<?
    include './dbinfo.php';
    
    // POST Data
    $cnt1 = $_POST["cnt1"]; // cigas
    $cnt2 = $_POST["cnt2"]; // check_num
    $cnt3 = $_POST["cnt3"]; // borus
    $target_id = $_POST["target_id"]; // ciga_num
    $check_date = $_POST["check_date"];
    $now_num = $_POST["now_num"];
    $next_num = $now_num + 1;
    $next_direct = $_POST["next_direct"];

    // DB Update
    $query = "UPDATE checking SET cigas = $cnt1, check_num = $cnt2, borus = $cnt3 WHERE ciga_num = $target_id and check_date = '$check_date'";
    mysqli_query($conn, $query);

    // redirect
    if($next_direct == 1){
        echo "<script>location.href='index.php?num=$next_num'</script>";
    }else{
        echo "<script>location.href='index.php?num=$now_num'</script>";
    }
?>