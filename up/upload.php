<?php
	header("Content-type: text/plain; charset=UTF-8");

	set_time_limit(600);

	//ライブラリを読み込み
	include('./class.upload.php');

	//保存先フォルダ
	define("FOLDER", "../images/");

	//サムネイルを設定するか
	define('THUM_FLG', true);

	define('IMAGE_AREA_LENGTH', 400);

	//ファイル名（サンプルではUNIX時間を設定）
	define('FILE_ID', time());

	//アラート
	define('ERROR_ALERT', '<div class="alert alert-danger">');
	define('SUCCESS_ALERT', '<div class="alert alert-success">');

	//成否フラグ
	$flgfileup = false;

	//枚数をカウント
	$filecnt   = 1;

	//保存先フォルダが無ければ作成
	if (!file_exists(FOLDER)) {
		mkdir(FOLDER, 0755);
	}

	//変数をセット
	$dir_dest = (isset($_GET['dir']) ? $_GET['dir'] : FOLDER);
	$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $dir_dest);

	//エラーチェック
	//$_FILESが無い場合
	if(!isset($_FILES['upfile'])){
		echo ERROR_ALERT . "ファイルをアップロード出来ませんでした</div>";
		exit; 
	}

	//エラーコードが吐き出された場合
	foreach ($_FILES['upfile']['error'] as $k => $error){

		if ($error==1){
			echo ERROR_ALERT . "ファイルサイズは規定値を超えています</div>";
			exit; 
		}elseif($error==2){
			echo ERROR_ALERT ."HTMLフォームで規定されてた容量を超えています</div>";
			exit; 
		}elseif($error==3){
			echo ERROR_ALERT . "アップロードに失敗したファイルがあります</div>";
			exit; 
		}elseif($error==3){
			echo ERROR_ALERT . "アップロードに失敗しました</div>";
			exit; 
		}
	}

	//画像かどうかの確認
	foreach ($_FILES['upfile']['tmp_name'] as $k => $file){
		if (!imgFileDist($file)){
			echo ERROR_ALERT . "画像ファイルではないファイルが含まれています</div>";
			exit;
		}
	}

	//[$_FILES]配列を[$files]に変換。
	$files = array();
	foreach ($_FILES['upfile'] as $k => $l) {

		foreach ($l as $i => $v) {
			if (!array_key_exists($i, $files))
				$files[$i] = array();
			$files[$i][$k] = $v;
			
		}
	}

	//画像処理
	$filepath=array();
	
	foreach ($files as $file) {
		
		//CUPの宣言
		$handle = new upload($file);

		if ($handle->uploaded) {
			$filename =  FILE_ID .'_'. $filecnt;
			//全てのファイルをjpgに変換
			$handle->image_convert = 'jpg';
			//ファイル名上書き有効
			$handle->file_overwrite     = true;
			//リネーム無効
			$handle->file_auto_rename   = false;
			//ファイル名指定
			$handle->file_src_name_body = $filename;
			//jpegクオリティ
			$handle->jpeg_quality = 85;
			//アップロード
			$handle->process($dir_dest);

			//サムネイル画像
			if (THUM_FLG == true){
				if ($filecnt == 1){
					$thumfile =  FILE_ID . "_t";
					$handle->image_convert = 'jpg';
					$handle->file_overwrite     = true;
					$handle->file_auto_rename   = false;
					$handle->file_src_name_body = $thumfile;
					$handle->jpeg_quality = 60;

					//リサイズ設定
					$handle->image_resize          = true;
					//縦横比を維持しながら右揃えでトリミング
					$handle->image_ratio_crop      = 'L';
					//サイズ指定
					$handle->image_y               = 400;
					$handle->image_x               = 400;
					//アップロード
					$handle->Process($dir_dest);
				}
			}

			// アップロードに成功した場合
			if ($handle->processed) {
				if($filecnt==1){
					$filepath[] = FOLDER . $thumfile .".jpg";
				}
				$filepath[] = FOLDER . $filename .".jpg";
				//$imagesize = getimagesize($dir_dest.'/'.FILE_ID.'_'. $filecnt .'.jpg');
				//$file_size[] = $imagesize[0].'x'.$imagesize[1];
				$filecnt += 1;
			} else {
				// 失敗した場合
				echo ERROR_ALERT . "画像処理に失敗しました</div>";
				exit;
			}

		} else {
			echo ERROR_ALERT . "ファイルが選択されていません</div>";
			exit;
		}
	}

	//ファイルの最終確認
	$FileExistsFlg = true;
	foreach ($filepath as $file){
		if(!file_exists($file)){
			$FileExistsFlg = false;
			break;
		} 
	}

	if($FileExistsFlg){
		echo SUCCESS_ALERT . "画像をアップロードしました</div>";
	}else{
		echo ERROR_ALERT . "画像のアップロードに失敗しました</div>";
	}

function imgFileDist($file){
	//画像ファイルかどうかを確認する関数
	if (!file_exists($file)) {
		return false;
		exit;
	}else{
		$type = exif_imagetype($file);
	}

	switch ($type) {
		case IMAGETYPE_GIF:
			return true;
			exit;
		case IMAGETYPE_JPEG:
			return true;
			exit;
		case IMAGETYPE_PNG:
			return true;
			exit;
		case IMAGETYPE_BMP:
			return true;
			exit;
		default:
			return false;
			exit;
	}
}
	
?>