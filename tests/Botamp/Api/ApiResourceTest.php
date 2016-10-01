<?php

namespace Botamp\Api;

use Botamp\Client;
use Botamp\Api\ApiResponse;
use Botamp\TestCase;
use GuzzleHttp\Psr7\Response;

class ApiResourceTest extends TestCase
{
    private $resourceUrl;

    public function setUp()
    {
        $this->resourceUrl = 'https://app.botamp.com/api/v1/entities';
    }

    public function testShouldSetCorrectApiRequestor()
    {
        $client = new Client('123456789');
        $entities = new ApiResource('entities', $client);
        $apiRequestor = new ApiRequestor('entities', $client);

        $this->assertAttributeEquals($apiRequestor, 'apiRequestor', $entities);
    }

    /**
     * @covers ApiResource::all
     */
    public function testShouldPassAllActionToClient()
    {
        $body =  [ 'data' => [ [ 'id' => 1, 'type' => 'entities', 'attributes' => ['url' => 'my/url'] ] ] ];

        $httpClient = $this->getHttpMethodsMock(array('get'));
        $httpClient
            ->expects($this->any())
            ->method('get')
            ->with($this->resourceUrl)
            ->will($this->returnValue($this->getPSR7Response($body)));

        $client = $this->getMock('Botamp\Client', array('getHttpClient'), array('123456789'));
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $entities = new ApiResource('entities', $client);

        $this->assertEquals(new BotampObject($body, $entities), $entities->all());
    }


    /**
     * @covers ApiResource::all
     */
    public function testShouldPassAllActionToClientWithPageParams()
    {
        $body =  [ 'data' => [ 'id' => 1, 'type' => 'entities', 'attributes' => ['url' => 'my/url'] ] ];

        $httpClient = $this->getHttpMethodsMock(array('get'));
        $httpClient
            ->expects($this->any())
            ->method('get')
            ->with($this->resourceUrl.'?page[number]=1&page[size]=1')
            ->will($this->returnValue($this->getPSR7Response($body)));

        $client = $this->getMock('Botamp\Client', array('getHttpClient'), array('123456789'));
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $entities = new ApiResource('entities', $client);

        $this->assertEquals(new BotampObject($body, $entities), $entities->all(['page[number]'=>1, 'page[size]'=>1]));
    }


    /**
     * @covers ApiResource::get
     */
    public function testShouldPassGetActionToClient()
    {
        $body =  [ 'data' => [ 'id' => 1, 'type' => 'entities', 'attributes' => ['url' => 'my/url'] ] ];

        $httpClient = $this->getHttpMethodsMock(array('get'));
        $httpClient
            ->expects($this->any())
            ->method('get')
            ->with($this->resourceUrl.'/1', array())
            ->will($this->returnValue($this->getPSR7Response($body)));

        $client = $this->getMock('Botamp\Client', array('getHttpClient'), array('123456789'));
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $entities = new ApiResource('entities', $client);

        $this->assertEquals(new BotampObject($body, $entities), $entities->get(1));
    }


    /**
     * @covers ApiResource::create
     */
    public function testShouldPassCreateActionToClient()
    {
        $params = ['url' => 'my/url'];
        $serializedParams = json_encode(['data' => ['type' => 'entities', 'attributes' => $params]]);

        $body =  [ 'data' => [ 'id' => 1, 'type' => 'entities', 'attributes' => ['url' => 'my/url'] ] ];

        $httpClient = $this->getHttpMethodsMock(array('post'));
        $httpClient
            ->expects($this->once())
            ->method('post')
            ->with($this->resourceUrl, [], $serializedParams)
            ->will($this->returnValue($this->getPSR7Response($body)));

        $client = $this->getMock('Botamp\Client', array('getHttpClient'), array('123456789'));
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $entities = new ApiResource('entities', $client);

        $this->assertEquals(new BotampObject($body, $entities), $entities->create($params));
    }


    /**
     * @covers ApiResource::update
     */
    public function testShouldPassUpdateActionToClient()
    {
        $params = ['url' => 'my/url'];
        $serializedParams = json_encode(['data' => ['type' => 'entities', 'id' => 1, 'attributes' => $params]]);

        $body =  [ 'data' => [ 'id' => 1, 'type' => 'entities', 'attributes' => ['url' => 'my/url'] ] ];

        $httpClient = $this->getHttpMethodsMock(array('put'));
        $httpClient
            ->expects($this->once())
            ->method('put')
            ->with($this->resourceUrl.'/1', [], $serializedParams)
            ->will($this->returnValue($this->getPSR7Response($body)));

        $client = $this->getMock('Botamp\Client', array('getHttpClient'), array('123456789'));
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $entities = new ApiResource('entities', $client);

        $this->assertEquals(new BotampObject($body, $entities), $entities->update(1, $params));
    }


    /**
     * @covers ApiResource::delete
     */
    public function testShouldPassDeleteActionToClient()
    {
        $httpClient = $this->getHttpMethodsMock(array('delete'));
        $httpClient
            ->expects($this->once())
            ->method('delete')
            ->with($this->resourceUrl.'/1', array())
            ->will($this->returnValue($this->getPSR7Response([])));

        $client = $this->getMock('Botamp\Client', array('getHttpClient'), array('123456789'));
        $client->expects($this->any())
            ->method('getHttpClient')
            ->willReturn($httpClient);

        $entities = new ApiResource('entities', $client);

        $this->assertEquals(new BotampObject([], $entities), $entities->delete(1));
    }
}
