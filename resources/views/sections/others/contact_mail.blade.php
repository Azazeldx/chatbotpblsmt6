<div class="lg:!px-40 lg:!py-12 md:!px-20 md:!py-12 px-8 py-6">
    <div class="grid grid-cols-1 gap-16 mx-auto max-w-7xl md:grid-cols-2">
        <!-- Left Side: Contact Form -->
        <div class="md:p-8" data-aos="fade-right">
            <!-- Contact Us Title -->
            <h2 class="mb-4 text-4xl font-semibold tracking-wider text-gray-800 md:text-5xl lg:text-6xl">Contact Us</h2>
            <p class="mb-6 text-gray-800">Tanyakan hal yang ingin Anda ketahui tentang kami pada kolom di bawah ini!</p>
            <!-- Form -->
            <form action="{{ route('mail') }}" method="POST" class="space-y-6">
                @csrf
                <!-- Email Field -->
                <div>
                    <input type="email" id="email" name="email" required
                        class="w-full p-2 placeholder-gray-500 border border-gray-300 rounded-lg hover:border-[blue] hover:bg-white hover:text-[blue] "
                        placeholder="Email Anda *">
                </div>

                <!-- Subject Field -->
                <div>
                    <input type="text" id="subject" name="subject" required
                        class="w-full p-2 placeholder-gray-500 border border-gray-300 rounded-lg hover:border-[blue] hover:bg-white hover:text-[blue]"
                        placeholder="Subject *">
                </div>

                <!-- Message Field -->
                <div>
                    <textarea id="message" name="message" required rows="6"
                        class="w-full p-2 placeholder-gray-500 border border-gray-300 rounded-lg hover:border-[blue] hover:bg-white hover:text-[blue]"
                        placeholder="Tulis pesan Anda di sini *"></textarea>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="flex items-center justify-center w-full gap-2 px-4 py-2 font-medium text-white transition border-2 rounded-lg bg-[blue] hover:border-[blue] hover:bg-white hover:text-[blue] ">
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
        <!-- Right Side: Image -->
        <div class="items-center justify-center hidden md:flex" data-aos="fade-left">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d23869.59920651211!2d115.15241036915143!3d-8.803814270812888!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd244c13ee9d753%3A0x6c05042449b50f81!2sPoliteknik%20Negeri%20Bali!5e0!3m2!1sid!2sid!4v1762275032755!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
