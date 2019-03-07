<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo 
    <a href="/home#/dashboard" class="brand-link">
      <img src="../images/logo.png" alt="MAI Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ __('menus.admin_area') }}</span>
    </a>-->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <user-box></user-box>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt blue"></i>
              <p>
              {{ __('menus.dashboard') }}
              </p>
            </router-link>
          </li>
          @role('admin')      
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shield-alt yellow"></i>
              <p>
              {{ __('menus.auth_managment') }}
                @if(App::isLocale('fa'))
                <i class="right fa fa-angle-right"></i>
                @elseif(App::isLocale('en'))
                <i class="right fa fa-angle-left"></i>
                @endif
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" class="nav-link">
                  <i class="fas fa-users-cog nav-icon indigo"></i>
                  <p>{{ __('menus.users') }}</p>
                </router-link>
              </li>
              <li class="nav-item">
              <router-link to="/user_roles" class="nav-link">
                  <i class="fas fa-users nav-icon teal"></i>
                  <p>{{ __('menus.user_roles') }}</p>
                </router-link>
              </li>
              <li class="nav-item">
              <router-link to="/user_permissions" class="nav-link">
                  <i class="fas fa-user-lock  nav-icon red"></i>
                  <p>{{ __('menus.user_permissions') }}</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/profile_structures" class="nav-link">
                  <i class="nav-icon fas fa-table cyan"></i>
                  <p>
                  {{ __('menus.profile_structure') }}
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/password_policies" class="nav-link">
                  <i class="nav-icon  fas fa-lock purple"></i>
                  <p>
                  {{ __('menus.password_policy') }}
                  </p>
                </router-link>
              </li>              
            </ul>
          </li>
          @endrole
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-info lighGray"></i>
              <p>
              {{ __('menus.basic_information') }}
                @if(App::isLocale('fa'))
                <i class="right fa fa-angle-right"></i>
                @elseif(App::isLocale('en'))
                <i class="right fa fa-angle-left"></i>
                @endif
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/#" class="nav-link">
                  <i class="nav-icon fas fa-table cyan"></i>
                  <p>
                  {{ __('menus.item') }}
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <router-link to="/profiles" class="nav-link">
              <i class="nav-icon fas fa-user orange"></i>
              <p>
              {{ __('menus.profile') }}
              </p>
            </router-link>
          </li>
          <li class="nav-item">       
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-power-off red"></i>
                <p>                                
                    {{ __('menus.logout') }}
                </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
