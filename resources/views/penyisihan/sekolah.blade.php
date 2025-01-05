@extends('templates.templates')
@section('title', 'Sekolah')
@section('sidebar')
@include('templates.subtemplates.penyisihan.sidebar')
@endsection
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">Provinsi {{ $provinsi->nama_provinsi }} / Sekolah</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
      <div class="btn-list">
        <a href="{{ route('penyisihan.provinsi.index') }}" class="btn btn-primary">Kembali</a>
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
                <th>Nama Sekolah</th>
                <th>Group</th>
                <th>Point Per Sesi</th>
                <th>Point</th>
                <th>Berat Point</th>
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
            <label class="form-label required">Nama Sekolah</label>
            <input type="text" class="form-control" name="nama_sekolah" placeholder="Nama Sekolah" required>
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
            <label class="form-label required">Nama Sekolah</label>
            <input type="text" class="form-control" name="nama_sekolah" placeholder="Nama Sekolah" required>
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
    var provinsiId = '{{ $provinsi->id }}';
    
    $(document).ready(function () {

        $('#DataTable').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            searching: true,
            ajax: {
              url: "{{ route('penyisihan.provinsi.sekolah.index', ['provinsiId' => ':provinsiId']) }}".replace(':provinsiId', provinsiId),
              data: function (d) {
                d.provinsiId = provinsiId;
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
                { data: 'nama_sekolah', name: 'nama_sekolah' },
                { data: 'group', name: 'group' },
                { data: 'point_per_sesi', name: 'point_per_sesi', orderable: false, searchable: false },
                { data: 'point', name: 'point' },
                { data: 'berat_point', name: 'berat_point' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

    $('#createForm').on('submit', function (e) {
        e.preventDefault();
        $.LoadingOverlay("show");

        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('penyisihan.provinsi.sekolah.store', ':provinsiId') }}".replace(':provinsiId', provinsiId),
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
        url: "{{ route('penyisihan.provinsi.sekolah.show', [':provinsiId', ':id']) }}".replace(':provinsiId', provinsiId).replace(':id', id),
        method: 'GET',
        success: function (data) {
          $('#editForm [name="nama_sekolah"]').val(data.nama_sekolah);
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
            url: "{{ route('penyisihan.provinsi.sekolah.update', [':provinsiId', ':id']) }}".replace(':provinsiId', provinsiId).replace(':id', id),
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
        var deleteUrl = "{{ route('penyisihan.provinsi.sekolah.destroy', [':provinsiId', ':id']) }}".replace(':provinsiId', provinsiId).replace(':id', id);

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
                    url: deleteUrl,
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

    $(document).on('click', '.setGroup', function () {
      $.LoadingOverlay("show");
      
      const id = $(this).data('id');
      $.ajax({
        url: "{{ route('penyisihan.provinsi.sekolah.set-group', [':provinsiId', ':id']) }}".replace(':provinsiId', provinsiId).replace(':id', id),
        method: 'GET',
        success: function (data) {
          $.LoadingOverlay("hide");

          Swal.fire(
              'Success!',
              data.message,
              'success'
          );
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
    });
  </script>
@endpush