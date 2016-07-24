<?php
namespace Tests\VP\HTTP;

use VP\HTTP\Client;
use VP\HTTP\ClientInterface;
use VP\HTTP\Curl;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var Curl|\PHPUnit_Framework_MockObject_MockObject
     */
    private $curlMock;

    /**
     * @inheritDoc
     */
    public function setUp()
    {
        $this->curlMock = $this->createMock(Curl::class);
        $this->client   = new Client($this->curlMock, 10);

        parent::setUp();
    }

    public function testSuccessRequest()
    {
        $data = ['foo' => 'bar'];

        $this->curlMock
            ->expects($this->at(0))
            ->method('setOption')
            ->with(CURLOPT_URL, 'http://foo.bar?baz=qux');

        $this->curlMock
            ->expects($this->at(1))
            ->method('setOption')
            ->with(CURLOPT_TIMEOUT, 10);

        $this->curlMock
            ->expects($this->once())
            ->method('exec');

        $this->curlMock
            ->expects($this->once())
            ->method('getErrorCode')
            ->willReturn(0);

        $this->curlMock
            ->expects($this->once())
            ->method('getResponse')
            ->willReturn(json_encode($data));

        $result = $this->client->makeRequest('http://foo.bar', 'GET', ['baz' => 'qux']);

        $this->assertInternalType('array', $result);
        $this->assertEquals($data, $result);
    }

    /**
     * @expectedException \VP\Exception\ConnectionException
     * @expectedExceptionCode 500
     * @expectedExceptionMessage Something happened. The error is: CURLE_UNSUPPORTED_PROTOCOL
     */
    public function testFailureRequest()
    {
        $this->curlMock
            ->expects($this->at(0))
            ->method('setOption')
            ->with(CURLOPT_URL, 'http://foo.bar?baz=qux');

        $this->curlMock
            ->expects($this->at(1))
            ->method('setOption')
            ->with(CURLOPT_TIMEOUT, 10);

        $this->curlMock
            ->expects($this->once())
            ->method('exec');

        $this->curlMock
            ->expects($this->once())
            ->method('getErrorCode')
            ->willReturn(1);

        $this->curlMock
            ->expects($this->once())
            ->method('getErrorString')
            ->willReturn('CURLE_UNSUPPORTED_PROTOCOL');

        $this->client->makeRequest('http://foo.bar', 'GET', ['baz' => 'qux']);
    }

    /**
     * @expectedException \VP\Exception\LogicException
     * @expectedExceptionCode 500
     * @expectedExceptionMessage Method `POST` is not supported.
     */
    public function testPostRequest()
    {
        $this->client->makeRequest('http://foo.bar', 'POST', ['baz' => 'qux']);
    }

    /**
     * @expectedException \VP\Exception\BadResponseException
     * @expectedExceptionCode 500
     * @expectedExceptionMessage The response should be JSON. The error is: Syntax error
     */
    public function testBadJsonResponse()
    {
        $this->curlMock
            ->expects($this->at(0))
            ->method('setOption')
            ->with(CURLOPT_URL, 'http://foo.bar?baz=qux');

        $this->curlMock
            ->expects($this->at(1))
            ->method('setOption')
            ->with(CURLOPT_TIMEOUT, 10);

        $this->curlMock
            ->expects($this->once())
            ->method('exec');

        $this->curlMock
            ->expects($this->once())
            ->method('getErrorCode')
            ->willReturn(0);

        $this->curlMock
            ->expects($this->once())
            ->method('getResponse')
            ->willReturn('foo');

        $this->client->makeRequest('http://foo.bar', 'GET', ['baz' => 'qux']);
    }
}
