<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    /**
     * Test getProjects - returns all projects
     */
    public function testGetProjects() {
        $client = static::createClient();
        $client->request('GET', '/project');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
    /**
     * Test getProjectsByStatus - returns all projects sorted by status
     */
    public function testGetProjectsByStatus() {
        $client = static::createClient();
        $client->request('GET', '/project/statut/en cours');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }
    /**
     * Test getProjectById - get a project by its id
     */
    public function testGetProjectId() {
        $client = static::createClient();
        $client->request('GET', '/project/13');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }
    /**
     * Test createProject - create a project
     */
    public function testCreateProject() {
        $client = static::createClient();
        $client->request('POST', '/project/create', [], [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            json_encode(['projectname' => 'test',
                         'descripton' => 'test description'
                ]));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());

    }
    /**
     * Test updateProject - update a project by its id
     */
    public function testUpdateProject() {
        $client = static::createClient();
        $client->request('PUT', '/project/update/13', [], [],
        ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
        json_encode(['projectname' => 'Barbier SAS test',
                     'descripton' => 'test description'
        ]));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
    /**
     * Test deleteProject - delete a project by its id
     */
    public function testDeleteProject() {
        $client = static::createClient();
        $client->request('DELETE', '/project/delete/16');
        $this->assertEquals(202, $client->getResponse()->getStatusCode());
    }
}