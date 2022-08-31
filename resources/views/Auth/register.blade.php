@extends('layout.app')
  
@section('content')
<main class="login-form">
  <div class="container" style="margin-top: 5em;">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                @if(session()->has('success'))  
                <div class="alert msg alert-success"> {!! session('success') !!} </div>
                @endif @if(session()->has('error')) 
                <div class="alert msg alert-danger"> {!! session('error') !!} </div>  
        @endif   
    
                  <div class="card-header">Register</div>
                  <div class="card-body">
  
                      <form action="{{ route('register.post') }}" method="POST">
                          @csrf
                          <div class="form-group">
                              <label for="name" class="col-md-4 col-form-label">Name</label>
                              <div class="col-md-12">
                                  <input type="text" id="name" class="form-control" name="name" required autofocus>
                                  @if ($errors->has('name'))
                                      <span class="text-danger">{{ $errors->first('name') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group">
                              <label for="email_address" class="col-md-4 col-form-label ">Email</label>
                              <div class="col-md-12">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          {{-- <div class="form-group">
                              <label for="password" class="col-md-4 col-form-label ">Password</label>
                              <div class="col-md-12">
                                  <input type="password" id="password" class="form-control" name="password" required>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div> --}}
                          <div class="form-group col-md-12" >
                            {{ old('role') == '1' ? 'selected' : '' }}
                             <label for="role">Role<span class="text-danger">*</span></label>
                             <select id="duration" name="role_id" class="form-control col-md-12">
                             <option>Select role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id==old('role') ? 'selected' : ''}}>{{ $role->role_name }}</option>
                                @endforeach
                              </select> 
                              
                          </select>
                           </div>    
                           <div class="form-group col-md-12" >
                            {{ old('cell') == '1' ? 'selected' : '' }}
                             <label for="role">Cell<span class="text-danger">*</span></label>
                             <select id="cell" name="cell_id" class="form-control col-md-12">
                             <option>Assign to Cell</option>
                                @foreach($cells as $cell)
                                <option value="{{ $cell->id }}" {{ $cell->id==old('cell') ? 'selected' : ''}}>{{ $cell->cell_name }}</option>
                                @endforeach
                              </select> 
                              
                          </select>
                           </div>    
                          <div class="col-md-6 offset-md-9">
                              <button type="submit" class="btn btn-primary">
                                  Register
                              </button>
                          </div>
                      </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection