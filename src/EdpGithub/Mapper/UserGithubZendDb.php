<?php

namespace EdpGithub\Mapper;

use ZfcBase\Mapper\DbMapperAbstract,
    ZfcUser\Module as ZfcUser;

/**
 * TODO: Make table and field names more dynamic
 */ 
class UserGithubZendDb extends DbMapperAbstract implements UserGithub
{
    public function linkUserToGithubId($userId, $githubId)
    {
        $data = array(
            'user_id'   => $userId,
            'github_id' => $githubId,
        );
        return $this->getTableGateway()->insert((array) $data);
    }

    public function findUserByGithubId($githubId)
    {
        $rowset = $this->getTableGateway()->select(array('github_id' => $githubId));
        $row = $rowset->current();
        $userModelClass = ZfcUser::getOption('user_model_class');
        return $userModelClass::fromArray($row);
    }
}
