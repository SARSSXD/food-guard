<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - Food-Guard</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .form-check-input {
            display: inline-block !important;
            opacity: 1 !important;
            visibility: visible !important;
            width: 16px !important;
            height: 16px !important;
            margin-right: 8px;
            vertical-align: middle;
        }

        .form-check-label {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }
    </style>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller d-flex">
        <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left p-3">
                            <div class="brand-logo">
                                <img src="{{ asset('assets/img/logoFG.jpg') }}" style="width: 70px; border-radius: 15%;"
                                    alt="Food-Guard Logo">
                            </div>
                            <h4>Baru di sini?</h4>
                            <h6 class="font-weight-light">Daftarkan akun Anda untuk mengakses sistem Food-Guard!</h6>
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form class="pt-3" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nama Lengkap</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-account-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg border-left-0"
                                            id="name" name="name" value="{{ old('name') }}"
                                            placeholder="Nama Lengkap" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-email-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="email" class="form-control form-control-lg border-left-0"
                                            id="email" name="email" value="{{ old('email') }}"
                                            placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-lock-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control form-control-lg border-left-0"
                                            id="password" name="password" placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-lock-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control form-control-lg border-left-0"
                                            id="password_confirmation" name="password_confirmation"
                                            placeholder="Konfirmasi Password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select class="form-control form-control-lg" id="role" name="role" required>
                                        <option value="" disabled {{ old('role') == '' ? 'selected' : '' }}>--
                                            Pilih Peran --</option>
                                        <option value="nasional" {{ old('role') == 'nasional' ? 'selected' : '' }}>
                                            Admin
                                            Nasional</option>
                                        <option value="daerah" {{ old('role') == 'daerah' ? 'selected' : '' }}>Admin
                                            Daerah</option>
                                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pengguna
                                            Umum</option>
                                    </select>
                                </div>
                                <div class="form-group" id="region-group"
                                    style="display: {{ old('role') == 'daerah' ? 'block' : 'none' }};">
                                    <label for="id_region">Region</label>
                                    <select class="form-control form-control-lg" id="id_region" name="id_region"
                                        {{ old('role') == 'daerah' ? 'required' : '' }}>
                                        <option value="" disabled {{ old('id_region') == '' ? 'selected' : '' }}>
                                            -- Pilih Region --</option>
                                        @foreach ($wilayah as $region)
                                            <option value="{{ $region->id }}"
                                                {{ old('id_region') == $region->id ? 'selected' : '' }}>
                                                {{ $region->provinsi }} - {{ $region->kota }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" name="terms" class="form-check-input" required>
                                            Saya setuju dengan <a href="#" class="text-primary">Syarat &
                                                Ketentuan</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">DAFTAR</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 register-half-bg d-none d-lg-flex flex-row">
                        <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright © 2025
                            Food-Guard. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const regionGroup = document.getElementById('region-group');
            const regionSelect = document.getElementById('id_region');

            function toggleRegionField() {
                if (roleSelect.value === 'daerah') {
                    regionGroup.style.display = 'block';
                    regionSelect.required = true;
                } else {
                    regionGroup.style.display = 'none';
                    regionSelect.required = false;
                }
            }

            toggleRegionField();

            roleSelect.addEventListener('change', toggleRegionField);
        });
    </script>
</body>

</html>
