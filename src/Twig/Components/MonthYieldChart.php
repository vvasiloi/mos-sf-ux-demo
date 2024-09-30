<?php

declare(strict_types=1);

namespace App\Twig\Components;

use App\Stats\MonthYieldDataProvider;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
class MonthYieldChart
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public int $year;

    #[LiveProp(writable: true)]
    public int $month;

    public function __construct(
        private readonly ChartBuilderInterface $chartBuilder,
        private readonly MonthYieldDataProvider $dataProvider,
    ) {
        $this->year = (int)date('Y');
        $this->month = (int)date('n');
    }

    #[ExposeInTemplate]
    public function getChart(): Chart
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $data = $this->dataProvider->getData($this->year, $this->month);
        $chart->setData([
            'labels' => array_keys($data),
            'datasets' => [
                [
                    'label' => 'Total yield (kwh)',
                    'data' => array_values($data),
                    'backgroundColor' => '#'.dechex(rand(0x000000, 0xFFFFFF)),
                ],
            ],
        ]);

        $chart->setOptions([
            'responsive' => true,
            'maintainAspect' => false,
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => date_format(date_create_from_format('!Yn', $this->year.$this->month), 'F Y'),
                ],
            ],
            'scales' => [
                'yAxes' => [
                    'beginAtZero' => true,
                ],
            ],
        ]);

        return $chart;
    }

    #[ExposeInTemplate]
    public function getYears(): array
    {
        $currentYear = (int)date('Y');
        $range = range($currentYear, $currentYear - 9);

        return array_combine($range, $range);
    }

    #[ExposeInTemplate]
    public function getMonths(): array
    {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = date_format(date_create_from_format('!n', (string)$i), 'F');
        }

        return $months;
    }
}
