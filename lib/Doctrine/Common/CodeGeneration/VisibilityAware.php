<?php

namespace Doctrine\Common\CodeGeneration;

interface VisibilityAware
{
    const VISIBILITY_PUBLIC    = 'public';
    const VISIBILITY_PROTECTED = 'protected';
    const VISIBILITY_PRIVATE   = 'private';

    function setVisibility($visibility);
    function getVisibility();
    function setStatic($bool = true);
    function isStatic();
}
