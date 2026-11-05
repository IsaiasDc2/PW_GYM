@extends('layouts.app')

@section('title', 'Editar sede')
@section('heading', 'Editar ' . $sede->nombre)

@section('content')
    <div class="card">
        @include('sedes._form', ['sede' => $sede])
    </div>
@endsection
