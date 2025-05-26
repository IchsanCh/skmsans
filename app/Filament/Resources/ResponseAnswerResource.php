<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ResponseAnswer;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ResponseAnswerResource\Pages;
use App\Filament\Resources\ResponseAnswerResource\RelationManagers;

class ResponseAnswerResource extends Resource
{
    protected static ?string $model = ResponseAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Respon';
    protected static ?string $navigationLabel = 'Respon Pertanyaan';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Response Pertanyaan')
                    ->description('Jawaban dari setiap pertanyaan')
                    ->schema([
                        Select::make('survey_response_id')
                            ->relationship('surveyResponse', 'id')
                            ->required()
                            ->label('Survey Response'),

                        Select::make('question_id')
                            ->relationship('question', 'pertanyaan')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Pertanyaan')
                            ->live(),

                        Select::make('question_option_id')
                            ->relationship('questionOption', 'label')
                            ->required()
                            ->options(function (callable $get) {
                                $questId = $get('question_id');
                                if (!$questId) return [];

                                return \App\Models\QuestionOption::where('question_id', $questId)->pluck('label', 'id')->toArray();
                            })
                            ->searchable()
                            ->disabled(fn(callable $get) => !$get('question_id'))
                            ->hint('Pilih pertanyaan terlebih dahulu')
                            ->preload()
                            ->label('Opsi Jawaban'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('surveyResponse.id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('question.pertanyaan')
                    ->label('Pertanyaan')
                    ->sortable()
                    ->searchable()->toggleable(),

                Tables\Columns\TextColumn::make('questionOption.label')
                    ->label('Jawaban')
                    ->sortable()
                    ->searchable()->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable()->toggleable(),
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
            'index' => Pages\ListResponseAnswers::route('/'),
            'create' => Pages\CreateResponseAnswer::route('/create'),
            'edit' => Pages\EditResponseAnswer::route('/{record}/edit'),
        ];
    }
}
