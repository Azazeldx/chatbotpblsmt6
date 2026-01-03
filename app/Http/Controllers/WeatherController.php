<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class WeatherController extends Controller
{
    public static function getWeatherData()
    {
        return Cache::remember('weather_jimbaran', 600, function () {
            $apiKey = config('services.openweather.key');
            $lat = "-8.798755622508684";
            $lon = "115.16206160767392";

            try {
                $response = Http::withOptions(['verify' => false])
                    ->get("https://api.openweathermap.org/data/2.5/weather", [
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

                    // Menambahkan Waktu Update (Zona Waktu WITA)
                    $data['waktu_update'] = Carbon::now('Asia/Makassar')->locale('id')->translatedFormat('l, H:i') . ' WITA';

                    // Mapping Status Indo
                    $statusIndo = match($mainWeather) {
                        'Clear' => 'Cerah',
                        'Clouds' => 'Berawan',
                        'Rain', 'Drizzle' => 'Hujan',
                        'Thunderstorm' => 'Hujan Badai Petir',
                        'Atmosphere' => 'Berkabut',
                        default => $mainWeather,
                    };

                    // Mapping Pesan Himbauan
                    $pesanHimbauan = match($mainWeather) {
                        'Clear' => "Cuaca di Jimbaran sangat cerah hari ini. Tetap jaga hidrasi dan selamat beraktivitas di kampus PNB!",
                        'Clouds' => "Hari ini Jimbaran sedang berawan. Cuaca yang cukup teduh dan sangat aman untuk beraktivitas di area Politeknik.",
                        'Rain', 'Drizzle' => "Jimbaran sedang diguyur hujan. Harap mahasiswa berhati-hati, gunakan jas hujan/payung, dan waspada jalanan licin.",
                        'Thunderstorm' => "Waspada! Sedang terjadi hujan badai di Jimbaran. Tetap berlindung di dalam gedung dan tunda perjalanan jika tidak mendesak.",
                        default => "Pantau terus prakiraan cuaca hari ini untuk kelancaran aktivitas akademik Anda di Politeknik Negeri Bali.",
                    };

                    // Mapping Background
                    $bgImage = match($mainWeather) {
                        'Clear' => 'PnbGoodWeather.webp',
                        'Rain', 'Drizzle' => 'gambarPNBHeavyRain.webp',
                        'Thunderstorm' => 'gambarPNBHeavyRainLightning.webp',
                        'Clouds' => 'PnbMendung.webp',
                        default => 'PnbGoodWeather.webp',
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