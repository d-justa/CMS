<?php

namespace App\Livewire\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Rappasoft\LaravelLivewireTables\Views\Columns\ArrayColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;

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
            Column::make("Email", "email")
                ->sortable(),
            ArrayColumn::make('Roles', 'name')
                ->data(fn($value, $row) => ($row->roles))
                ->outputFormat(fn($index, $value) => "<a href='" . $value->id . "'>" . $value->name . "</a>")
                ->separator('<br />')
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
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
                        ->location(fn($row) => route('users.edit', $row->id))
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
                                "wire:confirm" => "Are you sure you want to delete this package?",
                                'class' => 'text-red-500 bg-white px-2 py-1 rounded',
                            ];
                        }),
                    LinkColumn::make('Impersonate')
                        ->title(fn($row) => 'Impersonate')
                        ->location(fn($row) => route('impersonate.start', $row)) // You will create this route
                        ->attributes(fn($row) => [
                            'class' => 'underline text-green-500 hover:no-underline ' . (!Gate::allows('impersonate', $row)
                                ? 'hidden' : ''),
                        ]),
                ]),
        ];
    }

    public function delete(int $id)
    {
        $item = $this->model::find($id);
        $item->delete();
    }
}
