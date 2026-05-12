<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelanggan;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::create([
            'idpel' => '513030087368',
            'nama' => 'DUL MAJID',
            'tarif_daya' => 'R1/450 VA',
            'stand_meter' => '00015875-00015965',
        ]);

        Pelanggan::create([
            'idpel' => '513030356362',
            'nama' => 'SUTIKNO',
            'tarif_daya' => 'R1M/900 VA',
            'stand_meter' => '00026622-00026733',
        ]);

        Pelanggan::create([
            'idpel' => '513030333740',
            'nama' => 'RUMINAH',
            'tarif_daya' => 'R1/450 VA',
            'stand_meter' => '00024319-00024391',
        ]);

        Pelanggan::create([
            'idpel' => '513030350894',
            'nama' => 'PANI',
            'tarif_daya' => 'R1/450 VA',
            'stand_meter' => '00023052-00023147',
        ]);

        Pelanggan::create([
            'idpel' => '513030494362',
            'nama' => 'MUHAMMAD IKSAN',
            'tarif_daya' => 'R1M/900 VA',
            'stand_meter' => '00020392-00020419',
        ]);

        Pelanggan::create([
            'idpel' => '513030361942',
            'nama' => 'NUR BIDIN',
            'tarif_daya' => 'R1/450 VA',
            'stand_meter' => '00003082-00003158',
        ]);

        Pelanggan::create([
            'idpel' => '513030422124',
            'nama' => 'LADI MASHURI',
            'tarif_daya' => 'R1/450 VA',
            'stand_meter' => '00013453-00013563',
        ]);

        Pelanggan::create([
            'idpel' => '513030497734',
            'nama' => 'HARIYONO',
            'tarif_daya' => 'R1M/900 VA',
            'stand_meter' => '00030799-00030827',
        ]);

        Pelanggan::create([
            'idpel' => '513030984969',
            'nama' => 'MUSLIKAH',
            'tarif_daya' => 'R1M/900 VA',
            'stand_meter' => '00008956-00009088',
        ]);

        pelanggan::create([
            'idpel' => '513030198453',
            'nama' => 'WAGIMUN',
            'tarif_daya' => 'R1/900 VA',
            'stand_meter' => '00007296-00007371',
        ]);
    }
}
