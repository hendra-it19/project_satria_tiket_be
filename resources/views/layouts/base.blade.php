<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Admin | {{ $judulHalaman }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="km. satria, tiket kapa, satria tiket, admin km satria" name="keywords">
    <meta content="dashboard admin untuk mengontrol transaksi penjualan tiket kapal" name="description">

    <!-- Favicon -->
    <link href="{{ asset('logo.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}">
    <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">


        @include('layouts.loading')


        @include('layouts.sidebar')


        <!-- Content Start -->
        <div class="content">


            @include('layouts.topbar')


            <!-- Blank Start -->
            <div class="container-fluid pt-4 px-2" style="min-height: 100vh">
                @yield('pages')
            </div>
            <!-- Blank End -->


            @include('layouts.footer')

        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.extend($.fn.dataTable.defaults, {
                searching: true,
                ordering: false,
            });
            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'colvis',
                        className: 'btn-sm btn-primary',
                    },
                    {
                        extend: 'csv',
                        className: 'btn-sm btn-primary',
                        exportOptions: {
                            columns: ':visible'
                        }

                    },
                    {
                        extend: 'excel',
                        className: 'btn-sm btn-primary',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-sm btn-primary',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],
                initComplete: function() {
                    var btns = $('.btn-secondary');
                    btns.removeClass('btn-secondary');
                },
            });
        });
    </script>
</body>

</html>
