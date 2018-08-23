<?php
$data ="";
$data .="
<center><h1>和東國小 {$semester} 學期 學生午餐 供餐檢核表</h1></center>
<center>
<table style='border: 1px solid #000000;border-collapse: collapse;'>
    <tr style='border: 1px solid #000000;font-size: 20px;'>
        <td style='border: 1px solid #000000;width:150px'>
            班級
        </td>
        <td style='border: 1px solid #000000;width:150px'>
            日期
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            主食
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            主菜
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            副菜
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            蔬菜
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            湯品</td>
        <td style='border: 1px solid #000000;width:180px'>
            不合格原因
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            處置
        </td>
    </tr>";
foreach($admin_checks as $admin_check){
    $main_eat = ($admin_check->main_eat)?"X":"";
    $main_vag = ($admin_check->main_vag)?"X":"";
    $co_vag = ($admin_check->co_vag)?"X":"";
    $vag = ($admin_check->vag)?"X":"";
    $soup = ($admin_check->soup)?"X":"";
    $data .= "
    <tr style='border: 1px solid #000000;font-size: 20px;'>
        <td style='border: 1px solid #000000;width:50px'>
            {$admin_check->class_id}
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            {$admin_check->order_date}
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            {$main_eat}
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            {$main_vag}
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            {$co_vag}
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            {$vag}
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            {$soup}
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            {$admin_check->reason}
        </td>
        <td style='border: 1px solid #000000;width:50px'>
            {$admin_check->action}
        </td>
    </tr>
    ";
}

$data .= "
</table>
</center>
處置：1.已處理(移除),2.已更換,3.僅目前通報
";

echo "<body onload='window.print()'>";
echo $data;

?>