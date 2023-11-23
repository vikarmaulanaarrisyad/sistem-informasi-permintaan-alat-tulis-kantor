@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    @include('dashboard.admin._small_box')
    @include('dashboard.admin._stok')
@endsection
