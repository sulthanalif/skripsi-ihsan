@extends('layouts.main')
@section('title', 'Document Fields')

@section('content')
    <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $document_type->name }} Fields</h1>
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
                                        {{-- <div class="mt-2">
                                            <button id="btn-import" class="btn btn-success float-left"><i class="nav-icon fa fa-upload"></i> Import Template</button>
                                            @if ($document_type->template_file_path && Illuminate\Support\Facades\Storage::disk('public')->exists($document_type->template_file_path))
                                            <a class="btn btn-success float-left ml-2" href="{{ Illuminate\Support\Facades\Storage::url($document_type->template_file_path) }}" download="{{ $document_type->name }}_template.docx"><i class="nav-icon fa fa-download"></i> Export Template</a>
                                            @endif
                                        </div> --}}
                                </div>
                            </div>
                            <div class="col-md-8">

                                    <button class="btn btn-danger float-right" ><i class="nav-icon fa fa-arrow-left"></i>  <a href="{{ route('document.type.index') }}" class="text-white">Back</a></button>
                                    <button class="btn btn-primary float-right mr-2" id="btn-create"><i class="nav-icon fa fa-plus"></i>  Tambah Field</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="data-table" data-order='[[ 4, "asc" ]]' width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Label</th>
                                        <th>Type Data</th>
                                        <th>Is Required</th>
                                        <th>Petunjuk</th>
                                        <th>Order</th>
                                        {{-- <th>Deskripsi</th> --}}
                                        <th class="text-center" style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($document_type->formFields as $field)
                                    <tr>
                                        <td>{{ $field->field_name }}</td>
                                        <td>{{ $field->field_label }}</td>
                                        <td>{{ $field->field_type }}</td>
                                        <td>{{ $field->is_required ? 'Ya' : 'Tidak' }}</td>
                                        <td>{{ $field->hint ? $field->hint : '-' }}</td>
                                        <td>{{ $field->order }}</td>
                                        <td class="text-center text-nowrap">

                                            <a href="#" class="edit" id="btn-edit" data-url="{{ route('document.field.update', ['document_type' => $document_type->id, 'form_field' => $field->id]) }}" data-id="{{ $document_type->id }}" data-get="{{ route('document.field.show', $field->id) }}">
                                                <i class="fa fa-pen mr-3 text-dark"></i>
                                            </a>

                                                <a href="#" id="btn-destroy" data-id="{{ $field->id }}" data-url="{{ route('document.field.destroy', ['document_type' => $document_type->id, 'form_field' => $field->id]) }}"><i class="fa fa-trash text-red"></i></a>

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

