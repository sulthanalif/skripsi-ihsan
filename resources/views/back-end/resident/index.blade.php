@extends('layouts.main')
@section('title', 'Penduduk')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Penduduk</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    @can('residents-delete')
                                        <div class="mt-2">
                                            <a href="#" class="hidden" id="btn-destroy"><i class="fa fa-trash text-red"></i></a>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                            <div class="col-md-8">
                                @can('resident-create')
                                    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-create"><i class="nav-icon fa fa-plus"></i>  Tambah Penduduk</button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="data-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NIK/KK</th>
                                        <th>Name</th>
                                        <th>TTL</th>
                                        <th>JK</th>
                                        <th>Kewarganegaraan</th>
                                        <th>Agama</th>
                                        <th>Status Perkawinan</th>
                                        <th>Pekerjaan</th>
                                        <th>Alamat KTP</th>
                                        <th class="text-center" style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->profile->nik }}/<br>{{ $user->profile->kk }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->profile->birth_place }}, {{ $user->profile->birth_date }}</td>
                                        <td>{{ $user->profile->gender }}</td>
                                        <td>{{ $user->profile->nationality }}</td>
                                        <td>{{ $user->profile->religion }}</td>
                                        <td>{{ $user->profile->marital_status }}</td>
                                        <td>{{ $user->profile->occupation }}</td>
                                        <td>{{ $user->profile->address_ktp }}</td>
                                        <td class="text-center text-nowrap">
                                            @can('resident-update')
                                            <a href="#" class="edit" id="btn-edit" data-url="{{ route('resident.update', $user->id) }}" data-id="{{ $user->id }}" data-get="{{ route('resident.show', $user->id) }}">
                                                <i class="fa fa-pen mr-3 text-dark"></i>
                                            </a>
                                            @endcan
                                            @can('resident-delete')
                                                <a href="#" id="btn-destroy" data-id="{{ $user->id }}" data-url="{{ route('resident.destroy', $user->id) }}"><i class="fa fa-trash text-red"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('back-end.resident.create')
@include('back-end.resident.edit')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#data-table tbody').on('click', 'a#btn-destroy', function (e) {
            e.preventDefault(); // Mencegah aksi default dari link anchor
            var arrId = $(this).data('id');
            // Pastikan route 'user.destroy' didefinisikan untuk menerima parameter ID.
            // Ganti 'id' dengan nama parameter yang benar jika berbeda (misalnya 'user').
            var url = $(this).data('url');

            Swal.fire({
                title: "Apakah Anda yakin ingin menghapus data ini?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning", // Menggunakan 'icon' bukan 'type' untuk SweetAlert2
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                // closeOnConfirm: false, // Tidak diperlukan untuk SweetAlert2 modern dengan .then()
            }).then((result) => {
                if (result.isConfirmed){
                    $.ajax({
                        url: url, // Menggunakan URL yang sudah dikonstruksi dengan benar
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            // "id": arrId // Mungkin tidak diperlukan jika ID sudah ada di URL dan controller mengambil dari route parameter.
                                         // Jika controller Anda secara spesifik membutuhkan 'id' di body POST, biarkan ini.
                        },
                        success: function (response) {
                            // Server akan melakukan redirect dan menampilkan flash message.
                            // Cukup reload halaman untuk melihat perubahan dan pesan.
                            // Swal di sini bersifat opsional untuk feedback instan sebelum reload.
                            Swal.fire("Terhapus!", "Data berhasil dihapus.", "success").then(function(){
                                location.reload();
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            // Error pada request AJAX (misal server error 500, 403).
                            // Server mungkin juga sudah menyiapkan flash message error saat redirect.
                            console.log(xhr.responseText);

                            Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus data. Silakan coba lagi.", "error").then(function(){
                                location.reload();
                            });
                        }
                    });
                }
            });
        });

        $('#data-table tbody').on('click', '#btn-edit', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            var url_hit = $(this).data('get');
            $.ajax({
                url: url_hit,
                type: 'GET',
            })
            .done(function (response) {
                if(response && response.status){ // Pastikan response dan response.status ada
                    $('#name_edit').val(response.data.name);
                    $('#username_edit').val(response.data.username);
                    $('#email_edit').val(response.data.email);
                    $('#nik_edit').val(response.data.profile.nik);
                    $('#kk_edit').val(response.data.profile.kk);
                    $('#birth_place_edit').val(response.data.profile.birth_place);
                    $('#birth_date_edit').val(response.data.profile.birth_date);
                    $('#gender_edit').val(response.data.profile.gender).trigger('change');
                    $('#nationality_edit').val(response.data.profile.nationality);
                    $('#religion_edit').val(response.data.profile.religion).trigger('change');
                    $('#marital_status_edit').val(response.data.profile.marital_status).trigger('change');
                    $('#occupation_edit').val(response.data.profile.occupation);
                    $('#address_ktp_edit').val(response.data.profile.address_ktp);
                    $('#address_domisili_edit').val(response.data.profile.address_domisili);
                    // $('#password_edit').val(response.data.password);

                    $("#form-edit").attr('action', url);
                    $('#modal-edit').modal('show');
                } else {
                    console.error("Gagal memuat data user atau format respons tidak valid:", response);
                    Swal.fire("Gagal!", "Tidak dapat memuat data pengguna untuk diedit.", "error");
                }
            })
            .fail(function () {
                console.log("error");
            });
        });

    });
</script>
@endpush
