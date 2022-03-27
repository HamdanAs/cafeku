<?php

namespace App\Http\Livewire;

use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Spatie\Activitylog\Models\Activity;

class ActivitiesTable extends LivewireDatatable
{
    public function builder()
    {
        return Activity::query();
    }

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID'),

            Column::name('causer_id')
                ->searchable()
        ];
    }
}
