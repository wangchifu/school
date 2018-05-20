<div class="card my-4">
    <h3 class="card-header">使用者資料</h3>
    <div class="card-body">
        <div class="form-group">
            <label for="username"><strong>帳號*</strong></label>
            {{ Form::text('username',null,['id'=>'username','class' => 'form-control', 'placeholder' => '帳號']) }}
        </div>
        <div class="form-group">
            <label for="name"><strong>姓名*</strong></label>
            {{ Form::text('name',null,['id'=>'name','class' => 'form-control', 'placeholder' => '姓名']) }}
        </div>
        <div class="form-group">
            <label for="group_id">群組</label>
            {{ Form::select('group_id[]', $groups,$default_group, ['id' => 'group_id', 'class' => 'form-control','multiple'=>'multiple', 'placeholder' => '---可多選群組---']) }}
        </div>
        <div class="form-group">
            <label for="job_title">職稱</label>
            {{ Form::text('job_title',null,['id'=>'job_title','class' => 'form-control', 'placeholder' => '職稱']) }}
        </div>
        <div class="form-group">
            <label for="order_by">排序</label>
            {{ Form::text('order_by',null,['id'=>'order_by','class' => 'form-control', 'placeholder' => '填數字排序']) }}
        </div>
        <div class="form-group">
            <label for="email">電子信箱</label>
            {{ Form::text('email',null,['id'=>'email','class' => 'form-control', 'placeholder' => '電子信箱']) }}
        </div>
        <div class="form-group">
            <label for="website">個人網站</label>
            {{ Form::text('website',null,['id'=>'website','class' => 'form-control', 'placeholder' => '個人網站']) }}
        </div>
        <div class="form-group">
            <div class="form-check">
                {{ Form::checkbox('disable', '1',null,['id'=>'disable','class'=>'form-check-input']) }}
                <label class="form-check-label" for="disable">離職</label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                <i class="fas fa-save"></i> 儲存設定
            </button>
        </div>
    </div>
</div>