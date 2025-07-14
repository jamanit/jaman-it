<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('/') }}assets/fortawesome/fontawesome-free/css/all.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Trebuchet MS', sans-serif;
        }

        .a4 {
            width: 210mm;
            height: 297mm;
            margin: 0 auto 10mm;
            page-break-after: always;
            max-width: 210mm;
            max-height: 297mm;
            position: relative;
        }

        @media print {
            @page {
                margin: 0;
            }

            .a4 {
                width: 210mm;
                height: 297mm;
                margin: 0 auto;
                page-break-after: always;
                max-width: 210mm;
                max-height: 297mm;
            }

            body {
                margin: 0;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
    <!-- PAGE 1 -->
    <div class="a4 bg-white p-10 shadow-md">
        <div class="border-t-4 border-black pt-2"></div>
        <div class="mb-6">
            <div class="mb-4">
                <h1 class="text-4xl font-bold">RIKI DAVIDTRA</h1>
            </div>

            @if ($lang === 'en')
                <p><i class="fas fa-home"></i> Jl. Komp. Guru SD Patimura RT. 26 Telanaipura, Jambi City, Indonesian.</p>
            @else
                <p><i class="fas fa-home"></i> Jl. Komp. Guru SD Patimura RT. 26 Telanaipura, Kota Jambi, Indonesia.</p>
            @endif

            @if ($lang === 'en')
                <div class="grid grid-cols-2">
                    <div>
                        <p><i class="fas fa-phone"></i> <a href="tel:+6289508475453" class="text-blue-600" target="_blank">+62 895-0847-5453</a> (Phone Number)</p>
                        <p><i class="fab fa-whatsapp"></i> <a href="https://wa.me/6289508475453" class="text-blue-600" target="_blank">+62 895-0847-5453</a> (WhatsApp)</p>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:rikidavidtra.2310@gmail.com" class="text-blue-600" target="_blank">rikidavidtra.2310@gmail.com</a></p>
                        <p><i class="fab fa-linkedin"></i> <a href="https://www.linkedin.com/in/riki-davidtra-a30752237/" class="text-blue-600" target="_blank">linkedin.com/in/riki-davidtra-a30752237</a></p>
                    </div>
                    <div>
                        <p><i class="fab fa-github"></i> <a href="https://github.com/jamanit" class="text-blue-600" target="_blank">github.com/jamanit</a></p>
                        <p><i class="fab fa-youtube"></i> <a href="https://www.youtube.com/@jaman_it" class="text-blue-600" target="_blank">youtube.com/@jaman_it</a></p>
                        <p><i class="fa-solid fa-globe"></i> <a href="https://rport.my.id" class="text-blue-600" target="_blank">rport.my.id</a> (My Website)</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-2">
                    <div>
                        <p><i class="fas fa-phone"></i> <a href="tel:+6289508475453" class="text-blue-600" target="_blank">+62 895-0847-5453</a> (Nomor Telepon)</p>
                        <p><i class="fab fa-whatsapp"></i> <a href="https://wa.me/6289508475453" class="text-blue-600" target="_blank">+62 895-0847-5453</a> (WhatsApp)</p>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:rikidavidtra.2310@gmail.com" class="text-blue-600" target="_blank">rikidavidtra.2310@gmail.com</a></p>
                        <p><i class="fab fa-linkedin"></i> <a href="https://www.linkedin.com/in/riki-davidtra-a30752237/" class="text-blue-600" target="_blank">linkedin.com/in/riki-davidtra-a30752237</a></p>
                    </div>
                    <div>
                        <p><i class="fab fa-github"></i> <a href="https://github.com/jamanit" class="text-blue-600" target="_blank">github.com/jamanit</a></p>
                        <p><i class="fab fa-youtube"></i> <a href="https://www.youtube.com/@jaman_it" class="text-blue-600" target="_blank">youtube.com/@jaman_it</a></p>
                        <p><i class="fa-solid fa-globe"></i> <a href="https://rport.my.id" class="text-blue-600" target="_blank">rport.my.id</a> (Website Saya)</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="border-t-2 border-black pt-2"></div>

        @if ($lang === 'en')
            <div class="mb-6">
                <h2 class="mb-4 text-center text-xl font-semibold">PROFILE</h2>
                <p class="text-justify">
                    I am an experienced <span class="text-blue-600">IT Programmer</span> focused on software development,
                    particularly in web applications. I have been involved in various projects, from development to maintenance
                    and performance enhancement of long-term web applications. Throughout my career, I have successfully delivered
                    responsive web solutions and tackled complex challenges such as security systems, validation systems, APIs,
                    and UI/UX optimization. I am also disciplined in team collaboration to ensure that the solutions developed
                    meet business objectives. In addition to web development, I possess skills in
                    <span class="text-blue-600">IT Technician</span> work, including repairing computer and mobile devices, as
                    well as <span class="text-blue-600">Graphic Design</span> such as creating logos, brochures, posters, banners,
                    and invitations. With this combination of skills, I am ready to support any project that I will work on.
                </p>
            </div>
        @else
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-center mb-4">PROFIL</h2>
                <p class="text-justify">Saya adalah <span class="text-blue-600">IT Programmer</span> berpengalaman dengan
                    fokus
                    pada pengembangan perangkat
                    lunak, khususnya dalam
                    aplikasi web. Saya telah terlibat dalam berbagai proyek, mulai dari pengembangan hingga pemeliharaan
                    dan
                    peningkatan kinerja aplikasi web jangka panjang. Sepanjang karier saya, saya telah berhasil
                    memberikan
                    solusi web responsif dan mengatasi tantangan kompleks seperti sistem keamanan, sistem validasi, API,
                    dan
                    optimisasi UI/UX. Saya juga disiplin dalam kolaborasi tim untuk memastikan bahwa solusi yang
                    dikembangkan memenuhi tujuan bisnis. Selain pengembangan web, saya memiliki keterampilan dalam bidang
                    <span class="text-blue-600">IT
                        Teknisi</span> yaitu memperbaiki perangkat komputer dan ponsel serta <span class="text-blue-600">Desain
                        Grafis</span> seperti pembuatan logo, brosur, poster, banner dan undangan. Dengan kombinasi keahlian
                    ini, saya siap mendukung proyek apa pun yang akan dikerjakan.
                </p>
            </div>
        @endif

        <div class="border-t-2 border-black pt-2"></div>

        @if ($lang === 'en')
            <div class="mb-6">
                <h2 class="mb-4 text-center text-xl font-semibold">EDUCATION</h2>

                <div class="mb-4">
                    <div class="flex">
                        <div class="w-4/5">
                            <p><strong>Nurdin Hamzah University, Jambi, Indonesia</strong></p>
                        </div>
                        <div class="w-1/5">
                            <p class="text-end"><strong>2017 - 2021</strong></p>
                        </div>
                    </div>
                    <p>Bachelor of Computer Science</p>
                    <p>
                        Final Project: "Community Emergency Response Application" - A web-based application designed to assist the
                        community in emergency situations, such as natural disasters. This application allows users to report
                        emergency incidents, request help, and access important safety information.
                    </p>
                </div>

                <div>
                    <div class="flex">
                        <div class="w-4/5">
                            <p><strong>SMK Negeri 1 Jambi City, Indonesia</strong></p>
                        </div>
                        <div class="w-1/5">
                            <p class="text-end"><strong>2013 - 2016</strong></p>
                        </div>
                    </div>
                    <p>Computer Networking Engineering</p>
                    <p>
                        Final Project: "PC Assembly and Network Installation" - This project involved assembling computers from
                        hardware components, as well as installing and configuring a local area network (LAN).
                    </p>
                </div>
            </div>
        @else
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-center mb-4">PENDIDIKAN</h2>

                <div class="mb-4">
                    <div class="flex">
                        <div class="w-4/5">
                            <p><strong>Universitas Nurdin Hamzah Jambi, Indonesia</strong></p>
                        </div>
                        <div class="w-1/5">
                            <p class="text-end"><strong>2017 - 2021</strong></p>
                        </div>
                    </div>
                    <p>S1 Teknik Informatika</p>
                    <p>Proyek Akhir: "Aplikasi Tanggap Darurat Masyarakat" - Sebuah aplikasi berbasis web yang dirancang
                        untuk
                        membantu masyarakat dalam situasi darurat, seperti bencana alam. Aplikasi ini memungkinkan pengguna
                        untuk melaporkan kejadian darurat, meminta bantuan, dan mengakses informasi penting terkait
                        keselamatan.
                    </p>
                </div>
                <div>
                    <div class="flex">
                        <div class="w-4/5">
                            <p><strong>SMK Negeri 1 Kota Jambi, Indonesia</strong></p>
                        </div>
                        <div class="w-1/5">
                            <p class="text-end"><strong>2013 - 2016</strong></p>
                        </div>
                    </div>
                    <p>Teknik Komputer Jaringan</p>
                    <p>Proyek Akhir: "Merakit PC dan Instalasi Jaringan" - Proyek ini melibatkan perakitan komputer dari
                        komponen hardware, serta melakukan instalasi dan konfigurasi jaringan lokal (LAN).</p>
                </div>
            </div>
        @endif

        <div class="border-t-2 border-black pt-2"></div>

        @if ($lang === 'en')
            <div class="mb-6">
                <h2 class="mb-4 text-center text-xl font-semibold">PERSONAL PROJECTS</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p>
                            GitHub: <a href="https://github.com/jamanit" class="text-blue-600" target="_blank">github.com/jamanit</a>
                        </p>
                        <p>
                            YouTube:
                            <a href="https://www.youtube.com/@jaman_it" class="text-blue-600" target="_blank">youtube.com/@jaman_it</a>
                        </p>
                        <p>
                            My Website:
                            <a href="https://rport.my.id" class="text-blue-600" target="_blank">rport.my.id</a>
                        </p>
                        <p>
                            Digital Invitation:
                            <a href="https://undangbae.site/" target="_blank" class="text-blue-600">undangbae.site</a>
                        </p>
                    </div>
                    <div>
                        <p>
                            Other Projects:
                            <a href="https://drive.google.com/drive/folders/1dqE_3PYT-X9mmOHg-lDDk0GE-jR4eFsu?usp=drive_link" class="text-blue-600" target="_blank">https://drive.google.com/drive/folders/1dqE_3PYT-X9mmOHg-lDDk0GE-jR4eFsu?usp=drive_link</a>
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-center mb-4">PROYEK PRIBADI</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p>
                            GitHub:
                            <a href="https://github.com/jamanit" class="text-blue-600" target="_blank">github.com/jamanit</a>
                        </p>
                        <p>
                            YouTube:
                            <a href="https://www.youtube.com/@jaman_it" class="text-blue-600" target="_blank">youtube.com/@jaman_it</a>
                        </p>
                        <p>
                            Website Saya:
                            <a href="https://rport.my.id" class="text-blue-600" target="_blank">rport.my.id</a>
                        </p>
                        <p>
                            Undangan Digital:
                            <a href="https://undangbae.site/" target="_blank" class="text-blue-600">undangbae.site</a>
                        </p>
                    </div>
                    <div>
                        <p>
                            Proyek Lainnya:
                            <a href="https://drive.google.com/drive/folders/1dqE_3PYT-X9mmOHg-lDDk0GE-jR4eFsu?usp=drive_link" class="text-blue-600" target="_blank">https://drive.google.com/drive/folders/1dqE_3PYT-X9mmOHg-lDDk0GE-jR4eFsu?usp=drive_link</a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if ($lang === 'en')
            <div class="absolute bottom-4 right-10 text-sm text-gray-500">Page 1</div>
        @else
            <div class="absolute bottom-4 right-10 text-gray-500 text-sm">Halaman 1</div>
        @endif
    </div>

    <!-- PAGE 2 -->
    <div class="a4 bg-white p-10 shadow-md">
        <div class="border-t-2 border-black pt-2"></div>

        @if ($lang === 'en')
            <div class="mb-6">
                <div class="mb-4">
                    <h2 class="mb-3 text-center text-xl font-semibold">WORK EXPERIENCE</h2>
                    <div class="flex">
                        <div class="w-2/3">
                            <p><strong>Diskominfo Sarolangun Jambi</strong></p>
                        </div>
                        <div class="w-1/3">
                            <p class="text-end"><strong>January 2025 - Present</strong></p>
                        </div>
                    </div>
                    <p><strong>Expert Programmer</strong></p>
                    <ul class="list-inside list-disc">
                        <li>Develop and maintain information systems and applications to support the organization's operations.</li>
                        <li>Collaborate with the IT team to design and implement effective technology solutions.</li>
                        <li>Maintain servers, databases, and networks to ensure optimal and secure performance.</li>
                        <li>Analyze user requirements, test, and fix bugs in applications.</li>
                        <li>Provide technical support and training for staff regarding system usage.</li>
                    </ul>
                </div>
            </div>
        @else
            <div class="mb-6">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-center mb-3">PENGALAMAN KERJA</h2>
                    <div class="flex">
                        <div class="w-2/3">
                            <p><strong>Diskominfo Sarolangun Jambi</strong></p>
                        </div>
                        <div class="w-1/3">
                            <p class="text-end"><strong>Januari 2025 - Sekarang</strong></p>
                        </div>
                    </div>
                    <p><strong>Tenaga Ahli Programmer</strong></p>
                    <ul class="list-disc list-inside">
                        <li>Mengembangkan dan memelihara sistem informasi serta aplikasi untuk mendukung operasional
                            instansi.</li>
                        <li>Bekerja sama dengan tim IT untuk merancang dan menerapkan solusi teknologi yang efektif.</li>
                        <li>Menjaga server, database, dan jaringan agar tetap berfungsi optimal dan aman.</li>
                        <li>Menganalisis kebutuhan pengguna, menguji, dan memperbaiki bug pada aplikasi.</li>
                        <li>Memberikan dukungan teknis dan pelatihan kepada staf terkait penggunaan sistem.</li>
                    </ul>
                </div>
            </div>
        @endif

        @if ($lang === 'en')
            <div class="mb-6">
                <div class="mb-4">
                    <div class="flex">
                        <div class="w-2/3">
                            <p><strong>KKI Warsi</strong></p>
                        </div>
                        <div class="w-1/3">
                            <p class="text-end"><strong>April 2024 - September 2024</strong></p>
                        </div>
                    </div>
                    <p><strong>Information Technology</strong></p>
                    <ul class="list-inside list-disc">
                        <li>Developing and maintaining applications to display spatial and demographic data for villages.</li>
                        <li>Conducting data analysis to support decision-making at the village level.</li>
                        <li>Creating maps to illustrate various aspects of the village, such as land use and infrastructure.</li>
                        <li>Conducting training sessions for village officials on how to use the developed applications.</li>
                        <li>Providing documentation and user guides as references.</li>
                        <li>Managing hardware and software maintenance for computers in the office.</li>
                        <li>Providing technical support to office staff in the use of technology.</li>
                    </ul>
                </div>
            </div>

            <div class="mb-6">
                <div class="mb-4">
                    <div class="flex">
                        <div class="w-2/3">
                            <p><strong>PT Pulau Sambu Guntung</strong></p>
                        </div>
                        <div class="w-1/3">
                            <p class="text-end"><strong>March 2022 - March 2024</strong></p>
                        </div>
                    </div>
                    <p><strong>IT Programmer</strong></p>
                    <ul class="mb-2 list-inside list-disc">
                        <li>Developing applications for testing and analyzing product quality data.</li>
                        <li>Building dashboards to monitor audit results and standard violations.</li>
                        <li>Creating a document management system for quality procedures and policies.</li>
                        <li>Creating an efficient inventory management system.</li>
                        <li>Developing applications for tracking incoming and outgoing goods.</li>
                        <li>Implementing barcode technology to optimize goods retrieval.</li>
                        <li>Developing software for monitoring and controlling production processes.</li>
                        <li>Creating applications for production scheduling and resource allocation management.</li>
                        <li>Implementing reporting systems for production performance analysis.</li>
                        <li>Developing systems to monitor energy and water usage.</li>
                        <li>Creating applications for utility system management and maintenance.</li>
                    </ul>
                </div>
            </div>

            <div class="mb-6">
                <div class="mb-4">
                    <div class="flex">
                        <div class="w-2/3">
                            <p><strong>PT Infomedia Solusi Humanika</strong></p>
                        </div>
                        <div class="w-1/3">
                            <p class="text-end"><strong>January 2022 - February 2022</strong></p>
                        </div>
                    </div>
                    <p><strong>Digitalization and Validation Staff</strong></p>
                    <ul class="mb-2 list-inside list-disc">
                        <li>Digitalizing and validating documents at the Jambi City BPN office.</li>
                        <li>Providing and preparing necessary documents.</li>
                    </ul>
                </div>
            </div>
        @else
            <div class="mb-6">
                <div class="mb-4">
                    <div class="flex">
                        <div class="w-2/3">
                            <p><strong>KKI Warsi</strong></p>
                        </div>
                        <div class="w-1/3">
                            <p class="text-end"><strong>April 2024 - September 2024</strong></p>
                        </div>
                    </div>
                    <p><strong>Teknologi Informasi</strong></p>
                    <ul class="list-disc list-inside">
                        <li>Mengembangkan dan memelihara aplikasi untuk menampilkan data spasial dan demografi desa.</li>
                        <li>Melakukan analisis data untuk mendukung pengambilan keputusan di tingkat desa.</li>
                        <li>Membuat peta untuk menggambarkan berbagai aspek desa, seperti penggunaan lahan dan
                            infrastruktur.
                        </li>
                        <li>Mengadakan sesi pelatihan untuk perangkat desa mengenai penggunaan aplikasi yang dibuat.</li>
                        <li>Menyediakan dokumentasi dan panduan pengguna sebagai referensi.</li>
                        <li>Mengelola pemeliharaan perangkat keras dan perangkat lunak komputer di kantor.</li>
                        <li>Memberikan dukungan teknis kepada staf kantor dalam penggunaan perangkat teknologi.</li>
                    </ul>
                </div>
            </div>

            <div class="mb-6">
                <div class="mb-4">
                    <div class="flex">
                        <div class="w-2/3">
                            <p><strong>PT Pulau Sambu Guntung</strong></p>
                        </div>
                        <div class="w-1/3">
                            <p class="text-end"><strong>Maret 2022 - Maret 2024</strong></p>
                        </div>
                    </div>
                    <p><strong>IT Programmer</strong></p>
                    <ul class="list-disc list-inside mb-2">
                        <li>Mengembangkan aplikasi untuk pengujian dan analisis data kualitas produk.</li>
                        <li>Membangun dashboard untuk memantau hasil audit dan pelanggaran standar.</li>
                        <li>Membuat sistem manajemen dokumen untuk prosedur dan kebijakan kualitas.</li>

                        <li>Membuat sistem manajemen inventaris yang efisien.</li>
                        <li>Mengembangkan aplikasi untuk pelacakan barang masuk dan keluar.</li>
                        <li>Menerapkan teknologi barcode untuk optimasi pengambilan barang.</li>

                        <li>Mengembangkan perangkat lunak untuk pemantauan dan pengendalian proses produksi.</li>
                        <li>Membuat aplikasi untuk manajemen jadwal produksi dan alokasi sumber daya.</li>
                        <li>Mengimplementasikan sistem pelaporan untuk analisis kinerja produksi.</li>
                        <li>Mengembangkan sistem pemantauan penggunaan energi dan air.</li>
                        <li>Membuat aplikasi untuk manajemen dan pemeliharaan sistem utilitas.</li>
                    </ul>
                </div>
            </div>

            <div class="mb-6">
                <div class="mb-4">
                    <div class="flex">
                        <div class="w-2/3">
                            <p><strong>PT Infomedia Solusi Humanika</strong></p>
                        </div>
                        <div class="w-1/3">
                            <p class="text-end"><strong>Januari 2022 - Februari 2022</strong></p>
                        </div>
                    </div>
                    <p><strong>Staf Digitalisasi dan Validasi</strong></p>
                    <ul class="list-disc list-inside mb-2">
                        <li>Digitalisasi dan validasi dokumen di kantor BPN Kota Jambi.</li>
                        <li>Menyediakan dan mempersiapkan dokumen yang diperlukan.</li>
                    </ul>
                </div>
            </div>
        @endif


        @if ($lang === 'en')
            <div class="absolute bottom-4 right-10 text-sm text-gray-500">Page 2</div>
        @else
            <div class="absolute bottom-4 right-20 text-gray-500 text-sm">Halaman 2</div>
        @endif
    </div>

    <!-- PAGE 3 -->
    <div class="a4 bg-white p-10 shadow-md">

        @if ($lang === 'en')
            <div class="mb-6">
                <div class="mb-4">
                    <div class="flex">
                        <div class="w-2/3">
                            <p><strong>PT Pos Indonesia</strong></p>
                        </div>
                        <div class="w-1/3">
                            <p class="text-end"><strong>May 2020 - September 2020</strong></p>
                        </div>
                    </div>
                    <p><strong>Admin Staff</strong></p>
                    <ul class="mb-2 list-inside list-disc">
                        <li>
                            Processing data of the public and financial assistance recipients for Covid-19 BANSOS in Jambi Province.
                        </li>
                        <li>Distributing assistance to the field.</li>
                    </ul>
                </div>
            </div>
        @else
            <div class="mb-6">
                <div class="mb-4">
                    <div class="flex">
                        <div class="w-2/3">
                            <p><strong>PT Pos Indonesia</strong></p>
                        </div>
                        <div class="w-1/3">
                            <p class="text-end"><strong>Mei 2020 - September 2020</strong></p>
                        </div>
                    </div>
                    <p><strong>Staf Admin</strong></p>
                    <ul class="list-disc list-inside mb-2">
                        <li>Mengolah data masyarakat dan keuangan penerima BANSOS Covid-19 Provinsi Jambi.</li>
                        <li>Menyalurkan bantuan ke lapangan.</li>
                    </ul>
                </div>
            </div>
        @endif


        <div class="border-t-2 border-black pt-2"></div>

        @if ($lang === 'en')
            <div class="mb-6">
                <h2 class="mb-4 text-center text-xl font-semibold">SKILLS</h2>
                <ul class="list-inside list-disc">
                    <li>Programming Languages: PHP, JavaScript, CSS</li>
                    <li>Frameworks: Laravel, ExpressJS, ReactJS, NextJS, CodeIgniter</li>
                    <li>Database Management: PostgreSQL, MySQL</li>
                    <li>Libraries: TailwindCSS, Bootstrap, Leaflet, jQuery, Yajra Serverside, Intervention Image, Filament</li>
                    <li>Tools: GitHub, Trello, VSCode</li>
                    <li>Others: Computer and mobile device repair, Graphic design</li>
                </ul>
            </div>
        @else
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-center mb-4">KETERAMPILAN</h2>
                <ul class="list-disc list-inside">
                    <li>Bahasa Pemrograman: PHP, JavaScript, CSS</li>
                    <li>Framework: Laravel, ExpressJS, ReactJS, NextJS, Codeigniter</li>
                    <li>Manajemen Database: PostgreSQL, MySQL</li>
                    <li>Library: TailwindCSS, Boostrap, Leaflet, JQuery, Yajra Serverside, Intervention Image, Filament</li>
                    <li>Alat: GitHub, Trello, VSCode</li>
                    <li>Lainnya: Memperbaiki komputer dan ponsel, Desain grafis</li>
                </ul>
            </div>
        @endif

        <div class="border-t-2 border-black pt-2"></div>

        @if ($lang === 'en')
            <div class="mb-6">
                <h2 class="mb-4 text-center text-xl font-semibold">CERTIFICATIONS</h2>
                <p>1. Web Developer Certificate - VSGA Kominfo (2022)</p>
                <p>2. DGTalent Training Certificate (2022)</p>
                <p>3. UI/UX Design Certificate - Prakerja KEMDIKBUD (2022)</p>
            </div>
        @else
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-center mb-4">SERTIFIKASI</h2>
                <p>1. Sertifikat Web Developer - VSGA Kominfo (2022)</p>
                <p>2. Sertifikat Pelatihan DGTalent (2022)</p>
                <p>3. Sertifikat UI/UX Design - Prakerja KEMDIKBUD (2022)</p>
            </div>
        @endif


        <div class="border-t-2 border-black pt-2"></div>

        @if ($lang === 'en')
            <div class="mb-6">
                <h2 class="mb-4 text-center text-xl font-semibold">REFERENCES</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p><strong>Bagas Rimawan</strong></p>
                        <p>Field Operator - PetroChina Jabung International LTD</p>
                        <p>Email: bagas2rimawan@gmail.com</p>
                    </div>
                    <div>
                        <p><strong>M. Saptariawan</strong></p>
                        <p>PPIC Foreman - PT Bungasari Flour Mill Indonesia</p>
                        <p>Email: m.saptariawan@gmail.com</p>
                    </div>
                    <div>
                        <p><strong>Teguh Surya Nugraha</strong></p>
                        <p>PPIC - PT Pulau Sambu Guntung</p>
                        <p>Email: teguhsurya045@gmail.com</p>
                    </div>
                    <div>
                        <p><strong>Syihab Hasya</strong></p>
                        <p>IT Staff - PT Mega Ciogi International</p>
                        <p>Email: syihabhasya@gmail.com</p>
                    </div>
                    <div>
                        <p><strong>Isma Citra</strong></p>
                        <p>IT Programmer - PT Pulau Sambu Guntung</p>
                        <p>Email: ismacitra@gmail.com</p>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-center mb-4">REFERENSI</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p><strong>Bagas Rimawan</strong></p>
                        <p>Field Operator - PetroChina Jabung International LTD</p>
                        <p>Email: bagas2rimawan@gmail.com</p>
                    </div>
                    <div>
                        <p><strong>M. Saptariawan</strong></p>
                        <p>PPIC Foreman - PT Bungasari Flour Mill Indonesia</p>
                        <p>Email: m.saptariawan@gmail.com</p>
                    </div>
                    <div>
                        <p><strong>Teguh Surya Nugraha</strong></p>
                        <p>PPIC - PT Pulau Sambu Guntung</p>
                        <p>Email: teguhsurya045@gmail.com</p>
                    </div>
                    <div>
                        <p><strong>Syihab Hasya</strong></p>
                        <p>IT Staff - PT Mega Ciogi International</p>
                        <p>Email: syihabhasya@gmail.com</p>
                    </div>
                    <div>
                        <p><strong>Isma Citra</strong></p>
                        <p>IT Programmer - PT Pulau Sambu Guntung</p>
                        <p>Email: ismacitra@gmail.com</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($lang === 'en')
            <div class="absolute bottom-4 right-10 text-sm text-gray-500">Page 3</div>
        @else
            <div class="absolute bottom-4 right-10 text-gray-500 text-sm">Halaman 3</div>
        @endif
    </div>

</body>

</html>
