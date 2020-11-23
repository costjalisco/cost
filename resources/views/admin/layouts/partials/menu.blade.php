<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">COST <sup>Jalisco</sup></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Core
  </div>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProject" aria-expanded="true"
      aria-controls="collapseProject">
      <i class="fas fa-fw fa-cog"></i>
      <span>Proyectos</span>
    </a>
    <div id="collapseProject" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('project.index')}}">Proyectos registrados</a>

      </div>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrg" aria-expanded="true"
      aria-controls="collapseOrg">
      <i class="fas fa-fw fa-cog"></i>
      <span>Organizaciones</span>
    </a>
    <div id="collapseOrg" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">

        <a class="collapse-item" href="{{ route('organizations.index')}}">Listado de organizaciones</a>
        <a class="collapse-item" href="{{route('organizations.createRol')}}">Rol organización</a>
      </div>
    </div>
  </li>


  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCat" aria-expanded="true"
      aria-controls="collapseCat">
      <i class="fas fa-fw fa-list"></i>
      <span>Cátalogos</span>
    </a>
    <div id="collapseCat" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">

        <a class="collapse-item" href="{{ route('catalogs.cat_sectors')}}">Sectores/subsectores</a>
        <a class="collapse-item" href="{{route('projecttype.index')}}">Tipo de proyecto</a>
        <a class="collapse-item" href="{{route('catalogs.studies')}}">Estudios</a>
        <a class="collapse-item" href="{{route('resource.index')}}">Origen del recurso</a>
        <a class="collapse-item" href="{{route('adjudication.index')}}">Modalidad de adjudicación</a>
        <a class="collapse-item" href="{{route('contracttype.index')}}">Tipo de contrato</a>
        <a class="collapse-item" href="{{route('contracting.index')}}">Modalidad de contratación</a>
        <a class="collapse-item" href="{{route('contractstatus.index')}}">Estados de contratación</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Contenidos
  </div>

  <!-- Nav Item - News -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('news.index') }}">
      <i class="fas fa-newspaper"></i>
      <span>Noticias</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNewsletter" aria-expanded="true"
      aria-controls="collapseNewsletter">
      <i class="far fa-paper-plane"></i>
      <span>Boletines</span>
    </a>
    <div id="collapseNewsletter" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Secciones</h6>
        <a class="collapse-item" href="{{ route('news.index')}}">
          <span>Listado</span>
        </a>
        <a class="collapse-item" href="{{ route('news.index')}}">
          <span>Suscripctores</span>
        </a>
      </div>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('events.index') }}">
      <i class="far fa-calendar"></i>
      <span>Eventos</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Sistema
  </div>

  <!-- Nav Item - Users -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('users.index') }}">
      <i class="fas fa-users"></i>
      <span>Usuarios</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>