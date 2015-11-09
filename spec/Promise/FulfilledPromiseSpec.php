<?php

namespace spec\Http\Client\Utils\Promise;

use Http\Client\Exception\NetworkException;
use Http\Client\Promise;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class FulfilledPromiseSpec extends ObjectBehavior
{
    function it_is_initializable(ResponseInterface $response)
    {
        $this->beAnInstanceOf('Http\Client\Utils\Promise\FulfilledPromise', [$response]);
        $this->shouldImplement('Http\Client\Promise');
    }

    function it_returns_fulfilled_promise(ResponseInterface $response)
    {
        $this->beConstructedWith($response);

        $promise = $this->then(function (ResponseInterface $responseReceived) use($response) {
            if (Argument::is($responseReceived)->scoreArgument($response->getWrappedObject())) {
                return $response->getWrappedObject();
            }
        });

        $promise->shouldReturnAnInstanceOf('Http\Client\Promise');
        $promise->shouldReturnAnInstanceOf('Http\Client\Utils\Promise\FulfilledPromise');
        $promise->getState()->shouldReturn(Promise::FULFILLED);
        $promise->getResponse()->shouldReturn($response);
    }

    function it_returns_rejected_promise(RequestInterface $request, ResponseInterface $response)
    {
        $this->beConstructedWith($response);
        $exception = new NetworkException('', $request->getWrappedObject());

        $promise = $this->then(function (ResponseInterface $responseReceived) use($response, $exception) {
            if (Argument::is($responseReceived)->scoreArgument($response->getWrappedObject())) {
                throw $exception;
            }
        });

        $promise->shouldReturnAnInstanceOf('Http\Client\Promise');
        $promise->shouldReturnAnInstanceOf('Http\Client\Utils\Promise\RejectedPromise');
        $promise->getState()->shouldReturn(Promise::REJECTED);
        $promise->getException()->shouldReturn($exception);
    }

    function it_returns_fulfilled_state(ResponseInterface $response)
    {
        $this->beConstructedWith($response);
        $this->getState()->shouldReturn(Promise::FULFILLED);
    }

    function it_returns_response(ResponseInterface $response)
    {
        $this->beConstructedWith($response);
        $this->getResponse()->shouldReturn($response);
    }

    function it_throws_exception_for_reason(ResponseInterface $response)
    {
        $this->beConstructedWith($response);
        $this->shouldThrow('\LogicException')->duringGetException();
    }
}
