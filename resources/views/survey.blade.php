@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-base-300 py-8">
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif
        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: '{{ session('error') }}'
                    });
                });
            </script>
        @endif

        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Header Card -->
                <div class="card bg-base-100 shadow-xl mb-6">
                    <div class="card-body text-center">
                        <h1 class="card-title text-3xl font-bold text-primary justify-center">
                            Survey Kepuasan Layanan
                        </h1>
                        <p class="text-base-content/70 mt-2">
                            Mohon untuk dijawab dengan jujur dan lengkap
                        </p>
                    </div>
                </div>

                <!-- Main Form Card -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body space-y-8">
                        <form action="{{ route('survey.start') }}" method="POST">
                            @csrf
                            <!-- Department and Service Selection -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text text-lg font-semibold">Pilih Unit</span>
                                    </label>
                                    <select id="unitSelect" name="unit_id" required
                                        class="select select-bordered select-primary w-full">
                                        <option disabled selected>Pilih Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text text-lg font-semibold">Pilih Layanan</span>
                                    </label>
                                    <select id="serviceSelect" name="service_id" required
                                        class="select select-bordered select-primary w-full">
                                        <option disabled selected>Pilih Layanan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <!-- Age Selection -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-lg font-semibold">Usia</span>
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-primary hover:bg-primary/5 transition-all">
                                            <input type="radio" name="usia" value="<17"
                                                class="radio radio-primary" />
                                            <span class="label-text text-center">Dibawah 17 Tahun</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-primary hover:bg-primary/5 transition-all">
                                            <input type="radio" name="usia" value="17-30"
                                                class="radio radio-primary" />
                                            <span class="label-text text-center">17-30 Tahun</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-primary hover:bg-primary/5 transition-all">
                                            <input type="radio" name="usia" value="31-40"
                                                class="radio radio-primary" />
                                            <span class="label-text text-center">31-40 Tahun</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-primary hover:bg-primary/5 transition-all">
                                            <input type="radio" name="usia" value="41-50"
                                                class="radio radio-primary" />
                                            <span class="label-text text-center">41-50 Tahun</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-primary hover:bg-primary/5 transition-all">
                                            <input type="radio" name="usia" value=">50"
                                                class="radio radio-primary" />
                                            <span class="label-text text-center">Diatas 50 Tahun</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <!-- Gender Selection -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-lg font-semibold">Jenis Kelamin</span>
                                </label>
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-6 rounded-lg border border-base-300 hover:border-primary hover:bg-primary/5 transition-all">
                                            <input type="radio" name="jenis_kelamin" value="L"
                                                class="radio radio-primary" />
                                            <span class="label-text text-center font-medium">Laki-laki</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-6 rounded-lg border border-base-300 hover:border-secondary hover:bg-secondary/5 transition-all">
                                            <input type="radio" name="jenis_kelamin" value="P"
                                                class="radio radio-secondary" />
                                            <span class="label-text text-center font-medium">Perempuan</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <!-- Education Selection -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-lg font-semibold">Pendidikan Terakhir</span>
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 mt-4">
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-accent hover:bg-accent/5 transition-all">
                                            <input type="radio" name="pendidikan" value="SD Kebawah"
                                                class="radio radio-accent" />
                                            <span class="label-text text-center">SD Kebawah</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-accent hover:bg-accent/5 transition-all">
                                            <input type="radio" name="pendidikan" value="SMP"
                                                class="radio radio-accent" />
                                            <span class="label-text text-center">SMP</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-accent hover:bg-accent/5 transition-all">
                                            <input type="radio" name="pendidikan" value="SMA/K"
                                                class="radio radio-accent" />
                                            <span class="label-text text-center">SMA/K</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-accent hover:bg-accent/5 transition-all">
                                            <input type="radio" name="pendidikan" value="D1-D4"
                                                class="radio radio-accent" />
                                            <span class="label-text text-center">D1 - D4</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-accent hover:bg-accent/5 transition-all">
                                            <input type="radio" name="pendidikan" value="S1"
                                                class="radio radio-accent" />
                                            <span class="label-text text-center">S1</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-accent hover:bg-accent/5 transition-all">
                                            <input type="radio" name="pendidikan" value="S2 Keatas"
                                                class="radio radio-accent" />
                                            <span class="label-text text-center">S2 Keatas</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <!-- Job Selection -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text text-lg font-semibold">Pekerjaan</span>
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-warning hover:bg-warning/5 transition-all">
                                            <input type="radio" name="pekerjaan" value="TNI"
                                                class="radio radio-warning" />
                                            <span class="label-text text-center">TNI</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-warning hover:bg-warning/5 transition-all">
                                            <input type="radio" name="pekerjaan" value="PNS"
                                                class="radio radio-warning" />
                                            <span class="label-text text-center">PNS</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-warning hover:bg-warning/5 transition-all">
                                            <input type="radio" name="pekerjaan" value="Pegawai Swasta"
                                                class="radio radio-warning" />
                                            <span class="label-text text-center">Pegawai Swasta</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-warning hover:bg-warning/5 transition-all">
                                            <input type="radio" name="pekerjaan" value="Wirausaha"
                                                class="radio radio-warning" />
                                            <span class="label-text text-center">Wirausaha</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-warning hover:bg-warning/5 transition-all">
                                            <input type="radio" name="pekerjaan" value="Polri"
                                                class="radio radio-warning" />
                                            <span class="label-text text-center">Polri</span>
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label
                                            class="label cursor-pointer flex-col gap-3 p-4 rounded-lg border border-base-300 hover:border-warning hover:bg-warning/5 transition-all">
                                            <input type="radio" name="pekerjaan" value="Lainnya"
                                                class="radio radio-warning" />
                                            <span class="label-text text-center">Lainnya</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <!-- Action Buttons -->
                            <div class="card-actions justify-end pt-4">
                                <button class="btn btn-primary btn-lg" type="submit">
                                    Lanjutkan
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('unitSelect').addEventListener('change', function() {
            const unitId = this.value;
            fetch(`/get-services/${unitId}`)
                .then(res => res.json())
                .then(data => {
                    const serviceSelect = document.getElementById('serviceSelect');
                    serviceSelect.innerHTML = '<option disabled selected>Pilih Layanan</option>';
                    data.forEach(service => {
                        const option = document.createElement('option');
                        option.value = service.id;
                        option.textContent = service.nama;
                        serviceSelect.appendChild(option);
                    });
                });
        });

        // Add form validation and interaction
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth transitions for radio button selections
            const radioGroups = document.querySelectorAll('input[type="radio"]');
            radioGroups.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Remove selected state from siblings
                    const siblings = document.querySelectorAll(`input[name="${this.name}"]`);
                    siblings.forEach(sibling => {
                        sibling.closest('label').classList.remove('border-primary',
                            'bg-primary/10');
                    });

                    // Add selected state to current
                    this.closest('label').classList.add('border-primary', 'bg-primary/10');
                });
            });
        });
    </script>
@endsection
