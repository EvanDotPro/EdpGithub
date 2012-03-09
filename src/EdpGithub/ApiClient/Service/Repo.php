<?php

namespace EdpGithub\ApiClient\Service;

use EdpGithub\ApiClient\Model\Repo as RepoModel;

class Repo extends AbstractService
{
    public function listRepositories($username = null)
    {
        $this->getApiClient();
        if ($username == null) {
            $repos = $this->getApiClient()->request('/user/repos');
        } else {
            $repos = $this->getApiClient()->request('/users/' . $username . '/repos');
        }
        return RepoModel::fromArraySet($repos);
    }
}
