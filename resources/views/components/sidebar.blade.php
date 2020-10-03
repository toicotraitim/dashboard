 <!-- Sidebar Menu -->
 <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{route('admin.dashboard')}}" class="nav-link {{$activeUrl[4] == 'dashboard' ? 'active':''}}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
            
        </li>
        <li class="nav-item has-treeview {{$activeUrl[4] == 'category-product' ? 'menu-open':''}}">
            <a href="{{route('category-product.index')}}" class="nav-link {{$activeUrl[4] == 'category-product' ? 'active':''}}">
                <i class="nav-icon fas fa-folder"></i>
                <p>
                    Categories Pruduct
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('category-product.create')}}" class="nav-link {{$activeUrl[4] == 'category-product' &&  isset($activeUrl[5]) && $activeUrl[5] == 'create' ? 'active':''}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tạo chuyên mục</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('category-product.index')}}" class="nav-link {{$activeUrl[4] == 'category-product' &&  (isset($activeUrl[5]) === FALSE || $activeUrl[5] > 0) ? 'active':''}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liệt kê chuyên mục</p>
                  </a>
                </li>
              </ul>
        </li>
        <li class="nav-item has-treeview {{$activeUrl[4] == 'post-product' ? 'menu-open':''}}">
          <a href="{{route('category-product.index')}}" class="nav-link {{$activeUrl[4] == 'post-product' ? 'active':''}}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                  Posts Pruduct
                  <i class="fas fa-angle-left right"></i>
              </p>
          </a>
          <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('post-product.create')}}" class="nav-link {{$activeUrl[4] == 'post-product' && isset($activeUrl[5]) && $activeUrl[5] == 'create' ? 'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tạo chuyên mục</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('post-product.index')}}" class="nav-link {{$activeUrl[4] == 'post-product' &&  (isset($activeUrl[5]) === FALSE || $activeUrl[5] > 0) ? 'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Liệt kê chuyên mục</p>
                </a>
              </li>
            </ul>
      </li>
      <li class="nav-item has-treeview {{$activeUrl[4] == 'menu' ? 'menu-open':''}}">
        <a href="{{route('menu.index')}}" class="nav-link {{$activeUrl[4] == 'menu' ? 'active':''}}">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>
                Menus
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('menu.create')}}" class="nav-link {{$activeUrl[4] == 'menu' && isset($activeUrl[5]) && $activeUrl[5] == 'create' ? 'active':''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Tạo chuyên mục</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('menu.index')}}" class="nav-link {{$activeUrl[4] == 'menu' &&  (isset($activeUrl[5]) === FALSE || $activeUrl[5] > 0) ? 'active':''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Liệt kê chuyên mục</p>
              </a>
            </li>
          </ul>
    </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
