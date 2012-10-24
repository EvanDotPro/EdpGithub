<?php

namespace EdpGithub\Api;

class Repos extends AbstractApi
{
    /**
     * GetRepos for authenticated user
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param string $username
     * @return array
     */
    public function show($username, $repository)
    {
        return $this->get('repos/'.urlencode($username).'/'.urlencode($repository));
    }
}