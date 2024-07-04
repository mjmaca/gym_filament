<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use Filament\Pages\Page;
use App\Models\Member;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Forms\Form;


class QRScanner extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = AttendanceResource::class;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static string $view = 'filament.pages.q-r-scanner';

    protected static ?string $navigationLabel = 'Checking Logs';
    protected ?string $heading = 'Checking Logs';

    public $membership_id;

    public $members;

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Attendance::query();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('membership_id')
                    ->label("Membership ID")
                    ->live(onBlur: true)
                    ->debounce(1000) // Debounce of 3 seconds
                    ->autofocus()
                    ->autocomplete(false)
                    ->afterStateUpdated(function ($state) {
                        $this->filterMembers($state);
                        $this->resetForm();

                    }), // Pass a closure here
            ]);
    }

    public function filterMembers($value)
    {
        // Add your filtering logic here
        $this->members = Member::where('membership_id', $value)->first();
    }

    public function resetForm()
    {
        // Reset the form state
        $this->form->fill(['membership_id' => null]);
    }

    public function savedAttendance($data)
    {
        $newAttendance = new Attendance();

        $newAttendance['membership_id'] = $data->membership_id;
        $newAttendance['full_name'] = $data->full_name;
        $newAttendance['branch_location'] = $data->branch_location;
        $newAttendance['is_guest'] = $data->is_guest;
        $newAttendance->save();
    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->label('Logged In')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('full_name')
                ->label('Full Name')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('branch_location')
                ->label('Branch Location')
                ->sortable()
                ->searchable(),

            Tables\Columns\BooleanColumn::make('is_guest')
                ->label('Is Guest')
                ->sortable()
                ->searchable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            // Define your filters here
        ];
    }

    protected function getTableActions(): array
    {
        return [
            // Define your actions here
        ];
    }

    // protected function getTableBulkActions(): array
    // {
    //     return [
    //         Tables\Actions\BulkActionGroup::make([
    //             Tables\Actions\DeleteBulkAction::make(),
    //         ]),
    //     ];
    // }

}
