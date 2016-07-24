<?php
namespace VP\GooglePlaces\Request;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
interface RequestInterface
{
    const METHOD_GET = 'GET';

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return array
     */
    public function getQueryParams(): array;
}
