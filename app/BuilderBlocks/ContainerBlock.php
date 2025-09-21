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
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use App\BuilderBlocks\Components\HeadingComponent;
use App\BuilderBlocks\Components\TextEditorComponent;
use App\BuilderBlocks\Components\ImageComponent;
use App\BuilderBlocks\Components\ButtonComponent;
use App\BuilderBlocks\Components\VideoComponent;
use App\BuilderBlocks\Components\HtmlComponent;
use App\BuilderBlocks\Components\ComponentBuilder\BaseComponentStyle;

class ContainerBlock
{
    public static function make(): Builder\Block
    {
        return Builder\Block::make(BuilderBlockType::Container->value)
            ->label(BuilderBlockType::Container->name)
            ->schema([

                Tabs::make('Tabs')
                    ->tabs([
                        self::containerContent(),
                        self::containerStyle(),
                    ])->extraAttributes(['class' => 'custom-builder-container-tabs']),
            ])
            ->extraAttributes(['class' => 'custom-builder-container'])
            ->columns(1);
    }

    private static function containerStyle()
    {
        return (new BaseComponentStyle)
            ->addSection([BaseComponentStyle::class, 'spacingSection'])
            ->addSection([BaseComponentStyle::class, 'backgroundSection'])
            ->addSection([BaseComponentStyle::class, 'borderSection'])
            ->addSection([BaseComponentStyle::class, 'typographySection'])
            ->make();
    }

    private static function containerContent()
    {
        return Tabs\Tab::make('Content')
            ->schema([
                Forms\Components\Select::make('columns')
                    ->label('Number of Blocks')
                    ->options(array_combine(range(1, 12), range(1, 12)))
                    ->reactive()
                    ->afterStateUpdated(
                        fn($state, callable $set) =>
                        $set('blocks', array_fill(0, $state, [])) // initialize empty layouts
                    )
                    ->hidden(fn($get) => $get('columns') !== null),

                Forms\Components\Repeater::make('blocks')
                    ->label('Blocks')
                    ->schema([
                        Tabs::make('Tabs')->tabs([
                                self::BlockContent(),
                                self::BlockStyle()
                            ])->extraAttributes(['class' => 'custom-block-repeator-tabs']),
                    ])
                    ->hidden(fn($get) => $get('columns') === null)
                    ->extraAttributes(['class' => 'custom-block-repeator'])
                    ->cloneable()
                    ->addActionLabel('Add new Block')
                    ->collapsible()
                    ->columns(1),
            ]);
    }

    private static function BlockStyle()
    {
        return (new BaseComponentStyle)
            ->addSection([BaseComponentStyle::class, 'spacingSection'])
            ->addSection([BaseComponentStyle::class, 'backgroundSection'])
            ->addSection([BaseComponentStyle::class, 'borderSection'])
            ->addSection([BaseComponentStyle::class, 'typographySection'])
            ->make();
    }

    private static function BlockContent()
    {
        return Tabs\Tab::make('Block Setting')
            ->schema([
                Builder::make('components')->label('')
                    ->blocks(self::BlockComponent())
                    ->addActionLabel('Add Component')
                    ->reorderableWithButtons()
                    ->collapsible()
                    ->blockNumbers(false)
                    //->collapsed()
                    ->cloneable()
                    ->extraAttributes(['class' => 'custom-block-component'])
            ]);
    }

    private static function BlockComponent()
    {
        return [
            HeadingComponent::make(),
            TextEditorComponent::make(),
            ImageComponent::make(),
            ButtonComponent::make(),
            VideoComponent::make(),
            HtmlComponent::make(),
        ];
    }
}
