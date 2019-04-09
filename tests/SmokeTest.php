<?php
// tests/SmokeTest.php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     */
    public function testPageIsSuccessful($pageName, $url, $statuCode)
    {
        $client = self::createClient();
        $client->catchExceptions(false);
        $client->request('GET', $url);
        $response = $client->getResponse();
    
        self::assertEquals(
            $statuCode,
            $response->getStatusCode(),
            sprintf(
            'La page "%s" devrait être accessible, mais le code HTTP est "%s".',
            $pageName,
            $response->getStatusCode()
            )
        );
    }
    
    public function provideUrls()
    {
        return [
            'index' => ['ticket', '/ticket',200],
            'noticket' => ['noticket', '/noticket',200],
            'home' => ['home', '/',200],
            'firststage' => ['firststage', '/ticket/firststage',302],
            'secondstage' => ['secondstage', '/ticket/secondstage',302],
            'payment' => ['payment', '/ticket/payment',302],
            'validation' => ['validation', '/ticket/validation',200],
        ];
    }
}