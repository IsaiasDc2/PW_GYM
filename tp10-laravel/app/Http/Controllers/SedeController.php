<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SedeController extends Controller
{
    public function index(): View
    {
        $sedes = Sede::orderBy('nombre')->get();

        return view('sedes.index', compact('sedes'));
    }

    public function create(): View
    {
        return view('sedes.create', ['sede' => new Sede()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Sede::create($request->validate($this->reglas(), $this->mensajes()));

        return redirect()
            ->route('sedes.index')
            ->with('success', 'Sede creada correctamente.');
    }

    public function show(Sede $sede): View
    {
        return view('sedes.show', compact('sede'));
    }

    public function edit(Sede $sede): View
    {
        return view('sedes.edit', compact('sede'));
    }

    public function update(Request $request, Sede $sede): RedirectResponse
    {
        $sede->update($request->validate($this->reglas($sede), $this->mensajes()));

        return redirect()
            ->route('sedes.index')
            ->with('success', 'Sede actualizada correctamente.');
    }

    public function destroy(Sede $sede): RedirectResponse
    {
        $sede->delete();

        return redirect()
            ->route('sedes.index')
            ->with('success', 'Sede eliminada correctamente.');
    }

    private function reglas(?Sede $sede = null): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:50',
                Rule::unique('sedes', 'nombre')->ignore($sede?->id),
            ],
            'direccion' => ['required', 'string', 'max:120'],
            'horario_semana' => ['required', 'string', 'max:40'],
            'horario_sabado' => ['required', 'string', 'max:40'],
        ];
    }

    private function mensajes(): array
    {
        return [
            'nombre.required' => 'El nombre de la sede es obligatorio.',
            'nombre.unique' => 'Ya existe una sede con ese nombre.',
            'nombre.max' => 'El nombre no puede superar los 50 caracteres.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede superar los 120 caracteres.',
            'horario_semana.required' => 'El horario de lunes a viernes es obligatorio.',
            'horario_semana.max' => 'El horario de lunes a viernes no puede superar los 40 caracteres.',
            'horario_sabado.required' => 'El horario de sábados es obligatorio.',
            'horario_sabado.max' => 'El horario de sábados no puede superar los 40 caracteres.',
        ];
    }
}
