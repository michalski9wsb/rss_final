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

					if ($polaczenie->query("INSERT INTO rss VALUES ('$url', '$email', NULL,0)"))
					{
						echo("zakonczono sukcesem");
					}
					else
					{
						echo("spierdalaj, nie dziala");
                    }

                    if ($polaczenie->query("SELECT url FROM rss "))
                    {

                       // echo("zakonczono sukcesem wyciaganie url");
                        $result = $polaczenie->query("SELECT url FROM rss ");
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "id: " . $row["id"]. " - Name: " . $row["url"]."<br>";
                            }
                        }
					}else
					{
						echo("spierdalaj, nie dziala");
					}
            }
    }

    $polaczenie->close();
?>