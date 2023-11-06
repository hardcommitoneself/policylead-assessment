<?php

namespace App\Console\Commands;

use App\Spiders\PolicyLeadArticleSpider;
use Illuminate\Console\Command;
use RoachPHP\Roach;
use App\Models\Article;
use Illuminate\Support\Carbon;

class ScrapeArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $result = Roach::collectSpider(
            PolicyLeadArticleSpider::class
        );

        $result =  $result[0]->all();

        if (!isset($result['articles'])) {
            return;
        }

        foreach ($result['articles'] as $article) {
            Article::updateOrCreate(
                [
                    'uuid' => data_get($article, 'uuid')
                ],
                [
                    'title' => data_get($article, 'title'),
                    'link' => data_get($article, 'link'),
                    'date' => Carbon::createFromFormat('j. F Y, H.i \U\h\r', data_get($article, 'date')),
                    'excerpt' => data_get($article, 'excerpt'),
                    'image' => data_get($article, 'image')
                ]
            );
        }
    }
}
