    <!-- Sidebar Start -->
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-light navbar-light">
            <a href="{{ url('/') }}" class="navbar-brand mx-4 mb-3 text-center">
                <img src="{{ asset('logo.png') }}" alt="logo" width="60px">
                <h4>Satria<span class="text-primary">Tiket</span></h4>
            </a>
            <div class="d-flex align-items-center ms-4 mb-4">
                <hr>
            </div>
            <div class="navbar-nav w-100">

                <a href="{{ url('/') }}" class="nav-item nav-link @if ($judulHalaman == 'Dashboard') active @endif">
                    <i class="fa fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>

                <a href="{{ route('ships.index') }}"
                    class="nav-item nav-link @if ($judulHalaman == 'Kapal') active @endif"><i
                        class="fa fa-ship me-2"></i>Kapal</a>

                <a href="{{ route('schedules.index') }}"
                    class="nav-item nav-link @if ($judulHalaman == 'Jadwal') active @endif"><i
                        class="fas fa-calendar-week me-2"></i>Jadwal</a>

                <a href="{{ route('tickets.index') }}"
                    class="nav-item nav-link @if ($judulHalaman == 'Tiket') active @endif"><i
                        class="fas fa-ticket-alt me-2"></i>Tiket</a>

                <a href="{{ route('transactions.index') }}"
                    class="nav-item nav-link @if ($judulHalaman == 'Transaksi') active @endif"><i
                        class="fas fa-clipboard me-2"></i>Transaksi</a>

                <a href="{{ route('users.index') }}"
                    class="nav-item nav-link @if ($judulHalaman == 'Akun') active @endif"><i
                        class="fa fa-users me-2"></i>Akun</a>

            </div>
        </nav>
    </div>
    <!-- Sidebar End -->
