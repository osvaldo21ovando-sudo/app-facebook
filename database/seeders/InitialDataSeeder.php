<?php
namespace Database\Seeders;

use App\Models\PoliticalStructure;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        $partido = PoliticalStructure::create([
            'name'  => 'Partido Principal',
            'type'  => 'partido',
            'color' => '#1a56db',
        ]);

        $zona1 = PoliticalStructure::create([
            'name'      => 'Zona Norte',
            'type'      => 'zona',
            'parent_id' => $partido->id,
            'color'     => '#0e9f6e',
        ]);

        $zona2 = PoliticalStructure::create([
            'name'      => 'Zona Sur',
            'type'      => 'zona',
            'parent_id' => $partido->id,
            'color'     => '#e3a008',
        ]);

        PoliticalStructure::create([
            'name'      => 'Sección 1',
            'type'      => 'seccion',
            'parent_id' => $zona1->id,
            'color'     => '#7e3af2',
        ]);

        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@tudominio.com',
            'password' => Hash::make('CambiarEstaPassword123!'),
            'role'     => 'admin',
        ]);

        $this->command->info('✅ Datos iniciales creados.');
        $this->command->info('   Admin: admin@tudominio.com / CambiarEstaPassword123!');
    }
}