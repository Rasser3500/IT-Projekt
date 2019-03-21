<html>
<?php
include"Connect.php";
$UserID = $_GET["UserID"];
?>
<form action="addProduct.php">
    Name:<br>
    <input type="text" name="Name" value="">
    <br>
    Value:<br>
    <input type="text" name="Value" value="">
    <br>
    <br><br>
    <button type="submit" name="UserID" value="<?php echo $UserID; ?>">Create Product</button>
</form>
</html>
