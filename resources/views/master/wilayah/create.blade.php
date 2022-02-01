@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <form id="formInput" class="col-md-12" method="post" action="{{ ($data['typeForm'] == 'create') ? route('master.wilayah.store') : route('master.wilayah.update',$data['dataModel']->WilayahID) }}" enctype="multipart/form-data" autocomplete="off">
            {{ csrf_field() }}
            <!--buat overided form post !-->
            <input name="_method" type="hidden" value="">
            <h1 class="p-0">Master Wilayah</h1>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-row justify-content-between">
                        <div>Form Master Wilayah</div>
                        <div class="btn-group">
                            <a href="{{route('master.wilayah.index')}}" type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-angle-left mr-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-sm btn-avian-secondary">
                                <i class="fas fa-save mr-2"></i>Save
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div id="deleteContainer">

                            </div>
                            <div class="form-group row">
                                <label for="no_pp" class="form-label col-md-3">Wilayah * :</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="wilayah"  value="{{ ($data['typeForm'] == 'create') ? "" : $data['dataModel']->Bagian }}"  required>
                                </div>
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
                        redirect('{{route('master.wilayah.index')}}');
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
