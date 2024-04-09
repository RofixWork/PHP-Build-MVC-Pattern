<?php

namespace App\DI;

use App\EntryNotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $entries;
    public function get(string $id)
    {
        if($this->has($id))
        {
            $entry = $this->entries[$id];
            return $entry($this);
        }
        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable $concret) : void
    {
        $this->entries[$id] = $concret;
    }

    public function getEntries()
    {
        var_dump($this->entries);
    }

    public function resolve(string $id)
    {
        $reflectionClass = new \ReflectionClass($id);

        if(!$reflectionClass->isInstantiable())
        {
            throw new ContainerEcxpetion('cannot instantiate in this class ' . $id);
        }

        $constructor = $reflectionClass->getConstructor();

        if(!$constructor)
        {
            return new $id;
        }

        $params = $constructor->getParameters();

        if(!$params)
        {
            return new $id;
        }

        $arguments = array_map(function (\ReflectionParameter $parameter) use($id) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            if(!$type)
            {
                throw new ContainerEcxpetion('Failed to resolve class ' . $id . 'because $params ' . $name . ' is missing a type hint');
            }

            if($type instanceof \ReflectionUnionType)
            {
                throw new ContainerEcxpetion('Failed to resolve class ' . $id . 'because of union type fot param ' . $name);
            }

            if($type instanceof \ReflectionNamedType && !$type->isBuiltin())
            {
                return $this->get($type->getName());
            }

            throw new ContainerEcxpetion('Failed to resolve class ' . $id . 'because $params ' . $name . ' is missing a type hint');


        }, $params);

        return $reflectionClass->newInstanceArgs($arguments);
    }
}