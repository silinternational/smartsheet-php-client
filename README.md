# smartsheet-php-client
PHP client to interact with the Smartsheet API.

We're slowly building out this client as we need the functionality. Initially we only need it for managing user accounts.

This client is built on top of [Guzzle](http://docs.guzzlephp.org/en/latest/index.html), the PHP HTTP Client.
Guzzle has a simple way to create API clients by describing the API in a Swagger-like format without the need to implement 
every method yourself. So adding support for more Smartsheet APIs is relatively simple. If you want to submit a pull request
to add another feature, please do. If you don't know how to do that, ask us and we might be able to add it in for you.

# Smartsheet API Authentication #
Smartsheet supports User Generated Tokens or OAuth 2.0 for authorization. This client however only supports
the User Generated Tokens method. Please see http://www.smartsheet.com/developers/api-documentation#h.y2e83x6xwscl for more information.

# Install #
Installation is simple with [Composer](https://getcomposer.org/). Add ```"silinternational/smartsheet-php-client": "dev-master"``` to your ```composer.json``` file and update.

# Usage #
Example:
```php

<?php

use Smartsheet\Client;

$client = new Client([
  'access_token' => '1234567890',
]);

$user = $client->getUser(['id' => 123456789]);

echo $user['email'];
// example@domain.org

$newUser = $client->addUser([
  "email" => "test_user@domain.org",
  "name" => "test user",
  "firstName" => "test",
  "lastName" => "user",
  "admin" => false,
  "licensedSheetCreator" => false,
  "resourceManager" => false,
]);

echo $user['result']['id'];
// 1234567890

```

## Guzzle Service Client Notes ##
- Presentation by Jeremy Lindblom: https://speakerdeck.com/jeremeamia/building-web-service-clients-with-guzzle-1
- Example by Jeremy Lindblom: https://github.com/jeremeamia/sunshinephp-guzzle-examples
- Parameter docs in source comments: https://github.com/guzzle/guzzle-services/blob/master/src/Parameter.php
