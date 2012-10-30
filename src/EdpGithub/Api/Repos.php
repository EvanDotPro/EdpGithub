<?php

namespace EdpGithub\Api;

use EdpGithub\Collection\RepositoryCollection;

class Repos extends AbstractApi
{
    /**
     * Get Repos for specified user
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username
     * @return array
     */
    public function show($username, $type = 'all', $perPage = 30)
    {
        $httpClient =$this->getClient()->getHttpClient();
        $params[$type] = $type;
        $collection = new RepositoryCollection($httpClient, 'users/'.urlencode($username).'/repos', $params);

        return $collection;
    }

    public function content($repo, $file)
    {
        return $this->get('repos/'.$repo.'/contents/'.$file);
    }
}
