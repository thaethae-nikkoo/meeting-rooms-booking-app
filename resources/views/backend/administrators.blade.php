@extends('layout.backmaster')
@section('tit', 'Administrators')
@section('breadcrumb1', 'E.F.R Meeting Room Management System')
@section('body')


    @if (Session::has('success'))
        <div class="col-12 alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (Session::has('success_update'))
        <div class="col-12 alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ Session::get('success_update') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (Session::has('success_delete'))
        <div class="col-12 alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ Session::get('success_delete') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="container">




        <div class="table-responsive">
            <table class="table">

                <thead>
                    <tr>
                        <th colspan="5">
                            <a href="{{ url('/administrations/admin/create') }}" class="btn btn-info btn-sm active"
                                role="button" aria-pressed="true">Add New <i class="bi bi-plus-circle-fill"></i></a>

                        </th>
                        <th colspan="2">
                            Showing <span class="text-primary"> 3 </span> of entries.
                        </th>
                    </tr>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>

                        <th scope="col">Email</th>
                        <th scope="col">Contact No.</th>
                        <th scope="col">Company</th>
                        <th scope="col">Role</th>
                        <th scope="col"> Created at</th>
                        {{-- <th scope="col">Updated at</th>
                    <th scope="col">Actions</th> --}}
                    </tr>
                </thead>
                <tbody>

                    @foreach ($admins as $a)
                        <tr>
                            <th scope="row">{{ $a->id }}</th>

                            <th scope="row">{{ $a->name }}</th>
                            <td>{{ $a->email }}</td>
                            <td>{{ $a->phone }}</td>
                            <td>{{ $a->company_name }}</td>
                            <td>{{ $a->role }}</td>
                            {{-- <td>{{$a->created_at}}</td>
                    <td>{{$a->updated_at}}</td> --}}
                            <td>

                                <a data-toggle="modal" data-id="{{ $a->id }}"
                                    data-attr="{{ route('admin.destroy', $a->id) }}" id="deleteBtn"
                                    data-target="#deleteModal" href="#"
                                    class="badge bg-danger text-white text-decoration-none">Delete</a>


                                <a href="{{ route('admin.edit', $a->id) }}"
                                    class="badge bg-primary text-white text-decoration-none">Edit</a>

                            </td>
                        </tr>
                    @endforeach





                </tbody>
            </table>
            <div class="d-lg-flex d-sm-block justify-content-end">
                {{ $admins->links() }}
            </div>

        </div>



        <!-- Delete Modal -->
        <div class="modal deleteModal fade" id="deleteModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Are
                            you sure want to
                            delete?</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="delModal" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script>
        // display a modal (delete modal)
        $(document).on('click', '#deleteBtn', function(event) {
            event.preventDefault();

            let href = $(this).attr('data-attr');
            $('#delModal').attr('action', href);
        });
    </script>

@endsection
