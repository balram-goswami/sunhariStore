<?php

namespace App\BuilderBlocks\Components;

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

class BaseComponentStyle
{
    public static function make(): Tabs\Tab
    {
        return Tabs\Tab::make('Style')
            ->schema([
                self::spacingSection(),
                self::backgroundSection(),
                self::borderSection(),
               // self::typographySection(),
            ])
            ->extraAttributes(['class' => 'custom-builder-container-tab-style']);
    }

    public static function spacingSection(array $attributes = [])
    {
        return \Filament\Forms\Components\Section::make('Spacing')
            ->extraAttributes(['class' => 'custom-builder-container-spacing-section'])
            ->collapsible()
            ->schema([
                Split::make([
                    Split::make([
                        TextInput::make('padding_top')->label('Padding Top')->default('0')->numeric(),
                        TextInput::make('padding_right')->label('Padding Right')->default('0')->numeric(),
                        TextInput::make('padding_bottom')->label('Padding Bottom')->default('0')->numeric(),
                        TextInput::make('padding_left')->label('Padding Left')->default('0')->numeric(),
                    ]),
                    Split::make([
                        Select::make('padding_right_unit')->label('Type')->options([
                            'px' => 'px',
                            'em' => 'em',
                            'rem' => 'rem',
                            'vw' => 'vw',
                            'vh' => 'vh',
                        ])->maxWidth('100px')->default('px'),
                    ]),
                ]),
                Split::make([
                    Split::make([
                        TextInput::make('margin_top')->label('Margin Top')->default('0')->numeric(),
                        TextInput::make('margin_right')->label('Margin Right')->default('0')->numeric(),
                        TextInput::make('margin_bottom')->label('Margin Bottom')->default('0')->numeric(),
                        TextInput::make('margin_left')->label('Margin Left')->default('0')->numeric(),
                    ]),
                    Split::make([
                        Select::make('margin_top_unit')->label('Type')->options([
                            'px' => 'px',
                            'em' => 'em',
                            'rem' => 'rem',
                            'vw' => 'vw',
                            'vh' => 'vh',
                        ])->maxWidth('100px')->default('px'),
                    ]),
                ]),
                ...$attributes,
            ]);
    }

    public static function backgroundSection(array $attributes = [])
    {
        return \Filament\Forms\Components\Section::make('Background')
            ->extraAttributes(['class' => 'custom-builder-container-background-section'])
            ->collapsible()
            ->collapsed()
            ->schema([
                ColorPicker::make('background_color')->label('Background Color'),
                FileUpload::make('background_image')->label('Background Image'),
                ...$attributes,
            ]);
    }

    public static function borderSection(array $attributes = [])
    {
        return \Filament\Forms\Components\Section::make('Border')
            ->extraAttributes(['class' => 'custom-builder-container-border-section'])
            ->collapsible()
            ->collapsed()
            ->schema([
                Split::make([
                    TextInput::make('border_top_radius')->label('Top')->default('0')->numeric(),
                    TextInput::make('border_right_radius')->label('Right')->default('0')->numeric(),
                    TextInput::make('border_bottom_radius')->label('Bottom')->default('0')->numeric(),
                    TextInput::make('border_left_radius')->label('Left')->default('0')->numeric(),
                ]),
                Split::make([
                    TextInput::make('border_radius')->label('Radius')->default('0')->numeric(),
                    TextInput::make('border_width')->label('Width')->default('0')->numeric(),
                    ColorPicker::make('border_color')->label('Color'),
                ]),
                ...$attributes,
            ]);
    }

    // public static function typographySection(array $attributes = [])
    // {
    //     return \Filament\Forms\Components\Section::make('Typography')
    //         ->extraAttributes(['class' => 'custom-builder-container-typography-section'])
    //         ->collapsible()
    //         ->collapsed()
    //         ->schema([
    //             TextInput::make('font_size')->label('Font Size'),
    //             TextInput::make('font_weight')->label('Font Weight'),
    //             ColorPicker::make('font_color')->label('Font Color'),
    //             ...$attributes,
    //         ]);
    // }
}
