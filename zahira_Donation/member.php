<?php session_start(); 

?>
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
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {?>
    <script>
        window.location.href="index.php";
    </script><?php
}else{
?>
<div class="dashboard">
        <div class="nav"></div>
        <div class="flexbox">
        <div class="body bg-gray-100 p-8">
            
         <div class="p-4 bg-gray-100">
         <div class="flex justify-between items-center mb-2">
    <!-- Title Section -->
    <div class="text-xl font-semibold text-gray-800">Add Member</div>
    
    <!-- Search Section -->
    <div class="flex items-center space-x-2">
        <form action="" method="post" enctype="multipart/form-data">
        <input type="text" id="search" placeholder="Search..." class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" name="search_input">
        <button class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg shadow hover:bg-gray-300 focus:ring-2 focus:ring-blue-500" name="searchbtn">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.42-1.42l4.4 4.39a1 1 0 01-1.42 1.42l-4.39-4.4zM8 14a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd" />
            </svg>
        </button></form>
    </div>

    <!-- Add Member Button -->
    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 openmodal">
        Add Member
    </button>
</div>

    </div>
    <hr class="border-0 h-px bg-gray-800 my-4">


   
    <div class="container mx-auto bg-white rounded-lg w-full ">
    <h2 class="text-2xl font-semibold mb-4 ml-2">Members Details</h2>

    <div class="overflow-y-auto h-96"> <!-- Added this div for scrolling -->
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead class="sticky top-0 bg-blue-200 z-10"> <!-- Fixed header with sticky position -->
                <tr class="border-b">
                    <th class="py-3 px-4 text-left text-gray-700 font-semibold">Membership ID</th> <!-- New column -->
                    <th class="py-3 px-4 text-left text-gray-700 font-semibold">Member Name</th>
                    <th class="py-3 px-4 text-left text-gray-700 font-semibold">Email</th>
                    <th class="py-3 px-4 text-left text-gray-700 font-semibold">Phone Number</th>
                    <th class="py-3 px-4 text-left text-gray-700 font-semibold">Address</th>
                    <th class="py-3 px-4 text-left text-gray-700 font-semibold">NIC</th>
                    <th class="py-3 px-4 text-left text-gray-700 font-semibold">Batch</th>
                    <th class="py-3 px-4 text-left text-gray-700 font-semibold">Gender</th>
                    <th class="py-3 px-4 text-left text-gray-700 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'dbms/connection.php';
                if (isset($_POST['searchbtn'])) {
                    $input = $_POST['search_input'];
                    $search = "SELECT * FROM members WHERE M_name = '$input' OR M_phone = '$input' OR M_NIC = '$input' OR M_email = '$input' or Membership_ID='$input' or M_Batch='$input'";
                    $squery = mysqli_query($conn, $search);
                    if (mysqli_num_rows($squery)) {
                        while ($show = mysqli_fetch_array($squery)) {
                            $gender = ($show['Gender'] == 1) ? "Male" : "Female"; // Ternary for gender
                            ?>
                            <tr>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['Membership_ID'];?></td> <!-- Smaller text -->
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_name']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_email']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_phone']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_address']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_NIC']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_Batch']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $gender; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm">
                                    <form action="member.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="eid" value="<?php echo $show['M_ID']; ?>">
                                        <button class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover:bg-blue-600 hover:shadow-xl focus:outline-none transition-all duration-300 ease-in-out" name="editClick">
                                            Edit
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                } else {
                    $sql = "SELECT * FROM members";
                    $run = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($run)) {
                        while ($show = mysqli_fetch_array($run)) {
                            $gender = ($show['Gender'] == 1) ? "Male" : "Female"; // Ternary for gender
                            ?>
                            <tr>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['Membership_ID'];?></td> <!-- Smaller text -->
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_name']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_email']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_phone']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_address']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_NIC']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $show['M_Batch']; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm"><?php echo $gender; ?></td>
                                <td class="py-2 px-4 text-gray-700 border-b text-sm">
                                    <form action="member.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="eid" value="<?php echo $show['M_ID']; ?>">
                                        <button class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover:bg-blue-600 hover:shadow-xl focus:outline-none transition-all duration-300 ease-in-out" name="editClick">
                                            Edit
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!---->

