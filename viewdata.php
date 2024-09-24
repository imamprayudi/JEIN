<?php
// session_start();
include('../koneksi.php');

$tglawal = $_GET['rstart'];
$tglakhir = $_GET['rend'];
$part = $_GET['partno'];
$reel = $_GET['reelno'];

$sql = "select ROW_NUMBER() OVER(ORDER BY PART_NO) AS nomor,
  part_no,qty,reel_no,tran_user,place,
  case when rsnd_user='TEMP' then 'ON PROGRESS' else 'DONE' end as rsnd_user
  from stockiodata where (part_no like :partlike)
  and ( reel_no like :reellike )
  and ( rsnd_date between :awallike and :akhirlike )"; 
    
$partlike = "%".$part."%";
$reellike = "%".$reel."%";
$st = $db->prepare($sql);
$st->bindParam(':awallike', $tglawal, PDO::PARAM_STR);
$st->bindParam(':akhirlike', $tglakhir, PDO::PARAM_STR);
$st->bindParam(':partlike', $partlike, PDO::PARAM_STR);
$st->bindParam(':reellike', $reellike, PDO::PARAM_STR);
$st->execute();
$result = $st->fetchAll(PDO::FETCH_ASSOC);
$data = json_encode($result);
echo $data;
