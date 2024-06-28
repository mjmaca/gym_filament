<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use App\Filament\Widgets\DashboardMemberOverview;
use Filament\Actions;
use App\Models\Branch;
use Carbon\Carbon;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

class ListMembers extends ListRecords
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            DashboardMemberOverview::class
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label("Create Member"),
        ];
    }
}
