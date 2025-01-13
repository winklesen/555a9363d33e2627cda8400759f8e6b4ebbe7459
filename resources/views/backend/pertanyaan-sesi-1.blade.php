@extends('backend.templates.pages')
@section('title', 'Pertanyaan')
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">Pertanyaan Sesi 1</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
      <div class="btn-list">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('content')
<div class="container-xl">
  <div class="row g-2 mb-2">
    <div class="col-3">
      <select id="filterProvinsi" class="form-select select2">
        <option value="">Semua</option>
        @foreach($provinsis as $provinsi)
          <option value="{{ $provinsi->id }}">{{ $provinsi->nama_provinsi }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-3">
      <select id="filterTema" class="form-select select2">
        <option value="">Semua</option>
        @foreach($temas as $tema)
          <option value="{{ $tema->id }}">{{ $tema->tema }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="table-responsive p-3">
          <table id="DataTable" class="table table-vcenter card-table table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th>Provinsi</th>
                <th>Tema</th>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
                <th>Status Aktif</th>
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
          <div class="mt-3">
            <label class="form-label required">Tema</label>
            <select class="form-select select2" name="tema_id" required>
              <option value="" selected disabled>Select</option>
              @foreach($temas as $tema)
                <option value="{{ $tema->id }}">{{ $tema->provinsi->nama_provinsi }} - {{ $tema->tema }}</option>
              @endforeach
            </select>
          </div>
          <div class="mt-3">
            <label class="form-label required">Pertanyaan</label>
            <textarea class="form-control" name="pertanyaan" rows="5" placeholder="Pertanyaan" required></textarea>
          </div>
          <div class="mt-3">
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
          <div class="mt-3">
            <label class="form-label required">Tema</label>
            <select class="form-select select2" name="tema_id" required>
              <option value="" selected disabled>Select</option>
              @foreach($temas as $tema)
                <option value="{{ $tema->id }}">{{ $tema->provinsi->nama_provinsi }} - {{ $tema->tema }}</option>
              @endforeach
            </select>
          </div>
          <div class="mt-3">
            <label class="form-label required">Pertanyaan</label>
            <textarea class="form-control" name="pertanyaan" rows="5" placeholder="Pertanyaan" required></textarea>
          </div>
          <div class="mt-3">
            <label class="form-label required">Jawaban</label>
            <div id="editAnswersContainer"></div>
            <button type="button" class="btn btn-primary" id="addEditAnswer">Tambah</button>
          </div>
          <div class="mt-3">
            <div class="form-label required">Status Aktif</div>
            <select class="form-select" name="status_aktif" required>
              <option disabled selected value="">Pilih</option>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
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
  let deletedAnswerIds = [];
  
  $(document).ready(function () {
      $('#DataTable').DataTable({
          processing: true,
          serverSide: true,
          paging: true,
          searching: true,
          ajax: {
            url: "{{ route('admin.pertanyaan-sesi-1.index') }}",
            data: function (d) {
                d.provinsi_id = $('#filterProvinsi').val();
                d.tema_id = $('#filterTema').val();
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
              { data: 'provinsi', name: 'provinsi', searchable: false },
              { data: 'tema', name: 'tema', searchable: false },
              { data: 'pertanyaan', name: 'pertanyaan' },
              { data: 'jawaban', name: 'jawaban', searchable: false },
              { data: 'status_aktif', name: 'status_aktif', searchable: false },
              { data: 'action', name: 'action', orderable: false, searchable: false }
          ]
      });

      $('#filterProvinsi').change(function () {
          $('#DataTable').DataTable().ajax.reload(null, false);
      });

      $('#filterTema').change(function () {
          $('#DataTable').DataTable().ajax.reload(null, false);
      });
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
      const answerContainer = $(this).closest('.d-flex');
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
          url: "{{ route('admin.pertanyaan-sesi-1.store') }}",
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
          url: "{{ route('admin.pertanyaan-sesi-1.show', [':id']) }}".replace(':id', id),
          method: 'GET',
          success: function(data) {
              $('#editForm [name="tema_id"] option').each(function () {
                if ($(this).val() == data.tema_id) {
                  $(this).prop('selected', true);
                } else {
                  $(this).prop('selected', false);
                }
              });
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
              $('#editForm [name="status_aktif"] option').each(function () {
                if ($(this).val() == data.status_aktif) {
                  $(this).prop('selected', true);
                } else {
                  $(this).prop('selected', false);
                }
              });
              $('#editModal').modal('show');
              $.LoadingOverlay("hide");
          }
      });
  });

  $('#editForm').on('submit', function(e) {
      e.preventDefault();
      $.LoadingOverlay("show");

      const id = $(this).attr('data-id');

      const formData = new FormData(this);
      formData.append('deleted_jawaban_ids', JSON.stringify(deletedAnswerIds));

      $.ajax({
        url: "{{ route('admin.pertanyaan-sesi-1.update', [':id']) }}".replace(':id', id),
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
      var url = "{{ route('admin.tema.destroy', [':id']) }}".replace(':id', id);

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
                  url: url,
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