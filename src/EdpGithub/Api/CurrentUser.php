<?php

namespace EdpGithub\Api;

use EdpGithub\Collection\RepositoryCollection;

class CurrentUser extends AbstractApi
{
    /**
     * Get authenticatec User
     *
     * @link http://developer.github.com/v3/users/
     *
     * @return array
     */
    public function show()
    {
        return $this->get('user');
    }

    /**
     * Get Repos for authenticated user
     *
     * @link http://developer.github.com/v3/repos/
     * @param array $params
     * @return RepositoryCollection
     */
    public function repos(array $params = array())
    {
        $httpClient =$this->getClient()->getHttpClient();

        return new RepositoryCollection(
            $httpClient,
            'user/repos',
            $params
        );
    }

    /**
     * Get Organizations for authenticated user
     *
     * @link http://developer.github.com/v3/orgs/
     * @return array
     */
    public function orgs()
    {
        $orgs = $this->get('user/orgs');
        return json_decode($orgs);
    }
}
