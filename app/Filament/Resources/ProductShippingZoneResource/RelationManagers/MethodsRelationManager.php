<?php

namespace App\Filament\Resources\ProductShippingZoneResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MethodsRelationManager extends RelationManager
{
    protected static string $relationship = 'methods';
    protected static ?string $title = 'Methods';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')->required()->columnSpanFull(),
            Forms\Components\Textarea::make('about')->rows(2)->required()->columnSpanFull(),
            Forms\Components\TextInput::make('deliver')->numeric()->required(),
            Forms\Components\Select::make('type')
                ->options([
                    'flat' => 'Flat Rate',
                    'free' => 'Free Shipping',
                ])
                ->required(),
            Forms\Components\TextInput::make('tax')->required(),
            Forms\Components\TextInput::make('min_amount')->numeric()->default(0),
            Forms\Components\TextInput::make('discount')->numeric()->required(),
            
            Forms\Components\Select::make('zone_id')
                ->label('Shipping Zone')
                ->relationship('zone', 'name')
                ->required(),
                Forms\Components\Toggle::make('status')->label('Active')->default(true)->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('type')->sortable(),
                \Filament\Tables\Columns\TextColumn::make('tax'),
                \Filament\Tables\Columns\TextColumn::make('min_amount'),
                \Filament\Tables\Columns\TextColumn::make('zone.name')->label('Zone'),
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
