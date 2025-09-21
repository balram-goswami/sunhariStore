<?php

namespace App\BuilderBlocks\Components;

use App\BuilderBlocks\Enums\BuilderBlockType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Split;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\ColorPicker;
use Illuminate\Support\Str;
use Filament\Forms\Components\Tabs;
use App\BuilderBlocks\Components\ComponentBuilder\BaseComponentStyle;


class ImageComponent
{
    public static function make(): Builder\Block
    {
        return Builder\Block::make(BuilderBlockType::Image->value)
            ->label(Str::headline(BuilderBlockType::Image->name))
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        self::imageContent(),
                        self::imageStyle(),
                    ])->extraAttributes(['class' => 'custom-builder-container-tabs']),
            
            ])
            ->columns(1);
    }

    private static function imageStyle()
    {
        return (new BaseComponentStyle)
        ->addSection([BaseComponentStyle::class, 'spacingSection'])
        ->addSection([BaseComponentStyle::class, 'backgroundSection'])
        ->addSection([BaseComponentStyle::class, 'borderSection'])
        ->addSection([BaseComponentStyle::class, 'typographySection'])
        ->make();
    }

    private static function imageContent()
    {
        return Tabs\Tab::make('Content')
            ->schema([
                FileUpload::make('image')->label('Image'),

                Split::make([
                    Split::make([
                        TextInput::make('image_width')->numeric()->label('Width'),
                        Select::make('image_width_unit')->label('Unit')
                            ->options([
                                'px' => 'px',
                                'em' => 'em',
                                'rem' => 'rem',
                                '%' => '%',
                            ])->default('px'),
                        TextInput::make('image_height')->numeric()->label('Height'),
                        Select::make('image_height_unit')->label('Unit')
                            ->options([
                                'px' => 'px',
                                'em' => 'em',
                                'rem' => 'rem',
                                '%' => '%',
                            ])->default('px'),
                    ]),
                
                ]),

                Split::make([
                    Select::make('image_alignment')->label('Alignment')
                    ->options([
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right',
                        'justify' => 'Justify',
                    ])->default('left'),
                    TextInput::make('image_border_radius')->label('Rounded')->numeric()->default('0'),
                ]),
            ]);
    }
}
