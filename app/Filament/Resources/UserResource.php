<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'User management';
    protected static ?string $navigationLabel = 'Utilisateurs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->required()
                    ->maxLength(255),
                Select::make('role')
                    ->options([
                        'admin' => 'Administrateur',
                        'seller' => 'Vendeur',
                        'delivery_person' => 'Livreur'
                    ])
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->minLength(8)
                    ->same('password_confirmation')
                    ->dehydrated(fn($state) => filled($state))
                    ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                TextInput::make('password_confirmation')
                    ->label('Password confirmation')
                    ->password()
                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->minLength(8)
                    ->dehydrated(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable()
                    ->label('Nom'),
                TextColumn::make('email')->sortable()->searchable()
                    ->label('Email'),
                TextColumn::make('role')->sortable()->searchable()
                    ->label('Rôle')
                    ->formatStateUsing(function ($state) {
                        $translations = [
                            'admin' => "Administrateur",
                            'seller' => "Vendeur",
                            'delivery_person' => "Livreur"
                        ];

                        return $translations[$state] ?? $state;
                    }),
                TextColumn::make('created_at')->dateTime()
                    ->label('Créé le')
                    ->date('D d-m-Y'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
