<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Filament\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?int $navigationSort      = 51;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->string()
                    ->maxLength(255),
                \Filament\Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),
                \Filament\Forms\Components\Textarea::make('message')
                    ->label('Message')
                    ->required()
                    ->maxLength(1000)
                    ->columnSpanFull()
                    ->rows(6),
                \Filament\Forms\Components\TextInput::make('ip_address')
                    ->label('IP Address')
                    ->maxLength(100)
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Toggle::make('is_read')
                    ->label('Read Status')
                    ->inline(false)
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('message')
                    ->label('Message')
                    ->sortable()
                    ->searchable()
                    ->limit(50),
                \Filament\Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_read')
                    ->label('Read')
                    ->sortable()
                    ->searchable()
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->searchable()
                    ->dateTime()
                    ->since()
                    ->dateTimeTooltip()
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->sortable()
                    ->searchable()
                    ->dateTime()
                    ->since()
                    ->dateTimeTooltip()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->mutateRecordDataUsing(function (array $data) {
                        if (! $data['is_read']) {
                            \App\Models\Message::where('id', $data['id'])->update(['is_read' => true]);
                            $data['is_read'] = true;
                        }

                        return $data;
                    }),
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMessages::route('/'),
            // 'create' => Pages\CreateMessage::route('/create'),
            // 'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
