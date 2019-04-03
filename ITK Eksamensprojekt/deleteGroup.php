<html>
<?php
include"database.php";
$conn=getConnection();
$Name=getName($conn,$_POST["ID"],$_POST["Var"]);
if(deleteGroup($conn,$_POST["ID"],$_POST["Var"])){
    echo "The ".$_POST["Var"]." ".$Name." has been deleted";
}
?>
<br>
<a href="<?php echo "view".$_POST["Var"]."s.php" ?>"><button>Ok</button></a>
</html>