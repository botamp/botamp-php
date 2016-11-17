<?php

namespace Botamp\Api;

use Botamp\Client;

/**
 * Class Me

 *
 * @package Botamp\Api
 */

class Me
{
    private $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get()
    {
        $url = $this->client->getApiBase().'/'.$this->client->getApiVersion().'/me';
        return ApiResponse::getContent($this->client->getHttpClient()->get($url));
    }
}
