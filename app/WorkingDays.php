<?php

namespace App;


use DateInterval;
use DateTime;

class WorkingDays
{
    public static function getOrthodoxEaster($year)
    {
        $oed = new DateTime();

        $r1 = $year % 4;
        $r2 = $year % 7;
        $r3 = $year % 19;
        $r4 = (19 * $r3 + 15) % 30;
        $r5 = (2 * $r1 + 4 * $r2 + 6 * $r4 + 6) % 7;
        $days = $r5 + $r4 + 13;

        if ($days > 39) {
            $days = $days - 39;
            $oed->setDate($year, 5, $days);
            $oed->setTime(0, 0, 0);
        } else if ($days > 9) {
            $days = $days - 9;
            $oed->setDate($year, 4, $days);
            $oed->setTime(0, 0, 0);
        } else {
            $days = $days + 22;
            $oed->setDate($year, 3, $days);
            $oed->setTime(0, 0, 0);
        }
        return $oed;
    }

    public static function getBankHolidays($year)
    {
        $newYearEve = DateTime::createFromFormat('U', mktime(0, 0, 0, 1, 1, $year));
        $epiphany = DateTime::createFromFormat('U', mktime(0, 0, 0, 1, 6, $year));
        $easter = WorkingDays::getOrthodoxEaster($year);
        $cleanMonday = clone $easter;
        $cleanMonday->sub(DateInterval::createFromDateString('48 days'));
        $independenceDay = DateTime::createFromFormat('U', mktime(0, 0, 0, 3, 25, $year));
        $goodFriday = clone $easter;
        $goodFriday->sub(DateInterval::createFromDateString('2 days'));
        $easterMonday = clone $easter;
        $easterMonday->add(DateInterval::createFromDateString('1 days'));
        $labourDay = DateTime::createFromFormat('U', mktime(0, 0, 0, 5, 1, $year));
        $whitMonday = clone $easter;
        $whitMonday->add(DateInterval::createFromDateString('50 days'));
        $assumption = DateTime::createFromFormat('U', mktime(0, 0, 0, 8, 15, $year));
        $ochiDay = DateTime::createFromFormat('U', mktime(0, 0, 0, 10, 28, $year));
        $christmas = DateTime::createFromFormat('U', mktime(0, 0, 0, 12, 25, $year));
        $glorifying = DateTime::createFromFormat('U', mktime(0, 0, 0, 12, 26, $year));

        $holidays = array($newYearEve, $epiphany, $cleanMonday, $independenceDay, $goodFriday, $easterMonday, $labourDay, $whitMonday, $assumption, $ochiDay, $christmas, $glorifying);

        return $holidays;
    }

    public static function calculateWorkingDays(DateTime $startDate, DateTime $endDate)
    {
        $workDays = 0;
        $nonWorkingDays = WorkingDays::getBankHolidays($startDate->format('Y'));
        do {
            if ($startDate->format('N') != 6 && $startDate->format('N') != 7 && !in_array($startDate, $nonWorkingDays)) {
                $workDays++;
            }

            $startDate->add(DateInterval::createFromDateString('1 day'));
        } while ($startDate <= $endDate);


        return $workDays;
    }
}