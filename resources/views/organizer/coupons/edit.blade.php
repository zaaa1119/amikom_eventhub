@extends('layouts.organizer')
@section('page_title', 'Edit Kupon')

@section('content')
<div class="bg-white rounded-2xl shadow p-8 max-w-lg">
    <form action="{{ route('organizer.coupons.update', $coupon) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block font-bold mb-1 text-sm">Kode Kupon</label>
            <input type="text" name="code" value="{{ $coupon->code }}" class="w-full border rounded-xl px-4 py-3 uppercase" required>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Tipe Potongan</label>
            <select name="type" id="type" class="w-full border rounded-xl px-4 py-3" required onchange="toggleMaxDiscount()">
                <option value="percentage" {{ $coupon->type === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>Potongan Tetap (Rp)</option>
            </select>
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Nilai</label>
            <input type="number" name="value" value="{{ $coupon->value }}" class="w-full border rounded-xl px-4 py-3" required>
        </div>
        <div id="max_discount_field">
            <label class="block font-bold mb-1 text-sm">Maksimal Potongan (Rp, opsional)</label>
            <input type="number" name="max_discount" value="{{ $coupon->max_discount }}" class="w-full border rounded-xl px-4 py-3">
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Minimal Belanja (Rp, opsional)</label>
            <input type="number" name="min_purchase" value="{{ $coupon->min_purchase }}" class="w-full border rounded-xl px-4 py-3">
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Batas Jumlah Pemakaian (opsional)</label>
            <input type="number" name="usage_limit" value="{{ $coupon->usage_limit }}" class="w-full border rounded-xl px-4 py-3">
        </div>
        <div>
            <label class="block font-bold mb-1 text-sm">Berlaku Sampai (opsional)</label>
            <input type="date" name="valid_until" value="{{ $coupon->valid_until?->format('Y-m-d') }}" class="w-full border rounded-xl px-4 py-3">
        </div>
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold">Update</button>
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