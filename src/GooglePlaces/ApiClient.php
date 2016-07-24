<?php
namespace VP\GooglePlaces;

use VP\Exception\GooglePlacesApiException;
use VP\GooglePlaces\Request\RequestInterface;
use VP\GooglePlaces\Request\SearchRequest;
use VP\HTTP\ClientInterface;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class ApiClient implements ApiClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function textSearch(array $parameters): array
    {
        return $this->processRequest(new SearchRequest($parameters));
    }

    /**
     * @param RequestInterface $request
     *
     * @return array
     */
    private function processRequest(RequestInterface $request): array
    {
        $result = $this->client->makeRequest(
            sprintf('%s%s', self::GPA_URI, $request->getPath()),
            ClientInterface::METHOD_GET,
            array_merge($request->getQueryParams(), ['key' => self::GPA_KEY])
        );

        switch (strtoupper($result[self::RESPONSE_STATUS_FIELD])) {
            case self::STATUS_OK:
            case self::STATUS_ZERO_RESULTS:
                return $result[self::RESPONSE_RESULT_FIELD];
                break;
            case self::STATUS_OVER_QUERY_LIMIT:
                throw new GooglePlacesApiException('Sorry, but you are over your quota.', 500);
                break;
            case self::STATUS_REQUEST_DENIED:
                throw new GooglePlacesApiException(
                    'Your request was denied, generally because of lack of an invalid key parameter.',
                    403
                );
                break;
            case self::STATUS_INVALID_REQUEST:
                throw new GooglePlacesApiException('The `query` parameter is missing', 400);
                break;
            case self::STATUS_UNKNOWN_ERROR:
            default:
                throw new GooglePlacesApiException('Unknown error. Try again, please.', 500);
                break;
        }
    }
}
