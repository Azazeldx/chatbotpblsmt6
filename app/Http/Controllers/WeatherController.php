<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class WeatherController extends Controller
{
    public static function getWeatherData()
    {
        return Cache::remember('weather_pasuruan', 600, function () {
            $apiKey = config('services.openweather.key');
            $lat = "-7.6433";
            $lon = "112.9067";

            try {
                $response = Http::timeout(5)->connectTimeout(3)->get("https://api.openweathermap.org/data/2.5/weather", [
                    'lat' => $lat,
                    'lon' => $lon,
                    'appid' => $apiKey,
                    'units' => 'metric', #Ini instruksi penting agar angka yang dikirim dalam format Celsius
                    'lang' => 'id' #Ini instruksi penting agar deskripsi cuaca dalam bahasa Indonesia
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $mainWeather = $data['weather'][0]['main'];

                    // Contoh: 27.55 jadi 27
                    $data['main']['temp_floor'] = floor($data['main']['temp']);

                    // Menambahkan Waktu Update (Zona Waktu WIB)
                    $data['waktu_update'] = Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, H:i') . ' WIB';

                    // Mapping Status Indo
                    $statusIndo = match ($mainWeather) {
                        'Clear' => 'Cerah',
                        'Clouds' => 'Berawan',
                        'Rain', 'Drizzle' => 'Hujan',
                        'Thunderstorm' => 'Hujan Badai Petir',
                        'Atmosphere' => 'Berkabut',
                        default => $mainWeather,
                    };

                    // Mapping Pesan Himbauan
                    $pesanHimbauan = match ($mainWeather) {
                        'Clear' => "Cuaca di Pasuruan sangat cerah hari ini. Tetap semangat dalam mengawal dan mewujudkan program RPJMD!",
                        'Clouds' => "Hari ini Pasuruan sedang berawan. Cuaca yang sangat mendukung untuk aktivitas dan pelayanan masyarakat.",
                        'Rain', 'Drizzle' => "Pasuruan sedang diguyur hujan. Harap berhati-hati di jalan dan utamakan keselamatan saat beraktivitas di luar.",
                        'Thunderstorm' => "Waspada! Sedang terjadi hujan badai di Pasuruan. Tunda perjalanan jika tidak mendesak demi keselamatan bersama.",
                        default => "Pantau terus prakiraan cuaca hari ini untuk kelancaran aktivitas di wilayah Kabupaten Pasuruan.",
                    };

                    // Mapping Background
                    $bgImage = match ($mainWeather) {
                        'Clear' => 'pasuruanGoodWeather.webp',
                        'Rain', 'Drizzle' => 'pasuruanGoodWeather.webp',
                        'Thunderstorm' => 'pasuruanGoodWeather.webp',
                        'Clouds' => 'pasuruanGoodWeather.webp',
                        default => 'pasuruanGoodWeather.webp',
                    };

                    $data['status_indo'] = $statusIndo;
                    $data['pesan_himbauan'] = $pesanHimbauan;
                    $data['custom_bg'] = $bgImage;

                    return $data;
                }
                return null;
            } catch (\Exception $e) {
                return null;
            }
        });
    }
}