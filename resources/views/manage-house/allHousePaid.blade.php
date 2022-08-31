@extends('layout.app')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
<div class="container mg-10" style="margin-top: 5em;">

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
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>House code</th>
                <th>Cell</th>
                <th width="100px">Paid</th>
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
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
      serverSide: true,
      dom: 'lifrtip',
      pageLength: 10,
      bPaginate: true,
      bLengthChange: true,
      responsive: true,
      searching: true,
      bInfo : true,
      stateSave: false,
      aaSorting: [],
        ajax: "{{ route('paidAllHouse') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'house_code', name: 'house_code'},
            {data: 'cell_name', name: 'cells.cell_name'},
            {data: 'paid', name: 'paid', orderable: false, searchable: false},
        ],
        'columnDefs': [
    {
      responsivePriority: 1,
      targets: 0
    },
    {
      responsivePriority: 2,
      targets: 3
    },
      { 'visible': false, 'targets': [0] }
    ],
   'order': [[0, 'desc']]
    });
    
    $(document).on('change', '.toggle-class', function(){
    var id = $(this).attr('data-id');
    
    var status_url = $(this).attr('data-url');
   
    if ($(this).is(":checked")) {
      var status = 1;
      var statusname ="Activate";
    } else {
      var status = 0;
      var statusname ="De-activate";
    }
    
    swal({
        title: 'Are you sure want to '+ statusname +'?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#22D69D',
        cancelButtonColor: '#FB8678',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        confirmButtonClass: 'btn',
        cancelButtonClass: 'btn',
    }).then(function (result) {
        console.log(result);
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
                  data:{
                      id:id,
                      status:status
                    },
                    
                  success: function (data) {
                   
                    if(data){
                       swal({
                        title: "Success",
                        text: "Status Updated Successfully.",
                        type: "success",
                        confirmButtonColor: "#22D69D"
                        
                    });
                      $('.data-table').DataTable().draw();
                    }
                  }
                 
              });
        }else
        {
          $(".data-table").DataTable().draw();
        }
    });
  });
    
  $(document).on('click', '.delete-sportcategory', function(){
    var id = $(this).attr('data-id');
    var del_url = $(this).attr('data-url');
    swal({
        title: 'Are you sure?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#22D69D',
        cancelButtonColor: '#FB8678',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn',
        cancelButtonClass: 'btn',
    }).then(function (result) {
        console.log(result);
       if (result) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                  type: "POST",
                  dataType: 'json',
                  url: del_url,
                  success: function (data) {
                    if(data){
                       swal({
                        title: "Success",
                        text: "Deleted Successfully.",
                        type: "success",
                        confirmButtonColor: "#22D69D"
                    });
                      $('#manage-sportscategory').DataTable().draw();
                    }
                  }
              });
        }
    });
  });
  });
</script>

@endsection