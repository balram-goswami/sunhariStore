<?php

namespace App\Filament\Clusters\WebContent\Resources;

use App\BuilderBlocks\ChildBuilderBlock;
use App\BuilderBlocks\ContainerBlock;
use App\BuilderBlocks\Components\HtmlComponent;
use App\BuilderBlocks\ProductsBlock;
use App\BuilderBlocks\SliderBlock;
use App\BuilderBlocks\TestimonialBlock;
use App\Filament\Clusters\WebContent;
use App\Filament\Clusters\WebContent\Resources\PageResource\Pages;
use App\Filament\Clusters\WebContent\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Models\Enums\UserRoles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = WebContent::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->rules([
                        function (\Filament\Forms\Get $get, ?Model $record) {
                            return Rule::unique('pages', 'title')
                                ->where('user_id', auth()->id())
                                ->ignore($record?->id);
                        }
                    ]),

                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => Auth::id())
                    ->dehydrated(),

                \Filament\Forms\Components\Builder::make('layout')->label('')->blocks([
                    ContainerBlock::make(),
                    SliderBlock::make(),
                    TestimonialBlock::make(),
                    ProductsBlock::make(),
                    HtmlComponent::make(),
                ])
                    ->addActionLabel('Add new Container')
                    ->blockNumbers(false)
                    ->extraAttributes(['class' => 'custom-section-builder-container'])
                    ->reorderableWithButtons()
                    ->collapsible()
                    ->collapsed()
                    ->cloneable()
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Page Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->sortable()->searchable(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                if ($user->hasRole(UserRoles::Admin)) {
                    return $query;
                }

                return $query->where('user_id', $user->id);
            })
            ->actions([
                Tables\Actions\EditAction::make(),

                Action::make('preview')
                    ->label('Preview')
                    ->url(function ($record): string {
                        $user = Auth::user();
                        $tenant = Tenant::where('user_id', $user->id)
                            ->value('domain'); // shorter than get()->first()

                        if (!$tenant) {
                            return '#';
                        }

                        return 'http://' . $tenant . '/preview/' . $record->slug;
                    })
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->openUrlInNewTab()
                    ->visible(function ($record) {
                        $user = auth()->user();

                        return $user->hasRole(UserRoles::Manager);
                    }),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
