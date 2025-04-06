<?php
declare(strict_types=1);

namespace Flynn314\SeaTemperature;

use Flynn314\SeaTemperature\Entity\TempInfo;
use Flynn314\WebClient\WebClient;
use Symfony\Component\DomCrawler\Crawler;

final class SeaTemperatureClient
{
    public function __construct(private WebClient $wc) {}

    public function getCurrentTemperature(string $country, string $city, string|null $language = null): TempInfo
    {
        $domainName = 'seatemperature.net';
        $version = 1;
        if ('ru' === $language) {
            $domainName = 'seatemperature.ru';
            $city .= '-sea-temperature';
        } elseif ($language) {
            $domainName = $language . '.' . $domainName;
        } else {
            $city .= '-sea-temperature';
            $version = 2;
        }

        $link = sprintf('https://%s/current/%s/%s', $domainName, $country, $city);
        $html = $this->getHtml($link);
        $crawler = new Crawler($html);

        if (1 === $version) {
            $temp = (float) $crawler->filter('#temp1 h3')->text();
            $description = mb_trim((string) $crawler->filter('#apa p')->first()?->text());
        } else {
            $temp = (float) $crawler->filter('#tempwindows div')->first()->text('h4');
            $description = mb_trim((string) $crawler->filter('#curinfo p')->eq(2)?->text());
        }

        return new TempInfo($temp, $description);
    }

    private function getHtml(string $link): string
    {
        return $this->wc->fileGetContentsAsChrome($link);
    }
}
