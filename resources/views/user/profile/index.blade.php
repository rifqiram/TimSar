@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg p-5 text-white shadow-md">
            <div class="text-sm opacity-80">Status Akun</div>
            <div class="text-xl font-bold mt-1">Aktif & Terverifikasi</div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg p-5 text-white shadow-md">
            <div class="text-sm opacity-80">Pelatihan Diikuti</div>
            <div class="text-xl font-bold mt-1">0 Pelatihan</div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-lg p-5 text-white shadow-md">
            <div class="text-sm opacity-80">Rekomendasi Kerja</div>
            <div class="text-xl font-bold mt-1">Tersedia</div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-lg mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Profil Saya</h2>

        <div id="alert-message" class="hidden p-4 mb-4 text-sm rounded-lg" role="alert"></div>

        <form id="profile-form">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nomor Telepon</label>
                <input type="text" id="no_telp" name="no_telp" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<!-- i -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // === 1. SKRIP OTOMATIS MENGUBAH TEKS NAVBAR ATAS & BAWAH ===
    document.querySelectorAll('*').forEach(el => {
        // Mengubah "Laravel" di navbar atas menjadi "Halaman"
        if (el.children.length === 0 && el.textContent.trim() === 'Laravel') {
            el.textContent = 'Data Diri';
        }
        // Mengubah judul "Halaman" di bawah navbar menjadi "Deskripsi"
        if (el.children.length === 0 && el.textContent.trim() === 'Halaman' && !el.closest('nav') && !el.closest('header')) {
            el.textContent = 'Profile Saya';
        }
    });

    // === 2. AMBIL DATA USER DARI API ===
    const token = localStorage.getItem('token') || 'dummy_testing_token'; 

    fetch('/api/me', {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const user = data.data?.user || data.user || data;
        
        if(user) {
            document.getElementById('name').value = user.name || '';
            document.getElementById('email').value = user.email || '';
            document.getElementById('no_telp').value = user.no_telp || '';
            document.getElementById('alamat').value = user.alamat || '';
        }
    })
    .catch(error => console.error('Error saat memuat profil:', error));


    // === 3. SIMPAN PERUBAHAN DATA PROFIL ===
    document.getElementById('profile-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const updatedData = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            no_telp: document.getElementById('no_telp').value,
            alamat: document.getElementById('alamat').value,
        };

        fetch('/api/user/profile/update', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(updatedData)
        })
        .then(response => {
            return response.json().then(data => ({ ok: response.ok, data }));
        })
        .then(({ ok, data }) => {
            const alertBox = document.getElementById('alert-message');
            alertBox.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
            
            if(ok) {
                alertBox.classList.add('bg-green-100', 'text-green-700');
                alertBox.innerText = data.message || 'Profil berhasil diperbarui!';
            } else {
                alertBox.classList.add('bg-red-100', 'text-red-700');
                alertBox.innerText = data.message || 'Gagal memperbarui profil.';
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        })
        .catch(error => {
            console.error('Error saat memperbarui profil:', error);
            const alertBox = document.getElementById('alert-message');
            alertBox.classList.remove('hidden');
            alertBox.classList.add('bg-red-100', 'text-red-700');
            alertBox.innerText = 'Terjadi kesalahan sistem.';
        });
    });
});
</script>
@endsection