@extends('layouts.admin')

@section('title', 'Add New User')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Tambah Pengguna Baru</h1>
            <p class="text-muted small mb-0">Buat akun pengguna baru untuk sistem</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Create User Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-white bg-opacity-25 rounded-circle p-3 me-3">
                            <i class="fas fa-user-plus fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Formulir Pengguna Baru</h5>
                            <small class="opacity-75">Lengkapi informasi di bawah ini</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST" id="createUserForm">
                        @csrf

                        <!-- Name Input -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-user text-primary me-2"></i>Nama Lengkap
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}" 
                                   required
                                   class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope text-primary me-2"></i>Email Address
                                <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   placeholder="contoh@email.com">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Email akan digunakan untuk login
                            </small>
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Section -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-3">
                                    <i class="fas fa-lock text-warning me-2"></i>Keamanan Akun
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="password" class="form-label fw-semibold small">
                                            Password <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-key text-muted"></i>
                                            </span>
                                            <input type="password" 
                                                   name="password" 
                                                   id="password"
                                                   required
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="Minimal 6 karakter">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div id="passwordStrength"></div>
                                        @error('password')
                                            <div class="text-danger small mt-1">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label fw-semibold small">
                                            Konfirmasi Password <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-shield-alt text-muted"></i>
                                            </span>
                                            <input type="password" 
                                                   name="password_confirmation" 
                                                   id="password_confirmation"
                                                   required
                                                   class="form-control"
                                                   placeholder="Ulangi password">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div id="passwordMatch"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-4">
                            <label for="role" class="form-label fw-semibold">
                                <i class="fas fa-user-tag text-primary me-2"></i>Role / Peran
                                <span class="text-danger">*</span>
                            </label>
                            <select name="role" 
                                    id="role" 
                                    required
                                    class="form-select form-select-lg @error('role') is-invalid @enderror">
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    🛠️ Admin - Akses penuh sistem
                                </option>
                                <option value="ustadz" {{ old('role') == 'ustadz' ? 'selected' : '' }}>
                                    👨‍🏫 Ustadz - Pengajar pria
                                </option>
                                <option value="ustadzah" {{ old('role') == 'ustadzah' ? 'selected' : '' }}>
                                    👩‍🏫 Ustadzah - Pengajar wanita
                                </option>
                                <option value="santri_putra" {{ old('role') == 'santri_putra' ? 'selected' : '' }}>
                                    👦 Santri Putra - Siswa pria
                                </option>
                                <option value="santri_putri" {{ old('role') == 'santri_putri' ? 'selected' : '' }}>
                                    👧 Santri Putri - Siswa wanita
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Class ID -->
                        <div class="mb-4">
                            <label for="class_id" class="form-label fw-semibold">
                                <i class="fas fa-school text-primary me-2"></i>Kelas (Opsional)
                            </label>
                            <input type="text" 
                                   name="class_id" 
                                   id="class_id" 
                                   value="{{ old('class_id') }}"
                                   class="form-control form-control-lg @error('class_id') is-invalid @enderror"
                                   placeholder="Contoh: Kelas A, 7B, Tahfidz 1, dsb">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Opsional - Kosongkan jika tidak memiliki kelas
                            </small>
                            @error('class_id')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-user-plus me-2"></i>Buat Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <h6 class="card-title fw-bold mb-3">
                        <i class="fas fa-lightbulb text-warning me-2"></i>Informasi Penting
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Password:</strong> Minimal 6 karakter untuk keamanan
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Email:</strong> Harus unik dan valid untuk login
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Role:</strong> Menentukan akses dan fitur yang tersedia
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Kelas:</strong> Opsional, berguna untuk pengelompokan santri
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.form-control:focus,
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-control-lg {
    padding: 0.75rem 1rem;
    font-size: 1rem;
}

.icon-circle {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    transition: all 0.3s ease;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.input-group-text {
    border-right: 0;
}

.input-group .form-control {
    border-left: 0;
    border-right: 0;
}

.input-group:focus-within .input-group-text,
.input-group:focus-within .btn-outline-secondary {
    border-color: #667eea;
}

#passwordStrength,
#passwordMatch {
    font-size: 0.875rem;
    margin-top: 0.25rem;
    min-height: 20px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');
    const togglePassword = document.getElementById('togglePassword');
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const form = document.getElementById('createUserForm');

    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    togglePasswordConfirm.addEventListener('click', function() {
        const type = confirmPasswordField.type === 'password' ? 'text' : 'password';
        confirmPasswordField.type = type;
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    // Password strength indicator
    passwordField.addEventListener('input', function() {
        const strength = this.value.length;
        const strengthDiv = document.getElementById('passwordStrength');
        let message = '';
        let badgeClass = '';

        if (strength === 0) {
            strengthDiv.innerHTML = '';
        } else if (strength < 6) {
            message = 'Lemah - Minimal 6 karakter';
            badgeClass = 'bg-danger';
        } else if (strength < 10) {
            message = 'Sedang - Tambahkan lebih banyak karakter';
            badgeClass = 'bg-warning';
        } else {
            message = 'Kuat - Password aman';
            badgeClass = 'bg-success';
        }

        if (message) {
            strengthDiv.innerHTML = `<span class="badge ${badgeClass} mt-1"><i class="fas fa-shield-alt me-1"></i>${message}</span>`;
        }

        // Check if passwords match when typing in password field
        if (confirmPasswordField.value) {
            checkPasswordMatch();
        }
    });

    // Password match indicator
    confirmPasswordField.addEventListener('input', checkPasswordMatch);

    function checkPasswordMatch() {
        const matchDiv = document.getElementById('passwordMatch');
        
        if (confirmPasswordField.value === '') {
            matchDiv.innerHTML = '';
            return;
        }

        if (passwordField.value === confirmPasswordField.value) {
            matchDiv.innerHTML = '<span class="badge bg-success mt-1"><i class="fas fa-check me-1"></i>Password cocok</span>';
        } else {
            matchDiv.innerHTML = '<span class="badge bg-danger mt-1"><i class="fas fa-times me-1"></i>Password tidak cocok</span>';
        }
    }

    // Form validation
    form.addEventListener('submit', function(e) {
        if (passwordField.value !== confirmPasswordField.value) {
            e.preventDefault();
            alert('⚠️ Password dan konfirmasi password tidak cocok!\nSilakan periksa kembali.');
            confirmPasswordField.focus();
        }
    });
});
</script>
@endsection