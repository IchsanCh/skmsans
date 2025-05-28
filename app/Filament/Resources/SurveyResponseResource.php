<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\SurveyResponse;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SurveyResponseResource\Pages;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\SurveyResponseResource\RelationManagers;
use App\Filament\Resources\SurveyResponseResource\Pages\SurveyReport;

class SurveyResponseResource extends Resource
{
    protected static ?string $model = SurveyResponse::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';
    protected static ?string $navigationGroup = 'Respon';
    protected static ?string $navigationLabel = 'Respon Survei';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Responden')
                    ->description('Informasi Responden')
                    ->schema([
                        Select::make('unit_id')
                            ->relationship('unit', 'nama')
                            ->label('Unit Departement')
                            ->preload()
                            ->searchable()
                            ->live()
                            ->required(),
                        Select::make('service_id')
                            ->label('Pilih Layanan')
                            ->options(function (callable $get) {
                                $unitId = $get('unit_id');
                                if (!$unitId) return [];

                                return \App\Models\Service::where('unit_id', $unitId)->pluck('nama', 'id')->toArray();
                            })
                            ->searchable()
                            ->disabled(fn(callable $get) => !$get('unit_id'))
                            ->hint('Pilih Unit terlebih dahulu')
                            ->required(),
                        Select::make('usia')
                            ->options([
                                '17-30' => '17-30 Tahun',
                                '31-40' => '31-40 Tahun',
                                '41-50' => '41-50 Tahun',
                                '>50' => 'Diatas 50 Tahun',
                            ])
                            ->required()
                            ->label('Usia'),

                        Select::make('jenis_kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required()
                            ->label('Jenis Kelamin'),

                        Select::make('pendidikan')
                            ->options([
                                'SD' => 'SD',
                                'SMP' => 'SMP',
                                'SMA' => 'SMA/SMK',
                                'D3' => 'D3',
                                'S1' => 'S1',
                                'S2' => 'S2',
                                'S3' => 'S3',
                            ])
                            ->required()
                            ->label('Pendidikan Terakhir'),

                        Select::make('pekerjaan')
                            ->options([
                                'PNS' => 'PNS',
                                'TNI/POLRI' => 'TNI/POLRI',
                                'Pegawai Swasta' => 'Pegawai Swasta',
                                'Wirausaha' => 'Wirausaha',
                                'Pelajar/Mahasiswa' => 'Pelajar/Mahasiswa',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->label('Pekerjaan'),

                        Textarea::make('masukan')
                            ->label('Masukan/Saran')
                            ->rows(3)
                            ->columnSpan(2)
                            ->maxLength('5000')
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit.nama')
                    ->label('Unit')
                    ->searchable()->toggleable()->sortable(),
                TextColumn::make('service.nama')
                    ->label('Layanan')->searchable()->toggleable()->sortable(),
                TextColumn::make('usia')
                    ->label('Usia')->searchable()->toggleable()->sortable(),
                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')->toggleable()->sortable(),
                TextColumn::make('pendidikan')
                    ->label('Pendidikan')->sortable()->toggleable(),
                TextColumn::make('pekerjaan')
                    ->label('Pekerjaan')->sortable()->toggleable(),
                TextColumn::make('masukan')
                    ->label('Masukan')->toggleable()->wrap()
                    ->limit(50, '...')
                    ->tooltip(function ($state) {
                        return Str::limit(strip_tags($state), 100, '...');
                    }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Export Report')
                    ->icon('heroicon-o-chart-bar')
                    ->url(fn() => SurveyResponseResource::getUrl('report'))
                    ->color('success')
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
            'index' => Pages\ListSurveyResponses::route('/'),
            'create' => Pages\CreateSurveyResponse::route('/create'),
            'edit' => Pages\EditSurveyResponse::route('/{record}/edit'),
            'report' => SurveyReport::route('/report'),
        ];
    }
}
