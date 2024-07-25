@foreach($productos as $producto)
<tr>
    <td>{{ $producto->id }}</td>
    <td>{{ $producto->nombre }}</td>
    <td>{{ $producto->precio }}</td>
    <td>
        <input type="number" class="form-control cantidad" placeholder="Cantidad" min="1">
    </td>
    <td>
        <button type="button" class="btn btn-primary btn-agregar" data-id="{{ $producto->id }}" data-nombre="{{ $producto->nombre }}" data-precio="{{ $producto->precio }}">Agregar</button>
    </td>
</tr>
@endforeach