@extends('front.layouts.app')
 
@section('title')
Datos del proyecto
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
@endsection
<meta charset='utf-8'>

@section('content')

<div class="container-fluid pt-4">
    <!-- Section - Descripción General del proyecto -->
    <div class="row mb-5" style="background-color: #d8d8cd;">
        <div class="col-md-3 px-0">
            <img src="{{ asset('/assets/img/project/proyecto-2.jpg') }}" class="img-fluid" alt="">
        </div>
        <div class="col-md-9 px-0">
            <div class="media-body">
                <div id="titleproject" class="col-md-12">
                    <span>{{ $project->title }}</span>
                </div>
                <div id="benefited" class="col-md-12">
                    <div class="row mx-0 align-items-baseline">
                        <img src="{{ asset('/assets/img/project/icons/people.png') }}" class="img-fluid ml-3" width="60"
                            alt="">
                        <label class="ml-3" style="color:#628ea0; font-size: 28px; font-weight: 600;" for="">{{number_format($project->people)}}
                            ciudadanos beneficiados</label>
                    </div>
                    <div class="row mx-0">
                        <div id="btns">
                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                <button onclick="smoothScroll(document.getElementById('datos-generales'))"
                                    class="btn btn-gris btn-sm"
                                    style="background: linear-gradient(90deg, rgba(145,145,145,1) 0%, rgba(136,136,136,1) 100%); ">DATOS
                                    GENERALES</button>
                                <button onclick="smoothScroll(document.getElementById('identificacion'))"
                                    class="btn btn-gris btn-sm"
                                    style="background: linear-gradient(90deg, rgba(135,135,135,1) 0%, rgba(126,126,126,1) 100%);">IDENTIFICACIÓN</button>
                                <button onclick="smoothScroll(document.getElementById('preparacion'))"
                                    class="btn btn-gris btn-sm"
                                    style="background: linear-gradient(90deg, rgba(125,125,125,1) 0%, rgba(115,115,115,1) 100%);">PREPARACIÓN</button>
                                <button onclick="smoothScroll(document.getElementById('contratacion'))"
                                    class="btn btn-gris btn-sm"
                                    style="background: linear-gradient(90deg, rgba(114,114,114,1) 0%, rgba(93,93,93,1) 100%); ">PROCEDIMIENTO
                                    DE CONTRATACIÓN</button>
                                <button onclick="smoothScroll(document.getElementById('ejecucion'))"
                                    class="btn btn-gris btn-sm"
                                    style="background: linear-gradient(90deg, rgba(91,91,91,1) 0%, rgba(83,83,83,1) 100%);">EJECUCIÓN</button>
                                <button onclick="smoothScroll(document.getElementById('finalizacion'))"
                                    class="btn btn-gris btn-sm"
                                    style="background: linear-gradient(90deg, rgba(82,82,82,1) 0%, rgba(73,73,73,1) 100%);">FINALIZACIÓN</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid" id="status">
                    <div class="row pt-2">
                        <div class="col-md-4">
                            <span style="font-size: 22px; font-weight: 700;">Estatus:</span>
                        </div>
                        <div class="col-md-8 d-flex justify-content-end align-items-baseline">
                            <span
                                style="font-size: 26px; font-weight: 700;">100%</span>&nbsp;&nbsp;<span>completado</span>
                        </div>
                    </div>
                </div>
                <div id="line-date-inagurado" class="py-1">
                    <?php 
                    setlocale(LC_ALL, 'es_ES');
                    $date=date_create($project->updated);?>
                    <span style="color: #2C4143"><b>Inagurado:  {{date_format($date,'d/M/Y')}}</b></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section - Mapa de la localización -->
    <div class="row" id="map"></div>

    <!-- Section - Datos generales -->
    <div class="row mt-5" id="datos-generales">
        <div class="col-md-6 background-title px-0 py-1">
            <span style="font-weight: 700; margin-left: 140px;">Datos Generales</span>
        </div>
        <div class="col-md-6 px-0">
            <div class="" style="margin-top: 25px;
            border-bottom: 1px solid #628ea0;"></div>
        </div>
    </div>
    <div class="container">
        <div class="my-5">
            {{ $project->purpose }}
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <img src="{{asset('assets/img/project/icons/pdf.png')}}" class="img-fluid" width="32">
                <?php 
                
                

                ?>
                <a id="pdf1"
                onclick="<?php 
                foreach($identificacion as $doc){
                    echo "funcion('$doc');";
                }
                 ?>"
             
              
                
                class="btn btn-sm btn-documents" style="font-size: 11px;">ABRIR PDF</a>
                
                <script>
                   
                    function funcion(url){
                  
                    var f='{{asset("documents/")}}'+"/"+url;
                    console.log(f);
                    window.open(f);
                    }

                </script>
           
            </div>
        </div>
    </div>

    <!-- Section - Identificación -->
    <div class="row mt-5" id="identificacion">
        <div class="col-md-6 background-title px-0 py-1">
            <span style="font-weight: 700; margin-left: 140px;">Identificación</span>
        </div>
        <div class="col-md-6 px-0">
            <div class="" style="margin-top: 25px;
            border-bottom: 1px solid #628ea0;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 my-2">
            <h3 style="color:#628ea0; font-weight: 700; margin-bottom: 0;" class="ml-4">Responsables del proyecto</h3>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 data mt-4">
                <span><b>Número del acto público, ID.Entidad:</b></span><br>
                <span>DOPI-MUN-R33-DS-CI-055-2019</span><br>
                <span>En el subsector de Servicios</span><br>
                <span><b>Número o números de identificación del estudio del impacto en el terreno y
                        asentamientos:</b></span><br>
                <span>DOC-IMSCO-07</span><br>
            </div>
            <div class="col-md-6 data" style="border-left:1px solid #628ea0;">
                <?php
                $responsables = [];
                $responsables[] = ['name' => 'Lic. José Rodolfo Hernández', 'cargo' => 'Dirección de obras Públicas e Infraestructura de Zapopan, Jalisco.', 'email' => 'rodolfo.berrecil@zapopan.gob.mx'];
                $responsables[] = ['name' => 'Lic. Grabriel Marín Acevedo', 'cargo' => 'Jefe de Departamento B', 'email' => ''];
                $responsables[] = ['name' => 'Arq. José Luis Vázquez Morán', 'cargo' => '', 'email' => 'joseluis.vazquez@zapopan.gob.mx'];
                ?>
                @foreach($responsables as $responsable)
                <br>
                @if($responsable['name']!='')
                <img src="{{ asset('/assets/img/project/icons/people.png') }}" class="img-fluid mx-1" width="22" alt="">
                <span style="font-weight: bold;">{{$responsable['name']}}</span></br>
                @endif
                @if($responsable['cargo']!='')
                <span style="padding-left:34px;">{{$responsable['cargo']}}</span></br>
                @endif
                @if($responsable['email']!='')
                <span style="padding-left:34px;">{{$responsable['email']}}</span><br>
                @endif
                @endforeach
  
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <img src="{{asset('assets/img/project/icons/pdf.png')}}" class="img-fluid" width="32">
                <button class="btn btn-sm btn-documents" style="font-size: 11px;">ABRIR PDF</button>
            </div>
        </div>
    </div>

    <!-- Section - Preparación -->
    <div class="row mt-5" id="preparacion">
        <div class="col-md-6 background-title px-0 py-1">
            <span style="font-weight: 700; margin-left: 140px;">Preparación</span>
        </div>
        <div class="col-md-6 px-0">
            <div class="" style="margin-top: 25px;
            border-bottom: 1px solid #628ea0;"></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5 mb-2">
                <?php
                $adjudicacion = [];
                $impacto_ambiental = [];
                $factibilidad = [];
                $impacto = [];
                $adjudicacion[] = ['nombre' => '', 'email'];
                ?>
                <p>Se realizaron estudios sobre el impacto ambiental, así como estudios de factibilidad y estudios de
                    impacto en terreno y asentamientos, con <br>
                    recursos federales. <br>
                    Con la Unidad de Presupuesto y Contratación
                    de Obra Publica como entidad de ajudicación. </p>
            </div>
            <div class="col-md-12">
                <span style="padding-left:34px;font-size:18px; color:#628ea0; font-weight:bold;">Responsable del
                    contacto de
                    la entidad de adjudicación</span><br>
                <img src="{{ asset('/assets/img/project/icons/people.png') }}" class="img-fluid mx-1" width="22" alt="">
                <span style="font-weight: 700;">Lic. Sandra Patricia Sánchez Váldez</span><br>
                <span style="padding-left:34px; font-weight: 700;">sandra.sanchez@zapopan.gob.mx</span><br><br>
                <span style="padding-left:34px;font-size:18px; color:#628ea0; font-weight:bold;">Responsables de
                    estudios de
                    impacto de terreno</span><br>
                <img src="{{ asset('/assets/img/project/icons/people.png') }}" class="img-fluid mx-1" width="22" alt="">
                <span style="font-weight: 700;">Ingeniería en Mécanica de Suelos y Control de Occidente S.A. de
                    C.V.</span><br><br>
                <span style="padding-left:34px;font-size:18px; color:#628ea0; font-weight:bold;">Responsables de
                    estudios de
                    factibilidad</span><br>
                <img src="{{ asset('/assets/img/project/icons/people.png') }}" class="img-fluid mx-1" width="22" alt="">
                <span style="font-weight: 700;">Tesorería Municipal</span><br><br>
                <span style="padding-left:34px;font-size:18px;color:#628ea0; font-weight:bold;">Responsable del estudio
                    de
                    impacto de terreno y asentamientos</span><br>
                <img src="{{ asset('/assets/img/project/icons/people.png') }}" class="img-fluid mx-1" width="22" alt="">
                <span style="font-weight: 700;">M en C.E. Alonso López Flores</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <img src="{{asset('assets/img/project/icons/pdf.png')}}" class="img-fluid" width="32">
                <button class="btn btn-sm btn-documents" style="font-size: 11px;">ABRIR PDF</button>
            </div>
        </div>
    </div>

    <!-- Section - Procedimiento de contratación -->
    <div class="row mt-5" id="contratacion">
        <div class="col-md-6 background-title px-0 py-1">
            <span style="font-weight: 700; margin-left: 140px;">Procedimiento de contratación</span>
        </div>
        <div class="col-md-6 px-0">
            <div class="" style="margin-top: 25px;
            border-bottom: 1px solid #628ea0;"></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5">
                <?php
                $adjudicacion = [];
                $impacto_ambiental = [];
                $factibilidad = [];
                $impacto = [];
                $adjudicacion[] = ['nombre' => '', 'email'];
                ?>
                <span><b>Tipo de contrato:</b> Obras</span><br>
                <span><b>Modalidad de contratación:</b> Precios unitarios</span><br>
                <span><b>Entidad administradora del contrato:</b>Unidad de Presupuesto y Contratación de Obra
                    Publica</span><br>
                <span><b>Título del contrato:</b> DOPI-MUN-R33-DC-SI-055-2019</span><br>
                <span><b>Vía por la que presenta su propuesta:</b> JUNTA DE APERTURA</span><br>
                <span><b>Monto del contrato (cantidad estipulada):</b>$571857.77</span><br>
                <span><b>Alcance del trabajo según el contrato:</b>REVESTIMIENTO Y SANEAMIENTO DEL CANAL EN LA COLONIA
                    MARIANO OTERO, EN ZAPOPAN</span><br>
                <span><b>Duración del proyecto de acuerdo con lo establecido del contrato:</b> 63 DÍAS</span><br>
            </div>
            <div class="col-md-6">
                <h3 style="color:#628ea0; font-weight: 700; margin-bottom: 0;" class="ml-4">Empresas participantes</h3>
                <?php
                $empresas = [];
                $empresas[] = ['nombre' => 'CONSTRUCCIONES TECNICAS DE OCCIDENTE SA DE CV, CONSTRUCTORA CENTAURO DE INFRAESTRUCTURA SA DE CV, GUILLERMO VARGAS LARA, SALVADOR PANTOJA VACA.'];
                $empresas[] = ['nombre' => 'CONSTRUCCIONES TECNICAS DE OCCIDENTE S.A DE C.V.'];
                ?>
                @foreach($empresas as $empresa)
                <div class="row py-4" style="border-left: 1px solid #628ea0;">
                    <div class="col-md-2">
                        <img src="{{ asset('/assets/img/project/icons/fabrica.png') }}" class="img-fluid mx-1" width="50"
                            alt="">
                    </div>
                    <div class="col-md-10 px-0">
                        <span style="font-weight: 700;">{{ $empresa['nombre'] }}</span><br>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <img src="{{asset('assets/img/project/icons/pdf.png')}}" class="img-fluid" width="32">
                <button class="btn btn-sm btn-documents" style="font-size: 11px;">ABRIR PDF</button>
            </div>
        </div>
    </div>

    <!-- Section - Ejecución -->
    <div class="row mt-5" id="ejecucion">
        <div class="col-md-6 background-title px-0 py-1">
            <span style="font-weight: 700; margin-left: 140px;">Ejecución</span>
        </div>
        <div class="col-md-6 px-0">
            <div class="" style="margin-top: 25px;
            border-bottom: 1px solid #628ea0;"></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5">
                <span><b>Variaciones en el precio del contrato:</b></span><br>
                <span><b>Razones de cambio en el precio del contrato:</b></span><br>
                <span><b>Variaciones en la duración del contrato:</b></span><br>
                <span><b>Razones de cambio en la duración del contrato:</b></span><br>
                <span><b>Variaciones en el alcance del contrato:</b></span><br>
                <span><b>Razones de cambios en el alcance del contrato:</b></span><br>
                <span><b>Aplicación de escalatoria:</b></span><br>
                <span><b>Estado actual del proyecto:</b> Concluído</span><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <img src="{{asset('assets/img/project/icons/pdf.png')}}" class="img-fluid" width="32">
                <button class="btn btn-sm btn-documents" style="font-size: 11px;">ABRIR PDF</button>
            </div>
        </div>
    </div>

    <!-- Section - Finalización -->
    <div class="row mt-5" id="finalizacion">
        <div class="col-md-6 background-title px-0 py-1">
            <span style="font-weight: 700; margin-left: 140px;">Finalización</span>
        </div>
        <div class="col-md-6 px-0">
            <div class="" style="margin-top: 25px;
            border-bottom: 1px solid #628ea0;"></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5">
                <span><b>Costo de finalización:</b></span><br>
                <span><b>Fecha de finalización:</b></span><br>
                <span><b>Alcance de la finalización:</b></span><br>
                <span><b>Razones de cambio en el proyecto:</b></span><br>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row align-items-baseline">
            <div class="col-md-7" style="background-color:#d60000; color:#fff;">
                <div class="d-flex justify-content-end align-items-baseline">
                    <span style="font-size: 26px; font-weight: 700;">100%</span>&nbsp;&nbsp;<span>completado</span>
                </div>
            </div>
            <div class="col-md-3">
                <span style="font-weight: 700;">Inagurada: 15/Ago/2020</span>
            </div>
            <div class="col-md-2 text-right">
                <img src="{{asset('assets/img/project/icons/pdf.png')}}" class="img-fluid" width="32">
                <button class="btn btn-sm btn-documents" style="font-size: 11px;">ABRIR PDF</button>
            </div>
        </div>
    </div>

    <!-- Barra - Resumen -->
    <div class="row" id="background-resumen">
        <div class="col-md-12 d-flex justify-content-center" style="height: auto;">
            <div class="col-md-3 text-center text-white py-3">
                <img src="{{ asset('/assets/img/project/icons/beneficiarios.png') }}" class="img-fluid" width="24" alt="">
                &nbsp<span>Beneficiarios: 569 950 ciudadanos</span>
            </div>
            <div style="height: 1.5em;
            border-left: 1px solid #B0C6CF;" class="mt-3"></div>
            <div class="col-md-3 text-center text-white py-3">
                <img src="{{ asset('/assets/img/project/icons/ubicacion.png') }}" class="img-fluid" width="16" alt="">
                &nbsp<span>Colonia Mariano Otero, Zapopan.</span>
            </div>
            <div style="height: 1.5em;
            border-left: 1px solid #B0C6CF;" class="mt-3"></div>
            <div class="col-md-3 text-center text-white py-3">
                <img src="{{ asset('/assets/img/project/icons/dinero.png') }}" class="img-fluid" width="24" alt="">
                &nbsp<span>Inversión: $571857.77</span>
            </div>
            <div style="height: 1.5em;
            border-left: 1px solid #B0C6CF;" class="mt-3"></div>
        </div>
    </div>

    <!-- Section - Documentos para descargar -->
    <div class="row align-items-center" id="background-docs">
        <div class="col-md-6 text-center my-5">
            <p style="color:#fff;"><strong>¡Descarga los documentos del proyecto!</strong></p>
            <a href="">
                <img src="{{asset('/assets/img/project/icons/clic.png')}}" class="img-fluid" width="50" alt="">
            </a>
        </div>
        <div class="col-md-6 text-center my-5">
            <img src="{{asset('/assets/img/project/icons/excel.png')}}" class="img-fluid" width="100"><br><br>
            <button class="btn btn-sm btn-documents">ABRIR DOCUMENTO XLS</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

<script type="text/javascript">
    // listen for screen resize events
      var zona = 0;
      window.addEventListener('load', function(event){

            var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                          osmAttrib = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                          osm = L.tileLayer(osmUrl, { maxZoom: 14, attribution: osmAttrib });
  
              var map = new L.Map('map', {
                  scrollWheelZoom: false,
                  center: ["20.689742","-103.3928097"],
                  zoom: 14,
                  layers: [osm],
                  
              });
  
            L.marker(["20.689742","-103.3928097"]).addTo(map);

    });
</script>
@endsection
