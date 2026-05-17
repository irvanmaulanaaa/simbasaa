<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Sampah;
use App\Models\Setoran;
use App\Models\Saldo;
use App\Models\DetailSetoran;
use Illuminate\Support\Facades\DB;

class SetoranSampahTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Persiapan Data Dummy menyesuaikan struktur relasi database SIMBASA
     */
    private function prepareDummyData()
    {
        $roleKetua = Role::firstOrCreate(['nama_role' => 'ketua']);
        $roleWarga = Role::firstOrCreate(['nama_role' => 'warga']);

        $ketua = User::create([
            'role_id' => $roleKetua->id_role ?? $roleKetua->id,
            'nama_lengkap' => 'Ketua Test',
            'username' => 'ketuatest_' . uniqid(),
            'password' => bcrypt('password123'),
            'status' => 'aktif'
        ]);

        $warga = User::create([
            'role_id' => $roleWarga->id_role ?? $roleWarga->id,
            'nama_lengkap' => 'Warga Test',
            'username' => 'wargatest_' . uniqid(),
            'password' => bcrypt('password123'),
            'status' => 'aktif'
        ]);

        $kategoriId = DB::table('kategori_sampah')->insertGetId([
            'nama_kategori' => 'Kertas/Kardus Test'
        ]);

        $sampah = Sampah::create([
            'kategori_id' => $kategoriId,
            'diinput_oleh' => $ketua->id_user ?? $ketua->id,
            'nama_sampah' => 'Kardus Bekas Test',
            'deskripsi' => 'Ini adalah deskripsi sampah untuk keperluan testing',
            'kode_sampah' => 'KRD-' . uniqid(), 
            'harga_anggota' => 2000,
            'harga_bsb' => 2500, 
            'UOM' => 'kg', 
            'status_sampah' => 'aktif'
        ]);

        return [$ketua, $warga, $sampah];
    }

    public function test_sistem_memblokir_input_setoran_tidak_valid(): void
    {
        [$ketua, $warga, $sampah] = $this->prepareDummyData();

        $this->actingAs($ketua);

        $response = $this->post('/ketua/setoran', [
            'warga_id' => '', 
            'sampah_id' => [], 
            'berat' => [0] 
        ]);

        $response->assertSessionHasErrors(['warga_id', 'sampah_id', 'berat.0']);
    }

    public function test_sistem_berhasil_menghitung_dan_menyimpan_setoran(): void
    {
        [$ketua, $warga, $sampah] = $this->prepareDummyData();

        $this->actingAs($ketua);

        $beratInput = 2.5; 
        $hargaMaster = 2000;
        $ekspektasiTotalHarga = $beratInput * $hargaMaster; 

        $response = $this->post('/ketua/setoran', [
            'warga_id' => $warga->id_user ?? $warga->id,
            'sampah_id' => [$sampah->id_sampah ?? $sampah->id],
            'berat' => [$beratInput]
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Setoran berhasil ditambahkan.');

        $this->assertDatabaseHas('setoran', [
            'warga_id' => $warga->id_user ?? $warga->id,
            'ketua_id' => $ketua->id_user ?? $ketua->id,
            'total_harga' => $ekspektasiTotalHarga 
        ]);

        $this->assertDatabaseHas('detail_setoran', [
            'sampah_id' => $sampah->id_sampah ?? $sampah->id,
            'berat' => $beratInput,
            'subtotal' => $ekspektasiTotalHarga
        ]);

        $saldoWarga = Saldo::where('user_id', ($warga->id_user ?? $warga->id))->first();
        $this->assertNotNull($saldoWarga, 'Data saldo tidak ditemukan untuk warga ini.');
        $this->assertEquals($ekspektasiTotalHarga, $saldoWarga->jumlah_saldo);
    }
}