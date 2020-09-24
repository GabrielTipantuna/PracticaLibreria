@extends('layout.app')

@section('titulo')
Libros
@endsection

@section('header')
@endsection

@section('contenido')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
    <img src="https://www.flaticon.es/svg/static/icons/svg/1818/1818696.svg" class="navbar-brand" height="40px" height="40px">
    <h1 style="font-family:Courier New; color:white;">LibOs</h1>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" style="text-align:rigth" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/autor">Autores <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item  active">
        <a class="nav-link" href="/libro">Libros</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/editorial">Editoriales</a>
      </li>
    </ul>
  </div>
</nav>
<br>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Sección de Libros</h1>
        <p class="lead">Crea, modifica o elimina libros.</p>
    </div>
</div>
<div class="card">
    <div class="card-header">
        Autor
    </div>
    <div class="card-body">
        @if(session('status'))
        {!! session('status') !!}
        @endif
        <div class="d-flex justify-content-end">
            <div class="p-2">
                <button id="btnNuevo" type="button" class="btn btn-primary btn-sm">Nuevo</button>
            </div>
        </div>
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Titulo</th>
                    <th>Año Publicación</th>
                    <th>Editorial</th>
                    <th>Precio</th>
                    <th style="width: 15%;">Estado</th>
                    <th style="width: 15%;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($libros as $value)
                <tr>
                    <td class="tdISBN">{{ $value->LivIsbn }}</td>
                    <td class="tdTitulo">{{ $value->LivTitulo }}</td>
                    <td class="tdAnio">{{ $value->LivAnioPublicacion }}</td>
                    <td class="tdEdi" data-ediid = "{{ $value->LivEdiId }}">{{ $value->EdiNombre }}</td>
                    <td class="tdPrecio">{{ $value->LivPrecio }}</td>
                    <td>
                        <div align="center">{!! $value->LivEstadoRegistro == 1 ? '<span class="badge badge-success badge-pill">ACTIVO</span>' : '<span class="badge badge-danger badge-pill">INACTIVO</span>' !!}</div>
                    </td>
                    <td>
                        <div align="center">
                            <button id="btnEditar{{ $value->LivId }}" data-id="{{ $value->LivId }}" type="button" class="btn btn-info btn-sm btn-editar">Editar</button>
                            <button id="btnEliminar{{ $value->LivId }}" data-id="{{ $value->LivId }}" type="button" class="btn btn-danger btn-sm btn-eliminar">Eliminar</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="mdlNuevoEditar" tabindex="-1" aria-labelledby="Crear o Editar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frmNuevoEditar" action="/libro/save" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="h5Titulo">Titulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="hiddenId" name="hiddenId" type="hidden">
                    <div class="form-group">
                        <label for="livIsbn">ISBN</label>
                        <input name="livIsbn" id="livIsbn" type="text" class="form-control form-control-sm" aria-label="Input nombre" aria-describedby="inputGroup-sizing-sm" autocomplete="off" require />
                    </div>
                    <div class="form-group">
                        <label for="livTitulo">Titulo</label>
                        <input name="livTitulo" id="livTitulo" type="text" class="form-control form-control-sm" aria-label="Input nombre" aria-describedby="inputGroup-sizing-sm" autocomplete="off" require />
                    </div>
                    <div class="form-group">
                        <label for="livAnioPublicacion">Año Publicación</label>
                        <input name="livAnioPublicacion" id="livAnioPublicacion" type="text" class="form-control form-control-sm" aria-label="Input nombre" aria-describedby="inputGroup-sizing-sm" autocomplete="off" require />
                    </div>
                    <div class="form-group">
                        <label for="livEdiId">Editorial</label></br>
                        <select name="livEdiId" id="livEdiId" class="custom-select custom-select-sm" require>
                            <option selected disabled value="">Seleccionar...</option>
                            @foreach($editoriales as $value)
                            <option value="{{$value->EdiId}}">{{$value->EdiNombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="aulId">Autores</label></br>
                        <select name="aulId[]" id="aulId" multiple="multiple" style="width: 100%;">
                            <option disabled value="">Seleccionar...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="livPrecio">Precio</label>
                        <input name="livPrecio" id="livPrecio" type="text" class="form-control form-control-sm" aria-label="Input nombre" aria-describedby="inputGroup-sizing-sm" autocomplete="off" require />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button form="frmNuevoEditar" type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlEliminar" tabindex="-1" aria-labelledby="Crear o Editar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frmEliminar" action="/libro/delete" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="h5Titulo">Eliminar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="livId" name="livId" type="hidden">
                    Está seguro de eliminar este registro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button form="frmEliminar" type="submit" class="btn btn-primary btn-sm">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {

        var autores = @json($autores);
        var data = [];
        if (autores.length > 0) {
            $.each(autores, function(index, item) {
                data.push({
                    id: item.AutId,
                    text: item.AutNombres + " " + item.AutApellidos
                });
            });
        }

        $('#aulId').select2({
            theme: 'bootstrap4',
            data: data
        });

        $('.btn-editar').click(function() {
            var tr = $(this).closest('tr');
            $('#h5Titulo').text('EDITAR');
            $('#hiddenId').val($(this).data('id'));
            $('#livIsbn').val(tr.find('.tdISBN').text());
            $('#livTitulo').val(tr.find('.tdTitulo').text());
            $('#livAnioPublicacion').val(tr.find('.tdAnio').text());
            $('#livEdiId').val(tr.find('.tdEdi').data("ediid"));
            $.ajax({
                method: "GET",
                url: "/autores/" + $('#hiddenId').val(),
                success: function(response) {
                    var data = [];
                    if (response.length > 0) {
                        $.each(response, function(index, item) {
                            data.push(item.AutId);
                        });
                    }
                    $("#aulId").val(Object.values(data)).trigger("change");
                }
            });
            $('#livPrecio').val(tr.find('.tdPrecio').text());
            $('#mdlNuevoEditar').modal('show');
        });

        $('.btn-eliminar').click(function() {
            var tr = $(this).closest('tr');
            console.log($(this).data('id'));
            $('#livId').val($(this).data('id'));
            $('#mdlEliminar').modal('show');
        });

        $('#btnNuevo').click(function() {
            $('#h5Titulo').text('NUEVO');
            $('#hiddenId').val('');
            $('#livIsbn').val('');
            $('#livTitulo').val('');
            $('#livAnioPublicacion').val('');
            $('#livEdiId').val('');
            $('#mdlNuevoEditar').modal('show');
        });
    });
</script>
@endsection