<?php

namespace App\Http\Controllers;

use App\Models\Units;
use App\Models\Service;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\QuestionOption;
use App\Models\ResponseAnswer;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    public function index()
    {
        $units = Units::all();
        $services = Service::all();

        return view('survey', compact('units', 'services'));
    }
    public function getServices($unit_id)
    {
        $services = Service::where('unit_id', $unit_id)->get();
        return response()->json($services);
    }

    public function start(Request $request)
    {
        // Custom validation
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required|exists:units,id',
            'service_id' => 'required|exists:services,id',
            'usia' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
        ], [
            // Custom error messages (opsional)
            'unit_id.required' => 'Unit harus dipilih',
            'unit_id.exists' => 'Unit yang dipilih tidak valid',
            'service_id.required' => 'Layanan harus dipilih',
            'service_id.exists' => 'Layanan yang dipilih tidak valid',
            'usia.required' => 'Usia harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P',
            'pendidikan.required' => 'Pendidikan harus diisi',
            'pekerjaan.required' => 'Pekerjaan harus diisi',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            // Ambil error pertama untuk ditampilkan
            $firstError = $validator->errors()->first();

            // Atau kamu bisa bikin pesan custom
            $errorMessage = $this->generateCustomErrorMessage($validator->errors());

            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
            // atau bisa pake with('sweetalert_error', $errorMessage);
        }

        // Jika semua data valid
        $data = $request->all();

        // Simpan di session sementara
        session(['survey_data' => $data]);

        // Success message (opsional)
        return redirect()->route('survey.questions');
    }
    private function generateCustomErrorMessage($errors)
    {
        $missingFields = [];

        if ($errors->has('unit_id')) {
            $missingFields[] = 'Unit';
        }
        if ($errors->has('service_id')) {
            $missingFields[] = 'Layanan';
        }
        if ($errors->has('usia')) {
            $missingFields[] = 'Usia';
        }
        if ($errors->has('jenis_kelamin')) {
            $missingFields[] = 'Jenis Kelamin';
        }
        if ($errors->has('pendidikan')) {
            $missingFields[] = 'Pendidikan';
        }
        if ($errors->has('pekerjaan')) {
            $missingFields[] = 'Pekerjaan';
        }

        if (count($missingFields) == 1) {
            return "Mohon lengkapi data {$missingFields[0]} terlebih dahulu.";
        } else {
            $lastField = array_pop($missingFields);
            $fieldList = implode(', ', $missingFields) . ' dan ' . $lastField;
            return "Mohon lengkapi data {$fieldList} terlebih dahulu.";
        }
    }
    public function questions()
    {
        $surveyData = session('survey_data');
        if (!$surveyData) {
            return redirect()->route('survey.index')->with('error', 'Silakan isi data terlebih dahulu.');
        }

        $questions = Question::with('questionOptions')->get();

        return view('question', compact('questions'));
    }
    public function submit(Request $request)
    {
        $surveyData = session('survey_data');
        if (!$surveyData) {
            return redirect()->route('survey.index')->with('error', 'Session expired, silakan mulai ulang.');
        }

        // Validasi jawaban
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|exists:question_options,id',
            'masukan' => 'nullable|string|max:1000'
        ]);

        try {
            // Tambahkan masukan ke survey data
            $surveyData['masukan'] = $request->input('masukan');

            // Simpan SurveyResponse
            $response = SurveyResponse::create($surveyData);

            // Simpan jawaban dari form pertanyaan
            foreach ($request->input('answers') as $question_id => $option_id) {
                ResponseAnswer::create([
                    'survey_response_id' => $response->id,
                    'question_id' => $question_id,
                    'question_option_id' => $option_id, // This should be the option ID, not an array
                ]);
            }

            // Hapus session
            session()->forget('survey_data');

            return redirect()->route('survey.index')->with('success', 'Terima kasih sudah mengisi survei!');
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Survey submission error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }
}
