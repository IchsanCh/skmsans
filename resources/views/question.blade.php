@extends('layouts.app')
@section('title', 'Isi Survei Kepuasan Masyarakat')

@section('meta_description',
    'Isi survei kepuasan masyarakat secara mudah dan cepat. Pendapat Anda sangat penting untuk
    peningkatan layanan publik.')

@section('og_description',
    'Pendapat Anda penting! Isi survei SKM sekarang dan bantu tingkatkan pelayanan publik di
    instansi kami.')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-base-200 via-base-100 to-base-200">
        <!-- Progress Bar -->
        <div class="sticky top-0 z-50 bg-base-100/80 backdrop-blur-md border-b border-base-300">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-base-content/70">Progress</span>
                    <span class="text-sm font-medium text-primary" id="progress-text">0 / {{ count($questions) }}</span>
                </div>
                <div class="w-full bg-base-200 rounded-full h-2 overflow-hidden">
                    <div class="progress-bar h-full rounded-full" id="progress-fill" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-12">
            <div class="max-w-3xl mx-auto">
                <!-- Hero Section -->
                <div class="text-center mb-12">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-primary to-secondary mb-6 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <h1
                        class="text-4xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-4">
                        Survey Kepuasan Layanan
                    </h1>
                    <p class="text-lg text-base-content/70 max-w-2xl mx-auto">
                        Bantu kami meningkatkan kualitas pelayanan dengan memberikan penilaian yang jujur dan konstruktif
                    </p>
                </div>

                <form action="{{ route('survey.submit') }}" method="POST" id="survey-form">
                    @csrf

                    <!-- Questions Container -->
                    <div class="space-y-8" id="questions-container">
                        @foreach ($questions as $index => $question)
                            <div class="question-card opacity-0 translate-y-8" data-question="{{ $index + 1 }}"
                                style="animation-delay: {{ $index * 0.1 }}s">
                                <div
                                    class="card bg-base-100 shadow-xl border-0 overflow-hidden hover:shadow-2xl transition-all duration-500">
                                    <!-- Card Header -->
                                    <div class="bg-gradient-to-r from-primary/10 to-secondary/10 px-8 py-6">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-12 h-12 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center shadow-lg">
                                                    <span class="text-white font-bold text-lg">{{ $index + 1 }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="text-xl font-semibold text-base-content leading-relaxed">
                                                    {{ $question->pertanyaan }}
                                                </h3>
                                                <div class="mt-2 flex items-center gap-2 text-sm text-base-content/60">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Pilih salah satu jawaban
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body p-8">
                                        <div class="space-y-3">
                                            @foreach ($question->questionOptions as $optionIndex => $option)
                                                <div
                                                    class="option-item transform transition-all duration-300 hover:scale-[1.02]">
                                                    <label
                                                        class="flex items-center gap-4 p-5 rounded-2xl border-2 border-base-200 hover:border-primary/50 hover:bg-primary/5 cursor-pointer transition-all duration-300 group">
                                                        <div class="flex-shrink-0">
                                                            <input type="radio" name="answers[{{ $question->id }}]"
                                                                value="{{ $option->id }}"
                                                                class="radio radio-primary radio-lg scale-125" required />
                                                        </div>
                                                        <div class="flex items-center gap-3 flex-1">
                                                            <div
                                                                class="w-8 h-8 rounded-full bg-base-200 flex items-center justify-center text-sm font-bold group-hover:bg-primary group-hover:text-white transition-colors">
                                                                {{ chr(65 + $optionIndex) }}
                                                            </div>
                                                            <span
                                                                class="text-base font-medium text-base-content group-hover:text-primary transition-colors">
                                                                {{ $option->label }}
                                                            </span>
                                                        </div>
                                                        <div
                                                            class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 text-primary" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Feedback Section -->
                    <div class="mt-12">
                        <div
                            class="card bg-gradient-to-br from-secondary/10 to-accent/10 shadow-xl border-0 overflow-hidden">
                            <div class="card-body p-8">
                                <div class="flex items-start gap-4 mb-6">
                                    <div
                                        class="w-12 h-12 rounded-full bg-gradient-to-br from-secondary to-accent flex items-center justify-center shadow-lg flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-base-content mb-2">
                                            Saran & Masukan
                                        </h3>
                                        <p class="text-base-content/70">
                                            Bagikan pendapat Anda untuk membantu kami memberikan pelayanan yang lebih baik
                                        </p>
                                    </div>
                                </div>

                                <div class="form-control">
                                    <textarea name="masukan" id="masukan" maxlength="500"
                                        class="textarea textarea-bordered textarea-lg min-h-32 text-base resize-none focus:textarea-primary transition-all duration-300"
                                        placeholder="Tuliskan saran, kritik, atau pengalaman Anda..."></textarea>
                                    <div class="label">
                                        <span class="label-text-alt text-base-content/60 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Bagian ini bersifat opsional
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="mt-12">
                        <div
                            class="card bg-gradient-to-r from-success/10 to-info/10 border-2 border-dashed border-success/30 shadow-xl">
                            <div class="card-body text-center p-8">
                                <div class="mb-6">
                                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-success/20 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-success font-medium">Siap untuk mengirim?</span>
                                    </div>
                                </div>

                                <p class="text-base-content/70 mb-8 max-w-md mx-auto">
                                    Pastikan semua pertanyaan telah dijawab sebelum mengirim survey
                                </p>

                                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                    <button type="button" class="btn btn-outline btn-lg" onclick="history.back()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Kembali
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg px-8" id="submit-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        Kirim Survey
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .question-card {
            animation: slideInUp 0.6s ease-out forwards;
        }

        .progress-bar {
            transition: width 0.5s ease-in-out;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            width: 0%;
        }

        .option-selected {
            border-color: #3b82f6 !important;
            background-color: rgba(59, 130, 246, 0.1) !important;
            transform: scale(1.02);
        }

        .option-selected .radio {
            animation: pulse 0.5s ease-in-out;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalQuestions = {{ count($questions) }};
            let answeredQuestions = 0;

            // Progress tracking
            function updateProgress() {
                const progressBar = document.getElementById('progress-fill');
                const progressText = document.getElementById('progress-text');
                const percentage = (answeredQuestions / totalQuestions) * 100;

                if (progressBar && progressText) {
                    progressBar.style.width = percentage + '%';
                    progressText.textContent = `${answeredQuestions} / ${totalQuestions}`;
                }
            }

            // Enhanced radio button interactions
            const radioInputs = document.querySelectorAll('input[type="radio"]');
            const questionNames = new Set();

            radioInputs.forEach(radio => {
                const questionName = radio.name;
                questionNames.add(questionName);

                radio.addEventListener('change', function() {
                    const allOptionsInQuestion = document.querySelectorAll(
                        `input[name="${questionName}"]`);

                    // Remove selected state from all options in this question
                    allOptionsInQuestion.forEach(option => {
                        const label = option.closest('label');
                        if (label) {
                            label.classList.remove('option-selected');
                        }
                    });

                    // Add selected state to current option
                    const currentLabel = this.closest('label');
                    if (currentLabel) {
                        currentLabel.classList.add('option-selected');
                    }

                    // Update progress - count unique answered questions
                    const answeredQuestionsSet = new Set();
                    document.querySelectorAll('input[type="radio"]:checked').forEach(
                        checkedRadio => {
                            answeredQuestionsSet.add(checkedRadio.name);
                        });

                    answeredQuestions = answeredQuestionsSet.size;
                    updateProgress();

                    // Smooth scroll to next question
                    setTimeout(() => {
                        const currentCard = this.closest('.question-card');
                        const nextCard = currentCard?.nextElementSibling;

                        if (nextCard && nextCard.classList.contains('question-card')) {
                            nextCard.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        } else if (answeredQuestions === totalQuestions) {
                            // Scroll to feedback section if all questions answered
                            const textarea = document.querySelector('textarea');
                            if (textarea) {
                                textarea.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }
                        }
                    }, 300);
                });
            });

            // Form submission with validation
            const form = document.getElementById('survey-form');
            const submitBtn = document.getElementById('submit-btn');

            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    if (answeredQuestions < totalQuestions) {
                        e.preventDefault();

                        // Remove existing alerts
                        const existingAlert = form.querySelector('.alert');
                        if (existingAlert) {
                            existingAlert.remove();
                        }

                        // Show alert for incomplete form
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-warning shadow-lg mb-4';
                        alert.innerHTML = `
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                <span>Mohon jawab semua pertanyaan sebelum mengirim survey (${answeredQuestions}/${totalQuestions} terjawab)</span>
                            </div>
                        `;

                        form.prepend(alert);

                        // Scroll to first unanswered question
                        const firstUnanswered = Array.from(questionNames).find(name => {
                            return !document.querySelector(`input[name="${name}"]:checked`);
                        });

                        if (firstUnanswered) {
                            const firstUnansweredInput = document.querySelector(
                                `input[name="${firstUnanswered}"]`);
                            if (firstUnansweredInput) {
                                const questionCard = firstUnansweredInput.closest('.question-card');
                                if (questionCard) {
                                    questionCard.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'center'
                                    });
                                }
                            }
                        }

                        // Remove alert after 5 seconds
                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.remove();
                            }
                        }, 5000);
                        return;
                    }

                    // Show loading state
                    submitBtn.innerHTML = `
                        <span class="loading loading-spinner loading-sm mr-2"></span>
                        Mengirim...
                    `;
                    submitBtn.disabled = true;
                });
            }

            // Initialize progress
            updateProgress();
        });
    </script>
    <x-footers></x-footers>
@endsection
