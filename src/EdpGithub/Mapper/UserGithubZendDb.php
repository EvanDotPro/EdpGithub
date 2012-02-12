<?php

namespace EdpGithub\Mapper;

use ZfcBase\Mapper\DbMapperAbstract,
    ZfcUser\Module as ZfcUser;

/**
 * TODO: Make table and field names more dynamic
 */ 
class UserGithubZendDb extends DbMapperAbstract implements UserGithub
{
    protected $tableName = 'user_github';

    public function linkUserToGithubId($userId, $githubId)
    {
        $data = array(
            'user_id'   => $userId,
            'github_id' => $githubId,
        );

        $db = $this->getWriteAdapter();
        return $db->insert($this->getTableName(), $data);
    }

    public function findUserByGithubId($githubId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
            ->where('github_id = ?', $githubId)
            ->join('user', 'user_github.user_id = user.user_id');
        $row = $db->fetchRow($sql);
        if (!$row) return null;
        $userModelClass = ZfcUser::getOption('user_model_class');
        $user = $userModelClass::fromArray($row);
        return $user;
    }
}
