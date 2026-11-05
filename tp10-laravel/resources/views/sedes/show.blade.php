@extends('layouts.app')

@section('title', $sede->nombre)
@section('heading', $sede->nombre)

@section('actions')
    <a class="btn" href="{{ route('sedes.edit', $sede) }}">Editar</a>
    <a class="btn ghost" href="{{ route('sedes.index') }}">Volver</a>
@endsection

@section('content')
    <div class="card">
        <dl class="detail">
            <div class="full">
                <dt>Dirección</dt>
                <dd>{{ $sede->direccion }}</dd>
            </div>
            <div>
                <dt>Lunes a viernes</dt>
                <dd>{{ $sede->horario_semana }}</dd>
            </div>
            <div>
                <dt>Sábados</dt>
                <dd>{{ $sede->horario_sabado }}</dd>
            </div>
            <div>
                <dt>Registrada</dt>
                <dd>{{ $sede->created_at?->format('d/m/Y H:i') }}</dd>
            </div>
            <div>
                <dt>Última actualización</dt>
                <dd>{{ $sede->updated_at?->format('d/m/Y H:i') }}</dd>
            </div>
        </dl>
    </div>
@endsection
