<?php

namespace EdpGithub\ApiClient\Service;

use EdpGithub\ApiClient\ApiClient;

class AbstractService
{
    /**
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * Get apiClient.
     *
     * @return ApiClient
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }

    /**
     * Set apiClient.
     *
     * @param ApiClient $apiClient
     */
    public function setApiClient(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }
}
