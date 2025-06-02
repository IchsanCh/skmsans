<x-filament::page>
    <h1 class="text-xl font-bold mb-4">Laporan Survei</h1>

    <form method="GET" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Rentang Tanggal -->
            <div>
                <label for="from_date" class="block text-sm font-medium">Dari Tanggal</label>
                <input type="date" name="from_date" id="from_date"
                    value="{{ request('from_date') ?? now()->startOfMonth()->toDateString() }}"
                    class="w-full rounded-md">
            </div>
            <div>
                <label for="to_date" class="block text-sm font-medium">Sampai Tanggal</label>
                <input type="date" name="to_date" id="to_date"
                    value="{{ request('to_date') ?? now()->endOfMonth()->toDateString() }}" class="w-full rounded-md">
            </div>

            <!-- Filter Unit -->
            <div>
                <label for="unit_id" class="block text-sm font-medium">Unit</label>
                <select name="unit_id" id="unit_id" class="w-full rounded-md">
                    <option value="">Semua</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" @selected(request('unit_id') == $unit->id)>{{ $unit->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Layanan -->
            <div>
                <label for="service_id" class="block text-sm font-medium">Layanan</label>
                <select name="service_id" id="service_id" class="w-full rounded-md">
                    <option value="">Semua</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" @selected(request('service_id') == $service->id)>{{ $service->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Jenis Kelamin -->
            <div>
                <label for="jenis_kelamin" class="block text-sm font-medium">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="w-full rounded-md">
                    <option value="">Semua</option>
                    <option value="L" @selected(request('jenis_kelamin') == 'L')>Laki-laki</option>
                    <option value="P" @selected(request('jenis_kelamin') == 'P')>Perempuan</option>
                </select>
            </div>

            <!-- Filter Usia -->
            <div>
                <label for="usia" class="block text-sm font-medium">Usia</label>
                <input type="text" name="usia" id="usia" value="{{ request('usia') }}"
                    placeholder="Contoh: 20-30" class="w-full rounded-md">
            </div>
        </div>

        <div style="margin-top: 1rem" class="flex items-center gap-2">
            <x-filament::button type="submit">Terapkan Filter</x-filament::button>
            <x-filament::button tag="a" href="{{ route('survei.export', request()->query()) }}" color="success">
                Export Excel
            </x-filament::button>
        </div>
    </form>

    <!-- Info Total Data -->
    <div class="mb-4 p-3 bg-blue-50 rounded-lg">
        <p class="text-sm text-blue-800">
            Menampilkan {{ ($currentPage - 1) * $perPage + 1 }} - {{ min($currentPage * $perPage, $totalRecords) }}
            dari total {{ number_format($totalRecords) }} data
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto mt-6 border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">Tanggal</th>
                    <th class="border px-4 py-2 text-left">Response ID</th>
                    <th class="border px-4 py-2 text-left">Unit</th>
                    <th class="border px-4 py-2 text-left">Layanan</th>
                    <th class="border px-4 py-2 text-left">Usia</th>
                    <th class="border px-4 py-2 text-left">Jenis Kelamin</th>
                    <th class="border px-4 py-2 text-left">Pendidikan</th>
                    <th class="border px-4 py-2 text-left">Pekerjaan</th>
                    <th class="border px-4 py-2 text-left">Masukan</th>
                    <th class="border px-4 py-2 text-center">U1</th>
                    <th class="border px-4 py-2 text-center">U2</th>
                    <th class="border px-4 py-2 text-center">U3</th>
                    <th class="border px-4 py-2 text-center">U4</th>
                    <th class="border px-4 py-2 text-center">U5</th>
                    <th class="border px-4 py-2 text-center">U6</th>
                    <th class="border px-4 py-2 text-center">U7</th>
                    <th class="border px-4 py-2 text-center">U8</th>
                    <th class="border px-4 py-2 text-center">U9</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $item->created_at->format('d-m-Y') }}</td>
                        <td class="border px-4 py-2">{{ $item->id }}</td>
                        <td class="border px-4 py-2">{{ $item->unit->nama ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $item->service->nama ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $item->usia }}</td>
                        <td class="border px-4 py-2">{{ $item->jenis_kelamin }}</td>
                        <td class="border px-4 py-2">{{ $item->pendidikan }}</td>
                        <td class="border px-4 py-2">{{ $item->pekerjaan }}</td>
                        <td class="border px-4 py-2">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->masukan), 100, '...') }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            {{ optional($item->responseAnswers->firstWhere('question_id', 1)?->questionOption)->bobot ?? '-' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            {{ optional($item->responseAnswers->firstWhere('question_id', 2)?->questionOption)->bobot ?? '-' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            {{ optional($item->responseAnswers->firstWhere('question_id', 3)?->questionOption)->bobot ?? '-' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            {{ optional($item->responseAnswers->firstWhere('question_id', 4)?->questionOption)->bobot ?? '-' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            {{ optional($item->responseAnswers->firstWhere('question_id', 5)?->questionOption)->bobot ?? '-' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            {{ optional($item->responseAnswers->firstWhere('question_id', 6)?->questionOption)->bobot ?? '-' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            {{ optional($item->responseAnswers->firstWhere('question_id', 7)?->questionOption)->bobot ?? '-' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            {{ optional($item->responseAnswers->firstWhere('question_id', 8)?->questionOption)->bobot ?? '-' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            {{ optional($item->responseAnswers->firstWhere('question_id', 9)?->questionOption)->bobot ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="18" class="text-center py-8 text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="text-lg font-medium">Data tidak ditemukan</p>
                                <p class="text-sm">Coba ubah filter pencarian Anda</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($totalRecords > $perPage)
        <div class="mt-6 flex items-center justify-between">
            <div class="flex items-center text-sm text-gray-700">
                <span>Halaman {{ $currentPage }} dari {{ $this->getTotalPages() }}</span>
            </div>

            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <!-- Previous Button -->
                @if ($this->hasPreviousPage())
                    <a href="{{ $this->getPreviousPageUrl() }}"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </a>
                @else
                    <span
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-300 cursor-not-allowed">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif

                <!-- Page Numbers -->
                @foreach ($this->getPageRange() as $page)
                    @if ($page == $currentPage)
                        <span
                            class="relative inline-flex items-center px-4 py-2 border border-primary-300 bg-primary-50 text-sm font-medium text-primary-600">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $this->getPageUrl($page) }}"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                <!-- Next Button -->
                @if ($this->hasNextPage())
                    <a href="{{ $this->getNextPageUrl() }}"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <span
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-300 cursor-not-allowed">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </nav>
        </div>
    @endif

</x-filament::page>
