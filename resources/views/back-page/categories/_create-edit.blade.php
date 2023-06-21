<!-- Modal -->
<div class="modal fade" id="modalCategory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCategory" method="post">
                <div class="modal-body">
                    <ul id="errCategory" class="pl-0 mb-0"></ul>

                    <div class="row">
                        <div class="col px-2">
                            <div class="form-group mt-0 pt-0">
                                <label for="categoryName">Nama {{ $title }}</label>
                                <input type="text" id="categoryName" class="form-control" name="category_name"
                                    placeholder="Nama {{ $title }}...">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="hiddenId" name="hidden_id" />
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    <input type="submit" class="btn btn-primary" id="btnAction">
                </div>
            </form>
        </div>
    </div>
</div>

@push('_scripts')
    <script>
        $(document).ready(function() {
            $('#modalCategory').on('hidden.bs.modal', () =>
                $(this).find("input").val('').end()
            );

            $('#formCategory').on('submit', function(e) {
                e.preventDefault();

                let [action, url, method] = [$('#btnAction').val(), '', ''];

                if (action == 'Simpan') {
                    url = "{{ url('master-data/categories/store') }}";
                    method = 'POST';
                }

                if (action == 'Update') {
                    let categoryId = $("#hiddenId").val();
                    url = `{{ url('master-data/categories/${categoryId}/update') }}`;
                    method = 'PUT';
                }

                $.ajax({
                    type: method,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: url,
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        $('#modalCategory').modal('hide');
                        $('#formCategory')[0].reset();

                        Toast.fire({
                            'title': `${data.success}`
                        });

                        $("#categoryTable").DataTable().ajax.reload();
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

                            $('#errCategory').html(html);
                        }
                    }
                });
            });
        })
    </script>
@endpush
