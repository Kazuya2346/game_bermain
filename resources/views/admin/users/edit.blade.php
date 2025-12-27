@extends('layouts.admin')

@section('title', 'Edit Semua User')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                <i class="fas fa-users-cog text-primary me-2"></i>Edit Semua User Sekaligus
            </h1>
            <p class="text-muted small mb-0">Edit data user yang diperlukan, lalu klik tombol "Update Semua" di bawah</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error!</strong> Terdapat kesalahan pada form:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Card -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-white bg-opacity-25 rounded-circle p-3 me-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold">{{ $users->count() }}</h3>
                            <small class="opacity-75">Total User</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-white bg-opacity-25 rounded-circle p-3 me-3">
                            <i class="fas fa-edit fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold" id="editedCount">0</h3>
                            <small class="opacity-75">User Diubah</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-white bg-opacity-25 rounded-circle p-3 me-3">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Bulk Edit</h5>
                            <small class="opacity-75">Mode Aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Alert -->
    <div class="alert alert-info border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="fas fa-info-circle fa-2x me-3 mt-1"></i>
            <div>
                <h6 class="alert-heading fw-bold mb-2">💡 Tips Penggunaan:</h6>
                <ul class="mb-0">
                    <li>Edit field yang ingin Anda ubah pada setiap user</li>
                    <li>Kosongkan password jika tidak ingin mengubahnya</li>
                    <li>Gunakan checkbox "Ubah Password" untuk mengaktifkan edit password</li>
                    <li>Klik tombol <strong>"Update Semua User"</strong> di bawah untuk menyimpan perubahan</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bulk Edit Form -->
    <form action="{{ route('admin.users.bulk.update') }}" method="POST" id="bulkEditForm">
        @csrf
        @method('PUT')

        <div class="row">
            @foreach($users as $index => $user)
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100 user-card" data-user-id="{{ $user->id }}">
                    <!-- Card Header -->
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-white text-primary font-weight-bold" 
                                        style="width: 45px; height: 45px; font-size: 1.3rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">User #{{ $index + 1 }}</h6>
                                    <small class="opacity-75">ID: {{ $user->id }}</small>
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input edit-toggle" 
                                       type="checkbox" 
                                       id="toggle_{{ $user->id }}"
                                       data-user-id="{{ $user->id }}"
                                       checked>
                                <label class="form-check-label text-white small" for="toggle_{{ $user->id }}">
                                    Edit
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <input type="hidden" name="users[{{ $index }}][id]" value="{{ $user->id }}">

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                <i class="fas fa-user text-primary me-1"></i>Nama Lengkap
                            </label>
                            <input type="text" 
                                   name="users[{{ $index }}][name]" 
                                   value="{{ old('users.'.$index.'.name', $user->name) }}"
                                   class="form-control user-field"
                                   placeholder="Nama lengkap"
                                   required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                <i class="fas fa-envelope text-primary me-1"></i>Email
                            </label>
                            <input type="email" 
                                   name="users[{{ $index }}][email]" 
                                   value="{{ old('users.'.$index.'.email', $user->email) }}"
                                   class="form-control user-field"
                                   placeholder="email@example.com"
                                   required>
                        </div>

                        <!-- Password Toggle -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input password-toggle" 
                                       type="checkbox" 
                                       id="password_toggle_{{ $user->id }}"
                                       data-user-id="{{ $user->id }}">
                                <label class="form-check-label small" for="password_toggle_{{ $user->id }}">
                                    <i class="fas fa-lock me-1"></i>Ubah Password
                                </label>
                            </div>
                        </div>

                        <!-- Password Fields (Initially Hidden) -->
                        <div class="password-fields" id="password_fields_{{ $user->id }}" style="display: none;">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Password Baru</label>
                                    <input type="password" 
                                           name="users[{{ $index }}][password]" 
                                           class="form-control form-control-sm"
                                           placeholder="Min. 8 karakter">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Konfirmasi</label>
                                    <input type="password" 
                                           name="users[{{ $index }}][password_confirmation]" 
                                           class="form-control form-control-sm"
                                           placeholder="Ulangi password">
                                </div>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                <i class="fas fa-user-tag text-primary me-1"></i>Role
                            </label>
                            <select name="users[{{ $index }}][role]" 
                                    class="form-select form-select-sm user-field"
                                    required>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>🛠️ Admin</option>
                                <option value="ustadz" {{ $user->role == 'ustadz' ? 'selected' : '' }}>👨‍🏫 Ustadz</option>
                                <option value="ustadzah" {{ $user->role == 'ustadzah' ? 'selected' : '' }}>👩‍🏫 Ustadzah</option>
                                <option value="santri_putra" {{ $user->role == 'santri_putra' ? 'selected' : '' }}>👦 Santri Putra</option>
                                <option value="santri_putri" {{ $user->role == 'santri_putri' ? 'selected' : '' }}>👧 Santri Putri</option>
                            </select>
                        </div>

                        <!-- Class ID -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                <i class="fas fa-school text-primary me-1"></i>Kelas (Opsional)
                            </label>
                            <input type="text" 
                                   name="users[{{ $index }}][class_id]" 
                                   value="{{ old('users.'.$index.'.class_id', $user->class_id) }}"
                                   class="form-control form-control-sm user-field"
                                   placeholder="Contoh: 7A, Kelas B">
                        </div>

                        <!-- Info -->
                        <div class="mt-3 pt-3 border-top">
                            <div class="row text-muted small">
                                <div class="col-6">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $user->created_at->format('d M Y') }}
                                </div>
                                <div class="col-6 text-end">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $user->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-secondary">User ID: {{ $user->id }}</span>
                            <span class="text-muted small">
                                <i class="fas fa-info-circle me-1"></i>Edit enabled
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Sticky Bottom Action Bar -->
        <div class="sticky-bottom-bar bg-white border-top shadow-lg p-4">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 fw-bold">
                            <i class="fas fa-save text-primary me-2"></i>Siap untuk Update?
                        </h5>
                        <p class="text-muted small mb-0">
                            <span id="editedCountText">0</span> user akan diupdate
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                            <i class="fas fa-check-double me-2"></i>Update Semua User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
/* Gradients */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #5cb85c 0%, #4cae4c 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #5bc0de 0%, #31b0d5 100%);
}

