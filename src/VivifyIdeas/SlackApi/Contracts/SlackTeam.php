<?php

namespace VivifyIdeas\SlackApi\Contracts;

interface SlackTeam
{
    public function info();
    public function accessLogs($options = []);
}
