<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TicketOverviewChart extends ChartWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    protected static ?string $heading = 'Ticket Overview';

    public ?string $filter = 'week';

    protected function getFilters(): ?array
    {
        return [
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    protected function getData(): array
    {
        $start = null;
        $end = null;
        $perData = null;

        switch ($this->filter) {
            case 'week':
                $start = now()->startOfWeek();
                $end = now()->endOfWeek();
                $perData = 'perDay';
            break;

            case 'month':
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                $perData = 'perDay';
            break;

            case 'year':
                $start = now()->startOfYear();
                $end = now()->endOfYear();
                $perData = 'perMonth';
            break;
        }
         
        $data = Trend::model(Ticket::class)
        ->between(
            start: $start,
            end: $end,
        )

        ->$perData()
        ->count();
 
        return [
            'datasets' => [
                [
                    'label' => 'Ticket data',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
