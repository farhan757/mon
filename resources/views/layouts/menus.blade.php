<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                </svg> Dashboard</a></li>
        </li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-file') }}"></use>
                </svg> Ops</a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('ops.incdata.list') }}"><span
                            class="nav-icon"></span> Data Proses</a></li>
                @if(Auth::user()->id_group == 1)
                <li class="nav-item"><a class="nav-link" href="{{ route('ops.listdistribusi') }}"><span
                            class="nav-icon"></span> Distribusi</a></li>
                @endif

            </ul>
        </li>
        @if(Auth::user()->id_group == 1)
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-cloudy') }}"></use>
                </svg> Master</a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('master.component.list') }}"><span
                            class="nav-icon"></span> Component</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('master.status.list') }}"><span
                            class="nav-icon"></span> Status</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('master.listuser.list') }}"><span
                            class="nav-icon"></span> Users</a></li>
            </ul>
        </li>
        @endif
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list') }}"></use>
                </svg> Report</a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('report.listStok') }}"><span
                            class="nav-icon"></span> Stok Component</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('report.listusecomp') }}"><span
                            class="nav-icon"></span> Used Component</a></li>
                                                        
            </ul>
        </li>
    </ul>
    {{-- <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button> --}}
</div>
