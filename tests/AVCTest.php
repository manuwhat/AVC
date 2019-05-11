<?php
namespace{
    require($dir=dirname(__DIR__)).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'AVC.php';
    require $dir.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'AVCiterator.php';
    require $dir.DIRECTORY_SEPARATOR.'AVC.php';

    use PHPUnit\Framework\TestCase;

    class AVCTest extends TestCase
    {
        public function testCountValues()
        {
            $x=count_values(array_merge(range(0, 5), array(array()), array(array()), array(array(6))), true);
            $y=array_merge(range(0, 5), range(0, 5), range(0, 9));
            $this->assertTrue((json_encode($x))==="[[0,1],[1,1],[2,1],[3,1],[4,1],[5,1],[[],2],[[6],1]]");
            $this->assertTrue(3===value_count(3, $y));
            $this->assertTrue(10===count_diff_values($y));
            $this->assertTrue(array_count_values($y)===count_values($y));
        }
    }
}
