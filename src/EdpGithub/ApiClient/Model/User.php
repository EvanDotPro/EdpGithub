<?php

namespace EdpGithub\ApiClient\Model;

use ZfcBase\Model\ModelAbstract;

class User extends ModelAbstract
{
    protected $login = null;

    protected $id = null;

    protected $avatarUrl = null;

    protected $gravatarId = null;

    protected $url = null;

    protected $name = null;

    protected $company = null;

    protected $blog = null;

    protected $location = null;

    protected $email = null;

    protected $hireable = null;

    protected $bio = null;

    protected $publicRepos = null;

    protected $publicGists = null;

    protected $followers = null;

    protected $following = null;

    protected $htmlUrl = null;

    protected $createdAt = null;

    protected $type = null;

    protected $totalPrivateRepos = null;

    protected $ownedPrivateRepos = null;

    protected $privateGists = null;

    protected $diskUsage = null;

    protected $collaborators = null;

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
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

    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl($avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;
        return $this;
    }

    public function getGravatarId()
    {
        return $this->gravatarId;
    }

    public function setGravatarId($gravatarId)
    {
        $this->gravatarId = $gravatarId;
        return $this;
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    public function getBlog()
    {
        return $this->blog;
    }

    public function setBlog($blog)
    {
        $this->blog = $blog;
        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getHireable()
    {
        return $this->hireable;
    }

    public function setHireable($hireable)
    {
        $this->hireable = $hireable;
        return $this;
    }

    public function getBio()
    {
        return $this->bio;
    }

    public function setBio($bio)
    {
        $this->bio = $bio;
        return $this;
    }

    public function getPublicRepos()
    {
        return $this->publicRepos;
    }

    public function setPublicRepos($publicRepos)
    {
        $this->publicRepos = $publicRepos;
        return $this;
    }

    public function getPublicGists()
    {
        return $this->publicGists;
    }

    public function setPublicGists($publicGists)
    {
        $this->publicGists = $publicGists;
        return $this;
    }

    public function getFollowers()
    {
        return $this->followers;
    }

    public function setFollowers($followers)
    {
        $this->followers = $followers;
        return $this;
    }

    public function getFollowing()
    {
        return $this->following;
    }

    public function setFollowing($following)
    {
        $this->following = $following;
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

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getTotalPrivateRepos()
    {
        return $this->totalPrivateRepos;
    }

    public function setTotalPrivateRepos($totalPrivateRepos)
    {
        $this->totalPrivateRepos = $totalPrivateRepos;
        return $this;
    }

    public function getOwnedPrivateRepos()
    {
        return $this->ownedPrivateRepos;
    }

    public function setOwnedPrivateRepos($ownedPrivateRepos)
    {
        $this->ownedPrivateRepos = $ownedPrivateRepos;
        return $this;
    }

    public function getPrivateGists()
    {
        return $this->privateGists;
    }

    public function setPrivateGists($privateGists)
    {
        $this->privateGists = $privateGists;
        return $this;
    }

    public function getDiskUsage()
    {
        return $this->diskUsage;
    }

    public function setDiskUsage($diskUsage)
    {
        $this->diskUsage = $diskUsage;
        return $this;
    }

    public function getCollaborators()
    {
        return $this->collaborators;
    }

    public function setCollaborators($collaborators)
    {
        $this->collaborators = $collaborators;
        return $this;
    }
}
