@extends('layouts.organizer')
@section('page_title', 'Kupon')

@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('organizer.coupons.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm">
        + Buat Kupon
    </a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left">
            <tr>
                <th class="p-4">Kode</th>
                <th class="p-4">Potongan</th>
                <th class="p-4">Terpakai</th>
                <th class="p-4">Berlaku Sampai</th>
                <th class="p-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupons as $coupon)
                <tr class="border-t">
                    <td class="p-4 font-bold">{{ $coupon->code }}</td>
                    <td class="p-4">
                        @if($coupon->type === 'percentage')
                            {{ $coupon->value }}%{{ $coupon->max_discount ? ' (maks Rp' . number_format($coupon->max_discount, 0, ',', '.') . ')' : '' }}
                        @else
                            Rp{{ number_format($coupon->value, 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="p-4">{{ $coupon->used_count }}{{ $coupon->usage_limit ? ' / ' . $coupon->usage_limit : '' }}</td>
                    <td class="p-4">{{ $coupon->valid_until ? $coupon->valid_until->translatedFormat('d F Y') : 'Tidak ada batas' }}</td>
                    <td class="p-4 flex gap-2">
                        <a href="{{ route('organizer.coupons.edit', $coupon) }}" class="text-indigo-600 font-bold">Edit</a>
                        <form action="{{ route('organizer.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Yakin hapus kupon ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-6 text-center text-slate-400">Belum ada kupon.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $coupons->links() }}</div>
@endsection