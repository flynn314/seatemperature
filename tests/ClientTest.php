<?php
declare(strict_types=1);

namespace Tests;

use Flynn314\SeaTemperature\SeaTemperatureClient;
use Flynn314\WebClient\WebClient;
use PHPUnit\Framework\TestCase;

/**
 * vendor/bin/phpunit
 */
class ClientTest extends TestCase
{
    public function testCase(): void
    {
        $client = new SeaTemperatureClient(new WebClient());

        $temp = $client->getCurrentTemperature('united-states', 'miami-beach');
        $this->assertTrue(is_float($temp->getTemp()));
        $this->assertNotEmpty($temp->getDescription());

        $temp = $client->getCurrentTemperature('latvia', 'jurmala', 'lv');
        $this->assertTrue(is_float($temp->getTemp()));
        $this->assertNotEmpty($temp->getDescription());

        $temp = $client->getCurrentTemperature('united-states', 'miami-beach', 'es');
        $this->assertTrue(is_float($temp->getTemp()));
        $this->assertNotEmpty($temp->getDescription());

        $temp = $client->getCurrentTemperature('united-states', 'miami-beach', 'ru');
        $this->assertTrue(is_float($temp->getTemp()));
        $this->assertNotEmpty($temp->getDescription());
    }
}
