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
        $dateTime = \DateTime::createFromFormat($format, $dateValue);
        if (false === $dateTime) {
            throw new \LogicException(sprintf("Date value '%s' did not parse with format '%s'.", $dateValue, $format));
        }
        return $dateTime;
    }
}
