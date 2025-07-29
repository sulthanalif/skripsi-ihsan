<div class="modal fade" id="modal-edit" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Penduduk</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" method="POST" class="form-horizontal" id="form-edit" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name_edit" placeholder="Masukan Nama" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email_edit"  placeholder="Masukan Email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username_edit"  placeholder="Masukan username"  value="{{ old('username') }}">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password_edit"  placeholder="Masukan Password"  value="{{ old('password') }}">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" id="nik_edit" placeholder="Masukan NIK" value="{{ old('nik') }}">
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kk" class="form-label">KK</label>
                                <input type="text" name="kk" class="form-control @error('kk') is-invalid @enderror" id="kk_edit" placeholder="Masukan KK" value="{{ old('kk') }}">
                                @error('kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="birth_place" class="form-label">Tempat Lahir</label>
                                <input type="text" name="birth_place" class="form-control @error('birth_place') is-invalid @enderror" id="birth_place_edit" placeholder="Masukan Tempat Lahir" value="{{ old('birth_place') }}">
                                @error('birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date_edit" value="{{ old('birth_date') }}">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select name="gender" class="form-control @error('gender') is-invalid @enderror" id="gender_edit" data-selectjs="true" data-placeholder="Pilih Jenis Kelamin">
                                    {{-- <option value="" selected disabled>Pilih Jenis Kelamin</option> --}}
                                    <option value="Laki-laki" >Laki-laki</option>
                                    <option value="Perempuan" >Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nationality" class="form-label">Kewarganegaraan</label>
                                <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" id="nationality_edit" placeholder="Masukan Kewarganegaraan" value="{{ old('nationality') }}">
                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="religion" class="form-label">Agama</label>
                                <select name="religion" class="form-control @error('religion') is-invalid @enderror" id="religion_edit" data-selectjs="true" data-placeholder="Pilih Agama">
                                    <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen Protestan" {{ old('religion') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                    <option value="Kristen Katolik" {{ old('religion') == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                                    <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Budha" {{ old('religion') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                    <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('religion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="marital_status" class="form-label">Status Perkawinan</label>
                                <select name="marital_status" class="form-control @error('marital_status') is-invalid @enderror" id="marital_status_edit" data-selectjs="true" data-placeholder="Pilih Status Perkawinan">
                                    <option value="Menikah" {{ old('marital_status') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                    <option value="Belum Menikah" {{ old('marital_status') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="Janda" {{ old('marital_status') == 'Janda' ? 'selected' : '' }}>Janda</option>
                                    <option value="Duda" {{ old('marital_status') == 'Duda' ? 'selected' : '' }}>Duda</option>
                                </select>
                                @error('marital_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="occupation" class="form-label">Pekerjaan</label>
                                <input type="text" name="occupation" class="form-control @error('occupation') is-invalid @enderror" id="occupation_edit" placeholder="Masukan Pekerjaan" value="{{ old('occupation') }}">
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_ktp" class="form-label">Alamat KTP</label>
                                <textarea name="address_ktp" class="form-control @error('address_ktp') is-invalid @enderror" id="address_ktp_edit" placeholder="Masukan Alamat KTP">{{ old('address_ktp') }}</textarea>
                                @error('address_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_domisili" class="form-label">Alamat Domisili</label>
                                <textarea name="address_domisili" class="form-control @error('address_domisili') is-invalid @enderror" id="address_domisili_edit" placeholder="Masukan Alamat Domisili">{{ old('address_domisili') }}</textarea>
                                @error('address_domisili')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
