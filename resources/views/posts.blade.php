<!doctype html>
<html lang="en">
    <head>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Buku || {{$tittle}} </title>
        <style>
            body {
                background-color: lightgray !important;
            }
        </style>
    
        <!-- jQuery first -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
        <!-- DataTables CSS and JS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
        <!-- SweetAlert -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    
<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container">
                <a class="navbar-brand text-white" href="#">CRUD Buku</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        @if (Auth::user()->jabatan == 'admin')
                        <a class="nav-link text-white" href="{{route('/datauser')}}">Data User</a>
                        <a class="nav-link text-white" href="{{route('/databuku')}}">Data Buku</a>
                        @endif
                        @if (Auth::user()->jabatan == 'user')
                        <a class="nav-link text-white" href="{{route('/databuku')}}">Data Buku</a>
                        @endif
                        <a class="btn btn-danger" href="{{route('/logout')}}">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container" style="margin-top: 50px">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-md mt-4">
                    <div class="card-body">
                        @if (Auth::user()->jabatan == 'admin')
                        <a href="javascript:void(0)" class="btn btn-success mb-2" id="btn-create-post">TAMBAH</a>
                        @endif
                        @if (Auth::user()->jabatan == 'user')
                        <h3>Daftar Buku</h3>
                        @endif

                        <table class="table table-bordered table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Buku</th>
                                    <th>Cover</th>
                                    <th>Download</th>
                                    @if (Auth::user()->jabatan == 'admin')
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data buku akan dimuat di sini menggunakan jQuery -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-lg-start bg-primary mt-auto">
        <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2024 Copyright :
            <a class="text-white" href="#">CRUD Buku</a>
        </div>
    </footer>

    @include('components.modal-create')
    @include('components.modal-edit')
    

    <script>
        
    $(document).ready(function() {
    var table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('/databuku') }}",
            type: 'GET',
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'judul_buku', name: 'judul_buku', orderable: true, searchable: true },
            { data: 'cover', name: 'cover',},
            { data: 'download', name: 'download',},
            @if (Auth::user()->jabatan == 'admin')
            { data: 'aksi', name: 'aksi'},
            @endif
        ]
    })

    


    // Event untuk tombol Delete
    $('#myTable').on('click', '.delete', function() {
        var id_buku = $(this).data('id');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Ajax request untuk delete
                $.ajax({
                    url: "/buku/" + id_buku, // Sesuaikan dengan rute delete Anda
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}", // Token CSRF untuk Laravel
                    },
                    success: function(data) {
                        table.ajax.reload(); 
                        Swal.fire(
                            'Terhapus!',
                            'Data buku telah dihapus.',
                            'success'
                        );
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Data buku gagal dihapus.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});

</script>
</body>
</html>
