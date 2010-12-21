<?php

namespace Doctrine\Common\CodeGeneration\Dumper;

use Doctrine\Common\CodeGeneration\PropertyDefinition;

use Doctrine\Common\CodeGeneration\ArgumentDefinition;
use Doctrine\Common\CodeGeneration\MethodDefinition;
use Doctrine\Common\CodeGeneration\ClassDefinition;

class PHPDumper
{
    private $eol;

    public function __construct($eol = "\n")
    {
        $this->eol = $eol;
    }

    public function dumpClass($name, ClassDefinition $class)
    {
        $code = 'class ' . $name;
        $code .= $this->eol;
        $code .= '{' . $this->eol;
        $code .= $this->prepareBody($this->dumpProperties($class->getProperties()));
        $code .= $this->eol;

        if ($class->hasConstructor()) {
            $code .= $this->prepareBody($this->dumpMethod('__construct', $class->getConstructor()));
            $code .= $this->eol;
        }

        $code .= $this->prepareBody($this->dumpMethods($class->getMethods()));
        $code .= '}' . $this->eol;

        return $code;
    }

    public function dumpMethod($name, MethodDefinition $method)
    {
        $code = $method->getVisibility();

        if ($method->isStatic()) {
            $code .= ' static';
        }

        $code .= sprintf(' function %s(%s)', $name, $this->dumpArguments($method->getArguments()));
        $code .= $this->eol;
        $code .= '{' . $this->eol;
        $code .= $this->prepareBody($method->getBody()) . $this->eol;
        $code .= '}' . $this->eol;

        return $code;
    }

    private function prepareBody($body)
    {
        $lines = explode($this->eol, $body);

        foreach ($lines as &$line) {
            if ( ! empty($line)) {
                $line = '    ' . $line;
            }
        }

        return implode($this->eol, $lines);
    }

    public function dumpArgument($name, ArgumentDefinition $argument)
    {
        $code = '$' . $name;

        if (null !== $argument->getTypehint()) {
            $code = $argument->getTypehint() . ' ' . $code;
        }

        if ($argument->hasDefault()) {
            $code .= ' = ' . $this->dumpValue($argument->getDefault());
        }

        return $code;
    }

    public function dumpProperty($name, PropertyDefinition $property)
    {
        $code = $property->getVisibility();

        if ($property->isStatic()) {
            $code .= ' static';
        }

        $code .= ' $' . $name;

        if ($property->hasDefault()) {
            $code .= ' = ' . $this->dumpValue($property->getDefault());
        }

        $code .= ';';

        return $code;
    }

    private function dumpValue($value)
    {
        if (is_null($value)) {

            return 'null';
        } else if (is_string($value)) {

            return "'$value'";
        } else if (is_numeric($value)) {

            return $value;
        } else if (is_array($value)) {
            $values = array();

            foreach ($value as $key => $val) {
                $dumpedVal = '';
                if ( ! is_int($key)) {
                    $dumpedVal .= $this->dumpValue($key);
                    $dumpedVal .= ' => ';
                }
                $dumpedVal .= $this->dumpValue($val);
                $values[] = $dumpedVal;
            }

            return sprintf('array(%s)', implode(', ', $values));
        }

        throw new \InvalidArgumentException(sprintf('Argument default value %s cannot be dumped!', var_export($value, true)));
    }

    private function dumpArguments(array $arguments)
    {
        $dumpedArgs = array();

        foreach ($arguments as $name => $argument) {
            $dumpedArgs[] = $this->dumpArgument($name, $argument);
        }

        return implode(', ', $dumpedArgs);
    }

    private function dumpProperties(array $properties)
    {
        $dumpedProperties = array();

        foreach ($properties as $name => $property) {
            $dumpedProperties[] = $this->dumpProperty($name, $property);
        }

        return implode($this->eol, $dumpedProperties) . $this->eol;
    }

    private function dumpMethods(array $methods)
    {
        $code = '';
        $dumpedMethods = array();

        foreach ($methods as $name => $method) {
            $dumpedMethod = $this->dumpMethod($name, $method);
            $dumpedMethods[] = $dumpedMethod;
        }

        return implode($this->eol.$this->eol, $dumpedMethods) . $this->eol;
    }
}
