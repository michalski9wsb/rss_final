<?php
    $email = $_GET['email'];
    $url= $_GET['url'];

    require_once "connect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if(isset($_GET['save']))
    {
        if ($polaczenie->connect_errno!=0)
			{
				echo("Jakis blad polaczaenia z baza");
            }else{

            }
    }

    $polaczenie->close();
?>