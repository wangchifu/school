<div class="card my-4">
    <h3 class="card-header">教室資料</h3>
    <div class="card-body">
        <div class="form-group">
            <label for="name">名稱*</label>
            {{ Form::text('name',null,['id'=>'name','class' => 'form-control', 'placeholder' => '名稱']) }}
        </div>
        <div class="form-group">
            <label for="disable">停用？</label>
            <div class="form-check">
                {{ Form::checkbox('disable', '1',$disable ,['id'=>'disable','class'=>'form-check-input']) }}
                <label class="form-check-label" for="disable"><span class="btn btn-info btn-sm">設定</span></label>
            </div>
        </div>
        <div class="form-group">
            <label for="disable">不開放節次</label>
            <div class="form-check">
                {{ Form::checkbox('close_section[0]', null,$disable ,['id'=>'s0','class'=>'form-check-input']) }}
                <label class="form-check-label" for="s0"><span class="btn btn-success btn-sm">晨間</span></label>
            </div>
            <br>
            <div class="form-check">
                {{ Form::checkbox('close_section[1]', null,$disable ,['id'=>'s1','class'=>'form-check-input']) }}
                <label class="form-check-label" for="s1"><span class="btn btn-info btn-sm">第一節</span></label>
            </div>
            <br>
            <div class="form-check">
                {{ Form::checkbox('close_section[2]', null,$disable ,['id'=>'s2','class'=>'form-check-input']) }}
                <label class="form-check-label" for="s2"><span class="btn btn-info btn-sm">第二節</span></label>
            </div>
            <br>
            <div class="form-check">
                {{ Form::checkbox('close_section[3]', null,$disable ,['id'=>'s3','class'=>'form-check-input']) }}
                <label class="form-check-label" for="s3"><span class="btn btn-info btn-sm">第三節</span></label>
            </div>
            <br>
            <div class="form-check">
                {{ Form::checkbox('close_section[4]', null,$disable ,['id'=>'s4','class'=>'form-check-input']) }}
                <label class="form-check-label" for="s4"><span class="btn btn-info btn-sm">第四節</span></label>
            </div>
            <br>
            <div class="form-check">
                {{ Form::checkbox('close_section[45]', null,$disable ,['id'=>'s45','class'=>'form-check-input']) }}
                <label class="form-check-label" for="s45"><span class="btn btn-warning btn-sm">午休</span></label>
            </div>
            <br>
            <div class="form-check">
                {{ Form::checkbox('close_section[5]', null,$disable ,['id'=>'s5','class'=>'form-check-input']) }}
                <label class="form-check-label" for="s5"><span class="btn btn-info btn-sm">第五節</span></label>
            </div>
            <br>
            <div class="form-check">
                {{ Form::checkbox('close_section[6]', null,$disable ,['id'=>'s6','class'=>'form-check-input']) }}
                <label class="form-check-label" for="s6"><span class="btn btn-info btn-sm">第六節</span></label>
            </div>
            <br>
            <div class="form-check">
                {{ Form::checkbox('close_section[7]', null,$disable ,['id'=>'s7','class'=>'form-check-input']) }}
                <label class="form-check-label" for="s7"><span class="btn btn-info btn-sm">第七節</span></label>
            </div>
            <br>
        </div>
        <hr>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                <i class="fas fa-save"></i> 儲存設定
            </button>
        </div>
    </div>
</div>