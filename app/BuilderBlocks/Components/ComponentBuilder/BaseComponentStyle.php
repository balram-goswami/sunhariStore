<?php

namespace App\BuilderBlocks\Components\ComponentBuilder;

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
    protected array $sections = [];

    public function addSection(callable $section)
    {
        $this->sections[] = $section;
        return $this;
    }

    public function make(): Tabs\Tab
    {
        $schema = array_map( function ($section) {
            [$className, $method] = $section;
            return (new $className)->$method();
        }, $this->sections);
        return Tabs\Tab::make('Style')->schema($schema)
        ->extraAttributes(['class' => 'custom-builder-container-tab-style']);
    }

    public function spacingSection(array $attributes = [])
    {
        return \Filament\Forms\Components\Section::make('Spacing')
            ->extraAttributes(['class' => 'custom-builder-container-spacing-section'])
            ->collapsible()
            ->statePath('style')
            ->schema([
                Split::make([
                    Split::make([
                        TextInput::make('padding.top')->label('Padding Top')->default('0')->numeric(),
                        TextInput::make('padding.right')->label('Padding Right')->default('0')->numeric(),
                        TextInput::make('padding.bottom')->label('Padding Bottom')->default('0')->numeric(),
                        TextInput::make('padding.left')->label('Padding Left')->default('0')->numeric(),
                    ]),
                    Split::make([
                        Select::make('padding.unit')->label('Type')->options([
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
                        TextInput::make('margin.top')->label('Margin Top')->default('0')->numeric(),
                        TextInput::make('margin.right')->label('Margin Right')->default('0')->numeric(),
                        TextInput::make('margin.bottom')->label('Margin Bottom')->default('0')->numeric(),
                        TextInput::make('margin.left')->label('Margin Left')->default('0')->numeric(),
                    ]),
                    Split::make([
                        Select::make('margin.unit')->label('Type')->options([
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

    public function backgroundSection(array $attributes = [])
    {
        return \Filament\Forms\Components\Section::make('Background')
            ->extraAttributes(['class' => 'custom-builder-container-background-section'])
            ->collapsible()
            ->collapsed()
            ->statePath('style')
            ->schema([
                ColorPicker::make('background.color')->label('Background Color'),
                FileUpload::make('background.image')->label('Background Image'),
                ...$attributes,
            ]);
    }

    public function borderSection(array $attributes = [])
    {
        return \Filament\Forms\Components\Section::make('Border')
            ->extraAttributes(['class' => 'custom-builder-container-border-section'])
            ->collapsible()
            ->collapsed()
            ->statePath('style')
            ->schema([
                Split::make([
                    TextInput::make('border.top_radius')->label('Top')->default('0')->numeric(),
                    TextInput::make('border.right_radius')->label('Right')->default('0')->numeric(),
                    TextInput::make('border.bottom_radius')->label('Bottom')->default('0')->numeric(),
                    TextInput::make('border.left_radius')->label('Left')->default('0')->numeric(),
                ]),
                Split::make([
                    TextInput::make('border.radius')->label('Radius')->default('0')->numeric(),
                    TextInput::make('border.width')->label('Width')->default('0')->numeric(),
                    ColorPicker::make('border.color')->label('Color'),
                ]),
                ...$attributes,
            ]);
    }

    public function typographySection(array $attributes = [])
    {
        return \Filament\Forms\Components\Section::make('Typography')
            ->extraAttributes(['class' => 'custom-builder-container-typography-section'])
            ->collapsible()
            ->collapsed()
            ->statePath('style')
            ->schema([
                TextInput::make('font.size')->label('Font Size'),
                TextInput::make('font.weight')->label('Font Weight'),
                ColorPicker::make('font.color')->label('Font Color'),
                ...$attributes,
            ]);
    }
}
