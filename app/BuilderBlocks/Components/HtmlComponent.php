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
use Filament\Forms\Components\Tabs;
use App\BuilderBlocks\Components\ComponentBuilder\BaseComponentStyle;

class HtmlComponent
{
    public static function make(): Builder\Block
    {
        return Builder\Block::make(BuilderBlockType::Html->value)
            ->label(BuilderBlockType::Html->name)
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        self::htmlContent(),
                        self::htmlStyle(),
                    ])->extraAttributes(['class' => 'custom-builder-container-tabs']),
            ])
            ->columns(1);
    }

    private static function htmlStyle()
    {
        return (new BaseComponentStyle)
        ->addSection([BaseComponentStyle::class, 'spacingSection'])
        ->addSection([BaseComponentStyle::class, 'backgroundSection'])
        ->addSection([BaseComponentStyle::class, 'borderSection'])
        ->addSection([BaseComponentStyle::class, 'typographySection'])
        ->make();
    }

    private static function htmlContent()
    {
        return Tabs\Tab::make('Content')
            ->schema([
                Textarea::make('html_content')->label('HTML')->rows(10),
            ]);
    }
}
