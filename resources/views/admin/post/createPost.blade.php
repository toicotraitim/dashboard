@extends('master')
@section('title', 'Create Categories')
@section('content')

    <!-- general form elements disabled -->
    <div class="card card-primary mx-lg-5">
        <div class="card-header">
            <h3 class="card-title p-2"> Tạo sản phẩm</h3>
        </div>
      <!-- /.card-header -->
        
        <form role="form" method="POST" action="{{ route('post-product.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i>Success</h5>
                        <b>{{ session('success') }}</b> created!
                    </div>
                    
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- text input -->
                <div class="form-group">
                    <label>Tên chuyên mục</label>
                    <input type="text" name="post_name" class="form-control p-3" placeholder="Enter ...">
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea class="form-control" name="post_description" rows="5" placeholder="Enter ..."></textarea>
                </div> 
                <div class="form-group">
                    <label>Select</label>
                    <select class="form-control" name="category">
                        <option value="0">Chuyên mục mẹ</option>
                        @foreach ($category_parent as $item)
                            <option value="{{ $item['id'] }}">{{ $item['category_name'] }}</option>
                        @endforeach
                    
                    </select>
                </div>
                <div class="form-group">
                    <label>Ảnh chuyên mục</label>
                    
                    <div class="custom-file">
                      <input type="file" name="post_images" class="custom-file-input" id="customFile">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <img id="output" alt="" class="img-thumbnail mt-2" style="display: none; max-width: 200px">

                </div>
                <div class="icheck-primary my-3">
                    <input type="checkbox" name="post_active" id="checkboxPrimary1" checked="">
                    <label for="checkboxPrimary1">  Hiển thị</label>
                </div>
                
            </div>
            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary px-4 py-2">Submit</button>
            </div>
        </form>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    
    <!-- /.card -->
@endsection