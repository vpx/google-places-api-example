<?php
namespace VP\HTTP;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class Curl
{
    /**
     * @var resource
     */
    private $ch;

    /**
     * @var string
     */
    private $response;

    public function __construct()
    {
        $this->ch = curl_init();
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * @return Curl
     */
    public function exec(): Curl
    {
        $this->response = curl_exec($this->ch);

        return $this;
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return curl_errno($this->ch);
    }

    /**
     * @return string
     */
    public function getErrorString(): string
    {
        return curl_error($this->ch);
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        curl_close($this->ch);

        return (string) $this->response;
    }

    /**
     * @param int $option
     * @param bool|int|string $value
     *
     * @return Curl
     */
    public function setOption(int $option, $value): Curl
    {
        curl_setopt($this->ch, $option, $value);

        return $this;
    }
}
