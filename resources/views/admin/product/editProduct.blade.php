@extends('master')
@section('title', 'Edit Product')
@section('css')
    <link href="plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
@endsection
@section('content')

    <!-- general form elements disabled -->
    <div class="card card-primary mx-lg-5">
        <div class="card-header">
            <h3 class="card-title p-2"> Chỉnh sửa sản phẩm</h3>
        </div>
      <!-- /.card-header -->
        
        <form role="form" name="form" method="POST" action="{{ route('product-management.update',['product_management' => $product['id']]) }}" enctype="multipart/form-data">
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
                    <label>Tên sản phẩm</label>
                <input type="text" name="name" class="form-control p-3" placeholder="Enter ..." value="{{ $product['name'] }}">
                </div>

                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea name="content" class="textarea" placeholder="Place some text here" style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid rgb(221, 221, 221); padding: 10px; display: none;">{{ $product['content'] }}</textarea>
                </div> 
                <div class="form-group">
                    <label>Giá tiền</label>
                    <input type="number" name="price" class="form-control p-3" placeholder="1234" value="{{ $product['price'] }}">
                </div>
                <div class="form-group">
                    <label>Chọn chuyên mục</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" name="category_id">
                        {!! $htmlOptionCategory !!}
                    </select>
                </div>
                <div class="form-group">
                    <label>Tags</label>
                    <select name="tags[]" class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select a State" style="width: 100%;" aria-hidden="true">
                        {!! $htmlOptionTag !!}
                    </select>
                </div>
                <div class="form-group">
                    <label>Ảnh hiển thị </label>
                    
                    <div class="custom-file">
                      <input type="file" name="feature_image" class="custom-file-input customFile">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <div id="outputFile" style="display: inline-block;"><img id="output" src="{{ $product['feature_image'] == null ? asset('storage/thumbnail.png') : asset($product['feature_image']) }}" alt="" class="mt-2 mr-2" style="max-width: 200px; max-height: 200px;"></div>

                </div>
                <div class="form-group" id="imgs">
                    <label>Ảnh sản phẩm</label>
                    <div class="custom-file mb-2">
                        <input type="file" name="images" class="custom-file-input images" multiple>
                        <label class="custom-file-label" for="customFile" style="overflow: hidden">Choose file</label>
                    </div>
                    {!! $htmlImage !!}
                </div>
                
                <div class="icheck-primary my-3">
                    <input type="checkbox" name="active" id="checkboxPrimary1" {{ $product['active'] == 1 ? 'checked' : ''}}>
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
@section('js')
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.textarea').summernote();
            $(".select2").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
            bsCustomFileInput.init();
            function imagePreview(file) {

                return new Promise(resolve => {
                    let =  reader = new FileReader();
                    reader.onload = function(event) {
                        resolve(event.target.result);
                    }
                    reader.readAsDataURL(file);
                });
            }
            async function preview(element,res) {
                let result = await imagePreview(element.files[0]);
                $(res).html(`<img src="${result}" class="mt-2 mr-2" style="max-width: 200px; max-height: 200px; object-fit: cover">`);
            }
            $(".customFile").change(function() {
                preview(this,'#outputFile');
            });
        });
    </script>
    
@endsection