@extends('layouts.master')

@section('page-title', '學生身份統計')

@section('content')
<br><br><br>
<div class="container">
    <h1><i class="fas fa-utensils"></i> 學生身份統計</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">午餐系統</li>
            <li class="breadcrumb-item">報表輸出</li>
            <li class="breadcrumb-item active" aria-current="page">學生身份統計</li>
        </ol>
    </nav>
    <?php
    foreach(config('app.lunch_page') as $v){
        $active[$v] = "";
    }
    $active['report'] ="active";
    ?>
    @include('lunches.nav')
    <br>
    <div class="card">
        <div class="card-header">
            <h2>各班學生身份統計</h2>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        班級
                    </th>
                    <?php
                    $selects = [
                        '101'=>"101一般生",
                        '201'=>"201弱勢生-低收入戶",
                        '202'=>"202弱勢生-中低收入戶",
                        '203'=>"203弱勢生-家庭突發因素",
                        '204'=>"204弱勢生-父母一方失業",
                        '205'=>"205弱勢生-單親家庭",
                        '206'=>"206弱勢生-隔代教養",
                        '207'=>"207弱勢生-特殊境遇",
                        '208'=>"208弱勢生-身心障礙學生",
                        '209'=>"209弱勢生-新住民子女",
                        '210'=>"210弱勢生-原住民子女",
                    ];
                    ?>
                    @foreach($selects as $k=>$v)
                    <th>
                        {{ $v }}
                    </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <?php
                    $s101 = 0 ;
                    $s201 = 0 ;
                    $s202 = 0 ;
                    $s203 = 0 ;
                    $s204 = 0 ;
                    $s205 = 0 ;
                    $s206 = 0 ;
                    $s207 = 0 ;
                    $s208 = 0 ;
                    $s209 = 0 ;
                    $s210 = 0 ;
                ?>
                    @foreach($stu_p_id_data as $k1=>$v1)
                    <tr>
                        <td>
                            {{ $k1 }}
                        </td>
                        @foreach($v1 as $k2=>$v2)
                            <td>
                                {{ $v2 }}
                            </td>
                            <?php
                            if($k2=='s101') $s101+=$v2;
                            if($k2=='s201') $s201+=$v2;
                            if($k2=='s202') $s202+=$v2;
                            if($k2=='s203') $s203+=$v2;
                            if($k2=='s204') $s204+=$v2;
                            if($k2=='s205') $s205+=$v2;
                            if($k2=='s206') $s206+=$v2;
                            if($k2=='s207') $s207+=$v2;
                            if($k2=='s208') $s208+=$v2;
                            if($k2=='s209') $s209+=$v2;
                            if($k2=='s210') $s210+=$v2;
                            ?>
                        @endforeach
                    </tr>
                    @endforeach
                <tr>
                    <td>
                        合計
                    </td>
                    <td>
                        {{ $s101 }}
                    </td>
                    <td>
                        {{ $s201 }}
                    </td>
                    <td>
                        {{ $s202 }}
                    </td>
                    <td>
                        {{ $s203 }}
                    </td>
                    <td>
                        {{ $s204 }}
                    </td>
                    <td>
                        {{ $s205 }}
                    </td>
                    <td>
                        {{ $s206 }}
                    </td>
                    <td>
                        {{ $s207 }}
                    </td>
                    <td>
                        {{ $s208 }}
                    </td>
                    <td>
                        {{ $s209 }}
                    </td>
                    <td>
                        {{ $s210 }}
                    </td>

                </tr>
                <tr>
                    <th>
                        班級
                    </th>
                    @foreach($selects as $k=>$v)
                        <th>
                            {{ $v }}
                        </th>
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
