@extends('layouts.app')

@section('title', 'Sedes')
@section('heading', 'Sedes disponibles')

@section('actions')
    <a class="btn primary" href="{{ route('sedes.create') }}">Nueva sede</a>
@endsection

@section('content')
    @if ($sedes->isEmpty())
        <div class="card muted">No hay sedes cargadas todavía.</div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Sede</th>
                        <th>Lunes a viernes</th>
                        <th>Sábados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sedes as $sede)
                        <tr>
                            <td>
                                <strong>{{ $sede->nombre }}</strong>
                                <div class="muted small">{{ $sede->direccion }}</div>
                            </td>
                            <td>{{ $sede->horario_semana }}</td>
                            <td>{{ $sede->horario_sabado }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn ghost" href="{{ route('sedes.show', $sede) }}">Ver</a>
                                    <a class="btn" href="{{ route('sedes.edit', $sede) }}">Editar</a>
                                    <form method="POST" action="{{ route('sedes.destroy', $sede) }}" onsubmit="return confirm('¿Eliminar la sede {{ $sede->nombre }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
