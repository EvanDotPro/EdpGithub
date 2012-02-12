<?php

namespace EdpGithub\Mapper;

interface UserGithub
{
    public function findUserByGithubId($githubId);
}
