<?php

namespace spec\Http\Client\Utils;

use Http\Client\Exception\NetworkException;
use Http\Client\HttpClient;
use Http\Client\Promise;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class EmulateAsyncClientSpec extends ObjectBehavior
{
    function it_is_initializable(HttpClient $httpClient)
    {
        $this->beAnInstanceOf('Http\Client\Utils\EmulateAsyncClient', [$httpClient]);
        $this->shouldImplement('Http\Client\HttpAsyncClient');
    }

    function it_sends_async_request(HttpClient $httpClient, RequestInterface $request, ResponseInterface $response)
    {
        $this->beConstructedWith($httpClient);
        $httpClient->sendRequest($request)->shouldBeCalled()->willReturn($response);

        $promise = $this->sendAsyncRequest($request);
        $promise->shouldReturnAnInstanceOf('Http\Client\Promise');
        $promise->shouldReturnAnInstanceOf('Http\Client\Utils\Promise\FulfilledPromise');
        $promise->getState()->shouldReturn(Promise::FULFILLED);
        $promise->getResponse()->shouldReturn($response);
    }

    function it_returns_rejected_promise(HttpClient $httpClient, RequestInterface $request)
    {
        $this->beConstructedWith($httpClient);
        $exception = new NetworkException('', $request->getWrappedObject());
        $httpClient->sendRequest($request)->shouldBeCalled()->willThrow($exception);

        $promise = $this->sendAsyncRequest($request);
        $promise->shouldReturnAnInstanceOf('Http\Client\Promise');
        $promise->shouldReturnAnInstanceOf('Http\Client\Utils\Promise\RejectedPromise');
        $promise->getState()->shouldReturn(Promise::REJECTED);
        $promise->getException()->shouldReturn($exception);
    }
}
