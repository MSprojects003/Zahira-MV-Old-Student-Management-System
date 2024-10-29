<?php


include '../dbms/connection.php';

if(isset($_POST['edit'])){
    $eid=$_POST['eid'];
    $ename=$_POST['ename'];
    $amount=$_POST['eamount'];
    $old_amount=$_POST['old_amount'];
    $note=$_POST['note'];

    $sql="UPDATE expense set program='$ename' , Amount='$amount', Description='$note'  where E_ID='$eid' ";
    $run=mysqli_query($conn,$sql);

    if ($run) {
        // Check if the amount has changed
        if ($old_amount != $amount) {
            // Determine if new amount is greater or smaller
            if ($amount > $old_amount) {
                // Calculate difference and increase total amount
                $calValue = $amount - $old_amount;
                $update = "UPDATE totalamount SET TotalValue = TotalValue - '$calValue' where T_ID=1";
            } else {
                // Calculate difference and decrease total amount
                $calValue = $old_amount - $amount;
                $update = "UPDATE totalamount SET TotalValue = TotalValue + '$calValue' where T_ID=1";
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