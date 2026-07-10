@extends('layouts.user')

@section('title', 'Daftar Pelatihan')
@section('breadcrumb', 'User / Daftar Pelatihan')

@section('content')

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-8">

    <h3 class="text-xl font-bold mb-6">
        Daftar Pelatihan Yang Sudah Didaftarkan
    </h3>

    <table class="min-w-full border">

        <thead class="bg-gray-100">

        <tr>

            <th class="border p-3">Nama User</th>

            <th class="border p-3">Nama Pelatihan</th>

            <th class="border p-3">Nama Mentor</th>

            <th class="border p-3">Status</th>

        </tr>

        </thead>

        <tbody>

        @forelse($pendaftarans as $item)

        <tr>

            <td class="border p-3">
                {{ $item->peserta->nama }}
            </td>

            <td class="border p-3">
                {{ $item->pelatihan->judul }}
            </td>

            <td class="border p-3">
                {{ $item->pelatihan->mentor->nama }}
            </td>

            <td class="border p-3">
                {{ $item->status }}
            </td>

        </tr>

        @empty

        <tr>

            <td colspan="4" class="text-center p-5">
                Belum ada data.
            </td>

        </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection