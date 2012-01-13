<?php

namespace EdpGithub\Mapper;

use EdpCommon\Mapper\DbMapperAbstract,
    EdpUser\Model\UserInterface as UserModelInterface;

class UserGithubZendDb extends DbMapperAbstract
{
    protected $tableName = 'user_github';

    public function persist(UserModelInterface $user)
    {
        $data = new ArrayObject(array(
            'user_id'         => $user->getUserId(),
            'github_user_id'  => $user->getEmail(),
            'github_username' => $user->getDisplayName(),
        ));
        $db = $this->getWriteAdapter();
        if ($user->getUserId() > 0) {
            $db->update($this->getTableName(), (array) $data, $db->quoteInto('user_id = ?', $user->getUserId()));
        } else {
            $db->insert($this->getTableName(), (array) $data);
            $userId = $db->lastInsertId();
            $user->setUserId($userId);
        }
        return $user;
    }

    public function findByGitHubUserId($userId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
            ->where('email = ?', $email);
        $this->events()->trigger(__FUNCTION__ . '.pre', $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        $userModelClass = Module::getOption('user_model_class');
        $user = $userModelClass::fromArray($row);
        $this->events()->trigger(__FUNCTION__ . '.post', $this, array('user' => $user, 'row' => $row));
        return $user;
    }

    public function findByUsername($username)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
            ->where('username = ?', $username);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        $UserModelClass = Model::getOption('user_model_class');
        return $userModelClass::fromArray($row);
    }

}
