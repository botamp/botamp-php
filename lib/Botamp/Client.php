<?php

namespace Botamp;

use Botamp\Api\ApiResource;
use Botamp\Exceptions;
use Http\Client\Common;
use Http\Client\Common\Plugin;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;
use Http\Message\Authentication\BasicAuth;

/**
 * Class Client
 *
 * @package Botamp
 */
class Client
{
    private $httpClient;

    private $apiKey;

    private $apiBase = 'https://app.botamp.com/api';

    private $apiVersion = 'v1';

    private static $allApiVersions = ['v1'];

    public $entities;

    public function __construct($apiKey, HttpClient $httpClient = null)
    {
        $this->setHttpClient($httpClient ?: HttpClientDiscovery::find(), MessageFactoryDiscovery::find());

        $this->apiKey = $apiKey;

        $this->entities = new ApiResource('entities', $this);
    }

    public function getHttpClient()
    {
        return $this->httpClient;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setApiBase($apiBase)
    {
        $this->apiBase = $apiBase;
    }

    public function getApiBase()
    {
        return $this->apiBase;
    }

    public function setApiVersion($apiVersion)
    {
        $apiVersion = strtolower($apiVersion);

        if(!in_array($apiVersion, self::$allApiVersions))
            throw new Exceptions\Base("No valid api version provided.");
        else
            $this->apiVersion = $apiVersion;
    }

    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    private function setHttpClient(HttpClient $httpClient, MessageFactory $messageFactory)
    {
        $plugins = [
            new Plugin\HeaderDefaultsPlugin(['Content-Type' => 'application/vnd.api+json']),
            new Plugin\AuthenticationPlugin(new BasicAuth($this->apiKey, ''))
        ];

        $this->httpClient = new Common\HttpMethodsClient(new Common\PluginClient($httpClient, $plugins), $messageFactory);
    }
}
