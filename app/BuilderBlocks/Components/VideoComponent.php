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
use Illuminate\Support\Str;

class VideoComponent
{
    public static function make(): Builder\Block
    {
        return Builder\Block::make(BuilderBlockType::Video->value)
            ->label(Str::headline(BuilderBlockType::Video->name))
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        self::videoContent(),
                        self::videoStyle(),
                    ])
                    ->extraAttributes(['class' => 'custom-builder-container-tabs']),
            ])
            ->columns(1);
    }

    private static function videoStyle()
    {
        return (new BaseComponentStyle)
        ->addSection([BaseComponentStyle::class, 'spacingSection'])
        ->addSection([BaseComponentStyle::class, 'backgroundSection'])
        ->addSection([BaseComponentStyle::class, 'borderSection'])
        ->addSection([BaseComponentStyle::class, 'typographySection'])
        ->make();
    }

    private static function videoContent()
    {
        return Tabs\Tab::make('Content')
            ->schema([
                Select::make('video_source')
                    ->label('Video Source')
                    ->options([
                        'upload' => 'Upload',
                        'link' => 'YouTube/Vimeo Link',
                    ])
                    ->default('upload')
                    ->reactive(),
                FileUpload::make('video')
                    ->label('Video File')
                    ->visible(fn($get) => $get('video_source') === 'upload'),
                TextInput::make('video_link')
                    ->label('Video Link (YouTube/Vimeo)')
                    ->visible(fn($get) => $get('video_source') === 'link'),
                Split::make([
                    Split::make([
                        TextInput::make('image_width')->numeric()->label('Width'),
                        Select::make('image_width_unit')
                            ->label('Unit')
                            ->options([
                                'px' => 'px',
                                'em' => 'em',
                                'rem' => 'rem',
                                '%' => '%',
                            ])
                            ->default('px'),
                        TextInput::make('image_height')->numeric()->label('Height'),
                        Select::make('image_height_unit')
                            ->label('Unit')
                            ->options([
                                'px' => 'px',
                                'em' => 'em',
                                'rem' => 'rem',
                                '%' => '%',
                            ])
                            ->default('px'),
                    ]),
                ]),
                Split::make([
                    Select::make('image_alignment')
                        ->label('Alignment')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right',
                            'justify' => 'Justify',
                        ])
                        ->default('left'),
                    TextInput::make('image_border_radius')->label('Rounded')->numeric()->default('0'),
                ]),
            ]);
    }
}
