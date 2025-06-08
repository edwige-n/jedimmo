<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase; 

class UserControllerTest extends WebTestCase {


    /**
     * Test getUser - retrieve a User by its id 
     */
    public function getUser() {
        $client = static::createClient(); 
        $client->request('GET', '/user/1'); 
        $this->assertEquals(200, $client->getResponse()->getStatusCode()); 
        $this->assertJson($client->getResponse()->getContent()); 
    }

    /**
     * Test updateUser - update an user by its id 
     */
    public function updateUser() {
        $client = static::createClient(); 
        $client->request('PUT', '/user/1', [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'], 
        json_encode(['lastname' => 'Picard', 
                    'firstname' => 'Marie'])); 
        $this->assertEquals(201, $client->getResponse()->getStatusCode()); 
        $this->assertJson($client->getResponse()->getContent()); 
    }

    /**
     * Test delete user - delete a user by its id 
     */
    public function deleteUser() {
        $client = static::createClient(); 
        $client->request('DELETE', '/user/1'); 
        $this->assertEquals(202, $client->getResponse()->getStatusCode()); 
    }
}