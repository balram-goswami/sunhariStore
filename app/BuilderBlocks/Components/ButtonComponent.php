<?php

namespace App\BuilderBlocks\Components;

use App\BuilderBlocks\Components\ComponentBuilder\BaseComponentStyle;
use App\BuilderBlocks\Enums\BuilderBlockType;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\Alignment;

class ButtonComponent
{
    public static function make(): Builder\Block
    {
        return Builder\Block::make(BuilderBlockType::Button->value)
            ->label(BuilderBlockType::Button->name)
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        self::buttonContent(),
                        self::buttonStyle(),
                    ])
                    ->extraAttributes(['class' => 'custom-builder-container-tabs']),
            ])
            ->columns(1);
    }

    private static function buttonStyle()
    {
        return (new BaseComponentStyle)
            ->addSection([BaseComponentStyle::class, 'spacingSection'])
            ->addSection([BaseComponentStyle::class, 'backgroundSection'])
            ->addSection([BaseComponentStyle::class, 'borderSection'])
            ->addSection([BaseComponentStyle::class, 'typographySection'])
            ->make();
    }

    private static function buttonContent()
    {
        return Tabs\Tab::make('Content')
            ->schema([
                TextInput::make('button_label')->label('Label'),
                Split::make([
                    TextInput::make('button_link')->label('Link'),
                    Select::make('button_target')
                        ->label('Target')
                        ->options([
                            '_self' => 'Self',
                            '_blank' => 'Blank',
                        ])
                        ->default('_self'),
                ]),
                Split::make([
                    Select::make('button_alignment')
                        ->label('Alignment')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right',
                            'justify' => 'Justify',
                        ])
                        ->default('left'),
                    ColorPicker::make('button_color')->label('Text Color'),
                    ColorPicker::make('button_background_color')->label('Background Color'),
                ]),
            ]);
    }
}
