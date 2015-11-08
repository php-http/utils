<?php

namespace Http\Client\Utils;

use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Client\Exception;
use Http\Client\Utils\Promise\FulfilledPromise;
use Http\Client\Utils\Promise\RejectedPromise;
use Psr\Http\Message\RequestInterface;

/**
 * Emulate an HttpAsyncClient on top of a HttpClient.
 *
 * This client sends request synchronously but then uses the Promise system
 * to allow a consistent codebase even with non-asynchronous capable clients.
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
class EmulateAsyncClient implements HttpAsyncClient
{
    /** @var HttpClient Underlying HTTP Client */
    private $httpClient;

    /**
     * @param HttpClient $httpClient Underlying HTTP Client
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function sendAsyncRequest(RequestInterface $request)
    {
        try {
            return new FulfilledPromise($this->httpClient->sendRequest($request));
        } catch (Exception $e) {
            return new RejectedPromise($e);
        }
    }
}
