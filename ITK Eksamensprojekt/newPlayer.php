<html>
<?php
include"Connect.php";
$UserID = $_GET["UserID"];
?>
<form action="addProduct.php">
    Name:<br>
    <input type="text" name="PlayerName" value="">
    <br>
    EXP:<br>
    <input type="text" name="EXP" value="">
    <br>
    Lvl:<br>
    <input type="text" name="Lvl" value="">
    <br>
    Class:<br>
    <input type="text" name="Lvl" value="">
    <br>
    Race:<br>
    <input type="text" name="Lvl" value="">
    <br>
    <br><br>
    <button type="submit" name="UserID">Create Product</button>
</form>
</html>
