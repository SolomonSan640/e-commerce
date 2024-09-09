<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrencyPointResource\Pages;
use App\Models\Currency;
use App\Models\CurrencyPoint;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CurrencyPointResource extends Resource
{
    protected static ?string $model = CurrencyPoint::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Points';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Points per Currency';
    protected static bool $shouldRegisterNavigation = false;


    public static function getLabel(): ?string
    {
        return 'Point Per Currency'; // Replace this with your desired title
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Currency Point Details')->schema([
                    Forms\Components\Select::make('currency_id')
                        ->label('Currency')
                        ->options(Currency::all()->pluck('name_en', 'id'))
                        ->unique(ignoreRecord: true)
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('point')
                        ->regex('/^[1-9]\d*$/')
                        ->minValue(0)
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('amount')
                        ->regex('/^[1-9]\d*$/')
                        ->minValue(0)
                        ->numeric()
                        ->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('currency.name_en')
                    ->label('Currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('point')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
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
            'index' => Pages\ListCurrencyPoints::route('/'),
            'create' => Pages\CreateCurrencyPoint::route('/create'),
            'view' => Pages\ViewCurrencyPoint::route('/{record}'),
            'edit' => Pages\EditCurrencyPoint::route('/{record}/edit'),
        ];
    }
}
