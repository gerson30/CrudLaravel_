@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Mostrar un mensaje -->

    <!-- si hay un mensaje muestra un mensaje en la parte de abajo, esto servirá para todos los metodos
    que alteren o modifiquen los registros -->

    <!-- mensaje de producto actualizado con exito -->
    @if(Session::has('mensaje'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">

        {{ Session::get('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#my-alert" aria-label="Close"></button>
    </div>
    @endif

    <br>
    <br>



    <a href="{{ url('productos/create') }} " class="btn btn-success">Registrar un nuevo producto</a>
    <br>
    <br>

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            <!-- se crea un foreach para agregar cada registro en un dato diferente -->
            @foreach( $productos as $producto )
            <tr>
                <td>{{ $producto->id }}</td>

                <td>{{ $producto->Nombre }}</td>

                <td>{{ $producto->Descripcion }}</td>
                <td>
                    <!-- acceder a la carpeta donde se estan almacenando las imagenes y mostrar la imagen de la ruta especifica de cada registro -->
                    <img class="img-thumbnail img-fluid" src="{{  asset('storage').'/'.$producto->Foto }}" alt="" width="140">

                    {{ $producto->foto }}
                </td>
                <td>
                    <a href="{{  url('/productos/'.$producto->id.'/edit' ) }}" class="btn btn-warning">
                        Editar
                    </a>


                    <form action="{{ url('/productos/'.$producto->id) }}" class="d-inline" method="post">

                        <!-- llave para controlar el borrado por seguridad -->
                        @csrf
                        <!-- aqui se llama el metodo delete, se entiendete que se comunica por un method post pero se debe agregar el delete que es el qeu se usa para eliminar el registro -->
                        {{ method_field('DELETE') }}
                        <input class="btn btn-danger" type="submit" onclick=" return confirm('¿Esta seguro que desea borrar este producto?')" value="Borrar">
                    </form>
                </td>
            </tr>
            @endforeach

            <tr>
                <td scope="row"></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <!-- opcion para paginación -->
    {!! $productos->links() !!}
</div>
@endsection