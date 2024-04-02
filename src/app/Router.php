<?php
declare(strict_types=1);
namespace App;

use App\Exception\NotFoundException;

class Router
{
    private array $routes = [];

    public function register(string $requestMethod, string $route, callable|array $action) : self
    {
        $this->routes[$requestMethod][$route] = $action;
        
        return $this;
    }
//get
    public function get(string $route, callable|array $action) : self
    {
        return $this->register("get", $route, $action);
    }

    //post
    public function post(string $route, callable|array $action) : self
    {
        return $this->register("post", $route, $action);
    }

    //resolve

    /**
     * @throws NotFoundException
     */
    public function resolve(string $requestUri, string $requestMethod)
    {
        //get route and action
        $route = explode("?", $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        //check action exist or not
        if(!$action)
        {
            throw new NotFoundException();
        }
        //call action
        if(is_callable($action))
        {
            return call_user_func($action);
        }
        //check param is array
        if(is_array($action))
        {
            [$class, $method] = $action;

            if(class_exists($class))
            {
                $class = new $class();

                if(method_exists($class, $method))
                {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }

        throw new NotFoundException();
    }

    public function printRoutes() : void
    {
         var_dump($this->routes);
    }
}