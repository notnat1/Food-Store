<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Master Data';

    public static function getNavigationSort(): ?int
    {
        return 3;
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
                        ->label('Slider Image')
                        ->placeholder('Slider Image')
                        ->required(),

                    //link
                    Forms\Components\TextInput::make('link')
                        ->label('Link')
                        ->placeholder('Link')
                        ->required(),
                ])
        ]);
    }


            public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    Tables\Columns\ImageColumn::make('image'),
                    Tables\Columns\TextColumn::make('link'),
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
