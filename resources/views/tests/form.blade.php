<div class="card my-4">
    <h3 class="card-header">連結資料</h3>
    <div class="card-body">
        <div class="form-group">
            <label for="type">類別*</label>
            <?php $types=['1'=>'校內','2'=>'校外']; ?>
            {{ Form::select('type', $types,null, ['id' => 'type', 'class' => 'form-control']) }}
        </div>
        <div class="form-group">
            <label for="name">名稱*</label>
            {{ Form::text('name',null,['id'=>'name','class' => 'form-control', 'placeholder' => '名稱']) }}
        </div>
        <div class="form-group">
            <label for="url">網址*</label>
            {{ Form::text('url',null,['id'=>'url','class' => 'form-control', 'placeholder' => 'http://']) }}
        </div>
        <div class="form-group">
            <label for="order_by">排序</label>
            {{ Form::text('order_by',null,['id'=>'order_by','class' => 'form-control', 'placeholder' => '數目']) }}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                <i class="fas fa-save"></i> 儲存設定
            </button>
        </div>
    </div>
</div>