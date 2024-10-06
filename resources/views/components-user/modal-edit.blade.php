<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT POST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="post_id">

                <div class="form-group">
                    <label for="username_user" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username_user_edit" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-username_user_edit"></div>
                </div>

                <div class="form-group">
                    <label for="password1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password1_edit" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-password1_edit"></div>
                </div>

                <div class="form-group">
                    <label for="password2" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password2_edit" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-password2_edit"></div>
                </div>

                <div class="form-group">
                    <label for="nama_user" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama_user_edit" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_user_edit"></div>
                </div>
                <div class="form-group">
                    <label for="alamat_user" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat_user_edit" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat_user_edit"></div>
                </div>
                <div class="form-group">
                    <label for="nomor_telp" class="form-label">Nomor Telepon</label>
                    <input type="number" class="form-control" id="nomor_telp_edit" required>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nomor_telp_edit"></div>
                </div>

                <div class="form-group">
                    <select id="jabatan-edit">
                        <option selected>--Pilih--</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                      </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="update">UPDATE</button>
            </div>
        </div>
    </div>
</div>

<script>
$('body').on('click', '#btn-edit-post', function () {
    let post_id = $(this).data('id');


    // Fetch user details with AJAX
    $.ajax({
        url: `/user/${post_id}`,
        type: "GET",
        success: function(response) {
            // Fill data into form fields
            $('#post_id').val(response.data.id_user);
            $('#username_user_edit').val(response.data.username_user);
            $('#password1_edit').val(''); // Clear password fields
            $('#password2_edit').val(''); // Clear password fields
            $('#nama_user_edit').val(response.data.nama_user);
            $('#alamat_user_edit').val(response.data.alamat_user);
            $('#nomor_telp_edit').val(response.data.nomor_telp);
            $('#jabatan-edit').val(response.data.jabatan);

            $('#modal-edit').modal('show');
        }
    });
});


$('#update').click(function(e) {
    e.preventDefault();

    let username = $('#username_user_edit').val(); // Use '_edit' version
    let password1 = $('#password1_edit').val();    // Use '_edit' version
    let password2 = $('#password2_edit').val();    // Use '_edit' version
    let nama = $('#nama_user_edit').val();         // Use '_edit' version
    let alamat = $('#alamat_user_edit').val();     // Use '_edit' version
    let telp = $('#nomor_telp_edit').val();        // Use '_edit' version
    let jabatan = $('#jabatan-edit').val();        // Correct selector
    let token = $("meta[name='csrf-token']").attr("content");
    let post_id = $('#post_id').val();             // Correct post_id value

    // Clear previous error messages
    $('.alert-danger').addClass('d-none').html('');

    // Check if passwords match
    if (password1 !== password2) {
        $('#alert-password1_edit').removeClass('d-none').addClass('d-block').html('Passwords do not match!');
        return; // Stop the form from submitting if passwords don't match
    }

    // Create a FormData object to send files
    let formData = new FormData();
    formData.append("username_user", username);
    formData.append("password_user", password2); 
    formData.append("nama_user", nama);
    formData.append("alamat_user", alamat);
    formData.append("nomor_telp", telp);
    formData.append("jabatan", jabatan);
    formData.append("_token", token);

    // Append _method to mimic PUT request
    formData.append('_method', 'PUT');  // Mimic PUT method in Laravel

    // Send the AJAX request
    $.ajax({
        url: `/user/${post_id}`, 
        type: 'POST',  
        data: formData,
        cache: false,
        contentType: false, 
        processData: false,  
        success: function(response) {
            // Show success message
            Swal.fire({
                icon: 'success',
                title: `${response.message}`,
                showConfirmButton: false,
                timer: 3000
            });

            $('#myTable').DataTable().ajax.reload(null, false);

            // Update the post in the table
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
            $(`#index_${response.data.id_user}`).replaceWith(post);

            // Close the modal
            $('#modal-edit').modal('hide');
        },
        error: function(error) {
            console.log(error.responseJSON);  // Log any errors
        }
    });
});



</script>