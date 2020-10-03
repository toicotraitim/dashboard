@extends('master')
@section('title', 'Categories Product')
@section('content')
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">Categories Parent</h3>
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
                <th style="width: 30%">
                  Image
                </th>
                <th>
                  Description
                </th>
                <th style="width: 8%" class="text-center">
                  Status
                </th>
                <th style="width: 20%" class="text-center">
                  Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($category as $key => $item)
            <tr>
              <td>
                  #{{ $item['id'] }}
              </td>
              <td>
                  <h5 class="font-weight-bolder">
                      {{ $item['category_name'] }}
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
              <img src="{{ $item['category_thumb'] == null ? asset('storage/thumbnail.png') : asset($item['category_thumb']) }}" alt="" class="img-thumbnail" style="max-width: 200px">
              </td>
              <td>
                <small>{{ $item['category_description'] }}</small>
              </td>
              <td class="project-state">
                  <span class="badge {{ $item['category_active'] == 1 ? 'badge-success' : 'badge-danger' }}">{{ $item['category_active'] == 1 ? 'Active' : 'Inactive' }}</span>
              </td>
              <td class="project-actions text-center">
              <a class="btn btn-primary btn-sm" href="{{ route('category-product.show',['category_product' => $item['id']]) }}">
                      <i class="fas fa-folder">
                      </i>
                      View
                  </a>
                  <a class="btn btn-info btn-sm" href="{{ route('category-product.edit',['category_product' => $item['id'],'type' => 'update']) }}">
                      <i class="fas fa-pencil-alt">
                      </i>
                      Edit
                  </a>
                  <a class="btn btn-danger btn-sm" href="{{ route('category-product.edit',['category_product' => $item['id'],'type' => 'destroy']) }}">
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
{{$category->links("pagination::bootstrap-4")}}
@endsection