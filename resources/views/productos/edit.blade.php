
@extends('layouts.app')

@section('content')
<div class="container">
<form action="{{ url('/productos/'.$productos->id) }}" method="post" enctype="multipart/form-data">
@csrf 
<!-- metodo para usar PATCH para que se envíe al controlador Update -->
{{method_field ('PATCH')}}

<!-- La opcion que se agrega, ['modo'=>'editar']) lo que permite es cambiar el texto del boton a esto se le llama una inclusion de datos
para que permite modificar el texto del botn en crear,editar y agregar -->
@include('productos.form', ['modo'=>'Editar ']);


</form>
</div>
@endsection



