<?php

namespace Doctrine\Common\CodeGeneration;

class MethodDefinition implements VisibilityAware
{
    private $arguments;
    private $body;
    private $static;
    private $visibility;

    public function __construct(array $arguments = array(), $visibility = VisibilityAware::VISIBILITY_PUBLIC, $static = false)
    {
        $this->arguments  = array();
        $this->visibility = $visibility;
        $this->static     = $static;

        foreach ($arguments as $argument => $typehint) {
            if ( ! is_string($argument)) {
                // if we deal with 0 => 'arg' as the array element, then add
                // simple argument, if we deal with 'arg' => 'typehint', then
                // add argument's typehint too
                $argument = $typehint;
                $typehint = null;
            }
            $this->addArgument($argument, $typehint);
        }
    }

    public function addArgument($argument, $typehint = null)
    {
        $arg = new ArgumentDefinition($typehint);
        $this->arguments[$argument] = $arg;
        return $arg;
    }

    public function hasArgument($argument)
    {
        return isset($this->arguments[$argument]);
    }

    public function getArgument($argument)
    {
        return $this->arguments[$argument];
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
        return $this;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function setStatic($bool = true)
    {
        $this->static = $bool;
        return $this;
    }

    public function isStatic()
    {
        return $this->static;
    }
}
