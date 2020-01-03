## Laravel 6 and Lumen - Slack API

This package provides a simple way to use [Slack API](https://api.slack.com).

[![Latest Stable Version](https://poser.pugx.org/vivifyideas/slack-api/v/stable.svg)](https://packagist.org/packages/vivifyideas/slack-api) [![Total Downloads](https://poser.pugx.org/vivifyideas/slack-api/downloads.svg)](https://packagist.org/packages/vivifyideas/slack-api) [![Latest Unstable Version](https://poser.pugx.org/vivifyideas/slack-api/v/unstable.svg)](https://packagist.org/packages/vivifyideas/slack-api) [![License](https://poser.pugx.org/vivifyideas/slack-api/license.svg)](https://packagist.org/packages/vivifyideas/slack-api)

## Instalation

`composer require vivifyideas/slack-api`

## Instalation on Laravel 5
Add to `config/app.php`:

```php
<?php

[
    'providers' => [
        VivifyIdeas\SlackApi\SlackApiServiceProvider::class,
    ]
]

?>
```
> The ::class notation is optional.


and add the Facades to your aliases, if you need it

```php
<?php

[
    'aliases' => [
        'SlackApi'              => VivifyIdeas\SlackApi\Facades\SlackApi::class,
        'SlackChannel'          => VivifyIdeas\SlackApi\Facades\SlackChannel::class,
        'SlackChat'             => VivifyIdeas\SlackApi\Facades\SlackChat::class,
        'SlackGroup'            => VivifyIdeas\SlackApi\Facades\SlackGroup::class,
        'SlackFile'             => VivifyIdeas\SlackApi\Facades\SlackFile::class,
        'SlackSearch'           => VivifyIdeas\SlackApi\Facades\SlackSearch::class,
        'SlackInstantMessage'   => VivifyIdeas\SlackApi\Facades\SlackInstantMessage::class,
        'SlackUser'             => VivifyIdeas\SlackApi\Facades\SlackUser::class,
        'SlackStar'             => VivifyIdeas\SlackApi\Facades\SlackStar::class,
        'SlackUserAdmin'        => VivifyIdeas\SlackApi\Facades\SlackUserAdmin::class,
        'SlackRealTimeMessage'  => VivifyIdeas\SlackApi\Facades\SlackRealTimeMessage::class,
        'SlackTeam'             => VivifyIdeas\SlackApi\Facades\SlackTeam::class,
        'SlackOAuth'          => VivifyIdeas\SlackApi\Facades\SlackOAuth::class,
        'SlackOAuthV2'          => VivifyIdeas\SlackApi\Facades\SlackOAuthV2::class,
    ]
]

?>
```
> The ::class notation is optional.

## Instalation on Lumen

Add that line on `bootstrap/app.php`:

```php
<?php
// $app->register('App\Providers\AppServiceProvider'); (by default that comes commented)
$app->register('VivifyIdeas\SlackApi\SlackApiServiceProvider');

?>
```

If you want to use facades, add this lines on <code>bootstrap/app.php</code>

```php
<?php

class_alias('VivifyIdeas\SlackApi\Facades\SlackApi', 'SlackApi');
class_alias('VivifyIdeas\SlackApi\Facades\SlackChannel', 'SlackChannel');
class_alias('VivifyIdeas\SlackApi\Facades\SlackChat', 'SlackChat');
class_alias('VivifyIdeas\SlackApi\Facades\SlackGroup', 'SlackGroup');
class_alias('VivifyIdeas\SlackApi\Facades\SlackUser', 'SlackUser');
class_alias('VivifyIdeas\SlackApi\Facades\SlackTeam', 'SlackTeam');
//... and others

?>
```

Otherwise, just use the singleton shortcuts:

```php
<?php

/** @var \VivifyIdeas\SlackApi\Contracts\SlackApi $slackapi */
$slackapi     = app('slack.api');

/** @var \VivifyIdeas\SlackApi\Contracts\SlackChat $slackchat */
$slackchat    = app('slack.chat');

/** @var \VivifyIdeas\SlackApi\Contracts\SlackChannel $slackchannel */
$slackchannel = app('slack.channel');

//or

/** @var \VivifyIdeas\SlackApi\Contracts\SlackApi $slackapi */
$slackapi  = slack();

/** @var \VivifyIdeas\SlackApi\Contracts\SlackChat $slackchat */
$slackchat = slack('chat'); // or slack('slack.chat')

//...
//...

?>
```

## Configuration

configure your slack team token in <code>config/services.php</code>

```php
<?php

[
    //...,
    'slack' => [
        'token' => 'your token here'
    ]
]

?>
```

By default all api methods will return objects, to change it to associative array first publish slack-api config, and then set `response_to_assoc_array` to true

```bash
php artisan vendor:publish --provider="VivifyIdeas\SlackApi\SlackApiServiceProvider"
```

## Usage

```php
<?php

//Lists all users on your team
SlackUser::lists(); //all()

//Lists all channels on your team
SlackChannel::lists(); //all()

//List all groups
SlackGroup::lists(); //all()

//Invite a new member to your team
SlackUserAdmin::invite("example@example.com", [
    'first_name' => 'John',
    'last_name' => 'Doe'
]);

//Send a message to someone or channel or group
SlackChat::message('#general', 'Hello my friends!');

//Upload a file/snippet
SlackFile::upload([
    'filename' => 'sometext.txt',
    'title' => 'text',
    'content' => 'Nice contents',
    'channels' => 'C0440SZU6' //can be channel, users, or groups ID
]);

// Search for files or messages
SlackSearch::all('my message');

// Search for files
SlackSearch::files('my file');

// Search for messages
SlackSearch::messages('my message');

// or just use the helper

//Autoload the api
slack()->post('chat.postMessage', [...]);

//Autoload a Slack Method
slack('Chat')->message([...]);
slack('Team')->info();

?>
```

## Using Dependency Injection

```php
<?php

namespace App\Http\Controllers;

use VivifyIdeas\SlackApi\Contracts\SlackUser;

class YourController extends Controller{
    /** @var  SlackUser */
    protected $slackUser;

    public function __construct(SlackUser as $slackUser){
        $this->slackUser = $slackUser;
    }

    public function controllerMethod(){
        $usersList = $this->slackUser->lists();
    }
}

?>
```

## All Injectable Contracts:

### Generic API
`VivifyIdeas\SlackApi\Contracts\SlackApi`

Allows you to do generic requests to the api with the following http verbs:
`get`, `post`, `put`, `patch`, `delete` ... all allowed api methods you could see here: [Slack Web API Methods](https://api.slack.com/methods).

And is also possible load a SlackMethod contract:

```php
<?php

/** @var SlackChannel $channel **/
$channel = $slack->load('Channel');
$channel->lists();

/** @var SlackChat $chat **/
$chat = $slack->load('Chat');
$chat->message('D98979F78', 'Hello my friend!');

/** @var SlackUserAdmin $chat **/
$admin = $slack('UserAdmin'); //Minimal syntax (invokable)
$admin->invite('jhon.doe@example.com');

?>
```

### Channels API
`VivifyIdeas\SlackApi\Contracts\SlackChannel`

Allows you to operate channels:
`invite`, `archive`, `rename`, `join`, `kick`, `setPurpose` ...


### Chat API
`VivifyIdeas\SlackApi\Contracts\SlackChat`

Allows you to send, update and delete messages with methods:
`delete`, `message`, `update`.

### Files API
`VivifyIdeas\SlackApi\Contracts\SlackFile`

Allows you to send, get info, delete,  or just list files:
`info`, `lists`, `upload`, `delete`.

### Groups API
`VivifyIdeas\SlackApi\Contracts\SlackGroup`

Same methods of the SlackChannel, but that operates with groups and have adicional methods:
`open`, `close`, `createChild`

### Instant Messages API (Direct Messages)
`VivifyIdeas\SlackApi\Contracts\SlackInstantMessage`

Allows you to manage direct messages to your team members.

### Real Time Messages API
`VivifyIdeas\SlackApi\Contracts\SlackRealTimeMessage`

Allows you list all channels and user presence at the moment.


### Search API
`VivifyIdeas\SlackApi\Contracts\SlackSearch`

Find messages or files.

### Stars API
`VivifyIdeas\SlackApi\Contracts\SlackStar`

List all of starred itens.

### Team API
`VivifyIdeas\SlackApi\Contracts\SlackTeam`

Get information about your team.

### Users API
`VivifyIdeas\SlackApi\Contracts\SlackUser`

Get information about an user on your team or just check your presence ou status.

### Users Admin API
`VivifyIdeas\SlackApi\Contracts\SlackUserAdmin`

Invite new members to your team.

### OAuth API
`VivifyIdeas\SlackApi\Contracts\SlackOAuth`

Methods in oauth slack api namespace.

### OAuthV2 API
`VivifyIdeas\SlackApi\Contracts\SlackOAuthV2`

Methods in oauth v2 slack api namespace.


## License

[DBAD License](https://dbad-license.org).
