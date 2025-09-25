<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $navigationLabel = 'Slider';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label('Slider Image')
                    ->image()
                    ->directory('sliders')
                    ->required(false),

                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\Textarea::make('text')
                    ->label('Description')
                    ->rows(3),

                Forms\Components\TextInput::make('button_text')
                    ->label('Button Text')
                    ->maxLength(255),

                Forms\Components\TextInput::make('button_link')
                    ->label('Button Link')
                    ->maxLength(255),

                Forms\Components\Toggle::make('status')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->size(60),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('text')
                    ->label('Text')
                    ->limit(50),

                Tables\Columns\TextColumn::make('button_text')
                    ->label('Button Text'),

                Tables\Columns\TextColumn::make('button_link')
                    ->label('Button Link')
                    ->openUrlInNewTab(),

                Tables\Columns\ToggleColumn::make('status') // 👈 switch toggle
        ->label('Active / Inactive'),

            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Status'),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
