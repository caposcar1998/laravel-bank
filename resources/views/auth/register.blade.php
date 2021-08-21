@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-12">
        <h1>Registro</h1>
        <form action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="name@example.com">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" class="form-control" id="password_confirmation">
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
