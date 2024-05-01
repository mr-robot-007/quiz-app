@extends('layouts.dashboard')

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    Change Password
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
                action="{{ route('password.update',['current_user'=>$current_user]) }}"
                method="POST">

                @csrf

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="d-flex flex-column">
                            @foreach($errors->all() as $error)
                                <p class="btn btn-danger toastsDefaultDanger">{{ $error }}</p>
                            @endforeach

                        </div>
                    @endif
                    <div class=" form-group">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="form-control" id="exampleInputEmail1"
                            placeholder="Enter name"
                            {{ isset($current_user) ? 'disabled': '' }}
                            value="{{ isset($current_user)? $current_user->name : old('name') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1"
                            placeholder="Enter email"
                            {{ isset($current_user) ? 'disabled': '' }}
                            value="{{ isset($current_user)? $current_user->email : old('email') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input name="current_password" type="password" class="form-control" id="exampleInputPassword1"
                            placeholder="Password" value="{{ old('password') }}" required>
                    </div>



                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input name="new_password" type="password" class="form-control" id="exampleInputPassword1"
                            placeholder="Password" value="{{ old('password') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm_new_password">Confirm New Password</label>
                        <input name="confirm_new_password" type="password" class="form-control"
                            id="exampleInputPassword1" placeholder="Confirm New Password"
                            value="{{ old('confirm_new_password') }}" required>
                    </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
