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
                //Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy

					if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$url', '$email', 0,0)"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
            }
    }

    $polaczenie->close();
?>