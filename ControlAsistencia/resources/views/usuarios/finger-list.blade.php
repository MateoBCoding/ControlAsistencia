@extends('layouts.plantilla')

@section('page_title')
CA-V1 | Lista Huellas
@endsection

@section('title')
Listado de Huellas de Usuario: {{ $user->first_name." ".$user->last_name}}
@endsection

@section('content')
<div class="table-responsive">
    <div style="margin-bottom: -10px;">
        <div style="float: left;width: 30%;">
            <a href="javascript:void(0);" style="font-size: 28px;"
               class="new-finger"
               data-id="{{$user->id}}"
               data-toggle="tooltip" data-placement="right"
               title="" data-original-title="Nueva Huella">
                <i class="fa fa-plus-circle dark" ></i>  
            </a>
        </div>
    </div> 
    <div>
        <table class="table table-striped jambo_table table-hover">
            <thead>
                <tr class="headings">  
                    <th class="column-title">#</th>
                    <th class="column-title">Nombre</th>
                    <th class="column-title">Imagen</th>                                    
                    <th class="column-title no-link last"><span class="nobr">Action</span></th>                   
                </tr>
            </thead>
            <tbody id="_results">
                @foreach($fingerList as $finger)
                <tr class="even pointer">  
                    <td class=" ">{{$finger->id}}</td>
                    <td class=" ">{{$finger->finger_name}}</td>
                    <td class=" ">
                        <img src="{{asset("/images/fingerprint_32px.png")}}" alt="imgen huella"
                             style="width: 10%;">
                    </td>                            
                    <td class=" last">                       
                        <a href="javascript:void(0)" class="eliminar" 
                           data-titulo="¿Esta seguro de eliminar esta huella?"
                           data-id="{{$finger->id}}"
                           style="color:#dc3545;margin-left: 5px;font-size: 15px;margin-left: 7px;"
                           data-placement="top"><i class="fa fa-trash"></i>
                        </a> 
                    </td>
                </tr>  
                @endforeach
            </tbody>
        </table>                  
        <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}" />
        <input type="hidden" name="_url" id="_url" value="{{ url()->current()}}" />
        <input type="hidden" name="link" id="link" value="usuarios/{{$user->id}}/delte-finger" />                
    </div>
</div>
@endsection