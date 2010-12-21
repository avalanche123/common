<?php

namespace Doctrine\Common\CodeGeneration;

class PropertyDefinition implements VisibilityAware, Defaultable
{
    private $visibility;
    private $static;
    private $hasDefault;
    private $default;

    public function __construct($visibility = VisibilityAware::VISIBILITY_PUBLIC, $static = false)
    {
        $this->visibility = $visibility;
        $this->static     = $static;
        $this->hasDefault = false;
    }

    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function setStatic($bool = true)
    {
        $this->static = $bool;
    }

    public function isStatic()
    {
        return (bool) $this->static;
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
    }}
