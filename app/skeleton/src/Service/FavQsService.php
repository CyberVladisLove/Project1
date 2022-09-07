<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FavQsService
{

    /**
     * FavQsService constructor.
     */
    public function __construct(protected HttpClientInterface $httpClient)
    {
    }
    public function getQuote() : string
    {
        $request = $this->httpClient->request('GET','https://favqs.com/api/qotd');
        $content = $request->getContent();
        return $content;
    }
}