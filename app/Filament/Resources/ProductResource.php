<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Master Data';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Product Image')
                            ->placeholder('Product Image')
                            ->required(),

                        Forms\Components\TextInput::make('title')
                            ->label('Product Title')
                            ->placeholder('Product Title')
                            ->required(),

                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\Select::make('category_id')
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->required(),

                            Forms\Components\TextInput::make('price')
                                ->label('Price')
                                ->placeholder('Price')
                                ->required(),

                            Forms\Components\TextInput::make('weight')
                                ->label('Weight')
                                ->placeholder('Weight')
                                ->required(),
                        ]),

                        Forms\Components\RichEditor::make('description')
                            ->label('Product Description')
                            ->placeholder('Product Description')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('image')->circular(),
            Tables\Columns\TextColumn::make('title')->searchable(),
            Tables\Columns\TextColumn::make('category.name')->searchable(),
            Tables\Columns\TextColumn::make('price')->numeric(decimalPlaces: 0)->money('IDR', locale: 'id'),
            Tables\Columns\TextColumn::make('description')->html()->limit(50),
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


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
