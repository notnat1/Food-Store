<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartResource\Pages;
use App\Filament\Resources\CartResource\RelationManagers;
use App\Models\Cart;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CartResource extends Resource
{
    protected static ?string $model = Cart::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Carts & Orders';

        public static function getNavigationSort(): ?int
        {
            return 4;
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
            Tables\Columns\TextColumn::make('product.title')->searchable(),
            Tables\Columns\TextColumn::make('customer.name')->searchable(),
            Tables\Columns\TextColumn::make('qty'),
            Tables\Columns\TextColumn::make('total')
            ->money('IDR', locale: 'id')
            ->getStateUsing(fn($record) => $record->qty * $record->product->price),
        ])
        ->filters([
            //
        ])
        ->actions([
            //Tables\Actions\EditAction::make(),
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

    public static function canCreate(): bool
        {
            return false;
        }

        public static function getPages(): array
        {
            return [
                'index' => Pages\ListCarts::route('/'),
            ];
        }
}
