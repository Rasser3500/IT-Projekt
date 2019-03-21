<html>
<?php
include"Connect.php";

$UserID = $_GET["UserID"];
$ProductID = $_GET["ProductID"];
$Amount = $_GET["Amount"];

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
$NewBalance = $Balance-$Value*$Amount;

if ($NewBalance >= 0) {
  $sql = "INSERT INTO ProductDB.PurchaseTable (UserID, ProductID, Amount) Value('$UserID', '$ProductID', '$Amount')";
  if ($conn->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
  $sql = "UPDATE ProductDB.userTable SET Balance = '$NewBalance' WHERE UserID='$UserID'";
  echo "transaction complete";
}
else {
  echo "Insufficient funds (just get more money LOL :4Head:)";
}
if ($conn->query($sql) === TRUE) {
    echo "";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
<form action="viewProducts.php">
  <button type="submit" name="UserID" value="<?php echo $UserID; ?>">Back</button>
</form>
</html>
