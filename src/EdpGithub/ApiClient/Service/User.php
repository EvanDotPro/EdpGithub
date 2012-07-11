<?php

namespace EdpGithub\ApiClient\Service;

use EdpGithub\ApiClient\Model\User as UserModel;

class User extends AbstractService
{
    public function get($username = null)
    {
        $this->getApiClient();
        if ($username == null) {
            $user = $this->getApiClient()->request('/user');
        } else {
            $user = $this->getApiClient()->request('/users/' . $username);
        }
        return $this->getHydrator()->hydrate($data, new UserModel);
    }

    public function getEmails()
    {
        return $this->getApiClient()->request('/user/emails');
    }
}
