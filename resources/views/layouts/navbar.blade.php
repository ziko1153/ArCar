    <!-- Secondary navbar -->
    <div class="navbar navbar-expand-md navbar-light navbar-sticky">
      
        <div class="text-center d-md-none w-100">
           <h2> AR Car Hire & Sale</h2>
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                data-target="#navbar-navigation">
                <i class="icon-unfold mr-2"></i>
                Navigation
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbar-navigation">
            <h2 style="margin-right:10%"> AR Car Hire & Sale CMS </h2>
            <ul class="navbar-nav">
            <li class="nav-item">
                <a href="/" class="navbar-nav-link {{ Request::is('/') ? 'active' : '' }}">
                        <i class="icon-home4 mr-2"></i>
                        Dashboard
                    </a>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-car mr-2"></i>
                    Car Hire
                </a>

                <div class="dropdown-menu">
        
                   <a href="{{route('car.create')}}" class="dropdown-item  {{ Request::routeIs('car.create') ? 'active' : '' }}">
                    <i class="icon-list mr-2"></i>
                    Car Add
                  </a>
           

                  <a href="{{route('car.show')}}" class="dropdown-item {{ Request::routeIs('car.show') ? 'active' : '' }}">
                    <i class="icon-stack mr-2"></i>
                    Hire List
                  </a>

                  
                
                </div>
            </li>

            <li class="nav-item">
            <a href="{{route('car.sale')}}" class="navbar-nav-link {{ Request::routeIs('car.sale') ? 'active' : '' }}">
                        <i class="icon-mirror mr-2"></i>
                        Sales Car
                    </a>
            </li>

            <li class="nav-item">
                <a href="/customer" class="navbar-nav-link {{ Request::is('/customer') ? 'active' : '' }}">
                            <i class="icon-users4 mr-2"></i>
                           Customer
                        </a>
                </li>

            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-strategy mr-2"></i>
                    Report Section
                </a>

                <div class="dropdown-menu">
                   <a class="dropdown-item" href="#" ><i class="icon-car"></i>Hire Report</a>
                   <div class="dropdown-item"> <i class="icon-users4"></i>Sale Report  </div>
                
                </div>
            </li>


            </ul>

            <ul class="navbar-nav ml-md-auto">

                <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle"
                        data-toggle="dropdown">
                        <img src="/global_assets/images/placeholders/placeholder.jpg"
                            class="rounded-circle mr-2" height="34" alt="">
                        <span>Admin</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a>
                        <a href="#" class="dropdown-item" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
         <i class="icon-switch2"></i>   {{ __('Logout') }} </a>

         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
                    </div>
                </li>
            </ul>

            
        </div>
    </div>
    <!-- /secondary navbar -->