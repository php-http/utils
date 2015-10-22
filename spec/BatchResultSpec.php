<?php

namespace spec\Http\Client\Utils;

use Http\Client\Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;

class BatchResultSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beAnInstanceOf('Http\Client\Utils\BatchResult');
        $this->shouldImplement('Http\Client\BatchResult');
    }

    function it_is_immutable(RequestInterface $request, ResponseInterface $response)
    {
        $new = $this->addResponse($request, $response);

        $this->getResponses()->shouldReturn([]);
        $new->shouldHaveType('Http\Client\Utils\BatchResult');
        $new->getResponses()->shouldReturn([$response]);
    }

    function it_has_a_responses(RequestInterface $request, ResponseInterface $response)
    {
        $new = $this->addResponse($request, $response);

        $this->hasResponses()->shouldReturn(false);
        $this->getResponses()->shouldReturn([]);
        $new->hasResponses()->shouldReturn(true);
        $new->getResponses()->shouldReturn([$response]);
    }

    function it_has_a_response_for_a_request(RequestInterface $request, ResponseInterface $response)
    {
        $new = $this->addResponse($request, $response);

        $this->shouldThrow('UnexpectedValueException')->duringGetResponseFor($request);
        $this->hasResponseFor($request)->shouldReturn(false);
        $new->getResponseFor($request)->shouldReturn($response);
        $new->hasResponseFor($request)->shouldReturn(true);
    }

    function it_keeps_exception_after_add_request(RequestInterface $request1, Exception $exception, RequestInterface $request2, ResponseInterface $response)
    {
        $new = $this->addException($request1, $exception);
        $new = $new->addResponse($request2, $response);

        $new->getResponseFor($request2)->shouldReturn($response);
        $new->getExceptionFor($request1)->shouldReturn($exception);
    }
}
