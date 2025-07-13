<div class="modal fade" id="modal-create" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Field</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('document.field.store', $document_type->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_name" class="form-label">Nama</label>
                                <input type="text" name="field_name" class="form-control @error('field_name') is-invalid @enderror" id="field_name" placeholder="Masukan Nama" value="{{ old('field_name') }}">
                                @error('field_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_label" class="form-label">Label</label>
                                <input type="text" name="field_label" class="form-control @error('field_label') is-invalid @enderror" id="field_label" placeholder="Masukan Nama" value="{{ old('field_label') }}">
                                @error('field_label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="hint" class="form-label">Petunjuk</label>
                                <input type="text" name="hint" class="form-control @error('hint') is-invalid @enderror" id="hint" placeholder="Masukan Petunjuk" value="{{ old('hint') }}">
                                @error('hint')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field_type" class="form-label">Type Data</label>
                                <select name="field_type" id="field_type" class="form-control @error('field_type') is-invalid @enderror" data-selectjs="true" data-placeholder="Pilih Type Data">
                                    <option value="" selected disabled>Pilih Type Data</option>
                                    <option @selected(old('field_type') == 'text') value="text">Text</option>
                                    <option @selected(old('field_type') == 'textarea') value="textarea">Textarea</option>
                                    <option @selected(old('field_type') == 'select') value="select">Select</option>
                                    {{-- <option @selected(old('field_type') == 'radio') value="radio">Radio</option> --}}
                                    <option @selected(old('field_type') == 'checkbox') value="checkbox">Checkbox Group</option>
                                    <option @selected(old('field_type') == 'date') value="date">Date</option>
                                    <option @selected(old('field_type') == 'number') value="number">Number</option>
                                    {{-- <option @selected(old('field_type') == 'file') value="file">File</option> --}}
                                </select>
                                @error('field_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order" class="form-label">Urutan</label>
                                <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" id="order" placeholder="Masukan Urutan" value="{{ old('order') }}">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12" id="field_options_wrapper">
                            <div class="form-group">
                                <label for="field_options" class="form-label">Field Options (for Select/Radio)</label>
                                <textarea name="field_options" class="form-control @error('field_options') is-invalid @enderror" id="field_options" placeholder="Satu opsi per baris (misal: nilai:Label)" rows="3">{{ old('field_options') }}</textarea>
                                <small class="form-text text-muted">Digunakan untuk tipe field 'Select' dan 'Radio'. Format: <code>nilai:Label</code> atau hanya <code>Label</code>.</small>
                                @error('field_options')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12" id="field_checkbox_options_wrapper">
                            <div class="form-group">
                                <label for="field_checkbox_options" class="form-label">Field Checkbox Options (for Checkbox Group)</label>
                                <textarea name="field_checkbox_options" class="form-control @error('field_checkbox_options') is-invalid @enderror" id="field_checkbox_options" placeholder="Satu opsi per baris (misal: nilai:Label)" rows="3">{{ old('field_checkbox_options') }}</textarea>
                                <small class="form-text text-muted">Digunakan untuk tipe field 'Checkbox Group'. Format: <code>nilai:Label</code>.</small>
                                @error('field_checkbox_options')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="hidden" name="is_required" value="0">
                                    <input type="checkbox" name="is_required" class="form-check-input @error('is_required') is-invalid @enderror" id="is_required" value="1" {{ old('is_required') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_required">Wajib Diisi?</label>
                                    @error('is_required')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
