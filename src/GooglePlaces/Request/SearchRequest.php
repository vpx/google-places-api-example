<?php
namespace VP\GooglePlaces\Request;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 * @see https://developers.google.com/places/web-service/search
 */
class SearchRequest implements RequestInterface
{
    /**
     * @var array
     */
    private $parameters;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return self::METHOD_GET;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return '/place/textsearch/json';
    }

    /**
     * @inheritDoc
     */
    public function getQueryParams(): array
    {
        return $this->parameters;
    }
}
