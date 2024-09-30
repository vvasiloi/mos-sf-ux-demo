<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'app_chart')]
    public function index(Request $request, ChartBuilderInterface $chartBuilder): Response
    {
        $month = $request->query->get('month', (new \DateTime())->format('m'));
        $year = $request->query->get('year', (new \DateTime())->format('Y'));

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);

        $data = $this->getRandomMonthlyYieldData($month, $year);

        $chart->setData([
            'labels' => array_keys($data['yield']),
            'datasets' => [
                [
                    'label' => 'Total yield (kwh)',
                    'data' => array_values($data['yield']),
                    'backgroundColor' => '#' . dechex(rand(0x000000, 0xFFFFFF)),
                ]
            ]
        ]);

        $chart->setOptions([
            'responsive' => true,
            'maintainAspect' => false,
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => $data['month'],
                ],
            ],
            'scales' => [
                'yAxes' => [
                    'beginAtZero' => true,
                ],
            ],
        ]);

        return $this->render('chart/index.html.twig', [
            'controller_name' => 'ChartController',
            'chart' => $chart,
        ]);
    }

    /**
     * @return array{'month': string, 'yield': array<string, int>}
     */
    private function getRandomMonthlyYieldData(string $month, string $year): array
    {
        $date = \DateTimeImmutable::createFromFormat('Ymd', $year . $month . '01');
        $prefix = $date->format('Y-m-');
        $lastDay = (int)$date->modify('last day')->format('d');
        $data = [];

        for ($i = 1; $i < $lastDay; $i++) {
            $data[$prefix.$i] = random_int(0, 500);
        }

        return [
            'month' => $date->format('F Y'),
            'yield' => $data,
        ];
    }
}
