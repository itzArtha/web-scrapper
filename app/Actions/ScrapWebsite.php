<?php

namespace App\Actions;

use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ScrapWebsite
{
    use AsAction;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function handle(ActionRequest $request)
    {
        $url = $request->input('url');
        $browser = new HttpBrowser(HttpClient::create([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Connection' => 'keep-alive',
                'Upgrade-Insecure-Requests' => '1',
            ],
            'http_version' => '1.1', // Switch to HTTP/1.1
        ]));

        $browser->request('GET', $url);
        $response = $browser->getResponse();

        $content = $response->getContent();

        $crawler = new Crawler($content);

        $crawler->filter('.css-974ipl')->each(function (Crawler $node) {
            $title = $node->filter('.css-1bjwylw')->text();
            $price = $node->filter('.css-rhd610')->text();
            $link = $node->filter('a')->attr('href');

            Log::info("Title: $title");
            Log::info("Price: $price");
            Log::info("Link: $link");
            Log::info('-----------------------------');
        });
    }
}
