<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@yield('title')</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    @foreach ($url as $key => $item)
                        @if ($key >= 3)
                            @if ($loop->last)
                                <li class="breadcrumb-item"> {{ ucwords(implode(" ",explode("-",$item))) }} </li>                       
                                
                            @else
                                <li class="breadcrumb-item"><a href="{{ implode("/",array_slice($url,0,$key+1)) }}"> {{ ucwords(implode(" ",explode("-",$item))) }} </a></li>                       
                                
                            @endif
                        @endif
                    @endforeach
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->