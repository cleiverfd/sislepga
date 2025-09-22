<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('adminlte/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <div id="user-avatar" class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; color: white; font-weight: bold; font-size: 1rem;">
                </div>
            </div>
            <div class="info">
                <span id="user-name" class="d-block text-white">{{ Str::title(strtolower(Auth::user()->nombre)) }}</span>
            </div>
        </div>
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @can('permiso', 'inicio')
                    <li class="nav-item">
                        <a href="{{ url('/inicio') }}" class="nav-link {{ request()->is('inicio') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-th-large"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                @endcan
                @can('permiso', 'usuarios')
                    <li class="nav-item">
                        <a href="{{ url('/usuarios') }}" class="nav-link {{ request()->is('usuarios*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                @endcan
                @can('permiso', 'expedientes')
                    <li class="nav-item {{ request()->is('expedientes*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('expedientes*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Expedientes
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('/expedientes/civil-laboral') }}" class="nav-link {{ request()->is('expedientes/civil-laboral') || request()->is('expedientes/civil-laboral*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Civil - Laboral</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/expedientes/penal') }}" class="nav-link {{ request()->is('expedientes/penal*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penal</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                            <a href="{{ url('/expedientes/registrar') }}" class="nav-link {{ request()->is('expedientes/registrar*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Arbitral</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/expedientes/registrar') }}" class="nav-link {{ request()->is('expedientes/registrar*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Indecopi</p>
                            </a>
                        </li> --}}
                        </ul>
                    </li>
                @endcan
                @can('permiso', 'procesales')
                    <li class="nav-item">
                        <a href="{{ url('/procesales') }}" class="nav-link {{ request()->is('procesales*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Procesales</p>
                        </a>
                    </li>
                @endcan
                @can('permiso', 'equipo')
                    <li class="nav-item">
                        <a href="{{ url('/equipo') }}" class="nav-link {{ request()->is('equipo*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Equipo</p>
                        </a>
                    </li>
                @endcan
                @can('permiso', 'reportes')
                <li class="nav-item">
                    <a href="{{ url('/reportes') }}" class="nav-link {{ request()->is('reportes*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Reportes</p>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>

</aside>
@push('scripts')
    <script>
        $(document).ready(function() {
            let fullName = $("#user-name").text().trim();
            let parts = fullName.split(" ");

            let initials = parts[0].charAt(0).toUpperCase();
            if (parts.length > 1) {
                initials += parts[1].charAt(0).toUpperCase();
            }

            // Paleta de colores para los gradientes
            let gradients = [
                ["#ff6a00", "#ee0979"], // naranja → rosado
                ["#36d1dc", "#5b86e5"], // celeste → azul
                ["#ff512f", "#dd2476"], // rojo → fucsia
                ["#11998e", "#38ef7d"], // verde oscuro → verde claro
                ["#fc5c7d", "#6a82fb"], // rosado → azul
                ["#f7971e", "#ffd200"], // naranja → amarillo
                ["#56ccf2", "#2f80ed"], // celeste → azul intenso
                ["#8e2de2", "#4a00e0"], // violeta → morado
            ];

            let hash = 0;
            for (let i = 0; i < fullName.length; i++) {
                hash = fullName.charCodeAt(i) + ((hash << 5) - hash);
            }
            let index = Math.abs(hash) % gradients.length;
            let colors = gradients[index];

            $("#user-avatar").css("background", `linear-gradient(135deg, ${colors[0]}, ${colors[1]})`).text(initials);
        });
    </script>
@endpush
