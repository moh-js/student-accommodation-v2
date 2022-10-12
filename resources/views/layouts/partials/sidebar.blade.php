@php
    $navigations = collect([
        [
            'title' => 'Dashboard', 'url' => route('dashboard'), 'permission' => request()->user()->hasAnyPermission('dashboard'), 'icon' => 'ri-dashboard-line', 'childrens' => collect(),
        ], [
            'title' => 'Users Mgt', 'url' => 'javascript:void(0)', 'permission' => request()->user()->hasAnyPermission('user-view', 'role-view', 'user-add'), 'icon' => 'ri-group-line', 'childrens' => collect([
                [
                    'title' => 'List', 'url' => route('users.index'), 'permission' => request()->user()->hasAnyPermission('user-view')

                ], [
                    'title' => 'Add', 'url' => route('users.create'), 'permission' => request()->user()->hasAnyPermission('user-add')
                ], [
                    'title' => 'Groups', 'url' => route('roles.index'), 'permission' => request()->user()->hasAnyPermission('role-view')
                ]
            ]),
        ], [
            'title' => 'Block Mgt', 'url' => 'javascript:void(0)', 'permission' => request()->user()->hasAnyPermission('block-view'), 'icon' => 'ri-building-line', 'childrens' => collect([
                [
                    'title' => 'Block List', 'url' => route('blocks.index'), 'permission' => request()->user()->hasAnyPermission('block-view')

                ], [
                    'title' => 'Sub Block List', 'url' => route('sides.index'), 'permission' => request()->user()->hasAnyPermission('side-view')
                ], [
                    'title' => 'Room List', 'url' => route('rooms.index'), 'permission' => request()->user()->hasAnyPermission('room-view')
                ]
            ]),
        ], [
            'title' => 'Students', 'url' => route('students.index'), 'permission' => request()->user()->hasAnyPermission('student-view'), 'icon' => 'ri-user-2-line', 'childrens' => collect(),
        ], [
            'title' => 'Applications', 'url' => 'javascript:void(0)', 'permission' => request()->user()->hasAnyPermission('application-view'), 'icon' => 'ri-survey-line', 'childrens' => collect([
                [
                    'title' => 'List', 'url' => route('applications-list'), 'permission' => request()->user()->hasAnyPermission('application-view')

                ], [
                    'title' => 'Shortlist', 'url' => route('shortlist'), 'permission' => request()->user()->hasAnyPermission('shortlist-view')

                ]
            ]),
        ], [
            'title' => 'Payment', 'url' => route('invoices.index', App\Models\AcademicYear::current()->slug), 'permission' => request()->user()->hasAnyPermission('invoice-view'), 'icon' => ' ri-bank-card-2-line', 'childrens' => collect(),
        ], [
            'title' => 'Deadline', 'url' => route('deadline.index'), 'permission' => request()->user()->hasAnyPermission('deadline-view'), 'icon' => 'ri-calendar-2-line', 'childrens' => collect(),
        ]
    ]);
@endphp

<div class="vertical-menu">

  <div data-simplebar class="h-100">

      <!--- Sidemenu -->
      <div id="sidebar-menu">
          <!-- Left Menu Start -->
          <ul class="metismenu list-unstyled" id="side-menu">
              <li class="menu-title">Menu</li>

              @foreach ($navigations as $navigation)
                @if ($navigation['permission'] || auth()->user()->hasRole('super-admin'))
                    <li>
                        <a href="{{ $navigation['url'] }}" class="{{ ($navigation['childrens']->count()) ? 'has-arrow':'' }} waves-effect">
                            <i class="{{ $navigation['icon'] }}"></i>
                            <span>{{ $navigation['title'] }}</span>
                        </a>
                        @if ($navigation['childrens'])
                            <ul class="sub-menu" aria-expanded="true">
                                @foreach ($navigation['childrens'] as $navChild1)
                                @if ($navChild1['permission'] || auth()->user()->hasRole('super-admin'))
                                    <li><a href="{{ $navChild1['url'] }}" class="{{ ($navChild1['childrens']??false) ? 'has-arrow':'' }}">{{ $navChild1['title'] }}</a>
                                        @if ($navChild1['children']??false)
                                            <ul class="sub-menu" aria-expanded="true">
                                                @foreach ($navChild1['children'] as $child)
                                                @if ($child['permission'] || auth()->user()->hasRole('super-admin'))
                                                    <li><a href="{{ $child['url'] }}">{{ $child['title'] }}</a></li>
                                                @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
              @endforeach

          </ul>
      </div>
      <!-- Sidebar -->
  </div>
</div>
