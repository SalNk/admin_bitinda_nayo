<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Seller;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SellerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SellerResource\RelationManagers;

class SellerResource extends Resource
{
    protected static ?string $model = Seller::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Vendeurs';
    protected static ?int $navigationSort = 2;

    protected function getTableQuery(): Builder
    {
        return Seller::query()
            ->whereHas('user', function (Builder $query) {
                $query->where('is_active', 1);
            });
    }

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
                TextColumn::make('user.name')
                    ->label('Nom complet')
                    ->searchable()
                    ->sortable(),
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
                TextColumn::make('shop_name')
                    ->label('Nom de la boutique')
                    ->limit(20)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('shop_address')
                    ->label('Adresse de la boutique')
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
            'index' => Pages\ListSellers::route('/'),
            'create' => Pages\CreateSeller::route('/create'),
            'edit' => Pages\EditSeller::route('/{record}/edit'),
        ];
    }
}
