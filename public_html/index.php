<?php
include "mymap.php";

function binarySearch($full_path, $target){
  $file = fopen($full_path, "r");
  $array=array();
  $i=0;
  while(!feof($file)){
      $line=fgets($file);
      $lines=explode("\t", $line);
      $mymap=new MyMap($lines[0], $lines[1]);
      $array[$i]=$mymap;
      $i++;
  }
  if (count($array) === 0) return "undef";
  $left = 0;
  $right = count($array) - 1;
  while (($left + 1) < $right) {
      $mid = $left + ($right - $left) / 2;
      if ($target < $array[$mid]->getKey()) {
        $right = $mid;
      } else {
        $left = $mid;
      }
  }
  if($array[$left]->getKey() === $target)
    return $array[$left]->getValue();
    return "undef";
}

?>
<html>
  <head>
    <title>Binary Search</title>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
  </head>
  <body>
    <div class="parent">
    <div class="mainblock" align="center">
      <H1>Binary Search</H1>
      <div class="fieldblock" align="left">
        <form action="index.php" method="post" enctype="multipart/form-data">
          Файл: <input type="file" name="uploadfile"/><br>
          Ключ:  <input type="text" name="key"/><br>
          <input type="submit" value="Загрузить файл и выполнить поиск" name="submit"><br>
        </form>
      <div>
        <?php
        if($_POST){
            $found="undef";
            if($_FILES['uploadfile']['error']==0){
                $path = 'uploads/';
                $filename=$_FILES['uploadfile']['name'];
                $full_path = $path.$filename;
                if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $full_path)!=FALSE)
                  $found = binarySearch($full_path, $_POST['key']);
                else echo "FILE NOT LOADED";
            }
            echo "Значение по ключу: ".$found;
          }?>
        </div>
      </div>
    </div></div>
  </body>
</html>
