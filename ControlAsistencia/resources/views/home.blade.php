@extends('layouts.plantilla')

@section('header')
@endsection

@section('page_title')
CA-V1 | Home
@endsection

@section('title')
Bienvenido
@endsection

@section('content') 
<h2>Panel de Control de Asistencia</h2>
<div>
    @if(auth()->user()->getTipo->description == 'admin')
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count">{{ $total_usuarios }}</div>
                <h3>Usuarios</h3>
                <p>Total usuarios registrados</p>
            </div>
        </div>

        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-hand-o-up"></i></div>
                <div class="count">{{ $total_marcaciones }}</div>
                <h3>Marcaciones</h3>
                <p>Total marcaciones del dia</p>
            </div>
        </div>

    </div>
    <div class="container">
             <div class="consulta">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group date" id="fecha">
                    <input type="text" id="element-find" class="form-control fecha inputFind" value="{{ $hoy }}" />
                    <span class="input-group-addon btnFind">
                        <span class="glyphicon glyphicon-calendar btnFind"></span>                
                    </span>
                    <span class="input-group-btn">
                        <button class="btn btn-default search btnFind" onclick="consulta(1, 0)" type="button">@lang('text.btn_find')</button>
                    </span>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->getTipo->description == 'operador')
        <div class="row top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <div class="count">{{ $total_usuarios }}</div>
                    <h3>Usuarios</h3>
                    <p>Total usuarios registrados operador</p>
                </div>
            </div>

            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-hand-o-up"></i></div>
                    <div class="count">{{ $total_marcaciones }}</div>
                    <h3>Marcaciones</h3>
                    <p>Total marcaciones del dia</p>
                </div>
            </div>

        </div>
        <div class="consulta">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group date" id="fecha">
                    <input type="text" id="element-find" class="form-control fecha inputFind" value="{{ $hoy }}" />
                    <span class="input-group-addon btnFind">
                        <span class="glyphicon glyphicon-calendar btnFind"></span>                
                    </span>
                    <span class="input-group-btn">
                        <button class="btn btn-default search btnFind" onclick="consulta(1, 0)" type="button">@lang('text.btn_find')</button>
                    </span>
                </div>
            </div>
        </div>
        @endif
        <div class="row" style="margin-top: 16px">
            <div class="col-md-12" >
                <table class="table table-striped jambo_table table-hover">
                    <thead>
                        <tr class="headings">  
                            <th class="column-title">#</th>
                            <th class="column-title">Usuario</th>
                            <th class="column-title">Placa</th>
                            <th class="column-title">Fecha</th>
                            <th class="column-title">Tipo Registro</th>    
                        </tr>
                    </thead>
                    <tbody id="_results">
                        @foreach($records as $record)
                        <tr class="even pointer">  
                            <td class=" ">{{$record->id}}</td>
                            <td class=" ">{{$record->first_name}}</td>
                            <td class=" ">{{$record->last_name}}</td>
                            <td class=" ">{{$record->date_record}}</td>
                            <td class=" ">{{$record->type_record}}</td>  
                        </tr>  
                        @endforeach
                    </tbody>
                </table>                  
                <input type="hidden" name="link" id="link" value="home" />
                <input type="hidden" name="show_action" id="show_action" value="N" />
                <input type="hidden" name="fields" id="fields" value="user_id,id,name,date_record,type_record" />
                <div id="pagination_" style="text-align: center">
                    {{$records->links('vendor.pagination.bootstrap-4')}}  
                </div> 
            </div>
        </div>
    </div>
    @endsection