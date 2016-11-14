<?php
namespace Botamp;

class ClientTest extends TestCase
{
    private $apiKey;
    private $client;
    private $allApiVersions;

    public function setUp()
    {
        $this->apiKey = '123456789';
        $this->client = new Client($this->apiKey);
        $this->allApiVersions = TestCase::getProperty('Botamp\Client', 'allApiVersions');
    }

    public function test_shouldSetApiBase()
    {
        $newApiBase = 'https://customdomain.com/botamp-api';
        $this->client->setApiBase($newApiBase);
        $this->assertAttributeEquals($newApiBase, 'apiBase', $this->client);
    }

    public function test_shouldGetApiBase()
    {
        $this->assertEquals('https://app.botamp.com/api', $this->client->getApiBase());
    }

    public function test_ShouldGetApiKey()
    {
        $this->assertEquals($this->apiKey, $this->client->getApiKey());
    }

    public function test_ShouldGetHttpClient()
    {
        $this->assertInstanceOf('Http\Client\HttpClient', $this->client->getHttpClient());
    }

    public function test_shouldGetApiResourceInstance()
    {
        $this->assertInstanceOf('Botamp\Api\ApiResource', $this->client->entities);
    }

    public function test_ShouldGetValidApiVersion()
    {
        $this->assertContains($this->client->getApiVersion(), $this->allApiVersions->getValue());
    }

    /**
     * @dataProvider apiVersionsProvider
     */
    public function test_ShouldSetApiVersion($apiVersion)
    {
        $this->allApiVersions->setValue($this->client, array('v2', 'v3', 'v4', 'v5'));
        $this->client->setApiVersion($apiVersion);
        $this->assertEquals(strtolower($apiVersion), $this->client->getApiVersion());
    }

    public function testShouldGetAttributes()
    {
        $attributes =  ['page_id' => '123456', 'page_access_token' => 'A123456Z'];
        $url = 'https://app.botamp.com/api/v1/me';

        $httpClient = $this->getHttpMethodsMock(array('get'));
        $httpClient
            ->expects($this->any())
            ->method('get')
            ->with($url, array())
            ->will($this->returnValue($this->getPSR7Response($attributes)));

        $client = $this->getMock('Botamp\Client', array('getHttpClient'), array('123456789'));
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $this->assertEquals($attributes, $client->getAttributes());
    }

    /**
     * @expectedException Botamp\Exceptions\Base
     * @expectedExceptionMessage No valid api version provided.
     */
    public function test_shouldThrowExceptionIfTryingToSetBadApiVersion()
    {
        $this->allApiVersions->setValue($this->client, array('v1'));
        $this->client->setApiVersion('v2');
    }

    public function apiVersionsProvider()
    {
        return [['v2'], ['v3'], ['v4'], ['v5']];
    }
}
