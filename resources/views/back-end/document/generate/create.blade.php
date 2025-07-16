@extends('layouts.main')
@section('title', 'Generate Document: ' . $documentType->name)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Generate Document: {{ $documentType->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    {{-- Add breadcrumb for document type index if you have one --}}
                    <li class="breadcrumb-item active">Generate Document</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Fill in the details for {{ $documentType->name }}</h3>
            </div>
            {{-- Form action should point to your store method for generated documents --}}
            <form action="{{ route('document.generated.store', $documentType->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="sebagai">Sebagai <span class="text-danger">*</span></label>
                            {{-- {{auth()->user()->roles->first()}} --}}

                            <select name="sebagai" id="sebagai" class="form-control sebagai @error('sebagai') is-invalid @enderror" data-selectjs="true" data-placeholder="Pilih Sebagai..." required>
                                <option value="" selected disabled>Pilih Sebagai...</option>
                                <option value="pengaju" >Pengaju</option>
                                <option value="wali" >Wali</option>
                            </select>

                        @error('sebagai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="user_id_pengaju" class="form-group" style="display: none;">>

                    </div>

                    <div class="form-group" id="user_id_wali" style="display: none;">
                        <label for="user_id">Pilih Pengaju <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" data-selectjs="true" data-placeholder="Pilih Pengaju" required>
                            {{-- Add options for approval 1 --}}
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <hr>

                    @foreach ($documentType->formFields()->orderBy('order')->get() as $field)
                        @if ($field->field_name === 'kejadian_ke')
                            <input type="hidden" name="fields[{{ $field->id }}]" id="field_{{ $field->id }}" value="1">
                        @elseif (!$field->is_header)
                            <div class="form-group">
                                <label for="field_{{ $field->id }}">{{ $field->field_label }} @if($field->is_required)<span class="text-danger">*</span>@endif</label>

                                @switch($field->field_type)
                                    @case('text')
                                    @case('number')
                                    @case('date')
                                        <input type="{{ $field->field_type }}" name="fields[{{ $field->id }}]" id="field_{{ $field->id }}" class="form-control @error('fields.'.$field->id) is-invalid @enderror" value="{{ old('fields.'.$field->id) }}" {{ $field->is_required ? 'required' : '' }}>
                                        @break

                                    @case('textarea')
                                        <textarea name="fields[{{ $field->id }}]" id="field_{{ $field->id }}" class="form-control @error('fields.'.$field->id) is-invalid @enderror" rows="3" {{ $field->is_required ? 'required' : '' }}>{{ old('fields.'.$field->id) }}</textarea>
                                        @break

                                    @case('select')
                                        <select name="fields[{{ $field->id }}]" data-selectjs="true" placeholder="Select {{ $field->field_label }}" id="field_{{ $field->id }}" class="form-control @error('fields.'.$field->id) is-invalid @enderror" {{ $field->is_required ? 'required' : '' }}>
                                            <option value="" selected disabled>Select {{ $field->field_label }}</option>
                                            @foreach (explode(", ", $field->field_options) as $option)
                                                @php
                                                    $optionParts = explode(':', trim($option), 2);
                                                    $value = trim($optionParts[0]);
                                                    $label = isset($optionParts[1]) ? trim($optionParts[1]) : $value;
                                                @endphp
                                                <option value="{{ $value }}" {{ old('fields.'.$field->id) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @break

                                    @case('checkbox') {{-- Assuming this is for a group of checkboxes --}}
                                        @foreach (explode(", ", $field->field_checkbox_options) as $index => $option)
                                            @php
                                                $optionParts = explode(':', trim($option), 2);
                                                $value = trim($optionParts[0]);
                                                $label = isset($optionParts[1]) ? trim($optionParts[1]) : $value;
                                            @endphp
                                            <div class="form-check">
                                                <input class="form-check-input @error('fields.'.$field->id.'.'.$value) is-invalid @enderror" type="checkbox" name="fields[{{ $field->id }}][{{ $value }}]" id="field_{{ $field->id }}_{{ $value }}" value="{{ $value }}" {{ (is_array(old('fields.'.$field->id)) && array_key_exists($value, old('fields.'.$field->id))) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="field_{{ $field->id }}_{{ $value }}">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                        @break

                                    @case('file')
                                        <input type="file" name="fields[{{ $field->id }}]" id="field_{{ $field->id }}" class="form-control-file @error('fields.'.$field->id) is-invalid @enderror" {{ $field->is_required ? 'required' : '' }}>
                                        @break
                                @endswitch

                                @error('fields.'.$field->id)
                                    <div class="invalid-feedback d-block">{{ $message }}</div> {{-- d-block for radio/checkbox groups --}}
                                @enderror
                                @if($field->hint)
                                    <div class="form-text text-muted">{{ $field->hint }}</div>
                                @endif
                            </div>
                        @endif
                    @endforeach

                    <p>Note: Fields marked with <span class="text-danger">*</span> are required</p>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit Document</button>
                    {{-- Add a cancel button if needed --}}
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
{{-- Add any specific JS for this form if needed, e.g., for date pickers or select2 --}}
<script>
    $(document).ready(function() {
        // Menggunakan selector ID yang lebih spesifik dan mengambil data-url dari option yang dipilih
        $('#sebagai').on('change', function() {
            const selectedValue = $(this).val();
            var divUserIdPengaju = $('#user_id_pengaju');
            divUserIdPengaju.empty();
            const users = @json($users);
            const authUserId = {{ auth()->id() }};
            const authUserName = '{{ auth()->user()->profile?->nik ?? "" }} - {{ auth()->user()->name }}';

            var userList = $('#user_id');
            var userIdWali = $('#user_id_wali');
            userList.empty();
            userList.append('<option value="" selected disabled>Pilih Pengaju</option>');

            if (selectedValue === 'pengaju') {
                userIdWali.css('display', 'none');
                divUserIdPengaju.css('display', 'block');
                userIdWali.empty();
                divUserIdPengaju.append(`
                    <input type="hidden" name="user_id" value="${authUserId}">
                    <input type="text" class="form-control" value="${authUserName}" readonly>
                `);
            } else if (selectedValue === 'wali') {
                userIdWali.css('display', 'block');
                divUserIdPengaju.css('display', 'none');
                divUserIdPengaju.empty();
                if (users && Array.isArray(users) && users.length > 0) {

                    users.forEach(user => {
                        if(user && typeof user.id !== 'undefined' && typeof user.name !== 'undefined' && user.id !== authUserId) {
                            userList.append(`<option value="${user.id}">${user.profile ? user.profile.nik + ' - ' : ''}${user.name}</option>`);
                        } else if(user && typeof user.id === 'undefined' || typeof user.name === 'undefined') {
                            console.warn('Invalid user object received:', user);
                        }
                    });
                } else {
                    console.log('No users found or data is empty/invalid.');
                }

                // Trigger change event to update select plugin
                userList.find('select').trigger('change');
            } else {
                // userList.empty();
            }


        });

    })
</script>
@endpush
