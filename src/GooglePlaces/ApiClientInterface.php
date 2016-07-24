<?php
namespace VP\GooglePlaces;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
interface ApiClientInterface
{
    const GPA_URI = 'https://maps.googleapis.com/maps/api';
    const GPA_KEY = 'AIzaSyB1NK2khSMCWDAIUa2ZJqiUMW6PycmVI_0';

    const STATUS_OK               = 'OK';
    const STATUS_INVALID_REQUEST  = 'INVALID_REQUEST';
    const STATUS_NOT_FOUND        = 'NOT_FOUND';
    const STATUS_OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    const STATUS_REQUEST_DENIED   = 'REQUEST_DENIED';
    const STATUS_UNKNOWN_ERROR    = 'UNKNOWN_ERROR';
    const STATUS_ZERO_RESULTS     = 'ZERO_RESULTS';

    const RESPONSE_STATUS_FIELD = 'status';
    const RESPONSE_RESULT_FIELD = 'results';

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function textSearch(array $parameters): array;
}
