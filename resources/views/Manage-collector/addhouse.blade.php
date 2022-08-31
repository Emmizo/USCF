@extends('layout.collector')
@section('content')
<main class="login-form">
    <div class="container" style="margin-top: 5em;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">House</div>
                    <div class="card-body">
    
                        <form action="{{ route('add-house') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="col-md-4 col-form-label">House Code</label>
                                <div class="col-md-12">
                                    <input type="text" id="name" class="form-control" name="house_code" maxlength="5" required autofocus>
                                    @if ($errors->has('house_code'))
                                        <span class="text-danger">{{ $errors->first('house_code') }}</span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group">
                                
                                <div class="col-md-12">
                                    <input type="hidden" id="email_address" class="form-control" name="cell_id" value="{{ $cell_id }}" required autofocus>
                                </div>
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
