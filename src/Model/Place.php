<?php
namespace VP\Model;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class Place implements \JsonSerializable
{
    const ADDRESS_FIELD = 'formatted_address';
    const NAME_FIELD    = 'name';

    const RESULT_NAME_FIELD    = 'name';
    const RESULT_ADDRESS_FIELD = 'address';

    /**
     * @var array
     */
    private $place;

    /**
     * @param array $place
     */
    public function __construct(array $place)
    {
        $this->place = $place;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            self::RESULT_NAME_FIELD    => $this->place[self::NAME_FIELD] ?? '',
            self::RESULT_ADDRESS_FIELD => $this->place[self::ADDRESS_FIELD] ?? '',
        ];
    }
}
