<?php

namespace App\Filament\Resources\ProductShippingZoneResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegionsRelationManager extends RelationManager
{
    protected static string $relationship = 'regions';
    protected static ?string $title = 'Regions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('region')->required(),
                Forms\Components\Select::make('zone_id')
                    ->label('Shipping Zone')
                    ->relationship('zone', 'name')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('region')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('region')->sortable()->searchable(),
                \Filament\Tables\Columns\TextColumn::make('zone.name')->label('Zone'),
                \Filament\Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
