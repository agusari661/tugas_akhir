 <!-- Page Wrapper -->
 <div id="wrapper">

     <!-- Sidebar -->
     <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

         <!-- Sidebar - Brand -->
         <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
             <div class="sidebar-brand-icon">
                 <img src="{{ asset('img/logo1.png') }}" alt="" class="logo">
             </div>
             <div class="sidebar-brand-text mx-3">TOKO ARIS DALUNG</div>
         </a>

         <!-- Divider -->
         <hr class="sidebar-divider my-0">

         <!-- Nav Item - Dashboard -->
         <li class="nav-item {{ request()->is(Auth::user()->role . '/dashboard') ? 'active' : '' }}">
             <a class="nav-link" href="{{ route(Auth::user()->role . '.dashboard') }}">
                 <i class="fas fa-fw fa-tachometer-alt"></i>
                 <span>Dashboard</span>
             </a>
         </li>

         <!-- Divider -->
         <hr class="sidebar-divider">



         <!-- Nav Item - Charts -->
         <li class="nav-item">
             <a class="nav-link" href="{{ route('stokbarang.index') }}">
                 <i class="fas fa-fw fa-box"></i>
                 <span>Stok Barang</span></a>
         </li>

         <li class="nav-item">
             <a class="nav-link" href="{{ route('supplier.index') }}">
                 <i class="fas fa-fw fa-users"></i>
                 <span>Data Supplier</span></a>
         </li>

         {{-- <li class="nav-item">
             <a class="nav-link" href="{{ route('barangMasuk.index') }}">
                 <i class="fas fa-fw fa-chart-area"></i>
                 <span>Data Barang Masuk</span></a>
         </li>
         <li class="nav-item">
             <a class="nav-link" href="{{ route('barangKeluar.index') }}">
                 <i class="fas fa-fw fa-chart-area"></i>
                 <span>Data Barang Keluar</span></a>
         </li> --}}
         <li class="nav-item">
             <a class="nav-link" href="{{ route('log.barangkeluar') }}">
                 <i class="fas fa-fw fa-chart-area"></i>
                 <span>Logs Aktivitas Barang</span></a>
         </li>

         <!-- Divider -->
         <hr class="sidebar-divider d-none d-md-block">

         <!-- Heading -->
         <div class="sidebar-heading">
             Pages
         </div>

         <li class="nav-item">
             <a class="nav-link" href="{{ route('profile.eksekutif', Auth::user()->id) }}">
                 <i class="fas fa-fw fa-user"></i>
                 <span>Profile</span></a>
         </li>

         <!-- Divider -->
         <hr class="sidebar-divider">

         <!-- Sidebar Toggler (Sidebar) -->
         <div class="text-center d-none d-md-inline">
             <button class="rounded-circle border-0" id="sidebarToggle"></button>
         </div>

     </ul>
     <!-- End of Sidebar -->

     <!-- Content Wrapper -->
     <div id="content-wrapper" class="d-flex flex-column">

         <!-- Main Content -->
         <div id="content">

             <!-- Topbar -->
             <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                 <!-- Sidebar Toggle (Topbar) -->
                 <form class="form-inline">
                     <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                         <i class="fa fa-bars"></i>
                     </button>
                 </form>

                 <!-- Topbar Navbar -->
                 <ul class="navbar-nav ml-auto">
                     <!-- Nav Item - User Information -->
                     <!-- Nav Item - User Information -->
<li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
            {{ Auth::user()->name ?? '' }}
        </span>
        <img class="img-profile rounded-circle"
            src="{{ $users->profile_picture ? asset('storage/' . $users->profile_picture) : asset('images/default-profile.png') }}">
    </a>

    <!-- Dropdown Menu -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="{{ route('profile.eksekutif', Auth::user()->id) }}">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
        </a>
        <div class="dropdown-divider"></div>

        <!-- Button that opens the modal -->
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw text-gray-400"></i>
            {{ ('Logout') }}
        </a>
    </div>
</li>


                 </ul>

             </nav>
             <!-- End of Topbar -->

             <!-- /.container-fluid -->

             <!-- Begin Page Content -->
             <div>

                 <main class="py-4">
                     @yield('content')
                 </main>

             </div>
             <!-- End of Main Content -->

             <!-- Footer -->
             {{-- <footer class="sticky-footer bg-white">
                 <div class="container my-auto">
                     <div class="copyright text-center my-auto">
                         <span>Copyright &copy; Your Website 2025</span>
                     </div>
                 </div>
             </footer> --}}
             <!-- End of Footer -->

         </div>
         <!-- End of Content Wrapper -->

     </div>
     <!-- End of Page Wrapper -->

     <!-- Scroll to Top Button-->
     <a class="scroll-to-top rounded" href="#page-top">
         <i class="fas fa-angle-up"></i>
     </a>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Pilih "Logout" jika Anda yakin ingin mengakhiri sesi ini.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

                <!-- Submit Form Logout -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

