<?php
namespace Tests\VP\GooglePlaces;

use VP\GooglePlaces\ApiClient;
use VP\GooglePlaces\ApiClientInterface;
use VP\GooglePlaces\Request\RequestInterface;
use VP\HTTP\Client;
use VP\HTTP\ClientInterface;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class ApiClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiClientInterface
     */
    private $apiClient;

    /**
     * @var Client|\PHPUnit_Framework_MockObject_MockObject
     */
    private $httpClientMock;

    /**
     * @var RequestInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $requestMock;

    /**
     * @inheritDoc
     */
    public function setUp()
    {
        $this->httpClientMock = $this->getMockBuilder(ClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestMock = $this->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiClient = new ApiClient($this->httpClientMock);

        parent::setUp();
    }

    public function testInterface()
    {
        $this->assertInstanceOf(ApiClientInterface::class, $this->apiClient);
    }

    /**
     * @dataProvider normalFlowDataProvider
     *
     * @param array $parameters
     * @param array $result
     */
    public function testTextSearch(array $parameters, array $result)
    {
        $this->httpClientMock
            ->expects($this->once())
            ->method('makeRequest')
            ->with($this->getPath(), 'GET', $parameters)
            ->willReturn($result);

        $result = $this->apiClient->textSearch($parameters);
        $this->assertInternalType('array', $result);
    }

    /**
     * @return array
     */
    public function normalFlowDataProvider(): array
    {
        return [
            [
                $this->getDefaultParameters(),
                [
                    'html_attributions' => [],
                    'results'           => [
                        [
                            'formatted_address' => 'foo',
                            'name'              => 'bar',
                        ],
                        [
                            'formatted_address' => 'baz',
                            'name'              => 'qux',
                        ],
                    ],
                    'status'            => 'OK',
                ],
            ],
            [
                $this->getDefaultParameters(),
                [
                    'html_attributions' => [],
                    'results'           => [],
                    'status'            => 'ZERO_RESULTS',
                ],
            ],
        ];
    }

    /**
     * @expectedException \VP\Exception\GooglePlacesApiException
     * @expectedExceptionMessage Sorry, but you are over your quota.
     * @expectedExceptionCode 500
     */
    public function testOverLimitException()
    {
        $this->httpClientMock
            ->expects($this->once())
            ->method('makeRequest')
            ->with($this->getPath(), 'GET', $this->getDefaultParameters())
            ->willReturn([
                'html_attributions' => [],
                'results'           => [],
                'status'            => 'OVER_QUERY_LIMIT',
            ]);

        $this->apiClient->textSearch($this->getDefaultParameters());
    }

    /**
     * @expectedException \VP\Exception\GooglePlacesApiException
     * @expectedExceptionMessage Your request was denied, generally because of lack of an invalid key parameter.
     * @expectedExceptionCode 403
     */
    public function testRequestDeniedException()
    {
        $this->httpClientMock
            ->expects($this->once())
            ->method('makeRequest')
            ->with($this->getPath(), 'GET', $this->getDefaultParameters())
            ->willReturn([
                'html_attributions' => [],
                'results'           => [],
                'status'            => 'REQUEST_DENIED',
            ]);

        $this->apiClient->textSearch($this->getDefaultParameters());
    }

    /**
     * @expectedException \VP\Exception\GooglePlacesApiException
     * @expectedExceptionMessage The `query` parameter is missing
     * @expectedExceptionCode 400
     */
    public function testInvalidRequestException()
    {
        $this->httpClientMock
            ->expects($this->once())
            ->method('makeRequest')
            ->with($this->getPath(), 'GET', $this->getDefaultParameters())
            ->willReturn([
                'html_attributions' => [],
                'results'           => [],
                'status'            => 'INVALID_REQUEST',
            ]);

        $this->apiClient->textSearch($this->getDefaultParameters());
    }

    /**
     * @expectedException \VP\Exception\GooglePlacesApiException
     * @expectedExceptionMessage Unknown error. Try again, please.
     * @expectedExceptionCode 500
     */
    public function testUnknownErrorException()
    {
        $this->httpClientMock
            ->expects($this->once())
            ->method('makeRequest')
            ->with($this->getPath(), 'GET', $this->getDefaultParameters())
            ->willReturn([
                'html_attributions' => [],
                'results'           => [],
                'status'            => 'UNKNOWN_ERROR',
            ]);

        $this->apiClient->textSearch($this->getDefaultParameters());
    }

    /**
     * @return array
     */
    private function getDefaultParameters(): array
    {
        return ['query' => 'foo', 'key' => 'AIzaSyCbMJ4KOpp6wB4Cs60UtrDV_mTSL67zhe8'];
    }

    /**
     * @return string
     */
    private function getPath(): string
    {
        return 'https://maps.googleapis.com/maps/api/place/textsearch/json';
    }
}
