<?php
namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kategori;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'AkbarDZ',
            'email' => 'rabbaniakbar4@gmail.com',
            'role' => '1',
            'status' => 1,
            'hp' => '087780621927',
            'password' => bcrypt('@dz12345'),
        ]);
        #untuk record berikutnya silahkan, beri nilai berbeda pada nilai: nama, email, hp dengan
        User::create([
            'nama' => 'Rofi Ramadhan',
            'email' => 'rofjawa@gmail.com',
            'role' => '2',
            'status' => 1,
            'hp' => '089965221732',
            'password' => bcrypt('@jawa12345'),

        ]);
    }
}

