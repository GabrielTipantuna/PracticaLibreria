<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Autor;
use App\Models\LibroVenta;

class AutorController extends Controller
{
    public function index()
    {
        $autores = Autor::all();
        return view('autor.lista', compact("autores"));
    }

    //Metodo para guardar o actualizar datos
    public function save(Request $request)
    {
        $input = $request->all();
        $mensaje = "";
        try {
            DB::beginTransaction();
            if ($input['hiddenId'] == null) {
                //Crear nuevo registro
                Autor::create(['AutNombres' => $input['autNombres'], 'AutApellidos' => $input['autApellidos']] );
                $mensaje = "<div class=\"alert alert-success\" role=\"alert\">El registro fue creado con éxito.</div>";
            } else {
                //Editar registro
                Autor::find($input['hiddenId'])->update(['AutNombres' => $input['autNombres'], 'AutApellidos' => $input['autApellidos']]);
                $mensaje = "<div class=\"alert alert-success\" role=\"alert\">El registro fue modificado con éxito.</div>";
            }
            DB::commit();
        } catch (\Exception $e) {
            $mensaje = "<div class=\"alert alert-danger\" role=\"alert\">No se pudo " . ($input['hiddenId'] == null ? "crear" : "modificar") . " el registro.</div>";
            DB::rollback();
        }
        return redirect('autor')->with('status', $mensaje);
    }

    public function delete(Request $request)
    {
        $input = $request->all();
        $mensaje = "";
        try {
            if ($input['autId'] != null) {
                Autor::find($input['autId'])->delete();
                $mensaje = "<div class=\"alert alert-success\" role=\"alert\">El registro fue eliminado con éxito.</div>";
            } else {
                $mensaje = "<div class=\"alert alert-danger\" role=\"alert\">El registro no se pudo eliminar.</div>";
            }
        } catch (\Exception $e) {
            $mensaje = "<div class=\"alert alert-danger\" role=\"alert\">El registro no se pudo eliminar.</div>";
        }
        return redirect('autor')->with('status', $mensaje);
    }

    //Pivote para agregar uno o mas autores en un mismo libro
    public function autores($id)
    {
        $autores = LibroVenta::find($id)->autores()->wherePivot('AulEstadoegistro', '=' ,1)->get();
        return $autores;
    }
}

