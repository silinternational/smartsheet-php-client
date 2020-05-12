<?php
namespace tests;

use Smartsheet\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testListUsers()
    {
        $mockBody = json_encode([
            [
                'email' => "test_11234545543@domain.org",
                "name" => "test user",
                "firstName" => "test",
                "lastName" => "user",
                "admin" => 'false',
                "licensedSheetCreator" => 'false',
                "groupAdmin" => 'false',
                "resourceViewer" => 'false',
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
                "resourceViewer" => 'false',
                "id" => 3381623543621508,
                "status" => "PENDING"
            ],
        ]);

        $client = $this->getMockClient($mockBody);

        // Call list users and make sure we get back the user we expect from mock
        $users = $client->listUsers();

        $this->assertEquals(3, count($users));

        $this->assertEquals(3381623543621508,$users[0]['id']);
    }

    public function testListUserByEmail()
    {
        $mockBody = json_encode([
            [
                'email' => "test_11234545543@domain.org",
                "name" => "test user",
                "firstName" => "test",
                "lastName" => "user",
                "admin" => 'false',
                "licensedSheetCreator" => 'false',
                "groupAdmin" => 'false',
                "resourceViewer" => 'false',
                "id" => 3381623543621508,
                "status" => "PENDING"
            ],
        ]);

        $client = $this->getMockClient($mockBody);

        // Call list users and make sure we get back the user we expect from mock
        $users = $client->listUsers(['email' => 'test_user@domain.org']);

        $this->assertEquals(2, count($users));

        $this->assertEquals(3381623543621508,$users[0]['id']);
    }

    public function testGetUser()
    {
        $mockBody = json_encode([
                'email' => "test_11234545543@domain.org",
                "firstName" => "test",
                "lastName" => "user",
                "locale" => "en_US",
                "timeZone" => "US/Pacific",
                "id" => 3381623543621508,
        ]);

        $client = $this->getMockClient($mockBody);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->getUser(['id' => 3381623543621508]);

        $this->assertEquals(3381623543621508,$user['id']);
    }

    public function testAddUser()
    {
        $mockBody = json_encode([
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
        ]);

        $client = $this->getMockClient($mockBody);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->addUser([
            "email" => "test_112345455433@domain.org",
            "name" => "test user",
            "firstName" => "test",
            "lastName" => "user",
            "admin" => false,
            "licensedSheetCreator" => false,
            "resourceViewer" => false,
        ]);

        $this->assertEquals(7225516194326404,$user['result']['id']);
    }

    public function testUpdateUser()
    {
        $mockBody = json_encode([
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
        ]);

        $client = $this->getMockClient($mockBody);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->updateUser([
            "id" => 7225516194326404,
            "name" => "test user",
            "firstName" => "test",
            "lastName" => "user",
            "admin" => false,
            "licensedSheetCreator" => false,
            "resourceViewer" => false,
        ]);

        $this->assertEquals(7225516194326404,$user['result']['id']);
    }

    public function testDeleteUser()
    {
        $mockBody = json_encode([
            "resultCode" => 0,
            "message" => "SUCCESS",
        ]);

        $client = $this->getMockClient($mockBody);

        // Call get user and make sure we get back the user we expect from mock
        $user = $client->deleteUser([
            "id" => 7225516194326404,
            "transferTo" => 7225516194326411,
            "removeFromSharing" => 'true',
        ]);

        $this->assertEquals('SUCCESS',$user['message']);

    }

    private function getMockClient(string $mockBody, int $responseCode = 200) : Client
    {
        $config = include 'config-test.php';

        $mockHandler = new MockHandler([
            new Response($responseCode, [], $mockBody),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        return new Client(array_merge([
            'http_client_options' => [
                'handler' => $handlerStack,
            ]
        ], $config));
    }
}
