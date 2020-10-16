@extends('master')
@section('title', 'Product')
@section('css')
    
@endsection
@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">Danh sách sản phẩm</h3>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped projects">
        <thead>
            <tr>
                <th style="width: 1%">
                  #id
                </th>
                <th style="width: 20%">
                  Name
                </th>
                <th>
                  Price
                </th>
                <th>
                  Image
                </th>
                <th>
                  Content
                </th>
                <th class="text-center">
                  Status
                </th>
                <th class="text-center">
                  Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $key => $item)
            <tr>
              <td>
                  #{{ $item['id'] }}
              </td>
              <td>
                  <h5 class="font-weight-bolder">
                      {{ $item['name'] }}
                  </h5>
                  <small>
                    Created: {{ $item['created_at'] }}
                  </small>
                  <br>
                  <small>
                    Updated: {{ $item['updated_at'] }}
                  </small>
              </td>
              <td>
                {{ $item['price'] }} <b> <sup>đ</sup> </b>
              </td>
              <td>
              <img src="{{ $item['feature_image'] == null ? asset('storage/thumbnail.png') : asset($item['feature_image']) }}" alt="{{ $item['name'] }}" class="img-thumbnail" style="width: 200px; height: 200px; object-fit:cover">
              </td>
              <td>
                <small>{!! $item['content'] !!}</small>
              </td>
              <td class="project-state">
                  <span class="badge {{ $item['active'] == 1 ? 'badge-success' : 'badge-danger' }}">{{ $item['active'] == 1 ? 'Active' : 'Inactive' }}</span>
              </td>
              <td class="project-actions text-center">
              <a class="btn btn-primary btn-sm" href="{{ route('product-management.show',['product_management' => $item['id']]) }}">
                      <i class="fas fa-folder">
                      </i>
                      View
                  </a>
                  <a class="btn btn-info btn-sm" href="{{ route('product-management.edit',['product_management' => $item['id'],'type' => 'update']) }}">
                      <i class="fas fa-pencil-alt">
                      </i>
                      Edit
                  </a>
                  <a class="btn btn-danger btn-sm" href="{{ route('product-management.edit',['product_management' => $item['id'],'type' => 'destroy']) }}">
                      <i class="fas fa-trash">
                      </i>
                      Delete
                  </a>
              </td>
          </tr>
            @endforeach
            
        </tbody>
    </table>
  </div>
  <!-- /.card-body -->
</div>
{{$products->links("pagination::bootstrap-4")}}
@endsection
@section('js')

@endsection