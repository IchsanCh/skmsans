<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Unit Layanan';
    protected static ?string $navigationLabel = 'Layanan';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Layanan')
                    ->description('Tambahkan layanan baru')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->label('Nama Layanan')
                            ->placeholder('ex: Layanan Pengaduan')
                            ->maxLength(255),
                        Forms\Components\Select::make('unit_id')
                            ->relationship('unit', 'nama')
                            ->required()
                            ->label('Unit Departemen')
                            ->placeholder('Pilih Unit Layanan')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Layanan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit.nama')
                    ->label('Unit Departemen')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
