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
                        require 'ChromePhp.php';
                            /**
                             * ここではカレンダーを表記する際に
                             * 月初日から月末日まで計算して出力するためのコードを入れています
                             */
                        $y = date("Y");
                        $m = date("n");
                        $d = 1;

                        $mm = date("m");
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
                                echo "<td class='holiday'>{$d}  {$result['name']}</td>";
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
