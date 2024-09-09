<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedalPointResource\Pages;
use App\Models\Medal;
use App\Models\MedalPoint;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MedalPointResource extends Resource
{
    protected static ?string $model = MedalPoint::class;
    protected static ?string $navigationGroup = 'Points';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Currency Point Details')->schema([
                    Forms\Components\Select::make('medal_id')
                        ->label('Medal')
                        ->options(Medal::all()->pluck('name_en', 'id'))
                        ->unique(ignoreRecord: true)
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('point')
                        ->prefix('%')
                        ->regex('/^[1-9]\d*$/')
                        ->minValue(0)
                        ->maxValue(100)
                        ->numeric()
                        ->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('medal.name_en')
                    ->label('Medal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('point')
                    ->suffix('%')
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
            'index' => Pages\ListMedalPoints::route('/'),
            'create' => Pages\CreateMedalPoint::route('/create'),
            'view' => Pages\ViewMedalPoint::route('/{record}'),
            'edit' => Pages\EditMedalPoint::route('/{record}/edit'),
        ];
    }
}
