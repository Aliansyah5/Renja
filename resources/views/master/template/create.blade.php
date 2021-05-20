@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form class="card" method="post" action="{{ route('master.template.store') }}" enctype="multipart/form-data">
                <div class="card-header">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="font-weight-bold">Tambah Template Kartu</div>
                        <div class="btn-group">
                            <a href="javascript:history.go(-1);" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-angle-left"></i>
                                <p class="ml-2 d-none d-sm-inline">Kembali</p>
                            </a>
                            <button type="submit" class="btn btn-sm btn-avian-secondary">
                                <i class="fas fa-check"></i>
                                <p class="ml-2 d-none d-sm-inline">Simpan</p>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="m-0 px-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session()->get('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @csrf

                    <div class="form-group row">
                        <label for="nama" class="col-4 col-form-label">Nama Template</label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bgdepan" class="col-4 col-form-label">Background Depan</label>
                        <div class="col-8">
                            <input type="file" class="form-control" id="bgdepan" name="bgdepan" value="{{ old('bgdepan') }}" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bgbelakang" class="col-4 col-form-label">Background Belakang</label>
                        <div class="col-8">
                            <input type="file" class="form-control" id="bgbelakang" name="bgbelakang" value="{{ old('bgbelakang') }}" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="isfoto" class="col-4 col-form-label">Tampilkan Foto</label>
                        <div class="col-8">
                            <select class="form-control select2" id="isfoto" name="isfoto" required>
                                <option value="1" selected>Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="isnama" class="col-4 col-form-label">Tampilkan Nama</label>
                        <div class="col-8">
                            <select class="form-control select2" id="isnama" name="isnama" required>
                                <option value="1" selected>Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="isnik" class="col-4 col-form-label">Tampilkan NIK</label>
                        <div class="col-8">
                            <select class="form-control select2" id="isnik" name="isnik" required>
                                <option value="1" selected>Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="isrfid" class="col-4 col-form-label">Tampilkan RFID</label>
                        <div class="col-8">
                            <select class="form-control select2" id="isrfid" name="isrfid" required>
                                <option value="1">Ya</option>
                                <option value="0" selected>Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="color" class="col-4 col-form-label">Warna Font</label>
                        <div class="col-8">
                            <input type="color" class="form-control" id="color" name="color" value="{{ old('color') }}" required />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
