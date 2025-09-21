<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductCouponResource\Pages;
use App\Filament\Resources\ProductCouponResource\RelationManagers;
use App\Models\ProductCoupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Enums\UserRoles;
use Illuminate\Support\Facades\Session;
use App\Models\Tenant;  

class ProductCouponResource extends Resource
{
    protected static ?string $model = ProductCoupon::class;
    protected static ?string $navigationGroup = 'Orders';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Coupons';
    protected static ?string $pluralModelLabel = 'Coupons';
    protected static ?string $modelLabel = 'Coupon';

    

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id()),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)->columnSpanFull(),

                Forms\Components\Textarea::make('about')
                    ->rows(2)->columnSpanFull(),

                Forms\Components\Select::make('discount_type')
                    ->required()
                    ->options([
                        'fixed' => 'Fixed Amount',
                        'percent' => 'Percentage',
                    ]),
                Forms\Components\DateTimePicker::make('expire')
                    ->required(),

                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->default(0.00),

                Forms\Components\TextInput::make('minimum_amount')
                    ->numeric()
                    ->default(0.00),

                Forms\Components\TextInput::make('maximum_amount')
                    ->numeric()
                    ->default(0.00),

                Forms\Components\TextInput::make('user_limit')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('coupon_limit')
                    ->numeric()
                    ->required(),
                Forms\Components\Group::make([
                    Forms\Components\Hidden::make('domain_id')
                        ->default(fn() => session('tenant_id')),

                    Forms\Components\Select::make('domain_id')
                        ->label('Select Domain')
                        ->options(Tenant::pluck('name', 'id')->toArray())
                        ->required()
                        ->visible(fn() => ! session('tenant_id')),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('code')->searchable()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('discount_type')->sortable(),
                \Filament\Tables\Columns\TextColumn::make('amount')->sortable(),
                \Filament\Tables\Columns\TextColumn::make('expire')->dateTime()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductCoupons::route('/'),
            // 'create' => Pages\CreateProductCoupon::route('/create'),
            // 'edit' => Pages\EditProductCoupon::route('/{record}/edit'),
        ];
    }
}
