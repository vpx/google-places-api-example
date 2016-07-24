<?php
namespace VP;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class Application
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * This method runs the best application in the world!
     */
    public function run()
    {
        header('Content-Type: application/json;charset=UTF-8');

        try {
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            parse_str($_SERVER['QUERY_STRING'], $parameters);
            $response = call_user_func_array($this->router->match($url), [$parameters]);
        } catch (\Throwable $e) {
            http_response_code($e->getCode());
            $response = ['error' => $e->getMessage()];
        }

        echo json_encode($response);
    }
}
