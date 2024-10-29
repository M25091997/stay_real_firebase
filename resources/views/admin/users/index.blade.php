@extends('layouts.admin')

@push('title')
<title>Dashboard | Star Lotus</title>
@endpush

@section('main-section')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Select Criteria</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->


            <div class="row">
                <div class="col-12">
                  
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Users List</h4>
                            <div class="flex-shrink-0">
                                {{-- <div class="d-flex flex-wrap gap-2 mb-0 my-n1">
                                  <a href="{{url('admin/guests/create')}}">  <button type="button" class="btn btn-dark waves-effect waves-light justify"> <i class="fa fa-plus" aria-hidden="true"></i> Guest Register <i class="fa fa-registered" aria-hidden="true"></i></button> </a>

                                </div> --}}
                            </div>
                        </div>

                        {{-- <div class="card-header">
                         
                            <div class="row">
                                <div class="col-lg-8">



                                    <form action="#" method="post" class="row gx-3 gy-2 align-items-center mb-4 mb-lg-0">
                                        @csrf

                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label">Class</label> 
                                                <select class="form-select" id="class" name="class">
                                                    <option>Select class</option>
                                                    @foreach([]; as $class)
                                                    <option value="{{$class->id}}">{{$class->class_name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-3">
                                                <label class="form-label">Section</label>
                                                <select id="section" class="form-select" name="section">
                                                    <option value="">Select section</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto">
                                            <button type="submit" class="btn btn-success btm-sm mt-2">Submit</button>
                                        </div>
                                    </form>
                                </div>
                              


                               
                            </div>
                           
                        </div> --}}


                    </div>
                

                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>                
                                    <th>Sno</th>                                
                                    <th>Uid</th>                                
                                    <th>Name</th>                                
                                    <th>Email</th>                                
                                    <th>Phone</th>                                  
                                    <th>Profile Image</th> 
                                    <th>Create At</th>                                 
                                    <th>Friends</th>                                 
                                    <th>Pending Request</th>                                 
                                    <th>Action</th>                                         
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user['data']['uid']}}</td>
                                    <td>{{$user['data']['displayName']}}</td>
                                    <td>{{$user['data']['email']}}</td>
                                    <td>{{'--'}}</td>                                  
                                    <td> <a href="{{ $user['data']['photoURL'] }}" target="_blank"> <img src="{{$user['data']['photoURL']}}" alt="{{$user['data']['displayName']}}" class="avatar-xl rounded-circle img-thumbnail"> </a> </td>
                                    <td>{{ \Carbon\Carbon::parse($user['data']['createdAt'])->format('d/m/Y H:i:s') }} </td>
                                    
                                    <td> <a href="{{ route('user.friends', $user['id']) }}" class="btn btn-sm btn-success">
                                       <i class="fa fa-list" aria-hidden="true"></i>
                                       </a>  
                                    </td>
                                

                                    <td> <a href="{{ route('user.requestFriends', $user['id']) }}" class="btn btn-sm btn-warning">
                                       <i class="fa fa-list" aria-hidden="true"></i>
                                       </a>  
                                    </td>
                                    <td>                                       
                                                                               
                                       
                                        <form action="{{ route('delete.user', $user['id']) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')                                    
                                            <button type="submit" class="btn btn-sm btn-danger delete-purchase">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                    
                                </tr>

                                @endforeach
                                                           
                            </tbody>                       
                        </table>
                    </div>

                  
                </div>
                <!-- end cardaa -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->



</div>
<!-- end main content-->
<style>
    .pagination {
        float: inline-end;

    }
</style>


@endsection