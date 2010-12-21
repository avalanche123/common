<?php

namespace Doctrine\Tests\Common\CodeGeneration;

use Doctrine\Common\CodeGeneration\VisibilityAware;
use Doctrine\Common\CodeGeneration\PropertyDefinition;

class PropertyDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldInstantiatePublicNonStatic()
    {
        $property = new PropertyDefinition();

        $this->assertEquals(VisibilityAware::VISIBILITY_PUBLIC, $property->getVisibility());
        $this->assertFalse($property->isStatic());
    }

    public function testShouldInstantiateProtected()
    {
        $property = new PropertyDefinition(VisibilityAware::VISIBILITY_PROTECTED);

        $this->assertEquals(VisibilityAware::VISIBILITY_PROTECTED, $property->getVisibility());
        $this->assertFalse($property->isStatic());
    }

    public function testShouldInstantiatePrivateAndStatic()
    {
        $property = new PropertyDefinition(VisibilityAware::VISIBILITY_PRIVATE, true);

        $this->assertEquals(VisibilityAware::VISIBILITY_PRIVATE, $property->getVisibility());
        $this->assertTrue($property->isStatic());
    }

    public function testShouldResetVisibilityAndStatic()
    {
        $property = new PropertyDefinition();

        $this->assertEquals(VisibilityAware::VISIBILITY_PUBLIC, $property->getVisibility());
        $this->assertFalse($property->isStatic());

        $property->setVisibility(VisibilityAware::VISIBILITY_PRIVATE);

        $this->assertEquals(VisibilityAware::VISIBILITY_PRIVATE, $property->getVisibility());

        $property->setStatic();

        $this->assertTrue($property->isStatic());

        $property->setStatic(false);

        $this->assertFalse($property->isStatic());
    }

    public function testShouldAddDefault()
    {
        $default  = 'value';
        $property = new PropertyDefinition();

        $this->assertFalse($property->hasDefault());

		$property->setDefault($default);

        $this->assertTrue($property->hasDefault());
        $this->assertEquals($default, $property->getDefault());
    }
}
