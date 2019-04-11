<html>
<?php
//inkludere databasens funktioner og får connection
include"database.php";
$conn=getConnection();
//Skriver den givende gruppe type 
echo "Name your ".$_POST["Var"];
//laver en action med et tekstfælt og en knap som sender det indskrevne navn samt den givende gruppe type vidre til addGroup siden  
?>
<form action="addGroup.php" method="post">
    <br>
    <input type="text" name="Name">
    <br>
    <button type="submit" name="Var" value="<?php echo $_POST["Var"]; ?>">Next</button>
</form>
<br>
<!--laver en knap som føre til den givende gruppes side-->
<a href="<?php echo "view".$_POST["Var"]."s.php" ?>"><button>Back</button></a>
</html>
