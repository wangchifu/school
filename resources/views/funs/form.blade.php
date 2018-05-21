<div class="card my-4">
    <h3 class="card-header">指定模組管理資料</h3>
    <div class="card-body">
        <div class="form-group">
            <label for="type">類別*</label>
            <?php $types=['1'=>'報修系統','2'=>'學生系統','3'=>'午餐系統','4'=>'運動會報名系統']; ?>
            {{ Form::select('type', $types,null, ['id' => 'type', 'class' => 'form-control']) }}
        </div>
        <div class="form-group">
            <label for="user_id">使用者*</label>
            {{ Form::select('user_id', $users,null, ['id' => 'user_id', 'class' => 'form-control']) }}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                <i class="fas fa-save"></i> 儲存設定
            </button>
        </div>
    </div>
</div>