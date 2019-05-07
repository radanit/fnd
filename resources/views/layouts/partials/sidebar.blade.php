<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/home#/dashboard" class="brand-link">
      <img src="../assets/images/logo.png" alt="Radan Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ __('app.app_name') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <user-box></user-box>
      <!-- Sidebar Menu -->
      <nav class="mt-3">
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
          @ability('admin')      
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shield-alt orange"></i>
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
                  <i class="fas fa-users-cog nav-icon orange"></i>
                  <p>{{ __('menus.users') }}</p>
                </router-link>
              </li>
              <li class="nav-item">
              <router-link to="/user_roles" class="nav-link">
                  <i class="fas fa-users nav-icon orange"></i>
                  <p>{{ __('menus.user_roles') }}</p>
                </router-link>
              </li>
              <li class="nav-item">
              <router-link to="/user_permissions" class="nav-link">
                  <i class="fas fa-user-lock  nav-icon orange"></i>
                  <p>{{ __('menus.user_permissions') }}</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/profile_structures" class="nav-link">
                  <i class="nav-icon fas fa-table orange"></i>
                  <p>
                  {{ __('menus.profile_structure') }}
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/password_policies" class="nav-link">
                  <i class="nav-icon  fas fa-lock orange"></i>
                  <p>
                  {{ __('menus.password_policy') }}
                  </p>
                </router-link>
              </li>              
            </ul>
          </li>
          @endability
          <!-- Begin Basic Info menu --->
<<<<<<< HEAD
          @ability('admin','can-manage-radiology,can-register-reception')
=======
          @role(['admin','radioadmin'])
>>>>>>> 77c031e34396b2e59cfc0059da9631a7a1bf3327
          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-info cyan"></i>
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
                <router-link to="/specialities" class="nav-link">
                  <i class="nav-icon fas fa-table cyan"></i>
                  <p>
                  {{ __('menus.speciality') }}
                  </p>
                </router-link>
              </li>
              <!--<li class="nav-item">
                <router-link to="/doctors" class="nav-link">
                  <i class=" nav-icon fas fa-user-md teal"></i>
                  <p>
                  {{ __('menus.doctor_management') }}
                  </p>
                </router-link>
              </li>-->
              <li class="nav-item">
                <router-link to="/radio_types" class="nav-link">
                  <i class="nav-icon fas fa-images cyan"></i>
                  <p>
                  {{ __('menus.radio_type_management') }}
                  </p>
                </router-link>
              </li>                              
            </ul>
          </li>
          @endability
          <!-- End Basic Info menu --->

          <!-- Begin Radiology menu --->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-receipt green"></i>
              <p>
              {{ __('menus.reception_management') }}
                @if(App::isLocale('fa'))
                <i class="right fa fa-angle-right"></i>
                @elseif(App::isLocale('en'))
                <i class="right fa fa-angle-left"></i>
                @endif
              </p>
            </a>
            <ul class="nav nav-treeview">
<<<<<<< HEAD
              @ability('admin','can-register-reception')
=======
              @role(['admin','radioadmin','receptor'])
>>>>>>> 77c031e34396b2e59cfc0059da9631a7a1bf3327
              <li class="nav-item">
                <router-link to="/receptions" class="nav-link">
                  <i class="fas fa-id-badge nav-icon green"></i>
                  <p>{{ __('menus.reception') }}</p>
                </router-link>
              </li>
<<<<<<< HEAD
              @endability
              @ability('admin','can-capture-reception')
=======
              @endrole
              @role(['admin','radioadmin','expert'])
>>>>>>> 77c031e34396b2e59cfc0059da9631a7a1bf3327
              <li class="nav-item">
                <router-link to="/registered_receptions" class="nav-link">
                  <i class="fas fa-registered nav-icon green"></i>
                  <p>{{ __('menus.registered_reception') }}</p>
                </router-link>
              </li>
<<<<<<< HEAD
              @endability
              @ability('admin','can-result-reception')
=======
              @endrole
              @role(['admin','radioadmin','doctor'])
>>>>>>> 77c031e34396b2e59cfc0059da9631a7a1bf3327
              <li class="nav-item">
                <router-link to="/captured_receptions" class="nav-link">
                  <i class="fas fa-camera-retro nav-icon green"></i>
                  <p>{{ __('menus.captured_reception') }}</p>
                </router-link>
              </li>
<<<<<<< HEAD
              @endability
              @ability('admin','can-capture-reception')
=======
              @endrole
              @role(['admin','radioadmin','doctor','patient'])
>>>>>>> 77c031e34396b2e59cfc0059da9631a7a1bf3327
              <li class="nav-item">
                <router-link to="/completed_receptions" class="nav-link">
                  <i class="fas fa-tasks nav-icon green"></i>
                  <p>{{ __('menus.completed_reception') }}</p>
                </router-link>
              </li>
<<<<<<< HEAD
              @endability
              @ability('admin','can-capture-reception')
=======
              @endrole
              @role(['admin','radioadmin','doctor','expert','receptor'])
>>>>>>> 77c031e34396b2e59cfc0059da9631a7a1bf3327
              <li class="nav-item">
                <router-link to="/rejected_receptions" class="nav-link">
                  <i class="fas fa-low-vision nav-icon green"></i>
                  <p>{{ __('menus.rejected_reception') }}</p>
                </router-link>
              </li>
              @endability                                                
            </ul>
          </li>
          <!-- End Radiology menu --->
          <!--<li class="nav-item">
            <router-link to="/profiles" class="nav-link">
              <i class="nav-icon fas fa-user orange"></i>
              <p>
              {{ __('menus.profile') }}
              </p>
            </router-link>
          </li>-->
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
