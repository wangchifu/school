<div class="card my-4">
    <h3 class="card-header">午餐設定資料</h3>
    <div class="card-body">
        <div class="form-group">
            <label for="semester"><strong>學期*</strong><small class="text-danger">(如 1062)</small></label>
            {{ Form::text('semester',null,['id'=>'semester','class' => 'form-control', 'maxlength'=>'4','placeholder'=>'4碼數字']) }}
        </div>
        <div class="form-group">
            <label for="tea_money"><strong>教職員工收費*</strong></label>
            {{ Form::text('tea_money',null,['id'=>'tea_money','class' => 'form-control', 'maxlength'=>'5']) }}
        </div>
        <div class="form-group">
            <label for="stud_money"><strong>學生收費*</strong></label>
            {{ Form::text('stud_money',null,['id'=>'stud_money','class' => 'form-control', 'maxlength'=>'5']) }}
        </div>
        <div class="form-group">
            <label for="stud_back_money"><strong class="text-danger">學生退費*</strong></label>
            {{ Form::text('stud_back_money',null,['id'=>'stud_back_money','class' => 'form-control', 'maxlength'=>'5']) }}
        </div>
        <div class="form-group">
            <label for="support_part_money"><strong>部分補助*</strong></label>
            {{ Form::text('support_part_money',null,['id'=>'support_part_money','class' => 'form-control', 'maxlength'=>'5']) }}
        </div>
        <div class="form-group">
            <label for="support_all_money"><strong>全額補助*</strong></label>
            {{ Form::text('support_all_money',null,['id'=>'support_all_money','class' => 'form-control', 'maxlength'=>'5']) }}
        </div>
        <div class="form-group">
            <label for="die_line"><strong>允許師生最慢幾天前退餐*</strong></label>
            {{ Form::text('die_line',null,['id'=>'die_line','class' => 'form-control', 'maxlength'=>'1']) }}
        </div>
        <div class="form-group" id="show_factory">
            <label for="factory1"><strong>廠商1*</strong></label>
            <input type='text' class='form-control' name='factory[]' id='factory1'>
            <i class='fas fa-plus-circle text-success' onclick="add_fac()"></i>
        </div>
        <div class="form-group" id="show_place">
            <label for="place"><strong>教師供餐地點*</strong></label>
            <input type='text' class='form-control' name='place[]' id='place1'>
            <i class='fas fa-plus-circle text-success' onclick="add_place()"></i>
        </div>
        <div class="form-group">
            <label for="stud_gra_date">學生畢業日<small class="text-danger">(如 2018-06-20，該日不供餐)</small></label>
            {{ Form::text('stud_gra_date',null,['id'=>'stud_gra_date','class' => 'form-control','maxlength'=>'10','placeholdr'=>'10碼']) }}
        </div>
        <div class="form-group">
            <label for="tea_open">教師隨時可訂餐<small class="text-danger">(僅供暫時開放，切記關閉它)</small></label>
            <div class="form-check">
                {{ Form::checkbox('tea_open', null,null,['id'=>'tea_open','class'=>'form-check-input']) }}
                <label class="form-check-label" for="tea_open"><span class="btn btn-danger btn-sm">打勾為隨時可訂</span></label>
            </div>
        </div>
        <div class="form-group">
            <label for="disable">師生停止退餐<small class="text-danger">(僅供學期末計費時使用)</small></label>
            <div class="form-check">
                {{ Form::checkbox('disable', null,null,['id'=>'disable','class'=>'form-check-input']) }}
                <label class="form-check-label" for="disable"><span class="btn btn-danger btn-sm">打勾為全面停止退餐</span></label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                <i class="fas fa-save"></i> 儲存設定
            </button>
        </div>
    </div>
</div>
<script>
    var fac = 1;
    var place = 1;

    function add_fac() {
        var content;
        fac++;
        content ="<p><label for='factory"+fac+"'>廠商"+fac+"：</label>" +
            "<input type='text' class='form-control' name='factory[]' id='factory"+fac+"'> " +
            "<i class='fas fa-trash text-danger' onclick='remove_fac(this)'></i></p>";
        $("#show_factory").append(content);
    }

    function remove_fac(obj) {
        $(obj).parent().remove();
        fac--;
    }

    function add_place() {
        var content;
        place++;
        content ="<p><label for='factory"+place+"'>教師供餐地點"+place+"：</label>" +
            "<input type='text' class='form-control' name='place[]' id='place"+place+"'> " +
            "<i class='fas fa-trash text-danger' onclick='remove_place(this)'></i></p>";
        $("#show_place").append(content);
    }

    function remove_place(obj) {
        $(obj).parent().remove();
        place--;
    }

</script>