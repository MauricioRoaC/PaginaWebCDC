<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    {{-- Título dinámico por página, con valor por defecto --}}
    <title>@yield('title', 'Panel Administrativo - Comando Cochabamba')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Estilos del panel admin -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
    body {
        min-height: 100vh;
    }
    .sidebar {
        min-height: 100vh;
    }
</style>

    {{-- Estilos extra por página (opcional) --}}
    @stack('styles')
</head>
<body class="bg-light">
{{-- NAVBAR SUPERIOR SOLO EN MÓVIL/TABLET --}}
<nav class="navbar navbar-dark bg-dark d-md-none">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#mobileSidebar"
                aria-controls="mobileSidebar"
                aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="navbar-brand ms-2">
            Panel administrativo
        </span>
    </div>
</nav>

<div class="d-flex">
    {{-- Sidebar --}}
  {{-- SIDEBAR ESCRITORIO (≥ md) --}}
<nav class="sidebar bg-dark text-white p-3 d-none d-md-block" style="width: 240px;">
    @include('layouts.partials.sidebar-content')
</nav>

{{-- SIDEBAR MÓVIL/TABLET (OFFCANVAS) --}}
<div class="offcanvas offcanvas-start bg-dark text-white d-md-none sidebar" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Menú</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    <div class="offcanvas-body p-3">
        @include('layouts.partials.sidebar-content')
    </div>
</div>



    {{-- Contenido principal --}}
    <main class="flex-grow-1 p-4">
        {{-- Mensajes globales de éxito (si quieres usar solo este, quita los de cada vista) --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {

    const noAccessLinks = document.querySelectorAll(".user-no-access");

    noAccessLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();

            // Crear alerta flotante
            const alert = document.createElement("div");
            alert.textContent = "No tienes permiso para gestionar usuarios.";
            alert.style.position = "fixed";
            alert.style.top = "20px";
            alert.style.right = "20px";
            alert.style.background = "#dc3545";
            alert.style.color = "white";
            alert.style.padding = "12px 18px";
            alert.style.borderRadius = "8px";
            alert.style.boxShadow = "0 4px 12px rgba(0,0,0,0.2)";
            alert.style.zIndex = "9999";
            alert.style.opacity = "1"; // aparece INMEDIATAMENTE
            alert.style.transition = "opacity 0.5s ease";

            document.body.appendChild(alert);

            // Esperar EXACTAMENTE 3 segundos antes de desaparecer
            setTimeout(() => {
                alert.style.opacity = "0";

                // Eliminar después de la animación
                setTimeout(() => alert.remove(), 500);

            }, 3000);
        });
    });

});
</script>

{{-- Scripts extra por página (por ejemplo el de Google Maps en contact.html) --}}
@stack('scripts')
</body>
</html>
