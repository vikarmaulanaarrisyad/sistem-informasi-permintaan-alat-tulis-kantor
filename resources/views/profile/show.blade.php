@extends('layouts.app')

@section('title', 'Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profile</li>
@endsection

@section('content')

    <form class="form-horizontal" method="POST" action="{{ route('user-profile-information.update') }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ Storage::url(auth()->user()->path_image ?? '') }}" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>
                        <p class="text-muted text-center mb-3">{{ auth()->user()->email }}</p>

                        <div class="form-group mt-2">
                            <input type="file" name="path_image"
                                class="form-control @error('path_image') is-invalid @enderror">

                            @error('path_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <p class="text-muted">File harus bertipe jpg, png, jpeg ukuran max 2MB</p>

                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#settings"
                                    data-toggle="tab">Pengaturan</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active " id="settings">



                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name"
                                            class="form-control @error('email') is-invalid @enderror" id="inputName"
                                            placeholder="Name" autocomplete="off"
                                            value="{{ old('name') ?? auth()->user()->name }}">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control" id="inputEmail"
                                            placeholder="Email" autocomplete="off"
                                            value="{{ old('email') ?? auth()->user()->email }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Simpan</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

<x-notif></x-notif>
