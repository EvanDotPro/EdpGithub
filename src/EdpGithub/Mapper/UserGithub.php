<?php

namespace EdpGithub\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use ZfcUser\Options\UserServiceOptionsInterface;
use ZfcUser\Mapper\UserHydrator;

class UserGithub extends AbstractDbMapper
{
    protected $tableName = 'edpgithub_user';

    protected $zfcUserOptions;

    public function __construct()
    {
        $this->setHydrator(new UserHydrator);
    }

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
        $select = $this->select()
                       ->from($this->tableName)
                       ->join('user', $this->tableName . '.user_id = user.user_id')
                       ->where(array('github_id' => $githubId));
        return $this->selectWith($select)->current();
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
