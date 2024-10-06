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
                    <label for="name" class="control-label">Judul Buku</label>
                    <input class="form-control" type="text" id="judul_buku" />
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-judul"></div>
                </div>
                

                <div class="form-group">
                    <label class="control-label">Cover</label>
                    <input class="form-control" type="file" id="cover" />
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-cover"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Upload Buku</label>
                    <input class="form-control" type="file" id="dokumen" />
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-dokumen"></div>
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

    //action create post
   $('#store').click(function(e) {
    e.preventDefault();

    let judul_buku = $('#judul_buku').val();
    let cover = $('#cover')[0].files[0];
    let dokumen = $('#dokumen')[0].files[0];
    let token = $("meta[name='csrf-token']").attr("content");

    // Create FormData object
    let formData = new FormData();
    formData.append("judul_buku", judul_buku);
    formData.append("cover", cover);
    formData.append("dokumen", dokumen);
    formData.append("_token", token);

    // Perform the AJAX request
    $.ajax({
        url: `/buku`,
        type: "POST",
        cache: false,
        contentType: false, // Important for file uploads
        processData: false, // Important for file uploads
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

            // Append new post
            let post = `
                <tr id="index_${response.data.id_buku}">
                    <td>${response.data.judul_buku}</td>
                    <td>${response.data.cover}</td>
                    <td>${response.data.dokumen}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id_buku}" class="btn btn-primary btn-sm">EDIT</a>
                        <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id_buku}" class="btn btn-danger btn-sm">DELETE</a>
                    </td>
                </tr>
            `;
            $('#table-posts').prepend(post);
            $('#modal-create').modal('hide');
        },
        error: function (error) {
            console.log(error.responseJSON); // Log detailed error
            if (error.responseJSON.judul_buku) {
                $('#alert-judul').removeClass('d-none').addClass('d-block');
                $('#alert-judul').html(error.responseJSON.judul_buku[0]);
            }
            if (error.responseJSON.cover) {
                $('#alert-cover').removeClass('d-none').addClass('d-block');
                $('#alert-cover').html(error.responseJSON.cover[0]);
            }
            if (error.responseJSON.dokumen) {
                $('#alert-dokumen').removeClass('d-none').addClass('d-block');
                $('#alert-dokumen').html(error.responseJSON.dokumen[0]);
            }
        }
    });
});

</script>
