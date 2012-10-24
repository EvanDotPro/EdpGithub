<?php

namespace EdpGithub\HttpClient\Exception;

class ApiLimitExceedException extends RuntimeException implements ExceptionInterface
{
    public function __construct($limit, $code = 0, $previous = null)
    {
        parent::__construct('You have reached GitHub hour limit! Actual limit is: '. $limit, $code, $previous);
    }
}
