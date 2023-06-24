@extends('layout.backmaster')
@section('tit', 'Register Admin')
@section('breadcrumb1', 'E.F.R Meeting Room Management System')

@section('body')
    @if (Session::has('success'))
        <div class="col-6 alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="container mt-4">
        <div class="card py-xl-5 py-2 bg-white border-0 shadow-lg p-5">

            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div class="row justify-content-center align-items-center flex-md-row flex-column flex-wrap">
                    <!-- Username -->
                    <div class="col-md-6 col-12 mt-1">
                        <label for="usrname" class="form-label">Username<em style="color:red">*</em></label>
                        <input class="form-control shadow-none"
                            @error('name')
                           style="border:1px solid red;"
                            @enderror
                            type="text" name="name" value="{{ old('name') }}" id="usrname" required />
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <!-- Email -->
                    <div class="col-md-6 col-12 mt-1">
                        <label for="email" class="form-label">Email<em style="color:red">*</em></label>
                        <input class="form-control shadow-none" type="email"
                            @error('email')
                        style="border:1px solid red;"
                         @enderror
                            value="{{ old('email') }}" name="email" id="email" required />
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <!-- Contact Number -->
                    <div class="col-md-6 col-12 mt-4">
                        <label for="phone" class="form-label">Contact Number<em style="color:red">*</em></label>
                        <input class="form-control shadow-none" type="text" name="phone" value="{{ old('phone') }}"
                            id="phone" placeholder="09123456789" required />
                    </div>
                    <!-- Company Name -->
                    <div class="col-md-6 col-12 mt-4">
                        <label for="company_name" class="form-label">Company Name<em style="color:red">*</em></label>
                        <input class="form-control shadow-none" type="text" name="company_name"
                            value="{{ old('company_name') }}" id="company_name" required />
                    </div>
                    <!--Admin Role-->
                    <div class="col-md-6 col-12 mt-4">
                        <label for="role" class="form-label">Admin Role<em style="color:red">*</em></label>
                        <select name="role" class="form-control shadow-none" id="role">

                            <Option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</Option>
                            <Option value="Super Admin" {{ old('role') == 'Super Admin' ? 'selected' : '' }}>Super Admin
                            </Option>

                        </select>
                    </div>
                    <!-- Password -->
                    <div class="col-md-6 col-12 mt-4">
                        <label for="password" class="form-label">Password<em style="color:red">*</em></label>
                        <div class="d-flex justify-content-start align-items-center border border-2 rounded-2 p-0 px-2">

                            <input class="form-control border-0 shadow-none" type="password" name="password" id="password"
                                required />

                            <span class="show-btn"><i class="bi bi-eye-fill "></i></span>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-12 mt-4">
                        <button class="btn btn-dark w-100">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
