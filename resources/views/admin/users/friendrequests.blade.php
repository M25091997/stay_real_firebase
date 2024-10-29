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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Friends</a></li>
                                <li class="breadcrumb-item active">Request</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Friend Requests List</h4>
                            <div class="flex-shrink-0">
                            </div>
                        </div>
                    </div>
                

                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>                
                                    <th>Sno</th>                                
                                    <th>Uid</th>                                
                                    <th>Friends Name</th>                                
                                    <th>Email</th>                                
                                    <th>Phone</th>                                  
                                    <th>Profile Image</th> 
                                    <th>Create At</th> 
                                    <th>Status </th>                               
                                                                    
                                    {{-- <th>Action</th>                                          --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allDocuments as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user['friend_id']}}</td>
                                    <td>{{$user['displayName']}}</td>
                                    <td>{{$user['email']}}</td>
                                    <td>{{'--'}}</td>                                  
                                    <td> <img src="{{$user['photoURL']}}" alt="{{$user['displayName']}}" class="avatar-xl rounded-circle img-thumbnail"></td>
                                    <td>{{ \Carbon\Carbon::parse($user['createdAt'])->format('d/m/Y H:i:s') }} </td>
                                    <td> <span class=" {{ $user['type'] == 'Sended request' ? 'bg-primary':'bg-success' }}  badge me-2 p-1">{{ $user['type'] }}</span> </td>
                                        
                                        {{-- <div class="badge {{ $user['type'] == 'Sended request' ? ' badge-soft-warning':'badge-soft-success' }}  font-size-12">  {{ $user['type'] }} </div> </td> --}}
                                    
                                    {{-- <td>
                                    
                                        <form action="{{ url('admin/users/'. $user['friend_id']) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')                                    
                                            <button type="submit" class="btn btn-sm btn-danger delete-purchase">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td> --}}
                                    
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