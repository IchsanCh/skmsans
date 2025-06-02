@extends('layouts.app')
{{-- @extends('components.navbar') --}}
@section('title', 'Statistik')

@section('meta_description',
    'Lihat hasil dan analisis dari survei kepuasan masyarakat. Data real-time untuk evaluasi
    pelayanan publik.')

@section('og_description',
    'Lihat statistik kepuasan masyarakat secara langsung. Transparan, informatif, dan berbasis
    data.')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .card-hover {
                transition: all 0.3s ease;
            }

            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            }

            .animate-fade-in {
                animation: fadeIn 0.6s ease-in;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .stats-number {
                background: linear-gradient(45deg, #f093fb 0%, #f5576c 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
        </style>
    @endpush

@section('content')
    <div class="bg-base-200 min-h-screen" data-theme="dark">
        <!-- Main Content -->
        <div class="container mx-auto p-6 space-y-8">
            <!-- Filter Section -->
            <div class="card bg-base-100 shadow-xl card-hover animate-fade-in">
                <div class="card-body">
                    <h2 class="card-title text-2xl mb-4">
                        <i class="fas fa-filter text-primary"></i>
                        Filter Data Survey
                    </h2>
                    <form method="GET" action="{{ route('statistik.index') }}"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        {{-- UNIT --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Unit Kerja</span>
                            </label>
                            <select name="unit_id" id="unitSelect" class="select select-bordered select-primary w-full">
                                <option value="">Semua Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- LAYANAN --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Pilih Layanan</span>
                            </label>
                            <select name="service_id" id="serviceSelect"
                                class="select select-primary select-bordered w-full">
                                <option value="">Semua Layanan</option>
                                @if (request('unit_id') && request('service_id'))
                                    @php
                                        $selectedService = \App\Models\Service::find(request('service_id'));
                                    @endphp
                                    @if ($selectedService)
                                        <option value="{{ $selectedService->id }}" selected>{{ $selectedService->nama }}
                                        </option>
                                    @endif
                                @endif
                            </select>
                        </div>

                        {{-- TANGGAL AWAL --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Tanggal Awal</span>
                            </label>
                            <input type="date" name="tanggal_awal" class="input input-bordered input-primary"
                                value="{{ request('tanggal_awal') }}" />
                        </div>

                        {{-- TANGGAL AKHIR --}}
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Tanggal Akhir</span>
                            </label>
                            <input type="date" name="tanggal_akhir" class="input input-bordered input-primary"
                                value="{{ request('tanggal_akhir') }}" />
                        </div>

                        {{-- BUTTON --}}
                        <div class="form-control md:col-span-4">
                            <label class="label">
                                <span class="label-text">&nbsp;</span>
                            </label>
                            <button type="submit" class="btn btn-primary w-full">
                                <i class="fas fa-search mr-2"></i>
                                Filter Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SCRIPT --}}
            <script>
                const unitSelect = document.getElementById('unitSelect');
                const serviceSelect = document.getElementById('serviceSelect');

                function loadServices(unitId, selectedServiceId = null) {
                    if (!unitId) {
                        serviceSelect.innerHTML = '<option value="">Semua Layanan</option>';
                        return;
                    }

                    fetch(`/get-services/${unitId}`)
                        .then(res => res.json())
                        .then(data => {
                            serviceSelect.innerHTML = '<option value="">Semua Layanan</option>';
                            data.forEach(service => {
                                const option = document.createElement('option');
                                option.value = service.id;
                                option.textContent = service.nama;
                                if (selectedServiceId && service.id == selectedServiceId) {
                                    option.selected = true;
                                }
                                serviceSelect.appendChild(option);
                            });
                        });
                }

                // Auto-load saat halaman di-reload jika ada unit_id & service_id
                const initialUnitId = unitSelect.value;
                const initialServiceId = '{{ request('service_id') }}';
                if (initialUnitId) {
                    loadServices(initialUnitId, initialServiceId);
                }

                unitSelect.addEventListener('change', function() {
                    const selectedUnitId = this.value;
                    loadServices(selectedUnitId);
                });
            </script>


            <!-- Stats Overview -->
            <div class="flex flex-col lg:flex-row justify-around gap-4">
                <div class="stat bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-2xl shadow-xl card-hover">
                    <div class="stat-figure">
                        <i class="fas fa-users text-3xl opacity-80"></i>
                    </div>
                    <div class="stat-title text-blue-100 text-xl font-bold">Total Responden</div>
                    <div class="stat-value text-white">{{ number_format($totalResponden) }}</div>
                    <div class="stat-desc text-blue-100 font-semibold">
                        {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}
                    </div>
                </div>

                <div class="stat bg-gradient-to-r from-green-500 to-teal-600 text-white rounded-2xl shadow-xl card-hover">
                    <div class="stat-figure">
                        <i class="fas fa-star text-3xl opacity-80"></i>
                    </div>
                    <div class="text-green-100 text-xl font-bold">Index Kepuasan</div>
                    <div class="stat-value text-white">{{ number_format($ikm, 2) }}%</div>
                    <div class="stat-desc text-green-100 text-lg font-semibold">{{ $mutu }}</div>
                </div>
                <div class="stat bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-2xl shadow-xl card-hover">
                    <div class="stat-figure">
                        <i class="fas fa-calendar text-3xl opacity-80"></i>
                    </div>

                    <div class="stat-title text-purple-100 text-xl font-bold">Unit Kerja</div>

                    {{-- Nama Unit --}}
                    <div class="stat-value text-white text-sm">
                        @if (request('unit_id'))
                            {{ $units->find(request('unit_id'))->nama ?? 'Unit' }}
                        @else
                            Semua Unit
                        @endif
                    </div>

                    {{-- Nama Layanan --}}
                    <div class="text-white text-sm">
                        @if (request('service_id'))
                            {{ $services->find(request('service_id'))->nama ?? 'Layanan' }}
                        @else
                            Semua Layanan
                        @endif
                    </div>

                    <div class="stat-desc text-purple-100 text-lg font-semibold">
                        {{ $units->count() }} Total Unit Pelayanan
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="flex flex-col-reverse lg:flex-row gap-4 lg:justify-around items-center">
                <!-- Satisfaction Pie Chart -->
                <div class="deskripsi">
                    <h3 class="text-4xl font-bold mb-4">Prosentase Kepuasan</h3>
                    <p class="text-xl font-semibold mb-6">Ini merupakan rangkuman prosentase berdasarkan jawaban responden
                    </p>
                    <p class="text-xl font-semibold mb-2">Jawaban terdiri dari</p>
                    <ul class="list-disc pl-12 text-lg">
                        <li>Sangat puas, dengan poin <span class="font-bold">4</span></li>
                        <li>Puas, dengan poin <span class="font-bold">3</span></li>
                        <li>Tidak Puas , dengan poin <span class="font-bold">2</span></li>
                        <li>Mengecewakan, dengan poin <span class="font-bold">1</span></li>
                    </ul>
                </div>
                <div class="card bg-base-100 w-full lg:w-5/6 shadow-xl card-hover animate-fade-in">
                    <div class="card-body">
                        <h2 class="card-title text-2xl mb-4">
                            <i class="fas fa-chart-pie text-primary mr-2"></i>
                            Responden Berdasarkan Kepuasan
                        </h2>
                        <div class="w-full h-80">
                            <canvas id="satisfactionChart"></canvas>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mt-4">
                            <div class="stat bg-success/10 rounded-lg">
                                <div class="stat-title text-xs text-white font-semibold">Sangat Puas</div>
                                <div class="stat-value text-lg text-success">{{ $persentaseKepuasan[4]['persen'] ?? 0 }}%
                                </div>
                            </div>
                            <div class="stat bg-info/10 rounded-lg">
                                <div class="stat-title text-xs text-white font-semibold">Puas</div>
                                <div class="stat-value text-lg text-info">{{ $persentaseKepuasan[3]['persen'] ?? 0 }}%
                                </div>
                            </div>
                            <div class="stat bg-warning/10 rounded-lg">
                                <div class="stat-title text-xs text-white font-semibold">Tidak Puas</div>
                                <div class="stat-value text-lg text-warning">{{ $persentaseKepuasan[2]['persen'] ?? 0 }}%
                                </div>
                            </div>
                            <div class="stat bg-error/10 rounded-lg">
                                <div class="stat-title text-xs text-white font-semibold">Kecewa</div>
                                <div class="stat-value text-lg text-error">{{ $persentaseKepuasan[1]['persen'] ?? 0 }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section2 mt-8 flex flex-col lg:flex-row gap-4 justify-between items-center">
                <div class="chart-bar w-full lg:w-2/3">
                    <div class="card bg-base-100 shadow-xl card-hover animate-fade-in">
                        <div class="card-body">
                            <h2 class="card-title text-2xl mb-4">
                                <i class="fas fa-briefcase text-primary mr-2"></i>
                                Jawaban Responden Per Kategori Soal
                            </h2>
                            <div class="w-full lg:w-5/6">
                                <canvas id="barSoal" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="weldjobnedu flex flex-col gap-4 w-full lg:w-1/3">
                    <div class="card bg-base-100 shadow-xl card-hover animate-fade-in">
                        <div class="card-body">
                            <h2 class="card-title text-2xl mb-4">
                                <i class="fas fa-graduation-cap text-primary mr-2"></i>
                                Responden Berdasarkan Pendidikan
                            </h2>
                            <div class="w-full h-80">
                                <canvas id="educationChart"></canvas>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-4">
                                @foreach ($pendidikanStat as $pendidikan => $stat)
                                    <div class="stat bg-info/10 rounded-lg">
                                        <div class="stat-title text-xs text-white font-semibold">{{ $pendidikan }}</div>
                                        <div class="stat-value text-lg text-info">{{ $stat['persen'] }}%</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="jobngender flex flex-col lg:flex-row items-start justify-around gap-4 w-full">
                <div class="card bg-base-100 shadow-xl card-hover animate-fade-in w-full lg:w-1/2">
                    <div class="card-body">
                        <h2 class="card-title text-2xl mb-4">
                            <i class="fas fa-briefcase text-primary mr-2"></i>
                            Responden Berdasarkan Pekerjaan
                        </h2>
                        <div class="w-full h-80">
                            <canvas id="jobChart"></canvas>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mt-4">
                            @foreach ($pekerjaanStat as $pekerjaan => $stat)
                                <div class="stat bg-warning/10 rounded-lg">
                                    <div class="stat-title text-xs font-semibold text-white">{{ $pekerjaan }}</div>
                                    <div class="stat-value text-lg text-warning">{{ $stat['persen'] }}%</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card bg-base-100 shadow-xl card-hover animate-fade-in w-full lg:w-1/2">
                    <div class="card-body">
                        <h2 class="card-title text-2xl mb-4">
                            <i class="fas fa-briefcase text-primary mr-2"></i>
                            Responden Berdasarkan Gender
                        </h2>
                        <div class="w-full h-80">
                            <canvas id="genderChart"></canvas>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mt-4">
                            @foreach ($genderStat as $gender => $stat)
                                @php
                                    $genders = match ($gender) {
                                        'L' => 'Laki - Laki',
                                        'P' => 'Perempuan',
                                    };
                                @endphp
                                <div class="stat bg-success/10 rounded-lg">
                                    <div class="stat-title text-xs font-semibold text-white">{{ $genders }}</div>
                                    <div class="stat-value text-lg text-success">{{ $stat['persen'] }}%</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h2 class="card-title text-2xl mb-4">
                    <i class="fas fa-briefcase text-primary mr-2"></i>
                    Responden Berdasarkan Usia
                </h2>
                <div class="w-full h-80">
                    <canvas id="usiaChart"></canvas>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-4">
                    @foreach ($usiaStat as $usia => $stat)
                        <div class="stat bg-info/10 rounded-lg">
                            <div class="stat-title text-xs font-semibold text-white">{{ $usia }}</div>
                            <div class="stat-value text-lg text-info">{{ $stat['persen'] }}%</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Education Chart -->


            <!-- Detailed Questions Table -->
            <div class="card bg-base-100 shadow-xl card-hover animate-fade-in">
                <div class="card-body">
                    <h2 class="card-title text-2xl mb-4">
                        <i class="fas fa-table text-primary mr-2"></i>
                        Detil Jawaban Responden Per Kategori
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr class="bg-primary text-primary-content">
                                    <th rowspan="2">No</th>
                                    <th rowspan="2" class="text-center">Unsur Pelayanan</th>
                                    <th colspan="4" class="text-center">Jumlah Responden yang Menjawab (orang)</th>
                                    <th rowspan="2">Nilai Rata2</th>
                                    <th rowspan="2">Mutu</th>
                                </tr>
                                <tr class="bg-primary text-primary-content">
                                    <th class="text-center">
                                        <div class="badge badge-success">Sangat Baik</div>
                                    </th>
                                    <th class="text-center">
                                        <div class="badge badge-info">Baik</div>
                                    </th>
                                    <th class="text-center">
                                        <div class="badge badge-warning">Kurang Baik</div>
                                    </th>
                                    <th class="text-center">
                                        <div class="badge badge-error">Tidak Baik</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mutuPerPertanyaan as $index => $item)
                                    <tr class="hover">
                                        <td class="font-bold text-base-content">U{{ $index + 1 }}</td>
                                        <td class="max-w-xs text-base-content">{{ $item['unsur_pelayanan'] }}</td>
                                        <td class="text-center font-bold text-success">
                                            {{ $item['jumlah_pilihan']['Sangat Baik'] ?? 0 }}</td>
                                        <td class="text-center font-bold text-info">
                                            {{ $item['jumlah_pilihan']['Baik'] ?? 0 }}</td>
                                        <td class="text-center font-bold text-warning">
                                            {{ $item['jumlah_pilihan']['Kurang Baik'] ?? 0 }}</td>
                                        <td class="text-center font-bold text-error">
                                            {{ $item['jumlah_pilihan']['Tidak Baik'] ?? 0 }}</td>
                                        <td class="font-bold text-primary text-center">{{ $item['nrr'] }}</td>
                                        <td>
                                            @php
                                                $huruf = match ($item['mutu']) {
                                                    'Sangat Baik' => 'A',
                                                    'Baik' => 'B',
                                                    'Kurang Baik' => 'C',
                                                    'Tidak Baik' => 'D',
                                                    default => '-',
                                                };
                                            @endphp
                                            <div
                                                class="badge font-semibold {{ $item['mutu'] === 'Sangat Baik' ? 'badge-success' : ($item['mutu'] === 'Baik' ? 'badge-info' : ($item['mutu'] === 'Kurang Baik' ? 'badge-warning' : 'badge-error')) }} badge-lg">
                                                {{ $huruf }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <x-footer></x-footer>
    </div>
    <script>
        // Data from Laravel Controller
        const surveyData = {
            satisfaction: [{
                    label: 'Sangat Puas',
                    value: {{ $persentaseKepuasan[4]['jumlah'] ?? 0 }},
                    color: '#10b981'
                },
                {
                    label: 'Puas',
                    value: {{ $persentaseKepuasan[3]['jumlah'] ?? 0 }},
                    color: '#3b82f6'
                },
                {
                    label: 'Tidak Puas',
                    value: {{ $persentaseKepuasan[2]['jumlah'] ?? 0 }},
                    color: '#f59e0b'
                },
                {
                    label: 'Kecewa',
                    value: {{ $persentaseKepuasan[1]['jumlah'] ?? 0 }},
                    color: '#ef4444'
                }
            ],
            jobs: [
                @foreach ($pekerjaanStat as $pekerjaan => $stat)
                    {
                        label: '{{ $pekerjaan }}',
                        value: {{ $stat['jumlah'] }},
                        color: '{{ ['#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'][$loop->index % 7] }}'
                    },
                @endforeach
            ],
            education: [
                @foreach ($pendidikanStat as $pendidikan => $stat)
                    {
                        label: '{{ $pendidikan }}',
                        value: {{ $stat['jumlah'] }},
                        color: '{{ ['#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'][$loop->index % 5] }}'
                    },
                @endforeach
            ],
            questionQuality: [
                @foreach ($mutuPerPertanyaan as $index => $mutu)
                    {
                        label: 'U{{ $index + 1 }}',
                        nrr: {{ $mutu['nrr'] }},
                        nilai: {{ $mutu['nilai'] }},
                        mutu: '{{ $mutu['mutu'] }}',
                        pertanyaan: '{{ Str::limit($mutu['pertanyaan'], 50) }}'
                    },
                @endforeach
            ],
            genderStat: [
                @foreach ($genderStat as $gender => $stat)
                    {
                        label: '{{ $gender }}',
                        value: {{ $stat['jumlah'] }},
                        color: '{{ ['#8b5cf6', '#06b6d4'][$loop->index % 2] }}'
                    },
                @endforeach
            ],
            usiaStats: [
                @foreach ($usiaStat as $usia => $stat)
                    {
                        label: '{{ $usia }}',
                        value: {{ $stat['jumlah'] }},
                        color: '{{ ['#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'][$loop->index % 5] }}'
                    },
                @endforeach
            ]
        };

        // Initialize charts
        function initCharts() {
            // Only create charts if data exists
            if (surveyData.satisfaction.some(item => item.value > 0)) {
                createPieChart('satisfactionChart', surveyData.satisfaction, 'Distribusi Kepuasan');
            }

            if (surveyData.jobs.length > 0 && surveyData.jobs.some(item => item.value > 0)) {
                createPieChart('jobChart', surveyData.jobs, 'Distribusi Pekerjaan');
            }

            if (surveyData.education.length > 0 && surveyData.education.some(item => item.value > 0)) {
                createPieChart('educationChart', surveyData.education, 'Distribusi Pendidikan');
            }
            if (surveyData.genderStat.length > 0 && surveyData.genderStat.some(item => item.value > 0)) {
                createPieChart('genderChart', surveyData.genderStat, 'Gender');
            }
            if (surveyData.questionQuality.length > 0) {
                createBarChart('barSoal', surveyData.questionQuality);
            }
            if (surveyData.usiaStats.length > 0 && surveyData.usiaStats.some(item => item.value > 0)) {
                createPieChart('usiaChart', surveyData.usiaStats, 'Usia Responden');
            }
        }

        function createPieChart(canvasId, data, title) {
            const ctx = document.getElementById(canvasId);
            if (!ctx) return;

            // Filter out zero values for cleaner charts
            const filteredData = data.filter(item => item.value > 0);

            if (filteredData.length === 0) {
                // Show no data message
                const container = ctx.parentElement;
                container.innerHTML =
                    '<div class="flex items-center justify-center h-80 text-gray-500"><div class="text-center"><i class="fas fa-chart-pie text-4xl mb-4"></i><p>Tidak ada data untuk ditampilkan</p></div></div>';
                return;
            }

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: filteredData.map(item => item.label),
                    datasets: [{
                        data: filteredData.map(item => item.value),
                        backgroundColor: filteredData.map(item => item.color),
                        borderWidth: 3,
                        borderColor: '#1f2937',
                        hoverBorderWidth: 5,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12,
                                    weight: '600',
                                },
                                color: '#ffffff'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#f9fafb',
                            bodyColor: '#f9fafb',
                            borderColor: '#374151',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + '';
                                }
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }

        function createBarChart(canvasId, data) {
            const ctx = document.getElementById(canvasId);
            if (!ctx) return;

            if (data.length === 0) {
                const container = ctx.parentElement;
                container.innerHTML =
                    '<div class="flex items-center justify-center h-80 text-gray-500"><div class="text-center"><i class="fas fa-chart-bar text-4xl mb-4"></i><p>Tidak ada data untuk ditampilkan</p></div></div>';
                return;
            }

            const chartData = {
                labels: data.map(item => item.label),
                datasets: [{
                    label: 'Mutu',
                    data: data.map(item => item.nrr),
                    backgroundColor: '#2196F3',
                    borderColor: '#2196F3',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            };

            new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#f9fafb',
                            bodyColor: '#f9fafb',
                            borderColor: '#374151',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    const questionData = data[context.dataIndex];
                                    return [
                                        `Mutu: ${context.parsed.y}`,
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 4.0,
                            ticks: {
                                stepSize: 1.0,
                                callback: function(value) {
                                    return value.toFixed(2);
                                },
                                color: '#ffffff'
                            },
                            grid: {
                                color: '#374151'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#ffffff'
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    onComplete: function(chart) {
                        const ctx = chart.chart.ctx;
                        ctx.font = 'bold 14px Arial';
                        ctx.fillStyle = 'white';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';

                        chart.data.datasets.forEach(function(dataset, i) {
                            const meta = chart.chart.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                const data = dataset.data[index];
                                const yPosition = bar.y + (bar.height / 2);
                                ctx.fillText(data, bar.x, yPosition);
                            });
                        });
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} fixed top-4 right-4 w-auto z-50 shadow-lg`;
            toast.innerHTML = `
            <div>
                <span>${message}</span>
            </div>
        `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initCharts();

            // Show success message if filters are applied
            @if (request()->hasAny(['unit_id', 'tanggal_awal', 'tanggal_akhir']))
                showToast('Filter berhasil diterapkan!', 'success');
            @endif

            // Add smooth scroll for better UX
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });

        // Add loading state to form submission
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="loading loading-spinner loading-sm"></span> Memproses...';
            button.disabled = true;
        });
    </script>
@endsection
