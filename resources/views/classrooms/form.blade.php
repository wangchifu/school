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
        <div class="card my-4">
            <div class="card-header">
                <label for="disable">不開放節次</label>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td>星期日</td><td>星期一</td><td>星期二</td><td>星期三</td><td>星期四</td><td>星期五</td><td>星期六</td>
                    </tr>
                    <tr>
                        @for($i=0;$i<7;$i++)
                            <td>
                                <div class="form-check">
                                    {{ Form::checkbox('close_section['.$i.'][0]', null,$close[$i][0] ,['id'=>'s'.$i.'0','class'=>'form-check-input']) }}
                                    <label class="form-check-label" for="s{{ $i }}0"><span class="btn btn-success btn-sm">晨間</span></label>
                                </div>
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        @for($i=0;$i<7;$i++)
                            <td>
                                <div class="form-check">
                                    {{ Form::checkbox('close_section['.$i.'][1]', null,$close[$i][1] ,['id'=>'s'.$i.'1','class'=>'form-check-input']) }}
                                    <label class="form-check-label" for="s{{ $i }}1"><span class="btn btn-info btn-sm">第一節</span></label>
                                </div>
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        @for($i=0;$i<7;$i++)
                            <td>
                                <div class="form-check">
                                    {{ Form::checkbox('close_section['.$i.'][2]', null,$close[$i][2] ,['id'=>'s'.$i.'2','class'=>'form-check-input']) }}
                                    <label class="form-check-label" for="s{{ $i }}2"><span class="btn btn-info btn-sm">第二節</span></label>
                                </div>
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        @for($i=0;$i<7;$i++)
                            <td>
                                <div class="form-check">
                                    {{ Form::checkbox('close_section['.$i.'][3]', null,$close[$i][3] ,['id'=>'s'.$i.'3','class'=>'form-check-input']) }}
                                    <label class="form-check-label" for="s{{ $i }}3"><span class="btn btn-info btn-sm">第三節</span></label>
                                </div>
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        @for($i=0;$i<7;$i++)
                            <td>
                                <div class="form-check">
                                    {{ Form::checkbox('close_section['.$i.'][4]', null,$close[$i][4] ,['id'=>'s'.$i.'4','class'=>'form-check-input']) }}
                                    <label class="form-check-label" for="s{{ $i }}4"><span class="btn btn-info btn-sm">第四節</span></label>
                                </div>
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        @for($i=0;$i<7;$i++)
                            <td>
                                <div class="form-check">
                                    {{ Form::checkbox('close_section['.$i.'][45]', null,$close[$i][45] ,['id'=>'s'.$i.'45','class'=>'form-check-input']) }}
                                    <label class="form-check-label" for="s{{ $i }}45"><span class="btn btn-warning btn-sm">午休</span></label>
                                </div>
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        @for($i=0;$i<7;$i++)
                            <td>
                                <div class="form-check">
                                    {{ Form::checkbox('close_section['.$i.'][5]', null,$close[$i][5] ,['id'=>'s'.$i.'5','class'=>'form-check-input']) }}
                                    <label class="form-check-label" for="s{{ $i }}5"><span class="btn btn-info btn-sm">第五節</span></label>
                                </div>
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        @for($i=0;$i<7;$i++)
                            <td>
                                <div class="form-check">
                                    {{ Form::checkbox('close_section['.$i.'][6]', null,$close[$i][6] ,['id'=>'s'.$i.'6','class'=>'form-check-input']) }}
                                    <label class="form-check-label" for="s{{ $i }}6"><span class="btn btn-info btn-sm">第六節</span></label>
                                </div>
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        @for($i=0;$i<7;$i++)
                            <td>
                                <div class="form-check">
                                    {{ Form::checkbox('close_section['.$i.'][7]', null,$close[$i][7] ,['id'=>'s'.$i.'7','class'=>'form-check-input']) }}
                                    <label class="form-check-label" for="s{{ $i }}7"><span class="btn btn-info btn-sm">第七節</span></label>
                                </div>
                            </td>
                        @endfor
                    </tr>
                </table>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" onclick="bbconfirm_Form('setup','確定儲存嗎？')">
                <i class="fas fa-save"></i> 儲存設定
            </button>
        </div>
    </div>
</div>