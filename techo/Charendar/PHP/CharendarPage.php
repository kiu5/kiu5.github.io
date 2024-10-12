<?php

  function Weeks(){
    $weekday=['日','月','火','水','木','金','土'];
    $week='';
    for($i=0 ; $i<7 ; $i++){
      $week.='<td>'.$weekday[$i].'</td>';
    }
    echo '<tr>'.$week.'</tr>';
  }

  date_default_timezone_set('Asia/Tokyo');
  
    if (isset($_GET['ym'])) {
        $ym = $_GET['ym'];
    } else {
        $ym = date('Y-m');
    }
  
    $timestamp = strtotime($ym . '-01');
    if ($timestamp === false) {
        $ym = date('Y-m');
        $timestamp = strtotime($ym . '-01');
    }
  
    $today = date('Y-m-j');
  
    $html_title = date('Y年n月', $timestamp);
  
    $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));

  
    $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

  


  function Charendar($res){
    global $ym;
    global $today;
    global $html_title;
    // 方法２：strtotimeを使う
    // $prev = date('Y-m', strtotime('-1 month', $timestamp));
    // $next = date('Y-m', strtotime('+1 month', $timestamp));
    
    // 該当月の日数を取得
    //$day_count=31
    $day_count = date('t', $res);
    
    // １日が何曜日か　0:日 1:月 2:火 ... 6:土
    // 方法１：mktimeを使う
    // $youbi=2 　火曜日
    $youbi = date('w', mktime(0, 0, 0, date('m', $res), 1, date('Y', $res)));
    // 方法２
    // $youbi = date('w', $timestamp);
    
    
      $weeks = [];
      $week = '';
    
    // 第１週目：空のセルを追加
    // 例）１日が水曜日だった場合、日曜日から火曜日の３つ分の空セルを追加する
    // $youbi=2　のとき
    // $week='<td></td> <td></td>'
    $week .= str_repeat('<td></td>', $youbi);
    
    for ( $day = 1; $day <= $day_count; $day++, $youbi++) {
    
        // 2020-08-(1~31)
        $date = $ym . '-' . $day;
    
        // $week='<td></td><td></td><td>1</td>　<td class=today>11</td>　<td>31</td>'
        if ($today == $date) {
            // 今日の日付の場合は、class="today"をつける
            $week .= '<td class="today">' . $day;
        } else {
            $week .= '<td>' . $day;
        }
        $week .= '</td>';
    
        // 週終わり、または、月終わりの場合
        if ($youbi % 7 == 6 || $day == $day_count) {
    
            if ($day == $day_count) {
                // 月の最終日の場合、空セルを追加
                // 例）最終日が木曜日の場合、金・土曜日の空セルを追加
                $week .= str_repeat('<td></td>', 6 - ($youbi % 7));
            }
    
            // weeks配列にtrと$weekを追加する
            $weeks[] = '<tr>' . $week . '</tr>';
    
            // weekをリセット
            $week = '';
      }
    }
    foreach ($weeks as $week) {
      echo $week;
    }

  }
?>

<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!--------------------------- Bootstrap ----------------------------->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!--------------------------- Google Fonts ----------------------------->
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">

  <style>
    .container {
      font-family: 'Noto Sans', sans-serif;
    }

    h3 {
      margin-bottom: 30px;
    }

    th {
      height: 15vh;
      text-align: center;
    }

    td {
      height: 20vh;
      width: 20vh;
    }

    .today {
      background: orange;
    }

    th:nth-of-type(1),
    td:nth-of-type(1) {
      color: red;
    }

    th:nth-of-type(7),
    td:nth-of-type(7) {
      color: blue;
    }
  </style>

  <title>カレンダー</title>
</head>

<body>



  <div class="container">
  <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> 
  <?php echo $html_title; ?>
  <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
  <table class="table table-bordered">
    <?php Weeks(); ?>
      <?php Charendar($timestamp);  ?>
    </table>
  </div>








  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
    crossorigin="anonymous"></script>
</body>

</html>

