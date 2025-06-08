<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContributionControllerTest extends WebTestCase
{
    /**
     * Test getProjects - returns all projects
     */
    public function testGetContributions() {
        $client = static::createClient();
        $client->request('GET', '/contribution');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
    /**
     * Test getProjectsByStatus - returns all projects sorted by status
     */
    public function testshowProjectContributions() {
        $client = static::createClient();
        $client->request('GET', '/contribution/project/13');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    } 
    
    public function testshowUserContributions() {
        $client = static::createClient();
        $client->request('GET', '/contribution/user/7');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    /**
     * Test createProject - create a project
     */
    public function testCreateContributon() {
        $client = static::createClient();
        $client->request('POST', '/contribution/create', [], [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            json_encode(['contributor_id' => 1,
                         'project_id' => 1, 
                          'amount' => '1600'
                ]));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());

    }
}