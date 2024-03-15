@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Listado de Áreas Municipales</h2>

    <!-- Botón para crear nueva área -->
    <a href="{{ route('areas.create') }}" class="btn btn-primary mb-3">Crear Nueva Área</a>
    
    <!-- Búsqueda de Áreas -->
    <form method="GET" action="{{ route('areas.index') }}">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Buscar área" value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            </div>
        </div>
    </form>

    @if(isset($areas) && $areas->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($areas as $area)
                <tr class="table-primary">
                    <td>{{ $area->nombre }}</td>
                    <td>{{ $area->direccion }}</td>
                    <td>{{ $area->email }}</td>
                    <td>{{ $area->telefono }}</td>
                    <td>
                        <a href="{{ route('areas.edit', $area->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('areas.destroy', $area->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de querer eliminar esta área?');">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @if($area->children)
                    @foreach($area->children as $child)
                        <tr>
                            <td>{{ $child->nombre }}</td>
                            <td>{{ $child->direccion }}</td>
                            <td>{{ $child->email }}</td>
                            <td>{{ $child->telefono }}</td>
                            <td>
                                <a href="{{ route('areas.edit', $child->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                <form action="{{ route('areas.destroy', $child->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de querer eliminar esta subárea?');">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
    @else
        <p>No se encontraron áreas.</p>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <!-- Paginación -->
    <div class="mt-3">
        {{ $areas->links() }}
    </div>
</div>
@endsection

