<?php

namespace Doctrine\Common\CodeGeneration;

interface Defaultable
{
    function hasDefault();
    function setDefault($default);
    function getDefault();
}
