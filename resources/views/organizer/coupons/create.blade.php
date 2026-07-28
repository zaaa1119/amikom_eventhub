@extends('layouts.organizer')
@section('page_title', 'Buat Kupon')

@section('content')
<div class="bg-white rounded-2xl shadow p-8 max-w-lg">
    <form action="{{ route('organizer.coupons.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block font-bold mb-1 text-sm">Kode Kupon</label>
            <input type="text" name="code" placeholder="MAHASISWA50" value="{{ old('code') }}"
                class="w-full border rounded-xl px-4 py-3 uppercase" required>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Tipe Potongan</label>
            <select name="type" id="type" class="w-full border rounded-xl px-4 py-3" required onchange="toggleMaxDiscount()">
                <option value="percentage">Persentase (%)</option>
                <option value="fixed">Potongan Tetap (Rp)</option>
            </select>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Nilai</label>
            <input type="number" name="value" placeholder="Misal: 50 (untuk 50% atau Rp50.000)" value="{{ old('value') }}"
                class="w-full border rounded-xl px-4 py-3" required>
        </div>
        <div id="max_discount_field">
            <label class="block font-bold mb-1 text-sm">Maksimal Potongan (Rp, opsional)</label>
            <input type="number" name="max_discount" placeholder="Kosongkan kalau tidak ada batas" value="{{ old('max_discount') }}"
                class="w-full border rounded-xl px-4 py-3">
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Minimal Belanja (Rp, opsional)</label>
            <input type="number" name="min_purchase" placeholder="Kosongkan kalau tidak ada syarat" value="{{ old('min_purchase') }}"
                class="w-full border rounded-xl px-4 py-3">
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Batas Jumlah Pemakaian (opsional)</label>
            <input type="number" name="usage_limit" placeholder="Kosongkan kalau tidak terbatas" value="{{ old('usage_limit') }}"
                class="w-full border rounded-xl px-4 py-3">
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Berlaku Sampai (opsional)</label>
            <input type="date" name="valid_until" value="{{ old('valid_until') }}"
                class="w-full border rounded-xl px-4 py-3">
        </div>
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold">Simpan</button>
    </form>
</div>

<script>
function toggleMaxDiscount() {
    const type = document.getElementById('type').value;
    document.getElementById('max_discount_field').style.display = type === 'percentage' ? 'block' : 'none';
}
toggleMaxDiscount();
</script>
@endsection