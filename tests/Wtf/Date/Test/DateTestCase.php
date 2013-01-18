<?php
namespace Wtf\Date\Test;

use Wtf\Date;

class DateTestCase extends \PHPUnit_Framework_TestCase
{
    public function earlierProvider()
    {
        return array(
            array('2012-01-01', new \DateTime('2012-01-02'), true),
            array(null, new \DateTime('1982-05-03'), false)
        );
    }

    public function testSetDateTime()
    {
        $dateTime = new \DateTime('2012-01-01');
        $date = new Date($dateTime);
        $this->assertSame($dateTime, $date->getDate());
    }

    /**
     * @dataProvider earlierProvider
     */
    public function testIsEarlier($date1, $date2, $assertion)
    {
        $wtfDate = new Date($date1);
        if (true === $assertion) {
            $this->assertTrue($wtfDate->isEarlier($date2));
        } else {
            $this->assertFalse($wtfDate->isEarlier($date2));
        }
    }

    public function testLater()
    {
        $date1 = new Date('2013-01-01');
        $date2 = new \DateTime('2012-01-01');

        $this->assertTrue($date1->isLater($date2));
    }

    public static function todayProvider()
    {
        return array(
            array(date('Y-m-d'), true),
            array('2012-01-01', false),
        );
    }

    /**
     * @dataProvider todayProvider
     */
    public function testToday($date, $assertion)
    {
        $date1 = new Date($date);
        if (true === $assertion) {
            $this->assertTrue($date1->isToday());
        } else {
            $this->assertFalse($date1->isToday());
        }
    }

    public static function tomorrowProvider()
    {
        return array(
            array(null, false),
            array(date('Y-m-d', strtotime('tomorrow')), true)
        );
    }

    /**
     * @dataProvider tomorrowProvider
     */
    public function testTomorrow($date, $assertion)
    {
        $date1 = new Date($date);
        if (true === $assertion) {
            $this->assertTrue($date1->isTomorrow());
        } else {
            $this->assertFalse($date1->isTomorrow());
        }
    }

    public function testNow()
    {
        $date = Date::now();
        $this->assertInstanceOf('\Wtf\Date', $date);
        $this->assertInstanceOf('\DateTime', $date->getDate());
    }

    public static function validDateProvider()
    {
        return array(
            array(null, null, false),
            array(new \DateTime(), null, true),
            array(time(), null, true),
            array(strval(time()), null, true),
            array('2012-01-01', 'Y-m-d', true),
            array('2012-02-31', 'Y-m-d', false),
        );
    }

    /**
     * @dataProvider validDateProvider
     */
    public function testIsDate($date, $format, $assertion)
    {
        if (true === $assertion) {
            $this->assertTrue(Date::isDate($date, $format));
        } else {
            $this->assertFalse(Date::isDate($date, $format));
        }
    }

    /**
     *
     * @return array
     */
    public static function addProvider()
    {
        return array(
            array('2012-01-01', array('+1 day', null, null), new \DateTime('2012-01-02')),
            array('2013-03-01 00:00:00', array('+2 week', null, null), new \DateTime('2013-03-15 00:00:00')),
            array('2013-03-04', array(1, 'd', null), new \DateTime('2013-03-05')),
            array('2013-05-01', array('-1 year', null, null), new \DateTime('2012-05-01')),
            array('2013-01-01', array(-5, 'm', null), new \DateTime('2012-08-01')),
        );
    }

    /**
     * @dataProvider addProvider
     */
    public function testAdd($start, array $params, \DateTime $end)
    {
        $date = new Date($start);
        call_user_func_array(array($date, 'add'), $params);

        $this->assertEquals(
            $end->getTimestamp(),
            $date->getDate()->getTimestamp(),
            sprintf(
                "Failed: expected: %s, actual: %s",
                $end->format('c'),
                $date->getDate()->format('c')
            )
        );
    }
}
