<?php

declare(strict_types=1);

namespace App\Stats;

final class MonthYieldDataProvider
{
    /**
     * @return array<string, int>
     */
    public function getData(int $year, int $month): array
    {
        $date = date_create_from_format('Y-n-d', sprintf('%d-%d-01', $year, $month));
        $prefix = $date->format('Y-m-');
        $lastDay = (int)$date->modify('last day of this month')->format('d');

        $data = [];

        for ($i = 1; $i <= $lastDay; $i++) {
            $data[$prefix.$i] = random_int(0, 500);
        }

        return $data;
    }
}
