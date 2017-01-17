<?php

use FSalehpour\PHPPackageSkeleton\SampleClass;


class SampleClassTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_returns_exception_if_mobile_is_not_array()
    {
        $n = new Shayanadc\PayamResan\PayamResan();
        $n->validateParams('asgasg','2214');
    }
    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_returns_exception_if_mobile_is_not_valid_number()
    {
        $n = new Shayanadc\PayamResan\PayamResan();
        $n->validateParams(['93977301081424','109112718982'],'2214');
    }
}
