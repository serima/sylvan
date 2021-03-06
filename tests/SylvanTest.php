<?php
use Serima\Sylvan\Sylvan;

class SylvanTest extends PHPUnit_Framework_TestCase {

    public function testSylvan_getInputFilename_success()
    {
        $sylvan = new Sylvan();
        $expected = './data/jp/paid.json';
        $actual = $sylvan->getInputFilename('jp', 'paid');
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Not found input file. (./data/xx/xxxx.json)
     */
    public function testSylvan_getInputFilename_exception()
    {
        $sylvan = new Sylvan();
        $sylvan->getInputFilename('xx', 'xxxx');
    }

    public function testSylvan_getUrl_success()
    {
        $sylvan = new Sylvan();
        $expected = "http://itunes.apple.com/jp/rss/topfreeapplications/limit=100/genre=6021/json";
        $actual = $sylvan->getUrl('jp', 'free', 'newsstand');
        $this->assertSame($expected, $actual);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Not found specified genre. (xxxx)
     */
    public function testSylvan_getUrl_exception()
    {
        $sylvan = new Sylvan();
        $sylvan->getUrl('jp', 'free', 'xxxx');
    }
}