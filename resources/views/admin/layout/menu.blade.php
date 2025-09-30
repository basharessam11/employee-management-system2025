<!-- Menu -->
@php
    use App\Models\Setting;
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo ">
        <a class="app-brand-link">
            <span class="app-brand-logo demo">
                <img style="width: 45px; height:auto"
                    src="{{ asset('images') }}/{{ Setting::find(1)->photo != null ? Setting::find(1)->photo : 'no-image.png' }}"
                    class="ms-auto" alt="logo" width="30" />
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{ Setting::find(1)->name }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- ###################### Employees Section Dropdown ###################### --}}
        @canany([
            'view users',
            'view units',
            'view departments',
            'view location',
            'view grades',
            'view jobs',
            'view result',
            'view department_user',
            'view position',
            ])
            <li
                class="menu-item {{ in_array(Request::route()->getName(), ['users.index', 'units.index', 'departments.index', 'department_user.show', 'result.index', 'location.index', 'grades.index', 'jobs.index', 'position.index']) ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class='menu-icon tf-icons bx bxs-user'></i>
                    <div class="text-truncate">{{ __('admin.Employees') }}</div>
                </a>
                <ul class="menu-sub">

                    {{-- Employees --}}
                    @can('view users')
                        <li class="menu-item {{ Request::route()->getName() == 'users.index' ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class="menu-link">
                                <div class="text-truncate">{{ __('admin.Employees') }}</div>
                            </a>
                        </li>
                    @endcan

                    {{-- Reports --}}
                    @can('view result')
                        <li class="menu-item {{ Request::route()->getName() == 'result.index' ? 'active' : '' }}">
                            <a href="{{ route('result.index', auth()->user()->id) }}" class="menu-link">
                                <div class="text-truncate">{{ __('admin.Reports') }}</div>
                            </a>
                        </li>
                    @endcan
                    {{-- Reports --}}
                    @can('view department_user')
                        @php
                            $user = Auth::user();
                            foreach ($user->department_user as $du) {
                                $department_id = $du->department->id;
                            }
                        @endphp
                        <li class="menu-item {{ Request::route()->getName() == 'department_user.show' ? 'active' : '' }}">
                            <a href="{{ route('department_user.show', $department_id) }}" class="menu-link">
                                <div class="text-truncate">{{ __('admin.Reports') }}</div>
                            </a>
                        </li>
                    @endcan


                    {{-- Units --}}
                    @can('view units')
                        <li class="menu-item {{ Request::route()->getName() == 'units.index' ? 'active' : '' }}">
                            <a href="{{ route('units.index') }}" class="menu-link">
                                <div class="text-truncate">{{ __('admin.Units') }}</div>
                            </a>
                        </li>
                    @endcan

                    {{-- Departments --}}
                    @can('view departments')
                        <li class="menu-item {{ Request::route()->getName() == 'departments.index' ? 'active' : '' }}">
                            <a href="{{ route('departments.index') }}" class="menu-link">
                                <div class="text-truncate">{{ __('admin.Departments') }}</div>
                            </a>
                        </li>
                    @endcan

                    {{-- Location --}}
                    @can('view location')
                        <li class="menu-item {{ Request::route()->getName() == 'location.index' ? 'active' : '' }}">
                            <a href="{{ route('location.index') }}" class="menu-link">
                                <div class="text-truncate">{{ __('admin.Location') }}</div>
                            </a>
                        </li>
                    @endcan

                    {{-- Grades --}}
                    @can('view grades')
                        <li class="menu-item {{ Request::route()->getName() == 'grades.index' ? 'active' : '' }}">
                            <a href="{{ route('grades.index') }}" class="menu-link">
                                <div class="text-truncate">{{ __('admin.Grades') }}</div>
                            </a>
                        </li>
                    @endcan

                    {{-- Jobs --}}
                    @can('view jobs')
                        <li class="menu-item {{ Request::route()->getName() == 'jobs.index' ? 'active' : '' }}">
                            <a href="{{ route('jobs.index') }}" class="menu-link">
                                <div class="text-truncate">{{ __('admin.Jobs') }}</div>
                            </a>
                        </li>
                    @endcan

                    {{-- Position --}}
                    @can('view position')
                        <li class="menu-item {{ Request::route()->getName() == 'position.index' ? 'active' : '' }}">
                            <a href="{{ route('position.index') }}" class="menu-link">
                                <div class="text-truncate">{{ __('admin.Position') }}</div>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcanany
        {{-- ###################### End Employees Section Dropdown ###################### --}}

        {{-- ###################### Roles ###################### --}}
        @can('view roles')
            <li class="menu-item {{ Request::route()->getName() == 'roles.index' ? 'active open' : '' }}">
                <a href="{{ route('roles.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-id-card'></i>
                    <div class="text-truncate">{!! __('admin.Roles') !!}</div>
                </a>
            </li>
        @endcan
        {{-- ###################### End Roles ###################### --}}

        {{-- ###################### HR ###################### --}}
        @can('view hr')
            <li class="menu-item {{ Request::route()->getName() == 'hr.index' ? 'active open' : '' }}">
                <a href="{{ route('hr.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-plane-alt'></i>
                    <div class="text-truncate">{!! __('admin.Human Resources') !!}</div>
                </a>
            </li>
        @endcan
        {{-- ###################### End HR ###################### --}}

        {{-- ###################### Settings ###################### --}}
        @can('view settings')
            <li class="menu-item {{ Request::route()->getName() == 'settings.index' ? 'active open' : '' }}">
                <a href="{{ route('settings.index') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-cog'></i>
                    <div class="text-truncate">{!! __('admin.Settings') !!}</div>
                </a>
            </li>
        @endcan
        {{-- ###################### End Settings ###################### --}}

    </ul>
</aside>
<!-- / Menu -->
