<html>
<?php
include"Connect.php";
?>
<form action="addEncounter.php">
    Name:<br>
    <input type="text" name="Name" value="">
    <br>
    Challenge Rateing:<br>
    <input type="text" name="exp" value="">
    <br>
    Party Size and Lvl:<br>
    <input type="text" name="Size" value="">
    <input type="text" name="Lvl" value="">
    <br>
    <input type="submit" value="Send">
</form>
<a href="homePage.php"><button>Back</button></a>
</html>
