<!-- The Master doesn't talk, he acts. -->
<div class="pt-16">

    <div class="m-4 flex flex-col gap-y-4">

        <!-- CTA -->
        <div class="rounded-lg bg-white flex justify-between shadow-sm">
            <div class="mx-6 my-4 flex justify-center items-center">
                @if ($siswa)
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Hai, {{ $siswa->nama }}</h2>

                        @if ($siswa->status_lapor_pkl)
                            <!-- Jika sudah kirim data PKL -->
                            <p class="mb-4 text-yellow-800 text-lg">
                                Terima kasih! Kamu sudah mengirim data PKL.
                            </p>
                            <a href="{{ route('pkl') }}" class="inline-block bg-[#FCD34D] text-white px-4 py-2 rounded hover:bg-yellow-300 transition-colors">
                                Lihat atau perbarui data PKL
                            </a>
                        @else
                            <!-- Jika belum kirim data PKL -->
                            <p class="mb-4 text-gray-800 text-lg">
                                Kamu belum mengirim data PKL. Yuk segera lengkapi datamu biar prosesnya lancar!
                            </p>
                            <a href="{{ route('pkl') }}" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-[#9CA3AF] transition-colors">
                                Isi Data PKL Sekarang
                            </a>
                        @endif
                    </div>
                @else
                    <div class="text-red-600">
                        Data siswa tidak ditemukan.
                    </div>
                @endif
            </div>

            <div class="mx-6 my-4 flex justify-center items-center shadow-md">
                <!-- [kondisi] ? [benar] : [salah] -->
                <img class="rounded-xl w-56 h-56 object-contain" 
                src="{{ isset($siswa) && $siswa->foto && file_exists(storage_path('app/public/' . $siswa->foto)) 
                    ? asset('storage/' . $siswa->foto) 
                    : asset('images/siswa.png') }}" 
                alt="foto siswa" />
            </div>
        </div>

        <!-- Card Guru, Siswa, Industri -->
        <div class="flex gap-4">
            <!-- guru -->
            <div class="card flex-1 p-4 bg-[#60A5FA] rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-2xl font-semibold text-white">
                        <i class="fas fa-chalkboard-teacher mr-2"></i>
                        Jumlah Guru
                    </div>
                    <div class="w-16 h-16 flex items-center justify-center rounded-full bg-white text-[#60A5FA] text-2xl font-bold shadow-md ring-2 ring-white">
                        {{ $jumlahGuru }}
                    </div>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('guru') }}" class="bg-white text-[#60A5FA] px-4 py-2 rounded hover:bg-blue-100 transition font-medium">
                        Lihat Guru
                        <i class="ml-2 fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- siswa -->
            <div class="card flex-1 p-4 bg-[#34D399] rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-2xl font-semibold text-white">
                        <i class="fas fa-user-graduate mr-2"></i>
                        Jumlah Siswa
                    </div>
                    <div class="w-16 h-16 flex items-center justify-center rounded-full bg-white text-[#34D399] text-2xl font-bold shadow-md ring-2 ring-white">
                        {{ $jumlahSiswa }}
                    </div>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('siswa') }}" class="bg-white text-[#34D399] px-4 py-2 rounded hover:bg-green-100 transition font-medium">
                        Lihat Siswa
                        <i class="ml-2 fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- industri -->
            <div class="card flex-1 p-4 bg-[#FCD34D] rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-2xl font-semibold text-white">
                        <i class="fas fa-briefcase mr-2"></i>
                        Jumlah Industri
                    </div>
                    <div class="w-16 h-16 flex items-center justify-center rounded-full bg-white text-[#FCD34D] text-2xl font-bold shadow-md ring-2 ring-white">
                        {{ $jumlahIndustri }}
                    </div>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('industri') }}" class="bg-white text-[#FCD34D] px-4 py-2 rounded hover:bg-yellow-100 transition font-medium">
                        Lihat Industri
                        <i class="ml-2 fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="flex gap-4">
            <!-- Chart -->
            <!-- ada id kan, nah ini untuk memberi identitas agar kelak dapat dipanggil oleh scriptnya -->
            <div id="chart_pkl" class="card flex-1 shadow-sm"></div>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                // load library Google ChartJs
                google.charts.load('current', { // 'current' artinya pakai versi terbaru dari library-nya
                    packages: ['corechart'] // ini mengampil paket grafik inti seperti Pie Chart, Line Chart, dll
                });

                // lalu panggil fungsi drawChart() yang kita buat di bawah ini
                google.charts.setOnLoadCallback(drawChart);

                // fungsi utamanya adalah menggambar pie chart
                function drawChart() {
                    const chartData = @json($chartData); // ambil data dari logika Livewire ke JS

                    const data = google.visualization.arrayToDataTable(chartData); // ubah array biasa jadi format yang dimengerti oleh Google Charts

                    const options = {
                        title: 'Status Pengisian PKL', // judul
                        // pieHole: 0.4, // ini besarnya lubang, jika tanpa maka full bunder
                        colors: ['#60A5FA', '#34D399', '#9CA3AF'],  // warna, urutannya berdasarkan logika kita
                    };

                    // ini untuk buat 'kanvas' nya
                    // jadi, seluruh kodingan di dalam script ini akan dikirim ke mana nih?
                    // yaitu lemen HTML yang memiliki id 'chart_pkl'
                    // nanti akan dikirim ke variable chart
                    const chart = new google.visualization.PieChart(document.getElementById('chart_pkl'));

                    // gambar chartnya sekarang
                    // ambil data yang udah di format ('data')
                    // ambil pengaturan (judul, lubang pie, warna) dari ('options')
                    // lalu gambar grafiknya ke dalam elemen tadi ('chart_pkl')
                    chart.draw(data, options);
                }
            </script>

            <!-- Chart Rombel A -->
            <div id="chart_pkl_rombelA" class="card flex-1 shadow-sm"></div>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', { 
                    packages: ['corechart'] 
                });

                google.charts.setOnLoadCallback(drawChartRombelA);

                function drawChartRombelA() {
                    const chartDataRombelA = @json($chartDataRombelA); 

                    const data = google.visualization.arrayToDataTable(chartDataRombelA); 

                    const options = {
                        title: 'Status Pengisian PKL Rombel A', 
                        pieHole: 0.4, 
                        colors: ['#60A5FA', '#9CA3AF'],  
                    };

                    const chart = new google.visualization.PieChart(document.getElementById('chart_pkl_rombelA'));
                    chart.draw(data, options);
                }
            </script>

            <!-- Chart Rombel B -->
            <div id="chart_pkl_rombelB" class="card flex-1 shadow-sm"></div>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', { 
                    packages: ['corechart'] 
                });

                google.charts.setOnLoadCallback(drawChartRombelB);

                function drawChartRombelB() {
                    const chartDataRombelB = @json($chartDataRombelB); 

                    const data = google.visualization.arrayToDataTable(chartDataRombelB); 

                    const options = {
                        title: 'Status Pengisian PKL Rombel B', 
                        pieHole: 0.4, 
                        colors: ['#34D399', '#9CA3AF'],  
                    };

                    const chart = new google.visualization.PieChart(document.getElementById('chart_pkl_rombelB'));
                    chart.draw(data, options);
                }
            </script>
        </div>

        <!-- Bar Chart -->
        <div class="mb-4">
            @if (count($chartDataIndustri) <= 1)
                <div class="text-center py-6 text-gray-500 italic">
                    Belum ada siswa melapor PKL, jadilah yang pertama!
                </div>
            @else
                <div id="chart_industri" style="width: 100%; height: 400px;" class="shadow-sm"></div>
                <script type="text/javascript">
                    google.charts.load('current', { packages: ['corechart'] });
                    google.charts.setOnLoadCallback(drawChartIndustri);

                    function drawChartIndustri() {
                        const data = google.visualization.arrayToDataTable(@json($chartDataIndustri));

                        const options = {
                            title: 'Jumlah Siswa per Industri',
                            colors: ['#FCD34D'], 
                            legend: { position: 'none' },
                            hAxis: {
                                title: 'Industri',
                                textStyle: { fontSize: 10 }
                            },
                            vAxis: {
                                title: 'Jumlah Siswa',
                                minValue: 0
                            }
                        };

                        const chart = new google.visualization.ColumnChart(document.getElementById('chart_industri'));
                        chart.draw(data, options);
                    }
                </script>
            @endif
        </div>


    </div>

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Xx..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</div>
