@extends('layouts.user')

@section('title', 'Pelatihan')
@section('breadcrumb', 'User / Pelatihan')

@section('content')
<div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-8">
    <div class="border-b border-gray-200 pb-4 mb-6">
        <h3 class="text-lg font-bold leading-6 text-gray-900">Form Pendaftaran Pelatihan</h3>
        <p class="mt-1 text-sm text-gray-500">Silakan pilih program pelatihan yang tersedia dan mentor akan ditentukan secara otomatis.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-r-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('user.pendaftaran.store') }}" method="POST">
        @csrf
        
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Program Pelatihan</label>
            <select name="pelatihan_id" id="pelatihan_dropdown" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border" onchange="tentukanMentor()" required>
                <option value="">-- Silakan Pilih Pelatihan --</option>
                @foreach($pelatihans as $pelatihan)
                    <option value="{{ $pelatihan->id }}" data-mentor="{{ $pelatihan->mentor->nama ?? 'Mentor Belum Ditentukan' }}">
                        {{ $pelatihan->judul }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Mentor Pendamping</label>
            <input type="text" id="nama_mentor" class="block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm text-gray-500 sm:text-sm p-3 border cursor-not-allowed" readonly placeholder="Nama mentor akan muncul otomatis">
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Daftar Sekarang
            </button>
        </div>
    </form>
</div>

<script>
    function tentukanMentor() {
        let dropdown = document.getElementById('pelatihan_dropdown');
        let inputMentor = document.getElementById('nama_mentor');
        
        if(dropdown.value !== "") {
            let selectedOption = dropdown.options[dropdown.selectedIndex];
            inputMentor.value = selectedOption.getAttribute('data-mentor');
        } else {
            inputMentor.value = "";
        }
    }
</script>
@endsection