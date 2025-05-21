<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Master Data';

    public static function getNavigationSort(): ?int
    {
        return 1;
    }


    public static function form(Form $form): Form
    {
    return $form
        ->schema([
            //card
            Forms\Components\Card::make()
                ->schema([

                    //image
                    Forms\Components\FileUpload::make('image')
                        ->label('Category Image')
                        ->placeholder('Category Image')
                        ->required(),

                    //name
                    Forms\Components\TextInput::make('name')
                        ->label('Category Name')
                        ->placeholder('Category Name')
                        ->required(),
                ])
        ]);
    }


    public static function table(Table $table): Table
    {
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('image')->circular(),
            Tables\Columns\TextColumn::make('name')->searchable(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
