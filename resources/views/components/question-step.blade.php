@props(['question', 'options', 'step'])

<div x-show="currentStep === {{ $step }}" x-transition>
    <div class="card shadow-xl p-6 bg-white space-y-4">
        <h2 class="text-xl font-semibold">{{ $question->pertanyaan }}</h2>

        <div class="space-y-2">
            @foreach ($options as $option)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}"
                        class="radio radio-primary" x-model="answers[{{ $question->id }}]">
                    <span>{{ $option->label }}</span>
                </label>
            @endforeach
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" class="btn btn-secondary" x-show="currentStep > 1" @click="currentStep--">
                Kembali
            </button>

            <button type="button" class="btn btn-primary" @click="nextStep({{ $question->id }})">
                Selanjutnya
            </button>
        </div>
    </div>
</div>
