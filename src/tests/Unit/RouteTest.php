<?php

namespace Unit;

use App\Exception\NotFoundException;
use App\Router;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Tests\DataProvider\RouteDataProvider;
class RouteTest extends TestCase
{
    private Router $router;
    protected function setUp(): void
    {
        parent::setUp();
        $this->router = new Router();
    }

    public function testRegister()
    {

        $this->router->register('get', '/home', ["Class", 'method']);

        $expected = [
            "get" => [
                "/home" => ["Class", "method"]
            ]
        ];

        $this->assertEquals($expected, $this->router->printRoutes());
    }

    public function testGet()
    {

        $this->router->get("/", function () {
            return 'Home';
        });

        $expected = [
            'get' => [
                '/' => function() {
                    return "Home";
                }
            ]
        ];

        $this->assertEquals($expected, $this->router->printRoutes());
    }

    public function testPost()
    {

        $this->router->post("/", function () {
            return 'Home';
        });

        $expected = [
            'post' => [
                '/' => function() {
                    return "Home";
                }
            ]
        ];

        $this->assertEquals($expected, $this->router->printRoutes());
    }

    public function testRoutesIsEmpty()
    {
        $this->assertEmpty($this->router->isEmpty());
    }

    #[DataProviderExternal(RouteDataProvider::class, 'passArgumentsToResolveMethod')]
    public function testResolve(string $requestMethod, string $requestUri)
    {
        $this->expectException(NotFoundException::class);
        $this->router->resolve($requestMethod, $requestUri);
    }

    public function testResolveRoute()
    {
        $this->router->get("/home", fn() : array => [1,2,3]);

        $this->assertEquals([1,2,3,4], $this->router->resolve("/home", 'get'));
    }

    public function testEquals()
    {
        $obj = new class("ahmed") {
            public function __construct(public string $name)
            {
                echo "Hello $name";
            }
        };

        $obj2 = unserialize(serialize($obj));

        $this->assertEquals($obj, $obj2);
    }

}