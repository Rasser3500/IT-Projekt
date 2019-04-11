<html>
<?php
//inkludere databasens funktioner og får connection
include"database.php";
$conn=getConnection();
//finder navnet på den givende gruppe hvis det ikke er en legend.
$Name="";
if($_POST["Var"]!="Legend"){$Name=getName($conn,$_POST["ID"],$_POST["Var"]);}
//sender gruppens id samt gruppe type til deletegroup funktionen
if(deleteGroup($conn,$_POST["ID"],$_POST["Var"])){
    //skriver hvis gruppen blev deleted
    echo "The ".$_POST["Var"]." ".$Name." has been deleted";
}
?>
<br>
<!--laver en knap som føre til den givende gruppes side-->
<a href="<?php echo "view".$_POST["Var"]."s.php" ?>"><button>Ok</button></a>
</html>