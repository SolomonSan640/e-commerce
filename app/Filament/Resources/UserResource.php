<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Medal;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Details')->schema([
                    Forms\Components\TextInput::make('customized_number')
                        ->maxLength(255)
                        ->readOnly(),
                    Forms\Components\TextInput::make('name')
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('phone')
                        ->label('Primary Phone')
                        ->unique(ignoreRecord: true)
                        ->regex('/^09\d{9}$/')
                        ->required(),
                    Forms\Components\TextInput::make('second_phone')
                        ->unique(ignoreRecord: true)
                        ->regex('/^09\d{9}$/')
                        ->placeholder('0926956406')
                        ->required(),
                    Forms\Components\TextInput::make('gender')
                        ->required(),
                    Forms\Components\Select::make('loyalty_id')
                        ->options(Medal::all()->pluck('name_en', 'id'))
                        ->default('standard')
                        ->placeholder('standard')
                        ->required(),
                    Forms\Components\TextInput::make('current_points')
                        ->label('Current Points')
                        ->placeholder('78')
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\Textarea::make('address')
                        ->rows(5)
                        ->required()
                        ->columnSpanFull(),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customized_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
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
                // Tables\Actions\EditAction::make()->outlined()->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('is_admin', '!=', 1);
    }
}
