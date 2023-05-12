<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            @can('user_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        Gestion des utilisateurs
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}"
                                    class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    Permissions
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}"
                                    class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    Roles
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    Utilisateurs
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}?role=3"
                                    class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    Professeurs
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}?role=4"
                                    class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    Etudiants
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan


            @can("school_class_access")
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users nav-icon">

                    </i>
                    Gestion des classes
                </a>
                <ul class="nav-dropdown-items">

                    <li class="nav-item">
                        <a href="{{ route('admin.sections.index') }}"
                            class="nav-link {{ request()->is('admin/sections') || request()->is('admin/sections/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-school nav-icon">

                            </i>
                            Sections
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.groups.index') }}"
                            class="nav-link {{ request()->is('admin/groups') || request()->is('admin/groups/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-school nav-icon">

                            </i>
                            Groupes
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.salles.index') }}"
                            class="nav-link {{ request()->is('admin/calendar') || request()->is('admin/calendar/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-calendar nav-icon">

                            </i>
                            Salles
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('school_class_access')
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users nav-icon">

                    </i>
                    Gestion des matieres
                </a>
                <ul class="nav-dropdown-items">

                    <li class="nav-item">
                        <a href="{{ route('admin.modules.index') }}"
                            class="nav-link {{ request()->is('admin/modules') || request()->is('admin/modules/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-school nav-icon">

                            </i>
                            Modules
                        </a>
                    </li>
                    
                        <li class="nav-item">
                            <a href="{{ route('admin.school-classes.index') }}"
                                class="nav-link {{ request()->is('admin/school-classes') || request()->is('admin/school-classes/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-school nav-icon">

                                </i>
                                Elements
                            </a>
                        </li>
                </ul>
            </li>
            @endcan

            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users nav-icon">

                    </i>
                    Gestion des emplois du temps
                </a>
                <ul class="nav-dropdown-items">

                    {{-- @can('lesson_access')
                        <li class="nav-item">
                            <a href="{{ route('admin.lessons.index') }}"
                                class="nav-link {{ request()->is('admin/lessons') || request()->is('admin/lessons/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-clock nav-icon">

                                </i>
                                Seances
                            </a>
                        </li>
                    @endcan --}}


                    <li class="nav-item">
                        <a href="{{ route('admin.timetables.index') }}"
                            class="nav-link {{ request()->is('admin/calendar') || request()->is('admin/calendar/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-calendar nav-icon">

                            </i>
                            Emplois des temps
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
