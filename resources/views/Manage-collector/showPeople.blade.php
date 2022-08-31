@extends('layout.collector')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
<div class="container mg-10" style="margin-top: 5em;">

   <div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $title ?? '' }}</h1>
            </div>
            @if(session()->has('success'))  
        <div class="alert alert-success"> {!! session('success') !!} </div>
        @endif @if(session()->has('error')) 
        <div class="alert alert-danger"> {!! session('error') !!} </div>  
        @endif
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('Collector') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $add ?? '' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <div class="offset-8 col-sm-4 text-right" style="padding: 10px;"><a href="{{ route('add') }}" class="btn btn-info btn-sm">{{ $add ?? 'Add' }}</a></div>
    <table class="table table-bordered data-table" id="manage-teams">
        <thead>
            <tr>
                <th>No</th>
                <th>First name</th>
                <th>Last name</th>
                {{-- <th>Identity</th> --}}
                <th>Phone</th>
                <th>House code</th>
                {{-- <th>Cell</th> --}}
                <th>Ubudehe</th>
                <th>Amount</th>
                <th>Status</th>
                <th width="100px">Paid</th>
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
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('showPeople') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            // {data: 'identity', name: 'identity'},
            {data: 'phone', name: 'phone'},
            {data: 'house_code', name: 'houses.house_code'},
            // {data: 'cell_name', name: 'cell_name'},
            {data: 'category_name', name: 'categories.category_name'},
            {data: 'amount', name: 'categories.amount'},
            {data: 'status', name: 'houses.status'},
            {data: 'paid', name: 'paid_houses.paid', orderable: false, searchable: false},
            {data: 'option', name: 'option', orderable: false, searchable: false},
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
                      $('#manage-teams').DataTable().draw();
                    }
                  }
              });
        }else
        {
          $("#manage-teams").DataTable().draw();
        }
    });
  });

  $(document).on('change', '.toggle-class2', function(){
    var id = $(this).attr('data-id');
    var idss = $(this).attr('data-id2');
    console.log(idss);
    // var ids =$(this).attr('data-ids');
    var status_url = $(this).attr('data-url');
    var status=1;
    if ($(this).is(":checked")) {
      var paid = 0;
      var statusname ="This people paid";
    } else {
      var paid = 1;
      var statusname ="Refund";
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
       if (result) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var people = "<?php echo $people??''; ?>";
        console.log(people);
        $.ajax({
                  type: "POST",
                  dataType: 'json',
                  url: status_url,
                  data:{
                      // status:status,
                      id:idss,
                      paid:paid,
                      house_people_id:id,
                    },
                    beforeSend: function() {
                  $('.loader1').show();
                  },
                  success: function (data) {
                     $('.loader1').hide();
                    if(data){
                       swal({
                        title: "Success",
                        text: "Status Updated Successfully.",
                        type: "success",
                        confirmButtonColor: "#22D69D"
                    });
                      $('#manage-teams').DataTable().draw();
                    }
                  }
              });
        }else
        {
          $("#manage-teams").DataTable().draw();
        }
    });
  });
  });
</script>

@endsection