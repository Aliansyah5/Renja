@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group row">
                        <label for="template" class="col-form-label col-3">Template</label>
                        <div class="col-9">
                            <select class="form-control select2" id="template" style="width: 100%;">
                                @foreach($templates as $template)
                                <option 
                                    value="{{$template->TmpID}}" 
                                    data-foto="{{ $template->IsFoto ? 'true' : 'false' }}"
                                    data-nama="{{ $template->IsNama ? 'true' : 'false' }}"
                                    data-nik="{{ $template->IsNIK ? 'true' : 'false' }}"
                                    data-rfid="{{ $template->IsRFID ? 'true' : 'false' }}"
                                >
                                    {{ $template->Nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="font-weight-bold">Kartu Karyawan</div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-reload">
                                <i class="fas fa-sync"></i>
                                <p class="ml-2 d-none d-sm-inline">Reload</p>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-stripped table-hover w-100">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Kartu</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="card card-profile">
                <div class="card-header">
                    <div class="font-weight-bold">Profil Karyawan</div>
                </div>
                <div class="card-body">
                    <div id="profile-empty" class="text-center font-italic text-secondary m-4">Silahkan pilih karyawan terlebih dahulu.</div>
                    <form id="profile-selected" class="d-none" method="post" action="{{ route('kartu.print') }}" enctype="multipart/form-data" target="_blank" autocomplete="off">
                        <div class="form-group row">
                            <label for="foto" class="col-form-label col-3">Foto</label>
                            <div class="col-9">
                                <input type="file" class="form-control" id="foto" name="foto" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-form-label col-3">Nama</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="nama" name="nama" readonly />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nik" class="col-form-label col-3">NIK</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="nik" name="nik" readonly />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rfid" class="col-form-label col-3">RFID</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="rfid" name="rfid" />
                            </div>
                        </div>
                        @csrf
                        <input type="text" id="tmpid" name="tmpid" class="d-none" />
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-danger btn-reset-profile">
                        <i class="fas fa-times"></i>
                        <p class="ml-2 d-none d-sm-inline">Reset</p>
                    </button>
                    <button type="button" class="btn btn-sm btn-avian-secondary btn-print d-none" data-side="depan">
                        <i class="fas fa-print"></i>
                        <p class="ml-2 d-none d-sm-inline">Cetak Depan</p>
                    </button>
                    <button type="button" class="btn btn-sm btn-avian-secondary btn-print d-none" data-side="belakang">
                        <i class="fas fa-print"></i>
                        <p class="ml-2 d-none d-sm-inline">Cetak Belakang</p>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-update d-none">
                        <i class="fas fa-upload"></i>
                        <p class="ml-2 d-none d-sm-inline">Update</p>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .dataTables_wrapper .row:first-child, .dataTables_wrapper .row:last-child {
        margin-left: 0.5rem;
        margin-right: 0.5rem;
        margin-top: 0.5rem;
    }
    .dataTables_wrapper .row:last-child {
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('js')
<script>
$(function () {
    let table = $('.table').DataTable({
        responsive: true,
        orderCellsTop: true,
        // fixedHeader: true,
        processing: true,
        info: false,
        ajax: '{{ route("kartu.datatables") }}',
        language: {
            processing:     "Sedang memproses...",
            search:         "Cari:",
            lengthMenu:     "Tampilkan _MENU_ data",
            info:           "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty:      "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered:   "(Filter dari _MAX_ total data)",
            emptyTable:     "Tidak ada data yang ditampilkan",
            paginate: {
                first:      "Pertama",
                previous:   "Sebelumnya",
                next:       "Selanjutnya",
                last:       "Terakhir"
            },
        },
        columnDefs: [
            {
                targets: [-1],
                searchable: false,
                orderable: false,
            },
        ],
        columns: [
            { data: 'NIK', name: 'NIK', },
            { data: 'Name', name: 'Name', },
            { data: 'Status', name: 'Status', },
            { data: 'Kartu', name: 'Kartu', },
            { data: 'opsi', name: 'opsi', },
        ],
    });

    $('.btn-reload').on('click', function (e) {
        e.preventDefault();

        table.ajax.reload();
    });

    let profile = {
        value: null,
        listener: function (val) {},
        set profile(val) {
            this.value = val;
            this.listener(val);
        },
        get profile() {
            return value;
        },
        addListener: function (listener) {
            this.listener = listener;
        },
    }

    profile.addListener(function (val) {
        if (val) {
            $('#profile-empty').addClass('d-none');
            $('#profile-selected').removeClass('d-none');
            $('.btn-print, .btn-update').removeClass('d-none');

            $('#profile-selected #nik').val(val.nik || '');
            $('#profile-selected #nama').val(val.nama || '');
            $('#profile-selected #rfid').val('');
            $('#profile-selected #foto').val('');
        }
        else {
            $('#profile-empty').removeClass('d-none');
            $('#profile-selected').addClass('d-none');
            $('.btn-print, .btn-update').addClass('d-none');
        }
    });

    $('.table').on('click', '.btn-profile', function (e) {
        e.preventDefault();

        let nik = $(this).data('nik');
        let nama = $(this).data('nama');

        profile.profile = {
            'nik': nik,
            'nama': nama,
        };
    });

    $('.btn-reset-profile').on('click', function (e) {
        e.preventDefault();

        profile.profile = null;
    });

    $('.btn-update').on('click', function (e) {
        e.preventDefault();

        if (confirm('Apakah Anda yakin?')) {
            $.ajax({
                url: '{{ route("kartu.store") }}',
                method: 'post',
                dataType: 'json',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'rfid': $('#rfid').val(),
                    'nik': $('#nik').val(),
                    'nama': $('#nama').val(),
                },
                success: function (resp) {
                    if (resp.success && resp.message) {
                        alert(resp.message);
                        $('.btn-reset-profile, .btn-reload').trigger('click');
                    }
                },
                error: function (xhr, status, error) {
                    alert('Terjadi kesalahan!');
                }
            });
        }
    });

    $('.btn-print').on('click', function (e) {
        e.preventDefault();

        let side = $(this).data('side');

        $('form#profile-selected').attr('action', "{{ route('kartu.print') }}?side=" + side);
        $('form#profile-selected').trigger('submit');
    });

    $('#template').on('change', function () {
        let value = $(this).val();
        $('form#profile-selected #tmpid').val(value);
    });
    $('#template').trigger('change');
});
</script>
@endsection
