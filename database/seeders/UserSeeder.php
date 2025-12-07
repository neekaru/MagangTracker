<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $adminUser = \App\Models\User::create([
            'email' => 'admin@magang.com',
            'password' => bcrypt('password123'),
            'role' => 'Admin',
        ]);

        // Create Dosen User first
        $dosenUser = \App\Models\User::create([
            'email' => 'dosen@magang.com',
            'password' => bcrypt('password123'),
            'role' => 'Pembimbing',
        ]);

        // Then create Dosen record
        $dosen = \App\Models\Dosen::create([
            'user_id' => $dosenUser->id,
            'nama_lengkap' => 'Dr. Budi Santoso, M.Kom',
            'nip' => '198501012010011001',
        ]);

        // Update user with dosen id
        $dosenUser->update(['id_dosen' => $dosen->id]);

        // Create Mahasiswa User first
        $mahasiswaUser = \App\Models\User::create([
            'email' => 'mahasiswa@magang.com',
            'password' => bcrypt('password123'),
            'role' => 'Mahasiswa',
        ]);

        // Then create Mahasiswa record
        $mahasiswa = \App\Models\Mahasiswa::create([
            'user_id' => $mahasiswaUser->id,
            'nim' => '1234567890',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonths(3),
        ]);

        // Update user with mahasiswa id
        $mahasiswaUser->update(['id_mahasiswa' => $mahasiswa->id]);

        // Create Periode Magang
        $periodeMagang = \App\Models\PeriodeMagang::create([
            'nama_periode' => 'Periode Januari - Maret 2024',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonths(3),
            'status_magang' => 'Aktif',
        ]);

        // Create Unit Bisnis
        $unitBisnis = \App\Models\UnitBisnis::create([
            'nama_unit_bisnis' => 'IT Development',
            'id_periode' => $periodeMagang->id,
        ]);

        // Create Magang record for the student
        \App\Models\Magang::create([
            'id_mahasiswa' => $mahasiswa->id,
            'unit_id' => $unitBisnis->id,
            'periode_id' => $periodeMagang->id,
            'id_dosen' => $dosen->id,
            'pembimbing_lapangan' => 'Andi Wijaya, S.T.',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonths(3),
            'status_magang' => 'Aktif',
            'target_book_mingguan' => 5,
            'tugas_description' => 'Mengembangkan aplikasi web dan mobile untuk sistem informasi perusahaan.',
        ]);

        echo "✅ Seeder berhasil dijalankan!\n";
        echo "📧 Admin: admin@magang.com | password: password123\n";
        echo "📧 Dosen: dosen@magang.com | password: password123\n";
        echo "📧 Mahasiswa: mahasiswa@magang.com | password: password123\n";
    }
}
