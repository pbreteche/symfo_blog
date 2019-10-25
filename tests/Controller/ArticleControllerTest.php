<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{

    public function testSearch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/search');
        $this->assertResponseIsSuccessful();

        $title = $crawler->filter('h1')->text();
        $this->assertContains('Résultat', $title, 'Le titre de la page de recherche doit contenir "Résultat"');
    }
}
