@extends('layouts.user')

@section('title', 'Dashboard')
@section('breadcrumb', 'User / Dashboard')

@section('content')
<div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 tracking-tight">Selamat Datang, <span id="dashUserName">User</span></h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Placeholder Cards -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 p-6 rounded-xl border border-blue-100 shadow-sm transition-transform hover:scale-[1.02] duration-200">
            <h3 class="text-blue-900 font-medium">Status Profil</h3>
            <p class="text-sm text-blue-700 font-medium mt-1">Placeholder status kelengkapan profil.</p>
        </div>
        
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 p-6 rounded-xl border border-emerald-100 shadow-sm transition-transform hover:scale-[1.02] duration-200">
            <h3 class="text-emerald-900 font-medium">Pelatihan Aktif</h3>
            <p class="text-sm text-emerald-700 font-medium mt-1">Placeholder info pelatihan saat ini.</p>
        </div>
        
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100/50 p-6 rounded-xl border border-indigo-100 shadow-sm transition-transform hover:scale-[1.02] duration-200">
            <h3 class="text-indigo-900 font-medium">Rekomendasi Baru</h3>
            <p class="text-sm text-indigo-700 font-medium mt-1">Placeholder jumlah rekomendasi baru.</p>
        </div>
    </div>

    <div class="mt-8 p-5 bg-amber-50 rounded-r-xl border-l-4 border-amber-500 text-amber-800 shadow-sm">
        <p class="font-bold">Informasi Pengembangan</p>
        <p class="text-sm mt-1">Halaman ini masih dalam tahap pengembangan. Fitur statistik dan data real akan diimplementasikan pada tahap selanjutnya.</p>
    </div>
</div>
@endsection
