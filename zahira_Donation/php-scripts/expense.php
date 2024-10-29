<?php



include '../dbms/connection.php';

if(isset($_POST['submit'])){


    $uid=$_POST['uid'];
    $pname=$_POST['pname'];
    $amount=$_POST['amount'];
    $note= $_POST['notes'];
    $date=date('Y-m-d');

   
    $sql="INSERT INTO expense(program,Amount,Description,date,UID)values('$pname','$amount','$note','$date','$uid')";
    $query=mysqli_query($conn,$sql);
    if($query){
        
        $update="UPDATE totalamount set TotalValue =(TotalValue-'$amount') where T_ID=1";
        $run=mysqli_query($conn,$update);
        if($run){
            ?>
            <script>
                 window.location.href=document.referrer;
                alert("Successful");

            </script>
            <?php
        }else{
            ?>

<script>
     window.location.href=document.referrer;
    alert("<?php echo mysqli_error($conn); ?>");
</script>

<?php
        }
         

    }else{
        ?>

        <script>
             window.location.href=document.referrer;
            alert("<?php echo mysqli_error($conn); ?>");
        </script>
        
        <?php
    }
}





?>