<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home#/dashboard" class="brand-link">
      <img src="../images/logo.png" alt="MAI Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ __('menus.adminArea') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../images/profile.png" class="img-circle elevation-2" alt="User Image">
		  <span class="brand-text font-weight-light" style="color:#fff">{{ __('app.baharRadiology') }}</span>
        </div>
        <div class="info">
          <a href="#" class="d-block"> {{ Auth::user()->name }}</a>
        </div>
      </div>
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
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog lighGray"></i>
              <p>
              {{ __('menus.configuration') }}
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
                  <i class="fa fa-users nav-icon indigo"></i>
                  <p>{{ __('menus.users') }}</p>
                </router-link>
              </li>
              <li class="nav-item">
              <router-link to="/user_groups" class="nav-link">
                  <i class="fa fa-users-cog  nav-icon teal"></i>
                  <p>{{ __('menus.userGroups') }}</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-info lighGray"></i>
              <p>
              {{ __('menus.basicInformation') }}
                @if(App::isLocale('fa'))
                <i class="right fa fa-angle-right"></i>
                @elseif(App::isLocale('en'))
                <i class="right fa fa-angle-left"></i>
                @endif
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/profileStructure" class="nav-link">
                  <i class="nav-icon fas fa-table cyan"></i>
                  <p>
                  {{ __('menus.profileStructure') }}
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/specialities" class="nav-link">
                  <i class="nav-icon fas fa-table cyan"></i>
                  <p>
                  {{ __('menus.speciality') }}
                  </p>
                </router-link>
              </li>
              <!-- Begin Radiology menu --->
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-toolbox green"></i>
                  <p>
                  {{ __('menus.preventiveServiceManagment') }}
                    @if(App::isLocale('fa'))
                    <i class="right fa fa-angle-right"></i>
                    @elseif(App::isLocale('en'))
                    <i class="right fa fa-angle-left"></i>
                    @endif
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <router-link to="/preventiveService" class="nav-link">
                      <i class="fa fa-wrench nav-icon indigo"></i>
                      <p>{{ __('menus.preventiveService') }}</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link to="/userGroups" class="nav-link">
                        <i class="fa fa-tasks  nav-icon teal"></i>
                        <p>{{ __('menus.preventiveServicePlanning') }}</p>
                    </router-link>
                  </li>
                </ul>
              </li>
              <!-- End equipment and machinery Services menu --->
            </ul>
          </li>
          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
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
