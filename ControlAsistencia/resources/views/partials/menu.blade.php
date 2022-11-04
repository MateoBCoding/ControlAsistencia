<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Menú</h3>
        <ul class="nav side-menu">
            <li>
                <a href="{{url('/home')}}"><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>                
            </li>
            @if(auth()->user()->getTipo->description == 'admin')
            <li><a><i class="fa fa-gears"></i> Token <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="javascript:void(0)" onclick="generarToken();" >Generar Token</a></li>                   
                </ul>
            </li>
            <li><a><i class="fa fa-users"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{url('usuarios')}}">Listar Usuarios</a></li>
                    <li><a href="{{url('usuarios/create')}}">Crear Usuarios</a></li>

                </ul>
            </li>
            @endif
            
            @if(auth()->user()->getTipo->description == 'operador')
            <li><a><i class="fa fa-users"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{url('usuarios/create')}}">Crear Usuarios</a></li>
                    <li><a href="{{url('usuarios')}}">Listar Usuarios</a></li>
                </ul>
            </li>
            @endif
            <li><a><i class="fa fa-table"></i> Perfil <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{url('usuarios/'.auth()->user()->id)}}">Ir a mi Perfil</a></li>                   
                </ul>
            </li>          
        </ul>
    </div>  
</div>

