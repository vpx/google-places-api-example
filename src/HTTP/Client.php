<?php
namespace VP\HTTP;

use VP\Exception\BadResponseException;
use VP\Exception\ConnectionException;
use VP\Exception\LogicException;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class Client implements ClientInterface
{
    /**
     * @var Curl
     */
    private $curl;

    /**
     * @var int
     */
    private $timeout;

    /**
     * @param Curl $curl
     * @param int $timeout
     */
    public function __construct(Curl $curl, int $timeout = 30)
    {
        $this->curl    = $curl;
        $this->timeout = $timeout;
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $parameters
     *
     * @return array
     * @throws BadResponseException
     * @throws ConnectionException
     * @throws LogicException
     */
    public function makeRequest(string $url, string $method = self::METHOD_GET, array $parameters = []): array
    {
        if (self::METHOD_GET !== strtoupper($method)) {
            throw new LogicException(sprintf('Method `%s` is not supported.', $method), 500);
        }

        if (0 !== count($parameters)) {
            $url = sprintf('%s?%s', $url, http_build_query($parameters));
        }

        $this->curl->setOption(CURLOPT_URL, $url);
        $this->curl->setOption(CURLOPT_TIMEOUT, $this->timeout);
        $this->curl->exec();

        if (0 !== $this->curl->getErrorCode()) {
            throw new ConnectionException(
                sprintf('Something happened. The error is: %s', $this->curl->getErrorString()),
                500
            );
        }

        $result = json_decode($this->curl->getResponse(), true);

        if (json_last_error()) {
            throw new BadResponseException(
                sprintf('The response should be JSON. The error is: %s', json_last_error_msg()),
                500
            );
        }

        return $result;
    }
}
