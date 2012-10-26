<?php

namespace EdpGithub\Api\Model;

use Zend\Stdlib\AbstractOptions;

class Repo extends AbstractOptions
{
    protected $url = null;

    protected $htmlUrl = null;

    protected $cloneUrl = null;

    protected $gitUrl = null;

    protected $sshUrl = null;

    protected $svnUrl = null;

    protected $owner = null;

    protected $name = null;

    protected $description = null;

    protected $homepage = null;

    protected $language = null;

    protected $private = null;

    protected $fork = null;

    protected $forks = null;

    protected $watchers = null;

    protected $size = null;

    protected $masterBranch = null;

    protected $openIssues = null;

    protected $pushedAt = null;

    protected $createdAt = null;

    protected $watchersCount = null;

    protected $hasIssues = null;

    protected $forksCount = null;

    protected $openIssuesCount = null;

    protected $permissions = null;

    protected $hasDownloads = null;

    protected $mirrorUrl = null;

    protected $updatedAt = null;

    protected $hasWiki = null;

    protected $fullName = null;

    protected $_links = null;

    protected $id = null;

    protected $defaultBranch = null;

    public function getDefaultBranch()
    {
        return $this->defaultBranch;
    }

    public function setDefaultBranch($defaultBranch)
    {
        $this->defaultBranch = $defaultBranch;
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getLinks()
    {
        return $this->_links;
    }

    public function setLinks($_links)
    {
        $this->_links = $_links;
        return $this;
    }
    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function setHasWiki($hasWiki)
    {
        $this->hasWiki = $hasWiki;
    }

    public function getHasWiki()
    {
        return $this->hasWiki;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setMirrorUrl($mirrorUrl)
    {
        $this->mirrorUrl = $mirrorUrl;
    }

    public function getMirrorUrl()
    {
        return $this->mirrorUrl;
    }

    public function setHasDownloads($hasDownloads)
    {
        $this->hasDownloads = $hasDownloads;
    }

    public function getHasDownloads()
    {
        return $this->hasDownloads;
    }

    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function setOpenIssuesCount($openIssuesCount)
    {
        $this->openIssuesCount = $openIssuesCount;
    }

    public function getOpenIssuesCount()
    {
        return $this->openIssuesCount;
    }

    public function setForksCount($forksCount)
    {
        $this->forksCount = $forksCount;
    }

    public function getForksCount()
    {
        return $this->forksCount;
    }

    public function setHasIssues($hasIssues)
    {
        $this->hasIssues = $hasIssues;
    }

    public function getHasIssues()
    {
        return $this->hasIssues;
    }

    public function setWatchersCount($watchersCount)
    {
        $this->watchersCount = $watchersCount;
    }

    public function getWatchersCount()
    {
        return $this->watchersCount;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function getHtmlUrl()
    {
        return $this->htmlUrl;
    }

    public function setHtmlUrl($htmlUrl)
    {
        $this->htmlUrl = $htmlUrl;
        return $this;
    }

    public function getCloneUrl()
    {
        return $this->cloneUrl;
    }

    public function setCloneUrl($cloneUrl)
    {
        $this->cloneUrl = $cloneUrl;
        return $this;
    }

    public function getGitUrl()
    {
        return $this->gitUrl;
    }

    public function setGitUrl($gitUrl)
    {
        $this->gitUrl = $gitUrl;
        return $this;
    }

    public function getSshUrl()
    {
        return $this->sshUrl;
    }

    public function setSshUrl($sshUrl)
    {
        $this->sshUrl = $sshUrl;
        return $this;
    }

    public function getSvnUrl()
    {
        return $this->svnUrl;
    }

    public function setSvnUrl($svnUrl)
    {
        $this->svnUrl = $svnUrl;
        return $this;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getHomepage()
    {
        return $this->homepage;
    }

    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;
        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    public function getPrivate()
    {
        return $this->private;
    }

    public function setPrivate($private)
    {
        $this->private = $private;
        return $this;
    }

    public function getFork()
    {
        return $this->fork;
    }

    public function setFork($fork)
    {
        $this->fork = $fork;
        return $this;
    }

    public function getForks()
    {
        return $this->forks;
    }

    public function setForks($forks)
    {
        $this->forks = $forks;
        return $this;
    }

    public function getWatchers()
    {
        return $this->watchers;
    }

    public function setWatchers($watchers)
    {
        $this->watchers = $watchers;
        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    public function getMasterBranch()
    {
        return $this->masterBranch;
    }

    public function setMasterBranch($masterBranch)
    {
        $this->masterBranch = $masterBranch;
        return $this;
    }

    public function getOpenIssues()
    {
        return $this->openIssues;
    }

    public function setOpenIssues($openIssues)
    {
        $this->openIssues = $openIssues;
        return $this;
    }

    public function getPushedAt()
    {
        return $this->pushedAt;
    }

    public function setPushedAt($pushedAt)
    {
        $this->pushedAt = $pushedAt;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }


    protected $test  = null;

    public function getTest ()
    {
        return $this->test ;
    }

    public function setTest ($test )
    {
        $this->test  = $test ;
        return $this;
    }
    protected $test2 = null;

    public function getTest2()
    {
        return $this->test2;
    }

    public function setTest2($test2)
    {
        $this->test2 = $test2;
        return $this;
    }
}
