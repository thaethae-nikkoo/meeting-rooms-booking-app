@extends('layout.backmaster')
@section('tit','Edit Admin')
@section('breadcrumb1','E.F.R Meeting Room Management System')

@section('body')
<div class="container mt-4">
    <div class="card py-xl-5 py-5 bg-white border-0 shadow-lg p-5">

        <form action="{{route('admin.update',$admin->id)}}" method="POST" class="mt-4">
            @method('PUT')
            @csrf
            <div class="row justify-content-center align-items-center flex-md-row flex-column flex-wrap">
                <!-- Username -->
                <div class="col-md-6 col-12 mt-1">
                    <label for="topic" class="form-label">Username<em style="color:red">*</em></label>
                    <input class="form-control shadow-none" type="text" value="{{$admin->name}}" name="name"
                        id="username" required />
                </div>
                <!-- Email -->
                <div class="col-md-6 col-12 mt-1">
                    <label for="email " class="form-label">Email<em style="color:red">*</em></label>
                    <input class="form-control shadow-none" type="email" value="{{$admin->email}}" name="email"
                        id="email" required />
                </div>
                <!-- Contact Number -->
                <div class="col-md-6 col-12 mt-4">
                    <label for="phone" class="form-label">Contact Number<em style="color:red">*</em></label>
                    <input class="form-control shadow-none" type="text" name="phone" value="{{$admin->phone}}"
                        id="phone" placeholder="09123456789" required />
                </div>
                <!-- Company Name -->
                <div class="col-md-6 col-12 mt-4">
                    <label for="company_name" class="form-label">Company Name<em style="color:red">*</em></label>
                    <input class="form-control shadow-none" type="text" name="company_name"
                        value="{{$admin->company_name}}" id="company_name" required />
                </div>
                <!--Admin Role-->
                <div class="col-md-6 col-12 mt-4">
                    <label for="role" class="form-label">Admin Role<em style="color:red">*</em></label>
                    <select name="role" class="form-control shadow-none" id="role">

                        <Option value="Admin" {{ $admin->role == 'Admin' ? 'selected' : ''
                            }}>Admin</Option>
                        <Option value="Super Admin" {{ $admin->role == 'Super Admin' ? 'selected' : ''
                            }}>Super Admin</Option>


                    </select>
                </div>
                <!-- Submit btn -->
                <div class="col-md-6 col-12 mt-5">

                    <!--Submit btn -->
                    <button class="btn btn-dark w-100 shadow-none py-2">Update</button>
                </div>
            </div>



        </form>
    </div>
</div>
@endsection
