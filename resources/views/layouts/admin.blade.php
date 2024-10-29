<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="admin" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  @yield('title')
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{url('logo.webp')}}">

  <!-- preloader css -->
  <link rel="stylesheet" href="{{asset('public/admin/assets/css/preloader.min.css')}}" type="text/css" />

  <!-- Bootstrap Css -->
  <link href="{{asset('public/admin/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
  <!-- Icons Css -->
  <link href="{{ asset('public/admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
  <!-- App Css-->
  <link href="{{ asset('public/admin/assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

  <!-- DataTables -->
  <link href="{{ asset('public/admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('public/admin/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

  <!-- Responsive datatable examples -->
  <link href="{{ asset('public/admin/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />



  <!-- choices css -->
  <link href="{{ asset('public/admin/assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" />

  <!-- color picker css -->
  <link rel="stylesheet" href="{{ asset('public/admin/assets/libs/@simonwep/pickr/themes/classic.min.css')}}" /> <!-- 'classic' theme -->
  <link rel="stylesheet" href="{{ asset('public/admin/assets/libs/@simonwep/pickr/themes/monolith.min.css')}}" /> <!-- 'monolith  -->
  <link rel="stylesheet" href="{{ asset('public/admin/assets/libs/@simonwep/pickr/themes/nano.min.css')}}" /> <!-- 'nano' theme -->

  <!-- datepicker css -->
  <link rel="stylesheet" href="{{ asset('public/admin/assets/libs/flatpickr/flatpickr.min.css')}}">
  
  <!-- Include SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .form-control{
    background-color: #fff !important;
  }
  .form-control:disabled {
    background-color: #f8f9fa !important;
    }
  </style>

</head>

<body>

  <!-- Begin page -->
  <div id="layout-wrapper">

    @include('components.admin.navbar')

    @include('components.admin.left-sidebar')


    @yield('main-section')

  </div>
  <!-- END layout-wrapper -->


  <!-- Right Sidebar -->
  @include ('components.admin.right-sidebar')
  <!-- /Right-bar -->

  <!-- JAVASCRIPT -->

  <!-- JAVASCRIPT -->
  <script>
    var baseUrl = @json(url(''));
</script>

  <script src="{{ asset('public/admin/assets/libs/jquery/jquery.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/metismenu/metisMenu.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/simplebar/simplebar.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/node-waves/waves.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/feather-icons/feather.min.js')}}"></script>
  <!-- pace js -->
  <script src="{{ asset('public/admin/assets/libs/pace-js/pace.min.js')}}"></script>



  <script src="{{ asset('public/admin/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

  <!-- apexcharts init -->
  <script src="{{ asset('public/admin/assets/js/pages/apexcharts.init.js')}}"></script>


  <!-- Required datatable js -->
  <script src="{{ asset('public/admin/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <!-- Buttons examples -->
  <script src="{{ asset('public/admin/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/jszip/jszip.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>

  <!-- Responsive examples -->
  <script src="{{ asset('public/admin/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{ asset('public/admin/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

  <!-- Datatable init js -->
  <script src="{{ asset('public/admin/assets/js/pages/datatables.init.js')}}"></script>

  <!-- App js -->
  <script src="{{ asset('public/admin/assets/js/app.js')}}"></script>
  
  <!-- choices js -->
  <script src="{{ asset('public/admin/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

  <!-- color picker js -->
  <script src="{{ asset('public/admin/assets/libs/@simonwep/pickr/pickr.min.js') }}"></script>
  <script src="{{ asset('public/admin/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

  <!-- datepicker js -->
  <script src="{{ asset('public/admin/assets/libs/flatpickr/flatpickr.min.js') }}"></script>

  <!-- init js -->
  <script src="{{ asset('public/admin/assets/js/pages/form-advanced.init.js') }}"></script>

   <script src="{{ asset('public/js/dependent_dropdown.js') }}"></script>

    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
                        
            // Remove the success message from the session
            {{ session()->forget('success') }};
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            // Remove the error message from the session
            {{ session()->forget('error') }};
        @endif
    });
    </script>   


  <script>
    function capitalizeInput(input) {
        input.value = input.value.toUpperCase();
    }
</script>
<style>
  .table>:not(caption)>*>* {
    padding: 0.5rem 0.5rem !important;
  }
  </style>
</body>

</html>