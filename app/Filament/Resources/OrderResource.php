<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\OrderResource\Widgets\OrderOverview;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationLabel = 'Bitinda';
    protected static ?string $navigationIcon = 'carbon-order-details';
    protected static ?string $navigationBadgeTooltip = 'Nouveaux Bitinda';
    protected static ?int $navigationSort = 1;


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Attribution')
                    ->schema([
                        Select::make('seller_id')
                            ->label('Vendeur')
                            ->relationship('seller', 'id')
                            ->columnSpanFull(),
                        Select::make('delivery_man_id')
                            ->relationship('delivery_man', 'id')
                            ->label('Livreur')
                            ->columnSpanFull(),
                    ]),
                Section::make('Détail de la livraison')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Produit'),
                        TextInput::make('item_price')
                            ->label('Prix du produit')
                            ->columnSpan(1)
                            ->suffix('$'),
                        TextInput::make('delivery_price')
                            ->label('Frais de livraison')
                            ->suffix('$'),
                        TextInput::make('delivery_address')
                            ->label('Adresse de livraison'),
                        DatePicker::make('delivery_date')
                            ->label('Date de la livraison'),
                        TimePicker::make('delivery_time')
                            ->label('Heure de la livraison'),
                        Select::make('status')
                            ->label('Statut')
                            ->options([
                                'new' => 'Nouvelle',
                                'processing' => 'En cours',
                                'delivered' => 'Livrée',
                                'cancelled' => 'Annulée'
                            ]),
                    ]),
                Section::make('Images')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('media')
                            ->collection('bitinda-images')
                            ->multiple()
                            ->maxFiles(2)
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),
                Section::make()
                    ->schema([
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('bitinda-images')
                    ->label('Images')
                    ->collection('bitinda-images'),
                TextColumn::make('seller.user.name')
                    ->label('Vendeur')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Produit')
                    ->limit(20)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('item_price')
                    ->label('Prix')
                    ->sortable()
                    ->searchable()
                    ->suffix(' Fc'),
                TextColumn::make('delivery_price')
                    ->label('Frais de livraison')
                    ->sortable()
                    ->searchable()
                    ->suffix(' Fc'),
                TextColumn::make('delivery_date')
                    ->label('Date')
                    ->sortable()
                    ->searchable()
                    ->date('D d M Y'),
                TextColumn::make('delivery_time')
                    ->label('Heure')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('delivery_man.user.name')
                    ->label('Livreur')
                    ->sortable()
                    ->searchable()
                    ->limit(15),
                TextColumn::make('status')
                    ->label('Statut')
                    ->formatStateUsing(function ($state) {
                        $translations = [
                            'new' => 'Nouvelle',
                            'processing' => 'En cours',
                            'delivered' => 'Livrée',
                            'cancelled' => 'Annulée'
                        ];
                        return $translations[$state] ?? $state;
                    })
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'new' => 'info',
                        'processing' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger'
                    }),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            OrderOverview::class,
        ];
    }
}
