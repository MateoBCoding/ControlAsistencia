@extends('layouts.plantilla')

@section('page_title')
CA-V1 | Editar Usuarios
@endsection

@section('title')
Editar Usuarios
@endsection

@section('content') 
<form id="usuario" class="form-horizontal form-label-left" autocomplete="off" novalidate 
      method="POST" action="{{ url('usuarios/'.$usuario->id)}}">
    @csrf
    @method('put')
    <div class="item form-group form_title">
        Formulario Editar Usuario        
    </div>
    <div class="separator"></div>
    
     <div class="item form-group"> 
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="foto">Foto <span class="required"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <img src="{{$usuario->url_image}}" style="width: 70px; height: 70px;" />
        </div>
    </div>

    <div class="item form-group"> 
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url_image">Foto <span class="required"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="file" id="url_image" name="url_image" type="text" class="form-control col-md-7 col-xs-12"  accept="image/jpg,image/png" />
        </div>
    </div>

    <div class="item form-group"> 
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id_number">Documento <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="user_id_number" name="user_id_number" type="text"  required="required" 
                   class="form-control col-md-7 col-xs-12 @error('user_id_number') parsley-error @enderror"
                   placeholder="Ingrese Número de Documento" value="{{ $usuario->user_id_number }}">
            @error('user_id_number')
            <ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">*{{$message}}</li></ul> 
            @enderror
        </div>
    </div>

    <div class="item form-group"> 
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Nombres <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="first_name" name="first_name" type="text"  required="required" 
                   class="form-control col-md-7 col-xs-12 @error('first_name') parsley-error @enderror"
                   placeholder="Ingrese Nombres" value="{{ $usuario->first_name }}">
            @error('first_name')
            <ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">*{{$message}}</li></ul> 
            @enderror
        </div>
    </div>

    <div class="item form-group"> 
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">Placa <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="last_name" name="last_name" type="text"  required="required" 
                   class="form-control col-md-7 col-xs-12 @error('last_name') parsley-error @enderror"
                   placeholder="Ingrese Apellidos" value="{{ $usuario->last_name }}">
            @error('last_name')
            <ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">*{{$message}}</li></ul> 
            @enderror
        </div>
    </div>


    <div class="item form-group"> 
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="email" name="email" type="text"  required="required" 
                   class="form-control col-md-7 col-xs-12 @error('email') parsley-error @enderror"
                   placeholder="Ingrese Email" value="{{ $usuario->email }}">
            @error('email')
            <ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">*{{$message}}</li></ul> 
            @enderror
        </div>
    </div>

    <div class="item form-group"> 
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_type_id">Tipo Usuario <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="form-control col-md-7 col-xs-12 @error('user_type_id') parsley-error @enderror"
                    style="width: 100%" required="required" name="user_type_id" id="user_type_id" >
                <option>Seleccione..</option>
                @foreach($usersType as $tipo)
                <option {{ ($usuario->user_type_id == $tipo->id) ? 'selected' : '' }} value="{{$tipo->id}}">{{$tipo->description}}</option>                
                @endforeach
            </select>
            @error('user_type_id')
            <ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">*{{$message}}</li></ul> 
            @enderror
        </div>
    </div>

    <div class="item form-group"> 
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Contraseña <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="password" name="password" type="password"  required="required" 
                   class="form-control col-md-7 col-xs-12 @error('password') parsley-error @enderror"
                   placeholder="Ingrese Contraseña" value="{{ $usuario->password }}">
            @error('password')
            <ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">*{{$message}}</li></ul> 
            @enderror
        </div>
    </div>
    <div class="ln_solid"></div>
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <a href="{{url('usuarios')}}" class="btn btn-primary">Cancelar</a> 
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </div>
</form>
@endsection