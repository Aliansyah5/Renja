@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3>Selamat datang, {{ auth()->user()->pegawai->Nama }}.</h3>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div>Notifikasi</div>
                        <div class="btn-group">
                            <a href="{{ route('read_all') }}" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Apakah Anda yakin?')">
                                <i class="fas fa-check-double mr-2"></i>Mark all as read
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (count($notifications))
                    @foreach ($notifications as $notification)
                    <div class="card {{ $notification->IsRead ? 'bg-light' : 'bg-info text-white'}} mb-3">
                        <div class="card-header">
                            <div class="d-flex flex-row justify-content-between align-items-center">
                                <div>{{ $notification->Title }}</div>
                                <div class="btn-group">
                                    @if (!$notification->IsRead)
                                    <a href="{{ route('read', $notification->NotifID) }}" class="btn btn-sm btn-outline-light">
                                        <i class="fas fa-check-double mr-2"></i>Mark as read
                                    </a>
                                    @endif
                                    <a href="{{ route('show', $notification->NotifID) }}" class="btn btn-sm {{ $notification->IsRead ? 'btn-outline-secondary' : 'btn-outline-light'}}">
                                        <i class="fas fa-eye mr-2"></i>View
                                    </a>
                                    <a href="{{ route('delete', $notification->NotifID) }}" class="btn btn-sm {{ $notification->IsRead ? 'btn-outline-secondary' : 'btn-outline-light'}}" onclick="return confirm('Apakah Anda yakin?')">
                                        <i class="fas fa-trash mr-2"></i>Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between">
                                <div>{!! $notification->HtmlContent !!}</div>
                                <div class="font-italic">{{ $notification->CreatedDate->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-secondary w-100 m-2 text-center font-italic">Tidak ada data yang ditampilkan.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
