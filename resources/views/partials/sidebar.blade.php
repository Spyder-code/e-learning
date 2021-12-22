<!-- Sidebar -->
<aside class="main-sidebar fixed offcanvas shadow">
   <section class="sidebar">
      <div class="mt-3 mb-3 ml-3">
         <h5 class="s-18 has-icon">E-Learningku</h5>
      </div>
      <div class="relative">
         <a data-toggle="collapse" href="#userSettingsCollapse" role="button" aria-expanded="false"
            aria-controls="userSettingsCollapse"
            class="btn-fab btn-fab-sm fab-right fab-top btn-primary shadow1 collapsed">
            <i class="icon icon-cogs"></i>
         </a>
         @php
         $user = Auth::user();
         @endphp
         <div class="user-panel light p-3 mb-2">
            <div>
               <div class="float-left image">
                  <img class="user_avatar" src="{{ $user['avatar'] }}" alt="{{ $user['name'] }}">
               </div>
               <div class="float-left info">
                  <h6 class="font-weight-light mt-2 mb-1">{{ strtok($user['name'], " ") }}</h6>
                  <span>{{ $user['name'] }}</span>
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="multi-collapse collapse" id="userSettingsCollapse" style="">
               <div class="list-group mt-3 shadow">
                  <a href="{{ route('profile', $user->username) }}" class="list-group-item list-group-item-action">
                     <i class="mr-2 icon-umbrella text-blue"></i>Profile
                  </a>
                  <a href="{{ route('edit-password', $user->username) }}"
                     class="list-group-item list-group-item-action"><i class="mr-2 icon-security text-purple"></i>Change
                     Password</a>
               </div>
            </div>
         </div>
      </div>
      <ul class="sidebar-menu">
         @can('admin')
         <li class="{{ setActive('dashboard') }}"><a href="{{ route('dashboard') }}">
               <i class="icon icon-dashboard2 s-18 text-yellow"></i>Dashboard
            </a>
         </li>
         @endcan
         @if (Auth::user()->role!='admin')
         <li
            class="{{ setActive(['classroom.index', 'classroom.student', 'classroom.create','classroom.edit', 'classroom.show']) }}">
            <a href="{{ route('classroom.index') }}"><i
                  class="icon icon-room_service s-18 text-purple"></i>Classroom</a>
         </li>
         @endif
         @can('admin')
         <li class="header">
            <strong>Data Master</strong>
         </li>
         <li class="{{ setActive(['user.guru', 'users/create/Guru']) }}"><a href="{{ route('user.guru') }}"><i
                  class="icon icon-account_circle s-18 text-green"></i>Guru</a></li>
         <li class="{{ setActive(['user.siswa',route('users.create',['name'=>'Siswa'])]) }}"><a
               href="{{ route('user.siswa') }}"><i class="icon icon-account_circle s-18 text-green"></i>Siswa</a></li>
         <li class="{{ setActive(['room.*'])}}"><a href="{{ route('room.index') }}"><i
                  class="icon icon-class s-18 text-green"></i>Kelas</a></li>
         <li class="{{ setActive(['post.*']) }}"><a href="{{ route('post.index') }}"><i
                  class="icon icon-account_circle s-18 text-green"></i>Post</a></li>
         <li class="{{ setActive(route('post.edit', ['post' => 1])) }}"><a
               href="{{ route('post.edit', ['post' => 1]) }}"><i
                  class="icon icon-account_circle s-18 text-green"></i>Informasi PPDB</a></li>
         @endcan
         <li class="header">
            <strong>Akun</strong>
         </li>
         <li><a href="{{route('logout')}}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
               <i class="icon icon-exit_to_app s-18"></i>Logout</a>
            <form id="logout-form" action="{{route('logout')}}" method="POST" style="display:none;">
               @csrf
            </form>
         </li>


      </ul>
   </section>
</aside>
<!--Sidebar End-->