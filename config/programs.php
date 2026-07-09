<?php

/**
 * Data program "Strategi Operasional RPJMD" (halaman Profil) + halaman detailnya.
 * Satu sumber data untuk kartu ringkas dan halaman detail (pages/program.blade.php).
 * Key array = slug yang dipakai di URL /program/{slug}.
 */
return [

    'transformasi-digital' => [
        'icon'    => 'fa-bolt',
        'color'   => '#2563eb',
        'bg'      => 'bg-blue-50',
        'title'   => 'Transformasi Digital',
        'desc'    => 'Digitalisasi layanan publik 100% untuk mempermudah akses warga.',
        'detail'  => 'Program ini bertujuan untuk mengintegrasikan seluruh layanan publik Kabupaten Pasuruan ke dalam satu ekosistem digital yang aman dan transparan. Mencakup pengembangan super-app pelayanan warga, sistem perizinan online yang lebih cepat, dan penyediaan infrastruktur internet hingga ke pelosok desa.',
        'image'   => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=1200&auto=format&fit=crop',
        'targets' => [
            'Digitalisasi 100% dokumen kependudukan.',
            'Akses internet gratis di ruang publik strategis.',
            'Sistem monitoring pembangunan daerah berbasis real-time.',
        ],
    ],

    'kesehatan-prima' => [
        'icon'    => 'fa-shield-halved',
        'color'   => '#16a34a',
        'bg'      => 'bg-emerald-50',
        'title'   => 'Kesehatan Prima',
        'desc'    => 'Pemenuhan fasilitas kesehatan modern di setiap kecamatan.',
        'detail'  => 'Program Kesehatan Prima difokuskan pada pemerataan akses layanan kesehatan bermutu di seluruh wilayah Kabupaten Pasuruan. Meliputi modernisasi puskesmas, penambahan tenaga medis, layanan gawat darurat cepat tanggap, serta program promotif-preventif untuk menekan angka stunting dan penyakit menular.',
        'image'   => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=1200&auto=format&fit=crop',
        'targets' => [
            'Puskesmas modern di setiap kecamatan.',
            'Penurunan angka stunting secara signifikan.',
            'Layanan ambulans gawat darurat gratis 24 jam.',
        ],
    ],

    'inovasi-karang-taruna' => [
        'icon'    => 'fa-bullseye',
        'color'   => '#ea580c',
        'bg'      => 'bg-orange-50',
        'title'   => 'Inovasi Karang Taruna',
        'desc'    => 'Pemberdayaan pemuda melalui inkubasi bisnis kreatif dan vokasi.',
        'detail'  => 'Program ini memberdayakan pemuda dan Karang Taruna sebagai motor penggerak ekonomi kreatif daerah. Melalui inkubasi bisnis, pelatihan vokasi, serta akses permodalan, generasi muda didorong menciptakan lapangan kerja mandiri dan produk unggulan khas Kabupaten Pasuruan.',
        'image'   => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1200&auto=format&fit=crop',
        'targets' => [
            'Inkubasi 100 wirausaha muda setiap tahun.',
            'Pelatihan vokasi berbasis kebutuhan industri.',
            'Akses permodalan untuk usaha kreatif pemuda.',
        ],
    ],

];
