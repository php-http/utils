<?php

namespace Http\Client\Utils;

use Http\Client\Exception;
use Http\Client\Exception\BatchException;
use Psr\Http\Message\RequestInterface;

/**
 * Implements sending multiple request for client not supporting parallel requests.
 *
 * This implementation simply loops over the requests and uses sendRequest to send each of them.
 *
 * Use when implementing Http\Client\HttpClient.
 *
 * @author Joel Wurtz <jwurtz@jolicode.com>
 */
trait BatchRequest
{
    /**
     * {@inheritdoc}
     */
    abstract public function sendRequest(RequestInterface $request);

    /**
     * {@inheritdoc}
     */
    public function sendRequests(array $requests)
    {
        $batchResult = new BatchResult();

        foreach ($requests as $request) {
            try {
                $response = $this->sendRequest($request);
                $batchResult = $batchResult->addResponse($request, $response);
            } catch (Exception $e) {
                $batchResult = $batchResult->addException($request, $e);
            }
        }

        if ($batchResult->hasExceptions()) {
            throw new BatchException($batchResult);
        }

        return $batchResult;
    }
}
