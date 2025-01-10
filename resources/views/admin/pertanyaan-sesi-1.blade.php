@extends('templates.templates')
@section('title', 'Pertanyaan')
@section('sidebar')
@include('templates.subtemplates.sidebar')
@endsection
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">Provinsi : {{ $tema->provinsi->nama_provinsi }} / Sesi 1 / Tema : {{ Str::limit($tema->tema, 20, '...') }} / Pertanyaan</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
      <div class="btn-list">
        <a href="{{ route('admin.provinsi.sesi-1.tema.index', ['provinsiId' => $tema->provinsi->id]) }}" class="btn btn-primary">Kembali</a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('pages')
<div class="container-xl">
  <div class="row">
    <div class="col-12">
      @include('alert')
      <div class="card">
        <div class="table-responsive p-3">
          <table id="DataTable" class="table table-vcenter card-table table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th>Pertanyaan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="createModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="createForm">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Pertanyaan</label>
            <textarea class="form-control" name="pertanyaan" rows="5" placeholder="Pertanyaan" required></textarea>
          </div>
          <div>
            <label class="form-label required">Jawaban</label>
            <div id="createAnswersContainer">
              <div class="d-flex gap-2 mb-2">
                <input type="text" class="form-control" name="jawabans[]" placeholder="Jawaban" required>
                <button type="button" class="btn btn-danger hapusJawaban">Hapus</button>
              </div>
            </div>
            <button type="button" class="btn btn-primary" id="addCreateAnswer">Tambah</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editForm" data-id="">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Pertanyaan</label>
            <textarea class="form-control" name="pertanyaan" rows="5" placeholder="Pertanyaan" required></textarea>
          </div>
          <div>
            <label class="form-label required">Jawaban</label>
            <div id="editAnswersContainer"></div>
            <button type="button" class="btn btn-primary" id="addEditAnswer">Tambah</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  var provinsiId = '{{ $tema->provinsi->id }}';
  var temaId = '{{ $tema->id }}';
  let deletedAnswerIds = [];
  
  $(document).ready(function () {
      $('#DataTable').DataTable({
          processing: true,
          serverSide: true,
          paging: true,
          searching: true,
          ajax: {
            url: "{{ route('admin.provinsi.sesi-1.tema.pertanyaan.index', ['provinsiId' => ':provinsiId', 'temaId' => ':temaId']) }}".replace(':provinsiId', provinsiId).replace(':temaId', temaId),
            data: function (d) {
              d.provinsiId = provinsiId;
              d.temaId = temaId;
            }
          },
          columns: [
              {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                  return meta.row + 1;
                }
              },
              { data: 'pertanyaan', name: 'pertanyaan' },
              { data: 'action', name: 'action', orderable: false, searchable: false }
          ]
      });

      setInterval(function () {
        $('#DataTable').DataTable().ajax.reload(null, false);
      }, 3000);
  });

  $('#addCreateAnswer').click(function() {
      $('#createAnswersContainer').append(`
          <div class="d-flex gap-2 mb-2">
              <input type="text" class="form-control" name="jawabans[]" placeholder="Jawaban" required>
              <button type="button" class="btn btn-danger hapusJawaban">Hapus</button>
          </div>
      `);
  });

  $('#addEditAnswer').click(function() {
      $('#editAnswersContainer').append(`
          <div class="d-flex gap-2 mb-2">
              <input type="text" class="form-control" name="jawabans[]" placeholder="Jawaban" required>
              <input type="hidden" name="jawaban_ids[]" value="">
              <button type="button" class="btn btn-danger hapusJawaban">Hapus</button>
          </div>
      `);
  });

  $(document).on('click', '.hapusJawaban', function() {
      const answerContainer = $(this).closest('.input-group');
      const answerId = answerContainer.find('input[name="jawaban_ids[]"]').val();
      
      if (answerId) {
          deletedAnswerIds.push(answerId);
      }
      
      answerContainer.remove();
  });

  $('#createForm').on('submit', function(e) {
      e.preventDefault();
      $.LoadingOverlay("show");

      var formData = $(this).serialize();

      $.ajax({
          url: "{{ route('admin.provinsi.sesi-1.tema.pertanyaan.store', [':provinsiId', ':temaId']) }}".replace(':provinsiId', provinsiId).replace(':temaId', temaId),
          method: "POST",
          data: formData,
          success: function(response) {
              if (response.success) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                  });

                  $('#createModal').modal('hide');
                  $('#DataTable').DataTable().ajax.reload();
                  $('#createForm')[0].reset();
                  $('#createAnswersContainer').html(`
                      <div class="d-flex gap-2 mb-2">
                          <input type="text" class="form-control" name="jawabans[]" placeholder="Jawaban" required>
                          <button type="button" class="btn btn-danger hapusJawaban">Hapus</button>
                      </div>
                  `);
              }
              $.LoadingOverlay("hide");
          },
          error: function(xhr) {
              $.LoadingOverlay("hide");
              if (xhr.status === 422) {
                  var errors = xhr.responseJSON.errors;
                  var errorMessage = '';
                  $.each(errors, function(key, value) {
                      errorMessage += value[0] + '\n';
                  });

                  Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: errorMessage,
                  });
              }
          }
      });
  });

  $(document).on('click', '.edit', function() {
      $.LoadingOverlay("show");
      deletedAnswerIds = [];
      const id = $(this).data('id');
      
      $.ajax({
          url: "{{ route('admin.provinsi.sesi-1.tema.pertanyaan.show', [':provinsiId', ':temaId', ':id']) }}".replace(':provinsiId', provinsiId).replace(':temaId', temaId).replace(':id', id),
          method: 'GET',
          success: function(data) {
              $('#editForm [name="pertanyaan"]').val(data.pertanyaan);
              $('#editForm').attr('data-id', id);
              
              $('#editAnswersContainer').empty();
              if (data.jawabans && data.jawabans.length > 0) {
                  data.jawabans.forEach(function(jawaban) {
                      $('#editAnswersContainer').append(`
                          <div class="d-flex gap-2 mb-2">
                              <input type="text" class="form-control" name="jawabans[]" value="${jawaban.jawaban}" placeholder="Jawaban" required>
                              <input type="hidden" name="jawaban_ids[]" value="${jawaban.id}">
                              <button type="button" class="btn btn-danger hapusJawaban">Hapus</button>
                          </div>
                      `);
                  });
              } else {
                  $('#editAnswersContainer').append(`
                      <div class="d-flex gap-2 mb-2">
                          <input type="text" class="form-control" name="jawabans[]" placeholder="Jawaban" required>
                          <input type="hidden" name="jawaban_ids[]" value="">
                          <button type="button" class="btn btn-danger hapusJawaban">Hapus</button>
                      </div>
                  `);
              }
              
              $('#editModal').modal('show');
              $.LoadingOverlay("hide");
          }
      });
  });

  $('#editForm').on('submit', function(e) {
      e.preventDefault();
      $.LoadingOverlay("show");

      const formData = new FormData(this);
      formData.append('deleted_jawaban_ids', JSON.stringify(deletedAnswerIds));

      $.ajax({
          url: "{{ route('admin.provinsi.sesi-1.tema.pertanyaan.update', [':provinsiId', ':temaId', ':id']) }}"
              .replace(':provinsiId', provinsiId)
              .replace(':temaId', temaId)
              .replace(':id', $(this).attr('data-id')),
          method: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
              if (response.success) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                  });

                  $('#editModal').modal('hide');
                  $('#DataTable').DataTable().ajax.reload();
                  $('#editForm')[0].reset();
                  deletedAnswerIds = [];
              }
              $.LoadingOverlay("hide");
          },
          error: function(xhr) {
              $.LoadingOverlay("hide");
              if (xhr.status === 422) {
                  var errors = xhr.responseJSON.errors;
                  var errorMessage = '';
                  $.each(errors, function(key, value) {
                      errorMessage += value[0] + '\n';
                  });

                  Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: errorMessage,
                  });
              }
          }
      });
  });

  $(document).on('click', '.delete', function() {
      var id = $(this).data('id');
      var deleteUrl = "{{ route('admin.provinsi.sesi-1.tema.pertanyaan.destroy', [':provinsiId', ':temaId', ':id']) }}"
          .replace(':provinsiId', provinsiId)
          .replace(':temaId', temaId)
          .replace(':id', id);

      Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Hapus!',
          cancelButtonText: 'Tidak'
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  url: deleteUrl,
                  method: 'DELETE',
                  data: {
                      _token: '{{ csrf_token() }}',
                  },
                  success: function(response) {
                      if (response.success) {
                          Swal.fire(
                              'Success!',
                              'Data berhasil dihapus.',
                              'success'
                          );
                          $('#DataTable').DataTable().ajax.reload();
                      } else {
                          Swal.fire(
                              'Error!',
                              'Terjadi kesalahan. Silakan coba lagi.',
                              'error'
                          );
                      }
                  },
                  error: function(error) {
                      console.log(error);
                      Swal.fire(
                          'Error!',
                          'Terjadi kesalahan. Silakan coba lagi.',
                          'error'
                      );
                  }
              });
          }
      });
  });
</script>
@endpush