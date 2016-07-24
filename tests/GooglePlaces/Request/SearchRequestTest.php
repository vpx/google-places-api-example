<?php
namespace Tests\VP\GooglePlaces\Request;

use VP\GooglePlaces\Request\RequestInterface;
use VP\GooglePlaces\Request\SearchRequest;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class SearchRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @inheritDoc
     */
    public function setUp()
    {
        $this->request = new SearchRequest(['foo' => 'bar']);

        parent::setUp();
    }

    public function testInterface()
    {
        $this->assertInstanceOf(RequestInterface::class, $this->request);
    }

    public function testRequest()
    {
        $this->assertInternalType('string', $this->request->getPath());
        $this->assertInternalType('string', $this->request->getMethod());
        $this->assertInternalType('array', $this->request->getQueryParams());

        $this->assertEquals('/place/textsearch/json', $this->request->getPath());
        $this->assertEquals('GET', $this->request->getMethod());
        $this->assertEquals(['foo' => 'bar'], $this->request->getQueryParams());
    }
}
