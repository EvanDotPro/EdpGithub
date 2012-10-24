<?php

namespace EdpGithub\HttpClient\Message;

use Buzz\Message\Response as BaseResponse;

use EdpGithub\HttpClient\Exception\ApiLimitExceedException;

class Response extends BaseResponse
{
    /**
     * @var integer
     */
    protected $rateLimit;

    /**
     * @var integer
     */
    public $rateLimitRemaining;

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        $response = parent::getContent();
        $content  = json_decode($response, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return $response;
        }

        return $content;
    }

    /**
     * @return array|null
     */
    public function getPagination()
    {
        $header = $this->getHeader('Link');
        if (empty($header)) {
            return null;
        }

        $pagination = array();
        foreach (explode(',', $header) as $link) {
            preg_match('/<(.*)>; rel="(.*)"/i', trim($link, ','), $match);

            if (3 === count($match)) {
                $pagination[$match[2]] = $match[1];
            }
        }

        return $pagination;
    }

    /**
     * {@inheritDoc}
     */
    public function getApiLimit()
    {
        $header = $this->getHeader('X-RateLimit-Remaining');
        if (!empty($header)) {
            $this->rateLimitRemaining = $header;
        }

        $header = $this->getHeader('X-RateLimit-Limit');
        if (!empty($header)) {
            $this->rateLimit = $header;
        }

        if (null !== $this->rateLimitRemaining && 1 > $this->rateLimitRemaining) {
            throw new ApiLimitExceedException($this->rateLimit);
        }
    }
}
