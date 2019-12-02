<?php

namespace Vluzrmos\SlackApi\Methods;

use Vluzrmos\SlackApi\Contracts\SlackConversation as VluzrmosSlackConversation;

class Conversation extends SlackMethod implements VluzrmosSlackConversation
{
    protected $methodsGroup = 'conversations.';

    /**
     * 	Get list of all conversations in a workspace
     * @param array  $options
     *
     * @return array
     */
    public function list($options = [])
    {
        return $this->method('list', $options);
    }
}
