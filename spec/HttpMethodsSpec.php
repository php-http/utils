<?php

namespace spec\Http\Client\Util;

use Http\Client\Util\HttpMethodsClient;
use PhpSpec\ObjectBehavior;

class HttpMethodsSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\Http\Client\Util\HttpMethodsClientStub');
    }

    function it_sends_a_get_request()
    {
        $data = HttpMethodsClientStub::$requestData;

        $this->get($data['uri'], $data['headers'], $data['options'])->shouldReturn(true);
    }

    function it_sends_a_head_request()
    {
        $data = HttpMethodsClientStub::$requestData;

        $this->head($data['uri'], $data['headers'], $data['options'])->shouldReturn(true);
    }

    function it_sends_a_trace_request()
    {
        $data = HttpMethodsClientStub::$requestData;

        $this->trace($data['uri'], $data['headers'], $data['options'])->shouldReturn(true);
    }

    function it_sends_a_post_request()
    {
        $data = HttpMethodsClientStub::$requestData;

        $this->post($data['uri'], $data['headers'], $data['body'], $data['options'])->shouldReturn(true);
    }

    function it_sends_a_put_request()
    {
        $data = HttpMethodsClientStub::$requestData;

        $this->put($data['uri'], $data['headers'], $data['body'], $data['options'])->shouldReturn(true);
    }

    function it_sends_a_patch_request()
    {
        $data = HttpMethodsClientStub::$requestData;

        $this->patch($data['uri'], $data['headers'], $data['body'], $data['options'])->shouldReturn(true);
    }

    function it_sends_a_delete_request()
    {
        $data = HttpMethodsClientStub::$requestData;

        $this->delete($data['uri'], $data['headers'], $data['body'], $data['options'])->shouldReturn(true);
    }

    function it_sends_a_options_request()
    {
        $data = HttpMethodsClientStub::$requestData;

        $this->options($data['uri'], $data['headers'], $data['body'], $data['options'])->shouldReturn(true);
    }
}

class HttpMethodsClientStub extends HttpMethodsClient
{
    public static $requestData = [
        'uri'     => '/uri',
        'headers' => [
            'Content-Type' => 'text/plain',
        ],
        'body'    => 'body',
        'options' => [
            'timeout' => 60,
        ],
    ];

    /**
     * {@inheritdoc}
     */
    protected function send($method, $uri, array $headers = [], $body = null, array $options = [])
    {
        if (in_array($method, ['GET', 'HEAD', 'TRACE'])) {
            return $uri === self::$requestData['uri'] &&
            $headers === self::$requestData['headers'] &&
            is_null($body) &&
            $options === self::$requestData['options'];
        }

        return in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']) &&
        $uri === self::$requestData['uri'] &&
        $headers === self::$requestData['headers'] &&
        $body === self::$requestData['body'] &&
        $options === self::$requestData['options'];
    }
}
