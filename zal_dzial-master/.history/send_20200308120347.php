if($_GET['tensam'])
                                {
                                    $zaznaczony = $_GET['tensam'];
                                    foreach($_REQUEST['tensam'] as $val)
                                        $delIds = intval($val);

                                    $delSql = implode($delIds," ,");

                                    mysql_query("DELETE FROM rss WHERE PID IN ($delSql)");
                                }