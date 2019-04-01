<html>
<?php
include"database.php";
$conn=getConnection();
$Name=getName($conn,$_POST["ID"],"Party");
if(deleteGroup($conn,$_POST["ID"],$_POST["Var"])){
    echo "The ".$_POST["Var"]." ".$Name." has been deleted";
}
?>
<br>
<a href="viewParties.php"><button>Ok</button></a>
</html>