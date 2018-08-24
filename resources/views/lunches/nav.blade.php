<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ $active['teacher'] }}" href="{{ route('lunches.index') }}">教職員訂餐</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ $active['student'] }}" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">學生訂餐管理</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('lunch_students.index') }}">學生訂餐</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('lunch_students.back') }}">學生退餐</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('lunch_checks.index') }}">各班問題反應</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('lunch_satisfactions.index') }}">滿意度調查</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">特殊處理</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">報表輸出</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('lunch_reports.for_factory') }}" target="_blank">給廠商報表</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">教師訂餐報表</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">學生訂餐報表</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">給出納報表</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">給主計報表</a>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active['setup'] }}" href="{{ route('lunch_setups.index') }}">午餐設定</a>
    </li>
</ul>