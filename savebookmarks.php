<?php 
if(isset($_POST['bookmarks']))
{
    file_put_contents("settingsbookmarks.dat", $_POST['bookmarks']);
    echo "true";
}
else
{
	echo "false";
}

?>