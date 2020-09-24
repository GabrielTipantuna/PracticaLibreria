<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Editorial;

class EditorialController extends Controller
{
    public function index()
    {
        $editoriales = Editorial::all();
        return view('editorial.lista', compact("editoriales"));
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
                Editorial::create(['EdiNombre' => $input['ediNombre']]);
                $mensaje = "<div class=\"alert alert-success\" role=\"alert\">El registro fue creado con éxito.</div>";
            } else {
                //Editar registro
                Editorial::find($input['hiddenId'])->update(['EdiNombre' => $input['ediNombre']]);
                $mensaje = "<div class=\"alert alert-success\" role=\"alert\">El registro fue modificado con éxito.</div>";
            }
            DB::commit();
        } catch (\Exception $e) {
            $mensaje = "<div class=\"alert alert-danger\" role=\"alert\">No se pudo " . ($input['hiddenId'] == null ? "crear" : "modificar") . " el registro.</div>";
            DB::rollback();
        }
        return redirect('editorial')->with('status', $mensaje);
    }

    //Metodo para eliminar datos
    public function delete(Request $request)
    {
        $input = $request->all();
        $mensaje = "";
        try {
            if ($input['ediId'] != null) {
                Editorial::find($input['ediId'])->delete();
                $mensaje = "<div class=\"alert alert-success\" role=\"alert\">El registro fue eliminado con éxito.</div>";
            } else {
                $mensaje = "<div class=\"alert alert-danger\" role=\"alert\">El registro no se pudo eliminar.</div>";
            }
        } catch (\Exception $e) {
            $mensaje = "<div class=\"alert alert-danger\" role=\"alert\">El registro no se pudo eliminar.</div>";
        }
        return redirect('editorial')->with('status', $mensaje);
    }
}
