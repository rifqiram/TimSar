@extends('layouts.user')

@section('title', 'Rekomendasi')
@section('breadcrumb', 'User / Rekomendasi')

@section('content')
<div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-8">
    <div class="p-5 bg-amber-50 rounded-r-xl border-l-4 border-amber-500 text-amber-800 shadow-sm">
        <p class="font-bold">Informasi Pengembangan</p>
        <p class="text-sm mt-1">Halaman Rekomendasi masih dalam tahap pengembangan. Hasil algoritma rekomendasi pelatihan akan ditampilkan di sini pada tahap selanjutnya.</p>
    </div>
    
    <div class="mt-6 border-2 border-dashed border-gray-200 rounded-lg h-64 flex flex-col items-center justify-center text-gray-400">
        <!-- Placeholder Recommendation Result -->
        <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
        </svg>
        <span class="text-sm">Placeholder Hasil Rekomendasi Pelatihan</span>
    </div>
</div>
@endsection
