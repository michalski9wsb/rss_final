if($_GET['tensam'])
                                {
                                    $zaznaczony = $_GET['tensam'];
                                    foreach($_REQUEST['tensam'] as $val)
                                        $delIds = intval($val);

                                    $delSql = implode($delIds," ,");

                                    mysql_query("DELETE FROM rss WHERE PID IN ($delSql)");
                                }



$od  = "From: uzytkownik@kursphp.com \r\n";
$od .= 'MIME-Version: 1.0'."\r\n";
$od .= 'Content-type: text/html; charset=iso-8859-2'."\r\n";
$adres = "przyklad@uzycia.pl";
$tytul = "Tytuł wiadomości";
$wiadomosc = "<html>
<head>
</head>
<body>
   <b>Witam serdecznie!</b><br/>
   Zapraszam na stronę: <a href="http://kursphp.com">Kurs PHP</a>   
</body>
</html>";

// użycie funkcji mail
mail($adres, $tytul, $wiadomosc, $od);