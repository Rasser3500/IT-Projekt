<html>
<!-- der bliver refreret til stylesheetet-->
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<?php
//reseter session ID'erne ved at sætte den til 0
$_SESSION['PartyID']=0;
$_SESSION['EncounterID']=0;
?>
<!--knapper til de tre hoved sider-->
<a href="viewEncounters.php"><button>View Encounters</button></a>
<a href="viewPartys.php"><button>View Parties</button></a>
<a href="viewLegends.php"><button>View Legends</button></a>
</html>