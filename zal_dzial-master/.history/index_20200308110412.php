<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <title>Send RSS</title>
        <meta name="deskription" content="Apk for RSS" />
        <meta name="keywords" content="RSS,aplication, send" />
        <meta http-equiv="X-UA-Compatioble" content="IE=edge,chrome=1" />
        <link href="style.css" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Trade+Winds&display=swap" rel="stylesheet">
    </head>
    <body>
        <form method="get" action="">
            <h1>Send RSS to anyone</h1>
            <div class="url-flex row">
                <input id="url"  name="url" type="url" placeholder="url"/>
            </div>
            <div id="helper"><input id="email"  name="email" type="email" placeholder="email" /></div>
            <div class="email-flex row">

                <div id="debug">
                    <label for="debug">Dynamic rss list</label>
                    <div name="debug"  rows="10">
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
						//echo("zakonczono sukcesem");
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
                                echo $row["url"]."<br>";
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
                    </div>

                </div>
                <button id="delete" name="deletephp">usuń</button>
                <div class="sendlist" >
                    Boguś to ogr
                    Krisu to troll
                    Michaś to Elfi Krul
                </div>

             </div>
             <div style="clear:both;"></div>
            <div class="row">
                <!--<div class="buttonCentre">-->
                    <input id="send" type="submit" value="Send"/>
                    <button id="save" name="save">Save to database</button>
                <!--</div>-->
            </div>
        </form>

    </body>
</html>