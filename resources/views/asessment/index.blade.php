<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Perkembangan Siswa - Ruang Robot</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Custom CSS -->
    {{-- <link rel="stylesheet" href="/style.css"> --}}
    <style>
        @import "tailwindcss";

        /* Document & Custom Styles for Ruang Robot Report */
        :root {
            --rr-navy: #1f2553;
            --rr-navy-light: #303775;
            --rr-bg: #f8f9fa;
            --rr-border: #111111;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        /* Document Paper Styling (Tampilan Asli) */
        .report-paper {
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-radius: 4px;
            padding: 1.7rem 3rem;
            max-width: 960px;
            margin: 0 auto;
            transition: all 0.2s ease-in-out;
        }

        @media (max-width: 768px) {
            .report-paper {
                padding: 1.25rem 1rem;
                box-shadow: none;
                border-radius: 0;
            }
        }

        /* Document Outer Border Box as in original image */
        .document-box {
            border: 1.5px solid #000;
            padding: 20px;
        }

        .doc-row {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .doc-label {
            width: 300px;
            /* Sesuaikan jika kurang/lebar */
            font-weight: 300;
        }

        .doc-colon {
            width: 20px;
            text-align: center;
        }

        .doc-value {
            flex: 1;
            word-break: break-word;
        }

        .document-title {
            font-family: "Times New Roman", Times, serif;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: start;
            /* text-decoration: underline; */
            /* text-underline-offset: 4px; */
            /* line-height: 1.5; */
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* Mobile Responsive adjustment for document key-value */
        @media (max-width: 640px) {
            .document-row {
                flex-direction: column;
                margin-bottom: 1rem;
                border-bottom: 1px dashed #e5e7eb;
                padding-bottom: 0.5rem;
            }

            .document-label {
                flex: 0 0 auto;
                font-weight: 600;
                color: #374151;
                margin-bottom: 0.2rem;
            }

            .document-colon {
                display: none;
            }

            .document-value {
                padding-left: 0.25rem;
            }
        }

        /* Rating Score Badge Styling */
        .rating-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            border-radius: 50%;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* Print Styles */
        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm;
            }

            body {
                background: #ffffff !important;
                color: #000000 !important;
            }

            .no-print,
            .no-print * {
                display: none !important;
            }

            .report-paper {
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            .document-box {
                border: 1.5px solid #000000 !important;
                padding: 12pt !important;
            }

            .document-row {
                flex-direction: row !important;
                margin-bottom: 8pt !important;
                border-bottom: none !important;
            }

            .document-label {
                flex: 0 0 280pt !important;
            }

            .document-colon {
                display: inline !important;
            }

            .document-value {
                padding-left: 0 !important;
            }
        }
    </style>
</head>

<body>

    <!-- Main Container Area -->
    <main class="flex-fill py-3 py-md-4">

        <!-- SECTION 1: TAMPILAN DOKUMEN ASLI (Sesuai Presisi Gambar Screenshot) -->
        <section id="documentViewSection" class="container">
            <div class="report-paper">

                <!-- Logo Header -->
                <div class="mb-4 text-start">
                    <img src="{{ asset('images/ruangrobot.png') }}" alt="Ruang Robot" width="220" height="55"
                        style="object-fit: contain;">
                </div>

                <!-- Document Title (Underlined serif as in original screenshot) -->
                <div class="text-center mb-1">
                    <h1 id="docTitle" class="document-title">
                        LAPORAN PERKEMBANGAN SISWA KELAS REGULER T.A 2025/2025 RUANG ROBOT
                    </h1>
                </div>

                <!-- Bordered Box (Identik Kotak Hitam Laporan) -->
                <div class="document-box">
                    <div class="doc-row">
                        <div class="doc-label">Nama Siswa</div>
                        <div class="doc-colon">:</div>
                        <div id="valStudentName" class="doc-value">{{ $murid->nama }}</div>
                    </div>

                    <div class="doc-row">
                        <div class="doc-label">Pengajar</div>
                        <div class="doc-colon">:</div>
                        <div id="valTeachers" class="doc-value">{{ $pengajar->nama }}</div>
                    </div>

                    <div class="doc-row">
                        <div class="doc-label">Nama Program</div>
                        <div class="doc-colon">:</div>
                        <div id="valProgramName" class="doc-value">{{ $kelas->kelas->program_belajar->nama_program }}
                        </div>
                    </div>

                    @php
                        $keterangan = [
                            'pemahaman' => [
                                'A' =>
                                    'Siswa memahami konsep dasar robot dengan sangat baik dan mampu menerapkan materi secara mandiri.',
                                'A-' =>
                                    'Siswa memahami konsep dasar robot dengan sangat baik dan mampu mengikuti materi dengan cepat. Masih perlu sedikit penguatan agar semakin konsisten.',
                                'B+' =>
                                    'Siswa cukup memahami konsep dasar robot dan mampu mengikuti pembelajaran dengan baik. Perlu meningkatkan pemahaman pada beberapa materi.',
                                'B' =>
                                    'Siswa mulai memahami konsep dasar robot, namun masih membutuhkan arahan dan latihan secara bertahap.',
                                'B-' =>
                                    'Siswa masih memerlukan bimbingan dalam memahami konsep dasar robot dan perlu latihan yang lebih konsisten.',
                                'C' =>
                                    'Siswa memerlukan pendampingan lebih intensif dalam memahami konsep dasar robot.',
                            ],

                            'keterampilan' => [
                                'A' =>
                                    'Siswa mampu mengerjakan project dengan sangat baik secara mandiri serta menyelesaikan tugas dengan konsisten.',
                                'A-' =>
                                    'Siswa memiliki keterampilan yang sangat baik dan cukup mandiri dalam menyelesaikan project. Masih ada sedikit aspek yang dapat ditingkatkan.',
                                'B+' =>
                                    'Siswa mampu mengerjakan project dengan baik dan mulai menunjukkan kemandirian dalam menyelesaikan tugas.',
                                'B' =>
                                    'Siswa mampu mengikuti praktik dengan cukup baik, namun masih membutuhkan arahan dalam menyelesaikan project.',
                                'B-' =>
                                    'Siswa masih membutuhkan bimbingan dalam mengembangkan keterampilan dan kemandirian saat mengerjakan project.',
                                'C' =>
                                    'Siswa memerlukan pendampingan lebih intensif dalam mengembangkan keterampilan dan kemandirian.',
                            ],

                            'keamanan' => [
                                'A' =>
                                    'Siswa sangat baik dalam mengikuti prosedur keamanan dan menunjukkan ketelitian yang tinggi selama pengerjaan project.',
                                'A-' =>
                                    'Siswa mampu menerapkan prosedur keamanan dengan sangat baik dan cukup teliti dalam pengerjaan project.',
                                'B+' =>
                                    'Siswa mampu mengikuti prosedur keamanan dan cukup teliti dalam pengerjaan project. Perlu meningkatkan ketelitian agar hasil pengerjaan semakin optimal.',
                                'B' =>
                                    'Siswa cukup mampu mengikuti prosedur keamanan, namun masih perlu meningkatkan ketelitian selama pengerjaan project.',
                                'B-' =>
                                    'Siswa masih membutuhkan arahan dalam menerapkan prosedur keamanan dan meningkatkan ketelitian.',
                                'C' =>
                                    'Siswa memerlukan pendampingan lebih intensif dalam menerapkan prosedur keamanan dan ketelitian saat pengerjaan project.',
                            ],

                            'antusiasme' => [
                                'A' =>
                                    'Siswa menunjukkan antusiasme dan semangat belajar yang sangat tinggi serta aktif mengikuti seluruh kegiatan pembelajaran.',
                                'A-' =>
                                    'Siswa menunjukkan antusiasme yang sangat baik selama pembelajaran dan aktif mengikuti kegiatan praktik. Semangat belajar perlu dipertahankan secara konsisten.',
                                'B+' =>
                                    'Siswa menunjukkan antusiasme yang baik dan mampu mengikuti kegiatan pembelajaran dengan positif.',
                                'B' =>
                                    'Siswa cukup antusias mengikuti pembelajaran, namun perlu lebih aktif dalam kegiatan praktik.',
                                'B-' =>
                                    'Siswa mulai menunjukkan ketertarikan terhadap pembelajaran, namun masih perlu diberikan motivasi dan dorongan.',
                                'C' =>
                                    'Siswa memerlukan motivasi dan pendampingan lebih untuk meningkatkan antusiasme dalam mengikuti pembelajaran.',
                            ],

                            'percaya_diri' => [
                                'A' =>
                                    'Siswa menunjukkan rasa percaya diri dan tanggung jawab yang sangat baik serta mampu mengambil inisiatif dalam pembelajaran.',
                                'A-' =>
                                    'Siswa menunjukkan rasa percaya diri dan tanggung jawab yang sangat baik. Masih perlu sedikit dorongan untuk lebih aktif.',
                                'B+' =>
                                    'Siswa menunjukkan rasa percaya diri dan tanggung jawab yang baik. Perlu lebih aktif dalam menyampaikan pendapat dan mengambil inisiatif.',
                                'B' =>
                                    'Siswa cukup bertanggung jawab dalam pembelajaran, namun masih perlu meningkatkan rasa percaya diri dalam berkomunikasi.',
                                'B-' =>
                                    'Siswa masih membutuhkan dorongan untuk meningkatkan rasa percaya diri dan tanggung jawab dalam mengikuti pembelajaran.',
                                'C' =>
                                    'Siswa memerlukan pendampingan untuk membangun rasa percaya diri dan tanggung jawab dalam proses pembelajaran.',
                            ],
                        ];
                    @endphp

                    <div class="doc-row">
                        <div class="doc-label">Pemahaman Siswa</div>
                        <div class="doc-colon">:</div>
                        <div id="valUnderstanding" class="doc-value">
                            <strong>{{ $data->pemahaman }}</strong>
                            <br>
                            {{ $keterangan['pemahaman'][$data->pemahaman] ?? '-' }}
                        </div>
                    </div>

                    <div class="doc-row">
                        <div class="doc-label">Keamanan dan Ketelitian Saat Pengerjaan Project</div>
                        <div class="doc-colon">:</div>
                        <div id="valSafetyAccuracy" class="doc-value">
                            <strong>{{ $data->keamanan }}</strong>
                            <br>
                            {{ $keterangan['keamanan'][$data->keamanan] ?? '-' }}
                        </div>
                    </div>

                    <div class="doc-row">
                        <div class="doc-label">Keamanan dan Ketelitian Saat Pengerjaan Project</div>
                        <div class="doc-colon">:</div>
                        <div id="valSafetyAccuracy" class="doc-value">
                            <strong>{{ $data->keamanan }}</strong>
                            <br>
                            {{ $keterangan['keamanan'][$data->keamanan] ?? '-' }}
                        </div>
                    </div>

                    <div class="doc-row">
                        <div class="doc-label">Antusiasme dan Semangat Belajar</div>
                        <div class="doc-colon">:</div>
                        <div id="valEnthusiasm" class="doc-value">
                            <strong>{{ $data->antusiasme }}</strong>
                            <br>
                            {{ $keterangan['antusiasme'][$data->antusiasme] ?? '-' }}
                        </div>
                    </div>

                    <div class="doc-row">
                        <div class="doc-label">Sikap Percaya Diri dan Tanggung Jawab</div>
                        <div class="doc-colon">:</div>
                        <div id="valConfidenceResponsibility" class="doc-value">
                            <strong>{{ $data->percaya_diri }}</strong>
                            <br>
                            {{ $keterangan['percaya_diri'][$data->percaya_diri] ?? '-' }}
                        </div>
                    </div>

                    <div class="doc-row">
                        <div class="doc-label">Catatan dari Pengajar</div>
                        <div class="doc-colon">:</div>
                        <div id="valTeacherNotes" class="doc-value">
                            -
                        </div>
                    </div>

                    <div class="doc-row">
                        <div class="doc-label">Jadwal Konsultasi</div>
                        <div class="doc-colon">:</div>
                        <div id="valConsultationSchedule" class="doc-value">-</div>
                    </div>
                </div>

            </div>
        </section>

    </main>

    {{-- 

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-white border-top text-center text-muted small no-print">
        <div class="container">
            <p class="mb-0">
                © 2025 Ruang Robot. Laporan Perkembangan Siswa — Dibuat dengan HTML5, CSS3, dan Bootstrap 5 (Murni tanpa
                Framework JS).
            </p>
        </div>
    </footer> --}}

    <style>
        /* ================================
   RESPONSIVE LAPORAN
================================ */

        .report-paper {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .document-box {
            width: 100%;
            box-sizing: border-box;
        }

        .doc-row {
            display: grid;
            grid-template-columns: 260px 20px minmax(0, 1fr);
            gap: 8px;
            align-items: start;
        }

        .doc-label,
        .doc-colon,
        .doc-value {
            min-width: 0;
        }

        .doc-value {
            overflow-wrap: anywhere;
            word-break: break-word;
        }


        /* ================================
   TABLET
================================ */

        @media (max-width: 768px) {

            main {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            #documentViewSection {
                width: 100%;
                padding-left: 0;
                padding-right: 0;
            }

            .report-paper {
                width: 100%;
                max-width: 100%;
                padding: 20px;
            }

            /* Logo */
            .report-paper img {
                width: 170px !important;
                height: auto !important;
            }

            /* Judul */
            .document-title {
                font-size: 18px !important;
                line-height: 1.4;
                word-break: break-word;
            }

            /* Kotak laporan */
            .document-box {
                padding: 15px !important;
            }

            .doc-row {
                grid-template-columns: 180px 15px minmax(0, 1fr);
                gap: 5px;
            }

            .doc-label,
            .doc-value {
                font-size: 14px;
                line-height: 1.5;
            }

            .doc-colon {
                font-size: 14px;
            }
        }


        /* ================================
   HP
================================ */

        @media (max-width: 576px) {

            main {
                padding-top: 10px !important;
                padding-bottom: 10px !important;
                padding-left: 8px !important;
                padding-right: 8px !important;
            }

            #documentViewSection {
                padding: 0;
            }

            .report-paper {
                padding: 12px;
                border-radius: 8px;
            }

            /* Logo */
            .report-paper img {
                width: 130px !important;
                height: auto !important;
            }

            /* Jarak logo */
            .report-paper .mb-4 {
                margin-bottom: 15px !important;
            }

            /* Judul */
            .document-title {
                font-size: 15px !important;
                line-height: 1.35;
                margin-bottom: 12px !important;
            }

            /* Box */
            .document-box {
                padding: 12px !important;
            }

            /*
       Pada HP label dibuat satu baris sendiri.
       Ini jauh lebih nyaman daripada memaksa
       label panjang berdampingan dengan deskripsi.
    */
            .doc-row {
                display: grid;
                grid-template-columns: 1fr;
                gap: 3px;
                padding: 10px 0;
            }

            .doc-label {
                font-weight: 600;
                font-size: 13px;
                line-height: 1.4;
            }

            .doc-colon {
                display: none;
            }

            .doc-value {
                font-size: 13px;
                line-height: 1.6;
                width: 100%;
                overflow-wrap: anywhere;
                word-break: break-word;
            }

            .doc-value strong {
                display: inline-block;
                margin-bottom: 2px;
                font-size: 14px;
            }

        }


        /* ================================
            HP SANGAT KECIL
            ================================ */

        @media (max-width: 375px) {

            .report-paper {
                padding: 8px;
            }

            .document-box {
                padding: 10px !important;
            }

            .report-paper img {
                width: 115px !important;
            }

            .document-title {
                font-size: 14px !important;
            }

            .doc-row {
                padding: 8px 0;
            }

            .doc-label {
                font-size: 12px;
            }

            .doc-value {
                font-size: 12px;
                line-height: 1.55;
            }

            .doc-value strong {
                font-size: 13px;
            }
        }
    </style>

    <!-- Bootstrap 5 JS Bundle (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Vanilla JS Script -->
    <script src="/script.js"></script>
</body>

</html>
