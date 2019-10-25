<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{

    public function testSearch()
    {
        $client = static::createClient();

        $client->request('GET', '/search');

        $this->assertResponseIsSuccessful();
    }
}
