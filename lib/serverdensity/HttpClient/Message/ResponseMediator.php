<?php

namespace serverdensity\HttpClient\Message;

use serverdensity\Exception\ApiLimitExceedException;

class ResponseMediator
{
    /**
    * @param response is of type GuzzleHttp\Message\Response;
    */
    public static function getContent($response)
    {
        $body    = $response->getBody();
        $content = json_decode($body, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return $body;
        }

        return $content;
    }

    public static function getApiLimit($response)
    {
        $remainingCalls = $response->getHeader('X-RateLimit-Remaining');

        if (null !== $remainingCalls && 1 > $remainingCalls) {
            throw new ApiLimitExceedException($remainingCalls);
        }
    }
}
