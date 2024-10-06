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
                    <label for="name" class="control-label">Judul Buku</label>
                    <input type="text" class="form-control" id="judul-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                </div>
                

                <div class="form-group">
                    <label class="control-label">Cover</label>
                    <input class="form-control" type="file" id="cover-edit" />
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-content-edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Dokumen</label>
                    <input class="form-control" type="file" id="dokumen-edit" />
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-content-edit"></div>
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
    //button create post event
    $('body').on('click', '#btn-edit-post', function () {

let post_id = $(this).data('id');

// Fetch book details with AJAX
$.ajax({
    url: `/buku/${post_id}`,
    type: "GET",
    success:function(response) {

        // Fill data into form fields
        $('#post_id').val(response.data.id_buku);
        $('#judul-edit').val(response.data.judul_buku);

        // Properly display cover image
        $('#cover-edit').html(`<img src="public/cover/${response.data.cover}" width="100" class="img-fluid img-thumbnail">`);

        $('#dokumen-edit').html(`<img src="public/dokumen/${response.data.dokumen}" width="100" class="img-fluid img-thumbnail">`);

        // Open the modal for editing
        $('#modal-edit').modal('show');
    }
});
});

$('#update').click(function(e) {
    e.preventDefault();

    // Fetch form data
    let post_id = $('#post_id').val();
    let judul_buku = $('#judul-edit').val();
    let cover = $('#cover-edit')[0].files[0];  // Get the file from the input
    let dokumen = $('#dokumen-edit')[0].files[0];  // Get the file from the input
    let token = $("meta[name='csrf-token']").attr("content");  // Get CSRF token

    // Create a FormData object to send files
    let formData = new FormData();
    formData.append('judul_buku', judul_buku);  // Append the title to FormData
    formData.append('cover', cover);  // Append the cover file to FormData
    formData.append('dokumen', dokumen);  // Append the document file to FormData
    formData.append('_token', token);  // Append the CSRF token

    // Append _method to mimic PUT request
    formData.append('_method', 'PUT');  // Mimic PUT method in Laravel

    // Send the AJAX request
    $.ajax({
        url: `/buku/${post_id}`,  // URL to update the book
        type: 'POST',  // Using POST to send, but mimicking PUT request
        data: formData,
        cache: false,
        contentType: false,  // Necessary for sending files
        processData: false,  // Prevent jQuery from processing the data
        success: function(response) {
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Berhasil DiUpdate',
                showConfirmButton: false,
                timer: 3000
            });

            $('#myTable').DataTable().ajax.reload(null, false);

            // Update the post in the table
            let post = `
                <tr id="index_${response.data.id_buku}">
                    <td>${response.data.judul_buku}</td>
                    <td><img src="public/cover/${response.data.cover}" width="100"></td>
                    <td>${response.data.dokumen}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id_buku}" class="btn btn-primary btn-sm">EDIT</a>
                        <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id_buku}" class="btn btn-danger btn-sm">DELETE</a>
                    </td>
                </tr>
            `;
            $(`#index_${response.data.id_buku}`).replaceWith(post);

            // Close the modal
            $('#modal-edit').modal('hide');
        },
        error: function(error) {
            console.log(error.responseJSON);  // Log any errors
        }
    });
});


</script>