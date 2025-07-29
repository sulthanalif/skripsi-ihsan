<div class="modal fade" id="modal-export" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Export</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('report.export') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="month" class="form-label">Bulan</label>
                                <select name="month" class="form-control @error('month') is-invalid @enderror" id="month">
                                    <option value="">Pilih Bulan</option>
                                    <option value="1" {{ old('month') == '1' ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ old('month') == '2' ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ old('month') == '3' ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ old('month') == '4' ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ old('month') == '5' ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ old('month') == '6' ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ old('month') == '7' ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ old('month') == '8' ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ old('month') == '9' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ old('month') == '10' ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ old('month') == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ old('month') == '12' ? 'selected' : '' }}>Desember</option>
                                </select>
                                @error('month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="year" class="form-label">Tahun</label>
                                <select name="year" class="form-control @error('year') is-invalid @enderror" id="year" required>
                                    <option value="">Pilih Tahun</option>
                                    @php
                                        $years = $documents->pluck('created_at')->map(function($date) {
                                            return $date->format('Y');
                                        })->unique()->sort()->reverse();
                                    @endphp
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type" class="form-label">Tipe Export</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror" id="type" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="data">Data</option>
                                    <option value="total">Total</option>

                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
