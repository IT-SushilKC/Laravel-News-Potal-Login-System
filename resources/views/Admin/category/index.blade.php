@extends('admin.includes.admin_design')
@section('title') Admin Dashboard @endsection
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">View All Categories</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admindashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Categories</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ route('category.add') }}" class="btn add-btn"><i class="fa fa-plus"></i> Create
                            Project</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            @if (Session::get('delete'))
                <div class="alert alert-danger">
                    {{ Session::get('delete') }}
                </div>
            @endif
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-0">

                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="datatable table table-stripped mb-0">
                                    <thead>
                                        <tr>
                                            <th>S.N.</th>
                                            <th>Categories Name</th>
                                            <th>Main Categories</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $i = 1;
                                    ?>
                                    <tbody>
                                        @foreach ($category as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->category_name }}</td>
                                                <td>
                                                    @if ($item->parent_id == 0)
                                                        Main Category
                                                    @else
                                                        {{ $item->subCategory->category_name }}
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <p class="text-success">Active</p>
                                                    @else
                                                        <p class="text-danger">In Active</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('category.edit', $item->id) }}"
                                                        class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                    <a href="javascript:" class="btn btn-danger deleteRecord"
                                                        rel="{{ $item->id }}" rel1="category-delete"><i
                                                            class="fa fa-trash"></i></a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /Page Wrapper -->
@endsection
@section('jscode')
    <script>
        $('body').on('click', '.deleteRecord', function(event) {
                    event.preventDefault();
                    var SITEURL = '{{ URL::to('') }}';
                    var id = $(this).attr('rel');
                    var deleteFunction = $(this).attr('rel1');

                    swal({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        },
                        function(){
                            window.location.href = SITEURL+"/admin/"+ deleteFunction+"/"+id;
                        });
                    });
    </script>
@endsection
