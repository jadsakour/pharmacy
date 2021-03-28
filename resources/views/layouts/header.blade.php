<!--header start-->
<header class="header black-bg">
    <div class="sidebar-toggle-box">
    <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation" ></div>
    </div>
    <!--logo start-->
    <a href="index.html" class="logo">
        <!-- <img src="" style="width:70px;height:70px;" />-->
    </a>
    <!--logo end-->

    <div class="top-menu">
        <ul class="nav pull-right top-menu ml-auto">
            <!-- Authentication Links -->
            @guest
            <li class="nav-item">
                <a class="nav-link logout" href="{{ route('login') }}">{{ __('تسجيل الدخول') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link logout " href="{{ route('register') }}">{{ __('حساب جديد') }}</a>
                </li>
            @endif
            @else
                <li><a class="nav-link logout" href="{{ route('users.index') }}">إدارة المستخدمين</a></li>
                <li><a class="nav-link logout" href="{{ route('roles.index') }}">إدارة الصلاحيات</a></li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle logout" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('تسجيل الخروج') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
          @endguest
      </ul>
    </div>
</header>
<!--header end-->
<!-- **********************************************************************************************************************************************************
    MAIN SIDEBAR MENU
    *********************************************************************************************************************************************************** -->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <p class="centered">
                <a href="profile.html">
                    <div class="img-container">
                        <img src="/img/logo.png" class="img-circle" width="80">
                    </div>
                </a>
            </p>
            <h5 class="centered">NODES PHARMA</h5>
            <li class="mt">
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-plus-square"></i>
                        <span>الصيدلية</span>
                    </a>
                    <ul class="sub">
                        <li><a href="#">معلومات الصيدلية</a></li>
                        <li><a href="{{ route('users.index') }}">الموظفين</a></li>
                        <li><a href="{{ route('accountingOperation.index') }}">مدفوعات الصيدلية</a></li>
                        <li><a href="{{ route('accountingType.index') }}">أنواع المدفوعات</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-flask"></i>
                        <span>الأدوية</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('drug.index') }}">عرض الادوية</a></li>
                        <li><a href="{{ route('category.index') }}">الأصناف الدوائية</a></li>
                        <li><a href="{{ route('shape.index') }}">الأشكال الدوائية</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-building-o"></i>
                        <span>الشركات</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('company.index') }}">الشركات الدوائية</a></li>
                        <li><a href="{{ route('insurnce-company.index') }}">شركات التأمين</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-archive"></i>
                        <span>المستودعات</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('warehouse.index') }}">المستودعات الموجودة</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-calculator"></i>
                        <span>الفواتير</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('invoice.index') }}">عرض الفواتير</a></li>
                        <li><a href="{{ route('invoice.create') }}">فاتورة بيع بدون تأمين</a></li>
                        <li><a href="{{ route('invoice.create_with_insurance') }}">فاتورة بيع مع تأمين</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-shopping-cart"></i>
                        <span>الطلبيات</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('order.index') }}">عرض الطلبيات</a></li>
                        <li><a href="{{ route('order.create') }}">إضافة طلبية</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-briefcase"></i>
                        <span>التقارير</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('report.index') }}">اختر تقرير</a></li>
                    </ul>
                    <li>
                        <a href="{{URL('/techsupport')}}">
                            <i class="fa fa-gears"></i>
                            <span>الدعم التقني</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-group"></i>
                            <span>من نحن</span>
                        </a>
                    </li>
                </li>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
