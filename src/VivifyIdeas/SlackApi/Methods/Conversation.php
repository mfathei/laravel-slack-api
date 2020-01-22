<?php

namespace VivifyIdeas\SlackApi\Methods;

use VivifyIdeas\SlackApi\Contracts\SlackTeam;

class Conversation extends SlackMethod implements SlackTeam
{
    protected $methodsGroup = 'conversations.';

    /**
     * Lists all channels in a Slack team.
     *
     * @return array
     */
    public function list($channelId) {
        return $this->method('list', ['channel' => $channelId]);
    }
}
