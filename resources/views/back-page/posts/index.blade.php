@extends('layouts.back-core.main')

@push('styles')
    <!-- Datatables and Plugins-->
    <link rel="stylesheet" href="{{ asset('assets/back-src/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/back-src/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/back-src/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
                    <a href="#">Master Data</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $title }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title mr-auto">Data {{ $title }}</h4>
                            <button type="button" class="btn btn-sm btn-danger btn-round mr-1 d-none"
                                id="deleteAllSelected">
                            </button>
                            <a href="{{ url('master-data/posts/create') }}" class="btn btn-sm btn-primary btn-round">
                                <i class="fa fa-plus"></i>
                                &ensp;{{ $title }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="postTable" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 2%">No.</th>
                                    <th style="width: 2%">
                                        <input type="checkbox" name="main_checkbox">
                                    </th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Tags</th>
                                    <th>Author</th>
                                    <th style="width: 5%">Aksi</th>
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
            if ($('input[name="post_checkbox"]:checked').length > 0) {
                $('button#deleteAllSelected').html(`
                    <i class="fa fa-trash-alt"></i>
                    (${$('input[name="post_checkbox"]:checked').length}) {{ $title }}
                `).removeClass('d-none');
            } else {
                $('button#deleteAllSelected').addClass('d-none');
            }
        }

        $(document).ready(function() {
            const postTable = $('#postTable').DataTable({
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
                    'targets': 0
                }],
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
                    url: "{{ url('master-data/posts/data-table') }}",
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
                        name: 'title',
                        data: 'title',
                    },
                    {
                        name: 'category',
                        data: 'category.category_name',
                    },
                    {
                        name: 'tags',
                        data: 'tags',
                    },
                    {
                        name: 'author',
                        data: 'user.name',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'dt-nowrap text-center',
                    },
                ],
            }).on('draw', function() {
                $('input[name="post_checkbox"]').each(function() {
                    this.checked = false;
                });
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllSelected').addClass('d-none');
            });

            $('#postTable').on('click', '.post-delete', function() {
                let [postSlug, postName] = [$(this).data('slug'), $(this).data('delete')]

                Confirm.fire({
                    title: 'Konfirmasi hapus {{ $title }} !',
                    html: `Apakah anda yakin ingin menghapus {{ $title }} <b>${[postName]}</b>`,
                    confirmButtonText: 'Ya, Hapus',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'delete',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: `{{ url('master-data/posts/${postSlug}/destroy') }}`,
                            success: function(data) {
                                Toast.fire({
                                    'title': `${data.success}`
                                })

                                postTable.ajax.reload();
                            }
                        })
                    }
                });
            });

            $(document).on('click', 'input[name="main_checkbox"]', function() {
                if (this.checked) {
                    $('input[name="post_checkbox"]').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('input[name="post_checkbox"]').each(function() {
                        this.checked = false;
                    });
                }
                toggledeleteAllSelected();
            });

            $(document).on('change', 'input[name="post_checkbox"]', function() {
                if ($('input[name="post_checkbox"]').length ==
                    $('input[name="post_checkbox"]:checked').length
                ) {
                    $('input[name="main_checkbox"]').prop('checked', true);
                } else {
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllSelected();
            });

            $(document).on('click', 'button#deleteAllSelected', function() {
                let checkedPosts = [];
                $('input[name="post_checkbox"]:checked').each(function() {
                    checkedPosts.push($(this).data('id'));
                });

                if (checkedPosts.length > 0) {
                    Confirm.fire({
                        title: 'Konfirmasi hapus {{ $title }} !',
                        html: `Hapus <b>(${checkedPosts.length})</b> {{ $title }}`,
                        confirmButtonText: 'Ya, Hapus',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'delete',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                url: `{{ url('master-data/posts/destroy-all-selected') }}`,
                                data: {
                                    post_ids: checkedPosts
                                },
                                success: function(data) {
                                    Toast.fire({
                                        'title': `${data.success}`
                                    })

                                    postTable.ajax.reload();
                                }
                            })
                        }
                    })
                }
            });
        });
    </script>
@endpush
