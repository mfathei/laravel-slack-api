<?php

namespace VivifyIdeas\SlackApi\Contracts;

interface SlackConversation
{
    public function list($channel);
}
