<?php

namespace EdpGithub\ApiClient\Service;

use EdpGithub\ApiClient\Model\Repo as RepoModel;

class Repo extends AbstractService
{
    // list of github allowed types for fetching repositories
    protected $allowedTypes = array(
        'all',
        'owner',
        'public',
        'private',
        'member',
    );

    public function listRepositories($username = null, $type = null)
    {
        $api = $this->getApiClient();

        $params['access_token'] = $api->getOAuthToken();

        if($type !== null) {
            if(!in_array($type, $this->allowedTypes)) {
                throw new Exception\DomainException("Wrong type '$type' provided.");
            }
            $params['type'] = $type;
        }

        if ($username == null) {
            $repos = $api->request('/user/repos', $params);
        } else {
            $repos = $this->getApiClient()->request('/users/' . $username . '/repos');
        }

        return $this->hydrate($repos);
    }

    public function hydrate($repos)
    {
        $repoList = null;
        foreach($repos as $repo)
        {
            $repolist[] = new RepoModel($repo);
        }
       
        return $repolist;
    }
}
