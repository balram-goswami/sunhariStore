<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Filament\Resources\SiteSettingResource\RelationManagers;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Website Identity')
                    ->schema([
                        FileUpload::make('logo'),
                        FileUpload::make('favicon'),
                        Forms\Components\TextInput::make('tagline')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->columns(2),

                Section::make('Address')
                    ->schema([
                        Select::make('currency')
                            ->options(array_map(function ($c) {
                                return $c['name'] . ' (' . html_entity_decode($c['symbol']) . ')';
                            }, config('currency')))
                            ->searchable()
                            ->placeholder('Select a currency'),

                        Select::make('timezone')
                            ->options(config('timezones'))
                            ->searchable()->columnSpan(2),

                        Forms\Components\Textarea::make('address')->rows(2)->columnSpanFull(),
                        Forms\Components\TextInput::make('city')
                            ->maxLength(255)->columnSpan(1),
                        Forms\Components\TextInput::make('state')
                            ->maxLength(255)->columnSpan(1),
                        Forms\Components\TextInput::make('postal_code')
                            ->maxLength(255)->columnSpan(1),
                        Select::make('country')
                            ->options(config('country'))
                            ->searchable()
                            ->columnSpan(1),
                    ])->collapsible()->collapsed()->columns(3),

                Section::make('Contact')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->tel()->default('1234569871')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('alternate_phone')
                            ->tel()->default('1234569871')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\Repeater::make('social_links')
                            ->label('Social Links')
                            ->schema([
                                Select::make('icon')
                                    ->label('Icon')
                                    ->options([
                                        'facebook' => 'Facebook',
                                        'twitter' => 'Twitter',
                                        'instagram' => 'Instagram',
                                        'linkedin' => 'LinkedIn',
                                        'youtube' => 'YouTube',
                                        'github' => 'GitHub',
                                    ]),

                                Forms\Components\TextInput::make('url')
                                    ->label('URL')
                                    ->url(),
                            ])
                            ->addActionLabel('Add Social Link')
                            ->columnSpan('full')->columns(2),
                    ])->collapsible()->collapsed()->columns(3),

                Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('meta_description')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('meta_keywords')
                            ->columnSpanFull(),
                    ])->collapsible()->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                ->label('Logo')
                ->square()
                ->size(50),
                Tables\Columns\ImageColumn::make('favicon')
                ->label('Favicon')
                ->square()
                ->size(50),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alternate_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
