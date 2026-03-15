<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SiakadApiService
{
    protected string $baseUrl;
    protected string $systemToken;

    public function __construct()
    {
        $this->baseUrl = config('services.siakad.url'); // Set di .env: SIAKAD_URL
        $this->systemToken = config('services.siakad.token'); // Token khusus server-to-server
    }

    public function getLecturerDetails(string $siakadLecturerId)
    {
        return Cache::remember("siakad_lecturer_{$siakadLecturerId}", now()->addHours(24), function () use ($siakadLecturerId) {
            $response = Http::withToken($this->systemToken)
                ->get("{$this->baseUrl}/api/v1/lecturers/{$siakadLecturerId}");

            return $response->successful() ? $response->json('data') : null;
        });
    }

    public function getStudyPrograms()
    {
        return Cache::remember('siakad_study_programs', now()->addDays(7), function () {
            $response = Http::withToken($this->systemToken)->get("{$this->baseUrl}/api/v1/programs");
            return $response->successful() ? $response->json('data') : [];
        });
    }
}