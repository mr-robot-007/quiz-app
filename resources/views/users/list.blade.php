@extends('layouts.dashboard')

@section('title','Manage Users')

@section('content')

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="static/components/plugins/fontawesome-free/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="static/components/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="static/components/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="static/components/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="static/components/dist/css/adminlte.min.css">

<div class="card">
    <div class="card-header d-flex align-items-center">
        <h3 class="card-title col-sm-6">List of all users</h3>

        <div class="col-sm-6">
            <a href="{{ route('users.register') }}" class="btn btn-primary  btn-sm float-sm-right">Add
                new user</a>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @isset($users)

                    @forelse($users as $user)

                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}
                            </td>
                            <td>{{ $user->status }}</td>
                            <td>{{ $user->role }}</td>
                            <td><a type="button"
                                    href="{{ route('users.toggleblock',['user'=>$user->id]) }}"
                                    class="btn btn-block btn-info btn-xs">{{ $user->status =='blocked' ? 'Unblock' : 'Block' }}</a>
                            </td>
                            <td>
                                <a
                                    href="{{ route('users.edit',['user'=>$user->id]) }}">Edit</a>

                            </td>

                            <td><a
                                    href="{{ route('users.delete',['user'=>$user->id]) }}">Delete</a>
                            </td>
                        </tr>


                    @empty

                    @endforelse


                @endisset


            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

@endsection



@push('custom-js')
    <!-- jQuery -->
    <script src="static/components/plugins/jquery/jquery.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="static/components/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="static/components/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="static/components/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="static/components/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="static/components/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="static/components/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="static/components/plugins/jszip/jszip.min.js"></script>
    <script src="static/components/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="static/components/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="static/components/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="static/components/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="static/components/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script>
        $(function () {
            $("#example1").DataTable({
                ajax: "{{ route('users.data') }}",
                columns: [{
                        data: "name"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "role"
                    },
                    {
                        data: "id",
                        render: function (data, type, row) {
                            var buttonLabel = row.status == 'blocked' ? 'Unblock' : 'Block';
                            var buttonClass = row.status == 'blocked' ? 'btn-info' :
                                'btn-warning';
                            'btn-warning';
                            var buttonUrl =
                                "{{ route('users.toggleblock', ['user' => ':id']) }}"
                                .replace(':id', row.id);

                            return `<div class="btn-group">
                    <button type="button" class="btn btn-default">Info</button>
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="/users/toggleBlock/${row.id}">${row.status == 'blocked'? 'Unblock':'Block'}</a>
                      <a class="dropdown-item" href="/users/edit/${row.id}">Edit</a>
                      <a type="button" class="dropdown-item" href="/users/delete/${row.id}">Delete</a>
                    </div>
                  </div>`;
                            // return '<a href="' + buttonUrl +
                            //     '" class="btn btn-xs ' +
                            //     buttonClass + '">' + buttonLabel + '</a>';
                        }
                    }
                    // Add columns for actions if needed
                ]

            })
        });

    </script>
@endpush
