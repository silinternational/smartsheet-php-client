<?php
namespace tests;

use Smartsheet\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testListUsers()
    {
        $config = include 'config-test.php';

        $client = new Client($config);
        
        $mockBody = Stream::factory(json_encode([
            [
                'email' => "test_11234545543@domain.org",
                "name" => "test user",
                "firstName" => "test",
                "lastName" => "user",
                "admin" => 'false',
                "licensedSheetCreator" => 'false',
                "groupAdmin" => 'false',
                "resourceManager" => 'false',
                "id" => 3381623543621508,
                "status" => "PENDING"
            ],
            [
                'email' => "test_11234545543@domain.org",
                "name" => "test user",
                "firstName" => "test",
                "lastName" => "user",
                "admin" => 'false',
                "licensedSheetCreator" => 'false',
                "groupAdmin" => 'false',
                "resourceManager" => 'false',
                "id" => 3381623543621508,
                "status" => "PENDING"
            ],
        ]));

        $mock = new Mock([
            new Response(200,[],$mockBody),
        ]);

        // Add the mock subscriber to the client.
        $client->getHttpClient()->getEmitter()->attach($mock);

        // Call list users and make sure we get back the user we expect from mock
        $users = $client->listUsers();

        $this->assertEquals(3, count($users));

        $this->assertEquals(3381623543621508,$users[0]['id']);
    }

    public function testListUserByEmail()
    {
        $config = include 'config-test.php';

        $client = new Client($config);

        $mockBody = Stream::factory(json_encode([
            [
                'email' => "test_11234545543@domain.org",
                "name" => "test user",
                "firstName" => "test",
                "lastName" => "user",
                "admin" => 'false',
                "licensedSheetCreator" => 'false',
                "groupAdmin" => 'false',
                "resourceManager" => 'false',
                "id" => 3381623543621508,
                "status" => "PENDING"
            ],
        ]));

        $mock = new Mock([
            new Response(200,[],$mockBody),
        ]);

        // Add the mock subscriber to the client.
        $client->getHttpClient()->getEmitter()->attach($mock);

        // Call list users and make sure we get back the user we expect from mock
        $users = $client->listUsers(['email' => 'test_user@domain.org']);

        $this->assertEquals(2, count($users));

        $this->assertEquals(3381623543621508,$users[0]['id']);
    }

    public function testGetUser()
    {
        $config = include 'config-test.php';

        $client = new Client($config);

        $mockBody = Stream::factory(json_encode([
                'email' => "test_11234545543@domain.org",
                "firstName" => "test",
                "lastName" => "user",
                "locale" => "en_US",
                "timeZone" => "US/Pacific",
                "id" => 3381623543621508,
        ]));

        $mock = new Mock([
            new Response(200,[],$mockBody),
        ]);

        // Add the mock subscriber to the client.
        $client->getHttpClient()->getEmitter()->attach($mock);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->getUser(['id' => 3381623543621508]);

        $this->assertEquals(3381623543621508,$user['id']);
    }

    public function testAddUser()
    {
        $config = include 'config-test.php';

        $client = new Client($config);

        $mockBody = Stream::factory(json_encode([
            "resultCode" => 0,
            "result" => [
                "email" => "test_112345455433@domain.org",
                "name" => "test user",
                "firstName" => "test",
                "lastName" => "user",
                "admin" => 'false',
                "licensedSheetCreator" => 'false',
                "groupAdmin" => 'false',
                "id" => 7225516194326404
            ],
            "message" => "SUCCESS",
        ]));

        $mock = new Mock([
            new Response(200,[],$mockBody),
        ]);

        // Add the mock subscriber to the client.
        $client->getHttpClient()->getEmitter()->attach($mock);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->addUser([
            "email" => "test_112345455433@domain.org",
            "name" => "test user",
            "firstName" => "test",
            "lastName" => "user",
            "admin" => false,
            "licensedSheetCreator" => false,
            "resourceManager" => false,
        ]);

        $this->assertEquals(7225516194326404,$user['result']['id']);
    }

    public function testUpdateUser()
    {
        $config = include 'config-test.php';

        $client = new Client($config);

        $mockBody = Stream::factory(json_encode([
            "resultCode" => 0,
            "result" => [
                "firstName" => "test",
                "lastName" => "user",
                "admin" => false,
                "licensedSheetCreator" => false,
                "groupAdmin" => 'false',
                "id" => 7225516194326404
            ],
            "message" => "SUCCESS",
        ]));

        $mock = new Mock([
            new Response(200,[],$mockBody),
        ]);

        // Add the mock subscriber to the client.
        $client->getHttpClient()->getEmitter()->attach($mock);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->updateUser([
            "id" => 7225516194326404,
            "name" => "test user",
            "firstName" => "test",
            "lastName" => "user",
            "admin" => false,
            "licensedSheetCreator" => false,
            "resourceManager" => false,
        ]);

        $this->assertEquals(7225516194326404,$user['result']['id']);
    }

    public function testDeleteUser()
    {
        $config = include 'config-test.php';

        $client = new Client($config);

        $mockBody = Stream::factory(json_encode([
            "resultCode" => 0,
            "message" => "SUCCESS",
        ]));

        $mock = new Mock([
            new Response(200,[],$mockBody),
        ]);

        // Add the mock subscriber to the client.
        $client->getHttpClient()->getEmitter()->attach($mock);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->deleteUser([
            "id" => 7225516194326404,
            "transferTo" => 7225516194326411,
            "removeFromSharing" => true,
        ]);

        $this->assertEquals('SUCCESS',$user['message']);

    }
}