@extends('back.layout.auth-layout')

@section('pageTitle',isset($pageTitle) ? $pageTilte : 'register Page')
@section('content')
<div class="login-box bg-white box-shadow border-radius-10">
    <div class="login-title">
        <h2 class="text-center text-primary">Register</h2>
    </div>
    <form action="" method="POST">
        @csrf
<div class="form-wrap max-width-600 mx-auto">
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">Email Address*</label>
        <div class="col-sm-8">
            <input type="email" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">Username*</label>
        <div class="col-sm-8">
            <input type="text" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">Password*</label>
        <div class="col-sm-8">
            <input type="password" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-4 col-form-label">Confirm Password*</label>
        <div class="col-sm-8">
            <input type="password" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="input-group mb-0">

                <a href="{{ route('admin.login_handler') }}">Sudah punya akun?</a>
            
    <button type="submit" class="btn btn-primary">Daftar</button>
    </div>
        </div>
    </div>
</form>
</div>

@endsection