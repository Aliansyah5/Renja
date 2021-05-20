@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="font-weight-bold">Karyawan</div>
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

                    <table class="table table-bordered table-stripped table-hover w-100">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Kartu</th>
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
    let table = $('.table').DataTable({
        responsive: true,
        orderCellsTop: true,
        fixedHeader: true,
        processing: true,
        ajax: '{{ route("master.karyawan.datatables") }}',
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
            { data: 'NIK', name: 'NIK', },
            { data: 'Name', name: 'Name', },
            { data: 'Status', name: 'Status', },
            { data: 'Kartu', name: 'Kartu', },
        ],
    });
});
</script>
@endsection
