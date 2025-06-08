<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase {
    public function testApiLoginReturnsJwtToken() {
        $client = static::createClient();
        $client->request('POST', '/api/login_check', [], [],
        ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
        json_encode(['username' => 'anouk.lacombe@tele2.fr',
                     'password' => 'pwd'])
        );
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $data, 'Doit contenir le token' );
    }
    public function testInvalidLogin() {
        $client = static::createClient();
        $client->request('POST', '/api/login_check', [], [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            json_encode(['username' => 'test@test.fr',
                'password' => '123654'])
        );
        $response = $client->getResponse();
        $this->assertEquals(401, $response->getStatusCode());
    }
}