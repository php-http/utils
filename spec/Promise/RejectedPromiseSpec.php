<?php

namespace spec\Http\Client\Utils\Promise;

use Http\Client\Exception\NetworkException;
use Http\Client\Exception\TransferException;
use Http\Client\Exception;
use Http\Client\Promise;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;

class RejectedPromiseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beAnInstanceOf('Http\Client\Utils\Promise\RejectedPromise', [new TransferException()]);
        $this->shouldImplement('Http\Client\Promise');
    }

    function it_returns_fulfilled_promise(ResponseInterface $response)
    {
        $exception = new TransferException();
        $this->beConstructedWith($exception);

        $promise = $this->then(null, function (Exception $exceptionReceived) use($exception, $response) {
            if (Argument::is($exceptionReceived)->scoreArgument($exception)) {
                return $response->getWrappedObject();
            }
        });

        $promise->shouldReturnAnInstanceOf('Http\Client\Promise');
        $promise->shouldReturnAnInstanceOf('Http\Client\Utils\Promise\FulfilledPromise');
        $promise->getState()->shouldReturn(Promise::FULFILLED);
        $promise->getResponse()->shouldReturn($response);
    }

    function it_returns_rejected_promise()
    {
        $exception = new TransferException();
        $this->beConstructedWith($exception);

        $promise = $this->then(null, function (Exception $exceptionReceived) use($exception) {
            if (Argument::is($exceptionReceived)->scoreArgument($exception)) {
                throw $exception;
            }
        });

        $promise->shouldReturnAnInstanceOf('Http\Client\Promise');
        $promise->shouldReturnAnInstanceOf('Http\Client\Utils\Promise\RejectedPromise');
        $promise->getState()->shouldReturn(Promise::REJECTED);
        $promise->getException()->shouldReturn($exception);
    }

    function it_returns_rejected_state()
    {
        $exception = new TransferException();
        $this->beConstructedWith($exception);
        $this->getState()->shouldReturn(Promise::REJECTED);
    }

    function it_returns_exception()
    {
        $exception = new TransferException();
        $this->beConstructedWith($exception);
        $this->getException()->shouldReturn($exception);
    }

    function it_throws_exception_for_response()
    {
        $exception = new TransferException();
        $this->beConstructedWith($exception);
        $this->shouldThrow('\LogicException')->duringGetResponse();
    }
}
