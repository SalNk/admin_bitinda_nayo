<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DeliveryMan;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DeliveryManResource\Pages;
use App\Filament\Resources\DeliveryManResource\RelationManagers;

class DeliveryManResource extends Resource
{
    protected static ?string $model = DeliveryMan::class;
    protected static ?string $navigationIcon = 'carbon-delivery';
    protected static ?string $navigationLabel = 'Livreurs';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(3)
                    ->schema([
                        Section::make()
                            ->relationship('user')
                            ->columnSpan(2)
                            ->columns(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Nom'),
                                TextInput::make('email')
                                    ->required()
                                    ->unique()
                                    ->email()
                                    ->maxLength(255)
                                    ->label('Email'),
                                TextInput::make('telephone')
                                    ->required()
                                    ->maxLength(20)
                                    ->label('Téléphone'),
                                TextInput::make('address')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Adresse'),
                            ]),
                        Section::make()
                            ->columnSpan(1)
                            ->schema([
                                Radio::make('is_available')
                                    ->label('Disponibilité')
                                    ->inline()
                                    ->options([
                                        1 => 'Disponible',
                                        0 => 'Indisponible',
                                    ])
                                    ->default(1),
                                Select::make('role')
                                    ->default('delivery_man')
                                    ->visible(false)
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nom complet')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_available')
                    ->label('Disponibilité')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn(int $state) => match ($state) {
                        1 => 'success',
                        0 => 'warning',
                    })
                    ->formatStateUsing(fn($state) => $state ? 'Disponible' : 'Non disponible'),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.telephone')
                    ->label('Téléphone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.address')
                    ->label('Adresse')
                    ->limit(20)
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListDeliveryMen::route('/'),
            'edit' => Pages\EditDeliveryMan::route('/{record}/edit'),
        ];
    }
}
