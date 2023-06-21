@extends('layouts.back-core.main')

@push('styles')
    <!-- Datatables and Plugins-->
    <link rel="stylesheet" href="{{ asset('assets/back-src/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/back-src/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/back-src/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/back-src/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs ml-0 border-left-0">
                <li class="nav-home">
                    <a href="#">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Manajemen</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $title }}s</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title mr-auto">Data {{ $title }}</h4>
                            @role('Admin')
                                <button type="button" class="btn btn-sm btn-danger btn-round mr-1 d-none"
                                    id="deleteAllSelected">
                                </button>
                                <div class="form-group form-inline">
                                    <label for="isActive" class="col-md-3 col-form-label">Status:</label>
                                    <div class="col-md-9 p-0">
                                        <select id="isActive" name="account_status" class="form-control input-full">
                                            <option value="all">Tampil Semua</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            @endrole
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="userTable" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 2%">No.</th>
                                    @role('Admin')
                                        <th style="width: 2%">
                                            <input type="checkbox" name="main_checkbox">
                                        </th>
                                    @else
                                        <th style="width: 2%"></th>
                                    @endrole
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status Akun</th>
                                    <th class="text-center" style="width: 5%">Aksi</th>
                                </tr>
                            </thead>
                            <tfoot></tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('back-page.managament-users._edit', ['title' => $title])
@endsection

