<?php

namespace EdpGithub\Api;

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
        return $this->get('repos/' . $user . '/' . $repo);
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
        return $this->get('repos/' . $owner . '/' . $repo . '/contents/' . $path);
    }

    /**
     * Get Readme
     * @param  string $owner
     * @param  string $repo
     * @return string
     */
    public function readme($owner, $repo)
    {
        return $this->get('repos/' . $owner . '/' . $repo . '/readme');
    }

    /**
     * Get contributor
     * @param  string $owner
     * @param  string $repo
     * @return string
     */
    public function contributors($owner, $repo)
    {
        return $this->get('repos/' . $owner . '/' . $repo . '/stats/contributors');
    }

    /**
     * Get commit activity
     * @param  string $owner
     * @param  string $repo
     * @return string
     */
    public function commitActivity($owner, $repo)
    {
        return $this->get('repos/' . $owner . '/' . $repo . '/stats/commit_activity');
    }

    /**
     * Get code frequency
     * @param  string $owner
     * @param  string $repo
     * @return string
     */
    public function codeFrequency($owner, $repo)
    {
        return $this->get('repos/' . $owner . '/' . $repo . '/stats/code_frequency');
    }

    /**
     * @param  string $owner
     * @param  string $repo
     * @return string
     */
    public function participation($owner, $repo)
    {
        return $this->get('repos/' . $owner . '/' . $repo . '/stats/participation');
    }

    /**
     * @deprecated
     *
     * @param  string $owner
     * @param  string $repo
     * @return string
     */
    public function partecipation($owner, $repo)
    {
        return $this->participation($owner, $repo);
    }

    /**
     * Get punch card
     * @param  string $owner
     * @param  string $repo
     * @return string
     */
    public function punchCard($owner, $repo)
    {
        return $this->get('repos/' . $owner . '/' . $repo . '/stats/punch_Card');
    }
}
