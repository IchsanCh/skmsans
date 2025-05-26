<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\QuestionOption;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuestionOptionResource\Pages;
use App\Filament\Resources\QuestionOptionResource\RelationManagers;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class QuestionOptionResource extends Resource
{
    protected static ?string $model = QuestionOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'Pertanyaan';
    protected static ?string $navigationLabel = 'Opsi Pertanyaan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Opsi Pertanyaan')
                    ->description('Tambahkan opsi pertanyaan baru')
                    ->schema([
                        Forms\Components\Select::make('question_id')
                            ->relationship('question', 'pertanyaan')
                            ->required()
                            ->label('Pertanyaan')
                            ->placeholder('Pilih Pertanyaan')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('label')
                            ->required()
                            ->label('Opsi Pertanyaan')
                            ->placeholder('ex: Puas')
                            ->maxLength(255),
                        TextInput::make('bobot')
                            ->required()
                            ->label('Bobot Opsi Pertanyaan')
                            ->placeholder('ex: 4')
                            ->numeric()
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Opsi Pertanyaan')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('question.pertanyaan')
                    ->label('Pertanyaan')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('bobot')
                    ->label('Bobot')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
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
            'index' => Pages\ListQuestionOptions::route('/'),
            'create' => Pages\CreateQuestionOption::route('/create'),
            'edit' => Pages\EditQuestionOption::route('/{record}/edit'),
        ];
    }
}
