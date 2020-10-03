@extends('master')
@section('title', 'Edit Category')
@section('content')

    <!-- general form elements disabled -->
    <div class="card card-success mx-lg-5">
        <div class="card-header">
            <h3 class="card-title p-2"> Chỉnh sửa chuyên mục</h3>
        </div>
      <!-- /.card-header -->
        
        <form role="form" method="POST" action="{{ route('category-product.update',['category_product' => $category['id']]) }}" enctype="multipart/form-data">
            @method("PUT")
            {{ csrf_field() }}
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i>Success</h5>
                        <b>{{ session('success') }}</b> updated!
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
                <input type="text" name="category_name" class="form-control p-3" placeholder="Enter ..." value="{{ $category['category_name'] }}">
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea class="form-control" name="category_description" rows="5" placeholder="Enter ...">{{ $category['category_description'] }}</textarea>
                </div> 
                <div class="form-group">
                    <label>Select</label>
                    <select class="form-control" name="category_parent">
                        <option value="0">Chuyên mục mẹ</option>
                        {!! $htmlOption !!}
                    </select>
                </div>
                <div class="form-group">
                    <label>Ảnh chuyên mục</label>
                    <div class="custom-file">
                      <input type="file" name="category_thumb" class="custom-file-input" id="customFile">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <img id="output" src="{{ $category['category_thumb'] == null ? asset('storage/thumbnail.png') : asset($category['category_thumb']) }}" alt="" class="img-thumbnail mt-2" style="max-width: 200px">

                </div>
                <div class="icheck-primary my-3">
                    <input type="checkbox" name="category_active" id="checkboxPrimary1" {{ $category['category_active'] == 1 ? 'checked' : ''}}>
                    <label for="checkboxPrimary1">  Hiển thị</label>
                </div>
                
            </div>
            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-success px-4 py-2">Save change</button>
            </div>
        </form>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    
    <!-- /.card -->
@endsection