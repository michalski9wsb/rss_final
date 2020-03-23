<?php
    session_start();
    require_once "connect.php";
	//$_SESSION['Semail']=$email;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <title>Send RSS</title>
    <meta name="deskription" content="Apk for RSS"/>
    <meta name="keywords" content="RSS,aplication, send"/>
    <meta http-equiv="X-UA-Compatioble" content="IE=edge,chrome=1"/>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Trade+Winds&display=swap" rel="stylesheet">
</head>
<body>
<form method="get" action="">
    <h1>Send RSS to anyone</h1>

    <form name="forma" action="" method="get">

        <div class="url-flex row">

            <input id="url" name="url" type="url" placeholder="url"/>

        </div>
		
		
        <div id="helper">

            <input id="email" name="email" type="email" placeholder="email" value="
			<?php if(isset($_GET['email']))
			{
				echo $_GET['email'];
			}?>
			" 
			<?php  if(isset($_GET['email'])){echo "readonly"; }?>/>

        </div>

        <div class="email-flex row">

            <div id="debug">
                <label for="debug">
                <?php

                if (isset($_GET['send'])) {

                    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

                    $email = $_GET['email'];

                    $_SESSION['tmpEmail'] = $email;

                    $url = $_GET['url'];

                        if ($res = $polaczenie->query("SELECT email from emails WHERE email='$email'")) {

                            if ($res->num_rows == 0) {
                                echo("Email not found in database.<br>");
                        }   
                        else {
                            if ($idRes = $polaczenie->query("SELECT ID FROM emails WHERE email='$email'")) {

                                $idd = $idRes->fetch_assoc();
                                $id = $idd['ID'];


                                if ($result = $polaczenie->query("SELECT rss_address FROM rss_data WHERE email_id = '$id'")) {
                                    if ($result->num_rows > 0) {

                                    $entries = array();
                                    while ($row = $result->fetch_assoc()) {

                                    
                                    $content = file_get_contents($row['rss_address']);
                                    //$xml = simplexml_load_file($feed);			
			                        $xml = simplexml_load_string($content);
                                    $entries = array_merge($entries, $xml->xpath("//item"));
        
                                    usort($entries, function ($feed1, $feed2) {
                                        return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
                                        });
                                    }
                                }
                            }
                        }
                }
    }

}
?>
<ul><?php
        //Print all the entries
        foreach($entries as $entry){
            ?>
            <li><a href="<?= $entry->link ?>"><?= $entry->title ?></a> (<?= parse_url($entry->link)['host'] ?>)
            <p><?= strftime('%m/%d/%Y %I:%M %p', strtotime($entry->pubDate)) ?></p>
            <p><?= $entry->description ?></p></li>
            <?php
        }
?>
        </ul></label>
                <div name="debug" rows="10">
                </div>

            </div>
            
            <button id="delete" name="deleteRSS">Usuń</button>

            <div class="sendlist">

<?php
                

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);


                if (isset($_GET['save'])) {

                    $email = $_GET['email'];
                    $url = $_GET['url'];
                    //$_SESSION['Semail']=$email;

					


                    if ($polaczenie->connect_errno != 0) {
                        echo("Error: Issue with connection.<br>");
                    } else {

                        if ($res = $polaczenie->query("SELECT email from emails WHERE email='$email'")) {
                            if ($res->num_rows == 0) {
                                echo("Email not found in database.<br>");


                                if ($polaczenie->query("INSERT INTO emails VALUES ('','$email')")) {
                                    echo("Added email to database.<br>");

                                    if ($idRes = $polaczenie->query("SELECT ID FROM emails WHERE email='$email'")) {

                                        $idd = $idRes->fetch_assoc();
                                        $id = $idd['ID'];

                                        if ($polaczenie->query("INSERT INTO rss_data VALUES('$url','$id')")) {
                                            echo("Url assigned to email address.<br>");
                                        }
                                    }
                                }
                            } else {

                                echo("Email found in database.<br>");
                                if ($idRes = $polaczenie->query("SELECT ID FROM emails WHERE email='$email'")) {

                                    $idd = $idRes->fetch_assoc();
                                    $id = $idd['ID'];

                                    if ($polaczenie->query("INSERT INTO rss_data VALUES('$url','$id')")) {

                                        echo("Url assigned to email address.<br>");
                                    }
                                }
                            }
                        }
						
                    }
                }


                if (isset($_GET['readSub'])) {

                    $email = $_GET['email'];

                    $_SESSION['tmpEmail'] = $email;

                    $url = $_GET['url'];

                    if ($res = $polaczenie->query("SELECT email from emails WHERE email='$email'")) {

                        if ($res->num_rows == 0) {
                            echo("Email not found in database.<br>");
                        } else {
                            if ($idRes = $polaczenie->query("SELECT ID FROM emails WHERE email='$email'")) {

                                $idd = $idRes->fetch_assoc();
                                $id = $idd['ID'];


                                if ($result = $polaczenie->query("SELECT rss_address FROM rss_data WHERE email_id = '$id'")) {
                                    if ($result->num_rows > 0) {

                                        while ($row = $result->fetch_assoc()) {

                                            echo '
                                            <input type="checkbox" name="rss_cb[]" value="' . $row['rss_address'] . '"/>
                                            ' . $row["rss_address"] . '<br>
                                            ';
                                        }
                                    }
                                }
                            }
                        }
                    }

                }
                if (isset($_GET['deleteRSS'])) {


                    if (!empty($_GET['rss_cb'])) {

                        foreach ($_GET['rss_cb'] as $rss_addr) {

                            $tmail = $_SESSION['tmpEmail'];
                            if ($idRes = $polaczenie->query("SELECT ID FROM emails WHERE email='$tmail'")) {

                                $idd = $idRes->fetch_assoc();
                                $id = $idd['ID'];
                            
                                if ($polaczenie->query("DELETE FROM rss_data WHERE rss_address='$rss_addr' AND email_id='$id'")) {

                                    echo("Url deleted<br>");
                                } else {
                                    echo('LIPA.');
                                }
                            }
                        }
                    }
                }

                $polaczenie->close();

                ?>
            </div>

        </div>

        <div class="url-flex row">

            <input id="send" name="send" type="submit" value="Send"/>
            <button id="save" name="save">Save to database</button>
            <button id="readSub" name="readSub">Read User's subscriptions.</button>

        </div>
    </form>

</body>
</html>