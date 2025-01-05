@extends('templates.templates')
@section('title', 'Dashboard')
@section('sidebar')
@include('templates.subtemplates.penyisihan.sidebar')
@endsection
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">
        Dashboard
      </h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
      <div class="btn-list">
        
      </div>
    </div>
  </div>
</div>
@endsection
@section('pages')
<style>
  body {
    font-family: sans-serif;
  }

  table {
    width: 100%;
    height: 100%;
    table-layout: fixed;
  }

  td {
    position: relative;
  }

  #connector {
    position: absolute;
    z-index: -1;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }

  path {
    fill: none;
    stroke: #333;
    stroke-width: 4;
    stroke-linecap: round;
  }
</style>
<div class="container-xl">
  <div class="row">
    <div class="col-12">
      <table class="table table-borderless">
        <tbody>
          <tr>
            <td>
              <div id="peserta1penyisihan1" class="card border peserta-group1 penyisihan1group1">
                <div class="card-body">
                  <div>Peserta 1 Penyisihan 1</div>
                </div>
              </div>
            </td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>
              <div id="peserta2penyisihan1" class="card border peserta-group1 penyisihan1group1">
                <div class="card-body">
                  <div>Peserta 2 Penyisihan 1</div>
                </div>
              </div>
            </td>
            <td>
              <div id="peserta1penyisihan2" class="card mb-0 peserta1penyisihan2">
                <div class="card-body">
                  <div>Peserta 1 Penyisihan 2</div>
                </div>
              </div>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <div id="peserta3penyisihan1" class="card border peserta-group1 penyisihan1group1">
                <div class="card-body">
                  <div>Peserta 3 Penyisihan 1</div>
                </div>
              </div>
            </td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>
              <div id="peserta4penyisihan1" class="card border peserta-group2 penyisihan1group2">
                <div class="card-body">
                  <div>Peserta 4 Penyisihan 1</div>
                </div>
              </div>
            </td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>
              <div id="peserta5penyisihan1" class="card border peserta-group2 penyisihan1group2">
                <div class="card-body">
                  <div>Peserta 5 Penyisihan 1</div>
                </div>
              </div>
            </td>
            <td>
              <div id="peserta2penyisihan2" class="card mb-0 peserta2penyisihan2">
                <div class="card-body">
                  <div>Peserta 2 Penyisihan 2</div>
                </div>
              </div>
            </td>
            <td>
              <div id="peserta1penyisihan3" class="card mb-0 peserta1penyisihan3">
                <div class="card-body">
                  <div>Peserta 1 Penyisihan 3</div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div id="peserta6penyisihan1" class="card border peserta-group2 penyisihan1group2">
                <div class="card-body">
                  <div>Peserta 6 Penyisihan 1</div>
                </div>
              </div>
            </td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>
              <div id="peserta7penyisihan1" class="card border peserta-group3 penyisihan1group3">
                <div class="card-body">
                  <div>Peserta 7 Penyisihan 1</div>
                </div>
              </div>
            </td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>
              <div id="peserta8penyisihan1" class="card border peserta-group3 penyisihan1group3">
                <div class="card-body">
                  <div>Peserta 8 Penyisihan 1</div>
                </div>
              </div>
            </td>
            <td>
              <div id="peserta3penyisihan2" class="card mb-0 peserta3penyisihan2">
                <div class="card-body">
                  <div>Peserta 3 Penyisihan 2</div>
                </div>
              </div>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <div id="peserta9penyisihan1" class="card border peserta-group3 penyisihan1group3">
                <div class="card-body">
                  <div>Peserta 9 Penyisihan 1</div>
                </div>
              </div>
            </td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
      <svg id="connector">
        <path id="allPaths"/>
      </svg>
    </div>
  </div>
</div>
<script>
  window.onload = function() {
    const pesertas = {
      group1: document.querySelectorAll('.peserta-group1'),
      group2: document.querySelectorAll('.peserta-group2'),
      group3: document.querySelectorAll('.peserta-group3')
    };
    const peserta1penyisihan2 = document.getElementById('peserta1penyisihan2');
    const peserta2penyisihan2 = document.getElementById('peserta2penyisihan2');
    const peserta3penyisihan2 = document.getElementById('peserta3penyisihan2');
    const peserta1penyisihan3 = document.getElementById('peserta1penyisihan3');
    const path = document.getElementById('allPaths');
    
    function updatePath() {
      let pathData = '';

      function connectPesertas(pesertas, target) {
        const targetRect = target.getBoundingClientRect();
        const endX = targetRect.left + targetRect.width / 2;
        const endY = targetRect.top + targetRect.height / 2;

        pesertas.forEach(peserta => {
          const pesertaRect = peserta.getBoundingClientRect();
          const startX = pesertaRect.left + pesertaRect.width / 2;
          const startY = pesertaRect.top + pesertaRect.height / 2;

          const middleX = (startX + endX) / 2;
          const middleY = (startY + endY) / 2;

          if (pathData === '') {
            pathData = `M${startX},${startY} L${middleX},${startY} L${middleX},${endY} L${endX},${endY}`;
          } else {
            pathData += ` M${startX},${startY} L${middleX},${startY} L${middleX},${endY} L${endX},${endY}`;
          }
        });
      }

      connectPesertas(pesertas.group1, peserta1penyisihan2);
      connectPesertas(pesertas.group2, peserta2penyisihan2);
      connectPesertas(pesertas.group3, peserta3penyisihan2);
      connectPesertas([peserta1penyisihan2, peserta2penyisihan2, peserta3penyisihan2], peserta1penyisihan3);

      path.setAttribute("d", pathData);
    }

    updatePath();
    window.addEventListener('resize', updatePath);
  };
</script>
@endsection
