<?php

namespace Doctrine\Tests\Common\CodeGeneration;

use Doctrine\Common\CodeGeneration\ArgumentDefinition;

class ArgumentDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldSetDefault()
    {
        $argument = new ArgumentDefinition();
        $this->assertFalse($argument->hasDefault());

        $argument->setDefault(123);
        $this->assertTrue($argument->hasDefault());
        $this->assertEquals(123, $argument->getDefault());
    }

    public function testShouldSetTypehint()
    {
        $argument = new ArgumentDefinition();
        $this->assertNull($argument->getTypehint());

        $argument->setTypehint('SomeClass');
        $this->assertEquals('SomeClass', $argument->getTypehint());

        $argument = new ArgumentDefinition('SomeClass');
        $this->assertEquals('SomeClass', $argument->getTypehint());
    }
}
