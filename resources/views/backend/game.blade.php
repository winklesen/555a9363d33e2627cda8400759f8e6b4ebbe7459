@extends('backend.templates.pages')
@section('title', 'Game')

@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">Game</h2>
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
                <th>Game</th>
                <th>Sekolah</th>
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
          <div class="">
            <label class="form-label required">Provinsi</label>
            <select class="form-select select2" name="provinsi_id" required>
              <option value="" selected disabled>Select</option>
              @foreach($provinsis as $provinsi)
                <option value="{{ $provinsi->id }}">{{ $provinsi->nama_provinsi }}</option>
              @endforeach
            </select>
          </div>
          <div class="mt-3">
            <label class="form-label required">Group A</label>
            <select class="form-select select2" name="group_a" required>
              <option value="" selected disabled>Select</option>
              @foreach($sekolahs as $sekolah)
                <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
              @endforeach
            </select>
          </div>
          <div class="mt-3">
            <label class="form-label required">Group B</label>
            <select class="form-select select2" name="group_b" required>
              <option value="" selected disabled>Select</option>
              @foreach($sekolahs as $sekolah)
                <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
              @endforeach
            </select>
          </div>
          <div class="mt-3">
            <label class="form-label required">Group C</label>
            <select class="form-select select2" name="group_c" required>
              <option value="" selected disabled>Select</option>
              @foreach($sekolahs as $sekolah)
                <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
              @endforeach
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
          <div class="">
            <label class="form-label required">Provinsi</label>
            <select class="form-select select2" name="provinsi_id" required>
              <option value="" selected disabled>Select</option>
              @foreach($provinsis as $provinsi)
                <option value="{{ $provinsi->id }}">{{ $provinsi->nama_provinsi }}</option>
              @endforeach
            </select>
          </div>
          <div class="mt-3">
            <label class="form-label required">Group A</label>
            <select class="form-select select2" name="group_a" required>
              <option value="" selected disabled>Select</option>
              @foreach($sekolahs as $sekolah)
                <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
              @endforeach
            </select>
          </div>
          <div class="mt-3">
            <label class="form-label required">Group B</label>
            <select class="form-select select2" name="group_b" required>
              <option value="" selected disabled>Select</option>
              @foreach($sekolahs as $sekolah)
                <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
              @endforeach
            </select>
          </div>
          <div class="mt-3">
            <label class="form-label required">Group C</label>
            <select class="form-select select2" name="group_c" required>
              <option value="" selected disabled>Select</option>
              @foreach($sekolahs as $sekolah)
                <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
              @endforeach
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
    $(document).ready(function () {
        $('#DataTable').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            searching: true,
            ajax: {
              url: "{{ route('admin.game.index') }}",
              data: function (d) {
                  d.provinsi_id = $('#filterProvinsi').val();
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
                { data: 'provinsi', name: 'provinsi' },
                { data: 'game', name: 'game' },
                { data: 'sekolahs', name: 'sekolahs' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('#filterProvinsi').change(function () {
            $('#DataTable').DataTable().ajax.reload(null, false);
        });
    });

    $('#createForm').on('submit', function (e) {
        e.preventDefault();
        $.LoadingOverlay("show");

        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('admin.game.store') }}",
            method: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                    });

                    $('#createModal').modal('hide');
                    $('#DataTable').DataTable().ajax.reload();
                    $('#createForm')[0].reset();
                }

                $.LoadingOverlay("hide");
            },
            error: function (xhr) {
              $.LoadingOverlay("hide");

              if (xhr.status === 422) {
                  var errors = xhr.responseJSON.errors;
                  var errorMessage = '';
                  $.each(errors, function (key, value) {
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

        setTimeout(function () {
            $.LoadingOverlay("hide");
        }, 10000);
    });

    $(document).on('click', '.edit', function () {
      $.LoadingOverlay("show");
      
      const id = $(this).data('id');

      $.ajax({
        url: "{{ route('admin.game.show', [':id']) }}".replace(':id', id),
        method: 'GET',
        success: function (data) {
          $('#editForm [name="provinsi_id"] option').each(function () {
            if ($(this).val() == data.provinsi_id) {
              $(this).prop('selected', true);
            } else {
              $(this).prop('selected', false);
            }
          });
          $('#editForm [name="group_a"] option').each(function () {
            if ($(this).val() == data.group_a) {
              $(this).prop('selected', true);
            } else {
              $(this).prop('selected', false);
            }
          });
          $('#editForm [name="group_b"] option').each(function () {
            if ($(this).val() == data.group_b) {
              $(this).prop('selected', true);
            } else {
              $(this).prop('selected', false);
            }
          });
          $('#editForm [name="group_c"] option').each(function () {
            if ($(this).val() == data.group_c) {
              $(this).prop('selected', true);
            } else {
              $(this).prop('selected', false);
            }
          });
          $('#editForm').attr('data-id', id);
          $('#editModal').modal('show');
          $.LoadingOverlay("hide");
        }
      });
    });

    $('#editForm').on('submit', function (e) {
        e.preventDefault();
        $.LoadingOverlay("show");

        var formData = $(this).serialize();

        const id = $(this).attr('data-id');

        $('#editForm .text-danger').remove();

        $.ajax({
            url: "{{ route('admin.game.update', [':id']) }}".replace(':id', id),
            method: "PUT",
            data: formData,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                    });

                    $('#editModal').modal('hide');
                    $('#DataTable').DataTable().ajax.reload();
                    $('#editForm')[0].reset();
                }

                $.LoadingOverlay("hide");
            },
            error: function (xhr) {
              $.LoadingOverlay("hide");

              if (xhr.status === 422) {
                  var errors = xhr.responseJSON.errors;
                  var errorMessage = '';
                  $.each(errors, function (key, value) {
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

        setTimeout(function () {
            $.LoadingOverlay("hide");
        }, 10000);
    });

    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');

        var url = "{{ route('admin.game.destroy', [':id']) }}".replace(':id', id);

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Apakah Anda yakin ingin menghapus data dengan id " + id + "? Tindakan ini tidak dapat dibatalkan.",
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
                    success: function (response) {
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
                    error: function (error) {
                        console.log(error)
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