<?php
namespace Wtf\Date;

class Helper
{
    /**
     * Creates a DateTime object from the input.
     *
     * @param mixed $dateValue
     * @param mixed $format
     *
     * @return \DateTime
     */
    public static function convertToDateTime($dateValue, $format = null)
    {
        if (null === $format) {
            return new \DateTime($dateValue);
        }
        return \DateTime::createFromFormat($format, $dateValue);
    }
}