@push('scripts')
    <!-- Datatables and Plugins-->
    <script src="{{ asset('assets/back-src/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/back-src/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/back-src/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/back-src/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('assets/back-src/plugins/select2/js/select2.min.js') }}"></script>

    <!-- Message from success session -->
    @if (session()->has('success'))
        <script>
            Toast.fire({
                title: `{{ session()->get('success') }}`
            })
        </script>
    @endif

    <script>
        function toggledeleteAllSelected() {
            if ($('input[name="user_checkbox"]:checked').length > 0) {
                $('button#deleteAllSelected').html(`
                    <i class="fa fa-trash-alt"></i>
                    (${$('input[name="user_checkbox"]:checked').length}) {{ $title }}
                `).removeClass('d-none');
            } else {
                $('button#deleteAllSelected').addClass('d-none');
            }
        }

        $(document).ready(function() {
            $('#roleIds').select2({
                width: "100%"
            });

            const userTable = $('#userTable').DataTable({
                "serverSide": true,
                "responsive": true,
                "autoWidth": false,
                "order": [0, 'asc'],
                "pageLength": 5,
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Semua"]
                ],
                "columnDefs": [{
                        'width': '2%',
                        'targets': [0, 1]
                    },
                    {
                        'width': '5%',
                        'targets': 6
                    }
                ],
                "dom": "<'row'<'col-md-3'l><'col-md-6'B><'col-md-3'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                "buttons": [{
                        extend: 'copy',
                        className: 'btn btn-sm',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-sm',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-sm',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-sm',
                        pageSize: 'A4',
                        orientation: 'potrait',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            doc.content[1].table.widths = Array(doc.content[1].table
                                .body[0].length + 1).join('*').split('');
                            doc.defaultStyle.alignment = 'center';
                            doc.styles.tableHeader.alignment = 'center';
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-sm',
                        text: 'Kolom',
                        autoClose: true
                    },
                ],
                "language": {
                    lengthMenu: 'Tampil _MENU_ data',
                    buttons: {
                        "copyTitle": "Salin ke Papan klip",
                        "copySuccess": {
                            "_": "%d baris disalin ke papan klip"
                        },
                    },
                    search: "Cari:",
                    zeroRecords: 'Tidak ditemukan data yang sesuai',
                    emptyTable: 'Tidak ada data yang tersedia pada tabel ini',
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
                    infoFiltered: '(difilter dari total _MAX_ catatan)',
                    loadingRecords: 'Sedang memproses...',
                    paginate: {
                        "next": 'Next',
                        "previous": 'Prev'
                    },
                },
                ajax: {
                    url: "{{ url('management-users/data-table') }}",
                    data: function(data) {
                        data.account_status = $('#isActive').val();
                    }
                },
                columns: [{
                        name: 'DT_RowIndex',
                        data: 'DT_RowIndex',
                        searchable: false,
                        className: 'text-center',
                    },
                    {
                        name: 'checkbox',
                        data: 'checkbox',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                    },
                    {
                        name: 'name',
                        data: 'name',
                    },
                    {
                        name: 'email',
                        data: 'email',
                    },
                    {
                        name: 'roles',
                        data: 'roles',
                    },
                    {
                        name: 'account_status',
                        data: 'account_status',
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'dt-nowrap',
                    },
                ],
            }).on('draw', function() {
                $('input[name="user_checkbox"]').each(function() {
                    this.checked = false;
                });
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllSelected').addClass('d-none');
            });

            function validateAccountOrNot({
                title = '',
                text = '',
                name,
                user_id
            }) {
                return Confirm.fire({
                    title: `Konfirmasi ${title} validasi akun!`,
                    html: `Apakah anda ingin mem${text}validasi akun <b>${name}</b>`,
                    confirmButtonText: 'Ya, Hapus',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: `{{ url('management-users/${user_id}/update-account-status') }}`,
                            success: function(data) {
                                Toast.fire({
                                    'title': `${data.success}`
                                })

                                userTable.ajax.reload();
                            }
                        })
                    }
                })
            }

            $('#userTable').on('click', '.user-validate', function(e) {
                e.preventDefault();

                let [userId, name, isActive] = [
                    $(this).attr('id'), $(this).data('validate'), $(this).data('status')
                ];

                (isActive) ? validateAccountOrNot({
                        title: 'pembatalan',
                        text: 'batalkan ',
                        name: name,
                        user_id: userId
                    }):
                    validateAccountOrNot({
                        name: name,
                        user_id: userId
                    });
            });

            $('#isActive').change(function() {
                userTable.draw();
            });

            $('#userTable').on('click', '.user-edit', function(e) {
                e.preventDefault();
                $('#errUserEdit').html('');

                let userId = $(this).attr('id');

                $.get(`{{ url('management-users/${userId}/edit') }}`, function(data) {
                    $('#hiddenId').val(data.user.id);
                    $('#name').val(data.user.name);
                    $('#email').val(data.user.email);

                    $('#roleIds').html('');
                    $.each(data.roles, (_, role) => {
                        $('#roleIds').append(
                            `<option value="${role.id}">${role.name}</option>`
                        );
                    });
                    $('#roleIds').val(data.user.role_selected);

                    $('#modalUserEdit').modal('show');
                });
            });

            $('#userTable').on('click', '.user-delete', function() {
                let [userId, name] = [$(this).attr('id'), $(this).data('delete')]

                Confirm.fire({
                    title: 'Konfirmasi hapus {{ $title }} !',
                    html: `Apakah anda yakin ingin menghapus {{ $title }} <b>${name}</b>`,
                    confirmButtonText: 'Ya, Hapus',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'delete',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: `{{ url('management-users/${userId}/destroy') }}`,
                            success: function(data) {
                                Toast.fire({
                                    'title': `${data.success}`
                                });

                                userTable.ajax.reload();
                            },
                            error: function(jqXHR) {
                                if (jqXHR.status == 500) {
                                    let respText = $.parseJSON(jqXHR.responseText);
                                    Toast.fire({
                                        icon: 'error',
                                        'title': respText.error
                                    })
                                }
                            }
                        })
                    }
                })
            });

            $(document).on('click', 'input[name="main_checkbox"]', function() {
                if (this.checked) {
                    $('input[name="user_checkbox"]').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('input[name="user_checkbox"]').each(function() {
                        this.checked = false;
                    });
                }
                toggledeleteAllSelected();
            });

            $(document).on('change', 'input[name="user_checkbox"]', function() {
                if ($('input[name="user_checkbox"]').length ==
                    $('input[name="user_checkbox"]:checked').length
                ) {
                    $('input[name="main_checkbox"]').prop('checked', true);
                } else {
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllSelected();
            });

            $(document).on('click', 'button#deleteAllSelected', function() {
                let checkedUsers = [];
                $('input[name="user_checkbox"]:checked').each(function() {
                    checkedUsers.push($(this).data('id'));
                });

                if (checkedUsers.length > 0) {
                    Confirm.fire({
                        title: 'Konfirmasi hapus {{ $title }} !',
                        html: `Hapus <b>(${checkedUsers.length})</b> {{ $title }}`,
                        confirmButtonText: 'Ya, Hapus',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'delete',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                url: `{{ url('management-users/destroy-all-selected') }}`,
                                data: {
                                    user_ids: checkedUsers
                                },
                                success: function(data) {
                                    Toast.fire({
                                        'title': `${data.success}`
                                    })

                                    userTable.ajax.reload();
                                }
                            })
                        }
                    })
                }
            });
        });
    </script>

    @stack('_scripts')
@endpush
