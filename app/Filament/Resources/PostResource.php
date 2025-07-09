<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort     = 31;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(fn() => \Illuminate\Support\Facades\Auth::user()?->uuid),
                Forms\Components\Grid::make(2)
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('image')
                            ->label('Image')
                            ->nullable()
                            ->image()
                            ->directory('posts')
                            ->disk('public')
                            ->enableOpen()
                            // ->enableDownload()
                            ->maxSize(2048)
                            ->deleteUploadedFileUsing(function ($file, $record) {
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($file);
                                $record->update([
                                    'image' => null,
                                ]);
                            }),
                    ]),
                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->string()
                    ->maxLength(255),
                \Filament\Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->relationship('category', 'name', function ($query) {
                        $query->orderBy('name', 'asc');
                    }),
                \Filament\Forms\Components\Select::make('status')
                    ->label('Status')
                    ->required()
                    ->options([
                        'draft'   => 'Draft',
                        'publish' => 'Publish',
                    ])
                    ->default('draft'),
                \Filament\Forms\Components\TextInput::make('view_total')
                    ->label('View Total')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(false),
                \Filament\Forms\Components\RichEditor::make('content_body')
                    ->label('Content')
                    ->nullable()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'bulletList',
                        'orderedList',
                        'undo',
                        'redo'
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable()
                    ->limit(50),
                \Filament\Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('view_total')
                    ->label('View Total')
                    ->sortable()
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft'   => 'gray',
                        'publish' => 'primary',
                    }),
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
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
