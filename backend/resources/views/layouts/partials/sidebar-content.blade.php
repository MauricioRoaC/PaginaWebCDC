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
            Dashboard
        </a>
    </li>

    <li class="nav-item mb-1">

    @if(Auth::user()->role === 'superadmin')
        {{-- SUPERADMIN: acceso normal --}}
        <a href="{{ route('admin.users.index') }}"
           class="nav-link @if(request()->routeIs('admin.users.*')) active @endif">
            Usuarios
        </a>
    @if(auth()->user()->role === 'superadmin')
    <li class="nav-item mb-1">
    <a href="{{ route('admin.units.index') }}"
       class="nav-link @if(request()->routeIs('admin.units.*')) active @endif">
        Unidades
    </a>
</li>
@endif

    @else
        {{-- ADMIN NORMAL: acceso bloqueado + mensaje de alerta --}}
        <a href="#" class="nav-link user-no-access">
            Usuarios
        </a>
    @endif

</li>

    <li class="nav-item mb-1">
        <a href="{{ route('admin.news.index') }}"
           class="nav-link @if(request()->routeIs('admin.news.*')) active @endif">
            Noticias
        </a>
    </li>
    <li class="nav-item mb-1">
    <a href="{{ route('admin.lives.index') }}"
       class="nav-link @if(request()->routeIs('admin.lives.*')) active @endif">
        Lives
    </a>
</li>
    <li class="nav-item mb-1">
        <a href="{{ route('admin.messages.index') }}"
           class="nav-link @if(request()->routeIs('admin.messages.*')) active @endif">
            Mensajes
        </a>
    </li>

    <li class="nav-item mb-1">
        <a href="{{ route('admin.events.index') }}"
           class="nav-link @if(request()->routeIs('admin.events.*')) active @endif">
            Calendario
        </a>
    </li>

    <li class="nav-item mb-1">
        <a href="{{ route('admin.documents.index') }}"
           class="nav-link @if(request()->routeIs('admin.documents.*')) active @endif">
            Documentos
        </a>
    </li>

    {{-- NUEVOS: Contactos y Categorías de contacto --}}
    <li class="nav-item mb-1">
        <a href="{{ route('admin.contacts.index') }}"
           class="nav-link @if(request()->routeIs('admin.contacts.*')) active @endif">
            Contactos
        </a>
    </li>

    <li class="nav-item mb-1">
        <a href="{{ route('admin.contact-categories.index') }}"
           class="nav-link @if(request()->routeIs('admin.contact-categories.*')) active @endif">
            Categorías de contacto
        </a>
    </li>
@if(auth()->user()->role === 'superadmin')
<li class="nav-item mb-1">
    <a href="{{ route('admin.activity_logs.index') }}"
       class="nav-link @if(request()->routeIs('admin.activity_logs.*')) active @endif">
        Historial
    </a>
</li>
@endif
    <li class="nav-item mb-1">
        <a href="{{ route('admin.profile.edit') }}"
           class="nav-link @if(request()->routeIs('admin.profile.*')) active @endif">
            Perfil
        </a>
    </li>
</ul>

<hr class="text-secondary">

<form action="{{ route('logout') }}" method="POST" class="mt-2">
    @csrf
    <button class="btn btn-sm btn-outline-light w-100">Cerrar sesión</button>
</form>
