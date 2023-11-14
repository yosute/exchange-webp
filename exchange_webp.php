<?php
  // worning表示が邪魔なので非表示
  // error_reporting(0);

  // 変換する拡張子の配列
  $file_type = ['.jpg', '.jpeg', '.JPG', '.JPEG', '.jpe', '.jfif', '.pjpeg', '.pjp','.PNG','.png'];
  // 変換せずに移動だけする配列
  $move_file_type = ['.webp','.GIF','.gif','.svg','.svgz','.tiff','.tif'];

  // assetsのimgディレクトリ以下に動作するので指定
  $dir_name = './img/';

  //img以下のディレクトリの名前を取得 
  $directry_name_array = array();
  $directry_name_array = get_directry_name_list($dir_name);
  // 変換する拡張子の時の処理
  foreach($file_type as $type){
    foreach($directry_name_array as $directry_name){
      if(strpos($directry_name,'webp') === false){
        $filepath = getfilepath($type,$dir_name,$directry_name);
        if(!is_null($filepath)){
          createwebp($filepath,$directry_name,$dir_name,$type);
        }
      }
    }
  }
  // 上と同じようにディレクトリ名を全て取得
  $directory_name_move_list = array();
  $directory_name_move_list = get_directry_name_list($dir_name);
  // 移動させる拡張子の時の処理
  foreach($move_file_type as $mv_type){
    foreach($directory_name_move_list as $directry_move_name){
      if(strpos($directry_move_name,'webp') === false){
        $filepath = getfilepath($mv_type,$dir_name,$directry_move_name);
        if(!is_null($filepath)){
          movefile($directry_move_name,$dir_name,$filepath);
        }
      }
    }
  }

  // ディレクトリ名を取得する関数
  function get_directry_name_list($dir_name){
    // ディレクトリやファイル名を取れるglob関数　
    // GLOB_ONLYDIRはディレクトリだけ取得するオプション

    $directry_name_list = glob($dir_name.'*',GLOB_ONLYDIR);
    $directry_name_array = array();
    foreach($directry_name_list as $value){
      $directry_name = str_replace($dir_name,'',$value);
      array_push($directry_name_array,$directry_name);
    }
    return $directry_name_array;
  }

  // ファイルの名前をパスごと取得する
  function getfilepath($filetype,$dir_name,$directry_name){
    $current_path = $dir_name.$directry_name.'/*'.$filetype;
    $jpgfilename = glob($current_path);
    return $jpgfilename;
  }

  // webpに変換する関数
  function createwebp($file_path,$directry_name,$dir_name,$file_type){
    foreach($file_path as $path){
      // 変換する画像のファイル名を取得
      $file_name=$path;
      
      // webpを保存するパスを作成
      $output_filename = str_replace($dir_name,'',$path);

      $output_filename = str_replace($directry_name.'/','',$output_filename);

      $output_filename = str_replace($file_type,'',$output_filename);

      // 出力先のパスを生成
      $output_path = $dir_name.$directry_name.'_webp/'.$output_filename.'.webp';
      checkdirectry($dir_name.$directry_name.'_webp/');
      // jpegとpngで使う関数が違うので分岐
      switch($file_type){
        case '.jpeg':
        case '.JPEG':
        case '.JPG':
        case '.jpg':
        case '.jpe':
        case '.jfif':
          $img = imagecreatefromjpeg($file_name);
          $webp = imagewebp($img,$output_path,100);
          // 読み込んだ画像をメモリから開放しておく
          imagedestroy($img);
          break;
        case '.pjpeg': 
        case '.pjp':
        case '.PNG':
        case '.png':
          $img = imagecreatefrompng($file_name);
          $webp = imagewebp($img,$output_path,100);
          // 読み込んだ画像をメモリから開放しておく
          imagedestroy($img);
          break;
      }
      // ファイル生成後ファイルサイズを確認する
      checkfilesize($file_name,$output_path);
    }
  }
  // ファイルを移動させる関数
  function movefile($directry_name,$dir_name,$file_path){
    foreach($file_path as $file_name){
      // 移動先のパスを作成
      $output_filename=str_replace($dir_name,'',$file_name);
      $output_filename=str_replace($directry_name.'/','',$output_filename);
      $destination_file_path = $dir_name.$directry_name.'_webp'.'/'.$output_filename;
      
      // 判定するwebpフォルダのパスを生成
      $check_path=$dir_name.$directry_name.'_webp';

      // 拡張子がwebpの時は先に変換していたwebpが入っている場合も考えて
      // フォルダを作る
      if(strpos($file_name,'.webp') === false){
        checkdirectry($check_path);
      }
      // フォルダを移動する　rename関数
      // メッセージが出るときは、webpに変換できるものかwebpが存在しない時
      if(!rename($file_name,$destination_file_path)){
        echo "ファイルの移動ができません！\n
              フォルダ内のファイル拡張子を確認してください\n";
        echo($file_name);
      }
    }
  }

  // ディレクトリがあるかを確認してなければ作成する
  function checkdirectry($directory_path){
    //「$directory_path」で指定されたディレクトリが存在するか確認
    if(file_exists($directory_path)){
        //存在したときの処理何もしない
    }else{
      //存在しないときの処理（「$directory_path」で指定されたディレクトリを作成する）
      if(mkdir($directory_path, 0777)){
          //作成したディレクトリのパーミッションを確実に変更
          chmod($directory_path, 0777);
          //作成に成功した時の処理
      }else{
          //作成に失敗した時の処理
      }
    }
  }
  
  // webpと元画像のデータサイズを確認する
  function checkfilesize($file_name,$output_path){
    $base_filesize = filesize($file_name);
    $webp_filesize = filesize($output_path);
    if($base_filesize <= $webp_filesize){
      print("元の画像のサイズの方が小さいです\n");
      print($output_path);
    }
  }

