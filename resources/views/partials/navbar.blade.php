<nav class="main-header navbar navbar-expand navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li>
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
        </li> -->
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="#" role="button" id="toggle-theme">
                <i class="fas fa-moon" id="theme-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-danger mt-1">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </li>
    </ul>
</nav>
@push('scripts')
<script defer>
    $(document).ready(function() {
        // Cargar el tema guardado
        const savedTheme = localStorage.getItem('theme');

        if (savedTheme === 'dark') {
            $('body').addClass('dark-mode');
            $('#theme-icon').removeClass('fa-moon').addClass('fa-sun');
            $('.main-header .navbar').removeClass('navbar-dark').addClass('navbar-light');
        } else {
            $('body').removeClass('dark-mode');
            $('#theme-icon').removeClass('fa-sun').addClass('fa-moon');
            $('.main-header .navbar').removeClass('navbar-light').addClass('navbar-dark');
        }

        // Evento para cambiar entre los temas
        $('#toggle-theme').on('click', function(e) {
            e.preventDefault();

            // Cambiar el cuerpo al modo oscuro/claro
            $('body').toggleClass('dark-mode');

            // Cambiar el icono
            $('#theme-icon').toggleClass('fa-moon fa-sun');

            // Cambiar la clase de la navbar y guardar estado
            if ($('body').hasClass('dark-mode')) {
                $('.main-header .navbar').removeClass('navbar-dark').addClass('navbar-light');
                localStorage.setItem('theme', 'dark');
            } else {
                $('.main-header .navbar').removeClass('navbar-light').addClass('navbar-dark');
                localStorage.setItem('theme', 'light');
            }
        });
        
    });
</script>
@endpush