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


class TextEditorComponent
{
    public static function make(): Builder\Block
    {
        return Builder\Block::make(BuilderBlockType::TextEditor->value)
            ->label(Str::headline(BuilderBlockType::TextEditor->name))
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        self::textEditorContent(),
                        self::textEditorStyle(),
                    ])->extraAttributes(['class' => 'custom-builder-container-tabs']),

            ])
            ->columns(1);
    }

    private static function textEditorStyle()
    {
        return (new BaseComponentStyle)
        ->addSection([BaseComponentStyle::class, 'spacingSection'])
        ->addSection([BaseComponentStyle::class, 'backgroundSection'])
        ->addSection([BaseComponentStyle::class, 'borderSection'])
        ->addSection([BaseComponentStyle::class, 'typographySection'])
        ->make();
    }

    private static function textEditorContent()
    {
        return Tabs\Tab::make('Content')
            ->schema([
                RichEditor::make('text_editor')->label('Content'),

                Split::make([

                    Select::make('text_editor_alignment')->label('Alignment')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right',
                            'justify' => 'Justify',
                        ])->default('left'),

                    ColorPicker::make('text_editor_color')->label('Color'),
                ]),
            ]);
    }
}
