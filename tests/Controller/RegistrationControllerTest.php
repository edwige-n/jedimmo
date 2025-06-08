<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase {
    public function testRegistration() {
        $client = static::createClient();
        $client->request('POST', '/api/registration', [], [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            json_encode(['email' => 'user.test-unit@email.fr',
                'password' => '1230']));
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testInvalidRegistration()
    {
        $client = static::createClient();
        $client->request('POST', '/api/registration', [], [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            json_encode(['email' => 'etienne70@guyot.net',
                    'password' => '1230']));
        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
    }
}