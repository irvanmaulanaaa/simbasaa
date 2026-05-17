<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Saldo;
use App\Models\Penarikan;

class PenarikanSaldoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Persiapan Data Dummy Warga beserta Saldonya
     */
    private function prepareDummyWarga($jumlahSaldo = 50000)
    {
        $roleWarga = Role::firstOrCreate(['nama_role' => 'warga']);

        $warga = User::create([
            'role_id' => $roleWarga->id_role ?? $roleWarga->id,
            'nama_lengkap' => 'Warga Penarikan Test',
            'username' => 'wargatarik_' . uniqid(),
            'password' => bcrypt('password123'),
            'status' => 'aktif'
        ]);

        Saldo::create([
            'user_id' => $warga->id_user ?? $warga->id,
            'jumlah_saldo' => $jumlahSaldo
        ]);

        return $warga;
    }

    public function test_sistem_menolak_pengajuan_jika_nominal_kosong(): void
    {
        $warga = $this->prepareDummyWarga();
        $this->actingAs($warga);

        $response = $this->postJson('/warga/tarik-saldo', [
            'jumlah' => ''
        ]);

        $response->assertStatus(400)
                 ->assertJson(['message' => 'Jumlah penarikan wajib diisi.']);
    }

    public function test_sistem_memblokir_jika_nominal_kurang_dari_batas_minimal(): void
    {
        $warga = $this->prepareDummyWarga();
        $this->actingAs($warga);

        $response = $this->postJson('/warga/tarik-saldo', [
            'jumlah' => 5000 
        ]);

        $response->assertStatus(400)
                 ->assertJson(['message' => 'Minimal penarikan Rp 10.000.']);
    }

    public function test_sistem_menolak_jika_nominal_melebihi_saldo(): void
    {
        $warga = $this->prepareDummyWarga(50000); 
        $this->actingAs($warga);

        $response = $this->postJson('/warga/tarik-saldo', [
            'jumlah' => 100000 
        ]);

        $response->assertStatus(400)
                 ->assertJson(['message' => 'Saldo Anda tidak mencukupi.']);
    }

    public function test_sistem_berhasil_menyimpan_pengajuan_pending(): void
    {
        $warga = $this->prepareDummyWarga(50000);
        $this->actingAs($warga);

        $jumlahTarik = 20000;

        $response = $this->postJson('/warga/tarik-saldo', [
            'jumlah' => $jumlahTarik
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('penarikan', [
            'warga_id' => $warga->id_user ?? $warga->id,
            'jumlah' => $jumlahTarik,
            'status' => 'pending'
        ]);
    }
}