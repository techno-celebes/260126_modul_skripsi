<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua data lama
        DB::table('permintaan_akademik_progress')->delete();
        DB::table('permintaan_akademiks')->delete();
        DB::table('aktivitas_mahasiswa_log')->delete();
        DB::table('aktivitas_mahasiswa')->delete();
        DB::table('kkn_aktivitas')->delete();
        DB::table('kkn')->delete();
        DB::table('users')->delete();

        // Admin - Login dengan NIP
        User::create([
            'name' => 'Jafar S.Kom',
            'email' => 'admin@uin.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'nim' => '199001012020031001', // NIP
            'email_verified_at' => now(),
        ]);

        // Mahasiswa - Login dengan NIM
        User::create([
            'name' => 'Andi',
            'email' => 'mahasiswa@uin.ac.id',
            'password' => Hash::make('andi'),
            'role' => 'mahasiswa',
            'nim' => '123456789',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Database fresh! 2 user berhasil dibuat:');
        $this->command->info('');
        $this->command->info('👨‍💼 Admin:');
        $this->command->info('   Email: admin@uin.ac.id');
        $this->command->info('   Password: admin123');
        $this->command->info('   NIP: 199001012020031001');
        $this->command->info('');
        $this->command->info('👨‍🎓 Mahasiswa:');
        $this->command->info('   Email: mahasiswa@uin.ac.id');
        $this->command->info('   Password: andi');
        $this->command->info('   NIM: 123456789');
    }
}
