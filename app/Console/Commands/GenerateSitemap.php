<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Automatically generate sitemap.xml file';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Home Page
        $sitemap->add(
            Url::create(route('homePage'))
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        // Static Pages
        $staticRoutes = [
            'about-us',
            'contuct-us',
            'products',
            'policies',
            'shipping',
            'terms',
            'return.refund'
        ];

        foreach ($staticRoutes as $route) {
            if (route($route, [], false)) {
                $sitemap->add(Url::create(route($route)));
            }
        }

        // Dynamic Products
        foreach (Product::where('status', 2)->get() as $product) {
            $sitemap->add(
                Url::create(route('product', $product->slug))
                    ->setLastModificationDate($product->updated_at)
            );
        }

        // Generate File
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ Sitemap generated successfully!');
    }
}
