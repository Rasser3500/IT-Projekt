<html>
<?php
include"database.php";
$conn=getConnection();
echo "Name your ".$_POST["Var"];
?>
<form action="addGroup.php" method="post">
    <br>
    <input type="text" name="Name">
    <br>
    <button type="submit" name="Var" value="<?php echo $_POST["Var"]; ?>">Next</button>
</form>
<br>
<a href="<?php echo "view".$_POST["Var"]."s.php" ?>"><button>Back</button></a>
</html>
