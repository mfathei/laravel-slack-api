<?php

namespace VivifyIdeas\SlackApi\Contracts;

interface SlackOAuth
{
    public function access($code, $options = []);
}
