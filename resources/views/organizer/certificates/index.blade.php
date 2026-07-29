@extends('layouts.organizer')
@section('page_title', 'Kirim Sertifikat')
@section('page_subtitle', $event->title)

@section('content')
<div class="bg-white rounded-2xl shadow p-6">
    @if($participants->isEmpty())
    <p class="text-slate-400 text-center py-10">
        Belum ada peserta yang check-in untuk event ini.
    </p>
    @else
    <form action="{{ route('organizer.certificates.send', $event) }}" method="POST">
        @csrf

        <div class="flex justify-between items-center mb-4">
            <label class="flex items-center gap-2 text-sm font-bold">
                <input type="checkbox" id="select-all" checked class="w-4 h-4">
                Pilih Semua
            </label>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm">
                Kirim Sertifikat ke yang Dipilih
            </button>
        </div>

        <div class="divide-y divide-slate-100">
            @foreach($participants as $trx)
            <label class="flex items-center justify-between py-3 cursor-pointer">
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="transaction_ids[]" value="{{ $trx->id }}"
                        class="participant-checkbox w-4 h-4" checked>
                    <div>
                        <p class="font-bold text-sm">{{ $trx->customer_name }}</p>
                        <p class="text-slate-400 text-xs">{{ $trx->customer_email }}</p>
                    </div>
                </div>
                <a href="{{ route('organizer.certificates.preview', $trx) }}" class="text-slate-500 text-xs font-bold hover:underline mr-3">
                    👁 Preview
                </a>
                @if($trx->certificate?->sent_at)
                <span class="text-green-600 text-xs font-bold">
                    ✓ Terkirim {{ $trx->certificate->sent_at->diffForHumans() }}
                </span>
                @else
                <span class="text-slate-400 text-xs">Belum dikirim</span>
                @endif
            </label>
            @endforeach
        </div>
    </form>
    @endif
</div>

<script>
    document.getElementById('select-all')?.addEventListener('change', function() {
        document.querySelectorAll('.participant-checkbox').forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection