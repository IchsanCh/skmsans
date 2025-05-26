<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $questions = [
            'Bagaimana pendapat Saudara tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya?',
            'Bagaimana pemahaman Saudara tentang kemudahan prosedur pelayanan di unit ini?',
            'Bagaimana pendapat Saudara tentang kecepatan waktu dalam memberikan pelayanan?',
            'Bagaimana pendapat Saudara tentang kewajaran biaya/tarif dalam pelayanan?',
            'Bagaimana pendapat Saudara tentang kesesuaian produk pelayanan antara yang tercantum dengan hasil yang diberikan?',
            'Bagaimana pendapat Saudara tentang kompetensi/kemampuan petugas dalam pelayanan?',
            'Bagaimana pendapat Saudara tentang perilaku petugas terkait kesopanan dan keramahan?',
            'Bagaimana pendapat Saudara tentang penanganan pengaduan, saran, dan masukan pengguna layanan?',
            'Bagaimana pendapat Saudara tentang kualitas sarana dan prasarana?'
        ];
        static $unsurPelayanan = [
            'Persyaratan Pelayanan',
            'Sistem, Mekanisme, dan Prosedur',
            'Waktu Penyelesaian',
            'Biaya/Tarif',
            'Produk Spesifikasi Jenis Pelayanan',
            'Kompetensi Pelaksana',
            'Perilaku Pelaksana',
            'Penanganan Pengaduan, Saran, dan Masukan',
            'Kualitas Sarana dan Prasarana'
        ];
        static $index = 0;

        if ($index >= count($questions)) {
            return [
                'pertanyaan' => $this->faker->sentence(),
                'unsur_pelayanan' => $this->faker->word()
            ];
        }

        return [
            'pertanyaan' => $questions[$index],
            'unsur_pelayanan' => $unsurPelayanan[$index++],
        ];
    }
}
