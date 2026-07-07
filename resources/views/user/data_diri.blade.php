@extends('layouts.user')

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        
        <form action="{{ route('user.profile.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id" value="{{ $peserta->id ?? '' }}">

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" 
                       value="{{ old('nama', $peserta->nama ?? '') }}" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="umur">Umur</label>
                <input type="number" name="umur" id="umur" class="form-control" 
                       value="{{ old('umur', $peserta->umur ?? '') }}" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="email">Alamat E-mail</label>
                <input type="email" name="email" id="email" class="form-control" 
                       value="{{ old('email', $peserta->email ?? '') }}" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="telepon">Nomor Telepon</label>
                <input type="text" name="telepon" id="telepon" class="form-control" 
                       value="{{ old('telepon', $peserta->telepon ?? '') }}" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="keahlian">Keahlian</label>
                <select name="keahlian" id="keahlian" class="form-control" required style="width: 100%; padding: 8px; margin-top: 5px;">
                    <option value="" disabled {{ old('keahlian', $peserta->keahlian ?? '') == '' ? 'selected' : '' }}>-- Pilih Keahlian --</option>
                    <option value="Web Developer" {{ old('keahlian', $peserta->keahlian ?? '') == 'Web Developer' ? 'selected' : '' }}>Web Developer</option>
                    <option value="Mobile Developer" {{ old('keahlian', $peserta->keahlian ?? '') == 'Mobile Developer' ? 'selected' : '' }}>Mobile Developer</option>
                    <option value="Data Analyst" {{ old('keahlian', $peserta->keahlian ?? '') == 'Data Analyst' ? 'selected' : '' }}>Data Analyst</option>
                    <option value="UI/UX Designer" {{ old('keahlian', $peserta->keahlian ?? '') == 'UI/UX Designer' ? 'selected' : '' }}>UI/UX Designer</option>
                    <option value="Network Engineer" {{ old('keahlian', $peserta->keahlian ?? '') == 'Network Engineer' ? 'selected' : '' }}>Network Engineer</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="background-color: #4e73df; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
                Simpan Data Diri
            </button>
        </form>
    </div>
</div>
@endsection