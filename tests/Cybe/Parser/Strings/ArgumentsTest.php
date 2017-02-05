<?php

namespace MemMemov\Cybe\Parser\Strings;

class ArgumentsTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $categories;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $complements;

    protected function setUp()
    {
        $this->categories = $this->getMockBuilder(Categories::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->complements = $this->getMockBuilder(Compliments::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItCreatesArgument()
    {
        $arguments = new Arguments($this->categories, $this->complements);

        $string = 'что:диагноз';

        $result = $arguments->create($string);

        $this->assertInstanceOf(Argument::class, $result);
    }
}