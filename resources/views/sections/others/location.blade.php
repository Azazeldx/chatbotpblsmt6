<div class="flex flex-col items-center justify-center lg:!px-20 lg:!py-12 md:!px-16 md:!py-12 px-2 py-4 mx-auto text-white bg-secondary-500 lg:flex-row">
    <div class="flex flex-col items-center lg:w-1/2" data-aos="fade-up">
        <h2 class="mb-2 text-3xl font-semibold text-center">Let’s see our planned location.</h2>
        <p class="mb-4 text-lg text-center">{{ $data['location']['address'] }}</p>
        <img class="mb-4" src="{{ Storage::url("location/dna-small.svg") }}" alt="DNA Icon">
        <a href="{{ $data['location']['url'] }}"
            class="flex items-center gap-2 px-6 py-2 text-lg transition-transform transform bg-white rounded-lg text-secondary-500 hover:scale-105">
            Lokasi
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
        </a>
    </div>
    <div class="flex justify-center mt-4 lg:w-1/2" data-aos="fade-up">
        <img src="{{ Storage::url("location/dna.jpg") }}" alt="{{ $data['location']['address'] }}" title="{{ $data['location']['address'] }}" class="max-w-full rounded-md">
    </div>
</div>
