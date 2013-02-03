<?php
namespace Wtf\Date\Test\Date;

use \Wtf\Date\Helper;

class HelperTestCase extends \PHPUnit_Framework_TestCase
{
    public static function dateProvider()
    {
        return array(
            array(null, new \DateTime(), null),
            array('2012-01-01', new \DateTime('2012-01-01'), null),
            array('00:00:00 01-01-2012', new \DateTime('2012-01-01'), 'H:i:s d-m-Y'),
        );
    }

    /**
     * @dataProvider dateProvider
     */
    public function testDate($dateStr, $dateTime, $format)
    {
        $date = Helper::convertToDateTime($dateStr, $format);
        $this->assertEquals($date->format('c'), $dateTime->format('c'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testWrongFormat()
    {
        Helper::convertToDateTime('2010-01-23 11:23:23', 'Y-m-d');
    }
}
