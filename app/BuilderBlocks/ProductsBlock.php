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

class ProductsBlock
{
    public static function make(): Builder\Block
    {
        return Builder\Block::make(BuilderBlockType::Product->value)
            ->label(BuilderBlockType::Product->name)
            ->schema([
                
            ])
            ->columns(1);
    }
}
