<?php

namespace App\Filament\Resources\AttributeResource;

use Filament\Forms;
use App\Models\Enums\UserRoles;
use App\Models\Tenant;
use Illuminate\Validation\Rule;


class AttributeForm
{
    public static function make()
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->unique()
                ->required(),

            Forms\Components\Repeater::make('attribute_values')
                ->label('Attribute Values')
                ->relationship('values')
                ->schema([
                    Forms\Components\TextInput::make('value')
                        ->label('Value')
                        ->required()
                        ->unique(ignoreRecord: true),
                ])
                ->defaultItems(1)
                ->minItems(1)
                ->maxItems(50)
                ->addActionLabel('Add new Attribute Value')
                ->columns(1),

        ];
    }
}
