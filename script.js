document.addEventListener('DOMContentLoaded', () => {
    const ipkValue = parseFloat(document.getElementById('ipk')?.value || 0); // Cek jika elemen ada
    const beasiswaSelect = document.getElementById('beasiswa');
    const berkasInput = document.getElementById('berkas');
    const submitBtn = document.getElementById('submit-btn');
    const daftarForm = document.getElementById('daftar-form');
    const hasilContainer = document.getElementById('hasil-container');
    const nextBtn = document.getElementById('next-btn');
    const deleteBtn = document.getElementById('delete-btn');

    let currentIndex = 0; // Indeks untuk menampilkan pendaftar

    // Cek apakah form ada (berarti berada di halaman daftar)
    if (daftarForm) {
        // Logika validasi di halaman daftar
        if(ipkValue >= 3) {
            beasiswaSelect.disabled = false;
            berkasInput.disabled = false;
            submitBtn.disabled = false;
            beasiswaSelect.focus();
        } else {
            beasiswaSelect.disabled = true;
            berkasInput.disabled = true;
            submitBtn.disabled = true;
            alert('IPK Anda dibawah 3.0.  Anda tidak dapat mendaftar beasiswa.');
        }

        // Validasi Form (email, hp, dan handling submit)
        daftarForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Simpan data form ke localStorage
            const aplikasi = {
                nama: document.getElementById('nama').value,
                email: document.getElementById('email').value,
                hp: document.getElementById('hp').value,
                semester: document.getElementById('semester').value,
                ipk: ipkValue,
                beasiswa: document.getElementById('beasiswa').value,
                berkas: document.getElementById('berkas').files[0]?.name || 'Tidak ada berkas',
                status_ajuan: 'Belum di verifikasi'
            };

            let dataAplikasi = JSON.parse(localStorage.getItem('aplikasi')) || [];
            dataAplikasi.push(aplikasi);
            localStorage.setItem('aplikasi', JSON.stringify(dataAplikasi));

            alert('Pendaftaran berhasil!');
            daftarForm.reset();
        });
    }

    // Cek apakah halaman hasil dan elemen container ada
    if (hasilContainer) {
        const dataAplikasi = JSON.parse(localStorage.getItem('aplikasi')) || [];

        if (dataAplikasi.length === 0) {
            hasilContainer.innerHTML = '<p>Belum ada pendaftaran.</p>';
        } else {
            // Fungsi untuk menampilkan data aplikasi berdasarkan index
            const showAplikasi = (index) => {
                hasilContainer.innerHTML = ''; // Kosongkan container hasil
                const app = dataAplikasi[index]; // Ambil data aplikasi berdasarkan index
                const div = document.createElement('div');
                div.innerHTML = `
                    <h3>Pendaftaran ${index + 1} dari ${dataAplikasi.length}</h3>
                    <p><strong>Nama:</strong> ${app.nama}</p>
                    <p><strong>Email:</strong> ${app.email}</p>
                    <p><strong>Nomor HP:</strong> ${app.hp}</p>
                    <p><strong>Semester:</strong> ${app.semester}</p>
                    <p><strong>IPK:</strong> ${app.ipk}</p>
                    <p><strong>Beasiswa:</strong> ${app.beasiswa}</p>
                    <p><strong>Berkas:</strong> ${app.berkas}</p>
                    <p><strong>Status Ajuan:</strong> ${app.status_ajuan}</p>
                `;
                hasilContainer.appendChild(div);
            };

            // Tampilkan data pendaftar pertama
            showAplikasi(currentIndex);

            // Tampilkan tombol Next jika ada lebih dari satu pendaftar
            if (dataAplikasi.length > 1) {
                nextBtn.style.display = 'block'; // Tampilkan tombol next

                // Event Listener untuk tombol next
                nextBtn.addEventListener('click', () => {
                    currentIndex = (currentIndex + 1) % dataAplikasi.length; // Pindah ke pendaftar berikutnya, kembali ke awal jika sudah di akhir
                    showAplikasi(currentIndex); // Tampilkan pendaftar baru
                });
            }

            // Tampilkan tombol hapus jika ada data
            deleteBtn.style.display = 'block';

            // Event Listener untuk tombol hapus
            deleteBtn.addEventListener('click', () => {
                if (confirm('Apakah Anda yakin ingin menghapus semua data?')) {
                    localStorage.removeItem('aplikasi'); // Hapus semua data dari localStorage
                    hasilContainer.innerHTML = '<p>Semua data pendaftaran telah dihapus.</p>';
                    nextBtn.style.display = 'none'; // Sembunyikan tombol next
                    deleteBtn.style.display = 'none'; // Sembunyikan tombol hapus
                }
            });
        }
    }
});
