<?php

namespace Botamp\Api;

use Botamp\Client;
use Botamp\Api\ApiResponse;
use Botamp\TestCase;
use GuzzleHttp\Psr7\Response;

class MeTest extends TestCase
{
    public function testShouldGetPageAttributes()
    {
      $attributes =  ['page_id' => '123456', 'page_access_token' => 'A123456Z'];

      $httpClient = $this->getHttpMethodsMock(array('get'));
      $httpClient
          ->expects($this->any())
          ->method('get')
          ->with('https://app.botamp.com/api/v1/me', array())
          ->will($this->returnValue($this->getPSR7Response($attributes)));

      $client = $this->getMock('Botamp\Client', array('getHttpClient'), array('123456789'));
      $client->expects($this->any())
          ->method('getHttpClient')
          ->willReturn($httpClient);

      $this->assertEquals($attributes, (new Me($client))->get());
    }
}
