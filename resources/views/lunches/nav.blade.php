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
        <a class="nav-link dropdown-toggle {{ $active['special'] }}" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">特殊處理</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('lunch_specials.fill_tea') }}">教職補訂餐</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('lunch_specials.change_tea') }}">教職變更訂餐</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('lunch_specials.back_tea') }}">教職退訂餐</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('lunch_specials.change_stu_begin') }}">期初學生更改訂餐</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('lunch_specials.change_one_stu') }}">單一學生更改葷素</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">x單一學生退訂餐</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">x班級單日退餐退費</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">x學年單日退餐退費</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">x學年單日退餐不退費</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">x全校教職員生退餐退費</a>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ $active['report'] }}" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">報表輸出</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('lunch_reports.for_factory') }}" target="_blank">給廠商報表</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('lunch_reports.tea_everyday') }}">教職逐日訂餐報表</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('lunch_reports.tea_money') }}">教職收費單</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('lunch_reports.stu') }}">學生訂餐報表</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">x給出納報表</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">x給主計報表</a>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active['setup'] }}" href="{{ route('lunch_setups.index') }}">午餐設定</a>
    </li>
</ul>