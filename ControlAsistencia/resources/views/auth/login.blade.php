<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login | CA V 1.0 </title>
        <link href="{{asset('images/fingerprint_32px.png')}}" type="image/png" rel="shortcut icon">

        <!-- Bootstrap -->
        <link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{asset('/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{asset('/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
        <!-- Animate.css -->
        <link href="{{asset('/vendors/animate.css/animate.min.css')}}" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="{{asset('/css/custom.min.css')}}" rel="stylesheet">
        <!-- Estilos Personalizados -->
        <link href="{{asset('/css/estilos.css')}}" rel="stylesheet">
    </head>

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form id="ingresar" method="POST" action="{{ route('login')}}">
                            @csrf
                            <h1>Inicio de Sesión</h1>
                            <div>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Ingrese Email" required="" value="{{ old('email')}}" />
                            </div>
                            <div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Contaseña" required="" />
                            </div>
                            @error('email')
                            <div class="error_msg">
                                <strong>Error validando el email o la contraseña..!</strong>
                            </div>
                            @enderror
                            <div>
                                <a class="btn btn-default submit" id="validar" href="javascript:void(0)">Iniciar</a>
                                <a class="reset_pass" href="#">Lost your password?</a>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">


                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1><img src="{{asset('/images/fingerprint_32px.png')}}"> Control Asistencia V.1.0</h1>
                                    <p>©2022 All Rights Reserved. Mateo Betancur Gomez</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>               
            </div>
        </div>
        <script src="{{asset('/vendors/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{asset('/js/SweetAlert2.js')}}"></script>
        <script src="{{asset('/js/login.js')}}"></script>
    </body>
</html>
