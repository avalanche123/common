<?php

namespace Doctrine\Tests\Common\CodeGeneration\Dumper;

use Doctrine\Common\CodeGeneration\VisibilityAware;

use Doctrine\Common\CodeGeneration\PropertyDefinition;

use Doctrine\Common\CodeGeneration\ArgumentDefinition;

use Doctrine\Common\CodeGeneration\MethodDefinition;

use Doctrine\Common\CodeGeneration\Dumper\PHPDumper;
use Doctrine\Common\CodeGeneration\ClassDefinition;

class PHPDumperTest extends \PHPUnit_Framework_TestCase
{
    private $fixtureDir;

    protected function setUp()
    {
        $this->fixtureDir = __DIR__.'/Fixtures/';
    }

    public function testShouldDumpClass()
    {
        $dumper      = new PHPDumper();
        $fixturePath = $this->fixtureDir . 'SomeClass.php';
        $class       = new ClassDefinition(array('dm' => 'DocumentManager'), array('name', 'dm'));

        $class->getProperty('name')
            ->setVisibility(VisibilityAware::VISIBILITY_PRIVATE);

        $class->getProperty('dm')
            ->setVisibility(VisibilityAware::VISIBILITY_PRIVATE);

        $class->getArgument('dm')
            ->setDefault(null);

        $class->setConstructor('$this->dm = $dm;');

        $class->addMethod('setName', array('name'))
            ->setBody('$this->name = $name;');

        $this->assertEquals($dumper->dumpClass('SomeClass', $class), file_get_contents($fixturePath), '->dumpClass() should produce correct class body');
    }

    public function testShouldDumpMethod()
    {
        $dumper      = new PHPDumper();
        $setName     = new MethodDefinition(array('name'));

        $setName->setBody('$this->name = $name;');

        $this->assertEquals($dumper->dumpMethod('setName', $setName), file_get_contents($this->fixtureDir . 'setName.php'), '->dumpMethod() should produce correct method body');

        $dumpMethods = new MethodDefinition(array('methods' => 'array'),'private', true);

        $dumpMethods->getArgument('methods')
            ->setDefault(array());

        $dumpMethods->setBody(<<<EOF
foreach (\$methods as \$name => \$method) {
    \$this->dumpMethod(\$name, \$method);
}
EOF
);

        $this->assertEquals($dumper->dumpMethod('dumpMethods', $dumpMethods), file_get_contents($this->fixtureDir . 'dumpMethods.php'), '->dumpMethod() should produce correct method body');
    }

    public function testShouldDumpArgument()
    {
        $dumper   = new PHPDumper();
        $argument = new ArgumentDefinition('DocumentManager');

        $this->assertEquals('DocumentManager $dm', $dumper->dumpArgument('dm', $argument));

        $argument->setDefault(null);

        $this->assertEquals('DocumentManager $dm = null', $dumper->dumpArgument('dm', $argument));
    }

    public function testShouldDumpProperty()
    {
        $dumper =   new PHPDumper();
        $property = new PropertyDefinition();

        $this->assertEquals('public $name;', $dumper->dumpProperty('name', $property));

        $property->setStatic();

        $this->assertEquals('public static $name;', $dumper->dumpProperty('name', $property));
    }
}
