@extends('layouts.user')

@section('title', 'Pelatihan')
@section('breadcrumb', 'User / Pelatihan')

@section('content')
<div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-8">
    <div class="p-5 bg-amber-50 rounded-r-xl border-l-4 border-amber-500 text-amber-800 shadow-sm">
        <p class="font-bold">Informasi Pengembangan</p>
        <p class="text-sm mt-1">Halaman Pelatihan masih dalam tahap pengembangan. Daftar pelatihan akan ditampilkan di sini pada tahap selanjutnya.</p>
    </div>
    
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Placeholder Training Cards -->
        <div class="border-2 border-dashed border-gray-200 rounded-lg h-48 flex items-center justify-center text-gray-400">
            <span class="text-sm">Placeholder Card Pelatihan</span>
        </div>
        <div class="border-2 border-dashed border-gray-200 rounded-lg h-48 flex items-center justify-center text-gray-400">
            <span class="text-sm">Placeholder Card Pelatihan</span>
        </div>
        <div class="border-2 border-dashed border-gray-200 rounded-lg h-48 flex items-center justify-center text-gray-400">
            <span class="text-sm">Placeholder Card Pelatihan</span>
        </div>
    </div>
</div>
@endsection
