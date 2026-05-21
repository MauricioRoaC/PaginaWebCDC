{{-- LOGO --}}
<div class="sidebar-logo text-center mb-4">
    <img src="{{ asset('assets/images/logo/logo.svg') }}" alt="Logo Comando Cochabamba">
    <h6 class="mb-0 mt-2">Comando Departamental</h6>
    <small>Cochabamba</small>
</div>

{{-- USUARIO --}}
<div class="sidebar-user text-center mb-4">
    <div class="sidebar-user-avatar mx-auto mb-2">
        <img
            src="{{ Auth::user()->avatar
                    ? asset('storage/' . Auth::user()->avatar)
                    : asset('assets/images/users/user_predeterm.png') }}"
            alt="Foto de perfil"
        >
    </div>

    <div class="sidebar-user-name">
        {{ Auth::user()->name }}
    </div>
    <div class="sidebar-user-role">
        {{ Auth::user()->email }}
    </div>
</div>

{{-- MENÚ --}}
<ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item mb-1">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
           <i class='bx bxs-dashboard'></i>
<span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item mb-1">

    @if(Auth::user()->role === 'superadmin')
        {{-- SUPERADMIN: acceso normal --}}
        <a href="{{ route('admin.users.index') }}"
           class="nav-link @if(request()->routeIs('admin.users.*')) active @endif">
            <i class='bx bx-user'></i>
<span>Usuarios</span>
        </a>
    @if(auth()->user()->role === 'superadmin')
    <li class="nav-item mb-1">
    <a href="{{ route('admin.units.index') }}"
       class="nav-link @if(request()->routeIs('admin.units.*')) active @endif">
        <i class='bx bx-buildings'></i>
<span>Unidades</span>
    </a>
</li>
@endif

    @else
        {{-- ADMIN NORMAL: acceso bloqueado + mensaje de alerta --}}
        <a href="#" class="nav-link user-no-access">
            <i class='bx bx-user'></i>
<span>Usuarios</span>
        </a>
    @endif

</li>

    <li class="nav-item mb-1">
        <a href="{{ route('admin.news.index') }}"
           class="nav-link @if(request()->routeIs('admin.news.*')) active @endif">
            <i class='bx bx-news'></i>
<span>Noticias</span>
        </a>
    </li>
    <li class="nav-item mb-1">
    <a href="{{ route('admin.lives.index') }}"
       class="nav-link @if(request()->routeIs('admin.lives.*')) active @endif">
        <i class='bx bx-broadcast'></i>
<span>Lives</span>
    </a>
</li>
    <li class="nav-item mb-1">
        <a href="{{ route('admin.messages.index') }}"
           class="nav-link @if(request()->routeIs('admin.messages.*')) active @endif">
            <i class='bx bx-message-square-detail'></i>
<span>Mensajes</span>
        </a>
    </li>

    <li class="nav-item mb-1">
        <a href="{{ route('admin.events.index') }}"
           class="nav-link @if(request()->routeIs('admin.events.*')) active @endif">
            <i class='bx bx-calendar'></i>
<span>Calendario</span>
        </a>
    </li>

    <li class="nav-item mb-1">
        <a href="{{ route('admin.documents.index') }}"
           class="nav-link @if(request()->routeIs('admin.documents.*')) active @endif">
            <i class='bx bx-file'></i>
<span>Documentos</span>
        </a>
    </li>

    {{-- NUEVOS: Contactos y Categorías de contacto --}}
    <li class="nav-item mb-1">
        <a href="{{ route('admin.contacts.index') }}"
           class="nav-link @if(request()->routeIs('admin.contacts.*')) active @endif">
            <i class='bx bx-phone'></i>
<span>Contactos</span>
        </a>
    </li>


@if(auth()->user()->role === 'superadmin')
<li class="nav-item mb-1">
    <a href="{{ route('admin.activity_logs.index') }}"
       class="nav-link @if(request()->routeIs('admin.activity_logs.*')) active @endif">
        <i class='bx bx-history'></i>
<span>Historial</span>
    </a>
</li>
@endif
    <li class="nav-item mb-1">
        <a href="{{ route('admin.profile.edit') }}"
           class="nav-link @if(request()->routeIs('admin.profile.*')) active @endif">
            <i class='bx bx-user-circle'></i>
<span>Perfil</span>
        </a>
    </li>
</ul>

<hr class="text-secondary">

<form action="{{ route('logout') }}" method="POST" class="mt-2">
    @csrf
    <button class="btn btn-sm btn-outline-light w-100">Cerrar sesión</button>
</form>
