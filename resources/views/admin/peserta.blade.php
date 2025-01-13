@extends('templates.templates')
@section('title', 'Peserta')
@section('sidebar')
@include('templates.subtemplates.sidebar')
@endsection
@section('header')
<div class="container-xl">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title">Provinsi : {{ $sekolah->provinsi->nama_provinsi }} / Sekolah : {{ $sekolah->nama_sekolah }} / Peserta</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
      <div class="btn-list">
        <a href="{{ route('admin.provinsi.sekolah.index', ['provinsiId' => $sekolah->provinsi->id]) }}" class="btn btn-primary">Kembali</a>
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
                <th>Nomor Peserta</th>
                <th>Nama Peserta</th>
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
            <label class="form-label required">Nomor Peserta</label>
            <input type="text" class="form-control number" name="nomor_peserta" placeholder="Nomor Peserta" required>
          </div>
          <div class="">
            <label class="form-label required">Nama Peserta</label>
            <input type="text" class="form-control" name="nama_peserta" placeholder="Nama Peserta" required>
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
            <label class="form-label required">Nomor Peserta</label>
            <input type="text" class="form-control number" name="nomor_peserta" placeholder="Nomor Peserta" required>
          </div>
          <div class="">
            <label class="form-label required">Nama Peserta</label>
            <input type="text" class="form-control" name="nama_peserta" placeholder="Nama Peserta" required>
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
    var provinsiId = '{{ $sekolah->provinsi->id }}';
    var sekolahId = '{{ $sekolah->id }}';
    
    $(document).ready(function () {

        $('#DataTable').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            searching: true,
            ajax: {
              url: "{{ route('admin.provinsi.sekolah.peserta.index', ['provinsiId' => ':provinsiId', 'sekolahId' => ':sekolahId']) }}".replace(':provinsiId', provinsiId).replace(':sekolahId', sekolahId),
              data: function (d) {
                d.provinsiId = provinsiId;
                d.sekolahId = sekolahId;
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
                { data: 'nomor_peserta', name: 'nomor_peserta' },
                { data: 'nama_peserta', name: 'nama_peserta' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        setInterval(function () {
          $('#DataTable').DataTable().ajax.reload(null, false);
        }, 3000);
    });

    $('#createForm').on('submit', function (e) {
        e.preventDefault();
        $.LoadingOverlay("show");

        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('admin.provinsi.sekolah.peserta.store', [':provinsiId', ':sekolahId']) }}".replace(':provinsiId', provinsiId).replace(':sekolahId', sekolahId),
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
        url: "{{ route('admin.provinsi.sekolah.peserta.show', [':provinsiId', ':sekolahId', ':id']) }}".replace(':provinsiId', provinsiId).replace(':sekolahId', sekolahId).replace(':id', id),
        method: 'GET',
        success: function (data) {
          console.log(data)
          $('#editForm [name="nomor_peserta"]').val(data.nomor_peserta);
          $('#editForm [name="nama_peserta"]').val(data.nama_peserta);
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
            url: "{{ route('admin.provinsi.sekolah.peserta.update', [':provinsiId', ':sekolahId', ':id']) }}".replace(':provinsiId', provinsiId).replace(':sekolahId', sekolahId).replace(':id', id),
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
        var deleteUrl = "{{ route('admin.provinsi.sekolah.peserta.destroy', [':provinsiId', ':sekolahId', ':id']) }}".replace(':provinsiId', provinsiId).replace(':sekolahId', sekolahId).replace(':id', id);

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
  </script>
@endpush