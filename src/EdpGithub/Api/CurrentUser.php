<?php

namespace EdpGithub\Api;

use EdpGithub\Collection\RepositoryCollection;

class CurrentUser extends AbstractApi
{
    /**
     * Get authenticatec User
     *
     * @link http://developer.github.com/v3/users/
     * /user
     *
     * @return array
     */
    public function show()
    {
        return $this->get('user');
    }

    /**
     * GetRepos for authenticated user
     *
     * @link http://developer.github.com/v3/repos/
     * @return array
     */
    public function repos($type = 'all', $perPage = 10)
    {
        $httpClient =$this->getClient()->getHttpClient();
        $params[$type] = $type;
        $collection = new RepositoryCollection($httpClient, 'user/repos', $params, $perPage);

        return $collection;
    }
}