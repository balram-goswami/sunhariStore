<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QueryResource\Pages;
use App\Models\Query;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class QueryResource extends Resource
{
    protected static ?string $model = Query::class;

    protected static ?string $navigationGroup = 'Help Section';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Contact Us Form';
    protected static ?string $modelLabel = 'Contact Us Form';
    protected static ?string $pluralModelLabel = 'Contact Us Forms';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('query_type')->label('Form')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->label('Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('message')->label('Query Message')->limit(50),
                Tables\Columns\TextColumn::make('response')
                    ->label('Response Message')
                    ->limit(50)
                    ->toggleable(),
            ])
            ->actions([
                // ✅ Reply button (only visible if query_type = 'contact' AND no response yet)
                Tables\Actions\Action::make('reply')
                    ->label('Reply')
                    ->icon('heroicon-o-paper-airplane')
                    ->button()
                    ->color('success')
                    ->visible(fn ($record) =>
                        $record->query_type === 'contact' && empty($record->response)
                    )
                    ->form([
                        Forms\Components\Textarea::make('response_message')
                            ->label('Your Reply Message')
                            ->required()
                            ->rows(5),
                    ])
                    ->action(function (array $data, Query $record): void {
                        try {
                            // Send email
                            Mail::raw($data['response_message'], function ($message) use ($record) {
                                $message->to($record->email)
                                    ->subject('Response to your contact query');
                            });

                            // Save response in DB
                            $record->update([
                                'response' => $data['response_message'],
                            ]);

                            // Success notification
                            Notification::make()
                                ->title('Reply sent successfully!')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Failed to send reply.')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // 🚫 Already Replied button (disabled)
                Tables\Actions\Action::make('already_replied')
                    ->label('Already Replied')
                    ->icon('heroicon-o-check-circle')
                    ->color('gray')
                    ->visible(fn ($record) =>
                        $record->query_type === 'contact' && !empty($record->response)
                    )
                    ->disabled(),

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
            'index' => Pages\ListQueries::route('/'),
        ];
    }
}
