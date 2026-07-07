@extends('admin.Layout.layout')

@section('content')
<style>

    .pendaftaran-container {
        display: flex;
        justify-content: center; 
        align-items: center;     
        width: 100%;             
        padding: 40px 20px;
        min-height: calc(100vh - 100px);
        background-color: var(--color-bg, #f8fafc);
    }
    .user-dashboard-card {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;          
        padding: 40px;
        background: var(--color-surface, #ffffff);
        border: 1px solid var(--color-border, #e2e8f0);
        border-radius: var(--radius-lg, 16px);
        box-shadow: var(--shadow-md, 0 10px 15px -3px rgba(0, 0, 0, 0.1));
        height: fit-content;
    }
    .user-dashboard-card h2 {
        margin-top: 0;
        margin-bottom: 24px;
        color: #0f172a;
        font-size: 24px;
        font-weight: 700;
        text-align: center;
    }
    .form-group {
        margin-bottom: 24px;
    }
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #475569;
        font-size: 14px;
    }
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 15px;
        color: #334155;
        background-color: #ffffff;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    .form-control[readonly] {
        background-color: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
    }
    .btn-submit {
        background-color: #2563eb;
        color: white;
        padding: 14px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.2s ease, transform 0.1s ease;
        margin-top: 10px;
    }
    .btn-submit:hover {
        background-color: #1d4ed8;
    }
    .btn-submit:active {
        transform: translateY(1px);
    }
    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 500;
    }
    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .alert-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
</style>

<div class="pendaftaran-container">
    <div class="user-dashboard-card">
        <h2>Daftar Pelatihan</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('user.pendaftaran.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Pilih Program Pelatihan</label>
                <select name="pelatihan_id" id="pelatihan_dropdown" class="form-control" onchange="tentukanMentor()" required>
                    <option value="">-- Silakan Pilih Pelatihan --</option>
                    @foreach($pelatihans as $pelatihan)
                        <option value="{{ $pelatihan->id }}" data-mentor="{{ $pelatihan->mentor->nama ?? 'Mentor Belum Ditentukan' }}">
                            {{ $pelatihan->judul }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Mentor Pendamping</label>
                <input type="text" id="nama_mentor" class="form-control" readonly placeholder="Nama mentor akan muncul otomatis">
            </div>

            <button type="submit" class="btn-submit">Daftar Sekarang</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
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
@endpush