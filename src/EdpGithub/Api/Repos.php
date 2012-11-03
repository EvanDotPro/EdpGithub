<?php

namespace EdpGithub\Api;

use EdpGithub\Collection\RepositoryCollection;

class Repos extends AbstractApi
{
    /**
     * Get Repo
     *
     * @link http://developer.github.com/v3/repos/
     *
     * @param  string $user
     * @param  string $repo
     * @return array
     */
    public function show($user, $repo)
    {
        return $this->get('repos/'.$user.'/'.$repo);
    }

    /**
     * Get Repo Content
     *
     * @link http://developer.github.com/v3/repos/contents/
     *
     * @param  string $owner
     * @param  string $repo
     * @param  string $path
     * @return array
     */
    public function content($owner, $repo, $path)
    {
        return $this->get('repos/'.$owner.'/'.$repo.'/contents/'.$path);
    }
}
