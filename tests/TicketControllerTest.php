<?php
// tests/TicketControllerTest.php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HTTPFoundation\Response;


class TicketControllerTest extends WebTestCase
    {

        public function testHomepageIsUp()
        {
            $client = static::createClient();
            $client->request('GET', '/');
            
            $this->assertSame(200, $client->getResponse()->getStatusCode());
        }

        public function testHomepage()
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/home');

            $this->assertSame(1, $crawler->filter('html:contains("Billetterie")')->count());
        }
        
        public function testLink()
        {
            $client = static::createClient();
             $client-> followRedirects();
             $crawler = $client->request('GET', '/ticket');
             $crawler->selectLink('CGV')->link();
             $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }

    }