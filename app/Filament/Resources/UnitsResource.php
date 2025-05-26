<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitsResource\Pages;
use App\Filament\Resources\UnitsResource\RelationManagers;
use App\Models\Units;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitsResource extends Resource
{
    protected static ?string $model = Units::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Unit Layanan';
    protected static ?string $navigationLabel = 'Unit Departemen';
    protected static ?int $navigationSort = 1;


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Unit Departemen')
                    ->description('Tambahkan unit departemen baru')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->label('Nama Unit')
                            ->placeholder('ex: Dinas Pariwisata')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Unit')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnits::route('/create'),
            'edit' => Pages\EditUnits::route('/{record}/edit'),
        ];
    }
}
