<html>
<?php
include"Connect.php";
$UserID = $_GET["UserID"];
$sql = "SELECT Name, Balance FROM ProductDB.UserTable WHERE UserID='$UserID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo " Hello " . $row["Name"]."";
        echo " your balance is " . $row["Balance"]. "$<br><br>";
    }
}
$sql = "SELECT ProductID, Name, Value FROM ProductDB.ProductTable";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo " Name:  " . $row["Name"]."<br>";
        echo " Value:  " . $row["Value"]. "$";
        ?>
        <form action="buyProducts.php">
            <input type="Hidden" name="UserID" value="<?php echo $UserID ?>">
            <?php echo "Amount" ?>
            <input type="text" name="Amount" value="">
            <button type="submit" name="ProductID" value="<?php echo $row["ProductID"]; ?>">Buy Products</button>
        </form><?php
    }
} else {
    echo "There are no Products"."<br>";
}
?>
<form action="newProduct.php">
   <button type="submit" name="UserID" value="<?php echo $UserID; ?>">Create New Product</button>
</form>
<form action="viewProducts.php">
   <button type="submit" name="UserID" value="<?php echo $UserID; ?>">Back</button>
</form>
</html>
