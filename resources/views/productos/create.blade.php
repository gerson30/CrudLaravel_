@extends('layouts.app')

@section('content')
<div class="container">

<form action="{{url('/productos') }}" method="post" enctype="multipart/form-data">
    <!--imprimir llave de seguridad para responder al momento de enviar la informacion al metodo store-->
@csrf

 @include('productos.form',['modo'=>'Crear ']);

</form>
</div>
@endsection