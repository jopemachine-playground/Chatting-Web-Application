<?php

$fileName = $_POST["a1"];
$word = $_POST["b1"];

if(!file_exists('data.txt')){
	$myFile = fopen("data.txt", "x+") or die("Unable to make file!");
}
else{
	$myFile = fopen("data.txt", "a+") or die("Unable to open file!");
}


class FileInfo{
	public static function saveInfo($_fileName, $_word){
		// $content = $_fileName . " " . $_word . "\n";
		// $content = '"' . $_fileName . '"' . "=>" . '"' . "$_word" .'"'. "\n";

		$content = $_fileName . "=>" . "$_word". "\n";
		$myFile = fopen("data.txt", "a+") or die("Unable to open file!");
		fwrite($myFile, $content);
	}
}

FileInfo::saveInfo($fileName, $word);

echo ("<script>location.href='AllDataShowAction.php';</script>");

?>
