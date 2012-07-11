<?php

namespace EdpGithub;

use Zend\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{
    /**
     * @var bool
     */
    protected $enableZfcUserAuthAdapter = false;

    /**
     * @var string
     */
    protected $githubClientId;

    /**
     * @var string
     */
    protected $githubClientSercret;

    /**
     * @var string
     */
    protected $githubOauthCallbackUrl;

    /**
     * Get enableZfcUserAuthAdapter.
     *
     * @return bool
     */
    public function getEnableZfcUserAuthAdapter()
    {
        return $this->enableZfcUserAuthAdapter;
    }

    /**
     * Set enableZfcUserAuthAdapter.
     *
     * @param bool $enableZfcUserAuthAdapter
     * @return Opions
     */
    public function setEnableZfcUserAuthAdapter($enableZfcUserAuthAdapter)
    {
        $this->enableZfcUserAuthAdapter = $enableZfcUserAuthAdapter;
        return $this;
    }

    /**
     * Get githubClientId.
     *
     * @return string.
     */
    public function getGithubClientId()
    {
        return $this->githubClientId;
    }

    /**
     * Set githubClientId.
     *
     * @param string $githubClientId
     * @return Options
     */
    public function setGithubClientId($githubClientId)
    {
        $this->githubClientId = $githubClientId;
        return $this;
    }

    /**
     * Get githubClientSercret.
     *
     * @return string
     */
    public function getGithubClientSercret()
    {
        return $this->githubClientSercret;
    }

    /**
     * Set githubClientSercret.
     *
     * @param string $githubClientSercret
     * @return Options
     */
    public function setGithubClientSercret($githubClientSercret)
    {
        $this->githubClientSercret = $githubClientSercret;
        return $this;
    }

    /**
     * Get githubOauthCallbackUrl.
     *
     * @return string
     */
    public function getGithubOauthCallbackUrl()
    {
        return $this->githubOauthCallbackUrl;
    }

    /**
     * Set githubOauthCallbackUrl.
     *
     * @param string $githubOauthCallbackUrl
     * @return Options
     */
    public function setGithubOauthCallbackUrl($githubOauthCallbackUrl)
    {
        $this->githubOauthCallbackUrl = $githubOauthCallbackUrl;
        return $this;
    }
}
