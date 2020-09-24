<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\LibroVenta;
use App\Models\Editorial;

class LibroVentaController extends Controller
{
    public function index()
    {
        //Mostrar Editorial
        $libros = DB::table('tbllibroventa')
            ->join('tbleditorial', 'tbleditorial.EdiId', 'tbllibroventa.LivEdiId')
            ->select('*')->get();
        $editoriales = Editorial::all();
        $autores = Autor::all();

        return view('libro.lista', compact("libros", "editoriales", "autores"));
    }

    //Metodo para guardar o actualizar datos
    public function save(Request $request)
    {
        $input = $request->all();
        $mensaje = "";
        try {
            DB::beginTransaction();
            $libro = null;
            if ($input['hiddenId'] == null) {
                //Crear nuevo registro
                $libro = LibroVenta::create(['LivIsbn' => $input['livIsbn'], 'LivTitulo' => $input['livTitulo'], 'LivAnioPublicacion' => $input['livAnioPublicacion'], 'LivEdiId' => $input['livEdiId'], 'LivPrecio' => $input['livPrecio']]);
                $mensaje = "<div class=\"alert alert-success\" role=\"alert\">El registro fue creado con éxito.</div>";
            } else {
                //Editar registro
                LibroVenta::find($input['hiddenId'])->update(['LivIsbn' => $input['livIsbn'], 'LivTitulo' => $input['livTitulo'], 'LivAnioPublicacion' => $input['livAnioPublicacion'], 'LivEdiId' => $input['livEdiId'], 'LivPrecio' => $input['livPrecio']]);
                $mensaje = "<div class=\"alert alert-success\" role=\"alert\">El registro fue modificado con éxito.</div>";
            }
            if ($libro == null) {
                $libro = LibroVenta::find($input['hiddenId']);
            }
            if (isset($input['aulId'])) {
                $condicional = [];
                foreach ($input['aulId'] as $key => $value) {
                    $update = $libro->autores()->updateExistingPivot($value, array('AulEstadoRegistro' => 1));
                    if (!$update) {
                        $libro->autores()->attach($value, array('AulEstadoRegistro' => 1));
                    }
                    array_push($condicional, ['tblautorlibroventa.AulAutId', '<>', $value]);
                }
                array_push($condicional, ['tbllibroventa.LivId', '=', $libro->LivId]);
                $libros = DB::table('tblautorlibroventa')
                    ->join('tbllibroventa', 'tbllibroventa.LivId', 'tblautorlibroventa.AulLivId')
                    ->where($condicional)
                    ->select('*')->get();
                foreach ($libros as $key => $value) {
                    LibroVenta::find($value->AulLivId)->autores()->updateExistingPivot($value->AulAutId, array('AulEstadoRegistro' => 0));
                }
            } else {
                $libro->autores()->newPivotStatement()
                    ->where('AulLivId', '=', $libro->LivId)
                    ->update(array('AulEstadoRegistro' => 0));
            }
            DB::commit();
        } catch (\Exception $e) {
            $mensaje = "<div class=\"alert alert-danger\" role=\"alert\">No se pudo " . ($input['hiddenId'] == null ? "crear" : "modificar") . " el registro. " . $e . "</div>";
            DB::rollback();
        }
        return redirect('libro')->with('status', $mensaje);
    }

    //Metodo para eliminar datos
    public function delete(Request $request)
    {
        $input = $request->all();
        $mensaje = "";
        try {
            if ($input['livId'] != null) {
                LibroVenta::find($input['livId'])->delete();
                $mensaje = "<div class=\"alert alert-success\" role=\"alert\">El registro fue eliminado con éxito.</div>";
            } else {
                $mensaje = "<div class=\"alert alert-danger\" role=\"alert\">El registro no se pudo eliminar.</div>";
            }
        } catch (\Exception $e) {
            $mensaje = "<div class=\"alert alert-danger\" role=\"alert\">El registro no se pudo eliminar.</div>";
        }
        return redirect('libro')->with('status', $mensaje);
    }
}
