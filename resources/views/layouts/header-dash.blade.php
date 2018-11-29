<nav class="navbar navbar-dashboard navbar-static-top  m-b-30">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
                <img src="{{ URL::to('/') }}/images/logo-light-internet-banking.png" alt="">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown menu-pessoal">
                    <a href="#" class="dropdown-toggle" role="button" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>Sobre você</li>
                    </ul>
                </li>

                <li>
                    <a class="btn btn-light" href="{{ route('logout') }}">
                        Encerrar sessão
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>