@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ubah Password') }}</div>

                <div class="card-body">
                    @if(session()->has('result'))
                    <div class="alert alert-{{ session()->get('result')->type }} alert-dismissible fade show" role="alert">
                        {{ session()->get('result')->message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <form method="post" action="{{ route('security') }}" onsubmit="return confirm('Apakah Anda yakin?')">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="old_password" class="col-sm-4 col-form-label">Password Lama</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" id="old_password" name="old" value="{{ old('old') }}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_password" class="col-sm-4 col-form-label">Password Baru</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" id="new_password" name="new" value="{{ old('new') }}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"></label>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-avian-secondary">
                                    <i class="fas fa-check"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('.autocomplete').autocomplete({
            source: [
                "ActionScript",
                "AppleScript",
                "Asp",
                "BASIC",
                "C",
                "C++",
                "Clojure",
                "COBOL",
                "ColdFusion",
                "Erlang",
                "Fortran",
                "Groovy",
                "Haskell",
                "Java",
                "JavaScript",
                "Lisp",
                "Perl",
                "PHP",
                "Python",
                "Ruby",
                "Scala",
                "Scheme"
            ],
        });

        $('.table').dataTable({
            responsive: true,
        });
    });
</script>
@endsection