@include('back-end.document.type.create-field')
@include('back-end.document.type.edit-field')
{{-- @include('back-end.document.type.import-template') --}}
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // --- Selectors for Create Modal ---
        const modalCreate = $('#modal-create');
        const formCreate = modalCreate.find('form');
        const fieldTypeCreateSelect = $('#field_type'); // In create-field.blade.php
        const fieldOptionsCreateWrapper = $('#field_options_wrapper'); // In create-field.blade.php
        const fieldCheckboxOptionsCreateWrapper = $('#field_checkbox_options_wrapper'); // In create-field.blade.php
        const fieldOptionsCreateInput = $('#field_options'); // In create-field.blade.php
        const fieldCheckboxOptionsCreateInput = $('#field_checkbox_options'); // In create-field.blade.php

        // --- Selectors for Edit Modal (assuming it's the complex one like document/field/edit.blade.php) ---
        const modalEdit = $('#modal-edit-field'); // Assumes you use modal-edit-field for the complex edit
        const formEdit = $('#form-edit-field');    // Assumes you use form-edit-field
        const fieldTypeEditSelect = $('#field_type_edit');
        const fieldOptionsEditInput = $('#field_options_edit');
        const fieldCheckboxOptionsEditInput = $('#field_checkbox_options_edit');

        // Function to toggle visibility for Create Modal fields
        function updateCreateFormFieldVisibility() {
            const selectedType = fieldTypeCreateSelect.val();
            if (selectedType === 'select' || selectedType === 'radio') {
                fieldOptionsCreateWrapper.show();
                fieldCheckboxOptionsCreateWrapper.hide();
                fieldCheckboxOptionsCreateInput.val('');
            } else if (selectedType === 'checkbox') { // Value from create-field.blade.php for checkbox group
                fieldCheckboxOptionsCreateWrapper.show();
                fieldOptionsCreateWrapper.hide();
                fieldOptionsCreateInput.val('');
            } else {
                fieldOptionsCreateWrapper.hide();
                fieldCheckboxOptionsCreateWrapper.hide();
                fieldOptionsCreateInput.val('');
                fieldCheckboxOptionsCreateInput.val('');
            }
        }

        // Function to toggle visibility for Edit Modal fields
        function updateEditFormFieldVisibility() {
            const selectedType = fieldTypeEditSelect.val();
            const fieldOptionsEditContainer = fieldOptionsEditInput.closest('.form-group');
            const fieldCheckboxOptionsEditContainer = fieldCheckboxOptionsEditInput.closest('.form-group');

            if (selectedType === 'select' || selectedType === 'radio') {
                fieldOptionsEditContainer.show();
                fieldCheckboxOptionsEditContainer.hide();
                fieldCheckboxOptionsEditInput.val(''); // Optionally clear
            } else if (selectedType === 'checkbox') { // Value for Checkbox Group
                fieldCheckboxOptionsEditContainer.show();
                fieldOptionsEditContainer.hide();
                fieldOptionsEditInput.val(''); // Optionally clear
            } else {
                fieldOptionsEditContainer.hide();
                fieldCheckboxOptionsEditContainer.hide();
                fieldOptionsEditInput.val('');
                fieldCheckboxOptionsEditInput.val('');
            }
        }

        // Initial hide for conditional fields in Create Modal
        if (fieldOptionsCreateWrapper.length) fieldOptionsCreateWrapper.hide();
        if (fieldCheckboxOptionsCreateWrapper.length) fieldCheckboxOptionsCreateWrapper.hide();

        // Event listener for Create Modal's field_type change
        if (fieldTypeCreateSelect.length) {
            fieldTypeCreateSelect.on('change', updateCreateFormFieldVisibility);
        }

        // Event listener for Edit Modal's field_type change
        if (fieldTypeEditSelect.length) {
            fieldTypeEditSelect.on('change', updateEditFormFieldVisibility);
        }

        $('#btn-import').click(function() {
            $('#modal-import-template').modal('show');
        });

        $('#btn-create').click(function() {
            formCreate[0].reset(); // Reset the form
            fieldTypeCreateSelect.val(fieldTypeCreateSelect.find('option[selected][disabled]').val() || '').trigger('change'); // Reset select and trigger change
            // Ensure other fields are cleared as needed, e.g., $('#field_name').val('');
            updateCreateFormFieldVisibility(); // Update visibility based on reset/default field_type
            modalCreate.modal('show');
        });

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
                            // console.log(xhr.responseText);

                            Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus data. Silakan coba lagi.", "error").then(function(){
                                location.reload();
                            });
                        }
                    });
                }
            });
        });

        $('#data-table tbody').on('click', '#btn-edit', function () {
            // var id = $(this).data('id'); // This was document_type_id, field_id is in the route
            var url = $(this).data('url');
            var url_hit = $(this).data('get');

            // Reset edit form before populating
            if (formEdit.length) formEdit[0].reset();

            $.ajax({
                url: url_hit,
                type: 'GET',
            })
            .done(function (response) {
                if(response && response.status){
                    // Populate fields from document/field/edit.blade.php
                    $('#field_name_edit').val(response.data.field_name);
                    $('#field_label_edit').val(response.data.field_label);
                    $('#order_edit').val(response.data.order);
                    $('#hint_edit').val(response.data.hint);

                    fieldTypeEditSelect.val(response.data.field_type).trigger('change');

                    fieldOptionsEditInput.val(response.data.field_options || '');
                    fieldCheckboxOptionsEditInput.val(response.data.field_checkbox_options || '');

                    $('#is_required_edit').prop('checked', !!response.data.is_required);
                    // $('#is_header_edit').prop('ch?÷ecked', !!response.data.is_header);
                    formEdit.attr('action', url); // Use formEdit selector

                    updateEditFormFieldVisibility(); // Update visibility after all data is set
                    modalEdit.modal('show'); // Use modalEdit selector for the complex modal
                } else {
                    console.error("Gagal memuat data atau format respons tidak valid:", response);
                    Swal.fire("Gagal!", "Tidak dapat memuat data pengguna untuk diedit.", "error");
                }
            })
            .fail(function () {
                console.log("error");
                Swal.fire("Gagal!", "Terjadi kesalahan saat mengambil data field.", "error");
            });
        });

    });
</script>
@endpush
