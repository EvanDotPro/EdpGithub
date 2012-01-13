<?php

namespace EdpGithub\Model;

use ZfcBase\Model\ModelAbstract;

class UserGithub extends ModelAbstract
{
    protected $userId;

    protected $githubUserId;

    protected $githubUsername;
 
    /**
     * Get userId.
     *
     * @return userId
     */
    public function getUserId()
    {
        return $this->userId;
    }
 
    /**
     * Set userId.
     *
     * @param $userId the value to be set
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
 
    /**
     * Get githubUserId.
     *
     * @return githubUserId
     */
    public function getGithubUserId()
    {
        return $this->githubUserId;
    }
 
    /**
     * Set githubUserId.
     *
     * @param $githubUserId the value to be set
     */
    public function setGithubUserId($githubUserId)
    {
        $this->githubUserId = $githubUserId;
        return $this;
    }
 
    /**
     * Get githubUsername.
     *
     * @return githubUsername
     */
    public function getGithubUsername()
    {
        return $this->githubUsername;
    }
 
    /**
     * Set githubUsername.
     *
     * @param $githubUsername the value to be set
     */
    public function setGithubUsername($githubUsername)
    {
        $this->githubUsername = $githubUsername;
        return $this;
    }
}