<!-- edit form -->
<?php
if (isset($_POST['editClick'])) {
    $eid = $_POST['eid'];
    $sql = "SELECT * FROM members WHERE M_ID='$eid'";
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

        <h2 class="text-xl font-semibold mb-4">Edit Member</h2>

        <form action="./php-scripts/add_member.php" method="POST" class="space-y-4" enctype="multipart/form-data">
            <input type="hidden" name="eid" value="<?php echo $row['M_ID']; ?>">

            <!-- Grid Layout for 2 inputs per row -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="name" name="ename" value="<?php echo $row['M_name']; ?>" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                    focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="e_email" value="<?php echo $row['M_email']; ?>" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                    focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" id="phone" name="ephone" value="<?php echo $row['M_phone']; ?>" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                    focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <!-- NIC -->
                <div>
                    <label for="NIC" class="block text-sm font-medium text-gray-700">NIC</label>
                    <input type="text" id="NIC" name="enic" value="<?php echo $row['M_NIC']; ?>" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                    focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <!-- Batch -->
                <div>
                    <label for="batch" class="block text-sm font-medium text-gray-700">Batch</label>
                    <input type="number" id="batch" name="ebatch" value="<?php echo $row['M_Batch']; ?>" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                    focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select id="gender" name="egender" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="1" <?php if($row['Gender'] == 1) echo 'selected'; ?>>Male</option>
                        <option value="0" <?php if($row['Gender'] == 0) echo 'selected'; ?>>Female</option>
                    </select>
                </div>
            </div>

            <!-- Address (Full width) -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea id="address" name="eaddress" rows="3" 
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm 
                focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?php echo $row['M_address']; ?></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" name="edit" 
                class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-indigo-700 
                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save Changes</button>
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

<!-- Modal for Add and Edit Member -->
<div id="modal" class="absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-300 ease-out transform scale-0 z-50">
    <div class="bg-white rounded-lg p-6 shadow-lg max-w-4xl w-full transition-transform transform duration-500 ease-in-out">
        <!-- Close Button -->
        <button id="closemodal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <h2 id="modal-title" class="text-xl mb-4">Add/Edit Member</h2>
        <form id="memberForm" action="./php-scripts/add_member.php" method="POST" class="grid grid-cols-2 gap-4" enctype="multipart/form-data">
            <!-- Hidden field for Member ID -->
            <input type="hidden" id="member_id" name="member_id">

            <!-- Full Name -->
            <div class="flex flex-col gap-2">
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" id="name" name="name" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" placeholder="Enter full name" required>
            </div>

            <!-- Email -->
            <div class="flex flex-col gap-2">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" placeholder="Enter email" required>
            </div>

            <!-- Phone Number -->
            <div class="flex flex-col gap-2">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" placeholder="Enter phone number" required>
            </div>

            <!-- NIC -->
            <div class="flex flex-col gap-2">
                <label for="NIC" class="block text-sm font-medium text-gray-700">NIC</label>
                <input type="text" id="NIC" name="NIC" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" placeholder="Enter NIC" required>
            </div>

            <!-- Batch -->
            <div class="flex flex-col gap-2">
                <label for="batch" class="block text-sm font-medium text-gray-700">Batch</label>
                <input type="number" id="batch" name="batch" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" placeholder="Enter Batch Year" required>
            </div>

            <!-- Gender -->
            <div class="flex flex-col gap-2">
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select id="gender" name="gender" class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg shadow-sm">
                    <option value="1">Male</option>
                    <option value="0">Female</option>
                </select>
            </div>

            <!-- Address -->
            <div class="col-span-2 flex flex-col gap-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea id="address" name="address" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm" placeholder="Enter address"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="col-span-2 flex justify-center">
                <button type="submit" id="submitButton" name="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-indigo-700">Save</button>
            </div>
        </form>
    </div>
</div>

 <!-- Modal -->
 <div id="modal" class="absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-300 ease-out transform scale-0">
        <div class="bg-white rounded-lg p-6 shadow-lg max-w-4xl w-full transition-transform transform duration-500 ease-in-out">
            <!-- Close Button -->
            <button id="closemodal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <h2 class="text-xl mb-4">Add a Member</h2>
            <form  action="./php-scripts/add_member.php" method="POST" class="grid grid-cols-2 gap-4" enctype="multipart/form-data">
                <!-- Full Name -->
                <div class="flex flex-col gap-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="name" name="name" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter full name" required>
                </div>
                <!-- Email -->
                <div class="flex flex-col gap-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter email" required>
                </div>
                <!-- Phone Number -->
                <div class="flex flex-col gap-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter phone number" required>
                </div>
                <!-- NIC Number -->
                <div class="flex flex-col gap-2">
                    <label for="NIC" class="block text-sm font-medium text-gray-700">NIC</label>
                    <input type="text" id="NIC" name="NIC" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter NIC Number" required>
                </div>
                <!-- Batch -->
                <div class="flex flex-col gap-2">
                    <label for="batch" class="block text-sm font-medium text-gray-700">Batch</label>
                    <input type="number" id="batch" name="batch" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter Batch Year" required>
                </div>
                <!-- Gender -->
                <div class="flex flex-col gap-2">
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select id="gender" name="gender" class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="1">Male</option>
                        <option value="0">Female</option>
                    </select>
                </div>
                <!-- Address (full width) -->
                <div class="col-span-2 flex flex-col gap-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea id="address" name="address" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter address"></textarea>
                </div>
                <!-- Submit Button (full width) -->
                <div class="col-span-2 flex justify-center">
                    <button type="submit" name="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                </div>
            </form>
        </div>
    </div>


        </div>
        </div>
        </div>
        <?php }?>
        

        <script src="scripts/dashbaord.js" type="module"></script>
        
</body>


</html>
