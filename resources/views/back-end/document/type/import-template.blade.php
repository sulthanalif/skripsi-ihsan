<div class="modal fade" id="modal-import-template" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Import Template</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" action="{{ route('document.field.import', ['document_type' => $document_type->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') --}}
                <div class="form-group my-3">
                    <label for="template_file">Unggah Template Dokumen (Word)</label>
                    <input type="file" name="template_file" class="form-control-file" id="template_file" accept=".doc,.docx" required>
                    @error('template_file')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="modal-footer justify-content-right">
                    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
