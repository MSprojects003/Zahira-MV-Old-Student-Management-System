<?php
session_start();






    include '../dbms/connection.php';





    if(isset($_POST['login'])){

 

        $uname=$_POST['uname'];
        $paswd=$_POST['paswd'];
        $result=false;

    
    $sql="SELECT * FROM users";
    $run=mysqli_query($conn,$sql);
    if(mysqli_num_rows($run)){
        while($show=mysqli_fetch_array($run)){
             if($uname==$show['U_name'] && $paswd==$show['U_paswd']){
                $result=true;
                $_SESSION['loggedin']=true;
                $_SESSION['UID']=$show['U_ID'];
             }
        }
    }
        if($result==true){
            ?>
<script>
     
    
    window.location.href=document.referrer;
  
</script>

<?php 
        }else{
            ?>
            <script>
    window.location.href=document.referrer;
    localStorage.setItem('loginStatus', 'error');
               
            </script>
            
            <?php 

        }

    }





     if(isset($_POST['check'])){
        $checkInput=$_POST['phone'];

        $sql="SELECT * FROM users where U_phone='$checkInput'";
        $run=mysqli_query($conn,$sql);
        if(mysqli_num_rows($run)){
            while($show=mysqli_fetch_array($run)){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form with Tailwind CSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg w-full">
        <h2 class="text-2xl font-bold text-center text-red-600 mb-6">Change Password</h2>

        <form method="post" enctype="multipart/form-data" action="">
            <!-- First Textbox -->
            <div class="mb-4">
                <label for="textbox1" class="block text-gray-700 text-sm font-bold mb-2">User ID</label>
                <input id="textbox1" type="text" placeholder="Enter value" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent" name="UID" value=<?php echo $show['U_ID'];?> readonly required>
            </div>

            <!-- Second Textbox -->
            <div class="mb-4">
                <label for="textbox2" class="block text-gray-700 text-sm font-bold mb-2">User Name</label>
                <input id="textbox2" type="text" placeholder="Enter value" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent" name="uname" value="<?php echo $show['U_name'];?>" required>
            </div>

            <!-- Third Textbox -->
            <div class="mb-4">
                <label for="textbox3" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input id="textbox3" type="text" placeholder="Enter value" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent" name="paswd" value="<?php echo $show['U_paswd'];?>" required>
            </div>

            <!-- Fourth Textbox -->
          

            <!-- Buttons -->
            <div class="flex items-center justify-between">
                <!-- Submit Button -->
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2" name="edit">
                    Submit
                </button>
                
                <!-- Cancel Button -->
                <a href="../index.php" type="button" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</body>
</html>
<?php
            }
        }else{
            ?>

<script>
     window.location.href=document.referrer;
     
</script>

<?php
        }
     }
    

     if (isset($_POST['edit'])) {
        $UID = $_POST['UID'];
        $uname = $_POST['uname'];
        $paswd = $_POST['paswd'];
    
        // Run the SQL query
        $sql = "UPDATE users SET U_name='$uname', U_paswd='$paswd' WHERE U_ID='$UID'";
        $run = mysqli_query($conn, $sql);
    
        if ($run) {
            // Check if any rows were actually updated
            if (mysqli_affected_rows($conn) > 0) {
                // Success: Rows were updated
                ?>
                <script>
                    window.location.href="../index.php";
                    alert("User Credential Successfully Changed");
                </script>
                <?php
            } else {
                // No rows affected (either no match or no change in data)
                ?>
                <script>
                    window.location.href="../index.php";
                    alert("No changes made. Either no matching user found or data is the same.");
                </script>
                <?php
            }
        } else {
            // SQL query failed
            ?>
            <script>
                window.location.href="../index.php";
                alert("Failed to Change. Error: <?php echo mysqli_error($conn); ?>");
            </script>
            <?php
        }
    }
    

?>




