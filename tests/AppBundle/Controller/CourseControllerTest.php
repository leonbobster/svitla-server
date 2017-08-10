<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CourseControllerTest extends WebTestCase
{
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        passthru(sprintf(
            'php %s/console doctrine:fixtures:load --no-interaction --quiet --env=test ',
            CONSOLE_PATH
        ));
    }

    public function testGetOneCourse()
    {
        $client = static::createClient();
        $client->request('GET', '/course/1');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"'
        );
    }

    public function testGetAllCourses()
    {
        $client = static::createClient();
        $client->request('GET', '/course');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"'
        );
    }
}
