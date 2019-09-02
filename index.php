<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>[WIP]へなちょこCalendar</title>
        <link rel="stylesheet" href="/css/reset.css">
        <link rel="stylesheet" href="/css/index.css">
    </head>
    <body>
        <article>
            <div class="main">
                <section class="main__top">
                    <div class= "top-bar">
                        <div class="triangle-left"></div>
                        <?php
                        $m = date("n");
                        echo "<h1>{$m}月</h1>"
                        ?>
                        <div class="triangle-right"></div>
                    </div>
                </section>
                <section class="main__bottom">
                    <table class="calender" border="1">
                        <tr class="calender__days-of-the-week">
                            <th class="sunday">日</th>
                            <th>月</th>
                            <th>火</th>
                            <th>水</th>
                            <th>木</th>
                            <th>金</th>
                            <th class="saturday">土</th>
                        </tr>
                        <?php
                        $y = date("Y");
                        $m = date("n");
                        $d = 1;

                        $wd1 = date("w", mktime(0,0,0,$m,1,$y));
                        for ($i = 1; $i <= $wd1; $i++){
                            echo "<td> </td>";
                        }
                        while(checkdate($m, $d, $y)){
                            echo "<td>$d</td>";
                            if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
                                echo "</tr>";
                                if (checkdate($m, $d + 1, $y)) {
                                    echo "<tr>";
                                }
                            }
                           $d++;
                        }
                        ?>
                    </table>
                </section>
            </div>
        </article>
    </body>
</html>
