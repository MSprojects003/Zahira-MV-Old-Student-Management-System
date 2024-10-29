<?php

include '../dbms/connection.php';

if (isset($_POST['edit'])) {
    $old_amount = $_POST['old_amount'];
    $ename = $_POST['ecname'];
    $eamount = $_POST['ecamount'];
    $edesc = $_POST['ecdesc'];
    $member = $_POST['emember'];
    $CID = $_POST['eid'];

    // Update the collection record
    $sql = "UPDATE collection SET Collection_Name='$ename', C_Amount='$eamount', c_desc='$edesc', MID='$member' WHERE C_ID='$CID'";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        // Check if the amount has changed
        if ($old_amount != $eamount) {
            // Determine if new amount is greater or smaller
            if ($eamount > $old_amount) {
                // Calculate difference and increase total amount
                $calValue = $eamount - $old_amount;
                $update = "UPDATE totalamount SET TotalValue = TotalValue + '$calValue' where T_ID=1";
            } else {
                // Calculate difference and decrease total amount
                $calValue = $old_amount - $eamount;
                $update = "UPDATE totalamount SET TotalValue = TotalValue - '$calValue' where T_ID=1";
            }
            
            // Execute the update query
            $updateRun = mysqli_query($conn, $update);

            if ($updateRun) {
                ?>
                <script>
                    alert("succesful");
                    window.location.href=document.referrer;
                </script>
                <?php
            } else {
                ?>
                <script>
                    alert("Failed");
                    window.location.href=document.referrer;
                </script>
                <?php
            }
        }  else{
            ?>
                <script>
                    alert("succesful");
                    window.location.href=document.referrer;
                </script>
                <?php
        }
    } else {
        ?>
                <script>
                    alert("Failed");
                    window.location.href=document.referrer;
                </script>
                <?php
    }
}
?>
