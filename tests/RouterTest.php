<?php
namespace Tests\VP;

use VP\Router;

/**
 * @author Vitalii Piskovyi <vitalii.piskovyi@gmail.com>
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @inheritDoc
     */
    public function setUp()
    {
        $this->router = new Router();

        parent::setUp();
    }

    /**
     * @dataProvider routesDataProvider
     *
     * @param string $current
     * @param string $pattern
     * @param callable $callback
     */
    public function testRouter(string $current, string $pattern, callable $callback)
    {
        $this->router->add($pattern, $callback);
        $this->assertInternalType('callable', $this->router->match($current));
    }

    /**
     * @expectedException \VP\Exception\RouteNotFoundException
     */
    public function testNotFoundRoute()
    {
        $this->router->match('/baz/qux');
    }

    /**
     * @return array
     */
    public function routesDataProvider(): array
    {
        return [
            [
                '/foo/bar',
                '/foo/bar',
                function () {
                    return 'foo';
                },
            ],
            [
                '/',
                '/',
                function () {
                    echo 'foo';
                },
            ],
        ];
    }
}
