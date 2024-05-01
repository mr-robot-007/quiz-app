@extends('layouts.dashboard')
@section('title')
    @if (@isset($user->id))
        Update details
    @else
        Register new user
    @endif


@endsection

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    @if(@isset($user->id) && $user->id == $current_user->id)
                        Update Profile
                    @elseif(@isset($user))
                        Edit user
                    @else
                        Add new user
                    @endisset

                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form
                action="{{ isset($user) ? route('users.update', [$user->id]) : route('users.store') }}"
                method="POST">

                @csrf

                <div class="card-body">
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
                            value="{{ isset($user)? $user->name : old('name') }}"
                            {{ isset($user) ? 'disabled': '' }}
                            required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1"
                            placeholder="Enter email"
                            {{ isset($user) ? 'disabled': '' }}
                            value="{{ isset($user)? $user->email : old('email') }}"
                            required>
                    </div>


                    @if(!isset($user) )

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input name="password" type="password" class="form-control" id="exampleInputPassword1"
                                placeholder="Password" value="{{ old('password') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input name="confirm_password" type="password" class="form-control"
                                id="exampleInputPassword1" placeholder="Confirm Password"
                                value="{{ old('confirm_password') }}" required>
                        </div>

                    @endif

                    @if(!isset($user) || (isset($user) && ($user->id != $current_user->id)))
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control select2" style="width: 100%;">
                                <option value="active"
                                    {{ isset($user) && $user->status === 'active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="inactive"
                                    {{ isset($user) && $user->status === 'inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                                <option value="blocked"
                                    {{ isset($user) && $user->status === 'blocked' ? 'selected' : '' }}>
                                    Blocked</option>
                                <option value="deleted"
                                    {{ isset($user) && $user->status === 'deleted' ? 'selected' : '' }}>
                                    Deleted</option>
                            </select>

                        </div>
                    @endif
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
