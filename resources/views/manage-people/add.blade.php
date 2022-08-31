@extends('layout.collector')
@section('content')
<main class="login-form">
    <div class="container" style="margin-top: 5em;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">People</div>
                    <div class="card-body">
    
                        <form action="{{ route('add-people') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="col-md-4 col-form-label">First name</label>
                                <div class="col-md-12">
                                    <input type="text" id="name" class="form-control" name="first_name" required autofocus>
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 col-form-label">Last name</label>
                                <div class="col-md-12">
                                    <input type="text" id="name" class="form-control" name="last_name" required autofocus>
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 col-form-label">Phone</label>
                                <div class="col-md-12">
                                    <input type="text" id="name" class="form-control" name="phone" required autofocus maxlength="10" minlength="10">
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 col-form-label">Identity</label>
                                <div class="col-md-12">
                                    <input type="text" id="name" class="form-control" name="identity" required autofocus maxlength="16" minlength="16">
                                    @if ($errors->has('identity'))
                                        <span class="text-danger">{{ $errors->first('identity') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-12" >
                                {{ old('house_id') == '1' ? 'selected' : '' }}
                                 <label for="role">Houses<span class="text-danger">*</span></label>
                                 <select id="cell" name="house_id" class="form-control col-md-12">
                                 <option>Houses</option>
                                    @foreach($houses as $house)
                                    <option value="{{ $house->id }}" {{ $house->id==old('house_id') ? 'selected' : ''}}>{{ $house->house_code }}</option>
                                    @endforeach
                                  </select> 
                                  
                              </select>
                               </div>    
                            <div class="form-group col-md-12" >
                                {{ old('cat') == '1' ? 'selected' : '' }}
                                 <label for="role">Category<span class="text-danger">*</span></label>
                                 <select id="cell" name="cat_id" class="form-control col-md-12">
                                 <option>Category</option>
                                    @foreach($category as $cat)
                                    <option value="{{ $cat->id }}" {{ $cat->id==old('cat') ? 'selected' : ''}}>{{ $cat->category_name }}</option>
                                    @endforeach
                                  </select> 
                                  
                              </select>
                               </div>    
    
                              
                             
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Submit
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
