<?php

namespace Doctrine\Tests\Common\CodeGeneration;

use Doctrine\Common\CodeGeneration\VisibilityAware;

use Doctrine\Common\CodeGeneration\MethodDefinition;

class MethodDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldAddArguments()
    {
        $method = new MethodDefinition();

        $this->assertEmpty($method->getArguments());

        $method->addArgument('arg');

        $this->assertNotEmpty($method->getArguments());
        $this->assertTrue($method->hasArgument('arg'));
        $this->assertInstanceOf('Doctrine\Common\CodeGeneration\ArgumentDefinition', $method->getArgument('arg'));

        $method->addArgument('name', 'String');
        $name = $method->getArgument('name');
        $this->assertEquals('String', $name->getTypehint());

        $this->assertEquals(2, count($method->getArguments()));
    }

    public function testShouldAddArgumentsFromConstructor()
    {
        $method = new MethodDefinition(array('name', 'value' => 'SomeClass'));

        $this->assertNotEmpty($method->getArguments());
        $this->assertEquals(2, count($method->getArguments()));
        $this->assertTrue($method->hasArgument('name'));
        $this->assertTrue($method->hasArgument('value'));
        $this->assertInstanceOf('Doctrine\Common\CodeGeneration\ArgumentDefinition', $method->getArgument('name'));

        $value = $method->getArgument('value');

        $this->assertInstanceOf('Doctrine\Common\CodeGeneration\ArgumentDefinition', $value);
        $this->assertEquals('SomeClass', $value->getTypehint());
    }

    public function testShouldSetBody()
    {
        $body   = 'throw new \Exception();';
        $method = new MethodDefinition();

        $this->assertEmpty($method->getBody());

		$method->setBody($body);

        $this->assertNotEmpty($method->getBody());
        $this->assertEquals($body, $method->getBody());
    }

    public function testShouldBeVisibilityAware()
    {
        $method = new MethodDefinition(array(), VisibilityAware::VISIBILITY_PROTECTED);

        $this->assertFalse($method->isStatic());
        $this->assertEquals(VisibilityAware::VISIBILITY_PROTECTED, $method->getVisibility());

        $method->setVisibility(VisibilityAware::VISIBILITY_PUBLIC);
        $method->setStatic();

        $this->assertTrue($method->isStatic());
        $this->assertEquals(VisibilityAware::VISIBILITY_PUBLIC, $method->getVisibility());

        $method = new MethodDefinition(array(), VisibilityAware::VISIBILITY_PRIVATE, true);

        $this->assertTrue($method->isStatic());
        $this->assertEquals(VisibilityAware::VISIBILITY_PRIVATE, $method->getVisibility());

        $method = new MethodDefinition();
        $this->assertFalse($method->isStatic());
        $this->assertEquals(VisibilityAware::VISIBILITY_PUBLIC, $method->getVisibility());
    }
}
