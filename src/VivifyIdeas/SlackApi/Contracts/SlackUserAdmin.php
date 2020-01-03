<?php

namespace VivifyIdeas\SlackApi\Contracts;

interface SlackUserAdmin
{
    public function invite($email, $options = []);
    public function setRegular($user);
    public function setAdmin($user);
    public function setInactive($user);
}
