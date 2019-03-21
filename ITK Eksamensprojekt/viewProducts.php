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
$sql = "SELECT COUNT(ProductID) FROM ProductDB.ProductTable";
$result = $conn->query($sql);
$MaxID = $result->fetch_assoc();
$ProdID = [];
for($i=1; $i<$MaxID["COUNT(ProductID)"]+1; $i++) {
    $y=0;
    $sql = "SELECT Amount FROM ProductDB.PurchaseTable WHERE UserID = '$UserID' AND ProductID = '$i'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
            $y= $y+$row["Amount"];
        }
    }
    $ProdID[$i][0]=$y;
}
for($i=1; $i<sizeof($ProdID)+1; $i++){
    $sql = "SELECT Name, Value FROM ProductDB.ProductTable WHERE ProductID = '$i'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
      $ProdID[$i][1]=$row["Name"];
      $ProdID[$i][2]=$row["Value"];
      }
    }
}
for($i=1; $i<sizeof($ProdID)+1; $i++) {
    if($ProdID[$i][0] > 0){
        echo " Name:  ".$ProdID[$i][1]."<br>";
        echo " Amount:  " . $ProdID[$i][0]. "<br>";
        echo " Total Value:  " .$ProdID[$i][2]*$ProdID[$i][0]. "$<br>";
        ?>
        <form action="sellProducts.php">
            <?php echo "Amount to sell"; ?>
            <input type="text" name="ChangedAmount" value="">
            <input type="hidden" name="Amount" value="<?php echo $ProdID[$i][0]; ?>">
            <input type="hidden" name="UserID" value="<?php echo $UserID; ?>">
            <button type="submit" name="ProductID"  value="<?php echo $i; ?>">Sell Product</button>
        </form><?php
}
}
?>
<form action="buySell.php">
  <button type="submit" name="UserID" value="<?php echo $UserID; ?>">Buy Products</button>
</form>
<form action="homePage.php">
  <button type="submit" name="UserID" value="<?php echo $UserID; ?>">Back</button>
</form>
</html>
