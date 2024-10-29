<?php

include '../dbms/connection.php';



if (isset($_POST['submit'])) {
    // Get form data
    $name =$_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $nic = $_POST['NIC'];
    $batch = $_POST['batch'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    
    // SQL query to insert data
    $sql = "INSERT INTO members (M_name, M_email, M_phone, M_address, M_NIC, M_Batch, Gender,Membership_ID) VALUES ('$name', '$email', '$phone', '$address', '$nic', '$batch', '$gender','1')";

    if (mysqli_query($conn,$sql)) {
         
        $mid=mysqli_insert_id($conn);
        $membershipID="ZdM_000".$mid;

        $updateID=" UPDATE members SET Membership_ID='$membershipID' where M_ID='$mid'";
        if($done=mysqli_query($conn,$updateID)){

        
        ?>

<script>
          alert("A New Member Added Succesfully");
          window.location.href=document.referrer;
        </script>

        <?php
    } else {
        ?>
        <script>alert(<?php echo "Error: " . $sql . "<br>" . $conn->error?>);</script>
        <?php
    }
}

    // Close connection
    $conn->close();
}


if (isset($_POST['edit'])) {
    // Get form data from the edit form
    $ename = $_POST['ename'];
    $eid = $_POST['eid'];  // Assuming you are passing the member ID as eid
    $ephone = $_POST['ephone'];
    $eEmail = $_POST['e_email'];
    $enic = $_POST['enic'];
    $ebatch = $_POST['ebatch'];
    $egender = $_POST['egender'];
    $eaddress = $_POST['eaddress'];

    // SQL query to update data
    $update = "UPDATE members SET 
                M_name = '$ename', 
                M_email = '$eEmail', 
                M_phone = '$ephone', 
                M_address = '$eaddress', 
                M_NIC = '$enic', 
                M_Batch = '$ebatch', 
                Gender = '$egender' 
                WHERE M_ID = '$eid'";

    if (mysqli_query($conn, query: $update)) {
        ?>
        <script>
            alert("Member details updated successfully");
            window.location.href = document.referrer;
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Error: <?php echo addslashes("Error: " . $update . "<br>" . $conn->error); ?>");
        </script>
        <?php
    }

    // Close connection
    $conn->close();
}
?>