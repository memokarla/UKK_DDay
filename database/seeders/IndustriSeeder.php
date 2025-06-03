<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Industri;

class IndustriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industris = Industri::insert([
            [
                'nama' => 'PT Aksa Digital Group', 
                'foto' => 'images/industri/aksa.jpg',
                'bidang_usaha' => 'IT Service and IT Consulting (Information Technology Company)',
                'alamat' => 'Jl. Wongso Permono No.26, Klidon, Sukoharjo, Kec. Ngaglik, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55581',
                'kontak' => '08982909000',
                'email' => 'aksa@gmail.com',
                'website' => 'https://aksa.id/',
            ],
            [
                'nama' => 'PT Gamatechno Indonesia', 
                'foto' => 'images/industri/gama.jpg',
                'bidang_usaha' => 'Penyedia layanan, solusi, dan produk inovasi teknologi informasi serta holding company yang melahirkan startup di bidang teknologi informasi.',
                'alamat' => 'Jl. Purwomartani, Karangmojo, Purwomartani, Kec. Kalasan, Kabupaten Sleman, Daerah Istimewa Yogyakarta',
                'kontak' => '0274-5044044',
                'email' => 'info@gamatechno.com',
                'website' => 'https://www.gamatechno.com/',
            ],
            [
                'nama' => 'CV Karya Hidup Sentosa', 
                'foto' => 'images/industri/khs.jpg',
                'bidang_usaha' => 'Alat pertanian',
                'alamat' => 'Jl. Magelang KM.8,8, Jongke Tengah, Sendangadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55285',
                'kontak' => '0274-512095',
                'email' => 'quick@gmail.com',
                'website' => 'https://www.quick.co.id/',
            ],
            [
                'nama' => 'PT Murni Cahaya Pratama', 
                'foto' => 'images/industri/chargloss.png',
                'bidang_usaha' => 'Produsen dan pemasar cat yang melindungi, memelihara dan meningkatkan tampilan visual berbagai produk otomotif di pasar Indonesia',
                'alamat' => 'Jl. Kp. Lio Baru Desa No.Km. 2, Sanja, Kec. Citeureup, Kabupaten Bogor, Jawa Barat 16810',
                'kontak' => '0217-3887744',
                'email' => 'cs@cargloss.co.id',
                'website' => 'https://cargloss.co.id/',
            ],
            [
                'nama' => 'Cyberkarta', 
                'foto' => 'images/industri/cyberkarta.jpg',
                'bidang_usaha' => 'Layanan keamanan komputer di Indonesia',
                'alamat' => 'Jl. Pogung Kidul No.17, Pogung Kidul, Sinduadi, Kec. Mlati, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55284',
                'kontak' => '0851-6183-5865',
                'email' => 'business@cyberkarta.com',
                'website' => 'https://cyberkarta.com/',
            ],
        ]);
    }
}
