<!-- Modal -->
<div class="modal fade" id="modalTag" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTag" method="post">
                <div class="modal-body">
                    <ul id="errTag" class="pl-0 mb-0"></ul>

                    <div class="row">
                        <div class="col px-2">
                            <div class="form-group mt-0 pt-0">
                                <label>Nama {{ $title }}</label>
                                <input type="text" id="tagName" class="form-control" name="tag_name"
                                    placeholder="Nama {{ $title }}...">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="hiddenId" name="hidden_id" />
                </div>
                <div class="modal-footer d-flex justify-content-between ">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" id="btnAction">
                </div>
            </form>
        </div>
    </div>
</div>

@push('_scripts')
    <script>
        $(document).ready(function() {
            $('#modalTag').on('hidden.bs.modal', () =>
                $(this).find("input").val('').end()
            );

            $('#formTag').on('submit', function(e) {
                e.preventDefault();

                let [action, url, method] = [$('#btnAction').val(), '', ''];

                if (action == 'Simpan') {
                    url = "{{ url('master-data/tags/store') }}";
                    method = 'POST';
                }

                if (action == 'Update') {
                    let tagId = $("#hiddenId").val();
                    url = `{{ url('master-data/tags/${tagId}/update') }}`;
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
                        $('#modalTag').modal('hide');
                        $('#formTag')[0].reset();

                        Toast.fire({
                            'title': `${data.success}`
                        });

                        $("#tagTable").DataTable().ajax.reload();
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            let html = '<div class="alert alert-danger py-2">';
                            $.each(response.responseJSON.errors, function(_, val) {
                                html += `<p class="mb-0">${val}</p>`;
                            });
                            html += '</div>';

                            setTimeout(function() {
                                $('.alert').fadeTo(200, 0).slideUp(500, () =>
                                    $(this).remove()
                                );
                            }, 5000);

                            $('#errTag').html(html);
                        }
                    }
                });
            });
        })
    </script>
@endpush
