<x-app-layout>
    <x-slot name="sidebar">
        @include('ketua.partials.sidebar')
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Setoran') }}
        </h2>
    </x-slot>

    <div class="p-6 lg:p-10">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <form action="{{ route('ketua.setoran.store') }}" method="POST" class="p-6">
                @csrf

                <div class="mb-6">
                    <x-input-label for="warga_id" :value="__('Pilih Warga')" />
                    <select id="warga_id" name="warga_id" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" required>
                        <option value="">Cari Nama Warga</option>
                        @foreach ($wargas as $warga)
                            <option value="{{ $warga->id_user }}">{{ $warga->nama_lengkap }}</option>
                        @endforeach
                    </select>
                    @if($wargas->isEmpty())
                        <p class="text-red-500 text-xs mt-1">Tidak ada warga aktif di RW Anda yang terdaftar.</p>
                    @endif
                </div>

                <div class="border-t border-gray-200 my-6"></div>

                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Rincian Sampah</h3>
                    <div id="items-container">
                        <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-end">
                            <div class="md:col-span-7">
                                <x-input-label :value="__('Jenis Sampah')" />
                                <select name="sampah_id[]" class="sampah-select block w-full border-gray-300 rounded-md shadow-sm" required onchange="updateHarga(this)">
                                    <option value="" data-harga="0">Pilih Sampah</option>
                                    @foreach ($sampahs as $sampah)
                                        <option value="{{ $sampah->id_sampah }}" data-harga="{{ $sampah->harga_anggota }}">
                                            {{ $sampah->nama_sampah }} (Rp {{ number_format($sampah->harga_anggota, 0, ',', '.') }}/{{ $sampah->UOM }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <x-input-label :value="__('Berat (Kg/Pcs)')" />
                                <x-text-input type="number" name="berat[]" class="block w-full" step="0.01" placeholder="0" required oninput="hitungSubtotal(this)" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-gray-700">Subtotal</label>
                                <div class="py-2 px-3 bg-gray-100 rounded-md text-right font-bold text-gray-700 subtotal-display">
                                    Rp 0
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="tambahBaris()" class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Item Lain
                    </button>
                </div>

                <div class="bg-green-50 p-4 rounded-lg flex justify-between items-center mb-6">
                    <span class="text-lg font-bold text-green-800">Total Estimasi:</span>
                    <span id="total-keseluruhan" class="text-2xl font-bold text-green-700">Rp 0</span>
                </div>

                <div class="flex justify-end">
                    <x-primary-button class="w-full md:w-auto justify-center">
                        {{ __('Simpan Setoran') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function tambahBaris() {
            const container = document.getElementById('items-container');
            const firstRow = container.querySelector('.item-row');
            const newRow = firstRow.cloneNode(true);
            
            newRow.querySelector('input').value = '';
            newRow.querySelector('select').value = '';
            newRow.querySelector('.subtotal-display').innerText = 'Rp 0';
            
            if (!newRow.querySelector('.btn-remove')) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn-remove text-red-500 hover:text-red-700 ml-2 text-sm font-bold';
                removeBtn.innerText = 'Hapus';
                removeBtn.onclick = function() { this.closest('.item-row').remove(); hitungTotalKeseluruhan(); };
                newRow.appendChild(removeBtn);
            }

            container.appendChild(newRow);
        }

        function updateHarga(selectElement) {
            const row = selectElement.closest('.item-row');
            const inputBerat = row.querySelector('input[name="berat[]"]');
            hitungSubtotal(inputBerat);
        }

        function hitungSubtotal(inputElement) {
            const row = inputElement.closest('.item-row');
            const selectSampah = row.querySelector('.sampah-select');
            const subtotalDisplay = row.querySelector('.subtotal-display');
            
            const berat = parseFloat(inputElement.value) || 0;

            const harga = parseFloat(selectSampah.options[selectSampah.selectedIndex].dataset.harga) || 0;
            
            const subtotal = berat * harga;
            
            subtotalDisplay.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
            
            hitungTotalKeseluruhan();
        }

        function hitungTotalKeseluruhan() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const selectSampah = row.querySelector('.sampah-select');
                const inputBerat = row.querySelector('input[name="berat[]"]');
                
                const berat = parseFloat(inputBerat.value) || 0;
                const harga = parseFloat(selectSampah.options[selectSampah.selectedIndex].dataset.harga) || 0;
                
                total += (berat * harga);
            });
            
            document.getElementById('total-keseluruhan').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }
    </script>
</x-app-layout>