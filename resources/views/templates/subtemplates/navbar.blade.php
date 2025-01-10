<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none sticky-top">
  <div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-nav flex-row order-md-last">
      <div class="py-0 my-auto">
        <select class="form-select" name="provinsi_id" required>
          <option value="">Semua</option>
        </select>
      </div>
      {{-- <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <div class="ps-2">
            <div>{{ auth()->user()->email }}</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
        </div>
      </div> --}}
    </div>
    <div class="collapse navbar-collapse" id="navbar-menu">
      
    </div>
  </div>
</header>
@push('scripts')
<script>
  $.ajax({
    url: '{{ route('ajax.provinsi') }}',
    method: 'GET',
    success: function(response) {
      const select = $('select[name="provinsi_id"]');

      response.provinsis.forEach(function(provinsi) {
        const selected = provinsi.id === response.user.provinsi_id ? 'selected' : '';
        select.append('<option value="' + provinsi.id + '" ' + selected + '>' + provinsi.nama_provinsi + '</option>');
      });
    }
  });

  $('select[name="provinsi_id"]').change(function() {
    var provinsiId = $(this).val();

    if (provinsiId === "") {
      provinsiId = null;
    }

    $.ajax({
      url: '{{ route('ajax.update-provinsi') }}',
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        provinsi_id: provinsiId
      },
      success: function(response) {
        window.location.href = '{{ route('admin.dashboard') }}';
      },
      error: function(response) {
        console.log(response);
      }
    });
  });
</script>
@endpush