 @php
    $current_user_id = current_user_position()->id;
         $approved_tickets_count= \App\Models\Ticket::where('status','approved')->where('task_id',0)->where('to_id',$current_user_id)->orderBy('id', 'desc')->count();
         $needapproval_tickets_count= \App\Models\Ticket::where('status','pending')->where('to_id',$current_user_id)->orderBy('id', 'desc')->count();
       //if the current uesr has parent 
        $has_parent = \App\Models\EmployeePositionRelation::where('child_id', $current_user_id)->count() > 0;
    @endphp

@if(!isset(current_user_position()->id))

@dd('يجب تعيين لك دور من قبل مدير النظام')
@endif

@if($has_parent==0 && $current_user_id !=4)
    @dd('يجب تحديد مدير مباشر للموظف من قبل مدير النظام')
@endif
<!DOCTYPE html>
<html lang="en">

<head>
    
<style>
    .badgered{background:red;color:white;}
    .collapse-item:hover{background-color:black !important; }
</style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css" />
    <title>برنامج الإستراتيجية</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
<style>

.btn-primary:hover,
.btn-secondary:hover,
.btn-success:hover,
.btn-danger:hover,
.btn-warning:hover,
.btn-info:hover,
.btn-light:hover,
.btn-dark:hover {
    /* Add your animation here */
    animation: color-change 1s;
    color: white !important;
}

@keyframes color-change {
    0% { background: #2797b6 !important; }
    50% { background: #1c6a8a !important; }
    100% { background: #2797b6 !important; }
}
body {
    font-family: 'Cairo' !important; text-align: right !important;
}
    .nav-link{text-align: right !important;}
    .navbar-nav{padding:0px !important;}
    .nav-logo{
        background: white;
    padding: 2em !important;
    padding-bottom: 0px !important;
    }
    .color-primary{color:#2797b6 !important; font-weight: bold;}
    .sidebar-dark .sidebar-heading{text-align: right !important;}   
    .btn-primary{background-color: #2797b6 !important; border-color: #2797b6 !important;}
    .sidebar .nav-item .nav-link[data-toggle=collapse]::after{float: left !important;}    .sidebar .nav-item .nav-link[data-toggle=collapse].collapsed::after{
        content: '\f104';
    }
      /* Custom sidebar toggle styles - Override SB Admin styles */
    body.sidebar-toggled .sidebar {
        width: 0 !important;
        overflow: hidden !important;
        min-height: 0 !important;
    }
    
    body.sidebar-toggled #content-wrapper {
        margin-left: 0 !important;
    }
    
    body.sidebar-toggled #accordionSidebar {
        width: 0 !important;
        overflow: hidden !important;
        min-height: 0 !important;
    }
    
    /* For mobile devices */
    @media (max-width: 768px) {
        body.sidebar-toggled .sidebar {
            transform: translateX(-250px) !important;
        }
        
        body.sidebar-toggled #accordionSidebar {
            transform: translateX(-250px) !important;
        }
    }
    
    #content-wrapper {
        transition: margin-left 0.3s ease !important;
    }
    
    .sidebar, #accordionSidebar {
        transition: width 0.3s ease, transform 0.3s ease !important;
    }
</style>


<style>
    .logoo{width:100%;height: 100%;}
    :root {
    --tmr-bootstrap-border-color: #dee2e6;
    --tmr-white: #eee;
    --tmr-table-header: #54667a;
    --tmr-row-divider-color: #3490dc;
    --tmr-stripped-row-background-color: rgba(0, 0, 0, 0.05);
}

/*-- ==============================================================
 Screen smaller than 760px and iPads.
 ============================================================== */

