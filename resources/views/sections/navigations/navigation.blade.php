<header id="navbar" class="w-full sticky top-0 z-[9999] bg-white py-2 text-black transition-all">
    <div class="flex flex-row items-center justify-between w-full px-4 mx-auto lg:px-0 lg:w-11/12">
        <!-- Logo -->
        <a href="{{ route('/') }}">
            <img class="w-[38px] lg:!w-[52px] h-auto" src="{{ !empty($data['site_logo']) ? asset('storage/'.$data['site_logo']) : asset('storage/others/logo_pasuruan.png') }}"
                alt="{{ $data['site_name'] }}">
        </a>

        <!-- Navbar items -->
        <ul id="navMenu"
            style="transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1), max-height 1000ms cubic-bezier(0.4, 0, 0.2, 1);"
            class="absolute left-0 flex flex-col items-end w-full overflow-y-auto text-sm text-center bg-white border-b-2 no-scrollbar max-h-0 md:max-h-fit md:overflow-visible md:items-center top-full md:top-0 md:w-fit md:justify-center md:flex-row md:gap-4 lg:text-base md:relative md:pb-0 md:border-b-0">
            @if ($data['navigation']['home'])
                <x-navigation.nav_item slug="{{ $data['navigation']['home']['slug'] }}">
                    {{ $data['navigation']['home']['title'] }}
                </x-navigation.nav_item>
            @endif
            @foreach ($data['navigation']['nav_items'] as $navItem)
                @if ($navItem['type'] == 'link' && !empty($navItem['link']))
                    <x-navigation.nav_item url="{{ $navItem['link']['url'] }}">
                        {{ $navItem['link']['label'] }}
                    </x-navigation.nav_item>
                @elseif ($navItem['type'] == 'page' && !empty($navItem['page']))
                    <x-navigation.nav_item slug="{{ $navItem['page']['slug'] }}">
                        {{ $navItem['page']['title'] }}
                    </x-navigation.nav_item>
                @endif
            @endforeach
        </ul>

        <!-- Search Form -->
        <a id="showMenu" class="rounded-md cursor-pointer md:hidden">
            <i class="fa-solid fa-bars"></i>
        </a>
    </div>
</header>

<script>
    // window.addEventListener('scroll', function() {
    //     const navbar = document.getElementById('navbar');
    //     const navMenu = document.getElementById('navMenu');
    //     if (window.scrollY > 50) {
    //         navbar.classList.add('!bg-primary-500');
    //         navbar.classList.add('!text-white');
    //         navMenu.classList.add('!bg-primary-500');
    //     } else {
    //         navbar.classList.remove('!bg-primary-500');
    //         navbar.classList.remove('!text-white');
    //         navMenu.classList.remove('!bg-primary-500');
    //     }
    // });

    const showMenu = document.getElementById('showMenu');
    showMenu.addEventListener('click', function () {
        const navMenu = document.getElementById('navMenu');
        navMenu.classList.toggle('max-h-0');
        navMenu.classList.toggle('!max-h-[500px]');
    });
</script>