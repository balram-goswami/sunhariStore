<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap.xml file';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // ✅ Home
        $sitemap->add(
            Url::create(route('homePage'))
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        );

        // ✅ Static Pages
        $sitemap->add(Url::create(route('about-us')));
        $sitemap->add(Url::create(route('contuct-us')));

        // ✅ Shop & Products List
        $sitemap->add(Url::create(route('products')));

        // ✅ Profile Page (authenticated, but still useful for indexing if public)
        $sitemap->add(Url::create(route('profile')));

        // ✅ Products (dynamic)
        foreach (Product::where('status', 2)->get() as $product) {
            $sitemap->add(
                Url::create(route('product', $product->slug))
                    ->setLastModificationDate($product->updated_at)
            );
        }

        // Save sitemap.xml in public/
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ Sitemap generated successfully!');
    }
}
