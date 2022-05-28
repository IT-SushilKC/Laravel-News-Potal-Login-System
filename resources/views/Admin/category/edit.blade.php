@extends('admin.includes.admin_design')
@section('title') Admin Dashboard - Edit Catrgory @endsection
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Edit Categories</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admindashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Category</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ route('category.index') }}" class="btn add-btn"><i class="fa fa-plus"></i> View
                            All Category</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <form action="{{ route('category.update',$category->id) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_id">Under Category</label>
                                            <select name="parent_id" id="parent_id" class="form-control">
                                                <option value="0">Main Category</option>
                                                @foreach ($categories as $data)
                                                <option value="{{$data->id}}" @if($data->id == $category->parent_id) selected @endif>{{$data->category_name}}</option>  
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('parent_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_name">Category Name</label>
                                            <input type="text" class="form-control" name="category_name"
                                                id="category_name" value="{{$category->category_name}}">
                                            <span class="text-danger">
                                                @error('category_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="category_name">Category Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{$category->description}}</textarea>
                                            <span class="text-danger">
                                                @error('description')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="status"
                                                    name="status" @if($category->status == 1) checked @endif>
                                                <label class="form-check-label" for="status">
                                                    Mark As Active
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Update Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- /Page Wrapper -->
    @endsection
