<h1>{{ $modo }} producto</h1>
<!-- si hay errores en los campos que se llenan deñl formulario..se imprimirá un mensaje indicando lo que debe rellenar o corregir. -->
@if(count($errors)>0)

<div class="alert alert-danger" role="alert">
    <ul>
        @foreach( $errors->all() as $error)
       <li> {{ $error }} </li>
        @endforeach
    </ul>
</div>

@endif

<div class="form-group">

    <!-- esta es una inclusion -->
    <label for="Nombre">Nombre </label>
    <!-- Se pasa en el value el valor que tiene el registro que es el nombre -->
    <!-- el isset indica que si existe ponga el valor, de lon contrario qeu no ponga nada, ya 
    que se esta usando el mismo formulario para crear y editar, por lo que al momento de editar si no se pone esta función pues arrojará error por qeu 
    estará llamando datos y no es la forma correcta para la función crear -->
    <input type="text" class="form-control" name="Nombre" id="Nombre"
     value="{{isset( $productos->Nombre)?$productos->Nombre:old('Nombre') }}">

</div>

<div class="form-group">

    <label for="Descripcion" ">Descripción </label>
    <input type=" text" class="form-control" name="Descripcion" id="Descripcion"
     value="{{ isset($productos->Descripcion)?$productos->Descripcion:old('Descripcion') }}">

</div>


<div class="form-group">
    <label for="Foto"> </label>
    <!-- si hay una imagen que la muestre si no que no la muestre, esto permite que no cargue ninguna foto en la opcion de crear un nuevo producto -->
    @if(isset($productos->Foto))
    <img class="img-thumbnail img-fluid" src="{{  asset('storage').'/'.$productos->Foto }}" width="110" alt="">
    @endif

    <input type="file" class="form-control" name="Foto" id="Foto" value="">

</div>
<br>

<!-- La opcion [[modo]]]] lo que permite es cambiar el texto del boton a esto se le llama una inclusion de datos
    para que permite modificar el texto del boton en crear,editar y agregar -->
<input class="btn btn-success" type="submit" value=" {{ $modo }}datos ">

<a class="btn btn-primary" href="{{ url('productos/') }} ">Regresar</a>