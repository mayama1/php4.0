<?php
include_once 'conn.php';
$sql = "select photoName,photoNum from photo order by photoNum desc";
$result = mysqli_query($conn,$sql);
$a['categories'] = array();
$a['data'] = array();
while ($info = mysqli_fetch_array($result)){
    array_push($a['categories'],$info['photoName']);
    array_push($a['data'],$info['photoNum']);
}
echo json_encode($a);