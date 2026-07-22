@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-6 py-12">
    <div class="bg-white rounded-2xl shadow p-8">
        <h1 class="text-2xl font-black mb-1">Beri Ulasan</h1>
        <p class="text-slate-500 mb-6">{{ $transaction->event->title }}</p>

        <form action="{{ route('review.store', $transaction) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Rating</label>
                <div class="flex flex-row-reverse justify-between w-full text-7xl">
                    @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                        class="peer hidden" {{ old('rating') == $i ? 'checked' : '' }} required>
                    <label for="star{{ $i }}"
                        class="cursor-pointer text-slate-200 peer-checked:text-amber-400 hover:text-amber-400 peer-checked:~peer-hover:text-amber-400 [&~label:hover]:text-amber-400">
                        ★
                    </label>
                    @endfor
                </div>
                @error('rating')<p class="text-red-600 text-xs mt-1 font-medium text-center">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Ulasan (opsional)</label>
                <textarea name="comment" rows="4"
                    class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl">{{ old('comment') }}</textarea>
                @error('comment')<p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Foto dokumentasi (opsional)</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl">
                @error('photo')<p class="text-red-600 text-xs mt-1 font-medium">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Kirim Ulasan
            </button>
        </form>
    </div>
</div>
@endsection