@extends('layouts.master')
@section('content')

<!-- html = ""
blade変数 '' -->
<section>
	 <script>
        var iterator = 2;
        $(function() {
            $('#add').click(function() {
                var copied_block = $('#form-1').prop('outerHTML');
                var block = $(copied_block).attr('id', 'form-' + iterator);
                $('.block').append(block);
                iterator++;
            });
            $(".block").on('click', '.remove', function() {
                $(this).parents('.form-inline').remove();
            });
            $("#source").hide();
        });
    </script>
	<h1>キーワード情報詳細登録・変更</h1>
    @if (\Session::get("status") === "success")
        <div class="alert alert-success">{{ "登録が完了しました" }} </div>
    @endif

	<div class="form-group">
	@include('commons.form', ['id' => 'keyword_form', 'action' => '/keyword/register', 'autocomplete' => false, 'buttonNo' => Config::get('const.ORIGN_BUTTON_NO_NAME_REGISTER')])
    <input type="hidden" name="token" value="{{\Session::get('token')}}">
		<div>
            <label>キーワード</label>
            <input type="text" name="targetKeyword" id="targetKeyword" class="form-control" value="{{\App\Helpers\ViewHelper::viewString($inputs, 'targetKeyword')}}@if(isset($results['keyword'][0])){{$results['keyword'][0]->target_keyword}}@endif">
            @include('commons.error', ['target' => 'targetKeyword', 'pairId' => 'targetKyeword']) <br></div>
        <div>
            <label>アクティブ</label>
            <select name="activeFlag">
                    <option value="1" @if((isset($results['keyword'][0]) && $results['keyword'][0]->active_flag == 1) || (\App\Helpers\ViewHelper::viewString($inputs, 'activeFlag') == 1)) ) 
                        {{"selected"}} 
                    @endif>有効</option>
                    <option value="0" @if((isset($results['keyword'][0]) && $results['keyword'][0]->active_flag == 0) || (\App\Helpers\ViewHelper::viewString($inputs, 'activeFlag') === 0) ) 
                        {{"selected"}} 
                    @endif>無効</option>
            </select> <br></div>

        <label>対象URL</label>
        <div class="block">
            <div class="form-inline" id="form-0" style="margin-bottom:15px">
                <input type="text" name="targetUrl[]" id="targetUrl.0" class="form-control" style="width:80%" value="{{\App\Helpers\ViewHelper::viewStringForArray($inputs, 'targetUrl', 0)}}@if(isset($results['url'][0])){{$results['url'][0]->target_url}}@endif">
                <select name="searchType[]" style="margin-left: 5px">
                    <option value="1" 
                    @if((isset($results['url']) && isset($results['url'][0]) && $results['url'][0]->search_type == 1) || (\App\Helpers\ViewHelper::viewStringForArray($inputs, 'searchType', 0) == 1) ) 
                        {{"selected"}} 
                    @endif>前方一致</option> 
                    <option value="2" 
                    @if((isset($results['url']) && isset($results['url'][0]) && $results['url'][0]->search_type == 2) || (\App\Helpers\ViewHelper::viewStringForArray($inputs, 'searchType', 0) == 2) )
                        {{"selected"}} 
                    @endif>完全一致</option> 
                </select>
                <select name="urlActiveFlag[]" style="margin-left: 5px">
                    <option value="1" @if((isset($results['url']) && isset($results['url'][0]) && $results['url'][0]->active_flag == 1) || (\App\Helpers\ViewHelper::viewStringForArray($inputs, 'urlActiveFlag', 0) == 1 ) ) {{"selected"}} @endif>有効</option> 
                    <option value="0" @if((isset($results['url']) && isset($results['url'][0]) && $results['url'][0]->active_flag === 0) || (\App\Helpers\ViewHelper::viewStringForArray($inputs, 'urlActiveFlag', 0) === 0 ) ) {{"selected"}} @endif>無効</option>
                </select>
                <button type="button" class="btn btn-warning remove" style="margin-left: 5px">削除</button>
                @include('commons.error', ['target' => 'targetUrl.0', 'pairId' => 'targetUrl.0'])
            </div>


        @if (isset($results['url'][1]))
        @for ($i=1; $i<count($results['url']); $i++)
            <div class="form-inline" id="form-0" style="margin-bottom:15px">
                <input type="text" name="targetUrl[]" id="targetUrl.{{$i}}" class="form-control" style="width:80%" value="{{\App\Helpers\ViewHelper::viewStringForArray($inputs, 'targetUrl', $i)}}@if(isset($results['url'][1])){{$results['url'][$i]->target_url}}@endif">
                <select name="searchType[]" style="margin-left: 5px">
                    <option value="1" @if(isset($results['url']) && isset($results['url'][$i]) && $results['url'][$i]->search_type == 1){{"selected"}} @endif>前方一致</option>
                    <option value="2" @if(isset($results['url']) && isset($results['url'][$i]) && $results['url'][$i]->search_type == 2){{"selected"}} @endif>完全一致</option>
                </select>
                <select name="urlActiveFlag[]" style="margin-left: 5px">
                    <option value="1" @if(isset($results['url']) && isset($results['url'][$i]) && $results['url'][$i]->active_flag == 1){{"selected"}} @endif>有効</option>
                    <option value="0" @if(isset($results['url']) && isset($results['url'][$i]) && $results['url'][$i]->active_flag === 0){{"selected"}} @endif>無効</option>
                </select>
                <button type="button" class="btn btn-warning remove" style="margin-left: 5px">削除</button>
                @include('commons.error', ['target' => 'targetUrl.{{$i}}', 'pairId' => 'targetUrl.{{$i}}'])
            </div>
        @endfor
        @endif

        @if (isset($errors))
        @for ($i=1; $i<count($inputs['targetUrl']); $i++)
            <div class="form-inline" id="form-0" style="margin-bottom:15px">
                <input type="text" name="targetUrl[]" id="targetUrl.{{$i}}" class="form-control" style="width:80%" value="{{\App\Helpers\ViewHelper::viewStringForArray($inputs, 'targetUrl', $i)}}@if(isset($results['url'][1])){{$results['url'][1]->target_url}}@endif">
                <select name="searchType[]" style="margin-left: 5px">
                    <option value="1" 
                    @if((isset($results['url']) && isset($results['url'][$i]) && $results['url'][$i]->search_type == 1) || (\App\Helpers\ViewHelper::viewStringForArray($inputs, 'searchType', $i) == 1) )
                        {{"selected"}} 
                    @endif>前方一致</option>
                    <option value="2" 
                    @if((isset($results['url']) && isset($results['url'][$i]) && $results['url'][$i]->search_type == 2) || (\App\Helpers\ViewHelper::viewStringForArray($inputs, 'searchType', $i) == 2) )
                        {{"selected"}} 
                    @endif>完全一致</option>
                </select>
                <select name="urlActiveFlag[]" style="margin-left: 5px">
                    <option value="1" 
                    @if((isset($results['url']) && isset($results['url'][$i]) && $results['url'][$i]->active_flag == 1) || (\App\Helpers\ViewHelper::viewStringForArray($inputs, 'urlActiveFlag', $i) == 1))
                        {{"selected"}} 
                    @endif>有効</option>
                    <option value="0" 
                    @if((isset($results['url']) && isset($results['url'][$i]) && $results['url'][$i]->active_flag == 0) || (\App\Helpers\ViewHelper::viewStringForArray($inputs, 'urlActiveFlag', $i) === 0))
                        {{"selected"}} 
                    @endif>無効</option>
                </select>
                <button type="button" class="btn btn-warning remove" style="margin-left: 5px">削除</button>
                @include('commons.error', ['target' => 'targetUrl.'.$i, 'pairId' => 'targetUrl.'.$i])
            </div>
        @endfor
        @endif
        </div>

        <button type="button" class="btn btn-info" id="add">行を追加</button>
        <br>
        <br>

        <button type="submit" class="btn btn-primary">登録</button>
        <button type="button" class="btn btn-success" onclick="javascript:window.history.back(-1);return false;">戻る</button>
	</form>
	 <div id="source">
            <div class="form-inline" id="form-1" style="margin-bottom:15px">
                <input type="text" name="targetUrl[]" id="targetUrl" class="form-control" style="width:80%">
                <select name="searchType[]" style="margin-left: 5px">
                    <option value="1">前方一致</option>
                    <option value="2">完全一致</option>
                </select>
                <select name="urlActiveFlag[]" style="margin-left: 5px">
                    <option value="1">有効</option>
                    <option value="0">無効</option>
                </select>
                <button type="button" class="btn btn-warning remove" style="margin-left: 5px">削除</button>
            </div>
        </div>
	</div>

</section>
@endsection
