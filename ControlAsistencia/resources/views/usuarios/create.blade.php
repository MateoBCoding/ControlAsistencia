@extends('layouts.plantilla')

@section('page_title')
CA-V1 | Crear Usuarios
@endsection

@section('title')
Crear Usuarios
@endsection

@section('content') 
<form id="usuario" class="form-horizontal form-label-left" autocomplete="off" novalidate 
      method="POST" action="{{ url('usuarios')}}">
    @csrf
    <div class="item form-group form_title">
        Formulario Crear Usuario        
    </div>
    
    <div class="separator"></div>
    <div class="container">        
        <div>
        <label for="dispositivosDeVideo">Cámara:</label><br>
        <select name="dispositivosDeVideo" id="dispositivosDeVideo"></select>
        <br><br>
        <video muted="muted" id="video"></video>
        <canvas id="canvas" style="display: none;"></canvas>
        <br><br>
        <p id="duracion"></p>
        <button id="btnDetenerGrabacion">Hacer foto</button>
    </div>
</div>
        <!--    <div class="item form-group">
                <fieldset class="form-group">
                    <div class="row">
                        <div class="form-check radio_check col-md-3 col-sm-3 col-xs-12">
                            <input class="form-check-input col-md-3 col-sm-3 col-xs-12" type="radio" name="radio_select" id="radiosfoto" value="1" checked>
                            <label class="form-check-label col-md-3 col-sm-3 col-xs-12" for="radiosfoto">Seleccionar Foto</label>
                        </div>
                        <div class="form-check radio_check col-md-3 col-sm-3 col-xs-12">
                            <input class="form-check-input col-md-3 col-sm-3 col-xs-12" type="radio" name="radio_select" id="radiotfoto" value="0">
                            <label class="form-check-label col-md-3 col-sm-3 col-xs-12" for="radiotfoto">Tomar Foto</label>
                        </div>
                    </div>
                </fieldset>
            </div>-->
        <div class="separator"></div>



        <div class="item form-group"> 
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id_number">Documento <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="user_id_number" name="user_id_number" type="text"  required="required" 
                       class="form-control col-md-7 col-xs-12 @error('user_id_number') parsley-error @enderror"
                       placeholder="Ingrese Número de Documento" value="{{old('user_id_number')}}">
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
                       placeholder="Ingrese Nombres" value="{{old('first_name')}}">
                @error('first_name')
                <ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">*{{$message}}</li></ul> 
                @enderror
            </div>
        </div>

        <div class="item form-group"> 
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">Placa Vehiculo <span>*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="last_name" name="last_name" type="text" 
                       class="form-control col-md-7 col-xs-12 @error('last_name') parsley-error @enderror"
                       placeholder="Ingrese Placa" value="{{old('last_name')}}">
            </div>
        </div>


        <div class="item form-group"> 
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" name="email" type="text"  required="required" 
                       class="form-control col-md-7 col-xs-12 @error('email') parsley-error @enderror"
                       placeholder="Ingrese Email" value="{{old('email')}}">
                @error('email')
                <ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">*{{$message}}</li></ul> 
                @enderror
            </div>
        </div>
        @if(auth()->user()->getTipo->description == 'operador')
        <div class="item form-group"> 
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_type_id">Tipo Usuario <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control col-md-7 col-xs-12 @error('user_type_id') parsley-error @enderror"
                        style="width: 100%" required="required" name="user_type_id" id="user_type_id" >
                    <option>Seleccione..</option>
                    
                    <option value="1">Usuario</option> 
                   
                </select>
                @error('user_type_id')
                <ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">*{{$message}}</li></ul> 
                @enderror
            </div>
        </div>
        @endif
        @if(auth()->user()->getTipo->description == 'admin')
        <div class="item form-group"> 
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_type_id">Tipo Usuario <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control col-md-7 col-xs-12 @error('user_type_id') parsley-error @enderror"
                        style="width: 100%" required="required" name="user_type_id" id="user_type_id" >
                    <option>Seleccione..</option>
                     @foreach($usersType as $tipo)
                    <option value="{{$tipo->id}}">{{$tipo->description}}</option>                
                    @endforeach
                   
                </select>
                @error('user_type_id')
                <ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">*{{$message}}</li></ul> 
                @enderror
            </div>
        </div>
        @endif
        <div class="item form-group"> 
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_arl_id">ARL <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control col-md-7 col-xs-12 @error('user_arl_id') parsley-error @enderror"
                        style="width: 100%" required="required" name="user_arl_id" id="user_arl_id" >
                    <option>Seleccione..</option>
                    <option value="Alfa">Alfa</option>                
                    <option value="Liberty">Liberty</option>   
                    <option value="Positiva">Positiva</option> 
                    <option value="Colmena">Colmena</option> 
                    <option value="Sura">Sura</option>
                    <option value="La equidad">La equidad</option>
                    <option value="Mapfre">Mapfre</option>
                    <option value="Bolivar">Bolivar</option>
                    <option value="La Aurora">La Aurora</option>
                </select>                
            </div>
        </div>
        @if(auth()->user()->getTipo->description == 'admin')
        <div class="item form-group"> 
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Contraseña <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password" name="password" type="password"  required="required" 
                       class="form-control col-md-7 col-xs-12 @error('password') parsley-error @enderror"
                       placeholder="Ingrese Contraseña" value="{{old('password')}}">
                @error('password')
                <ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">*{{$message}}</li></ul> 
                @enderror
            </div>
        </div>
        @endif
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href="{{url('usuarios')}}" class="btn btn-primary">Cancelar</a> 
                <button class="btn btn-success" id="btnDetenerGrabacion">Guardar</button>
            </div>
        </div>
</form>
@endsection