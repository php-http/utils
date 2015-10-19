<?php

namespace Http\Client\Util;

use Http\Client\Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Responses and exceptions returned from parallel request execution
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class BatchResult implements \Http\Client\BatchResult
{
    /**
     * @var \SplObjectStorage
     */
    private $responses;

    /**
     * @var \SplObjectStorage
     */
    private $exceptions;

    public function __construct()
    {
        $this->responses = new \SplObjectStorage();
        $this->exceptions = new \SplObjectStorage();
    }

    /**
     * Returns all successful responses
     *
     * @return ResponseInterface[]
     */
    public function getResponses()
    {
        $responses = [];

        foreach ($this->responses as $request) {
            $responses[] = $this->responses[$request];
        }

        return $responses;
    }

    /**
     * Returns a response of a request
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws \UnexpectedValueException
     */
    public function getResponseFor(RequestInterface $request)
    {
        try {
            return $this->responses[$request];
        } catch (\UnexpectedValueException $e) {
            throw new \UnexpectedValueException('Request not found', $e->getCode(), $e);
        }
    }

    /**
     * Checks if there are any successful responses at all
     *
     * @return boolean
     */
    public function hasResponses()
    {
        return $this->responses->count() > 0;
    }

    /**
     * Checks if there is a response of a request
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function hasResponseFor(RequestInterface $request)
    {
        return $this->responses->contains($request);
    }

    /**
     * Adds a response in an immutable way
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     *
     * @return BatchResult
     *
     * @internal
     */
    public function addResponse(RequestInterface $request, ResponseInterface $response)
    {
        $new = clone $this;
        $new->responses->attach($request, $response);

        return $new;
    }

    /**
     * Checks if a request is successful
     *
     * @param RequestInterface $request
     *
     * @return boolean
     */
    public function isSuccessful(RequestInterface $request)
    {
        return $this->responses->contains($request);
    }

    /**
     * Checks if a request is failed
     *
     * @param RequestInterface $request
     *
     * @return boolean
     */
    public function isFailed(RequestInterface $request)
    {
        return $this->exceptions->contains($request);
    }

    /**
     * Returns all exceptions
     *
     * @return Exception[]
     */
    public function getExceptions()
    {
        $exceptions = [];

        foreach ($this->exceptions as $request) {
            $exceptions[] = $this->exceptions[$request];
        }

        return $exceptions;
    }

    /**
     * Returns an exception for a request
     *
     * @param RequestInterface $request
     *
     * @return Exception
     *
     * @throws UnexpectedValueException
     */
    public function getExceptionFor(RequestInterface $request)
    {
        try {
            return $this->exceptions[$request];
        } catch (\UnexpectedValueException $e) {
            throw new UnexpectedValueException('Request not found', $e->getCode(), $e);
        }
    }

    /**
     * Checks if there are any exceptions at all
     *
     * @return boolean
     */
    public function hasExceptions()
    {
        return $this->exceptions->count() > 0;
    }

    /**
     * Checks if there is an exception for a request
     *
     * @param RequestInterface $request
     *
     * @return boolean
     */
    public function hasExceptionFor(RequestInterface $request)
    {
        return $this->exceptions->contains($request);
    }

    /**
     * Adds an exception
     *
     * @param RequestInterface  $request
     * @param Exception         $exception
     */
    public function addException(RequestInterface $request, Exception $exception)
    {
        $this->exceptions->attach($request, $exception);
    }

    public function __clone()
    {
        $this->responses = clone $this->responses;
    }
}
