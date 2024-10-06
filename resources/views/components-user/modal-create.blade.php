<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH POST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="username_user" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username_user" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-username_user"></div>
                </div>

                <div class="form-group">
                    <label for="password1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password1" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-password1"></div>
                </div>

                <div class="form-group">
                    <label for="password2" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password2" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-password2"></div>
                </div>

                <div class="form-group">
                    <label for="nama_user" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama_user" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_user"></div>
                </div>
                <div class="form-group">
                    <label for="alamat_user" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat_user" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat_user"></div>
                </div>
                <div class="form-group">
                    <label for="nomor_telp" class="form-label">Nomor Telepon</label>
                    <input type="number" class="form-control" id="nomor_telp" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nomor_telp"></div>
                </div>

                <div class="form-group">
                    <select name="jabatan" id="jabatan">
                        <option selected>--Pilih--</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                      </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('body').on('click', '#btn-create-post', function () {
        //open modal
        $('#modal-create').modal('show');
    });

   // action create post
$('#store').click(function(e) {
    e.preventDefault();

    let username = $('#username_user').val();
    let password1 = $('#password1').val();
    let password2 = $('#password2').val();
    let nama = $('#nama_user').val();
    let alamat = $('#alamat_user').val();
    let telp = $('#nomor_telp').val();
    let jabatan = $('#jabatan').val();
    let token = $("meta[name='csrf-token']").attr("content");

    // Clear previous error messages
    $('.alert-danger').addClass('d-none').html('');

    // Check if passwords match
    if (password1 !== password2) {
        $('#alert-password1').removeClass('d-none').addClass('d-block').html('Passwords do not match!');
        return; // Stop the form from submitting if passwords don't match
    }

    // Create FormData object
    let formData = new FormData();
    formData.append("username_user", username);
    formData.append("password_user", password2); // Use password2 for submission
    formData.append("nama_user", nama);
    formData.append("alamat_user", alamat);
    formData.append("nomor_telp", telp);
    formData.append("jabatan", jabatan);
    formData.append("_token", token);



    // Perform the AJAX request
    $.ajax({
        url: `/user`,
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function (response) {
            Swal.fire({
                type: 'success',
                icon: 'success',
                title: 'Berhasil DiTambahkan',
                showConfirmButton: false,
                timer: 3000
            });

            $('#myTable').DataTable().ajax.reload(null, false);

            let post = `
                <tr id="index_${response.data.id_user}">
                    <td>${response.data.username_user}</td>
                    <td>${response.data.nama_user}</td>
                    <td>${response.data.alamat_user}</td>
                    <td>${response.data.nomor_telp}</td>
                    <td>${response.data.jabatan}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id_user}" class="btn btn-primary btn-sm">EDIT</a>
                        <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id_user}" class="btn btn-danger btn-sm">DELETE</a>
                    </td>
                </tr>
            `;
            $('#table-posts').prepend(post);
            $('#modal-create').modal('hide');
        },
        error: function (error) {
            if (error.responseJSON.username_user) {
                $('#alert-username_user').removeClass('d-none').addClass('d-block').html(error.responseJSON.username_user[0]);
            }
            if (error.responseJSON.nama_user) {
                $('#alert-nama_user').removeClass('d-none').addClass('d-block').html(error.responseJSON.nama_user[0]);
            }
            if (error.responseJSON.alamat_user) {
                $('#alert-alamat_user').removeClass('d-none').addClass('d-block').html(error.responseJSON.alamat_user[0]);
            }
            if (error.responseJSON.nomor_telp) {
                $('#alert-nomor_telp').removeClass('d-none').addClass('d-block').html(error.responseJSON.nomor_telp[0]);
            }
        }
    });
});


</script>
