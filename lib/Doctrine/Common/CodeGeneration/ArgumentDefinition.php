<?php

namespace Doctrine\Common\CodeGeneration;

class ArgumentDefinition implements Defaultable
{
    private $hasDefault;
    private $default;
    private $typehint;

    public function __construct($typehint = null)
    {
        $this->typehint   = $typehint;
        $this->hasDefault = false;
    }

    public function hasDefault()
    {
        return $this->hasDefault;
    }

    public function setDefault($default)
    {
        $this->default    = $default;
        $this->hasDefault = true;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function setTypehint($typehint)
    {
        $this->typehint = $typehint;
    }

    public function getTypehint()
    {
        return $this->typehint;
    }
}
