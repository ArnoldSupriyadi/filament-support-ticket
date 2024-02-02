<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TextMessageResource\Pages;
use App\Filament\Resources\TextMessageResource\RelationManagers;
use App\Models\TextMessage;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TextMessageResource extends Resource
{
    protected static ?string $model = TextMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('sentBy.name')
                    ->searchable()
                    ->sortable()
                    ->default('-')
                    ->label('Message Sent By'),
                TextColumn::make('sentTo.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('message')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
            ])
            ->filters([
                SelectFilter::make('status')
                ->options(TextMessage::STATUS),
            ])
            ->actions([
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
            'index' => Pages\ListTextMessages::route('/'),
            // 'create' => Pages\CreateTextMessage::route('/create'),
            // 'edit' => Pages\EditTextMessage::route('/{record}/edit'),
        ];
    }
}
