<?php

namespace App\Filament\Resources\MemberResource\Widgets;

use Filament\Widgets\ChartWidget;

class MembersChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
