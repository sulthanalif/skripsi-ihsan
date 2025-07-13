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
                    {{-- Static field for Document Title (Optional, or can be part of FormField) --}}
                    {{-- <div class="form-group">
                        <label for="document_title">Document Title <span class="text-danger">*</span></label>
                        <input type="text" name="document_title" id="document_title" class="form-control @error('document_title') is-invalid @enderror" value="{{ old('document_title') }}" required>
                        @error('document_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <div class="form-group">
                        <label for="user_id">Atas Nama <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-control user_id @error('user_id') is-invalid @enderror" data-selectjs="true" data-placeholder="Pilih Warga" required>
                            <option value="" selected disabled>Pilih Warga</option>
                            {{-- <option value="{{ Auth::user()->id }}" data-url="{{ route('document.generated.getUserApprovals', Auth::user()->id) }}">Saya ({{ Auth::user()->name }})</option> --}}
                            @foreach ($users as $e)
                                <option data-url="{{ route('document.generated.getUserApprovals', $e->id) }}" @selected(old('user_id') == $e->id) value="{{ $e->id }}">{{$e->profile->nik .' - '. $e->name }}</option>
                            @endforeach
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
        $('#user_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var approvalsDiv = $('#approvals');

            var url = selectedOption.data('url');
            var approvalAList = $('#approval_1');
            approvalAList.empty();
            approvalAList.append('<option value="" selected disabled>Pilih Approval 1</option>');
            var approvalBList = $('#approval_2');
            approvalBList.empty();
            approvalBList.append('<option value="" selected disabled>Pilih Approval 1</option>');

            if (url) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        if (response.status) {
                            var employees = response.data; // Ini seharusnya array objek user
                            // console.log('Fetched employees for approval_1:', employees); // Log user yang diambil

                            if (employees && Array.isArray(employees) && employees.length > 0) {
                                approvalsDiv.css('display', 'block');
                                employees.forEach(employee => {
                                    // Pastikan user memiliki id dan name
                                    if(employee && typeof employee.user.id !== 'undefined' && typeof employee.user.name !== 'undefined') {
                                        approvalAList.append(`<option value="${employee.user.id}">${employee.user.name} - ${employee.position.name}</option>`);
                                        approvalBList.append(`<option value="${employee.user.id}">${employee.user.name} - ${employee.position.name}</option>`);
                                    } else {
                                        console.warn('Invalid user object received:', employee.user);
                                    }
                                });
                            } else {
                                console.log('No users found for approval_1 or data is empty/invalid.');
                            }
                            // Beritahu plugin select (misalnya Select2) untuk memperbarui dirinya sendiri
                            approvalAList.trigger('change');
                            approvalBList.trigger('change');
                        } else { // response.status bernilai false
                            console.error('Server merespons dengan error untuk approval_1:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            } else {
                console.error('URL not found');
            }
        });
    })
</script>
@endpush
