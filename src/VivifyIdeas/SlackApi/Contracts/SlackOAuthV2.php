<?php

namespace VivifyIdeas\SlackApi\Contracts;

interface SlackOAuthV2
{
    public function access($code, $options = []);
}
