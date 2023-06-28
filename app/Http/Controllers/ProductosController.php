<?php

namespace App\Http\Controllers;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Productos;

class ProductosController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // consultar la informacion a partir del modelo productos y se toman los primeros 7 registros donde se accedera a traves del index a productos sobre la variable $datos.
        $datos['productos'] = Productos::paginate(5);
        return view('productos.index', $datos);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //darle al controlador información de la vista
        return view('productos.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar los campos con un maximo de lineas
        $campos = [
            "Nombre" => "required|string|max:100",
            "Descripcion" => "required|string|max:200",
            // respetar los formatos de imagen, solo permitirá estos formatos
            'Foto' => 'required|max:10000|mimes:jpeg,png,jpg',
        ];
        // mensaje de alerta si no se ha llenado ningun dato al momento de oprimir el boton crear|} se agrega comodin de atribute por si no tiene ningun nombre entonces se agregara por si solo
        $mensaje = [
            'Nombre.required' => 'El nombre es requerido',
            'Descripcion.required' => 'La descripción es requerido',
            'Foto.required' => 'La foto es requerida'
        ];
        // se unen para validar si todo lo que se envía validará los campos y ademas mostrará los mensajes
        $this->validate($request, $campos, $mensaje);
        //obtener toda la informacion que le enviaron a este metodo, respondera con la variable datosProductos toda la informacion que se envió
        // $datosProductos = request()->all();

        //excepcion para que me quite de los datos que se llaman el token
        $datosProductos = request()->except('_token');
        //si hay una fotografía para qagregar se procederá a alterar ese campo para modificar el nombre del campo y agregarlo a la carpeta que se encuentrea en store->app->public->uploads
        if ($request->hasFile('Foto')) {
            $datosProductos['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }
        return Productos::create($request->all());




        Productos::insert($datosProductos);
        // return response()->json($datosProductos);
        //redireccion a index, el cual obtendra un mensaje
        return redirect('productos')->with('mensaje', 'Producto agregado con exito');
    }



    /**
     * Display the specified resource.
     */
    public function show(Productos $productos)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //recuperar los datos en el update por id guardando en la variable $productos
        $productos = Productos::findOrFail($id);
        //retornar a la vista con la información que está en la variable productos
        return view('productos.edit', compact('productos'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //validar que todos los campos estan  vacios
        $campos = [
            "Nombre" => "required|string|max:100",
            "Descripcion" => "required|string|max:200",
        ];
        // mensaje de alerta si no se ha llenado ningun dato al momento de oprimir el boton crear|} se agrega comodin de atribute por si no tiene ningun nombre entonces se agregara por si solo
        $mensaje = [
            'Nombre.required' => 'El nombre es requerido',
            'Descripcion.required' => 'La descripción es requerido',

        ];
        // el usuario no necesariamente tiene que agregar nuevamente la foto en el update
        if ($request->hasFile('Foto')) {
            $campos = ['Foto' => 'required|max:10000|mimes:jpeg,png,jpg'];
            $mensaje = ['Foto.required' => 'La foto es requerida'];
        }
        // se unen para validar si todo lo que se envía validará los campos y ademas mostrará los mensajes
        $this->validate($request, $campos, $mensaje);


        //se realiza la excepción del token y el metodo PATCH para que no llame esos datos. así mostrará solo Nombre,Descrpción y foto
        $datosProductos = request()->except('_token', '_method');

        //si existen los datos y la foto y si existe pues la va a volver a adjuntar y pasará el nombre nuevo a esa foto o
        if ($request->hasFile('Foto')) {
            //recuperar información
            $productos = Productos::findOrFail($id);
            //hacer borrado de la foto para agregar la nueva del update
            Storage::delete('public/' . $productos->Foto);
            //si hubo el cambio realizar la actualización de la base de datos
            $datosProductos['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        ///si coincide con el id y busca el id que se esta pasando realizará el update que se esta solicitando.
        Productos::where('id', '=', $id)->update($datosProductos);

        // retornar al formulario luego de la actualización;
        $productos = Productos::findOrFail($id);
        // return view('productos.edit', compact('productos'));
        return redirect('productos')->with('mensaje', 'Producto actualizado con exito');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //preguntar cual es la informacion que se esta proporcionando para saber cuales son los registros
        $productos = Productos::findOrFail($id);
        //condicional paara borrar fisicamente desde la url qeu incluye la foto
        if (Storage::delete('public/' . $productos->Foto)) {
            //borrar registro de datos
            Productos::destroy($id);
        }
        return redirect('productos')->with('mensaje', 'Producto eliminado con exito');
    }

    // ---------//---------// metodos para comunicación a la api peubas con POSTMAN//-----------//--------//
    // Get
    public function getProductos()
    {
        return response()->json(Productos::all(), 200);
    }

    public function getProductosById($id)
    {
        $producto = Productos::find($id);
        if (is_null($producto)) {
            return response()->json(['Mensaje' => 'Producto no entcontrado'], 404);
        }
        return response()->json($producto::find($id), 200);
    }


    // POST
    public function addProductos(Request $request)
    {
        $productos = Productos::create($request->all());
        return response($productos, 201);
    }


    // Put Update

    public function updateProductos(Request $request, $id)
    {
        $producto = Productos::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto->Nombre = $request->input('Nombre');
        $producto->Descripcion = $request->input('Descripcion');
        $producto->Foto = $request->input('Foto');
        // Actualizar otros campos del producto según sea necesario

        $producto->save();

        return response()->json($producto, 200);
    }

    // DELETE
    public function deleteProductos(Request $request,$id)
    {
        $producto = Productos::find($id);
        if (is_null($producto)) {
            return response()->json(['Mensaje' => 'Producto no entcontrado'], 404);
        }
        $producto->delete();
        return response()->json(null, 204);
    }
    // 
}
