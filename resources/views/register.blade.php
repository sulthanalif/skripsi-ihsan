<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ env('APP_NAME', 'Laravel') }}</title>

    <link href="{{ asset('assets') }}/img/logo.png" rel="icon">
    <link href="{{ asset('assets') }}/img/logo.png" rel="apple-touch-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
          <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <style>
        .img-logo {
            padding: 0.25rem;
            background-color: transparent;
            border: transparent;
            border-radius: 0.25rem;
            max-width: 80%;
            width: 300px;
            height: auto;
        }

        .register-box {
            /* Hapus width: 800px; agar lebih fleksibel */
            width: auto;
            /* Ini akan diatur oleh max-width */
            max-width: 760px;
            /* Batasi lebar maksimum untuk desktop, sesuaikan jika perlu */
            margin: 1rem auto;
            /* Beri margin atas/bawah dan tengah secara otomatis */
        }

        .register-card-body {
            padding: 1.25rem;
            /* Padding standar AdminLTE */
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            /* Pastikan kolom wrap ke baris baru */
            gap: 1rem;
            /* Jarak antar kolom dan baris */
        }

        .form-group {
            flex: 1 1 48%;
            /* Untuk 2 kolom di layar lebar (kurang dari 50% dikurangi gap) */
        }

        .form-group.full {
            flex: 1 1 100%;
            /* Untuk 1 kolom penuh */
        }

        /* Responsivitas untuk layar kecil (mobile) */
        @media (max-width: 768px) {
            .register-box {
                width: 90%;
                /* Ambil 90% lebar layar di mobile */
                margin: 0.5rem auto;
                /* Margin lebih kecil di mobile */
            }

            .form-group {
                flex: 1 1 100%;
                /* Di mobile, semua kolom jadi 100% lebar */
                margin-bottom: 1rem;
                /* Tambahkan margin bawah untuk setiap form-group */
            }

            .form-row {
                gap: 0;
                /* Hapus gap di mobile jika semua jadi 100% */
            }
        }
    </style>
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <div class="login-logo">
            <img src="{{ asset('assets') }}/img/logo.png" alt="" class="img-logo">
        </div>

        <div class="card card-outline card-primary">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Daftar Akun Baru</p>

                <form method="POST" action="{{ route('auth.register') }}">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nik">NIK <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="nik" id="nik"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    value="{{ old('nik') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-id-card"></span>
                                    </div>
                                </div>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="kk">Nomor KK <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="kk" id="kk"
                                    class="form-control @error('kk') is-invalid @enderror" value="{{ old('kk') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-address-book"></span>
                                    </div>
                                </div>
                                @error('kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="birth_place">Tempat Lahir <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="birth_place" id="birth_place"
                                    class="form-control @error('birth_place') is-invalid @enderror"
                                    value="{{ old('birth_place') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-map-marker-alt"></span>
                                    </div>
                                </div>
                                @error('birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="birth_date">Tanggal Lahir <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="date" name="birth_date" id="birth_date"
                                    class="form-control @error('birth_date') is-invalid @enderror"
                                    value="{{ old('birth_date') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-calendar-alt"></span>
                                    </div>
                                </div>
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="gender" id="gender"
                                    class="form-control @error('gender') is-invalid @enderror" data-selectjs="true"
                                    data-placeholder="Pilih Jenis Kelamin">
                                    <option disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" @selected(old('gender') == 'Laki-laki')>Laki-laki</option>
                                    <option value="Perempuan" @selected(old('gender') == 'Perempuan')>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="nationality">Kewarganegaraan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="nationality" id="nationality"
                                    class="form-control @error('nationality') is-invalid @enderror"
                                    value="{{ old('nationality') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-globe"></span>
                                    </div>
                                </div>
                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="religion">Agama <span class="text-danger">*</span></label>
                            <select name="religion" id="religion"
                                class="form-control @error('religion') is-invalid @enderror" data-selectjs="true"
                                data-placeholder="Pilih Agama">
                                <option disabled selected>Pilih Agama</option>
                                <option value="Islam" @selected(old('religion') == 'Islam')>Islam</option>
                                <option value="Kristen Protestan" @selected(old('religion') == 'Kristen Protestan')>Kristen Protestan
                                </option>
                                <option value="Kristen Katolik" @selected(old('religion') == 'Kristen Katolik')>Kristen Katolik
                                </option>
                                <option value="Hindu" @selected(old('religion') == 'Hindu')>Hindu</option>
                                <option value="Budha" @selected(old('religion') == 'Budha')>Budha</option>
                                <option value="Konghucu" @selected(old('religion') == 'Konghucu')>Konghucu</option>
                            </select>
                            @error('religion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="marital_status">Status Perkawinan <span class="text-danger">*</span></label>
                            <select name="marital_status" id="marital_status"
                                class="form-control @error('marital_status') is-invalid @enderror" data-selectjs="true"
                                data-placeholder="Pilih Status Perkawinan">
                                <option disabled selected>Pilih Status Perkawinan</option>
                                <option value="Menikah" @selected(old('marital_status') == 'Menikah')>Menikah</option>
                                <option value="Belum Menikah" @selected(old('marital_status') == 'Belum Menikah')>Belum Menikah</option>
                                <option value="Janda" @selected(old('marital_status') == 'Janda')>Janda</option>
                                <option value="Duda" @selected(old('marital_status') == 'Duda')>Duda</option>
                            </select>
                            @error('marital_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="occupation">Pekerjaan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="occupation" id="occupation"
                                    class="form-control @error('occupation') is-invalid @enderror"
                                    value="{{ old('occupation') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-briefcase"></span>
                                    </div>
                                </div>
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group full">
                            <label for="address_ktp">Alamat (Sesuai KTP) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <textarea name="address_ktp" id="address_ktp" class="form-control @error('address_ktp') is-invalid @enderror">{{ old('address_ktp') }}</textarea>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-map-marked-alt"></span>
                                    </div>
                                </div>
                                @error('address_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address_domisili">Alamat Domisili <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <textarea name="address_domisili" id="address_domisili"
                                    class="form-control @error('address_domisili') is-invalid @enderror">{{ old('address_domisili') }}</textarea>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-home"></span>
                                    </div>
                                </div>
                                @error('address_domisili')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input type="text" name="username" id="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Kata Sandi <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span toggle="#password" class="fa fa-eye-slash field_icon toggle-password"
                                            role="button"></span>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Kata Sandi <span
                                    class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span toggle="#password_confirmation"
                                            class="fa fa-eye-slash field_icon toggle-password" role="button"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>

            <div class="row">
                <div class="col-12 px-4 mt-3">
                    <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                </div>
            </div>

            <p class="mt-3 text-center">
                <a href="{{ route('login') }}">Sudah punya akun? Masuk</a>
            </p>
            </form>
        </div>
    </div>
    </div>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <script>
        $('.is_select2').select2();
        $('*select[data-selectjs="true"]').select2({
            width: '100%',
        });
        $('*select[data-selectTagjs="true"]').select2({
            width: '100%',
            tags: true
        });

        $("body").on('click', '.toggle-password', function() {
            // Toggle class pada ikon mata
            $(this).toggleClass("fa-eye fa-eye-slash");

            // Dapatkan id input password dari atribut toggle
            const targetId = $(this).attr('toggle');
            const input = $(targetId);

            // Ubah tipe input antara 'password' dan 'text'
            input.attr("type", input.attr("type") === "password" ? "text" : "password");
        });

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        @if (Session::has('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ Session::get('success') }}'
            })
        @endif

        @if (Session::has('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ Session::get('error') }}'
            })
        @endif

        @if (Session::has('warning'))
            Toast.fire({
                icon: 'warning',
                title: '{{ Session::get('warning') }}'
            })
        @endif
    </script>
</body>

</html>
