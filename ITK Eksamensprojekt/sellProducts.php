<html>
<?php
include"Connect.php";

$ProductID = $_GET["ProductID"];
$ChangedAmount = 0-$_GET["ChangedAmount"];
$Amount = $_GET["Amount"];
$UserID = $_GET["UserID"];

$sql = "SELECT Balance FROM ProductDB.UserTable WHERE UserID='$UserID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $Balance = $row["Balance"];
    }
}
$sql = "SELECT Value FROM ProductDB.ProductTable WHERE ProductID='$ProductID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $Value = $row["Value"];
    }
}
$NewBalance = $Balance-$Value*$ChangedAmount;
$NewAmount = $Amount+$ChangedAmount;
if ($NewAmount >= 0) {
$sql = "UPDATE ProductDB.UserTable SET Balance = '$NewBalance' WHERE UserID='$UserID'";
if ($conn->query($sql) === TRUE) {
    echo "Products sold successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$sql = "INSERT INTO ProductDB.PurchaseTable (ProductID,UserID,Amount) Value('$ProductID','$UserID','$ChangedAmount')";

if ($conn->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}} else {
    echo "You don't have that amount of Products";
}

$conn->close();
?>
<form action="viewProducts.php">
  <button type="submit" name="UserID" value="<?php echo $UserID; ?>">Back</button>
</form>
</html>
