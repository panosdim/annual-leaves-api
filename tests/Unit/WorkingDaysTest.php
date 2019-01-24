<?php

namespace Tests\Unit;

use DateTime;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\WorkingDays;

class WorkingDaysTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @throws \Exception
     */
    public function testGetOrthodoxEaster()
    {
        $oed2019 = new DateTime();
        $oed2019->setDate(2019, 4, 28);
        $oed2019->setTime(0, 0, 0);
        $this->assertEquals($oed2019, WorkingDays::getOrthodoxEaster(2019));

        $oed2020 = new DateTime();
        $oed2020->setDate(2020, 4, 19);
        $oed2020->setTime(0, 0, 0);
        $this->assertEquals($oed2020, WorkingDays::getOrthodoxEaster(2020));
    }

    public function testGetBankHolidays()
    {
        $year = 2019;
        $newYearEve = DateTime::createFromFormat('U', mktime(0, 0, 0, 1, 1, $year));
        $epiphany = DateTime::createFromFormat('U', mktime(0, 0, 0, 1, 6, $year));
        $cleanMonday = DateTime::createFromFormat('U', mktime(0, 0, 0, 3, 11, $year));
        $independenceDay = DateTime::createFromFormat('U', mktime(0, 0, 0, 3, 25, $year));
        $goodFriday = DateTime::createFromFormat('U', mktime(0, 0, 0, 4, 26, $year));
        $easterMonday = DateTime::createFromFormat('U', mktime(0, 0, 0, 4, 29, $year));
        $labourDay = DateTime::createFromFormat('U', mktime(0, 0, 0, 5, 1, $year));
        $whitMonday = DateTime::createFromFormat('U', mktime(0, 0, 0, 6, 17, $year));
        $assumption = DateTime::createFromFormat('U', mktime(0, 0, 0, 8, 15, $year));
        $ochiDay = DateTime::createFromFormat('U', mktime(0, 0, 0, 10, 28, $year));
        $christmas = DateTime::createFromFormat('U', mktime(0, 0, 0, 12, 25, $year));
        $glorifying = DateTime::createFromFormat('U', mktime(0, 0, 0, 12, 26, $year));

        $holidays = array($newYearEve, $epiphany, $cleanMonday, $independenceDay, $goodFriday, $easterMonday, $labourDay, $whitMonday, $assumption, $ochiDay, $christmas, $glorifying);

        $this->assertEquals($holidays, WorkingDays::getBankHolidays(2019));
    }

    public function testCalculateWorkingDays()
    {
        $from = DateTime::createFromFormat('U', mktime(0, 0, 0, 12, 24, 2018));
        $until = DateTime::createFromFormat('U', mktime(0, 0, 0, 12, 31, 2018));
        $this->assertEquals(4, WorkingDays::calculateWorkingDays($from, $until));

        $from = DateTime::createFromFormat('U', mktime(0, 0, 0, 9, 10, 2018));
        $until = DateTime::createFromFormat('U', mktime(0, 0, 0, 9, 21, 2018));
        $this->assertEquals(10, WorkingDays::calculateWorkingDays($from, $until));

        $from = DateTime::createFromFormat('U', mktime(0, 0, 0, 5, 10, 2018));
        $until = DateTime::createFromFormat('U', mktime(0, 0, 0, 5, 10, 2018));
        $this->assertEquals(1, WorkingDays::calculateWorkingDays($from, $until));

        $from = DateTime::createFromFormat('U', mktime(0, 0, 0, 6, 25, 2018));
        $until = DateTime::createFromFormat('U', mktime(0, 0, 0, 6, 26, 2018));
        $this->assertEquals(2, WorkingDays::calculateWorkingDays($from, $until));
    }
}
