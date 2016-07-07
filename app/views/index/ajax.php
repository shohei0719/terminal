<?php
 
$data = array();
$page = $_POST['page'];
 
$conn = mysql_connect('localhost', 'root', 'root0719');
 
$db = mysql_select_db('terminal_db', $conn);
 
$sql = " SELECT * FROM admins WHERE id = " . $page;
$res = mysql_query($sql, $conn);
 
while ($row = mysql_fetch_array($res)) {
    $data[] = $row;
}
 
mysql_close($conn);
 
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
 
?>