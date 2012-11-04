<?php

namespace EdpGithub\Api;

use EdpGithub\Collection\RepositoryCollection;

class User extends AbstractApi
{
    /**
     * Get A single user
     *
     * @link http://developer.github.com/v3/users/
     *
     * @param  string $username
     * @return array
     */
    public function show($username)
    {
        return $this->get('users/'.urlencode($username));
    }

    /**
     * Get Repositories
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username
     * @param array $params
     * @return RepositoryCollection
     */
    public function repos($username, array $params = array())
    {
        $httpClient =$this->getClient()->getHttpClient();
        $collection = new RepositoryCollection($httpClient, 'users/'.urlencode($username).'/repos', $params);

        return $collection;
    }

    /**
     * Get User Organizations
     *
     * @param  string $user
     * @return array
     */
    public function orgs($user)
    {
        $orgs = $this->get('users/'.$user.'/orgs');
        return $orgs;
    }

}
