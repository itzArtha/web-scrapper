<?php

namespace App\Actions;

use App\Exports\ProductsExport;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Maatwebsite\Excel\Facades\Excel;
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
        $browser = new HttpBrowser(HttpClient::create());

        $crawler = $browser->request('GET', $url);

        $productGridContainer = $crawler->filter('.product-grid-container');
        $collection = $productGridContainer->filter('.collection');
        $productGrid = $collection->filter('.product-grid');

        $productGrid->filter('.grid__item')->each(function (Crawler $node) use ($browser) {
            $productContentWrapper = $node->filter('.product-card-wrapper');
            $productCard = $productContentWrapper->filter('.card--standard');

            $productCardInnerMedia = $productContentWrapper->filter('.card__inner');
            $productCardMedia = $productCardInnerMedia->filter('.card__media');
            $productMedia = $productCardMedia->filter('.media');

            $productContent = $productCard->filter('.card__content');
            $productContent = $productContent->filter('.card__information');
            $productName = $productContent->filter('h3')->text();
            $productPrice = $productContent->filter('.price');
            $productPriceContainer = $productPrice->filter('.price__container');
            $productPriceRegular = $productPriceContainer->filter('.price__regular');
            $productPrice = $productPriceRegular->filter('.price-item')->text();

            $productImageUrl = $productMedia->filter('img')->attr('src');

            $uuid = Str::uuid();

            Product::create([
                'uuid' => $uuid,
                'name' => $productName,
                'price' => $productPrice,
                'image_url' => 'https:' . $productImageUrl
            ]);
        });

        return back()->with(['status' => 'Berhasil scraping data']);
    }

    public function download(ActionRequest $request)
    {
        return Excel::download(new ProductsExport, now()->format('Ymd') . '-' . 'products.xlsx');
    }
}
