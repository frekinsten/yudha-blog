<div class="modal fade" id="modalUserEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                        Edit Akun {{ $title }}
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUserEdit" method="post">
                <div class="modal-body">
                    <ul id="errUserEdit" class="pl-0 mb-0"></ul>

                    <div class="row">
                        <div class="col px-2">
                            <div class="form-group mt-0 pt-0">
                                <label for="name">Nama</label>
                                <input type="text" id="name" class="form-control" name="name"
                                    placeholder="Nama...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col px-2">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control" name="email"
                                    placeholder="Email...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col px-2">
                            <div class="form-group">
                                <label for="roleIds">Role</label>
                                <select class="form-control" id="roleIds" name="role_ids[]" multiple></select>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="hiddenId" name="hidden_id" />
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('_scripts')
    <script>
        $(document).ready(function() {
            $('#formUserEdit').on('submit', function(e) {
                e.preventDefault();

                let userId = $("#hiddenId").val()

                $.ajax({
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: `{{ url('management-users/${userId}/update') }}`,
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        $('#modalUserEdit').modal('hide');
                        $('#formUserEdit')[0].reset();

                        Toast.fire({
                            'title': `${data.success}`
                        })

                        $("#userTable").DataTable().ajax.reload();
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            let html = '<div class="alert alert-danger py-2">';
                            $.each(response.responseJSON.errors, function(_, val) {
                                html += `<li class="mb-0">${val}</li>`;
                            });
                            html += '</div>';

                            setTimeout(function() {
                                $('.alert').fadeTo(200, 0).slideUp(500, () =>
                                    $(this).remove()
                                );
                            }, 5000);

                            $('#errUserEdit').html(html);
                        }
                    }
                });
            });
        })
    </script>
@endpush
