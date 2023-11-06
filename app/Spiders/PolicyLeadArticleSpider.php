<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Downloader\Middleware\UserAgentMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Http\Request;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;
use Symfony\Component\DomCrawler\Crawler;
use Exception;

class PolicyLeadArticleSpider extends BasicSpider
{
    public array $startUrls = [
        'https://www.spiegel.de/politik/'
    ];

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
        UserAgentMiddleware::class
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        //
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    /**
     * @return Request[]
     */
    protected function initialRequests(): array
    {
        return [
            new Request(
                'GET',
                'https://www.spiegel.de/politik/',
                [$this, 'parse'],
                [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36'
                    ]
                ]
            )
        ];
    }

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        try {
            $result = [];

            $articles = $response->filterXPath('//div[contains(@data-block-el, "articleTeaser")]');

            foreach ($articles as $article) {
                $articleCrawler = new Crawler($article);

                // uuid
                $uuid = $articleCrawler->filter('article')->eq(0)->attr('data-sara-article-id');

                // title
                $title = $articleCrawler->filter('h2 a span:nth-of-type(2)')->text();

                // title link
                $link = $articleCrawler->filter('h2 a')->link()->getUri();

                // date
                $date = $articleCrawler->filter('span[data-auxiliary]')->text();

                // excerpt
                $excerpt = $articleCrawler->filter('section')->text();

                // image link
                $image = $articleCrawler->filter('picture img')->eq(0)->attr('data-src');

                $result[] = [
                    'uuid' => $uuid,
                    'title' => $title,
                    'link' => $link,
                    'date' => $date,
                    'excerpt' => $excerpt,
                    'image' => $image
                ];
            }

            yield $this->item([
                'articles' => $result
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
