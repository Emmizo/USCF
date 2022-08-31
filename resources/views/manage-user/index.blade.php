@extends('layout.app')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
    </head>

    <div class="container mg-12" style="margin-top: 5em;">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <div class="offset-8 col-sm-4 text-right" style="padding: 10px;"><a href="{{ route('register') }}"
                    class="btn btn-info btn-sm">{{ $add }}</a></div>
            <table class="table table-bordered data-table" id="users">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Cell</th>
                        <th width="100px">Active</th>
                        <th width="100px">Option</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </body>

    <script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'lifrtip',
                pageLength: 10,
                bPaginate: true,
                bLengthChange: true,
                responsive: true,
                searching: true,
                bInfo: true,
                stateSave: false,
                aaSorting: [],
                ajax: "{{ route('manage-user.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'cell_name',
                        name: 'cells.cell_name'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                'columnDefs': [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 3
                    },
                    {
                        'visible': false,
                        'targets': [0]
                    }
                ],
                'order': [
                    [0, 'desc']
                ]
            });
            $(document).on('change', '.toggle-class', function() {
                var id = $(this).attr('data-id');
                var cell = $(this).attr('data-id2');
                // alert(cell);
                var status_url = $(this).attr('data-url');
                if ($(this).is(":checked")) {
                    var status = 1;
                    var statusname = "Unblock this account";
                } else {
                    var status = 0;
                    var statusname = "Block this account";
                }
                swal({
                    title: 'Are you sure want to ' + statusname + '?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#22D69D',
                    cancelButtonColor: '#FB8678',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonClass: 'btn',
                    cancelButtonClass: 'btn',
                }).then(function(result) {
                    if (result) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            dataType: 'json',
                            url: status_url,
                            data: {
                                id: id,
                                status: status,
                                cell: cell
                            },
                            beforeSend: function() {
                                $('.loader1').show();
                            },
                            success: function(data) {
                                $('.loader1').hide();
                                if (data) {
                                    swal({
                                        title: "Success",
                                        text: "Status Updated Successfully.",
                                        type: "success",
                                        confirmButtonColor: "#22D69D"
                                    });
                                    $('#users').DataTable().draw();
                                }
                            }
                        });
                    } else {
                        $("#users").DataTable().draw();
                    }
                });
            });
        });
    </script>
@endsection
