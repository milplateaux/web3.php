<?php

namespace Test\Unit;

use InvalidArgumentException;
use Test\TestCase;
use Web3\Utils;

class UtilsTest extends TestCase
{
    /**
     * testHex
     * 'hello world'
     * you can check by call pack('H*', $hex)
     * 
     * @var string
     */
    protected $testHex = '68656c6c6f20776f726c64';

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * testToHex
     * 
     * @return void
     */
    public function testToHex()
    {
        $hex = Utils::toHex('hello world');

        $this->assertEquals($hex, $this->testHex);

        $hexPrefixed = Utils::toHex('hello world', true);

        $this->assertEquals($hexPrefixed, '0x' . $this->testHex);
    }

    /**
     * testHexToBin
     * 
     * @return void
     */
    public function testHexToBin()
    {
        $str = Utils::hexToBin($this->testHex);

        $this->assertEquals($str, 'hello world');

        $str = Utils::hexToBin('0x' . $this->testHex);

        $this->assertEquals($str, 'hello world');

        $str = Utils::hexToBin('0xe4b883e5bda9e7a59ee4bb99e9b1bc');

        $this->assertEquals($str, '七彩神仙鱼');
    }

    /**
     * testIsZeroPrefixed
     * 
     * @return void
     */
    public function testIsZeroPrefixed()
    {
        $isPrefixed = Utils::isZeroPrefixed($this->testHex);

        $this->assertEquals($isPrefixed, false);

        $isPrefixed = Utils::isZeroPrefixed('0x' . $this->testHex);

        $this->assertEquals($isPrefixed, true);
    }

    /**
     * testStripZero
     * 
     * @return void
     */
    public function testStripZero()
    {
        $str = Utils::stripZero($this->testHex);

        $this->assertEquals($str, $this->testHex);

        $str = Utils::stripZero('0x' . $this->testHex);

        $this->assertEquals($str, $this->testHex);
    }

    /**
     * testSha3
     * 
     * @return void
     */
    public function testSha3()
    {
        $str = Utils::sha3('');

        $this->assertNull($str);

        $str = Utils::sha3('baz(uint32,bool)');

        $this->assertEquals(mb_substr($str, 0, 10), '0xcdcd77c0');
    }

    /**
     * testToWei
     * 
     * @return void
     */
    public function testToWei()
    {
        $bn = Utils::toWei('0x1', 'wei');

        $this->assertEquals($bn->toString(), '1');

        $bn = Utils::toWei('18', 'wei');

        $this->assertEquals($bn->toString(), '18');

        $bn = Utils::toWei(1, 'wei');

        $this->assertEquals($bn->toString(), '1');

        $bn = Utils::toWei(0x11, 'wei');

        $this->assertEquals($bn->toString(), '17');

        $bn = Utils::toWei('1', 'ether');

        $this->assertEquals($bn->toString(), '1000000000000000000');

        $bn = Utils::toWei('0x5218', 'wei');

        $this->assertEquals($bn->toString(), '21016');
    }

    /**
     * testToEther
     * 
     * @return void
     */
    public function testToEther()
    {
        list($bnq, $bnr) = Utils::toEther('0x1', 'wei');

        $this->assertEquals($bnq->toString(), '0');
        $this->assertEquals($bnr->toString(), '1');

        list($bnq, $bnr) = Utils::toEther('18', 'wei');

        $this->assertEquals($bnq->toString(), '0');
        $this->assertEquals($bnr->toString(), '18');

        list($bnq, $bnr) = Utils::toEther(1, 'wei');

        $this->assertEquals($bnq->toString(), '0');
        $this->assertEquals($bnr->toString(), '1');

        list($bnq, $bnr) = Utils::toEther(0x11, 'wei');

        $this->assertEquals($bnq->toString(), '0');
        $this->assertEquals($bnr->toString(), '17');

        list($bnq, $bnr) = Utils::toEther('1', 'kether');

        $this->assertEquals($bnq->toString(), '1000');
        $this->assertEquals($bnr->toString(), '0');

        list($bnq, $bnr) = Utils::toEther('0x5218', 'wei');

        $this->assertEquals($bnq->toString(), '0');
        $this->assertEquals($bnr->toString(), '21016');
    }
}