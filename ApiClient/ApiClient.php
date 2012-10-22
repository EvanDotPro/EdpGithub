<?php

namespace EdpGithub\ApiClient;

use Zend\Json\Json;

class ApiClient
{
    const API_URI = 'https://api.github.com';

    /**
     * @var string
     */
    protected $oauthToken;

    /**
     * @var int
     */
    protected $rateLimitRemaining;

    /**
     * @var int
     */
    protected $rateLimit;

    /**
     * @var array
     */
    protected $services = array();

    protected $pagination = array(
        'first' => null,
        'next' => null,
        'prev' => null,
        'last' => null,
        'current' => null
    );

    protected $curlOpts = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_HEADER => false,
        CURLOPT_CRLF => true,
    );

    protected $headers;
    /**
     * Make a request to the GitHub API and decode the json response.
     *
     * @param string $uri
     * @param array $params
     * @return array
     */
    public function request($uri,  $params = null)
    {
        $this->headers = array();

        if(isset($params['page'])) {
            $this->pagination['current'] = $params['page'];
        } 

        $ch = curl_init();
        $opts = $this->curlOpts;
        $uri = static::API_URI . $uri;

        if(null !== $params) {
            $uri .= '?' . http_build_query($params);
        }
        $opts[CURLOPT_URL] = $uri;
        $opts[CURLOPT_HEADERFUNCTION] = array($this,'readHeader');

        curl_setopt_array($ch, $opts);

        $response = curl_exec($ch);

        curl_close($ch);

        $this->parseHeader();
        

        return Json::decode($response, Json::TYPE_ARRAY);
    }

    /**
     * getService
     *
     * @param string $serviceName
     * @return Service\ServiceAbstract
     */
    public function getService($serviceName)
    {
        $serviceName = ucfirst($serviceName);
        if (!isset($this->services[$serviceName])) {
            $serviceClass = "EdpGithub\ApiClient\Service\\{$serviceName}";
            $service      = new $serviceClass;
            $this->setService($serviceName, $service);
        }
        return $this->services[$serviceName];
    }

    /**
     * setService
     *
     * @param string $serviceName
     * @param Service\AbstractService $service
     * @return ApiClient
     */
    public function setService($serviceName, Service\AbstractService $service)
    {
        $service->setApiClient($this);
        $this->services[$serviceName] = $service;
        return $this;
    }

    /**
     * [readHeader description]
     * @param  [type] $ch          [description]
     * @param  [type] $header_line [description]
     * @return [type]              [description]
     */
    public function readHeader($ch, $header_line)
    {
        $this->headers[] = $header_line;
        return strlen($header_line);
    }

    /**
     * parse Header after curl request
     */
    public function parseHeader()
    {
        $headerString = null;
        $count = 0;
        foreach($this->headers as $line) {
            $count++;
            if($count == 1) {
                continue;
            }

            $headerString .= $line;
        }
        $headerString = str_replace('\n', '\r\n', $headerString);

        $this->headers = \Zend\Http\Headers::fromString($headerString);
        $this->setRateLimitRemaining($this->headers->get('X-RateLimit-Remaining')->getFieldValue());
        $this->setRateLimit($this->headers->get('X-RateLimit-Limit')->getFieldValue());
        if($this->headers->has('link')) {
            $this->parsePagination($this->headers->get('link')->getFieldValue());
        }
    }

    public function parsePagination($link) 
    {
        $link = str_replace(array('<', '>'), '', $link);
        $links = explode(',', $link);
        foreach($links as $link) {
            $url = explode(';', $link);
            $url = parse_url($url[0]);

            parse_str($url['query'], $query);
            if (preg_match('/"([^"]+)"/', $link, $m)) {
                $rel =  $m[1];   
            }

            switch($rel) {
                case 'next':
                    $this->pagination['next'] = $query['page'];
                break;
                case 'prev':
                    $this->pagination['prev'] = $query['page'];
                break;
                case 'first':
                    $this->pagination['first'] = $query['page'];
                break;
                case 'last':
                    $this->pagination['last'] = $query['page'];
                break;
            }
        }
    }

    /**
     * Get Current Page
     * 
     * @return int
     */
    public function getCurrent() 
    {
        return $this->pagination['current'];
    }

    /**
     * Get First Page
     * 
     * @return int
     */
    public function getFirst() 
    {
        return $this->pagination['first'];
    }

    /**
     * Get Last Page
     * 
     * @return int
     */
    public function getLast()
    {
        return $this->pagination['last'];
    }

    /**
     * Get Next Page
     * 
     * @return int
     */
    public function getNext()
    {
        return $this->pagination['next'];
    }

    /**
     * Get Previous Page
     * 
     * @return int
     */
    public function getPrevious()
    {
        return $this->pagination['previous'];
    }

    /**
     * Get oauthToken.
     *
     * @return string
     */
    public function getOauthToken()
    {
        return $this->oauthToken;
    }

    /**
     * Set oauthToken.
     *
     * @param string $oauthToken
     * @return EdpGithub\Service\Api
     */
    public function setOauthToken($oauthToken)
    {
        $this->oauthToken = $oauthToken;
        return $this;
    }

    /**
     * Get rateLimitRemaining.
     *
     * @return int
     */
    public function getRateLimitRemaining()
    {
        return $this->rateLimitRemaining;
    }

    /**
     * Set rateLimitRemaining.
     *
     * @param int $rateLimitRemaining
     * @return ApiClient
     */
    public function setRateLimitRemaining($rateLimitRemaining)
    {
        $this->rateLimitRemaining = (int) $rateLimitRemaining;
        return $this;
    }

    /**
     * Get rateLimit.
     *
     * @return int
     */
    public function getRateLimit()
    {
        return $this->rateLimit;
    }

    /**
     * Set rateLimit.
     *
     * @param int $rateLimit
     * @return ApiClient
     */
    public function setRateLimit($rateLimit)
    {
        $this->rateLimit = (int) $rateLimit;
        return $this;
    }
}
