<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\SurveyResponse;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

set_time_limit(600);
ini_set('memory_limit', '2G');

class SurveyResponseExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {

        // Gunakan tahun berjalan sebagai default jika filter tidak diisi
        $fromDate = $this->request->from_date ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $toDate = $this->request->to_date ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $query = SurveyResponse::query()->with(['unit', 'service', 'responseAnswers.questionOption']);

        $query->whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate);

        if ($this->request->unit_id) {
            $query->where('unit_id', $this->request->unit_id);
        }
        if ($this->request->service_id) {
            $query->where('service_id', $this->request->service_id);
        }
        if ($this->request->jenis_kelamin) {
            $query->where('jenis_kelamin', $this->request->jenis_kelamin);
        }
        if ($this->request->usia) {
            [$min, $max] = explode('-', $this->request->usia);
            $query->whereBetween('usia', [(int) $min, (int) $max]);
        }

        return $query->get()->map(function ($item) {
            return [
                'Tanggal' => $item->created_at->format('Y-m-d H:i:s'),
                'Response ID' => $item->id,
                'Unit' => $item->unit->nama ?? '-',
                'Layanan' => $item->service->nama ?? '-',
                'Usia' => $item->usia,
                'Jenis Kelamin' => $item->jenis_kelamin,
                'Pendidikan' => $item->pendidikan,
                'Pekerjaan' => $item->pekerjaan,
                'Masukan' => strip_tags($item->masukan),
                'U1' => $item->responseAnswers->firstWhere('question_id', 1)?->questionOption->bobot ?? '-',
                'U2' => $item->responseAnswers->firstWhere('question_id', 2)?->questionOption->bobot ?? '-',
                'U3' => $item->responseAnswers->firstWhere('question_id', 3)?->questionOption->bobot ?? '-',
                'U4' => $item->responseAnswers->firstWhere('question_id', 4)?->questionOption->bobot ?? '-',
                'U5' => $item->responseAnswers->firstWhere('question_id', 5)?->questionOption->bobot ?? '-',
                'U6' => $item->responseAnswers->firstWhere('question_id', 6)?->questionOption->bobot ?? '-',
                'U7' => $item->responseAnswers->firstWhere('question_id', 7)?->questionOption->bobot ?? '-',
                'U8' => $item->responseAnswers->firstWhere('question_id', 8)?->questionOption->bobot ?? '-',
                'U9' => $item->responseAnswers->firstWhere('question_id', 9)?->questionOption->bobot ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Response ID',
            'Unit',
            'Layanan',
            'Usia',
            'Jenis Kelamin',
            'Pendidikan',
            'Pekerjaan',
            'Masukan',
            'U1',
            'U2',
            'U3',
            'U4',
            'U5',
            'U6',
            'U7',
            'U8',
            'U9',
        ];
    }
}
