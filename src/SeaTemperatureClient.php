<?php
declare(strict_types=1);

namespace Flynn314\SeaTemperature;

use Flynn314\SeaTemperature\Entity\TempInfo;
use Flynn314\WebClient\WebClient;
use Symfony\Component\DomCrawler\Crawler;

class SeaTemperatureClient
{
    private WebClient $webClient;

    public function __construct()
    {
        $this->webClient = new WebClient();
    }

    public function getCurrentTemperature(string $country, string $city, string|null $language = null): TempInfo
    {
        $domainName = 'seatemperature.net';
        if ('ru' === $language) {
            $domainName = 'seatemperature.ru';
            $city .= '-sea-temperature';
        } elseif ($language) {
            $domainName = $language . '.' . $domainName;
        } else {
            $city .= '-sea-temperature';
        }

        $link = sprintf('https://%s/current/%s/%s', $domainName, $country, $city);
        $html = $this->getHtml($link);
        $crawler = new Crawler($html);

        $temp = (float) $crawler->filter('#temp1')->text();
        $description = $crawler->filter('#apa')->count() ? trim($crawler->filter('#apa')->text()) : '';

        return new TempInfo($temp, $description);
    }

    private function getHtml(string $link): string
    {
        return $this->webClient->fileGetContentsAsChrome($link);
    }
}
