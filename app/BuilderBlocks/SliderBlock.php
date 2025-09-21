<?php

namespace App\BuilderBlocks;

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

class SliderBlock
{
    public static function make(): Builder\Block
    {
        return Builder\Block::make(BuilderBlockType::Slider->value)
            ->label(BuilderBlockType::Slider->name)
            ->schema([
                Repeater::make('slides')
                    ->schema([
                        TextInput::make('heading'),
                        RichEditor::make('description'),

                        Split::make([
                            TextInput::make('button_text'),
                            TextInput::make('button_url'),
                        ])->from('md'),

                        FileUpload::make('background_image'),
                        ColorPicker::make('overlay_color'),
                        
                    ])->addActionAlignment(Alignment::End)->addActionLabel('Add new Slide')
                    ->reorderableWithButtons()->collapsible()->cloneable()
                    ->maxItems(5)
            ])
            ->columns(1);
    }
}
