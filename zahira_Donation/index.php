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
$expenseForMonth=0;
$available=0;
$collectionForMonth=0;
$dquery1 = "SELECT TotalValue FROM totalamount";
$queryd1 = mysqli_query($conn, $dquery1);


if (mysqli_num_rows($queryd1)) {
    while ($show1 = mysqli_fetch_array($queryd1)) {
        $available = $show1['TotalValue']; // Fetching total amount
    }
}

// Query for the 'Collection' table
$dquery2 = "SELECT * FROM collection";
$queryd2 = mysqli_query($conn, $dquery2);


if (mysqli_num_rows($queryd2)) {
    while ($show2 = mysqli_fetch_array($queryd2)) {
        $allcollection += $show2['C_Amount']; // Adding up all collection amounts
    }
}

// quey3
$currentMonth = date('n'); // Numeric representation of a month, 1 for January, 2 for February, etc.
$currentYear = date('Y');

$dquery3 = "SELECT * FROM collection WHERE MONTH(C_date) = $currentMonth AND YEAR(C_date) = $currentYear";
$runquery=mysqli_query($conn,$dquery3);
if(mysqli_num_rows($runquery)){
    while($row=mysqli_fetch_array($runquery)){
        $collectionForMonth += $row['C_Amount'];
    }
}
    
// query4

$dquery4 = "SELECT * FROM expense e WHERE MONTH(e.date) = $currentMonth AND YEAR(e.date) = $currentYear ";
$runquery1=mysqli_query($conn,$dquery4);
if(mysqli_num_rows($runquery1)){
    while($row1=mysqli_fetch_array($runquery1)){
        $expenseForMonth += $row1['Amount'];
    }
}
    





?>

    <div class="dashboard">
        <div class="nav"></div>
        <div class="flexbox">
            <div class="body bg-gray-100 p-8">
                <div class="font-bold text-xl mb-2">Dashboard</div>
                <div class="flex space-x-4">
                    <!-- Paid Amount Card -->
                    <div class="bg-white rounded shadow p-4 flex-1">
    <div class="font-bold text-gray-700">Collections</div>
    <p class="text-2xl font-semibold text-blue-600 font-bold">Rs. <?php echo formatNumber($allcollection); ?></p> <!-- Adjusted styling -->
    <p class="text-sm text-gray-500">Till Now</p>
</div>


                    <!-- Overdue Amount Card -->
                    <div class="bg-white rounded shadow p-4 flex-1">
                        <div class="font-bold text-gray-700">Available Amount</div>
                        <p class="text-2xl font-semibold text-blue-600 font-bold">Rs.<?php echo formatNumber($available);?></p>
                        <p class="text-sm text-gray-500">Full Total</p>
                    </div>

                    <!-- Other Cards -->
                    <div class="bg-white rounded shadow p-4 flex-1">
                        <div class="font-bold text-gray-700">Collection Amount</div>
                        <p class="text-2xl font-semibold text-red-600 font-bold">Rs.<?php echo formatNumber($collectionForMonth);?></p>
                        <p class="text-sm text-gray-500 font-bold">Over this Month</p>
                    </div>

                    <div class="bg-white rounded shadow p-4 flex-1">
                        <div class="font-bold text-gray-700">Expense Amount</div>
                        <p class="text-2xl font-semibold text-red-600 font-bold">Rs.<?php echo formatNumber($expenseForMonth);?></p>
                        <p class="text-sm text-gray-500 font-bold">Over this Month</p>
                    </div>
                </div>
            </div>

            
            <hr class="border-t-1 border-gray-400 ">
        

            <div class="p-4 bg-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-lg font-semibold">All Collection</div>
                    <div class="flex items-center space-x-2">
                        <label for="monthDropdown" class="block text-sm font-medium text-gray-700">Select Month</label>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="flex items-center">
                            <select id="monthDropdown" name="month" 
                    class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    onchange="this.form.submit()"> <!-- Automatically submit form when month is selected -->
                    <option  ></option> <option value="all">All</option>
                <?php
                // Get the current month number (1-12)
                $currentMonth = date('n'); // 1 for January, 2 for February, etc.
                
                // Create options for each month from January to the current month
                for ($month = 1; $month <= $currentMonth; $month++) {
                    // Convert month number to month name
                    $monthName = date('F', mktime(0, 0, 0, $month, 1));
                    echo "<option value='$month'>$monthName</option>";
                }
                ?>
                
            </select>

            <!-- Hidden input to display the selected month -->
            <input type="hidden" id="selectedMonth" class="ml-4 text-gray-700 font-medium" name="months">
        </div>
                                 
                            
                        </form>
                    </div>

                   
                    
