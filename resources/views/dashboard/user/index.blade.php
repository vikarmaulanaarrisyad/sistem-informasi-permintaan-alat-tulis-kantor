@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <x-card>
               <h3>Selamat Datang, {{ auth()->user()->name }}!</h3>
            </x-card>
        </div>
    </div>
@endsection

@include('include.datatables')

@include('dashboard.user.scripts')
