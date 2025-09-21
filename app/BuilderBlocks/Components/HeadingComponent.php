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

class HeadingComponent
{
    public static function make(): Builder\Block
    {
        return Builder\Block::make(BuilderBlockType::Heading->value)
            ->label(BuilderBlockType::Heading->name)
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        self::headingContent(),
                        self::headingStyle(),
                    ])
                    ->extraAttributes(['class' => 'custom-builder-container-tabs']),
            ])
            ->columns(1);
    }

    private static function headingStyle()
    {
        return (new BaseComponentStyle)
            ->addSection([BaseComponentStyle::class, 'spacingSection'])
            ->addSection([BaseComponentStyle::class, 'backgroundSection'])
            ->addSection([BaseComponentStyle::class, 'borderSection'])
            ->addSection([BaseComponentStyle::class, 'typographySection'])
            ->make();
    }

    private static function headingContent()
    {
        return Tabs\Tab::make('Content')
            ->schema([
                TextInput::make('heading_text')->label('Text'),
                Split::make([
                    Select::make('heading_size')
                        ->label('Size')
                        ->options([
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'h5' => 'H5',
                            'h6' => 'H6',
                        ])
                        ->default('h2'),
                    Select::make('heading_alignment')
                        ->label('Alignment')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right',
                            'justify' => 'Justify',
                        ])
                        ->default('left'),
                    ColorPicker::make('heading_color')->label('Color'),
                ]),
            ]);
    }
}
