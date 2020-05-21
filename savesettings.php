<?php 
if(isset($_POST['settingsgeneral']))
{
    file_put_contents("settingsgeneral.dat", $_POST['settingsgeneral']);
    //echo $_POST['settingsgeneral'];
	echo "true";
}
else
{
	echo "false";
}

?>