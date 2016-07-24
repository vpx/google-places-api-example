<?php
namespace Tests\VP\Model;

use VP\Model\Place;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class PlaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider placesDataProvider
     *
     * @param array $parameters
     * @param array $expected
     */
    public function testPlace(array $parameters, array $expected)
    {
        $place = new Place($parameters);
        $this->assertJsonStringEqualsJsonString(json_encode($expected), json_encode($place));
    }

    /**
     * @return array
     */
    public function placesDataProvider(): array
    {
        return [
            [
                [
                    'name' => 'foo',
                ],
                [
                    'name'    => 'foo',
                    'address' => '',
                ],
            ],
            [
                [
                    'formatted_address' => 'foo',
                ],
                [
                    'name'    => '',
                    'address' => 'foo',
                ],
            ],
            [
                [
                    'name'              => 'foo',
                    'formatted_address' => 'bar',
                ],
                [
                    'name'    => 'foo',
                    'address' => 'bar',
                ],
            ],
            [
                [
                    'foo' => 'bar',
                ],
                [
                    'name'    => '',
                    'address' => '',
                ],
            ],
        ];
    }
}
