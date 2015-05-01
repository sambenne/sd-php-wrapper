<?php

namespace serverdensity\Exception;

use GuzzleHttp\Exception\RequestException;

/**
 * NotFoundException.
 */
class NotFoundException extends RequestException implements ExceptionInterface
{
}
