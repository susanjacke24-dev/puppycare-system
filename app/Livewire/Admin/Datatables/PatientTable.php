<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PatientTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Patient::query()->with('user');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')->sortable(),
            Column::make('Mascota', 'pet_name')
                ->label(fn ($row) => $row->pet_display_name)
                ->sortable()
                ->searchable(),
            Column::make('Especie', 'species')->sortable()->searchable(),
            Column::make('Raza', 'breed')->sortable()->searchable(),
            Column::make('Dueño', 'user.name')->sortable()->searchable(),
            Column::make('Telefono', 'user.phone')->sortable(),
            Column::make('Acciones')
                ->label(fn ($row) => view('admin.patients.actions', ['patient' => $row])),
        ];
    }
}
