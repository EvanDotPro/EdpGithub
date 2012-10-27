<?php

namespace EdpGithub\Api;

class User extends AbstractApi
{
    /**
     * Get A single user
     * @link http://developer.github.com/v3/users/
     * /users/:user
     *
     * @param  string $username
     * @return array
     */
    public function show($username)
    {
        return $this->get('users/'.urlencode($username));
    }
}