<form class="form" method="POST" action="{{ $sede->exists ? route('sedes.update', $sede) : route('sedes.store') }}">
    @csrf
    @if ($sede->exists)
        @method('PUT')
    @endif

    <div class="grid">
        <div class="field full">
            <label for="nombre">Nombre de la sede</label>
            <input type="text" id="nombre" name="nombre" maxlength="50" value="{{ old('nombre', $sede->nombre) }}" required>
            @error('nombre')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="field full">
            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion" maxlength="120" value="{{ old('direccion', $sede->direccion) }}" required>
            @error('direccion')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="field">
            <label for="horario_semana">Horario lunes a viernes</label>
            <input type="text" id="horario_semana" name="horario_semana" maxlength="40" value="{{ old('horario_semana', $sede->horario_semana) }}" placeholder="Lunes a Viernes: 06:00 - 23:00" required>
            @error('horario_semana')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="field">
            <label for="horario_sabado">Horario sábados</label>
            <input type="text" id="horario_sabado" name="horario_sabado" maxlength="40" value="{{ old('horario_sabado', $sede->horario_sabado) }}" placeholder="Sábados: 08:00 - 20:00" required>
            @error('horario_sabado')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-actions">
        <button class="btn primary" type="submit">Guardar</button>
        <a class="btn ghost" href="{{ route('sedes.index') }}">Cancelar</a>
    </div>
</form>
