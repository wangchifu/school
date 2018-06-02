<script src="{{ asset('gijgo/js/gijgo.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('gijgo/css/gijgo.min.css') }}" rel="stylesheet" type="text/css">
<div class="card my-4">
    <h3 class="card-header">問卷資料</h3>
    <div class="card-body">
        <div class="form-group">
            <label for="disable">停用？停用才能增加題目。</label>
            <div class="form-check">
                {{ Form::checkbox('disable', '1',$disable ,['id'=>'disable','class'=>'form-check-input']) }}
                <label class="form-check-label" for="disable"><span class="btn btn-info btn-sm">設定</span></label>
            </div>
        </div>
        <div class="form-group">
            <label for="name">名稱*</label>
            {{ Form::text('name',null,['id'=>'name','class' => 'form-control', 'placeholder' => '名稱']) }}
        </div>
        <div class="form-group">
            <label for="do">對象*</label>
            {{ Form::select('do', $groups,null, ['id' => 'do', 'class' => 'form-control']) }}
        </div>
        <div class="form-group">
            <label for="datepicker">截止日期(西元/月/日)*</label>
            <input id="datepicker" width="276" name="unpublished_at" value="{{ $default_date }}">
            <script src="{{ asset('gijgo/js/messages/messages.zh-TW.js') }}"></script>
            <script>
                $('#datepicker').datepicker({
                    uiLibrary: 'bootstrap4',
                    format: 'yyyy-mm-dd',
                    locale: 'zh-TW',
                });
            </script>
        </div>
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <div class="form-group">
            <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                <i class="fas fa-save"></i> 儲存設定
            </button>
        </div>
    </div>
</div>