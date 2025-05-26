<x-filament::page>
    <h1 class="text-xl font-bold mb-4">Laporan Survei</h1>

    <form method="GET" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Rentang Tanggal -->
            <div>
                <label for="from_date" class="block text-sm font-medium">Dari Tanggal</label>
                <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                    class="w-full rounded-md">
            </div>
            <div>
                <label for="to_date" class="block text-sm font-medium">Sampai Tanggal</label>
                <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                    class="w-full rounded-md">
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

        <div class="mt-4">
            <x-filament::button type="submit">Terapkan Filter</x-filament::button>
        </div>
    </form>

    <table class="w-full table-auto mt-6 border">
        <thead>
            <tr class="">
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Unit</th>
                <th class="border px-4 py-2">Layanan</th>
                <th class="border px-4 py-2">Jenis Kelamin</th>
                <th class="border px-4 py-2">Usia</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td class="border px-4 py-2">{{ $item->created_at->format('d-m-Y') }}</td>
                    <td class="border px-4 py-2">{{ $item->unit->nama }}</td>
                    <td class="border px-4 py-2">{{ $item->service->nama }}</td>
                    <td class="border px-4 py-2">{{ $item->jenis_kelamin }}</td>
                    <td class="border px-4 py-2">{{ $item->usia }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-filament::page>
