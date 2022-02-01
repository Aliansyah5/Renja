@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="p-0">Form Renja LKH</h1>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-row justify-content-between">
                        <div>Form Renja LKH List</div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-reload">
                                <i class="fas fa-sync mr-2"></i>Reload
                            </button>
                            <a href="{{ route('form.renja.create') }}" class="btn btn-sm btn-avian-secondary">
                                <i class="fas fa-plus mr-2"></i>Add
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-md-0">
                    @if (session()->has('result'))
                    <div class="alert alert-{{ session()->get('result')->type }} m-2" role="alert">
                        {{ session()->get('result')->message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <table class="table table-striped table-hover dataTable">
                        <thead>
                            <tr>
                                <th width="0">No</th>
                                <th data-priority="1">Kode Form</th>
                                <th>PIC</th>
                                <th>Aktifitas</th>
                                <th>Kegiatan</th>
                                <th>User</th>
                                <th>Wilayah</th>
                                <th>Provinsi</th>
                                <th>Kabupaten</th>
                                <th>Sub Cabang</th>
                                <th data-priority="3">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var baseurl = "{{route('master.kabupaten.datatable')}}";
    let table = $('.dataTable').dataTable({
        processing: true,
        orderClasses: false,
        responsive: false,
        serverSide: true,
        paging: true,
        ajax: baseurl + '?' + $('#filter').serialize(),
        columns: [
            {data: 'KabID', name: 'KabID', searchable: false},
            {data: 'Provinsi', name: 'Provinsi'},
            {data: 'Kabupaten', name: 'Kabupaten'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order : ['0', 'desc'],
        "createdRow": function( row, data, dataIndex){
            console.log(data);
        }
    });
    const reloadData = function () {
        const filters = $('#filter').serialize();
        let url = baseurl + '?' + filters;
        table.api().ajax.url(url).load();
    };
    $('.form-control').on('change', function (e) {
            reloadData();
    });
    $('.form-control').on('keyup', function (e) {
        reloadData();
    });
    $('.btn-reload').on('click', function (e) {
        e.preventDefault();
        reloadData();
    });
</script>
@endsection
