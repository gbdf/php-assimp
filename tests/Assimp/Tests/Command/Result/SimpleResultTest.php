<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Marco Graetsch <magdev3.0@googlemail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author    magdev
 * @copyright 2014 Marco Graetsch <magdev3.0@googlemail.com>
 * @package   php-assimp
 * @license   http://opensource.org/licenses/MIT MIT License
 */

namespace Assimp\Tests\Command\Result;

use Assimp\Command\Result\SimpleResult;
use Assimp\Command\Verbs\VersionVerb;

/**
 * Test for Assimp SimpleResult
 *
 * @author magdev
 */
class SimpleResultTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Assimp\Command\Result
     */
    protected $object;



    /**
     * @see PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp() : void
    {
        $this->object = new SimpleResult();
    }


    /**
     * @see PHPUnit\Framework\TestCase::tearDown()
     */
    protected function tearDown() : void
    {
        $this->object = null;
    }


    /**
     * @covers Assimp\Command\Result::setCommand
     * @covers Assimp\Command\Result::getCommand
     */
    public function testGetSetCommand()
    {
        $command = '/test/command -p';
        $this->assertInstanceOf('\Assimp\Command\Result\SimpleResult', $this->object->setCommand($command));
        $this->assertEquals($command, $this->object->getCommand());
    }


    /**
     * @covers Assimp\Command\Result::isExecuted
     */
    public function testIsExecuted()
    {
        $this->assertFalse($this->object->isExecuted());

        $this->object->setExitCode(1);
        $this->assertFalse($this->object->isExecuted());

        $this->object->setOutput(array('a' => 'b'));
        $this->assertTrue($this->object->isExecuted());
    }


    /**
     * @covers Assimp\Command\Result::isSuccess
     */
    public function testIsSuccess()
    {
        $this->assertFalse($this->object->isSuccess());

        $this->object->setExitCode(1);
        $this->assertFalse($this->object->isSuccess());

        $this->object->setExitCode(0);
        $this->assertTrue($this->object->isSuccess());
    }


    /**
     * @covers Assimp\Command\Result::setVerb
     * @covers Assimp\Command\Result::getVerb
     */
    public function testGetSetVerb()
    {
        $verb = new VersionVerb();
        $this->assertInstanceOf('\Assimp\Command\Result\SimpleResult', $this->object->setVerb($verb));
        $this->assertSame($verb, $this->object->getVerb());
    }


    /**
     * @covers Assimp\Command\Result::setOutput
     * @covers Assimp\Command\Result::getOutput
     * @covers Assimp\Command\Result::getOutputLine
     */
    public function testGetSetOutput()
    {
        $output = array('line1', 'line2');

        $this->assertInstanceOf('\Assimp\Command\Result\SimpleResult', $this->object->setOutput($output));
        $this->assertCount(2, $this->object->getOutput());
        $this->assertEquals('line1', $this->object->getOutputLine(0));
        $this->assertEquals('line2', $this->object->getOutputLine(1));
    }


    /**
     * @covers Assimp\Command\Result::offsetGet
     * @covers Assimp\Command\Result::offsetSet
     * @covers Assimp\Command\Result::offsetExists
     * @covers Assimp\Command\Result::offsetUnset
     * @covers Assimp\Command\Result::count
     */
    public function testArrayAccessCountable()
    {
        $this->object['line1'] = 'line-1';
        $this->object['line2'] = 'line-2';

        $this->assertCount(2, $this->object->getOutput());
        $this->assertEquals('line-1', $this->object['line1']);
        $this->assertEquals('line-2', $this->object['line2']);
        $this->assertArrayHasKey('line1', $this->object);
        $this->assertArrayHasKey('line2', $this->object);

        unset($this->object['line2']);
        $this->assertCount(1, $this->object);
        $this->assertArrayNotHasKey('line2', $this->object);
    }
}