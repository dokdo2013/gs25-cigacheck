<?
    // GS SOSA CIGA CHECK Project (GSCC)
    include './dbinfo.php';
    $result = mysqli_query($conn, $query);
    if(isset($_GET["num"])){
        $num = $_GET["num"];
    }else{
        $num = 0;
    }
    $query1 = "SELECT * FROM ciga_list WHERE del_stat = 0 ORDER BY ciga_location LIMIT 2 OFFSET $num";
    $before = $num - 1;
    $after = $num + 1;
    $query2 = "SELECT count(*) as cnt FROM ciga_list WHERE DEL_STAT = 0";
    $result1 = mysqli_query($conn, $query1);
    $result2 = mysqli_query($conn, $query2);
    
    $row2 = mysqli_fetch_assoc($result2);
    $total = $row2["cnt"];
    $first_val = 1;
    $last_val = $total;

    $row1 = mysqli_fetch_assoc($result1);
    $ciga_num = $row1["num"];
    $ciga_group = $row1["ciga_group"];
    $ciga_name = $row1["ciga_name"];
    $ciga_location = $row1["ciga_location"];
    $ciga_barcode = $row1["ciga_code"];

    // config 'now'
    $query3 = "SELECT * FROM config WHERE flag = 'now'";
    $result3 = mysqli_query($conn, $query3);
    $row3 = mysqli_fetch_array($result3);
    $now = $config["now"] = $row3[1];

    // get checking
    $query4 = "SELECT cigas as cnt1, check_num as cnt2, borus as cnt3 FROM checking WHERE ciga_num = $ciga_num and check_date = '$now'";
    $result4 = mysqli_query($conn, $query4);
    $row4 = mysqli_fetch_array($result4);
    $cnt1 = $row4[0];
    $cnt2 = $row4[1];
    $cnt3 = $row4[2];

?>

<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>재고조사도우미 - GS25 소사원룸점 (<?=$config["now"]?>)</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.3/dist/JsBarcode.all.min.js"></script>
    <style>
        a{
            text-decoration: none;
            color: white;
        }
        body{
            font-family: 'Noto Sans KR';
        }
        #tb thead tr th, #tb tbody tr td{
            border: 1px solid black;
        }
        #tb{
            width: 100%;
        }
        #img{
            width: 100%;
            max-width: 240px;
        }
        #btn1{
            float: left;
            width: 100px;
            height: 100%;
            font-size: 20px;
            font-weight: bold;
            background-color: #FD6A02;
            color: white;
            border: 0;
        }
        #btn2{
            float: right;
            width: 100px;
            height: 100%;
            font-size: 20px;
            font-weight: bold;
            background-color: #FD6A02;
            color: white;
            border: 0;
        }
        #btn-save{
            float: left;
            width: 100px;
            height: 100%;
            font-size: 20px;
            font-weight: bold;
            margin-left: calc((100vw - 300px)/2);
            background-color: #FD6A02;
            color: white;
            border: 0;
        }
        @media screen and (min-width: 500px){
            #btn-save{
                margin-left: 100px;
            }
            .bottom{
                width: 500px !important;
            }
        }
        .top{
            margin: 0;
            background-color: #FD6A02;
            color: white;
            padding: 10px;
            height: 60px;
        }
        .top .title{
            font-weight: bold;
            font-size: 16px;
        }
        .main{
            margin-bottom: 100px;
        }
        .bottom{
            position:absolute;
            bottom:0;
            width: 100%;
            height:50px;
            background-color: #FD6A02;
        }
        .tal{ text-align: left; float: left; }
        .tar{ text-align: right; float: right; }
        .cnt{
            width: 80%;
            height: 35px;
            margin-bottom: 10px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            border: 2px solid black;
        }
        .img-inside{
            display: inline-block;
            width: 65%;
            float: left;
        }
        .img-right{
            display: inline-block;
            width: 30%;
            float: right;
            margin-top: 15px;
        }
    </style>
</head>
<body style="max-width: 500px; margin: 0 auto">
    <div class="dv top">
        <div>
            <span class="title tal" style="margin-bottom: 10px; float: none; display: block"><a href="?num=0">SOSAGS - <?=$config["now"]?></a></span>
        </div>
        <div>
            <span class="title tal">[<?=$ciga_group?>] <?=$ciga_name?></span>
            <span class="title tar"><?=$num+1?> / <?=$total?></span>
        </div>
    </div>
    <div class="dv main">
        <div class="img-inside">
            <img id="img" src="result/<?=$ciga_num?>.png" alt="" style="display: none">
            <svg id="barcode"></svg>
        </div>
        <div class="img-right">
            <form action="form.php" id="frm" method="post">
                <label for="cnt1">현재 재고</label><br>
                <input type="number" class="cnt" name="cnt1" id="cnt1" value="<?=$cnt1?>"><br>
                <label for="cnt2">전산상 재고</label><br>
                <input type="number" class="cnt" name="cnt2" id="cnt2" value="<?=$cnt2?>"><br>
                <label for="cnt3">보루수</label><br>
                <input type="number" class="cnt" name="cnt3" id="cnt3" value="<?=$cnt3?>"><br>
                <input type="hidden" name="target_id" value="<?=$ciga_num?>">
                <input type="hidden" name="now_num" value="<?=$num?>">
                <input type="hidden" name="check_date" value="<?=$config["now"]?>">
                <input type="hidden" name="next_direct" value="1">
            </form>
        </div>
    </div>
    <div class="dv bottom">
        <button id="btn1">이전</button>
        <button id="btn-save">저장</button>
        <button id="btn2">다음</button>
    </div>
    <script>
        $(document).ready(function(){
            var code = <?=$ciga_barcode?>;

            // viewPreset : QR, 바코드 선택 (QR:1, 바코드:2)
            var viewPreset = 2;
            if(viewPreset == 1){
                $("#img").show();
            }else if(viewPreset == 2){
                JsBarcode("#barcode", code);
                $("#barcode").css("width","100%");
            }

            var nowval = <?=$num+1?>;
            $(".cnt").click(function(){
                $(this).val('');
            });
            $(".cnt").focus(function(){
                $(this).val('');
            });
            $("#btn1").click(function(){
                var firstval = <?=$first_val?>;
                if(nowval <= firstval){
                    alert('처음입니다');
                }else{
                    location.href='?num=<?=$before?>';
                }
            });
            $("#btn2").click(function(){
                var lastval = <?=$last_val?>;
                if(nowval >= lastval){
                    alert('마지막입니다');
                }else{
                    location.href='?num=<?=$after?>';
                }
            });
            $("#btn-save").click(function(){
                $("#frm").submit();
            });
        });
    </script>
</body>
</html>