<html>
<!-- der bliver refreret til stylesheetet-->
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<?php
//inkludere databasens funktioner og får connection
include"database.php";
$conn=getConnection();
//sender den givende navn og gruppe type til creategroupfunktion
if(createGroup($conn,$_POST["Name"],$_POST["Var"])){
    //skriver hvis gruppen blev lavet
    echo "The ".$_POST["Var"]." ".$_POST["Name"]." has been created";
}
?>
<br>
<!--laver en knap som føre til den givende gruppes side-->
<a href="<?php echo "view".$_POST["Var"]."s.php" ?>"><button>Ok</button></a>
</html>