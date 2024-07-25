@foreach ($marcas as $marca)
    <tr>
        <td>{{ $marca->nombre_marca }}</td>
        <td>{{ $marca->proveedor }}</td>
        <td>
            <button type="button" class="btn btn-primary btn-sm btn-edit"
                data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-marca-id="{{ $marca->id }}">Editar</button>
        </td>
    </tr>
@endforeach

