@extends('layouts.master')

@section('page-title', '校務計畫 | 和東國小')

@section('content')
<br><br><br>
<div class="container">
    <h1 class="text-danger"><i class="fas fa-book"></i> 校務計畫</h1>
    <br><br>
    <?php
    $final = end($folder_path);
    $final_key = key($folder_path);
    $p="";
    $f="app/public/school_plans";
    $last_folder = "";
    ?>
    路徑：
    @foreach($folder_path as $k=>$v)
        <?php
            if($k=="0"){
                $k = null;

            }else{
                $p .= '&'.$k;
                $f .=  '/'.$v;
            }
            if($k != $final_key and !empty($k)){
                $last_folder .= '&'.$k;
            }

        ?>
        @if($v == $final)
            <i class="fa fa-folder-open text-warning"></i> <a href="{{ route('school_plans.index',$p) }}">{{$v}}</a>/
        @else
            <i class="fa fa-folder text-warning"></i> <a href="{{ route('school_plans.index',$p) }}">{{$v}}</a>/
        @endif
    @endforeach
    <table class="table table-striped">
        <thead class="thead-light">
        <tr>
            <th>目錄 / 檔案名稱</th>
            <th>類型</th>
            <th>數量</th>
            <th>建立時間</th>
        </tr>
        </thead>
        <tbody>
        @if($path!=null)
        <tr>
            <td><i class="fas fa-arrow-circle-left"></i> <a href="{{ route('school_plans.index',$last_folder) }}">上一層</a></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endif
        @foreach($folders as $folder)
            <?php
                $folder_p = $path.'&'.$folder->id;
            ?>
            <tr>
                <td>
                    <i class="fas fa-folder text-warning"></i> <a href="{{ route('school_plans.index',$folder_p) }}">{{ $folder->name }}</a></td>
                </td>
                <td>
                    <?php $n = \App\Upload::where('folder_id',$folder->id)->count();?>
                    <strong>目錄</strong>
                    @if($on_folder and $n == 0)
                        <a href="{{ route('school_plans.delete',$folder_p) }}" id="delete_folder{{ $folder->id }}" onclick="bbconfirm_Link('delete_folder{{ $folder->id }}','確定刪除目錄 {{ $folder->name }} ?')"><i class="fas fa-minus-square text-danger"></i></a>
                    @endif
                </td>
                <td>
                    {{ $n }} 個項目
                </td>
                <td>

                </td>
            </tr>
        @endforeach
        @foreach($files as $file)
            <?php
            $file_p = $path.'&'.$file->id;
            ?>
            <tr>
                <td>
                    <i class="fas fa-file text-info"></i> <a href="{{ route('school_plans.download',$file_p) }}">{{ $file->name }}</a></td>
                </td>
                <td>
                    檔案
                    @if($on_folder)
                        <a href="{{ route('school_plans.delete',$file_p) }}" id="delete_file{{ $file->id }}" onclick="bbconfirm_Link('delete_file{{ $file->id }}','確定刪除檔案 {{ $file->name }} ?')"><i class="fas fa-minus-square text-danger"></i></a>
                    @endif
                </td>
                <td>
                    {{ filesizekb(storage_path($f.'/'.$file->name)) }} kB
                </td>
                <td>
                    {{ date ("Y-m-d H:i:s",filemtime(storage_path($f.'/'.$file->name))) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <hr>
    @can('create',\App\Upload::class)
        @if($has_dir==null)
            <a href="{{ route('school_plans.create') }}" class="btn btn-success btn-sm" id="create" onclick="bbconfirm_Link('create','要新增自己職稱的目錄？')"><i class="fas fa-plus"></i> 新增根目錄</a>
        @endif
        @if($on_folder)
        <div class="card my-4">
            <h3 class="card-header">新增</h3>
            <div class="card-body">
            {{ Form::open(['route' => 'school_plans.create_folder', 'method' => 'POST','id'=>'create_folder','onsubmit'=>'return false;']) }}
            <div class="form-group">
                <label for="name"><strong>1.子目錄</strong></label>
                {{ Form::text('name',null,['id'=>'name','class' => 'form-control','placeholder'=>'名稱']) }}
            </div>
            <div class="form-group">
                <input type="hidden" name="folder_id" value="{{ $on_folder }}">
                <input type="hidden" name="path" value="{{ $path }}">
                <a href="#" class="btn btn-success btn-sm" onclick="bbconfirm_Form('create_folder','確定新增子目錄？')"><i class="fas fa-plus"></i> 新增子目錄</a>
            </div>
            {{ Form::close() }}
            <hr>
            {{ Form::open(['route' => 'school_plans.upload_file', 'method' => 'POST','id'=>'upload_file','files' => true,'onsubmit'=>'return false;']) }}
            <div class="form-group">
                @include('layouts.alert')
                <label for="file"><strong>2.檔案</strong></label>
                {{ Form::file('files[]', ['class' => 'form-control','multiple'=>'multiple']) }}
            </div>
            <div class="form-group">
                <input type="hidden" name="folder_id" value="{{ $on_folder }}">
                <input type="hidden" name="path" value="{{ $path }}">
                <a href="#" class="btn btn-success btn-sm" onclick="bbconfirm_Form('upload_file','確定新增檔案？')"><i class="fas fa-plus"></i> 新增檔案</a>
            </div>
            {{ Form::close() }}
            </div>
        </div>
        @endif
    @endcan
</div>
@endsection