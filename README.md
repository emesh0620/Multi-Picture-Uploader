# Multi Picture Uploader
## 概要
大容量の画像をアップするときにブラウザのローディングではユーザーを不安にしてしてしまったり体感時間が長く感じられます。そこでAjaxで「画像をアップロードしています」という表示とローディングアニメーションを表示し、終われば「アップロードしました」（あるいはエラー時にはエラーメッセージを表示するアップローダーを作成しました。
他に欲しかった機能は以下の通りです。
1. 画像ファイルのみをアップロードすること
2. 同名ファイルの上書き
3. 大きすぎるファイルの画像処理
4. サムネイル機能の保存
5. 複数ファイルをアップするときには1ページ目に表示する画像のみサムネイル化
後述の参考URL等を参考に実装してみました。

## ライセンスについて
class.upload.phpはフリーで使う際にはGNUライセンスとなるので、このライブラリもGNUライセンスとなります。なお、使用して生じた損害は責任を負いかねます。


# 参考URL
[コピペで使う！画像アップロード付きAjax（JQuery）フォーム サンプル](https://tadworks.jp/archives/1846) - Ajax部分の参考に

[【PHP】PHPでファイルの送信フォーム](https://www.webdlab.com/labs/form-file-upload/) - 
PHP部分の大筋の参考に

[至高のファイルアップロード](https://qiita.com/kawasima/items/f80bc54efb12d5509c0b) - 
画像プレビュー機能の参考に

[PHPまとめ - 画像ファイル判別](http://doremi.s206.xrea.com/php/tips/imgtype.html) - 
画像判別関数の参考に

[PHPの画像アップロードライブラリ class.upload.php を使ってみた](http://webtech-walker.com/archive/2007/06/11210929.html) - class.upload.phpの参考に

[[PHP][メモ]class.upload.phpに関するメモ（docs）](https://happyquality.com/2009/08/26/1034.htm) - class.upload.phpの参考に

## License
GNU