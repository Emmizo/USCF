@extends('layout.app')

@section('content')
<div class="container-fluid">
  <div class="row mt-4">
    <div class="col-12">
      <div class="card card-secondary">
        <div class="card-header">
          <h3 class="card-title">{{ $title }}</h3>
        </div>
        @if(session()->has('success'))  
        <div class="alert alert-success"> {!! session('success') !!} </div>
        @endif @if(session()->has('error')) 
        <div class="alert alert-danger"> {!! session('error') !!} </div>  
        @endif
          <form role="form" id="edit-tour" action="{{ route('update-user') }}" name="edit-tour" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                 <div class="row">
                  <div class="form-group col-md-6 text-left" >
                    <label for="place_name">Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name')?old('name'):$info->name }}">
                  </div>
                   
                </div>

                <div class="row">
                 <div class="form-group col-md-6 text-left" >
                   <label for="basic_details">Email<span class="text-danger">*</span></label>
                   <input type="text" class="form-control" id="email" name="email" placeholder="email" value="{{ old('email')?old('email'):$info->email }}">
                 </div>
                 <div class="form-group col-md-6">
                    <label for="place_name">Role<span class="text-danger">*</span></label>
                    <select class="form-control" id="place" name="role_id" multiple>
                      <option value="">--Select role--</option>
                      @php $placeids = explode(",",$info->role_id); @endphp
                      @foreach($roles as $role)
                      @if(in_array($role->id, $placeids))
                      <option value="{{ $role->id }}" selected="true">{{ $role->role_name }}</option>
                      @else
                      <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>
                 
                <div class="form-group col-md-6">
                    <label for="place_name">Cell<span class="text-danger">*</span></label>
                    <select class="form-control" id="place" name="cell_id" multiple>
                      <option value="">--Select Cell--</option>
                      @php $cellids = explode(",",$info->cell_id); @endphp
                      @foreach($cells as $cell)
                      @if(in_array($cell->id, $cellids))
                      <option value="{{ $cell->id }}" selected="true">{{ $cell->cell_name }}</option>
                      @else
                      <option value="{{ $cell->id }}">{{ $cell->cell_name }}</option>
                      @endif
                      @endforeach
                    </select>
                </div>

            

        


        
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Update</button>
      <input type="hidden" name="id"  id="id" value="{{ $info->id }}">
      {{-- <a href="{{ route('users') }}" class="btn btn-secondary">Cancel</a> --}}
      <button type="button" onclick="resetForm();" class="btn btn-primary">Reset</button>
    </div>
  </form>
</div>
</div>
</div>
</div>
@endsection
@section('style')
<style>
 #map {
  height: 300px;
  width: 100%;
}
.custom-check-list-wrapper {
    display: block;
}

</style>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $('#edit-tour').validate({
      rules: {
        tour_package_name: {
          required: true,
          maxlength:50,
        },
        coins_required: {
          required: true,
        },
        distance: {
          required: true,
        },
        transportation: {
          required: true,
        },
        budget: {
          required: true,
        },
        tickets: {
          required: true,
        },
        duration:{
          required: true,
        },
        tour_description: {
          required: true,
          rangelength:[10,500],
        },
        overview: {
          required: true,
          rangelength:[10,500],
        },
        basic_details: {
          required: true,
          rangelength:[10,500],
        },
        'place[]': {
          required: true,
        },
      },
      messages: {
        tour_package_name: {
          required: "Please enter place name",
        },
        coins_required: {
          required: "Please enter coins",
        },
        duration: {
          required: "Please enter duration",
        },
        overview: {
          required: "Please enter overview",
        },
        tour_description: {
          required: "Please enter description",
        },
        distance: {
          required: "Please enter distance",
        },
        transportation: {
          required: "Please enter transportation",
        },
        budget: {
          required: "Please enter budget",
        },
        tickets: {
          required: "Please enter where you can find tickets",
        },
        basic_details: {
          required: "Please enter basic_details",
        },
        'place[]': {
          required: "Please select place",
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });
  $(document).ready(function () {
    $('#phone').mask('(000) 000-0000');
  });

  function resetForm() {
    document.getElementById("add-tour").reset();
  }

 </script>
@endsection
