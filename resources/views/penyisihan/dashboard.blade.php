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
<table class="table table-borderless">
  <tbody>
    <tr>
      <td>
        <div id="slot1penyisihan1" class="card border slot-group1">
          <div class="card-body">
            <div>Slot 1 Penyisihan 1</div>
          </div>
        </div>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>
        <div id="slot2penyisihan1" class="card border slot-group1">
          <div class="card-body">
            <div>Slot 2 Penyisihan 1</div>
          </div>
        </div>
      </td>
      <td>
        <div id="slot1penyisihan2" class="card mb-0">
          <div class="card-body">
            <div>Slot 1 Penyisihan 2</div>
          </div>
        </div>
      </td>
      <td></td>
    </tr>
    <tr>
      <td>
        <div id="slot3penyisihan1" class="card border slot-group1">
          <div class="card-body">
            <div>Slot 3 Penyisihan 1</div>
          </div>
        </div>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>
        <div id="slot4penyisihan1" class="card border slot-group2">
          <div class="card-body">
            <div>Slot 4 Penyisihan 1</div>
          </div>
        </div>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>
        <div id="slot5penyisihan1" class="card border slot-group2">
          <div class="card-body">
            <div>Slot 5 Penyisihan 1</div>
          </div>
        </div>
      </td>
      <td>
        <div id="slot2penyisihan2" class="card mb-0">
          <div class="card-body">
            <div>Slot 2 Penyisihan 2</div>
          </div>
        </div>
      </td>
      <td>
        <div id="slot1penyisihan3" class="card mb-0">
          <div class="card-body">
            <div>Slot 1 Penyisihan 3</div>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div id="slot6penyisihan1" class="card border slot-group2">
          <div class="card-body">
            <div>Slot 6 Penyisihan 1</div>
          </div>
        </div>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>
        <div id="slot7penyisihan1" class="card border slot-group3">
          <div class="card-body">
            <div>Slot 7 Penyisihan 1</div>
          </div>
        </div>
      </td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>
        <div id="slot8penyisihan1" class="card border slot-group3">
          <div class="card-body">
            <div>Slot 8 Penyisihan 1</div>
          </div>
        </div>
      </td>
      <td>
        <div id="slot3penyisihan2" class="card mb-0">
          <div class="card-body">
            <div>Slot 3 Penyisihan 2</div>
          </div>
        </div>
      </td>
      <td></td>
    </tr>
    <tr>
      <td>
        <div id="slot9penyisihan1" class="card border slot-group3">
          <div class="card-body">
            <div>Slot 9 Penyisihan 1</div>
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
<script>
  window.onload = function() {
    const slots = {
      group1: document.querySelectorAll('.slot-group1'),
      group2: document.querySelectorAll('.slot-group2'),
      group3: document.querySelectorAll('.slot-group3')
    };
    const slot1penyisihan2 = document.getElementById('slot1penyisihan2');
    const slot2penyisihan2 = document.getElementById('slot2penyisihan2');
    const slot3penyisihan2 = document.getElementById('slot3penyisihan2');
    const slot1penyisihan3 = document.getElementById('slot1penyisihan3');
    const path = document.getElementById('allPaths');
    
    function updatePath() {
      let pathData = '';

      function connectSlots(slots, target) {
        const targetRect = target.getBoundingClientRect();
        const endX = targetRect.left + targetRect.width / 2;
        const endY = targetRect.top + targetRect.height / 2;

        slots.forEach(slot => {
          const slotRect = slot.getBoundingClientRect();
          const startX = slotRect.left + slotRect.width / 2;
          const startY = slotRect.top + slotRect.height / 2;

          const middleX = (startX + endX) / 2;
          const middleY = (startY + endY) / 2;

          if (pathData === '') {
            pathData = `M${startX},${startY} L${middleX},${startY} L${middleX},${endY} L${endX},${endY}`;
          } else {
            pathData += ` M${startX},${startY} L${middleX},${startY} L${middleX},${endY} L${endX},${endY}`;
          }
        });
      }

      connectSlots(slots.group1, slot1penyisihan2);
      connectSlots(slots.group2, slot2penyisihan2);
      connectSlots(slots.group3, slot3penyisihan2);
      connectSlots([slot1penyisihan2, slot2penyisihan2, slot3penyisihan2], slot1penyisihan3);

      path.setAttribute("d", pathData);
    }

    updatePath();
    window.addEventListener('resize', updatePath);
  };
</script>
@endsection
