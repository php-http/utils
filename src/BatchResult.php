<?php

namespace Http\Client\Utils;

use Http\Client\Exception;
use Http\Client\BatchResult as BatchResultInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Responses and exceptions returned from parallel request execution
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class BatchResult implements BatchResultInterface
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
     * {@inheritDoc}
     */
    public function hasResponses()
    {
        return $this->responses->count() > 0;
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function isSuccessful(RequestInterface $request)
    {
        return $this->responses->contains($request);
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function addResponse(RequestInterface $request, ResponseInterface $response)
    {
        $new = clone $this;
        $new->responses->attach($request, $response);

        return $new;
    }

    /**
     * {@inheritDoc}
     */
    public function hasExceptions()
    {
        return $this->exceptions->count() > 0;
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function isFailed(RequestInterface $request)
    {
        return $this->exceptions->contains($request);
    }

    /**
     * {@inheritDoc}
     */
    public function getExceptionFor(RequestInterface $request)
    {
        try {
            return $this->exceptions[$request];
        } catch (\UnexpectedValueException $e) {
            throw new \UnexpectedValueException('Request not found', $e->getCode(), $e);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function addException(RequestInterface $request, Exception $exception)
    {
        $new = clone $this;
        $new->exceptions->attach($request, $exception);

        return $new;
    }

    public function __clone()
    {
        $this->responses = clone $this->responses;
        $this->exceptions = clone $this->exceptions;
    }
}
