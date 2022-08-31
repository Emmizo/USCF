@extends('layout.app')
@section('content')
<main class="login-form">
    <div class="container" style="margin-top: 5em;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $report }}</div>
                    <div class="card-body">
    
                        <form action="{{ route('generatedReport') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="col-md-4 col-form-label">From</label>
                                <div class="col-md-12">
                                    <input type="date" id="name" class="form-control" name="from" required autofocus>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 col-form-label">End</label>
                                <div class="col-md-12">
                                    <input type="date" id="name" class="form-control" name="end" required autofocus>
                                    
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Generate Report
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
