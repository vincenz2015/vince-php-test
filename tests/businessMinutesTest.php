<?php
require 'api.php';

use PHPUnit\Framework\TestCase;

class BusinessMinutesTest extends TestCase
{
    public function testBusinessMinutesCalculation()
    {
        $GLOBALS['BUSINESS_START_TIME'] = '9:00';
        $GLOBALS['BUSINESS_END_TIME'] = '17:00';

        // Example 1: 9AM to 11AM on weekdays (120 minutes)
        $startDateTime1 = (new DateTime('2023-06-19 09:00'))->getTimestamp();
        $endDateTime1 = (new DateTime('2023-06-19 11:00'))->getTimestamp();
        $expectedMinutes1 = 120;
        $businessMinutes1 = calculateBusinessMinutes($startDateTime1, $endDateTime1);
        $this->assertEquals($expectedMinutes1, $businessMinutes1);

        // Example 2: 7AM to 9:15AM on weekdays (15 minutes)
        $startDateTime2 = (new DateTime('2023-06-19 07:00'))->getTimestamp();
        $endDateTime2 = (new DateTime('2023-06-19 09:15'))->getTimestamp();
        $expectedMinutes2 = 15;
        $businessMinutes2 = calculateBusinessMinutes($startDateTime2, $endDateTime2);
        $this->assertEquals($expectedMinutes2, $businessMinutes2);

        // Example 3: 18 June 2023 (Sunday) - 9AM to 11AM - Not including weekends (0 minutes)
        $startDateTime3 = (new DateTime('2023-06-18 09:00 AM'))->getTimestamp();
        $endDateTime3 = (new DateTime('2023-06-18 11:00 AM'))->getTimestamp();
        $expectedMinutes3 = 0;
        $businessMinutes3 = calculateBusinessMinutes($startDateTime3, $endDateTime3, false);
        $this->assertEquals($expectedMinutes3, $businessMinutes3);

        // Example 3: 18 June 2023 (Sunday) - 9AM to 11AM - Allow for including weekends (120 minutes)
        $startDateTime3 = (new DateTime('2023-06-18 09:00 AM'))->getTimestamp();
        $endDateTime3 = (new DateTime('2023-06-18 11:00 AM'))->getTimestamp();
        $expectedMinutes3 = 120;
        $businessMinutes3 = calculateBusinessMinutes($startDateTime3, $endDateTime3, true);
        $this->assertEquals($expectedMinutes3, $businessMinutes3);

    }
}
