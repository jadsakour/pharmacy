@extends('layouts.master')

@section('content')
<div id="main-content" style="margin-right: 230px;">
    <div class="wrapper">
        <h3><i class="fa fa-angle-left"></i>حساب جديد</h3>
        <div class=" row  mt" dir="rtl">
            <div class="form-panel">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Create New Role</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                    </div>
                </div>
            </div>
            <hr>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('roles.store') }}" style="margin-right:50px;">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-10 mb">
                        <div class="form-group">
                            <strong class="col-sm-2 col-sm-2">Name:</strong>
                          <div class="col-sm-10">  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-10 col-md-10 mt">
                        <div class="form-group">
                            <strong>Permission:</strong>
                            <br/>
                            @foreach($permission as $value)
                                <label class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                        {{ $value->name }}</label>
                                </label>

                            @endforeach
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
</div>
@endsection
