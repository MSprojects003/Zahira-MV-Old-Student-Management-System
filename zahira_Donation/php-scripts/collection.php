<?php 



include '../dbms/connection.php';

if(isset($_POST['add'])){
    $uid=$_POST['aid'];
    $mid=$_POST['mid'];
    $amount=$_POST['camount'];
    $collection=$_POST['cname'];
    $date=date('Y-m-d');
    $total=0;
    $cdesc=$_POST['cdesc'];

    $add="INSERT INTO collection(Collection_Name,C_Amount,C_date,AID,MID,c_desc)values('$collection','$amount','$date','$uid','$mid','$cdesc')";
    $run=mysqli_query($conn,$add);
    if($run){

        $view="SELECT * FROM collection";
        $run1=mysqli_query($conn,$view);
        if(mysqli_num_rows($run1)){
            while($show=mysqli_fetch_array($run1)){
                $total += $show['C_Amount'];

            }
        }

        $update="UPDATE  totalamount set TotalValue='$total' where T_ID=1";
        $run2=mysqli_query($conn,$update);
        if($run2){

     
        ?>
        <script>
            alert("The Collection Added Successfully");
            window.location.href=document.referrer;
        </script>
        <?php
    }   }

}





?>