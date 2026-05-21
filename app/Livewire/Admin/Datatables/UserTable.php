<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UserTable extends DataTableComponent
{
    // Define el modelo
    public function builder(): Builder
    {
        return User::query()
            ->with('roles');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setConfigurableAreas([
            'table.empty' => 'livewire.tables.empty-users',
        ]);
    }

    public function columns(): array
    {
        return [

            Column::make("Id", "id")
                ->sortable(),

            Column::make("Nombre", "name")
                ->sortable(),

            Column::make("Email", "email")
                ->sortable(),

            Column::make("Número de id", "id_number")
                ->sortable(),

            Column::make("Teléfono", "phone")
                ->sortable(),

            Column::make("Rol", "roles")
                ->label(function ($row) {

                    $role = $row->roles->first()->name ?? 'Sin rol';

                    return $role === 'Paciente'
                        ? 'Dueño'
                        : ($role === 'Doctor'
                            ? 'Veterinario'
                            : $role);
                }),

            Column::make("Acciones")
                ->label(function ($row) {

                    return view('admin.users.actions', [
                        'user' => $row
                    ]);
                }),

        ];
    }
}