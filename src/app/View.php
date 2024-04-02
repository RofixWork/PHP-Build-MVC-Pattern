<?php

namespace App;

use App\Exception\ViewNotFound;

class View
{
    public function __construct(protected string $view, protected array $params = [])
    {
    }

    /**
     * @throws ViewNotFound
     */
    public function render() : string|\Exception
    {
        $filePath = VIEW_PATH . "/$this->view.php" ;

        if(!file_exists($filePath))
        {
            throw new ViewNotFound();
        }

        ob_start();
        include $filePath;
        return ob_get_clean();
    }
    public static function make(string $view, array $params) : static
    {
        return new static($view, $params);
    }

    /**
     * @throws ViewNotFound
     */
    public function __toString(): string
    {
        return $this->render();
    }

    public function __get(string $name)
    {
        return $this->params[$name] ?? null;
    }
}