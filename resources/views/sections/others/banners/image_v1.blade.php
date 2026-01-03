<!-- <div class="w-full">
    <div class="relative">
        <img class="object-cover w-full h-64 sm:h-80 md:h-80 lg:h-80" src="{{ Storage::url("others/border.webp") }}" alt="border.webp">
        <div class="absolute inset-0 grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 items-center justify-center text-white gap-4 px-6 h-[250px] sm:h-[350px] lg:h-80">
        </div>
    </div>
</div> -->

<!-- ini sebelum perubahan -->


<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200&h=400&fit=crop') center/cover;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .department-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .department-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background-color: #3b4279;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2d3158;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            border-bottom: 3px solid #3b4279;
            padding-bottom: 0.5rem;
            display: inline-block;
        }

        .stat-item {
            text-align: center;
            padding: 2rem 1rem;
            background-color: rgba(255, 255, 255, 0.95);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #3b4279;
        }

        .circular-img {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #3b4279;
        }

        nav {
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .logo-img {
            width: 40px;
            height: 40px;
        }

        .footer-link {
            color: #a0aec0;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: #3b4279;
        }

        .active {
            color: #3b4279;
            font-weight: 600;
        }
    </style>


<div class="w-full" data-aos="fade-up" id="stats-section">
    <div class="relative">
        <div class="w-full h-[500px] sm:h-80 md:h-96 lg:h-[420px] relative overflow-hidden bg-gray-900">
            <img src="{{ Storage::url('others/border.webp') }}" class="object-cover w-full h-full opacity-60" alt="border">

            <div class="absolute inset-0 flex items-center justify-center">
                <div class="max-w-7xl mx-auto grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-12 px-6 text-center text-white drop-shadow-[0_3px_8px_rgba(0,0,0,0.75)]">

                    <div>
                        <div class="text-4xl sm:text-5xl lg:text-6xl font-bold stat-counter" data-target="1957">0</div>
                        <p class="text-base sm:text-lg lg:text-xl mt-1 font-normal">Tahun Berdiri</p>
                    </div>

                    <div>
                        <div class="text-4xl sm:text-5xl lg:text-6xl font-bold stat-counter" data-target="9206">0</div>
                        <p class="text-base sm:text-lg lg:text-xl mt-1 font-normal">Mahasiswa Aktif</p>
                    </div>

                    <div>
                        <div class="text-4xl sm:text-5xl lg:text-6xl font-bold"><span class="stat-counter" data-target="25">0</span>k+</div>
                        <p class="text-base sm:text-lg lg:text-xl mt-1 font-normal">Alumni Lulusan</p>
                    </div>

                    <div>
                        <div class="text-4xl sm:text-5xl lg:text-6xl font-bold stat-counter" data-target="125">0</div>
                        <p class="text-base sm:text-lg lg:text-xl mt-1 font-normal">Staff Dosen</p>
                    </div>

                    <div>
                        <div class="text-4xl sm:text-5xl lg:text-6xl font-bold">Bali</div>
                        <p class="text-base sm:text-lg lg:text-xl mt-1 font-normal">Lokasi Kampus</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll('.stat-counter');
    const speed = 200; // Semakin kecil semakin cepat

    const startCounter = (el) => {
        const updateCount = () => {
            const target = +el.getAttribute('data-target');
            const count = +el.innerText.replace(/,/g, ''); // Hapus koma saat menghitung
            
            // Hitung pertambahan (bebas diatur)
            const inc = target / speed;

            if (count < target) {
                // Tambahkan angka dan format kembali dengan koma jika perlu
                const nextValue = Math.ceil(count + inc);
                el.innerText = nextValue.toLocaleString('en-US');
                setTimeout(updateCount, 10);
            } else {
                el.innerText = target.toLocaleString('en-US');
            }
        };
        updateCount();
    };

    // Observer untuk trigger animasi saat terlihat di layar
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                startCounter(entry.target);
                observer.unobserve(entry.target); // Animasi cuma jalan sekali
            }
        });
    }, { threshold: 0.5 }); // Trigger saat 50% section terlihat

    counters.forEach(counter => observer.observe(counter));
});
</script>