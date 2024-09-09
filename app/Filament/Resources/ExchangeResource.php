<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExchangeResource\Pages;
use App\Models\Exchange;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExchangeResource extends Resource
{
    protected static ?string $model = Exchange::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Warehouse Transfer Details')->schema([
                    Forms\Components\Select::make('from_currency_id')
                        ->relationship('fromCurrency', 'name_en')
                        ->label('Currency From')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('to_currency_id')
                        ->relationship('toCurrency', 'name_en')
                        ->label('Currency To')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('from_amount')
                        ->minValue(0)
                        ->numeric()
                        ->regex('/^[1-9]\d*$/')
                        ->required(),
                    Forms\Components\TextInput::make('to_amount')
                        ->minValue(0)
                        ->numeric()
                        ->regex('/^[1-9]\d*$/')
                        ->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fromCurrency.name_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('toCurrency.name_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('from_amount')
                    ->searchable(),
                Tables\Columns\TextColumn::make('to_amount')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->outlined()->button(),
                Tables\Actions\EditAction::make()->outlined()->button(),
                Tables\Actions\DeleteAction::make()->outlined()->button(),
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
            'index' => Pages\ListExchanges::route('/'),
            'create' => Pages\CreateExchange::route('/create'),
            'view' => Pages\ViewExchange::route('/{record}'),
            'edit' => Pages\EditExchange::route('/{record}/edit'),
        ];
    }
}
