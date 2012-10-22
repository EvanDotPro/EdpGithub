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

    public function listRepositories($username = null, $type = null, $params = array())
    {
        $api = $this->getApiClient();

        $params['access_token'] = $api->getOAuthToken();

        if(!isset($params['per_page'])) {
            $params['per_page'] = 100;
        }
        
        if($type !== null) {
            if(!in_array($type, $this->allowedTypes)) {
                throw new Exception\DomainException("Wrong type '$type' provided.");
            }
            $params['type'] = $type;
        }

        if ($username == null) {
            $request_url = '/user/repos';
            
        } else {
            $request_url = '/users/' . $username . '/repos';
        }

        $repos = $this->getApiClient()->request($request_url, $params);

        return $this->hydrate($repos);
    }

    public function hydrate($repos)
    {
        $repolist = array();
        foreach($repos as $repo)
        {
            $repolist[] = new RepoModel($repo);
        }

        return $repolist;
    }
}
