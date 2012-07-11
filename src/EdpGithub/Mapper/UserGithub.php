<?php

namespace EdpGithub\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use ZfcUser\Options\UserServiceOptionsInterface;

class UserGithub extends AbstractDbMapper
{
    protected $tableName = 'edpgithub_user';

    protected $zfcUserOptions;

    public function linkUserToGithubId($userId, $githubId)
    {
        $data = array(
            'user_id'   => $userId,
            'github_id' => $githubId,
        );
        return $this->insert($data);
    }

    public function findUserByGithubId($githubId)
    {
        return $this->select(array('github_id' => $githubId))->current();
    }

    public function getZfcUserOptions()
    {
        return $this->zfcUserOptions;
    }

    public function setZfcUserOptions(UserServiceOptionsInterface $zfcUserOptions)
    {
        $this->zfcUserOptions = $zfcUserOptions;
        $entityClass = $this->getZfcUserOptions()->getUserEntityClass();
        $this->setEntityPrototype(new $entityClass);
        return $this;
    }
}
