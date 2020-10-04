@extends('master')
@section('title', 'Sub Menus')
@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
    <h3 class="card-title">{{ $menu_parent['menu_name'] }}</h3>
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
              @foreach ($menu as $key => $item)
              <tr>
                <td>
                    #{{ $item['id'] }}
                </td>
                <td>
                    <h5 class="font-weight-bolder">
                        {{ $item['menu_name'] }}
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
                <img src="{{ $item['menu_icon'] == null ? asset('storage/menu-default.png') : asset($item['menu_icon']) }}" alt="" class="img-thumbnail" style="max-width: 64px">
                </td>
                <td>
                  <small>{{ $item['menu_description'] }}</small>
                </td>
                <td class="project-state">
                    <span class="badge {{ $item['menu_active'] == 1 ? 'badge-success' : 'badge-danger' }}">{{ $item['menu_active'] == 1 ? 'Active' : 'Inactive' }}</span>
                </td>
                <td class="project-actions text-center">
                    <a class="btn btn-primary btn-sm" href="{{ route('menu.show',['menu' => $item['id']]) }}">
                        <i class="fas fa-folder">
                        </i>
                        View
                    </a>
                    <a class="btn btn-info btn-sm" href="{{ route('menu.edit',['menu' => $item['id'],'type' => 'update']) }}">
                        <i class="fas fa-pencil-alt">
                        </i>
                        Edit
                    </a>
                    <a class="btn btn-danger btn-sm" href="{{ route('menu.edit',['menu' => $item['id'],'type' => 'destroy']) }}">
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
  {{$menu->links("pagination::bootstrap-4")}}
@endsection