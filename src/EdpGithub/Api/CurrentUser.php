<?php

namespace EdpGithub\Api;

use EdpGithub\Collections\RepositoryCollection;

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
    public function repos()
    {
        $repos = $this->get('user/repos');

        return new RepositoryCollection($repos, $this->getClient()->getHttpClient());
    }
}