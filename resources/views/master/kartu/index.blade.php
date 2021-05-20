@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="font-weight-bold">Kartu</div>
                        <div class="btn-group">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if (session()->has('message'))
                        <div class="mx-4 my-2 alert alert-info alert-dismissible fade show" role="alert">
                            {{ session()->get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="mx-4 my-2 alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session()->get('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form class="row m-2" id="filter">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-3">RFID</label>
                                <div class="col-9">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="rfid" id="rfid" />
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="clear"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered table-stripped table-hover w-100">
                        <thead>
                            <tr>
                                <th>RFID</th>
                                <th>NIK</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                    </table>
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
    let tableUrl = '{{ route("master.kartu.datatables") }}';
    let table = $('.table').DataTable({
        responsive: true,
        orderCellsTop: true,
        fixedHeader: true,
        processing: true,
        searching: false,
        ajax: tableUrl + '?' + $('#filter').serialize(),
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
        columns: [
            { data: 'RFID', name: 'RFID', },
            { data: 'NIK', name: 'NIK', },
            { data: 'Nama', name: 'Nama', },
        ],
    });

    const reloadData = function () {
        const filters = $('#filter').serialize();
        var url = tableUrl + '?' + filters;
        table.ajax.url(url).load();
    };

    $('#filter').on('change, keyup', '.form-control', function (e) {
        reloadData();
    });

    $('#filter').on('submit', function (e) {
        e.preventDefault();
    });

    $('#filter').on('click', '#clear', function (e) {
        e.preventDefault();

        $('#filter #rfid').val('').trigger('change');
        
        reloadData();
    });
});
</script>
@endsection
