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
    protected $githubClientSecret;

    /**
     * @var string
     */
    protected $githubCallbackUrl;

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
     * Get githubClientSecret.
     *
     * @return string
     */
    public function getGithubClientSecret()
    {
        return $this->githubClientSecret;
    }

    /**
     * Set githubClientSecret.
     *
     * @param string $githubClientSecret
     * @return Options
     */
    public function setGithubClientSecret($githubClientSecret)
    {
        $this->githubClientSecret = $githubClientSecret;
        return $this;
    }

    /**
     * Get githubCallbackUrl.
     *
     * @return string
     */
    public function getGithubCallbackUrl()
    {
        return $this->githubCallbackUrl;
    }

    /**
     * Set githubCallbackUrl.
     *
     * @param string $githubCallbackUrl
     * @return Options
     */
    public function setGithubCallbackUrl($githubCallbackUrl)
    {
        $this->githubCallbackUrl = $githubCallbackUrl;
        return $this;
    }
}
