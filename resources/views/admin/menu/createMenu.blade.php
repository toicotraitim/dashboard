@extends('master')
@section('title', 'Create Menu')
@section('css')
    <link href="plugins/select2/css/select2.min.css" rel="stylesheet" />
    
@endsection
@section('content')

    <!-- general form elements disabled -->
    <div class="card card-primary mx-lg-5">
        <div class="card-header">
            <h3 class="card-title p-2"> Tạo menu</h3>
        </div>
      <!-- /.card-header -->
        
        <form role="form" method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data">
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
                    <label>Tên menu</label>
                    <input type="text" name="menu_name" class="form-control p-3" placeholder="Enter ...">
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea class="form-control" name="menu_description" rows="5" placeholder="Enter ..."></textarea>
                </div> 
                <div class="form-group">
                    <label>Select</label>
                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" name="menu_parent">
                        <option value="0">Menu mẹ</option>
                        {!! $htmlOption !!}
                    </select>
                </div>
                <div class="form-group">
                    <label>Icon menu</label>
                    
                    <div class="custom-file">
                      <input type="file" name="menu_icon" class="custom-file-input" id="customFile">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <img id="output" alt="" class="img-thumbnail mt-2" style="display: none; max-width: 200px">

                </div>
                <div class="icheck-primary my-3">
                    <input type="checkbox" name="menu_active" id="checkboxPrimary1" checked="">
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
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".select2").select2();
            bsCustomFileInput.init();
            document.getElementById("customFile").addEventListener("change",function(event) {
                let reader = new FileReader();
                    reader.onload = function(){
                        var output = document.getElementById('output');
                        output.style.display = 'block';
                        output.src = reader.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
            });
        });
    </script>
    
@endsection