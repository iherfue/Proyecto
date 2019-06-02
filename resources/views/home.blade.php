<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <!-- plugins:css -->

    <link rel="stylesheet" href="css_layout_admin/vendor/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous"
    <!-- endinject -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <!-- inject:css -->
    <link rel="stylesheet" href="css_layout_admin/css/style.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="css_layout_admin/mdi/css/materialdesignicons.min.css">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <style type="text/css">
        *{
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex justify-content-center">
            <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                <h4>Área de Gestión</h4>
            </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav navbar-nav-right">

                <li class="nav-item nav-profile dropdown">
                    <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}

                    </a>
                    <div class="dropdown-menu  navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            {{ __('Cerrar Sesión') }}
                    </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                        </form>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/home')}}">
                        <i class="fas fa-home"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="{{url('/solicitar')}}">
                        <i class="fas fa-clipboard-list"></i>
                        <span class="menu-title"> Crear un Pedido</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                        <i class="fas fa-box"></i>
                        <span class="menu-title">Gestión de Pedidos</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{url('/pedidos/pendientes')}}">Pedidos Recientes</a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Pendientes de recoger</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{'/pedidos/recogidos'}}">Pedidos Recogidos</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{url('/pedidos')}}">Finalizar Pedido</a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Pedidos Retrasados</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/productos')}}">
                        <i class="fas fa-archive"></i>
                        <span class="menu-title">Gestión de Productos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/forms/basic_elements.html">
                        <i class="fas fa-bars"></i>
                        <span class="menu-title">Telecentros</span>
                    </a>
                </li><!--
                <li class="nav-item">
                    <a class="nav-link" href="pages/charts/chartjs.html">
                        <i class="mdi mdi-chart-pie menu-icon"></i>
                        <span class="menu-title">Charts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <i class="mdi mdi-grid-large menu-icon"></i>
                        <span class="menu-title">Tables</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages/icons/mdi.html">
                        <i class="mdi mdi-emoticon menu-icon"></i>
                        <span class="menu-title">Icons</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="mdi mdi-account menu-icon"></i>
                        <span class="menu-title">User Pages</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/login-2.html"> Login 2 </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/register-2.html"> Register 2 </a></li>
                            <li class="nav-item"> <a class="nav-link" href="pages/samples/lock-screen.html"> Lockscreen </a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="documentation/documentation.html">
                        <i class="mdi mdi-file-document-box-outline menu-icon"></i>
                        <span class="menu-title">Documentation</span>
                    </a>
                </li>-->
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-end flex-wrap">
                                <div class="mr-md-3 mr-xl-5">
                                    <h2>Bienvenido</h2>

                                        @if($pedidos_dia_siguiente[0]->pedido != '0')
                                            <div class="alert alert-warning"class="alert-link" role="alert">
                                                <strong><p>ATENCIÓN MAÑANA SE RECOGERÁN PEDIDOS, EN TOTAL: {{$pedidos_dia_siguiente[0]->pedido}} CONSULTE <a href="{{url('pedidos/pendientes')}}">AQUÍ</a></p></strong>
                                            </div>
                                        @endif

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body dashboard-tabs p-0">
                                <ul class="nav nav-tabs px-4" role="tablist" style="background-color: #008C95;">
                                    <h4 style="padding: 1%; color: white; margin-top: 10px">Resumen</h4>
                                </ul>
                                <div class="tab-content py-0 px-0">
                                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                        <div class="d-flex flex-wrap justify-content-xl-between">
                                            <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">

                                               <a style="text-decoration: none" href="{{url('pedidos/pendientes')}}"> <div class="d-flex flex-column justify-content-around">
                                                    <h5>Pedidos Recientes</h5>
                                                    <h3><?php print_r($pendientes[0]->Pendientes);?></h3>
                                                </div></a>
                                            </div>
                                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">

                                                <a style="text-decoration: none" href="{{url('pedidos/pendientes/recoger')}}"><div class="d-flex flex-column justify-content-around">
                                                    <h5>Pendientes de Recogida</h5>
                                                    <h3> <?php print_r($pendientes_recoger[0]->Preparado);?></h3>
                                                    </div></a>
                                            </div>
                                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">

                                                <a style="text-decoration: none" href="{{url('pedidos/recogidos')}}"><div class="d-flex flex-column justify-content-around">
                                                    <h5>Pedidos recogidos</h5>
                                                    <h3><?php print_r($recogidos[0]->Recogido);?></h3>
                                                </div></a>
                                            </div>
                                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">

                                               <a href="{{url('/pedidos/retrasados')}}"> <div class="d-flex flex-column justify-content-around">
                                                    <h5>Pedidos retrasados</h5>
                                                    <h3><?php print_r($retrasados[0]->Retrasado);?></h3>
                                                </div></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div id="cantidad" style="width: 450px; height: 250px; margin: 0 auto"></div>
                                <script>
                                    Highcharts.chart('cantidad', {
                                        chart: {
                                            type: 'line'
                                        },
                                        title: {
                                            text: 'Cantidad de Material Solicitado'
                                        },
                                        xAxis: {
                                            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
                                        },
                                        yAxis: {
                                            title: {
                                                text: 'Cantidad'
                                            }
                                        },
                                        plotOptions: {
                                            line: {
                                                dataLabels: {
                                                    enabled: true
                                                },
                                                enableMouseTracking: false
                                            }
                                        },
                                        series: [{
                                            name: '',
                                            data: [{{$cantidad_mes[1][0]->cantidad}},{{$cantidad_mes[2][0]->cantidad}},{{$cantidad_mes[3][0]->cantidad}},{{$cantidad_mes[4][0]->cantidad}},{{$cantidad_mes[5][0]->cantidad}},
                                                {{$cantidad_mes[6][0]->cantidad}},{{$cantidad_mes[7][0]->cantidad}},{{$cantidad_mes[8][0]->cantidad}},{{$cantidad_mes[9][0]->cantidad}},
                                                {{$cantidad_mes[10][0]->cantidad}},{{$cantidad_mes[11][0]->cantidad}},{{$cantidad_mes[12][0]->cantidad}}]
                                        }]
                                    });
                                </script>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div id="porcentaje" style="width: 350px; height: 250px; margin: 0 auto"></div>
                                <script>
                                    Highcharts.chart('porcentaje', {
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'pie'
                                        },
                                        title: {
                                            text: 'Productos más solicitados del mes'
                                        },
                                        tooltip: {
                                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                                    style: {
                                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                    }
                                                }
                                            }
                                        },
                                        series: [{
                                            name: 'Brands',
                                            colorByPoint: true,
                                            data: [
                                                @foreach($porcentaje as $p)
                                                 { name: <?php print_r("'$p->nombre'")?> , y: <?php print_r($p->cantidad)?> },
                                                @endforeach
                                            ]
                                        }]
                                    });
                                </script>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">

            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
</body>
</html>

