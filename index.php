<?php
try {

    /**
     * リクエストから得たスーパーグローバル変数をチェックするなどの処理
     */

    $pdo = new PDO(
        'mysql:dbname=calender;host=localhost;charset=utf8',
        'root',
        '12345',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}
?>

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
                        <form action= "index.php" method= "get">
                            <?php
                            $y = isset($_GET["y"])? $_GET["y"] : date("Y");
                            $m = isset($_GET["m"])? $_GET["m"] : date("m");
                            if ($m == 1) {
                                $nextyear = date("Y", mktime(0, 0, 0, $m, 1, $y-1));
                            } else {
                                $nextyear = isset($_GET["y"])? $_GET["y"] : date("Y");
                            }
                            $nextmonth = date("m", mktime(0, 0, 0, $m-1, 1, $y));
                            echo"<a href='index.php?y={$nextyear}&m={$nextmonth}'>";
                            ?>
                                <div class="triangle-left"></div>
                            </a>
                        </form>
                        <?php
                        $y = isset($_GET["y"])? $_GET["y"] : date("Y");
                        $m = isset($_GET["m"])? $_GET["m"] : date("n");
                        $m = sprintf('%01d', $m);
                        echo "<h1>{$y}年  {$m}月</h1>";
                        ?>
                        <form action= "index.php" method= "get">
                            <?php
                            $y = isset($_GET["y"])? $_GET["y"] : date("Y");
                            $m = isset($_GET["m"])? $_GET["m"] : date("m");
                            if ($m == 12) {
                                $nextyear = date("Y", mktime(0, 0, 0, $m, 1, $y+1));
                            } else {
                                $nextyear = isset($_GET["y"])? $_GET["y"] : date("Y");
                            }
                            $nextmonth = date("m", mktime(0, 0, 0, $m+01, 1, $y));
                            echo"<a href='index.php?y={$nextyear}&m={$nextmonth}'>";
                            ?>
                                <div class="triangle-right"></div>
                            </a>
                        </form>
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
                            /**
                             * ここではカレンダーを表記する際に
                             * 月初日から月末日まで計算して出力するためのコードを入れています
                             */
                        $y = isset($_GET["y"])? $_GET["y"] : date("Y");
                        $m = isset($_GET["m"])? $_GET["m"] : date("n");
                        $d = 1;

                        $mm = isset($_GET["m"])? $_GET["m"] : date("m");
                        $dd = "01";
                        $wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
                        for ($i = 1; $i <= $wd1; $i++) {
                            echo "<td> </td>";
                        }
                        while (checkdate($m, $d, $y)) {
                            $stmt = $pdo->query("SELECT * FROM holidays WHERE dating = '{$y}-{$m}-{$d}'");
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            $date = "{$y}-{$mm}-{$dd}";
                            if ("{$result['dating']}" == $date) {
                                echo "<td id='holiday'>{$d}  {$result['name']}</td>";
                            } else {
                                echo "<td>{$d}</td>";
                            }
                            if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
                                echo "</tr>";
                                if (checkdate($m, $d + 1, $y)) {
                                    echo "<tr>";
                                }
                            }
                            $d++;
                            $dd++;
                            $dd = sprintf('%02d', $dd);
                        }
                        $last = date('d', strtotime("{$y}-{$m} last day of this month"));
                        $wdlast = date("w", mktime(0, 0, 0, $m, $last, $y));
                        for ($wdlast; $wdlast < 6; $wdlast++) {
                            echo "<td> </td>";
                        }
                        ?>
                    </table>
                </section>
            </div>
        </article>
    </body>
</html>