@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px) {
    
    [data-content]:before {
        content: attr(data-content);
    }
    
    /* Force table to not be like tables anymore */
    .table-mobile-responsive,
    .table-mobile-responsive thead,
    .table-mobile-responsive tbody,
    .table-mobile-responsive th,
    .table-mobile-responsive td,
    .table-mobile-responsive tr {
        display: block;
    }

    .table-mobile-responsive.text-center {
        text-align: left !important;
    }
    .table-mobile-responsive caption {
        width: max-content;
    }

    /* Hide table headers (but not display: none;, for accessibility) */
    .table-mobile-responsive thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }

    .table-mobile-responsive> :not(:first-child) {
        border-top: none;
    }

    .table-mobile-responsive>:not(caption)>*>* {
        border-color: var(--tmr-bootstrap-border-color);
    }

    .table-mobile-responsive tr:not(.bg-light-blue) {
        border-bottom: 2px solid var(--tmr-row-divider-color);
    }

    /* Default layout */
    .table-mobile-responsive td {
        /* Behave  like a "row" */
        border: none;
        border-bottom: 1px solid var(--tmr-white);
        position: relative;
        padding-left: 50%;
        padding-top: 2rem !important;
    }

    .table-mobile-responsive td:before {
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 0;
        right: 6px;
        padding-bottom:1em;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        font-weight: bold;
        color: var(--tmr-table-header);
    }
    
    /* Sided layout */
    .table-mobile-responsive.table-mobile-sided> :not(:first-child) {
        border-top: none;
    }

    .table-mobile-responsive.table-mobile-sided>:not(caption)>*>* {
        border-color: var(--bs-table-border-color);
    }
    .table-mobile-responsive.table-mobile-sided td {
          /* Behave  like a "row" */
        border: none;
        border-bottom: 1px solid var(--tmr-white);
        position: relative;
        padding-left: 50%;
        padding-top: 0px !important;
        display: flex;
        justify-content: flex-start;
    }
    .table-mobile-responsive.table-mobile-sided td:before {
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 0;
        right: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        font-weight: bold;
        color: var(--tmr-table-header);
    }

    /* Styleless */
    .table-mobile-responsive.table-mobile-styleless tr:not(.bg-light-blue) {
        border-bottom: none !important;
    }

    /* Stripped rows */
    .table-mobile-responsive.table-mobile-striped>tbody>tr:nth-of-type(odd)>* {
        background-color: var(--tmr-stripped-row-background-color) !important;
    }
    #cssTable td{
        width:100%;
        height: auto;
    }
    #cssTable thead{display: none;}
}

@media (max-width: 767px) {
        .navbar-nav {
            padding: 0em !important;
            font-size: 0.9rem;
    padding-top: 1em !important;
        }

        .logoo{width:100%;height: 30px;}

    }

.navadmin li:hover{
    
 background: #504B9F;
background: linear-gradient(90deg,rgba(80, 75, 159, 1) 0%, rgba(16, 187, 183, 1) 100%);
}
.navadmin li:hover a, .navadmin li:hover i, .navadmin li:hover span {
color:white !important;    
}

</style>
</head>

<body id="page-top" dir="rtl">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-white sidebar sidebar-dark accordion navadmin" id="accordionSidebar">
            <div  class="navbar-nav  nav-logo">
                <a href="{{ env('APP_URL_REAL') }}"><img src="{{ asset('storage/logo.png') }}"  alt="" class="logoo">
                <!-- Authentication Links -->
                
                @guest
                    @if (Route::has('login'))
                        <div class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('تسجيل الدخول') }}</a>
                        </div>
                    @endif

                    @if (Route::has('register'))
                        <div class="nav-item ">
                            <a class="nav-link color-primary" href="{{ route('register') }}">{{ __('التسجيل') }}</a>
                        </div>
                    @endif
                @else
                    <div class="nav-item " style="text-align:center;">
                        

<div class="badge badge-dark" style="    text-align: center;
    font-weight: bold;
    
    ">
         {{ Auth::user()->name }} - 
    {{ current_user_position()->name }}
