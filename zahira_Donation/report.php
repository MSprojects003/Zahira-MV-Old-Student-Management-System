<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zahira Maha Vidyalaya Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
<?php

if (isset($_POST['logout'])) {
    
    session_unset();

     
    session_destroy();

    
    header("Location: index.php");
    exit();
}


?>

<?php
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] ) {
   
    
?>

    <div class="logintab"></div>
<?php

} else {
    include 'dbms/connection.php';
    $UID=$_SESSION['UID'];
     
//  dahsbaord query

function formatNumber($value) {
    if ($value >= 1000000) {
        return round($value / 1000000, 1) . 'M'; // For millions
    } elseif ($value >= 1000) {
        return round($value / 1000, 1) . 'k';    // For thousands
    } else {
        return $value; // Return the value as is if it's less than 1000
    }
}

$allcollection = 0;
$allExpenses=0;
$available=0;
$collectionForMonth=0;
 

// Query for the 'Collection' table
$dquery2 = "SELECT * FROM collection";
$queryd2 = mysqli_query($conn, $dquery2);


if (mysqli_num_rows($queryd2)) {
    while ($show2 = mysqli_fetch_array($queryd2)) {
        $allcollection += $show2['C_Amount']; // Adding up all collection amounts
    }
}


 
    
// query4

$dquery4 = "SELECT * FROM expense";
$runquery1=mysqli_query($conn,$dquery4);
if(mysqli_num_rows($runquery1)){
    while($row1=mysqli_fetch_array($runquery1)){
        $allExpenses += $row1['Amount'];
    }
}
    





?>

    <div class="dashboard">
        <div class="nav"></div>
        <div class="flexbox">
            <div class="body bg-gray-100 p-8">
                 
                <div class="flex justify-start space-x-36">
                    <!-- Paid Amount Card -->
                     <form action="" method="post" enctype="multipart/form-data"> 
                    <div class="bg-white rounded shadow p-4">
    <div class="font-bold text-gray-700">Total Collections</div>
    <p class="text-2xl font-semibold text-blue-600 font-bold">Rs. <?php echo formatNumber($allcollection); ?></p> <!-- Adjusted styling -->
    <p class="text-sm text-gray-500">Till Now</p>
</div>
 
 
            <label for="date-picker" class="block text-sm font-semibold text-gray-700 mb-2">Select a Date:</label>
            <input type="date" id="date-picker" name="selected_date" class="w-full px-4 py-2 border-2 border-blue-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-600 transition duration-200 ease-in-out" onchange="this.form.submit()">
        
</form>



                    <!-- Overdue Amount Card -->
                    <form action="" method="post" enctype="multipart/form-data"> 
                    <div class="bg-white rounded shadow p-4 ">
                        <div class="font-bold text-gray-700">Total Expenses</div>
                        <p class="text-2xl font-semibold text-blue-600 font-bold">Rs.<?php echo formatNumber($allExpenses);?></p>
                        <p class="text-sm text-gray-500">Full Total</p>
                    </div>
                    
                   
            <label for="date-picker" class="block text-sm font-semibold text-gray-700 mb-2">Select a Date:</label>
            <input type="date" id="date-picker" name="selected_expense_date" class="w-full px-4 py-2 border-2 border-blue-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-600 transition duration-200 ease-in-out" onchange="this.form.submit()">
        
                    </form>

                    <!-- Other Cards -->
                     <?php if(isset($_POST['selected_date'])){
                         $selectedDate = $_POST['selected_date'];
                       ?>
                          <form action="final_report.php" method="POST">
                        <input type="hidden" name="rdate" value="<?php echo $selectedDate;?>">
                        <input type="hidden" name="type" id="" value="collection">
                        <button type="submit" name="genrate" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-purple-600 hover:to-blue-500 text-white py-2 px-6 rounded-md shadow-lg flex items-center space-x-2 transition ease-in-out duration-300 transform hover:scale-105">
    <!-- New Icon from Heroicons (Download Icon) -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 12l-3-3m6 0l-3 3m-9 3h18" />
    </svg>
    <span class="text-sm font-semibold tracking-wide uppercase">Generate Report</span>
</button>
    </form>
    <?php
                     }else if(isset($_POST['selected_expense_date'])){
                        $selectedExpenseDate = $_POST['selected_expense_date'];
                        ?>
                           <form action="final_report.php" method="POST">
                         <input type="hidden"  name="rdate" value="<?php echo $selectedExpenseDate;?>">
                         <input type="hidden" name="type" id="" value="Expense">
                         <button type="submit" name="genrate" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-purple-600 hover:to-blue-500 text-white py-2 px-6 rounded-md shadow-lg flex items-center space-x-2 transition ease-in-out duration-300 transform hover:scale-105">
    <!-- New Icon from Heroicons (Download Icon) -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 12l-3-3m6 0l-3 3m-9 3h18" />
    </svg>
    <span class="text-sm font-semibold tracking-wide uppercase">Generate Report</span>
</button>

     </form><?php }
                     
                     
                     ?>
                 
     
                    
               
            
            <div class=" rounded-lg w-64">
        
           
        </div>
    </div>
    </div>
            <hr class="border-t-1 border-gray-400 ">
        

           
            <div class="min-w-full bg-white shadow-md rounded-lg">
    <?php 
    if (isset($_POST['selected_date'])) {
        $selectedDate = $_POST['selected_date'];
        $formattedDate = date('Y-m-d', strtotime($selectedDate));

        // SQL query to fetch collections for the selected date
        $sql = "SELECT * FROM collection c 
                INNER JOIN members m ON c.MID = m.M_ID 
                INNER JOIN users u ON c.AID = u.U_ID 
                WHERE DATE(c.C_date) = '$formattedDate' ORDER BY c.C_ID DESC";
    ?>
    
    <table class="min-w-full">
        <thead>
            <tr class="bg-blue-200 text-white">
                <th class="text-left py-3 px-4 font-semibold border-b">Collection Name</th>
                <th class="text-left py-3 px-4 font-semibold border-b">Amount</th>
                <th class="text-left py-3 px-4 font-semibold border-b">Date</th>
                <th class="text-left py-3 px-4 font-semibold border-b">Membership_ID</th>
                <th class="text-left py-3 px-4 font-semibold border-b">Responsible</th>
            </tr>
        </thead>
    </table>

    <!-- Wrapping only tbody in a scrollable div -->
    <div class="overflow-y-scroll h-80">
        <table class="min-w-full">
            <tbody>
                <?php
                $run = mysqli_query($conn, $sql);
                if (mysqli_num_rows($run)) {
                    while ($show = mysqli_fetch_array($run)) {
                        $date = $show['C_date'];
                        $formatted_date = date("M d,Y", strtotime($date));
                        ?>
                        <tr>
                            <td class="py-3 px-16 text-gray-600 border-b"><?php echo $show['Collection_Name']; ?></td>
                            <td class="py-3 px-6 text-gray-600 border-b"><?php echo $show['C_Amount']; ?></td>
                            <td class="py-3 px-4 text-gray-600 border-b"><?php echo $formatted_date; ?></td>
                            <td class="py-3 px-4 text-gray-600 border-b"><?php echo $show['Membership_ID']; ?></td>
                            <td class="py-3 px-4 text-gray-600 border-b"><?php echo $show['U_name']; ?></td>
                        </tr>
                    <?php 
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="bg-red-100 text-red-600 px-4 py-2 rounded-lg shadow-lg">
                                No results found
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php 
    }
    ?>
</div>



<!-- expense-->
<?Php 
           if (isset($_POST['selected_expense_date'])) {
    $selectedDate = $_POST['selected_expense_date'];
    $formattedDate = date('Y-m-d', strtotime($selectedDate));

    // SQL query to fetch collections for the selected date
    $sql = "SELECT * FROM expense e INNER JOIN users u ON e.UID = u.U_ID 
            WHERE DATE(e.date) = '$formattedDate' ORDER BY e.E_ID DESC";
 ?>
    <table class="min-w-full">
        <thead>
            <tr class="bg-blue-200 text-white"> <!-- Add background color and text color -->
            <th class="py-3 px-2 text-left text-gray-700 font-semibold">Expense Name</th>
                                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Amount</th>
                                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Date</th>

                                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Notes</th>
                                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Responsible</th>
            </tr>
        </thead>
    </table>
    
    <!-- Wrapping tbody in a scrollable div -->
    <div class="overflow-y-scroll h-80"> <!-- Set a fixed height for the scrollable area -->
        <table class="min-w-full">
            <tbody>
              <?php

     $run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run)) {
    while ($show = mysqli_fetch_array($run)) {
        $date = $show['date'];
        $formatted_date = date("M d,Y", strtotime($date));
        ?>
        <tr>
        <td class="py-3 px-12 text-gray-700"><?php echo $show['program']; ?></td>
                                                <td class="py-3 px-8 text-gray-700">Rs.<?php echo $show['Amount']; ?></td>
                                                <td class="py-3 px-4 text-gray-700"><?php echo $formatted_date; ?></td>
                                                <td class="py-3 px-4 text-gray-700"><?php echo $show['Description']; ?></td>
                                                <td class="py-3 px-4 text-gray-700"><?php echo $show['U_name']; ?></td>
        </tr>
    <?php 
    }
}else{
    ?>
    <br>
      <div class="flex items-center justify-center ">
                                        <div class="bg-red-100 text-red-600 px-4 py-2 rounded-lg shadow-lg">
                                            No results found
                                        </div>
                                    </div><?php
}
    
                



 
              
}  


              
              
              
              ?>
            </tbody>
        </table>
    </div>




</div>

            <!-- Modal -->
            <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-300 ease-out transform scale-0">
    <div class="bg-white rounded-lg p-6 shadow-lg max-w-md w-full transition-transform transform duration-500 ease-in-out">
        <h2 class="text-2xl mb-4">Add Collection</h2>
        <form method="post" action="php-scripts/collection.php" enctype="multipart/form-data" >

        <input type="hidden" name="aid" id="" value="<?php echo $UID;?>">
            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold">Collection Name</label>
                <input type="text" id="name" name="cname" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-sm font-semibold">Amount</label>
                <input type="number" id="amount" name="camount" class="w-full p-2 border rounded">
            </div>

            <!-- New Dropdown Input -->
            <div class="mb-4">
                <label for="category" class="block text-sm font-semibold">Member</label>
                <select id="category" name="mid" class="w-full p-2 border rounded">
                    <?php 

                    include 'dbms/connection.php';

                    $drop="SELECT * FROM members";
                    $run1=mysqli_query($conn,$drop);
                    if(mysqli_num_rows($run1)){
                        while($show=mysqli_fetch_array($run1)){
                            ?>
                            <option value="<?php echo $show['M_ID'];?>"><?php echo $show['M_name'];?></option><?php
                        }
                    }


?>
                     
                </select>
            </div>

            <div class="flex justify-end">
                <button type="button" id="closemodal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded" name="add">Save</button>
            </div>
        </form>
    </div>
</div>

        </div>
    </div>
<?php
}
?>
  

<script src="scripts/dashbaord.js" type="module"></script>
<script src="scripts/login.js"></script>


</body>
</html>
