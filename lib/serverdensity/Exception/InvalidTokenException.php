<?php

namespace serverdensity\Exception;

use GuzzleHttp\Exception\RequestException;

/**
 * RuntimeException.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class InvalidTokenException extends RequestException implements ExceptionInterface
{
}
