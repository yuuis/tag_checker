@extends('layouts.master')
@section('content')

<section>
    <script type="text/javascript">
      // ダイアログオブジェクト
      var dialog = {};

      // デフォルト値を設定
      dialog.setDefault = function() {
        dialog.width = 400;
        dialog.height = 300;
        dialog.body = 'テスト';
        dialog.bodyStyle =
          'padding:10px;'+
          'border-radius: 6px 6px 6px 6px;'+
          'background-color: #FFF;'+
          'box-shadow: 6px 6px 6px rgba(0,0,0,0.4);';
        dialog.backStyle =
          'background-color: #000;'+
          'opacity: 0.5;';
        // dialog.closeButtonHtml =
        //   '<button onclick="dialog.close()" style="float:right;margin:10px;">閉じる</button>'
        dialog.backId = 'dialog_back';
        dialog.bodyId = 'dialog_body';
      };

      dialog.show = function() {

        // 画面の高さを取得
        var getBrowserHeight = function() {
          if ( window.innerHeight ) {
            return window.innerHeight;
          } else if ( document.documentElement &&
            document.documentElement.clientHeight != 0 ) {
            return document.documentElement.clientHeight;
          } else if ( document.body ) {
            return document.body.clientHeight;
          }
          return 0;
        }

        dialog.left = (window.innerWidth - dialog.width) / 2;
        dialog.top = (window.innerHeight - dialog.height) / 2;


        var px = function(value) {
          return value.toString() + 'px';
        };
        var styleRect = function(left, top, width, height) {
          return 'left:' + px(left)
            + ';top:' + px(top)
            + ';width:' + px(width)
            + ';height:' + px(height) + ';'
        };

        var dialogBackStyle = function() {
          var result = '';
          result += 'height:' + px(getBrowserHeight()) + ';';
          result += 'position:absolute;';
          result += 'top:0px;';
          result += 'left:0px;';
          result += 'width:100%;';
          result += dialog.backStyle;
          return result;
        };

        var dialogBodyStyle = function() {
          var result = '';
          result += 'position:absolute;';
          result += dialog.bodyStyle;
          result += styleRect(dialog.left, dialog.top, dialog.width, dialog.height);
          return result;
        };

        var html = document.getElementById("content").innerHTML +
          '<div id="dialog">' +
            '<div id="' + dialog.backId + '" style="' + dialogBackStyle() + '"></div>' +
            '<div id="' + dialog.bodyId + '" style="' + dialogBodyStyle() + '">' +
              dialog.body +
              // dialog.closeButtonHtml +
            '</div>' +
          '</div>';

        document.getElementById("content").innerHTML = html;
      };

      // ダイアログを閉じる
      dialog.close = function() {
        var delNode = document.getElementById("dialog");
        delNode.parentNode.removeChild(delNode);
      };


      var dialogShowType1 = function() {
        dialog.setDefault();
        dialog.show();
      };

      var dialogShowType2 = function() {
        dialog.setDefault();
        dialog.width = 700;
        dialog.height = 60;
        dialog.body = "送信されたサイトを調べています。<br>完了したらcsvファイルをメールに添付して送信しますので少々お待ちください<br>";
        // dialog.closeButtonHtml =
        //   '<button onclick="dialog.close()" style="float:right;margin:10px;">×</button>'
        dialog.show();
      };

    </script>

    @if (isset($results))
      <div class="alert alert-success">{{ "検査を開始しました" }} </div>
    @endif

    <h1>GAtagchecker</h1>

    <br>
    <div class="form-group">
    <form action="/tagcheck" method="post">
      {{ csrf_field() }}
        <div>
            <label>ドメイン</label>
            <input type="text" name="url" id="url" class="form-control" value="">
        </div>
        <br>
        <div>
            <label>トラッキングコード</label>
            <input type="text" name="trackingCode" id="trackingCode" class="form-control" value="">
        </div>
        <br>
        <div>
            <label>メールアドレス</label>
            <input type="text" name="to" id="to" class="form-control" value="">
        </div>
        <br><br>
        <div id="content"></div>
        <button type="submit" class="btn btn-primary" onclick="dialogShowType2()">調べる</button>
    </form>
    </div>

</section>

@endsection