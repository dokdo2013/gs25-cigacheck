<?
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include './dbinfo.php';
    $date_q = "SELECT data FROM config WHERE flag='now'";
    $date_r = mysqli_query($conn, $date_q);
    $date_row = mysqli_fetch_array($date_r);
    $dt_tmp = $date_row[0];

    if(!isset($_GET['date'])){
        $date = $dt_tmp;
    }else{
        $date = $_GET['date'];
    }
    $q = "SELECT ciga_num, (SELECT ciga_group FROM ciga_list WHERE num = ciga_num) as ciga_group, (SELECT ciga_name FROM ciga_list WHERE num = ciga_num) as ciga_name, cigas, check_num, borus FROM checking WHERE check_date = '$date'";
    $r = mysqli_query($conn, $q);
    $num = array();
    $ciga_num = array();
    $ciga_group = array();
    $ciga_name = array();
    $cigas = array();
    $check_num = array();
    $borus = array();
    $i = 0;
    while($rows = mysqli_fetch_array($r)){
        $num[$i] = $i+1;
        $ciga_num[$i] = $rows["ciga_num"];
        $ciga_group[$i] = $rows["ciga_group"];
        $ciga_name[$i] = $rows["ciga_name"];
        $cigas[$i] = $rows["cigas"];
        $check_num[$i] = $rows["check_num"];
        $borus[$i] = $rows["borus"];
        $total[$i] = $cigas[$i] + ($borus[$i] * 10);
        $difference[$i] = $total[$i] - $check_num[$i];
        $i++;
    }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gssosa</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <style>
        body{
            max-width: 900px;
            margin: 0 auto;
            padding: 10px;
            font-family: 'Noto Sans KR'
        }
        .top{
            margin: 20px 0 30px 0;
        }
        .print-btn{
            float: right;
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px;
            background-color: lightgrey;
        }
        .print-btn a{
            color: #4169e1;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="top">
        <span class="print-btn"><a href="print.php?date=<?=$date?>" target="_blank"><i class="fas fa-print"></i> 인쇄</a></span>
        <h2 style="text-align: center">GS25 소사원룸점 (<?=$date?>)</h2>
    </div>
    <div class="main">
        <table id="tb" class="table table-striped" style="width: 100%; min-width: 650px">
            <thead>
                <tr>
                    <th>연번</th>
                    <th>분류</th>
                    <th>제품명</th>
                    <th>재고차이</th>
                    <th>진열</th>
                    <th>보루</th>
                    <th>합계</th>
                    <th>전산</th>
                </tr>
            </thead>
            <tbody>
                <? for($i=0;$i<count($num);$i++){ ?>
                    <tr>
                        <td><?=$num[$i]?></td>
                        <td><?=$ciga_group[$i]?></td>
                        <td><?=$ciga_name[$i]?></td>
                        <td><?=$difference[$i]?></td>
                        <td><?=$cigas[$i]?></td>
                        <td><?=$borus[$i]?></td>
                        <td><?=$total[$i]?></td>
                        <td><?=$check_num[$i]?></td>
                    </tr>
                <? } ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function(){
            $("#tb").DataTable({
                "scrollX": true,
                "pageLength": 50,
                "responsive": true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        });
    </script>
</body>
</html>