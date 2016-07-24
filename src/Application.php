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
     * This method runs the best application in the world
     */
    public function run()
    {
        header('Content-Type: application/json;charset=UTF-8');

        try {
            list($callback, $parameters) = $this->router->match();
            $response = call_user_func_array($callback, array_values($parameters));
        } catch (\Throwable $e) {
            http_response_code($e->getCode());
            $response = ['error' => $e->getMessage()];
        }

        echo json_encode($response);
    }
}
