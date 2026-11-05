@extends('layouts.app')

@section('title', 'Nueva sede')
@section('heading', 'Nueva sede')

@section('content')
    <div class="card">
        @include('sedes._form', ['sede' => $sede])
    </div>
@endsection
