<?php

namespace App\Console\Commands;

use App\Spiders\PolicyLeadArticleSpider;
use Illuminate\Console\Command;
use RoachPHP\Roach;
use RoachPHP\Spider\Configuration\Overrides;

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

        error_log(json_encode($result[0]->all()));
    }
}