<!-- serch-->
<div class="flex items-center space-x-2">
        <form action="" method="post" enctype="multipart/form-data">
        <input type="text" id="search" placeholder="Search..." class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" name="search_input">
        <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg shadow hover:bg-gray-300 focus:ring-2 focus:ring-blue-500" name="searchbtn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.42-1.42l4.4 4.39a1 1 0 01-1.42 1.42l-4.39-4.4zM8 14a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd" />
            </svg>
        </button></form>
    </div>
  



    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 openmodal">
                        Add Collection
                    </button>



                </div>
            </div>
          
            <div class="min-w-full bg-white shadow-md rounded-lg">
    <table class="min-w-full">
        <thead>
            <tr class="bg-blue-200 text-black text-sm"> <!-- Add background color and text color -->
                <th class="text-left py-3 px-2 font-semibold border-b">Collection Name</th>
                <th class="text-left py-3 px-4 font-semibold border-b">Amount</th>
                <th class="text-left py-3 px-10 font-semibold border-b">Date</th>
                <th class="text-left py-3 px-0 font-semibold border-b">Membership_ID</th>
                <th class="text-left py-3 px-6 font-semibold border-b">Member</th>

                <th class="text-left py-3 px-0 font-semibold border-b">Responsible</th>
                <th class="text-left py-3 px-20 font-semibold border-b">Note</th>
                <th class="text-left py-3 px-0 font-semibold border-b">Action</th>
            </tr>
        </thead>
    </table>
    
    <!-- Wrapping only tbody in a scrollable div -->
    <div class="overflow-y-scroll h-60"> <!-- Set a fixed height for the scrollable area -->
        <table class="min-w-full">
            <tbody>
                <?php  
                if (isset($_POST['searchbtn'])) {
                    $input = $_POST['search_input'];
                    $sql = "SELECT * FROM collection c 
                            INNER JOIN members m ON c.MID = m.M_ID 
                            INNER JOIN users u ON c.AID = u.U_ID WHERE Collection_Name = '$input' OR M_name='$input' OR Membership_ID='$input' ORDER BY c.C_ID DESC";
                } else {
                    if (isset($_POST['month'])) {
                        $selectedMonth = $_POST['month'];
                        if ($selectedMonth === "all") {
                            $sql = "SELECT * FROM collection c 
                                    INNER JOIN members m ON c.MID = m.M_ID 
                                    INNER JOIN users u ON c.AID = u.U_ID ORDER BY c.C_ID DESC";
                        } else {
                            $sql = "SELECT * FROM collection c 
                                    INNER JOIN members m ON c.MID = m.M_ID 
                                    INNER JOIN users u ON c.AID = u.U_ID WHERE MONTH(c.C_date) = $selectedMonth ORDER BY c.C_ID DESC";
                        }
                    } else {
                        $sql = "SELECT * FROM collection c 
                                INNER JOIN members m ON c.MID = m.M_ID 
                                INNER JOIN users u ON c.AID = u.U_ID ORDER BY c.C_ID DESC";
                    }
                }

                $run = mysqli_query($conn, $sql);
                if (mysqli_num_rows($run)) {
                    while ($show = mysqli_fetch_array($run)) {
                        $date = $show['C_date'];
                        $formatted_date = date("M d,Y", strtotime($date));
                        ?>
                        <tr class="text-sm">
                            <td class="py-3 px-8 text-gray-600 border-b font-bold"><?php echo $show['Collection_Name']; ?></td>
                            <td class="py-3 px-2 pl-4 pr-10 text-gray-600 border-b font-bold">Rs.<?php echo $show['C_Amount']; ?></td>
                            <td class="py-3 px-2 pl-0 pr-0 text-gray-600 border-b font-bold"><?php echo $formatted_date; ?></td>
                            <td class="py-3 px-10 pr-0 text-gray-600 border-b font-bold"><?php echo $show['Membership_ID']; ?></td>
                            <td class="py-3 px-8 pl-16 text-gray-600 border-b font-bold"><?php echo $show['M_name']; ?></td>
                            <td class="py-3 px-0 pl-4 pr-12 text-gray-600 border-b font-bold"><?php echo $show['U_name']; ?></td>
                            <td class="py-3 px-24  pl-0 text-gray-600 border-b font-bold"><?php echo $show['c_desc']; ?></td>
                            <td class="py-3 px-0 pl-0 text-gray-600 border-b font-bold"> <form action="" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="cid" value="<?php echo $show['C_ID']; ?>">
                                        <button class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover:bg-blue-600 hover:shadow-xl focus:outline-none transition-all duration-300 ease-in-out" name="editClick">
                                            Edit
                                        </button>
                                    </form></td>
                            
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
</div>

<?php
if (isset($_POST['editClick'])) {
    $cid = $_POST['cid'];
    $sql = "SELECT * FROM collection WHERE C_ID='$cid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
?>
<!-- Edit Member Modal -->
<div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-2xl relative">
        <!-- Close Button -->
        <button id="closeEditModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <h2 class="text-xl font-semibold mb-4">Edit Collection</h2>

        <form action="php-scripts/changeCollection.php" method="POST" class="space-y-4" enctype="multipart/form-data">
            <input type="hidden" name="eid" value="<?php echo $row['C_ID']; ?>">

            <input type="hidden" name="aid" id="" value="<?php echo $UID;?>">
            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold">Collection Name</label>
                <input type="text" id="name" name="ecname" value="<?php echo $row['Collection_Name']; ?>" class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-sm font-semibold">Amount</label>
                <input type="number" id="amount" name="ecamount" value="<?php echo $row['C_Amount']; ?>" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="note" class="block text-sm font-semibold">Note</label>
                <input type="text" id="note" name="ecdesc" value="<?php echo $row['c_desc'];?>" class="w-full p-2 border rounded">
            </div>
            <input type="hidden" name="old_amount" id="" value="<?php echo $row['C_Amount'];?>">

            <!-- New Dropdown Input -->
            <div class="mb-4">
                <label for="category" class="block text-sm font-semibold">Member</label>
                <select id="category" name="emember"   class="w-full p-2 border rounded">
                <?php 
                    include 'dbms/connection.php';
                    $drop = "SELECT * FROM members";
                    $run1 = mysqli_query($conn, $drop);
                    if (mysqli_num_rows($run1)) {
                        while ($show = mysqli_fetch_array($run1)) {
                            // Check if the current member is the selected one in the collection
                            $selected = ($show['M_ID'] == $row['member_id']) ? 'selected' : '';
                            echo "<option value='{$show['M_ID']}' $selected>{$show['M_name']}</option>";
                        }
                    }
                    ?>
                     
                </select>
            </div>

            <div class="flex justify-end">
                
                <button class="bg-blue-500 text-white px-4 py-2 rounded" name="edit">Save</button>
            </div>
            
        </form>
    </div>
</div>
<?php
}
?>
<script>
    document.getElementById('closeEditModal').addEventListener('click', function() {
        document.getElementById('editModal').style.display = 'none';
    });
</script>


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
            <div class="mb-4">
                <label for="note" class="block text-sm font-semibold">Note</label>
                <input type="text" id="note" name="cdesc" class="w-full p-2 border rounded">
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
