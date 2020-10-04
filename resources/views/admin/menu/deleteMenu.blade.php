@extends('master')
@section('title', 'Delete Menu')
@section('content')

    <!-- general form elements disabled -->
    <div class="card card-danger mx-lg-5">
        <div class="card-header">
            <h3 class="card-title p-2"> Xóa menu</h3>
        </div>
      <!-- /.card-header -->
        
        <form role="form" method="POST" action="{{ route('menu.destroy',['menu' => $menu['id']]) }}" enctype="multipart/form-data">
            @method("DELETE")
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
                
                <p> Bạn có chắc chắn muốn xóa menu <b> {{ $menu['menu_name'] }} </b>  không? </p>
                <small> <strong>* Note: </strong> xóa menu này đồng nghĩa với việc mọi menu con của menu này cũng sẽ bị xóa.
                Hãy backup menu con khi xóa</small>
            </div>
            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-danger px-4 py-2">Delete</button>
            </div>
        </form>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    
    <!-- /.card -->
@endsection