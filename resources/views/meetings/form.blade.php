<script src="{{ asset('gijgo/js/gijgo.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('gijgo/css/gijgo.min.css') }}" rel="stylesheet" type="text/css">
<div class="card my-4">
    <h3 class="card-header">會議資料</h3>
    <div class="card-body">
        <div class="form-group">
            <label for="title">會議日期(月/日/西元)*</label>
            <input id="datepicker" width="276" name="open_date" value="{{ $default_date }}">
            <script>
                $('#datepicker').datepicker({
                    uiLibrary: 'bootstrap4'
                });
            </script>
        </div>
        <div class="form-group">
            <label for="title">會議名稱*</label>
            {{ Form::text('name',$default_name,['id'=>'title','class' => 'form-control', 'placeholder' => '會議名稱']) }}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                <i class="fas fa-save"></i> 儲存設定
            </button>
        </div>

    </div>
</div>