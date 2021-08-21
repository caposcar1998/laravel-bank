@extends('layouts.main')

@section('content')
    <h1>Súper banco</h1>
    <p>
        <a href="{{ route('auth.register') }}" class="btn btn-primary">
            Registrate
        </a>
    </p>
@endsection
