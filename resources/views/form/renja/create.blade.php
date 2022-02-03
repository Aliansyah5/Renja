@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <form id="formInput" class="col-md-12" method="post" action="{{ ($data['typeForm'] == 'create') ? route('form.renja.store') : route('form.renja.update',$data['dataModel']->KabID) }}" enctype="multipart/form-data" autocomplete="off">
            {{ csrf_field() }}
            <!--buat overided form post !-->
            <input name="_method" type="hidden" value="">
            <h1 class="p-0">Renja LKH</h1>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-row justify-content-between">
                        <div>Form Renja LKH</div>
                        <div class="btn-group">
                            <a href="{{route('master.kabupaten.index')}}" type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-angle-left mr-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-sm btn-avian-secondary">
                                <i class="fas fa-save mr-2"></i>Save
                            </button>
                        </div>
                    </div>
                    <div class="btn-group btn-group-detail pull-right">
                        <button type="button" class="btn btn-sm btn-primary btnAddForm">
                            <i class="fas fa-plus mr-2"></i>Add Form
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div id="deleteContainer">

                            </div>

                            <div class="table-responsive table-sm">
                                <table class="table-avian stripe row-border order-column table table-striped table-bordered"
                                style="width: 100%" >
                                    <thead>
                                        <tr>
                                            <th colspan="5" class="text-center">Detail Input</th>
                                            <th class="text-center" colspan="5">Detail User</th>
                                            <th class="text-center" rowspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Kode</th>
                                            <th class="text-center">PIC</th>
                                            <th class="text-center">Aktifitas</th>
                                            <th class="text-center">Kegiatan</th>
                                            <th class="text-center">User</th>
                                            <th class="text-center">Wilayah</th>
                                            <th class="text-center">Provinsi</th>
                                            <th class="text-center">Kabupaten</th>
                                            <th class="text-center">Sub Cabang</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableform" id="tableBodyForm">
                                        <tr id='trForm'>
                                            <td></td>
                                            <td style="min-width: 250px"><input type='text' name='kode[]' class='form-control formkode' readonly></td>
                                            <td style="min-width: 200px"><input type='text' name='pic[]' class='form-control formpic' value="{{ Auth::user()->pegawai->Kode }}"></td>
                                            <td style="min-width: 200px">
                                                <select name='aktifitas[]' class="form-control select2 selectAktifitas">
                                                    <option value=''>Pilih Aktifitas</option>
                                                    <option value='VISIT' data-kode='VIS'>VISIT</option>
                                                    <option value='PEMBINAAN' data-kode='PEM'>PEMBINAAN</option>
                                                    <option value='SIDAK' data-kode='SID'>SIDAK</option>
                                                    <option value='PATROLI' data-kode='PAT'>PATROLI</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="kegiatan[]" class="form-control formkegiatan" style="min-width: 300px">
                                            </td>
                                            <td style="min-width: 200px"><input type="text" name="user[]" class="form-control formuser"></td>
                                            <td style="min-width: 200px">
                                                <select name='wilayah[]' class="form-control select2 selectWilayah">
                                                    <option value=''>Pilih Wilayah</option>
                                                    @foreach ($data['Wilayah'] as $item)
                                                    <option value="{{ $item->WilayahID }}" data-kode="{{ $item->KodeKabupaten }}" >{{ $item->Bagian }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td style="min-width: 200px">
                                                <select name='provinsi[]' class="form-control select2 selectProvinsi">
                                                </select>
                                            </td>
                                            <td style="min-width: 200px">
                                                <select name='kabupaten[]' class="form-control select2 selectKabupaten">
                                                </select>
                                            </td>
                                            <td><input type="text" name="subcabang[]" class="form-control formsubcabang"></td>
                                            <td>
                                            <button class='btn-action btn btn-danger btn-delete btnDeleteForm'>
                                                <i class='fas fa-trash'></i>
                                            </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('js')
<script>
    $(document).ready(function () {
        var arrWilayah = [];
        var parentRowForm = null;

        $(".btnAddForm").click(function (e) {
            e.preventDefault();
            addRowFormulasi();
        });

        async function getDataWilayah() {
            if(arrWilayah.length == 0){
                await $.ajax({
                    url: "{{route('master.wilayah.getWilayah')}}",
                    dataType: "json",
                    async: false,
                    beforeSend: function(){
                        blockMessage($('.card'),'Please Wait','#fff');
                    },
                }).done(function(data) {
                    $('.card').unblock();
                    if(data.length > 0){
                        arrWilayah = data;
                        return arrWilayah;
                    }
                }).fail(function(e) {
                    $('.card').unblock();
                    toastr.error(e.responseText);
                });
            }else{
                return arrWilayah;
            }
        }

        function generatedSelectWilayahHTML(data,Inputname,className,EmptyString,selected){
            var option = "<option value='0'>"+EmptyString+"</option>";
            $.each( data, function( key, value ) {
                if(selected == value.WilayahID){
                    option += "<option selected='selected' value='"+value.WilayahID+"'>"+value.Bagian+"</option>";
                }else{
                    option += "<option value='"+value.WilayahID+"'>"+value.Bagian+"</option>";
                }
            });
            return "<select name='"+Inputname+"' class='"+className+" form-control select2'>"+
                        option+
                    "</select>";
        }

        $(document.body).on("change",".selectWilayah",function(e){
            e.preventDefault();
            var obj = $(this);
            var wilayahid = obj.find('option:selected').val();
            var parentRowForm = obj.closest("tr");
            $.ajax({
                url: "{{route('master.provinsi.getProvinsi')}}",
                data: {
                    wilayahid : wilayahid,
                },
                dataType: "json",
            }).done(function(data) {
                parentRowForm.find('.selectProvinsi option').remove();
                var option = "<option value=''>Pilih Provinsi</option>";
                if(data.length > 0){
                    $.each( data, function( key, value ) {
                        option += "<option value='"+value.ProvID+"'>"+value.Provinsi+"</option>";
                    });
                    parentRowForm.find(".selectProvinsi").append(option);
                }else{
                    parentRowForm.find('.selectProvinsi option').remove();
                }
            });
        });

        $(document.body).on("change",".selectProvinsi",function(e){
            e.preventDefault();
            var obj = $(this);
            var provinsiid = obj.find('option:selected').val();
            var parentRowForm = obj.closest("tr");
            $.ajax({
                url: "{{route('master.kabupaten.getKabupaten')}}",
                data: {
                    provinsiid : provinsiid,
                },
                dataType: "json",
            }).done(function(data) {
                parentRowForm.find('.selectKabupaten option').remove();
                var option = "<option value=''>Pilih Provinsi</option>";
                if(data.length > 0){
                    $.each( data, function( key, value ) {
                        option += "<option value='"+value.KabID+"' data-kode='"+value.KodeKabupaten+"' >"+value.Kabupaten+"</option>";
                    });
                    parentRowForm.find(".selectKabupaten").append(option);
                }else{
                    parentRowForm.find('.selectKabupaten option').remove();
                }
            });
        });

        $(document.body).on("change",".selectKabupaten",function(e){
            e.preventDefault();
            var obj = $(this);
            var parentRowForm = obj.closest("tr");
            var namauser =  parentRowForm.find('.formuser').val();
            var user = namauser.slice(0, 3);
            var namapic =  parentRowForm.find('.formpic').val();
            var pic = namapic.slice(0, 2);
            var kodekabupaten = parentRowForm.find('.selectKabupaten option:selected').data('kode');
            var kodeaktifitas =  parentRowForm.find('.selectAktifitas option:selected').data('kode');
            var cabanguser = $(this).find('option:selected').data('kode');

            $.ajax({
                url: "{{route('form.renja.getNoForm')}}",
                data: {
                    user : user,
                    kodekabupaten : kodekabupaten,
                    kodeaktifitas : kodeaktifitas,
                    cabanguser : cabanguser,
                    pic : pic,
                },
                dataType: "json",
            }).done(function(data) {
                console.log('ikidata', data);
                parentRowForm.find('.formkode').val(data);
            });

        });

        function addRowFormulasi() {
            getDataWilayah().then(function (res) {
                var html = "<tr>"+
                        "<td></td>"+
                        "<td>"+
                            "<input type='text' name='kode[]' class='form-control formkode' readonly>"+
                        "</td>"+
                        "<td >"+
                             "<input type='text' name='pic[]' class='form-control formpic'>"+
                        "</td>"+
                        "<td>"+
                            "<select name='aktifitas[]' class='form-control select2 selectAktifitas'>"+
                                "<option value=''>Pilih Aktifitas</option>"+
                                "<option value='VISIT' data-kode='VIS'>VISIT</option>"+
                                "<option value='PEMBINAAN' data-kode='PEM'>PEMBINAAN</option>"+
                                "<option value='SIDAK' data-kode='SID'>SIDAK</option>"+
                                "<option value='PATROLI' data-kode='PAT'>PATROLI</option>"+
                            "</select>"+
                        "</td>"+
                        "<td>"+
                            "<input type='text' name='kegiatan[]' class='form-control formkegiatan' style='min-width: 300px'>"+
                        "</td>"+
                        "<td>"+
                            "<input type='text' name='user[]' class='form-control formuser'>"+
                        "</td>"+
                        "<td>"+
                            generatedSelectWilayahHTML(arrWilayah,"wilayah[]","selectWilayah","Pilih Wilayah")+
                        "</td>"+
                        "<td>"+
                            "<select name='provinsi[]' class='form-control select2 selectProvinsi'></select>"+
                        "</td>"+
                        "<td>"+
                            "<select name='kabupaten[]' class='form-control select2 selectKabupaten'></select>"+
                        "</td>"+
                        "<td>"+
                            "<input type='text' name='subcabang[]' class='form-control formsubcabang'>"+
                        "</td>"+
                        "<td>"+
                            "<button class='btn-action btn btn-danger btn-delete btnDeleteDetailFormulasi'>"+
                                    "<i class='fas fa-trash'></i>"+
                            "</button>"+
                        "</td>"+
                    "</tr>";

                $("#tableBodyForm").append(html);
                $(".select2").select2({
                    placeholder: 'Pilih...',
                    theme: 'bootstrap4',
                });
            });
        }

        $(document.body).on("click",".btnDeleteForm",function(e){
            e.preventDefault();
            var objListRow = $("#tableBodyForm").find("tr");
            var objRow = $(this).parent().parent();
            Swal.fire({
            title: 'Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.value) {
                    objRow.remove()
                }
            })
        })

        $("#formInput").submit(function(e){
            e.preventDefault();

            var formData = new FormData(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                }
            });

            @if($data['typeForm'] == "edit")
                formData.append('_method', 'PUT');
            @endif

            $.ajax({
                url: 		$("#formInput").attr('action'),
                method: 	'POST',
                data:  		formData,
                processData: false,
                contentType: false,
                dataType : 'json',
                encode  : true,
                beforeSend: function(){
                    blockMessage($('#formInput'),'Please Wait','#fff');
                }
            })
            .done(function(data){
                $('#formInput').unblock();
                if(data.Code == 200){
                    toastr.success(data.Message);
                    setTimeout(function(){
                        redirect('{{route('form.renja.index')}}');
                    }, 1500);
                }else{
                    toastr.error(data.Message);
                }
            })
            .fail(function(e) {
                $('#formInput').unblock();
                toastr.error(e.responseText);
            })

        });

    });
</script>
@endsection
