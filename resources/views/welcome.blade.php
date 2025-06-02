@extends('layouts.app')
@section('title', 'SurveyLo')

@section('meta_description',
    'Selamat datang di aplikasi Survei Kepuasan Masyarakat (SKM). Mari berpartisipasi untuk
    meningkatkan kualitas pelayanan publik.')

@section('og_description',
    'Ayo ikut Survei Kepuasan Masyarakat! Bersama kita tingkatkan kualitas layanan publik yang
    lebih baik.')
@section('content')
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
    <div class="main bg-base-200 min-h-screen" data-theme="dark">
        <!-- Hero Section -->
        <div class="hero min-h-[70vh] bg-gradient-to-br from-primary/20 to-secondary/20">
            <div class="hero-content flex-col lg:flex-row-reverse justify-between items-center w-full max-w-7xl px-8">
                <!-- Image Section -->
                <div class="flex-shrink-0 mb-8 lg:mb-0 lg:ml-8 overflow-hidden">
                    <div class="relative">
                        <img src="{{ asset('image/skm.webp') }}" alt="SKM" data-aos="fade-left" data-aos-duration="1000"
                            class="w-80 lg:w-96 h-auto rounded-2xl shadow-2xl">
                    </div>
                </div>

                <!-- Content Section -->
                <div class="flex-1 text-center lg:text-left">
                    <div class="max-w-2xl">
                        <h1 class="text-4xl lg:text-6xl font-bold leading-tight mb-6" data-aos="fade-up"
                            data-aos-duration="800">
                            Welcome To
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary"
                                data-aos="fade-up" data-aos-duration="800">
                                SurveyLo
                            </span>
                        </h1>

                        <p class="text-xl lg:text-2xl font-medium mb-8 text-base-content/80 leading-relaxed"
                            data-aos="fade-up" data-aos-duration="1000">
                            Pengukuran secara komprehensif tingkat kepuasan masyarakat terhadap pelayanan yang diterima.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start" data-aos="fade-up"
                            data-aos-duration="1000">
                            <a href="{{ route('survey.index') }}"
                                class="btn btn-primary btn-lg shadow-lg hover:shadow-xl transition-all duration-300">
                                <i class="fas fa-play mr-2"></i>
                                Mulai Survey Yuk!
                            </a>

                            <button class="btn btn-outline btn-lg" onclick="scrollToSection('about')" data-aos="fade-up"
                                data-aos-duration="1000">
                                <i class="fas fa-info-circle mr-2"></i>
                                Pelajari Lebih Lanjut
                            </button>
                        </div>

                        <!-- Stats -->
                        <div class="stats stats-vertical lg:stats-horizontal shadow-lg mt-8 bg-base-100/80 backdrop-blur-sm"
                            data-aos="fade-up" data-aos-duration="900">
                            <div class="stat">
                                <div class="stat-figure text-primary">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                                <div class="stat-title">Total Responden</div>
                                <div class="stat-value text-primary">{{ number_format($totalResponden) }}</div>
                                <div class="stat-desc">Sejak diluncurkan</div>
                            </div>
                            <div class="stat">
                                <div class="stat-figure text-accent">
                                    <i class="fas fa-clipboard-list text-2xl"></i>
                                </div>
                                <div class="stat-title">Unit Aktif</div>
                                <div class="stat-value text-accent">{{ number_format($totalUnits) }}</div>
                                <div class="stat-desc">Tersedia saat ini</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <section id="about" class="py-20 bg-base-100">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold mb-4" data-aos="fade-up" data-aos-duration="900">Apa itu SKM?</h2>
                    <p class="text-xl text-base-content/70 max-w-3xl mx-auto" data-aos="fade-up" data-aos-duration="900">
                        Survey Kepuasan Masyarakat (SKM) adalah alat ukur untuk mengetahui tingkat kinerja unit pelayanan
                        secara berkala sebagai bahan untuk meningkatkan kualitas pelayanan publik.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-aos="fade-up" data-aos-duration="900">
                    <div
                        class="card bg-base-200 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                        <div class="card-body text-center">
                            <div class="mx-auto mb-4">
                                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center">
                                    <i class="fas fa-clipboard-check text-2xl text-primary-content"></i>
                                </div>
                            </div>
                            <h3 class="card-title justify-center text-xl mb-2">Mudah & Cepat</h3>
                            <p class="text-base-content">
                                Survey dapat diselesaikan dalam 5-10 menit dengan pertanyaan yang jelas dan mudah dipahami.
                            </p>
                        </div>
                    </div>

                    <div
                        class="card bg-base-200 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                        <div class="card-body text-center">
                            <div class="mx-auto mb-4">
                                <div class="w-16 h-16 bg-secondary rounded-full flex items-center justify-center">
                                    <i class="fas fa-shield-alt text-2xl text-secondary-content"></i>
                                </div>
                            </div>
                            <h3 class="card-title justify-center text-xl mb-2">Aman & Terpercaya</h3>
                            <p class="text-base-content">
                                Data pribadi Anda aman dan hanya digunakan untuk keperluan evaluasi pelayanan publik.
                            </p>
                        </div>
                    </div>

                    <div
                        class="card bg-base-200 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                        <div class="card-body text-center">
                            <div class="mx-auto mb-4">
                                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-chart-line text-2xl text-white"></i>
                                </div>
                            </div>
                            <h3 class="card-title justify-center text-xl mb-2">Berdampak Nyata</h3>
                            <p class="text-base-content">
                                Masukan Anda membantu meningkatkan kualitas pelayanan publik untuk masyarakat yang lebih
                                baik.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-20 bg-base-200">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold mb-4" data-aos="fade-up" data-aos-duration="900">Cara Kerja SKM</h2>
                    <p class="text-xl text-base-content/70" data-aos="fade-up" data-aos-duration="900">
                        Proses survey yang sederhana dan efektif
                    </p>
                </div>

                <!-- Steps DaisyUI -->
                <ul class="steps steps-vertical lg:steps-horizontal w-full" data-aos="fade-up" data-aos-duration="900">
                    <li class="step step-primary" data-content="1">
                        <div class="text-center mt-4">
                            <h3 class="text-lg font-semibold">Pilih Layanan</h3>
                            <p class="text-base-content/70 max-w-xs mx-auto">
                                Pilih jenis pelayanan yang telah Anda terima
                            </p>
                        </div>
                    </li>

                    <li class="step step-primary" data-content="2">
                        <div class="text-center mt-4">
                            <h3 class="text-lg font-semibold">Isi Survey</h3>
                            <p class="text-base-content/70 max-w-xs mx-auto">
                                Jawab pertanyaan sesuai pengalaman Anda
                            </p>
                        </div>
                    </li>

                    <li class="step step-primary" data-content="3">
                        <div class="text-center mt-4">
                            <h3 class="text-lg font-semibold">Berikan Rating</h3>
                            <p class="text-base-content/70 max-w-xs mx-auto">
                                Beri penilaian untuk kualitas pelayanan yang anda terima
                            </p>
                        </div>
                    </li>

                    <li class="step step-primary" data-content="4">
                        <div class="text-center mt-4">
                            <h3 class="text-lg font-semibold">Selesai</h3>
                            <p class="text-base-content/70 max-w-xs mx-auto">
                                Terima kasih atas partisipasi Anda!
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <!-- FAQ Section -->
        <section id="faq" class="py-20 bg-base-100">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold mb-4" data-aos="fade-up" data-aos-duration="900">Pertanyaan yang Sering
                        Diajukan</h2>
                    <p class="text-xl text-base-content/70" data-aos="fade-up" data-aos-duration="900">
                        Temukan jawaban untuk pertanyaan umum tentang SKM
                    </p>
                </div>

                <div class="max-w-4xl mx-auto bg-base-300 rounded-lg shadow-xl">
                    <div class="join join-vertical w-full">
                        <div class="collapse collapse-arrow join-item border border-base-300">
                            <input type="radio" name="faq-accordion" checked="checked" />
                            <div class="collapse-title text-xl font-medium">
                                Apa itu Survey Kepuasan Masyarakat (SKM)?
                            </div>
                            <div class="collapse-content">
                                <p class="text-base-content/70">
                                    SKM adalah instrumen untuk mengukur tingkat kepuasan masyarakat terhadap pelayanan
                                    publik
                                    yang diberikan oleh penyelenggara pelayanan publik. SKM bertujuan untuk meningkatkan
                                    kualitas pelayanan berdasarkan masukan dari masyarakat.
                                </p>
                            </div>
                        </div>

                        <div class="collapse collapse-arrow join-item border border-base-300">
                            <input type="radio" name="faq-accordion" />
                            <div class="collapse-title text-xl font-medium">
                                Berapa lama waktu yang diperlukan untuk mengisi survey?
                            </div>
                            <div class="collapse-content">
                                <p class="text-base-content/70">
                                    Survey dapat diselesaikan dalam waktu 5-10 menit. Kami telah merancang pertanyaan
                                    yang singkat namun komprehensif untuk menghemat waktu Anda.
                                </p>
                            </div>
                        </div>

                        <div class="collapse collapse-arrow join-item border border-base-300">
                            <input type="radio" name="faq-accordion" />
                            <div class="collapse-title text-xl font-medium">
                                Apakah data pribadi saya aman?
                            </div>
                            <div class="collapse-content">
                                <p class="text-base-content/70">
                                    Ya, keamanan data pribadi Anda adalah prioritas utama kami. Semua informasi yang
                                    Anda berikan akan dijaga kerahasiaan dan hanya digunakan untuk tujuan evaluasi
                                    dan peningkatan pelayanan publik.
                                </p>
                            </div>
                        </div>

                        <div class="collapse collapse-arrow join-item border border-base-300">
                            <input type="radio" name="faq-accordion" />
                            <div class="collapse-title text-xl font-medium">
                                Bagaimana hasil survey digunakan?
                            </div>
                            <div class="collapse-content">
                                <p class="text-base-content/70">
                                    Hasil survey dianalisis dan digunakan sebagai bahan evaluasi untuk meningkatkan
                                    kualitas pelayanan. Laporan hasil survey juga dibagikan kepada unit-unit terkait
                                    untuk tindak lanjut perbaikan.
                                </p>
                            </div>
                        </div>

                        <div class="collapse collapse-arrow join-item border border-base-300">
                            <input type="radio" name="faq-accordion" />
                            <div class="collapse-title text-xl font-medium">
                                Apakah saya bisa mengisi survey lebih dari sekali?
                            </div>
                            <div class="collapse-content">
                                <p class="text-base-content/70">
                                    Ya, Anda dapat mengisi survey untuk setiap layanan yang berbeda yang pernah Anda terima.
                                    Namun untuk layanan yang sama, kami sarankan untuk mengisi survey setelah ada
                                    pengalaman pelayanan yang baru.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <x-footer></x-footer>

    <script>
        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script>
@endsection
