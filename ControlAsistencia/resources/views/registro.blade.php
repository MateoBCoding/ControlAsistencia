<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Control de Asistencia | Registro </title>
        <link href="{{asset('images/fingerprint_32px.png')}}" type="image/png" rel="shortcut icon">
        <!-- Bootstrap -->
        <link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{asset('vendors/nprogress/nprogress.css')}}" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="{{asset('/css/custom.min.css')}}" rel="stylesheet">
        <!-- Estilos personalizados -->
        <link href="{{asset('/css/estilos.css')}}" rel="stylesheet">
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="index.html" class="site_title"><i class="fa fa-home"></i> <span>Proveedor logistico!</span></a>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>General</h3>
                                <ul class="nav side-menu">
                                    <li><a><i class="fa fa-key"></i> Login <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{url('login')}}">Inicio de Sesión</a></li>                                           
                                        </ul>
                                    </li>
                                    <li><a><i class="fa fa-edit"></i> Sensor <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="javascript:void(0)" onclick="activeSensorRead(true)">Activar Sensor</a></li>
                                            <li><a href="javascript:void(0)" onclick="closeSensorRead(true)">Desactivar Sensor</a></li>                                            
                                        </ul>
                                    </li>                                   
                                </ul>
                            </div> 
                        </div>
                        <!-- /sidebar menu -->     
                    </div>
                </div>            

                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3>Registrar marcación con número  de identificación <i class="fa fa-hand-o-right"></i></h3>
                            </div>

                            <div class="title_right">
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    <div class="input-group">
                                        <input id="user_id_number" type="text" class="form-control leftRadius" placeholder="Identificacion..">
                                        <span class="input-group-btn">
                                            <button id="register" class="btn btn-default rightRadius" type="button">Registrar</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Registrar marcación con huella dactilar</h2>
                                        <div style=" float: right">
                                            <div class="date">
                                                <span class="colorGray">
                                                    <span class="colorGray" id="weekDay" class="weekDay" ></span>,
                                                    <span class="colorGray" id="day" class="day" ></span> de
                                                    <span class="colorGray" id="month" class="mont" ></span> del
                                                    <span class="colorGray" id="year" class="year" ></span>
                                                </span>
                                            </div>
                                            <div class="clock">                                            
                                                <span class="colorGray"  class="hours" >Hora: </span>
                                                <span class="colorGray" id="hours" class="hours" ></span>:
                                                <span class="colorGray" id="minutes" class="minutes" ></span>:
                                                <span class="colorGray" id="seconds" class="seconds" ></span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="img">
                                            <img class="imgFinger" src="{{asset('images/finger.png')}}" />
                                        </div>
                                        <div class="txtFinger ct2" >----------</div>
                                        <div class="dataUser" >
                                            Identificacion: --------
                                            <br>
                                            Nombre: ----------
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="token" style="display: none;">
                        @csrf
                    </form>
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Control Asistencia V 1.0 
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>
        <script>
         var base_url = "{{Config::get('constants.RUTA_APP')}}";
         var pathname = "{{ url()->current() }}";
        </script>
        <!-- jQuery -->
        <script src="{{asset('vendors/jquery/dist/jquery.min.js')}}"></script>
        <!-- Bootstrap -->
        <script src="{{asset('vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- FastClick -->
        <script src="{{asset('vendors/fastclick/lib/fastclick.js')}}"></script>
        <!-- NProgress -->
        <script src="{{asset('vendors/nprogress/nprogress.js')}}"></script>
        <!-- Custom Theme Scripts -->
        <script src="{{asset('js/custom.min.js')}}"></script>
        <!-- Reloj.js -->
        <script src="{{asset('js/reloj.js')}}"></script>
        <!-- Sweet Alert 2 -->
        <script src="{{asset('js/SweetAlert2.js')}}"></script>
         <!-- Funciones -->
        <script src="{{asset('js/funciones.js')}}"></script>
    </body>
</html>
