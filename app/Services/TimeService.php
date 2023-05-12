<?php

namespace App\Services;

use Carbon\Carbon;

class TimeService
{
    public function generateTimeRange($startTime, $endTime)
{
    $start = Carbon::createFromFormat('H:i', $startTime);
    $end = Carbon::createFromFormat('H:i', $endTime);

    $timeRange = [];

    while ($start < $end) {
        $timeRange[] = [
            'start' => $start->format('H:i'),
            'end' => $start->addMinutes(15)->format('H:i'),
        ];
    }

    return $timeRange;
}

}