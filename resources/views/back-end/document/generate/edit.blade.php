@extends('layouts.main')
@section('title', 'Edit Document: ' . $document->title)

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Document: {{ $document->title }}</h1>
                <p class="text-muted">Type: {{ $documentType->name }}</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    {{-- Add breadcrumb for document type index or document list if you have one --}}
                    <li class="breadcrumb-item active">Edit Document</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-warning"> {{-- Changed card color for edit --}}
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>
            {{-- Form action should point to your update method for generated documents --}}
            {{-- Assuming you have a route like 'document.generated.update' --}}
            <form action="{{ route('document.generated.update', ['document_type' => $documentType->id, 'document' => $document->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Method spoofing for update --}}
                <div class="card-body">
                    {{-- <div class="form-group">
                        <label for="document_title">Document Title <span class="text-danger">*</span></label>
                        <input type="text" name="document_title" id="document_title" class="form-control @error('document_title') is-invalid @enderror" value="{{ old('document_title', $document->title) }}" required>
                        @error('document_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    {{-- User selection and Approvals --}}
                    <div class="form-group">
                        <label for="user_id">Atas Nama <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-control user_id @error('user_id') is-invalid @enderror" data-selectjs="true" data-placeholder="Pilih Karyawan" required>
                            <option value="" selected disabled>Pilih Karyawan</option>
                            {{-- Option for current authenticated user --}}
                            <option value="{{ Auth::user()->id }}" data-url="{{ route('document.generated.getUserApprovals', Auth::user()->id) }}"
                                @selected(old('user_id', $document->user_id) == Auth::user()->id)>
                                Saya ({{ Auth::user()->name }})
                            </option>
                            @foreach ($employees as $e)
                                <option data-url="{{ route('document.generated.getUserApprovals', $e['id']) }}"
                                    @selected(old('user_id', $document->user_id) == $e['id']) value="{{ $e['id'] }}">
                                    {{$e['nik'] .' - '. $e['name'] .' - '. $e['department'] . ' - ' . $e['position']}}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="approvals" style="display: none;"> {{-- Initially hidden, shown by JS --}}
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="approval_1">Approval 1 <span class="text-danger">*</span></label>
                                <select name="approval_1" id="approval_1" class="form-control @error('approval_1') is-invalid @enderror" data-selectjs="true" data-placeholder="Pilih Approval 1" required></select>
                                @error('approval_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="approval_2">Approval 2</label>
                                <select name="approval_2" id="approval_2" class="form-control @error('approval_2') is-invalid @enderror" data-selectjs="true" data-placeholder="Pilih Approval 2" ></select>
                                @error('approval_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    @foreach ($documentType->formFields()->where('is_header', false)->orderBy('order')->get() as $field)
                        @php
                            // Get the existing value for this field
                            $existingValue = $document->fieldValues->where('form_field_id', $field->id)->first();
                            $currentValue = $existingValue ? $existingValue->value : null;
                        @endphp
                        <div class="form-group">
                            <label for="field_{{ $field->id }}">{{ $field->field_label }} @if($field->is_required)<span class="text-danger">*</span>@endif</label>

                            @switch($field->field_type)
                                @case('text')
                                @case('number')
                                @case('date')
                                    <input type="{{ $field->field_type }}" name="fields[{{ $field->id }}]" id="field_{{ $field->id }}" class="form-control @error('fields.'.$field->id) is-invalid @enderror" value="{{ old('fields.'.$field->id, $currentValue) }}" {{ $field->is_required ? 'required' : '' }}>
                                    @break

                                @case('textarea')
                                    <textarea name="fields[{{ $field->id }}]" id="field_{{ $field->id }}" class="form-control @error('fields.'.$field->id) is-invalid @enderror" rows="3" {{ $field->is_required ? 'required' : '' }}>{{ old('fields.'.$field->id, $currentValue) }}</textarea>
                                    @break

                                @case('select')
                                    <select name="fields[{{ $field->id }}]" data-selectjs="true" placeholder="Select {{ $field->field_label }}" id="field_{{ $field->id }}" class="form-control @error('fields.'.$field->id) is-invalid @enderror" {{ $field->is_required ? 'required' : '' }}>
                                        <option value="" {{ !$currentValue ? 'selected' : '' }} disabled>Select {{ $field->field_label }}</option>
                                        @foreach (explode(", ", $field->field_options) as $option)
                                            @php
                                                $optionParts = explode(':', trim($option), 2);
                                                $value = trim($optionParts[0]);
                                                $label = isset($optionParts[1]) ? trim($optionParts[1]) : $value;
                                            @endphp
                                            <option value="{{ $value }}" {{ old('fields.'.$field->id, $currentValue) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @break

                                @case('checkbox')
                                    @php
                                        $selectedCheckboxes = old('fields.'.$field->id, $currentValue ? json_decode($currentValue, true) : []);
                                        if (!is_array($selectedCheckboxes)) $selectedCheckboxes = []; // Ensure it's an array
                                    @endphp
                                    @foreach (explode(", ", $field->field_checkbox_options) as $index => $option)
                                        @php
                                            $optionParts = explode(':', trim($option), 2);
                                            $value = trim($optionParts[0]);
                                            $label = isset($optionParts[1]) ? trim($optionParts[1]) : $value;
                                        @endphp
                                        <div class="form-check">
                                            <input class="form-check-input @error('fields.'.$field->id.'.'.$value) is-invalid @enderror" type="checkbox" name="fields[{{ $field->id }}][{{ $value }}]" id="field_{{ $field->id }}_{{ $value }}" value="{{ $value }}" {{ in_array($value, $selectedCheckboxes) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="field_{{ $field->id }}_{{ $value }}">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                    @break

                                @case('file')
                                    <input type="file" name="fields[{{ $field->id }}]" id="field_{{ $field->id }}" class="form-control-file @error('fields.'.$field->id) is-invalid @enderror">
                                    @if($currentValue)
                                        <small class="form-text text-muted">Current file: <a href="{{ asset('storage/' . $currentValue) }}" target="_blank">{{ basename($currentValue) }}</a>. Uploading a new file will replace the current one.</small>
                                    @endif
                                    @break
                            @endswitch

                            @error('fields.'.$field->id)
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @if ($field->field_type === 'checkbox' && $errors->has('fields.'.$field->id)) {{-- General error for checkbox group --}}
                                <div class="invalid-feedback d-block">{{ $errors->first('fields.'.$field->id) }}</div>
                            @endif
                        </div>
                    @endforeach

                    <p>Note: Fields marked with <span class="text-danger">*</span> are required</p>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Update Document</button> {{-- Changed button text and color --}}
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
{{-- Add any specific JS for this form if needed --}}
<script>
    @php
        // Get the user_id for approval 1 and 2 from the document's approvals relationship
        $approval1User = $document->approval?->approvals->firstWhere('order', 1);
        $approval2User = $document->approval?->approvals->firstWhere('order', 2);

        $currentApproval1UserId = $approval1User ? $document->approval?->user_id : null;
        $currentApproval2UserId = $approval2User ? $document->approval?->user_id : null;
    @endphp
    $(document).ready(function() {
        // Store current approval IDs from PHP, fallback to empty string if not set
        var currentApproval1Id = '{{ old('approval_1', $currentApproval1UserId ?? '') }}';
        var currentApproval2Id = '{{ old('approval_2', $currentApproval2UserId ?? '') }}';

        function loadApprovers(selectedUserId, selectedUserUrl) {
            var approvalsDiv = $('#approvals');
            var approvalAList = $('#approval_1');
            var approvalBList = $('#approval_2');

            // Clear previous options and add placeholder
            approvalAList.empty().append('<option value="" selected disabled>Pilih Approval 1</option>');
            approvalBList.empty().append('<option value="" selected disabled>Pilih Approval 2</option>');

            if (selectedUserUrl) {
                $.ajax({
                    url: selectedUserUrl,
                    method: 'GET',
                    success: function(response) {
                        if (response.status) {
                            var employees = response.data; // Array of employee objects
                            if (employees && Array.isArray(employees) && employees.length > 0) {
                                approvalsDiv.css('display', 'block');
                                employees.forEach(employee => {
                                    if (employee && employee.user && typeof employee.user.id !== 'undefined' && typeof employee.user.name !== 'undefined' && employee.position && typeof employee.position.name !== 'undefined') {
                                        var optionTextA = `${employee.user.name} - ${employee.position.name}`;
                                        var optionTextB = `${employee.user.name} - ${employee.position.name}`; // As per create.blade.php logic
                                        approvalAList.append(`<option value="${employee.user.id}">${optionTextA}</option>`);
                                        approvalBList.append(`<option value="${employee.user.id}">${optionTextB}</option>`);
                                    } else {
                                        console.warn('Invalid employee/user object received for approvals:', employee);
                                    }
                                });

                                // Set selected values if they exist from initial load or old input
                                if (currentApproval1Id) {
                                    approvalAList.val(currentApproval1Id);
                                }
                                if (currentApproval2Id) {
                                    approvalBList.val(currentApproval2Id);
                                }
                            } else {
                                approvalsDiv.css('display', 'none'); // Hide if no approvers
                                console.log('No users found for approvals or data is empty/invalid.');
                            }
                            approvalAList.trigger('change'); // Notify Select2 to update
                            approvalBList.trigger('change'); // Notify Select2 to update
                        } else {
                            approvalsDiv.css('display', 'none');
                            console.error('Server responded with an error for approvals:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        approvalsDiv.css('display', 'none');
                        console.error('AJAX error fetching approvers:', error);
                    }
                });
            } else {
                approvalsDiv.css('display', 'none'); // Hide if no URL
                approvalAList.trigger('change');
                approvalBList.trigger('change');
            }
        }

        // Event listener for user_id change
        $('#user_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var userId = selectedOption.val();
            var url = selectedOption.data('url');
            // When user_id changes, we fetch new approvers.
            // currentApproval1Id and currentApproval2Id will be used if they match new options.
            // If not, the dropdowns will reset to placeholder.
            loadApprovers(userId, url);
        });

        // Initial load of approvers if a user is pre-selected
        var initialUserId = $('#user_id').val();
        if (initialUserId && initialUserId !== "") {
            var initialSelectedOption = $('#user_id').find('option:selected');
            var initialUrl = initialSelectedOption.data('url');
            if (initialUrl) {
                loadApprovers(initialUserId, initialUrl);
            } else {
                 $('#approvals').css('display', 'none');
            }
        } else {
            $('#approvals').css('display', 'none');
        }
    });
</script>
@endpush
