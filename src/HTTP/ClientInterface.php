<?php
namespace VP\HTTP;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
interface ClientInterface
{
    const METHOD_GET = 'GET';

    /**
     * @param string $url
     * @param string $method
     * @param array $parameters
     *
     * @return array
     */
    public function makeRequest(string $url, string $method, array $parameters): array;
}
