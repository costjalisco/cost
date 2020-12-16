@extends('front.layouts.app')
@section('title')
Proyecto
@endsection

@section('content')

<style>
    body {
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff;
    }

    .c1 {
        color: #2c4143;
        font-weight: bold;
    }

    .c2 {
        color: #d60000;
        font-weight: bold;
    }

    .c3 {
        color: #ffce32;
        font-weight: bold;
    }

    .c4 {
        color: #61a8bd;
        font-weight: bold;
    }

    .c5 {
        color: #d8d8cd;
        font-weight: bold;
    }


    .my {
        border-top: 1px solid #2c4143;
        border-left: 1px solid #2c4143;
        border-right: 1px solid #2c4143;
        margin-top: 4%;
        height: 100px;
    }

    .my2 {
        border-top: 1px solid #d60000;
        border-left: 1px solid #d60000;
        border-right: 1px solid #d60000;
        margin-top: 4%;
        height: 100px;
    }

    .my3 {
        border-top: 1px solid #ffce32;
        border-left: 1px solid #ffce32;
        border-right: 1px solid #ffce32;
        margin-top: 4%;
        height: 100px;
    }

    .my4 {
        border-top: 1px solid #61a8bd;
        border-left: 1px solid #61a8bd;
        border-right: 1px solid #61a8bd;
        margin-top: 4%;
        height: 100px;
    }

    .my5 {
        border-top: 1px solid #d8d8cd;
        border-left: 1px solid #d8d8cd;
        border-right: 1px solid #d8d8cd;
        margin-top: 4%;
        height: 100px;
    }

    .tlt {
        padding-left: 3.7%;
        padding-top: 3%;
    }

    .f {
        margin-left: 3%;
        margin-right: -1.5%;
    }

    .my2 {
        border-top: 1px solid #d60000;
        border-left: 1px solid #d60000;
        border-right: 1px solid #d60000;
        margin-top: 4%;
        height: 100px;
    }

    .table {
        height: auto;
    }

    .color1 {
        border-left: 5px solid #2c4143;
        margin-top: 4%;
    }

    .color2 {
        border-left: 5px solid #d60000;
        margin-top: 4%;
    }

    .color3 {
        border-left: 5px solid #ffce32;
        margin-top: 4%;
    }

    .color4 {
        border-left: 5px solid #61a8bd;
        margin-top: 4%;
    }

    .color5 {
        border-left: 5px solid #d8d8cd;
        margin-top: 4%;
    }

    .tr1 {
        background-image: url("assets/img/organizations/publico2.png");
        color: #fff;
        font-size: 1em;
    }

    .tr2 {
        background-image: url("assets/img/organizations/academico2.png");
        color: #fff;
        font-size: 1em;
    }

    .tr3 {
        background-image: url("assets/img/organizations/privado2.png");
        color: #fff;
        font-size: 1em;
    }

    .tr4 {
        background-image: url("assets/img/organizations/civil2.png");
        color: #fff;
        font-size: 1em;
    }

    .tr5 {
        background-image: url("assets/img/organizations/estrategico2.png");
        color: #fff;
        font-size: 1em;
    }

    th {
        text-align: center;
    }

    td {
        text-align: center;
    }
    #mural{
       /*
        background-image: url("assets/img/journal/1-mural-logo.png");
        background-repeat: no-repeat;
        height: 1px;
        */
    }
    #mural img{
     
    }
</style>

<div class="container">
    <div class="row my2" style="margin-bottom: 5%;">
        <div class="color2"></div>
        <div class="tlt">
            <h2 class="c2">Notas periodísticas<h2>
        </div>
    </div>
   
    <div class="media" style="margin-left: 8%; margin-bottom:4%;">
        <div id="mural" style="border: 1px solid green; height:112px;"  class="col-md-3">
         <img style="margin-top:10%; margin-left:10%;" src="assets/img/journal/1-mural-logo.png" height="40" alt="">
        </div>
 
  <div class="media-body">
      <div id="titulo" style="margin-top:4%;">
      <h3 style="margin-left:3%">Aperciben a Morena</h3>
      </div>
    
   <div id="url" class="col-md-8" style="background-color: #d8d8cd; height:40px;">
   <div style="padding-top: 1%;"><a  style="margin-left:3%; color:black" target="_blank" href="https://www.mural.com.mx/">https://www.mural.com.mx/</a></div>
        
   </div>
  </div>
</div>

<div class="media" style="margin-left: 8%; margin-bottom:4%;">
        <div style="border: 1px solid green; height:112px;"  class="col-md-3">
        <img style="margin-top:10%; margin-left:10%;" src="assets/img/journal/2-eldiario-logo.png" height="60" alt="">
        </div>
 
  <div class="media-body">
      <div id="titulo" style="margin-top:4%;">
      <h3 style="margin-left:3%">Buscan claridad en obras públicas</h3>
      </div>
    
   <div id="url" class="col-md-8" style="background-color: #d8d8cd; height:40px;">
   <div style="padding-top: 1%;">  <a  style="margin-left:3%; color:black" target="_blank" href="https://ntrguadalajara.com/">https://ntrguadalajara.com/</a></div>
   </div>
  </div>
</div>

<div class="media" style="margin-left: 8%; margin-bottom:4%;">
        <div style="border: 1px solid green; height:112px;"  class="col-md-3">
        <img style="margin-top:12%; margin-left:10%;" src="assets/img/journal/3-cronica-logo.png" height="30" alt="">
        </div>
 
  <div class="media-body">
      <div id="titulo" style="margin-top:4%;">
      <h3 style="margin-left:3%">Buscan transparentar obras en Jalisco</h3>
      </div>
    
   <div id="url" class="col-md-8" style="background-color: #d8d8cd; height:40px;">
   <div style="padding-top: 1%;">   <a  style="margin-left:3%; color:black" target="_blank" href="https://www.cronicajalisco.com">www.cronicajalisco.com</a></div>
   </div>
  </div>
</div>


</div>

<div class="container" style="margin-bottom: 2%;">
<div class="col-md-12 "> 

<div class="d-flex justify-content-end" style="font-size: 20px;">
<div>
<i class="fa fa-reply"></i>
    <span>1 de 3</span>
    <i class="fa fa-share"></i>
</div>
   
</div>

</div>     
</div>


@endsection

@section('scripts')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
    
<script>
    var mymap = L.map('mapid').setView([51.505, -0.09], 13);
</script>
@endsection