<?php

namespace Doctrine\Common\CodeGeneration;

class ClassDefinition
{
    private $constructor;
    private $methods;
    private $properties;

    public function __construct(array $arguments = array(), array $properties = array())
    {
        $this->methods    = array();
        $this->properties = array();

        if ($arguments) {
            $this->constructor = new MethodDefinition($arguments);
        }

        foreach ($properties as $property) {
            $this->addProperty($property);
        }
    }

    public function addProperty($property)
    {
        $prop = new PropertyDefinition();
        $this->properties[$property] = $prop;
        return $prop;
    }

    public function hasProperty($property)
    {
        return isset($this->properties[$property]);
    }

    public function getProperty($property)
    {
        return $this->properties[$property];
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function addArgument($argument, $typehint = null)
    {
        $this->initConstructor();
        return $this->constructor->addArgument($argument, $typehint);
    }

    public function hasArgument($argument)
    {
        if ( ! isset($this->constructor)) {
            return false;
        }
        return $this->constructor->hasArgument($argument);
    }

    public function getArgument($argument)
    {
        return $this->constructor->getArgument($argument);
    }

    public function getArguments()
    {
        if ( ! isset($this->constructor)) {
            return array();
        }
        return $this->constructor->getArguments();
    }

    public function setConstructor($body)
    {
        $this->initConstructor();
        $this->constructor->setBody($body);
        return $this;
    }

    public function hasConstructor()
    {
        return isset($this->constructor);
    }

    public function getConstructor()
    {
        return $this->constructor;
    }

    public function addMethod($method, array $arguments = array())
    {
        $mtd = new MethodDefinition($arguments);
        $this->methods[$method] = $mtd;
        return $mtd;
    }

    public function hasMethod($method)
    {
        return isset($this->methods[$method]);
    }

    public function getMethod($method)
    {
        return $this->methods[$method];
    }

    public function getMethods()
    {
        return $this->methods;
    }

    private function initConstructor()
    {
        if (null === $this->constructor) {
            $this->constructor = new MethodDefinition();
        }
    }
}
