<?php
namespace Wtf;

use Wtf\Date\Helper;

/**
 * Replacement for \Zend_Date without the ISO-crap and in fast.
 *
 * @author Till Klampaeckel <till@php.net>
 */
class Date
{
    /**
     * @var mixed|null
     */
    protected $format;

    /**
     * @var mixed|null
     */
    protected $locale;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var int|string|\DateTime
     */
    protected $rawDate;

    /**
     * CTOR
     *
     * @param mixed|null $date
     * @param mixed|null $format
     * @param mixed|null $locale
     *
     * @return \Wtf\Date
     */
    public function __construct($date = null, $format = null, $locale = null)
    {
        $this->locale = $locale;
        $this->setDate($date, $format);
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @param mixed $format
     *
     * @return \Wtf\Date
     */
    public function setDate($date, $format = null)
    {
        if (null === $date) {
            $date = new \DateTime();
        }

        $this->format  = $format;
        $this->rawDate = $date;

        if ($date instanceof \DateTime) {
            $this->date = $date;
            return $this;
        }

        if (null === $format) {
            $this->date = new \DateTime($date);
            return $this;
        }

        $this->date = Helper::convertToDateTime($this->rawDate, $this->format);
        return $this;
    }

    /**
     * Figure out if 'this' date is earlier than the supplied date parameter.
     *
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isEarlier(\DateTime $date)
    {
        if ($date->getTimestamp() > $this->date->getTimestamp()) {
            return true;
        }
        return false;
    }

    /**
     * Figure out if 'this' date is later than the supplied date parameter.
     *
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isLater(\DateTime $date)
    {
        if ($date->getTimestamp() < $this->date->getTimestamp()) {
            return true;
        }
        return false;
    }

    /**
     * Determine if 'this' date is today.
     *
     * @return bool
     */
    public function isToday()
    {
        if (date('Ymd') == $this->date->format('Ymd')) {
            return true;
        }
        return false;
    }

    /**
     * Determine if 'this' date is tomorrow.
     *
     * @return bool
     */
    public function isTomorrow()
    {
        $tomorrow = new \DateTime("tomorrow");
        if ($tomorrow->format('Ymd') == $this->date->format('Ymd')) {
            return true;
        }
        return false;
    }
}