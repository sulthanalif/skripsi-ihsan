@extends('layouts.main')
@section('title', 'Generate Document')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Select Document Type</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Select Document Type</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Available Document Types</h3>
            </div>
            <div class="card-body">
                @if ($documentTypes->isEmpty())
                    <p>No document types available for generation.</p>
                @else
                    <div class="row">
                        @foreach ($documentTypes as $type)
                            <div class="col-lg col-md-4 col-sm-6 mb-3">
                                {{-- Check if the document type has any form fields defined --}}
                                @if ($type->formFields()->count() > 0)
                                    <a href="{{ route('document.generated.create', $type->id) }}" class="btn btn-outline-primary btn-block p-3 d-flex flex-column align-items-center justify-content-center" style="height: 120px;">
                                        <span class="h5 mb-1 text-truncate" style="max-width: 100%;">{{ $type->name }}</span>
                                        <span class="badge badge-primary badge-pill">{{ $type->formFields()->count() }} Fields</span>
                                    </a>
                                @else
                                    {{-- Optionally show types with no fields, but disable the link --}}
                                    <div class="btn btn-outline-secondary btn-block p-3 d-flex flex-column align-items-center justify-content-center disabled" style="height: 120px;">
                                        <span class="h5 mb-1 text-truncate" style="max-width: 100%;">{{ $type->name }}</span>
                                        <span class="badge badge-secondary badge-pill">No Fields</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Custom style to attempt 5 columns with col-lg */
    /* Bootstrap's col-lg by default is 1/12th. To get 5, you'd need a 12/5 = 2.4 width, which isn't standard.
       Using col-lg without a number makes it flexible. If you have exactly 5 items, they might fit.
       For a strict 5-column layout, you might need custom CSS or ensure your parent container width allows it.
       The `col-lg` class without a number will make columns share space equally.
       If you want exactly 5 columns, you can use `col-lg-2` for each item (5*2 = 10/12, leaving some space)
       or `col-12 col-sm-6 col-md-4 col-lg-2dot4` (custom class) or adjust the `col-lg` to `col-lg-2` and accept it won't fill 100% if less than 6 items.
       For simplicity, `col-lg` will try to fit them. If you have many items, it will wrap.
    */
    @media (min-width: 992px) { /* lg breakpoint */
        .col-lg {
            flex-basis: 0;
            flex-grow: 1;
            max-width: 20%; /* Attempt to make it 5 per row */
        }
    }
</style>
@endpush
