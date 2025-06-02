<?php

namespace App\Http\Controllers;

use App\Models\Units;
use App\Models\Service;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\ResponseAnswer;
use App\Models\SurveyResponse;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SurveyResponseExport;

set_time_limit(300); // 5 menit (300 detik)
ini_set('memory_limit', '1G');
class StatistikController extends Controller
{

    public function index(Request $request)
    {
        $units = Units::all();
        $services = Service::all();
        $unitId = $request->input('unit_id');
        $serviceId = $request->input('service_id');
        $startDate = Carbon::parse($request->input('tanggal_awal') ?? now()->startOfMonth())->startOfDay();
        $endDate = Carbon::parse($request->input('tanggal_akhir') ?? now()->endOfMonth())->endOfDay();

        $query = SurveyResponse::query();

        if ($unitId) {
            $query->where('unit_id', $unitId);
        }
        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }
        $query->whereBetween('created_at', [$startDate, $endDate]);
        $responses = $query->with('responseAnswers.question', 'responseAnswers.questionOption')->get();
        $totalResponden = $responses->count();
        $unsurCount = Question::count();

        $totalNRR = 0;
        $jumlahTiapBobot = [1 => 0, 2 => 0, 3 => 0, 4 => 0];

        foreach ($responses as $response) {
            foreach ($response->responseAnswers as $answer) {
                $bobot = $answer->questionOption->bobot ?? 0;
                $totalNRR += $bobot;

                if (isset($jumlahTiapBobot[$bobot])) {
                    $jumlahTiapBobot[$bobot]++;
                }
            }
        }

        $jumlahJawaban = $unsurCount * max($totalResponden, 1);
        $nrr = $jumlahJawaban > 0 ? $totalNRR / $jumlahJawaban : 0;
        $nrrTertimbang = $nrr;
        $ikm = round($nrr * 25, 2);

        $mutu = 'Tidak Baik';
        if ($ikm >= 88.31) $mutu = 'Sangat Baik';
        elseif ($ikm >= 76.61) $mutu = 'Baik';
        elseif ($ikm >= 65.00) $mutu = 'Kurang Baik';

        $totalJawaban = array_sum($jumlahTiapBobot);
        $persentaseKepuasan = [];
        foreach ($jumlahTiapBobot as $bobot => $jumlah) {
            $persentaseKepuasan[$bobot] = [
                'jumlah' => $jumlah,
                'persen' => $totalJawaban > 0
                    ? round(($jumlah / $totalJawaban) * 100, 2)
                    : 0,
            ];
        }

        $pekerjaanStat = $responses->groupBy('pekerjaan')->map(function ($items) use ($totalResponden) {
            return [
                'jumlah' => $items->count(),
                'persen' => round(($items->count() / max($totalResponden, 1)) * 100, 2),
            ];
        });

        $pendidikanStat = $responses->groupBy('pendidikan')->map(function ($items) use ($totalResponden) {
            return [
                'jumlah' => $items->count(),
                'persen' => round(($items->count() / max($totalResponden, 1)) * 100, 2),
            ];
        });

        $questions = Question::all();
        $mutuPerPertanyaan = [];

        foreach ($questions as $question) {
            $answers = ResponseAnswer::where('question_id', $question->id)
                ->whereHas('surveyResponse', function ($q) use ($unitId, $serviceId, $startDate, $endDate) {
                    if ($unitId) {
                        $q->where('unit_id', $unitId);
                    }
                    if ($serviceId) {
                        $q->where('service_id', $serviceId);
                    }
                    if ($startDate && $endDate) {
                        $q->whereBetween('created_at', [$startDate, $endDate]);
                    }
                })
                ->with('questionOption')
                ->get();

            $jumlahJawaban = $answers->count();
            $totalBobot = $answers->sum(fn($a) => $a->questionOption->bobot ?? 0);
            $nrrPertanyaan = $jumlahJawaban > 0 ? round($totalBobot / $jumlahJawaban, 2) : 0;
            $nilaiPertanyaan = round($nrrPertanyaan * 25, 2);

            $mutuLabel = 'Tidak Baik';
            if ($nilaiPertanyaan >= 88.31) $mutuLabel = 'Sangat Baik';
            elseif ($nilaiPertanyaan >= 76.61) $mutuLabel = 'Baik';
            elseif ($nilaiPertanyaan >= 65.00) $mutuLabel = 'Kurang Baik';

            $jumlahPerPilihan = [
                'Sangat Baik' => 0,
                'Baik' => 0,
                'Kurang Baik' => 0,
                'Tidak Baik' => 0,
            ];

            foreach ($answers as $ans) {
                $label = $ans->questionOption->label ?? 'Tidak Diketahui';
                if (isset($jumlahPerPilihan[$label])) {
                    $jumlahPerPilihan[$label]++;
                }
            }

            $mutuPerPertanyaan[] = [
                'pertanyaan' => $question->pertanyaan,
                'unsur_pelayanan' => $question->unsur_pelayanan,
                'nrr' => $nrrPertanyaan,
                'nilai' => $nilaiPertanyaan,
                'mutu' => $mutuLabel,
                'jumlah_pilihan' => $jumlahPerPilihan,
            ];
        }
        $genderStat = $responses->groupBy('jenis_kelamin')->map(function ($items) use ($totalResponden) {
            return [
                'jumlah' => $items->count(),
                'persen' => round(($items->count() / max($totalResponden, 1)) * 100, 2),
            ];
        });
        $usiaStat = [
            'Di bawah 17 tahun' => 0,
            '17 - 30 tahun' => 0,
            '31 - 40 tahun' => 0,
            '41 - 50 tahun' => 0,
            'Di atas 50 tahun' => 0,
        ];

        foreach ($responses as $response) {
            $usia = $response->usia;
            if ($usia < 17) {
                $usiaStat['Di bawah 17 tahun']++;
            } elseif ($usia >= 17 && $usia <= 30) {
                $usiaStat['17 - 30 tahun']++;
            } elseif ($usia >= 31 && $usia <= 40) {
                $usiaStat['31 - 40 tahun']++;
            } elseif ($usia >= 41 && $usia <= 50) {
                $usiaStat['41 - 50 tahun']++;
            } else {
                $usiaStat['Di atas 50 tahun']++;
            }
        }

        // Hitung persentase per kategori usia
        $usiaStat = collect($usiaStat)->map(function ($jumlah) use ($totalResponden) {
            return [
                'jumlah' => $jumlah,
                'persen' => $totalResponden > 0 ? round(($jumlah / $totalResponden) * 100, 2) : 0,
            ];
        });
        return view('statistik', compact(
            'units',
            'services',
            'totalResponden',
            'ikm',
            'mutu',
            'persentaseKepuasan',
            'unitId',
            'startDate',
            'endDate',
            'pekerjaanStat',
            'pendidikanStat',
            'mutuPerPertanyaan',
            'genderStat',
            'usiaStat',
        ));
    }
    public function home()
    {
        $totalResponden = SurveyResponse::count();
        $totalUnits = Units::count();

        return view('welcome', compact('totalResponden', 'totalUnits'));
    }
    public function export(Request $request)
    {
        return Excel::download(new SurveyResponseExport($request), 'laporan-survei.xlsx');
    }
}
