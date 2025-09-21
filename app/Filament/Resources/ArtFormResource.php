<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtFormResource\Pages;
use App\Models\ArtForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Enums\UserRoles;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class ArtFormResource extends Resource
{
    protected static ?string $model = ArtForm::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        // return $user && (
        //     $user->hasRole(UserRoles::Admin) ||
        //     $user->hasRole(UserRoles::Manager)
        // );
        return false;
    }

    // public static function getNavigationBadge(): ?string
    // {
    //     $user = Auth::user();
    //     $query = static::getModel()::query();

    //     if ($tenantId = Session::get('tenant_id')) {
    //         $query->whereJsonContains('domain_id', (string) $tenantId);
    //     }

    //     if ($user->hasRole(UserRoles::Admin)) {
    //         return $query->count();
    //     }

    //     return $query->where('user_id', $user->id)->count();
    // }

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $isTenant = $user->hasRole(UserRoles::Manager);

        $statusField = [];
        if ($user->hasRole(UserRoles::Admin)) {
            $statusField[] = Forms\Components\Select::make('status')
                ->options([
                    'pending'     => 'Pending',
                    'in-progress' => 'In Progress',
                    'complete'    => 'Complete',
                    'delivered'   => 'Delivered',
                    'paid'        => 'Paid',
                    'un-paid'     => 'Un Paid',
                ])
                ->required();
        }

        return $form->schema([
            Forms\Components\Hidden::make('user_id')->default(Auth::id()),

            Forms\Components\Placeholder::make('tenant_notice')
                ->content('✅ Your request was approved by admin and is currently being worked on.')
                ->visible(
                    fn($livewire) =>
                    $isTenant &&
                        $livewire->record &&
                        $livewire->record->status !== 'pending'
                )
                ->disableLabel(),

            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\Group::make([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->disabled(
                                fn($livewire) =>
                                $isTenant && $livewire->record && $livewire->record->status !== 'pending'
                            ),

                        Forms\Components\TextInput::make('qty')
                            ->required()
                            ->disabled(
                                fn($livewire) =>
                                $isTenant && $livewire->record && $livewire->record->status !== 'pending'
                            ),

                        Forms\Components\RichEditor::make('description')
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                            ])
                            ->disabled(
                                fn($livewire) =>
                                $isTenant && $livewire->record && $livewire->record->status !== 'pending'
                            ),
                    ]),
                    Forms\Components\Group::make(array_merge(
                        $statusField,
                        [
                            Forms\Components\FileUpload::make('image')
                                ->directory('products')
                                ->multiple()
                                ->maxParallelUploads(5)
                                ->disabled(
                                    fn($livewire) =>
                                    $isTenant && $livewire->record && $livewire->record->status !== 'pending'
                                ),
                        ]
                    )),

                ]),
        ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->size(50),
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('qty')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('status')->sortable()->searchable(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                if ($user->hasRole(UserRoles::Admin)) {
                    return $query;
                }

                return $query->where('user_id', $user->id);
            })
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListArtForms::route('/'),
            'create' => Pages\CreateArtForm::route('/create'),
            'edit' => Pages\EditArtForm::route('/{record}/edit'),
        ];
    }
}
