<?php

namespace Doctrine\Tests\Common\CodeGeneration;

use Doctrine\Common\CodeGeneration\ClassDefinition;

class ClassDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldAddArgument()
    {
        $class = new ClassDefinition();
        $this->assertEquals(0, count($class->getArguments()));

        $class->addArgument('arg');
        $this->assertEquals(1, count($class->getArguments()));
        $this->assertTrue($class->hasArgument('arg'));
        $this->assertInstanceOf('Doctrine\Common\CodeGeneration\ArgumentDefinition', $class->getArgument('arg'));

        $arg = $class->addArgument('arg', 'TypeHint');
        $this->assertEquals('TypeHint', $arg->getTypehint());
    }

    public function testShouldAddMethod()
    {
        $class = new ClassDefinition();

        $this->assertEmpty($class->getMethods());

        $class->addMethod('setName');

        $this->assertNotEmpty($class->getMethods());
        $this->assertTrue($class->hasMethod('setName'));
        $this->assertInstanceOf('Doctrine\Common\CodeGeneration\MethodDefinition', $class->getMethod('setName'));
    }

    public function testShouldAddArgumentFromConstructor()
    {
        $class = new ClassDefinition();

        $this->assertEmpty($class->getArguments());
        $this->assertFalse($class->hasConstructor());

        $class = new ClassDefinition(array('arg'));

        $this->assertNotEmpty($class->getArguments());
        $this->assertTrue($class->hasArgument('arg'));
        $this->assertTrue($class->hasConstructor());

        $class = new ClassDefinition(array('arg' => 'TypeHint'));
        $arg = $class->getArgument('arg');

        $this->assertEquals('TypeHint', $arg->getTypehint());
    }

    public function testShouldAddProperties()
    {
        $class = new ClassDefinition();

        $this->assertEmpty($class->getProperties());

        $class->addProperty('name');

        $this->assertNotEmpty($class->getProperties());
        $this->assertEquals(1, count($class->getProperties()));
        $this->assertTrue($class->hasProperty('name'));
        $this->assertInstanceOf('Doctrine\Common\CodeGeneration\PropertyDefinition', $class->getProperty('name'));
    }

    public function testShouldAddPropertiesFromConstructor()
    {
        $class = new ClassDefinition(array(), array('property'));

        $this->assertNotEmpty($class->getProperties());
        $this->assertEquals(1, count($class->getProperties()));
        $this->assertTrue($class->hasProperty('property'));
        $this->assertInstanceOf('Doctrine\Common\CodeGeneration\PropertyDefinition', $class->getProperty('property'));

        $class = new ClassDefinition(array(), array('name', 'value'));

        $this->assertNotEmpty($class->getProperties());
        $this->assertEquals(2, count($class->getProperties()));
        $this->assertTrue($class->hasProperty('name'));
        $this->assertTrue($class->hasProperty('value'));
        $this->assertInstanceOf('Doctrine\Common\CodeGeneration\PropertyDefinition', $class->getProperty('name'));
        $this->assertInstanceOf('Doctrine\Common\CodeGeneration\PropertyDefinition', $class->getProperty('value'));
    }
}
