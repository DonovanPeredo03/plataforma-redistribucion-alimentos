{{-- Recibe: $ruta (ej. 'alimentos') y $id --}}
<a href="{{ route($ruta . '.show', $id) }}" class="btn btn-sm btn-info">Ver</a>

@can('editar')
  <a href="{{ route($ruta . '.edit', $id) }}" class="btn btn-sm btn-warning">Editar</a>
@endcan

@can('eliminar')
  <form method="POST" action="{{ route($ruta . '.destroy', $id) }}" style="display:inline"
        onsubmit="return confirm('¿Seguro que deseas eliminar este registro?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
  </form>
@endcan

@cannot('editar')
  <small class="text-muted">Solo lectura</small>
@endcannot