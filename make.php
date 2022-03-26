<?
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    // GS SOSA CIGA CHECK Project (GSCC)
    include './phpqrcode.php';
    $conn = mysqli_connect('localhost', 'dokdo2013', 'hwoo7141', 'sosags');
    $query = "SELECT * FROM ciga_list WHERE del_stat = 0";
    $result = mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_assoc($result)){
        $ciga_code = $row["ciga_code"];
        $num = $row["num"];
        QRcode::png($ciga_code,$_SERVER['DOCUMENT_ROOT']."/result/$num.png",0,3,2);
        echo "$num done<br>";
    }
?>