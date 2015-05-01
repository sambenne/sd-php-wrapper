<?php

namespace serverdensity\Exception;

use GuzzleHttp\Exception\RequestException;

/**
 * RuntimeException.
 *
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
class RuntimeException extends RequestException implements ExceptionInterface
{
}
