<section class="bg-gray-100 max-w-full py-12" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:!px-20 py-12">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Gambar Kotak cuaca di kiri -->
            <div class="bg-gradient-to-br from-gray-700 to-gray-900 rounded-2xl overflow-hidden h-80 relative shadow-2xl group cursor-default"
                data-aos="fade-right" data-aos-duration="1000">

                <img src="{{ asset('storage/weather/' . ($data['weather']['custom_bg'] ?? 'pasuruanGoodWeather.webp')) }}" alt="Weather Background"
                    class="w-full h-full object-cover opacity-60 transition-all duration-700 
                            group-hover:scale-110 group-hover:blur-sm group-hover:brightness-50">

                <div
                    class="absolute inset-0 flex flex-col justify-center items-center text-white transition-all duration-500 group-hover:scale-105">
                    <div class="text-7xl font-bold mb-1 drop-shadow-lg">
                        {{ $data['weather']['main']['temp_floor'] ?? 'N/A' }}°C
                    </div>
                    <div
                        class="text-xl font-medium tracking-widest uppercase opacity-90 border-t border-white/30 pt-2 drop-shadow-md">
                        {{ $data['weather']['status_indo'] ?? 'Berawan' }}
                    </div>
                    <div class="text-sm mt-2 opacity-80 italic drop-shadow-md">
                        {{ $data['weather']['waktu_update'] ?? '' }}
                    </div>
                </div>
            </div>

            <!-- Info cuaca di kanan -->
            <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <h3 class="text-green-600 font-bold tracking-widest text-sm mb-2 uppercase">KONDISI KABUPATEN PASURUAN
                </h3>

                <div class="flex items-baseline gap-4 mb-4">
                    <h2 class="text-6xl font-extrabold text-gray-900">
                        {{ $data['weather']['main']['temp_floor'] ?? 'N/A' }}°C
                    </h2>
                    <span class="text-gray-500 font-medium text-lg uppercase tracking-wider">
                        {{ $data['weather']['status_indo'] ?? 'Berawan' }}
                    </span>
                </div>

                <div class="flex gap-6 mb-6 text-gray-700 border-y border-gray-200 py-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-wind text-green-500"></i>
                        <span class="text-sm">Angin: <strong>{{ $data['weather']['wind']['speed'] ?? 0 }}
                                km/h</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-tint text-green-400"></i>
                        <span class="text-sm">Lembap:
                            <strong>{{ $data['weather']['main']['humidity'] ?? 0 }}%</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-clock text-gray-400"></i>
                        <span class="text-sm">{{ $data['weather']['waktu_update'] ?? '' }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-4 mb-6">
                    <div class="bg-green-600 p-3 rounded-xl shadow-lg shadow-green-200">
                        <i
                            class="fas {{ ($data['weather']['weather'][0]['main'] ?? '') == 'Rain' ? 'fa-cloud-showers-heavy' : 'fa-cloud-sun' }} text-white text-2xl"></i>
                    </div>
                    <span class="text-gray-800 font-bold text-xl tracking-tight">
                        {{ $data['weather']['name'] ?? 'Pasuruan' }}, Jawa Timur
                    </span>
                </div>

                <div
                    class="bg-white p-6 rounded-xl border-l-8 {{ ($data['weather']['weather'][0]['main'] ?? '') == 'Rain' || ($data['weather']['weather'][0]['main'] ?? '') == 'Thunderstorm' ? 'border-red-500' : 'border-green-600' }} shadow-md">
                    <p class="text-gray-600 leading-relaxed italic text-lg">
                        "{{ $data['weather']['pesan_himbauan'] ?? 'Selamat beraktivitas di Kabupaten Pasuruan.' }}"
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>