@extends('layouts.plantilla')

@section('page_title')
CA-V1 | Lista Usuarios
@endsection

@section('title')
Listado de Usuarios
@endsection

@section('content')
<div class="table-responsive">
    <div style="margin-bottom: -10px;">
        <div style="float: left;width: 30%">           
            <a href="usuarios/create" style="font-size: 28px;" 
               data-toggle="tooltip" data-placement="right" 
               title="" data-original-title="Nuevo Usuario">
                <i class="fa fa-plus-circle dark"></i></a>
        </div>
        <div style="float: right;width: 70%">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" id="element-find" class="form-control" placeholder="Buscar..">
                    <span class="input-group-btn">
                        <button class="btn btn-default search" onclick='consulta(1, 0)' type="button">Buscar</button>
                    </span>
                </div>
            </div>
        </div>
    </div> 
    <div>
        <table class="table table-striped jambo_table table-hover">
            <thead>
                <tr class="headings">  
                    <th class="column-title">Documento</th>
                    <th class="column-title">Nombre</th>
                    <th class="column-title">Correo</th>
                    <th class="column-title">Tipo Usuario</th>                           
                    <th class="column-title no-link last"><span class="nobr">Action</span></th>                   
                </tr>
            </thead>
            <tbody id="_results">
                @foreach($users as $user)
                <tr class="even pointer">  
                    <td class=" ">{{$user->user_id_number}}</td>
                    <td class=" ">{{$user->first_name ." ". $user->last_name}}</td>
                    <td class=" ">{{$user->email}}</td>
                    <td class=" ">{{$user->getTipo->description}}</td>                            
                    <td class=" last">
                        <a href="usuarios/{{$user->id}}/finger-list" style="font-size: 15px;margin-left: 7px;color:#03579f;" ><i class="fa fa-hand-o-up"></i></a>
                        @if(auth()->user()->getTipo->description == 'admin')
                        <a href="usuarios/{{$user->id}}/edit" style="font-size: 15px;" ><i class="fa fa-pencil"></i></a>
                        <a href="javascript:void(0)" class="eliminar" 
                           data-titulo="¿Esta seguro de eliminar este registro?"
                           data-id="{{$user->id}}"
                           style="color:#dc3545;margin-left: 5px;font-size: 15px;margin-left: 7px;"
                           data-placement="top"><i class="fa fa-trash"></i>
                        </a> 
                        @endif
                    </td>
                </tr>  
                @endforeach
            </tbody>
        </table>                  
        <input type="hidden" name="link" id="link" value="usuarios" />
        <input type="hidden" name="show_action" id="show_action" value="Y" />
        <input type="hidden" name="fields" id="fields" value="id,user_id_number,name,email,userType" />
        <div id="pagination_" style="text-align: center">
            {{$users->links('vendor.pagination.bootstrap-4')}}  
        </div>            
    </div>
</div>
@endsection