/* Card Effects */
.user-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.user-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    border-color: #667eea;
}

.user-card.edited {
    border-color: #5cb85c;
    background: linear-gradient(to right, #f0fff4, #ffffff);
}

/* Form Controls */
.form-control:focus,
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Icon Box */
.icon-box {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Sticky Bottom Bar */
.sticky-bottom-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Button Hover Effects */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Avatar Circle */
.avatar-circle {
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

/* Form Switch Custom Style */
.form-check-input:checked {
    background-color: #5cb85c;
    border-color: #5cb85c;
}

/* Smooth Transitions */
* {
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

/* Password Fields Animation */
.password-fields {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        max-height: 0;
    }
    to {
        opacity: 1;
        max-height: 200px;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .sticky-bottom-bar {
        padding: 1rem;
    }
    
    .sticky-bottom-bar h5 {
        font-size: 1rem;
    }
    
    .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let editedCount = 0;

    // Track changes on form fields
    const userFields = document.querySelectorAll('.user-field');
    userFields.forEach(field => {
        const originalValue = field.value;
        field.addEventListener('change', function() {
            const card = this.closest('.user-card');
            if (this.value !== originalValue) {
                card.classList.add('edited');
                updateEditedCount();
            }
        });
    });

    // Password toggle functionality
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const userId = this.dataset.userId;
            const passwordFields = document.getElementById('password_fields_' + userId);
            if (this.checked) {
                passwordFields.style.display = 'block';
            } else {
                passwordFields.style.display = 'none';
                // Clear password fields when hidden
                passwordFields.querySelectorAll('input').forEach(input => input.value = '');
            }
        });
    });

    // Edit toggle functionality
    const editToggles = document.querySelectorAll('.edit-toggle');
    editToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const card = this.closest('.user-card');
            const fields = card.querySelectorAll('input, select');
            
            if (this.checked) {
                fields.forEach(field => {
                    if (!field.classList.contains('edit-toggle')) {
                        field.disabled = false;
                    }
                });
                card.style.opacity = '1';
            } else {
                fields.forEach(field => {
                    if (!field.classList.contains('edit-toggle')) {
                        field.disabled = true;
                    }
                });
                card.style.opacity = '0.6';
            }
            updateEditedCount();
        });
    });

    // Update edited count
    function updateEditedCount() {
        const enabledCards = document.querySelectorAll('.edit-toggle:checked').length;
        document.getElementById('editedCount').textContent = enabledCards;
        document.getElementById('editedCountText').textContent = enabledCards;
    }

    // Initial count
    updateEditedCount();

    // Form submission confirmation
    const form = document.getElementById('bulkEditForm');
    form.addEventListener('submit', function(e) {
        const enabledCount = document.querySelectorAll('.edit-toggle:checked').length;
        
        if (enabledCount === 0) {
            e.preventDefault();
            alert('⚠️ Tidak ada user yang akan diupdate. Aktifkan toggle "Edit" untuk user yang ingin diubah.');
            return;
        }

        if (!confirm(`✅ Anda akan mengupdate ${enabledCount} user. Lanjutkan?`)) {
            e.preventDefault();
        }
    });

    // Smooth scroll to top when clicking submit
    document.getElementById('submitBtn').addEventListener('click', function(e) {
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            e.preventDefault();
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
});
</script>
@endsection