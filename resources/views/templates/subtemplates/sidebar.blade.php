<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark">
      <a href=".">
        <img src="{{ asset('images/logo.png') }}" width="70" height="" alt="" class="img-fluid">
      </a>
    </h1>
    <div class="navbar-nav flex-row d-lg-none">
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <div class="d-none d-xl-block ps-2">
            <div>{{ auth()->user()->email }}</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="" class="dropdown-item">Settings</a>
          <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
        </div>
      </div>
    </div>
    <div class="collapse navbar-collapse" id="sidebar-menu">
      <ul class="navbar-nav pt-lg-3">
        <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.dashboard') ? 'fw-bold' : '' }}" href="{{ route('admin.dashboard') }}" >
          <span class="nav-link-icon d-md-none d-lg-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path></svg>
          </span>
          <span class="nav-link-title">Dashboard</span>
        </a></li>
        @if(auth()->user()->provinsi_id)
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ Route::is('admin.provinsi.*') ? 'show' : '' }}" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path></svg>
              </span>
              <span class="nav-link-title">Provinsi</span>
            </a>
            <div class="dropdown-menu {{ Route::is('admin.provinsi.*') ? 'show' : '' }}">
              <a class="dropdown-item {{ Route::is('admin.provinsi.sekolah.*') ? 'fw-bold' : '' }}" href="{{ route('admin.provinsi.sekolah.index', ['provinsiId' => auth()->user()->provinsi_id]) }}" rel="noopener">Sekolah</a>
              <div class="dropend">
                <a class="dropdown-item dropdown-toggle show" href="#sidebar-authentication" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="true">Sesi</a>
                <div class="dropdown-menu show" data-bs-popper="static">
                  <a href="{{ route('admin.provinsi.sesi-1.tema.index', ['provinsiId' => auth()->user()->provinsi_id]) }}" class="dropdown-item {{ Route::is('admin.provinsi.sesi-1.tema.*') ? 'fw-bold' : '' }}">Sesi 1</a>
                  <a href="{{ route('admin.provinsi.sesi-2.pertanyaan.index', ['provinsiId' => auth()->user()->provinsi_id]) }}" class="dropdown-item {{ Route::is('admin.provinsi.sesi-2.pertanyaan.*') ? 'fw-bold' : '' }}">Sesi 2</a>
                  <a href="{{ route('admin.provinsi.sesi-3.pertanyaan.index', ['provinsiId' => auth()->user()->provinsi_id]) }}" class="dropdown-item {{ Route::is('admin.provinsi.sesi-3.pertanyaan.*') ? 'fw-bold' : '' }}">Sesi 3</a>
                </div>
              </div>
            </div>
          </li>
        @else
          <li class="nav-item {{ Route::is('admin.provinsi.*') ? 'active' : '' }}"><a class="nav-link {{ Route::is('admin.provinsi.*') ? 'fw-bold' : '' }}" href="{{ route('admin.provinsi.index') }}" >
            <span class="nav-link-icon d-md-none d-lg-inline-block"></span>
            <span class="nav-link-title">Provinsi</span>
          </a></li>
        @endif
      </ul>
    </div>
  </div>
</aside>