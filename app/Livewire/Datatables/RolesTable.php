<?php

namespace App\Livewire\Datatables;

use Illuminate\Support\Facades\Gate;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Spatie\Permission\Models\Role;

class RolesTable extends DataTableComponent
{
    protected $model = Role::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('View')
                        ->title(fn($row) => 'View ')
                        ->location(fn($row) => '#')
                        ->attributes(function ($row) {
                            return [
                                'class' => 'text-blue-500 bg-white px-2 py-1 rounded',
                            ];
                        }),
                    LinkColumn::make('Edit')
                        ->title(fn($row) => 'Edit ')
                        ->location(fn($row) => route('roles.edit', $row->id))
                        ->attributes(function ($row) {
                            return [
                                'class' => 'text-blue-500 bg-white px-2 py-1 rounded',
                            ];
                        }),
                    LinkColumn::make('Delete')
                        ->title(fn($row) => 'Delete ')
                        ->location(fn($row) => "#")
                        ->attributes(function ($row) {
                            return [
                                "wire:click" => "delete($row->id)",
                                "wire:confirm" => "Are you sure you want to delete this role?",
                                'class' => 'text-red-500 bg-white px-2 py-1 rounded ' . (!Gate::allows('delete', $row)
                                    ? 'hidden' : ''),
                            ];
                        }),
                ]),
        ];
    }

    public function delete(int $id)
    {
        $item = $this->model::find($id);
        $item->delete();
    }
}
