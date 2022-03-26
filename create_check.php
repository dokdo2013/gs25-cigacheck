<?
    include './dbinfo.php';

    $new = $_GET["new"];

    // check_list
    $q1 = "INSERT INTO check_list(check_date, is_finish, del_stat) VALUES('$new',0,0)";
    mysqli_query($conn, $q1);
    // get ciga_list
    $arr = array();
    $q2 = "SELECT num FROM ciga_list WHERE del_stat = 0";
    $r2 = mysqli_query($conn, $q2);
    while($rows2 = mysqli_fetch_array($r2)){
        array_push($arr, $rows2[0]);
    }

    // input checking default values
    for($i=0;$i<count($arr);$i++){
        $tmp = $arr[$i];
        $q = "INSERT INTO checking(check_date, ciga_num, check_num, cigas, borus) VALUES('$new', $tmp, 0, 0, 0)";
        mysqli_query($conn, $q);
    }
?>