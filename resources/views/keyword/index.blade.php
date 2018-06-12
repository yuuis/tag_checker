@extends('layouts.master')
@section('content')

<section>
   <script>
   jQuery(function($){
        // デフォルトの設定を変更
        $.extend( $.fn.dataTable.defaults, {
            language: {
                url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
            }
        });

            $("#table").DataTable();
        });
    </script>
  <h1>キーワード一覧</h1>

  <table id="table" class="table table-bordered">
        <thead>
            <tr>
                <th>企業名</th>
                <th>キーワード</th>
                <th>URL</th>
                <th>前回実行結果</th>
                <th>状態</th>
            </tr>
        </thead>
        <tbody>
        @if (isset($results))
    @foreach ($results as $rows)
        <tr>
          <td><a href="../company/detail/{{$rows->m_company_sid}}">{{$rows->company_name}}</a></td>
          <td><a href="../keyword/detail/{{$rows->m_keyword_sid}}/{{$rows->m_company_sid}}">{{$rows->target_keyword}}</a></td>
          <td>{!!str_replace(",", "<br>", $rows->target_url)!!}</td>
          <td><a href="../detection/history/{{$rows->m_keyword_sid}}">{!!str_replace([",", "<<<", ">>>"], ["<br>", "<object><a href='", "' target='_blank' style='color:tomato'>[リンク先]</a></object>"], $rows->detection_result_text)!!}</a></td>
          <td>
          @if ($rows->active_flag === 1)
            有効
          @else
            無効
          @endif
    </td>
        </tr>
        @endforeach
        @endif
        </tbody>
    </table>
  <br>
    <button type="button" class="btn btn-primary" style="margin-bottom: 15px" onclick="location.href='company/detail'">企業登録</button>
</section>
@endsection