</div>
                        <div style="margin-top:-20px;">
                            <a class="nav-link color-danger" href="{{ route('logout') }}" style="    padding: 0px;
    margin-top: 2em;
    margin-right: 1em;"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('تسجيل الخروج') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center d-none" style="display:none !important;" href="{{  url('/')}}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-chart-bar"></i>                </div>
                <div class="sidebar-brand-text mx-3">الإستراتيجية</div>
                <div>
                    
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->is('/') ? 'bg-grain' : '' }}">
                <a class="nav-link" href="{{ env('APP_URL_REAL') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>لوحة التحكم</span></a>
            </li>
                        @if (is_admin())

            <li class="nav-item {{ request()->routeIs('employeepositions.index') ? 'bg-grain' : '' }}">
                <a class="nav-link" href="{{ route('employeepositions.index') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>المناصب الوظيفية</span></a>
            </li>
            
            <li class="nav-item ">
                <li class="nav-item {{ request()->routeIs('stats.dashboard') ? 'bg-grain' : '' }}">
                    <a class="nav-link" href="{{ route('stats.dashboard') }}">
                        <i class="fas fa-fw fa-chart-pie"></i>
                        <span>لوحة الإحصائيات</span></a>
                </li>
            </li>
            
            <li class="nav-item ">
                <li style="display: none;" class="nav-item {{ request()->routeIs('stats.hierarchy') ? 'bg-grain' : '' }}">
                    <a class="nav-link" href="{{ route('stats.hierarchy') }}">
                        <i class="fas fa-fw fa-sitemap"></i>
                        <span>الهيكل التنظيمي</span></a>
                </li>
            @endif
            <li class="nav-item ">
                <li class="nav-item {{ request()->is('subtask-analyst*') && request()->get('type') == 'month' ? 'bg-grain' : '' }}">
                    <a class="nav-link" href="{{ url('/subtask-analyst?type=month&id='.date("m").'&department_id='.current_user_position()->id) }}&solo=true">
                        <i class="fas fa-fw fa-chart-bar"></i>
                        <span>احصائياتي الشهرية</span></a>
                </li>
            <li class="nav-item ">
                <li class="nav-item {{ request()->is('subtask-analyst*') && request()->get('type') == 'year' ? 'bg-grain' : '' }}">
                    <a class="nav-link" href="{{ url('/subtask-analyst?type=year&id='.date("Y").'&department_id='.current_user_position()->id) }}&solo=true">
                        <i class="fas fa-fw fa-chart-bar"></i>
                        <span>احصائياتي السنوية</span>
                    </a>
                </li>
            @if (is_strategy())
                
            
            <li class="nav-item {{ request()->routeIs('subtask.strategyEmployeeApproval') ? 'bg-grain' : '' }}">
                <a class="nav-link" href="{{ route('subtask.strategyEmployeeApproval') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>الموافقة كموظف استراتيجية</span></a>
            </li>
            @endif
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                التحكم
            </div>
            
            <li class="nav-item ">
                <li class="nav-item {{ request()->is('employeepositions/team/*') ? 'bg-grain' : '' }}">
                    <a class="nav-link" href="{{ url('/employeepositions/team/'.current_user_position()->id )  }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>فريقي</span></a>
                </li>
            </li>
            
            <li class="nav-item ">
                <li class="nav-item {{ request()->is('employeepositionstop') ? 'bg-grain' : '' }}">
                    <a class="nav-link" href="{{ url('/employeepositionstop') }}">
                        <i class="fas fa-fw fa-trophy"></i>
                        <span>أعلى الموظفين أداء</span></a>
                </li>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <li class="nav-item {{
                    request()->is('hadafstrategies') ||
                    request()->is('moasheradastrategy') ||
                    request()->is('mubadara') ||
                    request()->is('moashermkmf') ||
                    request()->is('task') ||
                    request()->is('subtask')
                    ? 'bg-grain' : ''
                }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>الأهداف والمؤشرات</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-grain py-2 collapse-inner rounded">
                            <h6 class="collapse-header"></h6>
                            <a class="collapse-item" href="{{url('/hadafstrategies')}}" >الأهداف الإستراتيجية</a>
                            
                            @if (is_admin())
                            <a class="collapse-item" href="{{url('/moasheradastrategy')}}" >المؤشرات الإستراتيجية</a>
                            <a class="collapse-item" href="{{url('/mubadara')}}" >المبادرات</a>
                            <a class="collapse-item" href="{{url('/moashermkmf')}}" >مؤشرات الكفاءة والفعالية</a>
                            <a class="collapse-item" href="{{url('/task')}}" >الإجراءات الرئيسية</a>
                            <a class="collapse-item" href="{{url('/subtask')}}" >المهام الفرعية</a>
                            @endif
                        </div>
                    </div>
                </li>
            </li>
         

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>المهام</span>
                    @php
               $user_id= \App\Models\EmployeePosition::where('user_id', auth()->user()->id)->first()->id;
                $subtasksApprovalCount = \App\Models\Subtask::where('parent_user_id', $user_id)
                    ->where('percentage', '!=', 100)
                    ->whereIn('status', ['pending-approval'])
                    ->count(); 
                    $subtasksNewCount =  \App\Models\Subtask::where('user_id',$user_id)->where('percentage', '!=', 100)->where('status','!=','pending-approval')->where('status','!=','approved')->count();

        // dd($subtasksApprovalCount);
                    @endphp
                    <span class="badge bg-red badgered" id="tasks-total-badge">{{ $subtasksApprovalCount+ $subtasksNewCount }}</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-grain py-2 collapse-inner rounded">
                        <h6 class="collapse-header"></h6>
                        <a class="collapse-item"  href="{{url('/settomyteam')}}" >إسناد لفريقي</a>
                        <a class="collapse-item"  href="{{route('subtask.assignmentStats')}}" >إحصائيات الإسناد</a>
                        <a class="collapse-item"  href="{{url('/subtaskapproval')}}" >الموافقة على المهام <span class="badge bg-red badgered" id="approval-tasks-badge">{{ $subtasksApprovalCount }}</span></a>
                        <a class="collapse-item"  href="{{url('/mysubtasks')}}" >مهامي <span class="badge bg-red badgered" id="my-tasks-badge">{{ $subtasksNewCount }}</span></a>
                  
                    </div>
                </div>
            </li>


            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTickets"
                    aria-expanded="true" aria-controls="collapseTickets">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>التذاكر <span class="badge bg-red badgered" id="tickets-total-badge">{{ $approved_tickets_count+$needapproval_tickets_count}}</span></span>
                </a>
                <div id="collapseTickets" class="collapse" aria-labelledby="headingTickets"
                    data-parent="#accordionSidebar">
                    <div class="bg-grain py-2 collapse-inner rounded">                        <h6 class="collapse-header">التذاكر:</h6>
                        <a class="collapse-item"  href="{{url('/tickets')}}" >التذاكر</a>
                        <a class="collapse-item"  href="{{url('/tickets/create')}}" >أضف تذكرة جديدة</a>
                        @if (in_array(current_user_position()->id, explode(',', env('STRATEGY_CONTROL_ID', ''))))
                        <a class="collapse-item"  href="{{ route('tickets.admin.index') }}" >
                            <i class="fas fa-cog fa-sm"></i> إدارة جميع التذاكر
                        </a>
                        @endif
                  
                    </div>
                </div>
            </li>

            <li class="nav-item ">
                <li class="nav-item {{ request()->is('mysubtaskscalendar') ? 'bg-grain' : '' }}">
                    <a class="nav-link" href="{{ url('/mysubtaskscalendar')  }}">
                        <i class="fas fa-fw fa-calendar"></i>
                        <span>التقويم</span></a>
                </li>
            </li>

            <li class="nav-item ">
                <li class="nav-item {{ request()->routeIs('password.change') ? 'bg-grain' : '' }}">
                    <a class="nav-link" href="{{ route('password.change') }}">
                        <i class="fas fa-fw fa-key"></i>
                        <span>تغيير كلمة المرور</span></a>
                </li>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading  d-none">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item d-none">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages d-none" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">تسجيل الدخول</a>
                        <a class="collapse-item" href="register.html">سجل</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item d-none">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item d-none">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0 d-none" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
           
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="overflow:auto;">
              <!-- Topbar -->
              <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">                <!-- Sidebar Toggle (Topbar) -->
                <button id="wwee" class="btn btn-link rounded-circle mr-3" style="display: block !important;">
                    <i class="fa fa-bars"></i>
                </button>


                <!-- Topbar Search -->
                {{-- <form
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                            aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                        placeholder="Search for..." aria-label="Search"
                                        aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">3+</span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>

                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <!-- Counter - Messages -->
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">
                                Message Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                        alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                        problem I've been having.</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                        alt="...">
                                    <div class="status-indicator"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">I have the photos that you ordered last month, how
                                        would you like them sent to you?</div>
                                    <div class="small text-gray-500">Jae Chun · 1d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                        alt="...">
                                    <div class="status-indicator bg-warning"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Last month's report looks great, I am very happy with
                                        the progress so far, keep up the good work!</div>
                                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                        alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                        told me that people say this to all dogs, even if they aren't good...</div>
                                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                            <img class="img-profile rounded-circle"
                                src="img/undraw_profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul> --}}

            </nav>
            @yield('content')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
      <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <!-- <script src="{{ asset('js/sb-admin-2.min.js') }}"></script> -->

    <!-- Page level plugins -->
    <!--<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>-->

    <!-- Page level custom scripts -->
    <!--<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>-->
    <!--<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>--> <!-- Custom scripts for all pages-->
<script>
$(document).ready(function() {
    console.log('Sidebar toggle script loaded');
    
    $('#wwee').on('click', function(e) {
        e.preventDefault();
        console.log('Toggle button clicked');
        
        var body = $('body');
        var sidebar = $('#accordionSidebar');
        var contentWrapper = $('#content-wrapper');
        
        // Toggle classes
        body.toggleClass('sidebar-toggled');
        sidebar.toggleClass('toggled');
        
        // Force styles based on state
        if (body.hasClass('sidebar-toggled')) {
            console.log('Hiding sidebar');
            sidebar.css({
                'width': '0px',
                'overflow': 'hidden',
                'min-height': '0px'
            });
            contentWrapper.css('margin-left', '0px');
        } else {
            console.log('Showing sidebar');
            sidebar.css({
                'width': '224px',
                'overflow': 'visible',
                'min-height': '100vh'
            });
            contentWrapper.css('margin-left', '224px');
        }
        
        // Hide any open collapses when sidebar is toggled
        if (sidebar.hasClass('toggled')) {
            sidebar.find('.collapse').collapse('hide');
        }
        
        console.log('Body classes:', body.attr('class'));
        console.log('Sidebar classes:', sidebar.attr('class'));
        console.log('Sidebar width:', sidebar.width());
    });
    
    // Window resize handler
    $(window).resize(function() {
        if ($(window).width() < 768) {
            $('#accordionSidebar .collapse').collapse('hide');
        }
        
        if ($(window).width() < 480 && !$('#accordionSidebar').hasClass('toggled')) {
            $('body').addClass('sidebar-toggled');
            $('#accordionSidebar').addClass('toggled');
            $('#accordionSidebar .collapse').collapse('hide');
        }
    });
    
    // Scroll to top functionality
    $(document).on('scroll', function() {
        if ($(this).scrollTop() > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });
    
    $(document).on('click', 'a.scroll-to-top', function(e) {
        var target = $(this);
        $('html, body').stop().animate({
            scrollTop: $(target.attr('href')).offset().top
        }, 1000, 'easeInOutExpo');
        e.preventDefault();
    });
});
</script>
 <!-- Page level plugins -->

 <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

 <!-- Page level custom scripts -->


 <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>



 <script>
    $(document).ready(function() {
    $('#dataTable').DataTable( {
        responsive: true,
        language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json',

    },

    } );
} );    </script>
          <script>
        $(document).ready(function() {
            if (window.innerWidth <= 768) {
                $('body').addClass('sidebar-toggled');
                $('#accordionSidebar').addClass('toggled');
            }
        });
        </script>

        <!-- Auto-update sidebar notification badges -->
        <script>
        $(document).ready(function() {
            // Store previous values for comparison
            let previousValues = {
                total_subtasks_count: parseInt($('#tasks-total-badge').text()) || 0,
                subtasks_approval_count: parseInt($('#approval-tasks-badge').text()) || 0,
                subtasks_new_count: parseInt($('#my-tasks-badge').text()) || 0,
                tickets_count: parseInt($('#tickets-total-badge').text()) || 0
            };
            
            console.log('Initial badge values:', previousValues);
            
            // Function to play notification sound
            function playNotificationSound() {
                try {
                    // Create and play notification sound using Web Audio API
                    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();
                    
                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);
                    
                    // Create a pleasant notification sound (two-tone)
                    oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                    oscillator.frequency.setValueAtTime(1000, audioContext.currentTime + 0.1);
                    oscillator.frequency.setValueAtTime(800, audioContext.currentTime + 0.2);
                    
                    gainNode.gain.setValueAtTime(0, audioContext.currentTime);
                    gainNode.gain.linearRampToValueAtTime(0.3, audioContext.currentTime + 0.05);
                    gainNode.gain.linearRampToValueAtTime(0, audioContext.currentTime + 0.3);
                    
                    oscillator.start(audioContext.currentTime);
                    oscillator.stop(audioContext.currentTime + 0.3);
                } catch (error) {
                    console.log('Audio not supported or blocked:', error);
                }
            }
            
            // Function to animate badge when number increases
            function animateBadgeIncrease(badgeElement) {
                // Change background to black temporarily
                badgeElement.css({
                    'background-color': 'black',
                    'transform': 'scale(1.2)',
                    'transition': 'all 0.3s ease'
                });
                
                // Restore original background after 2 seconds
                setTimeout(function() {
                    badgeElement.css({
                        'background-color': 'red',
                        'transform': 'scale(1)',
                        'transition': 'all 0.3s ease'
                    });
                }, 2000);
            }
            
            // Function to update badge visibility
            function updateBadgeVisibility(badgeElement, count) {
                if (count == 0) {
                    badgeElement.hide();
                } else {
                    badgeElement.show();
                }
            }
            
            // Function to update badge numbers
            function updateSidebarNotifications() {
                $.ajax({
                    url: '{{ route("stats.sidebar") }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('API Response:', data);
                        let soundPlayed = false;
                        
                        // Check and update tasks total badge
                        if (data.total_subtasks_count > previousValues.total_subtasks_count) {
                            console.log('Tasks total increased from', previousValues.total_subtasks_count, 'to', data.total_subtasks_count);
                            if (!soundPlayed) {
                                playNotificationSound();
                                soundPlayed = true;
                            }
                            animateBadgeIncrease($('#tasks-total-badge'));
                        }
                        $('#tasks-total-badge').text(data.total_subtasks_count);
                        updateBadgeVisibility($('#tasks-total-badge'), data.total_subtasks_count);
                        previousValues.total_subtasks_count = data.total_subtasks_count;
                        
                        // Check and update approval tasks badge
                        if (data.subtasks_approval_count > previousValues.subtasks_approval_count) {
                            console.log('Approval tasks increased from', previousValues.subtasks_approval_count, 'to', data.subtasks_approval_count);
                            if (!soundPlayed) {
                                playNotificationSound();
                                soundPlayed = true;
                            }
                            animateBadgeIncrease($('#approval-tasks-badge'));
                        }
                        $('#approval-tasks-badge').text(data.subtasks_approval_count);
                        updateBadgeVisibility($('#approval-tasks-badge'), data.subtasks_approval_count);
                        previousValues.subtasks_approval_count = data.subtasks_approval_count;
                        
                        // Check and update my tasks badge
                        if (data.subtasks_new_count > previousValues.subtasks_new_count) {
                            console.log('My tasks increased from', previousValues.subtasks_new_count, 'to', data.subtasks_new_count);
                            if (!soundPlayed) {
                                playNotificationSound();
                                soundPlayed = true;
                            }
                            animateBadgeIncrease($('#my-tasks-badge'));
                        }
                        $('#my-tasks-badge').text(data.subtasks_new_count);
                        updateBadgeVisibility($('#my-tasks-badge'), data.subtasks_new_count);
                        previousValues.subtasks_new_count = data.subtasks_new_count;
                        
                        // Check and update tickets badge
                        if (data.tickets_count > previousValues.tickets_count) {
                            console.log('Tickets increased from', previousValues.tickets_count, 'to', data.tickets_count);
                            if (!soundPlayed) {
                                playNotificationSound();
                                soundPlayed = true;
                            }
                            animateBadgeIncrease($('#tickets-total-badge'));
                        }
                        $('#tickets-total-badge').text(data.tickets_count);
                        updateBadgeVisibility($('#tickets-total-badge'), data.tickets_count);
                        previousValues.tickets_count = data.tickets_count;
                        
                        console.log('Updated badge values:', {
                            tasks_total: data.total_subtasks_count,
                            approval_tasks: data.subtasks_approval_count, 
                            my_tasks: data.subtasks_new_count,
                            tickets: data.tickets_count
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to update sidebar notifications:', error);
                        console.error('Response:', xhr.responseText);
                    }
                });
            }
            
            // Don't update immediately on page load to avoid hiding badges
            // Wait 3 seconds before first update
            setTimeout(function() {
                updateSidebarNotifications();
                // Then update every 3 seconds
                setInterval(updateSidebarNotifications, 3000);
            }, 3000);
        });
        </script>

        <!-- Bootstrap JS (مطلوب لـ dropdowns) -->

<!-- Bootstrap Select JS (بعد jQuery و Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.min.js" defer></script>

    @stack('scripts')
</body>

</html>
