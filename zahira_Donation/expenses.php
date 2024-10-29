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
    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {


        ?>

        <div class="logintab"></div>
        <?php

    } else {
        include 'dbms/connection.php';
        $UID = $_SESSION['UID'];


        $fullTotal = 0;
        $totalsql = "SELECT * FROM totalamount";
        $query1 = mysqli_query($conn, $totalsql);
        if (mysqli_num_rows($query1)) {
            while ($row = mysqli_fetch_array($query1)) {
                $fullTotal = $row['TotalValue'];
            }
        }

        ?>



        <div class="dashboard">
            <div class="nav"></div>
            <div class="flexbox">
                <div class="body bg-gray-100 p-8 h-screen">

                    <div class=" bg-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center justify-center  ">
                                <div class="bg-white shadow-lg rounded-lg p-6 ">
                                    <div class="text-center">
                                        <p class="text-gray-800 text-3xl font-bold">Rs.<?php echo number_format($fullTotal); ?></p>
                                        <!-- Price -->
                                    </div>
                                    <div class="text-center">
                                        <p class="text-gray-600 text-sm font-semibold">Available Amount</p>
                                        <!-- Available amount text -->
                                    </div>
                                </div>
                            </div>
                            <!-- search-->
                            <div class="flex items-center space-x-2">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="text" id="search" placeholder="Search..."
                                        class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        name="search_input">
                                    <button
                                        class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg shadow hover:bg-gray-300 focus:ring-2 focus:ring-blue-500"
                                        name="searchbtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.9 14.32a8 8 0 111.42-1.42l4.4 4.39a1 1 0 01-1.42 1.42l-4.39-4.4zM8 14a6 6 0 100-12 6 6 0 000 12z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>


                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 openmodal">
                                Add Expense
                            </button>
                        </div>
                    </div>
                    <hr class="border-0 h-px bg-gray-800 my-4">

                    <!---->
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


                    <div class="bg-gray-100 p-2 m-0">
                        <div class="container mx-auto bg-white p-6 rounded-lg shadow-md">
                            <h2 class="text-2xl font-semibold mb-4">Expenses Details</h2>

                            <div class="relative h-64 overflow-y-scroll overflow-x-hidden">
                            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                            <thead class="sticky top-0 bg-blue-200 z-10">
                                    <tr class="  border-b">
                                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Expense Name</th>
                                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Amount</th>
                                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Date</th>

                                        <th class="py-3 px-12 text-left text-gray-700 font-semibold">Notes</th>
                                        <th class="py-3 px-0 text-left text-gray-700 font-semibold">Responsible</th>
                                        <th class="py-3 px-4 text-left text-gray-700 font-semibold">Action</th>
                                    </tr>
                                </thead>

                                <?php
                                $result = false;
                                $noResult = false;
                                if (isset($_POST['searchbtn'])) {
                                    $input = $_POST['search_input'];

                                    $search = "SELECT * FROM expense e inner join users u on e.UID=u.U_ID where program = '$input' or U_name='$input' or U_name='$input' ORDER BY e.E_ID DESC";
                                    $squery = mysqli_query($conn, $search);
                                    if (mysqli_num_rows($squery)) {
                                        while ($show = mysqli_fetch_array($squery)) {
                                            $dateformat = date('M d,Y', strtotime($show['date']));
                                            ?>
                                            <tr class="border-b">
                                                <td class="py-3 px-4 text-gray-700"><?php echo $show['program']; ?></td>
                                                <td class="py-3 px-4 text-gray-700">Rs.<?php echo $show['Amount']; ?></td>
                                                <td class="py-3 px-4 text-gray-700"><?php echo $dateformat; ?></td>
                                                <td class="py-3 px-12 text-gray-700"><?php echo $show['Description']; ?></td>
                                                <td class="py-3 px-0 text-gray-700"><?php echo $show['U_name']; ?></td>
                                                
                                                
                                            </tr>
                                            <?php
                                        }
                                    } else {

                                        $noResult = true;




                                    }
                                } else {



                                    if (isset($_POST['month'])) {
                                        $selectedMonth = $_POST['month'];
                                        
                                        if ($selectedMonth === "all") {
                                            // Fetch all expenses if "All" is selected
                                            $sql = "SELECT * FROM expense e INNER JOIN users u ON e.UID = u.U_ID ORDER BY e.E_ID DESC";
                                        } else {
                                            // Fetch expenses for the selected month
                                            $sql = "SELECT * FROM expense e INNER JOIN users u ON e.UID = u.U_ID WHERE MONTH(e.date) = $selectedMonth ORDER BY e.E_ID DESC";
                                        }
                                    } else {
                                        // Default query to fetch all records if no month is selected
                                        $sql = "SELECT * FROM expense e INNER JOIN users u ON e.UID = u.U_ID ORDER BY e.E_ID DESC";
                                    }
                                    $query = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($query)) {
                                        while ($show = mysqli_fetch_array($query)) {
                                            $dateformat = date('M d', strtotime($show['date']));
                                            ?>
                                            <tbody clas="overflow-hidden">
                                            <tr class="border-b">
                                                <td class="py-3 px-4 text-gray-700"><?php echo $show['program']; ?></td>
                                                <td class="py-3 px-4 text-gray-700">Rs.<?php echo $show['Amount']; ?></td>
                                                <td class="py-3 px-4 text-gray-700"><?php echo $dateformat; ?></td>
                                                <td class="py-3 px-4 text-gray-700"><?php echo $show['Description']; ?></td>
                                                <td class="py-3 px-4 text-gray-700"><?php echo $show['U_name']; ?></td>
                                                <td class="py-3 px-4 text-gray-700"><form action="" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="eid" value="<?php echo $show['E_ID']; ?>">
                                        <button class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover:bg-blue-600 hover:shadow-xl focus:outline-none transition-all duration-300 ease-in-out" name="editClick">
                                            Edit
                                        </button>
                                    </form></td>
                                            </tr></tbody>
                                            <?php
                                        }
                                    } else {
                                        $result = true;
                                    }
                                }

                                ?>


                            </table>
                            </div>
                            <?php
                            if ($result == true) {
                                ?>
                                <div class="flex flex-col items-center justify-center" style="margin-top: 10px;">
                                    <p class="text-gray-700 text-lg mb-4">No expenses recorded yet. Click the button below to
                                        add an expense.</p>
                                    <button
                                        class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 openmodal">
                                        Add Expense
                                    </button>
                                </div>
                                <?php
                            } else if ($noResult == true) { ?>
                                    <br>
                                    <div class="flex items-center justify-center ">
                                        <div class="bg-red-100 text-red-600 px-4 py-2 rounded-lg shadow-lg">
                                            No results found
                                        </div>
                                    </div>
                                <?php
                            }
                            ?>


                        </div>

                    </div>

                    <?php
if (isset($_POST['editClick'])) {
    $eid = $_POST['eid'];
    $sql = "SELECT * FROM expense WHERE E_ID='$eid'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result))
 {
while($row=mysqli_fetch_array($result)){

    // Replace with actual value or calculation
?>
<div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-2xl relative">
        <button id="closeEditModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <!-- Edit Expense Form -->
        <form id="expense-form-edit" action="php-scripts/changeExpense.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="eid" value="<?php echo $row['E_ID']; ?>">
            <h2 class="text-2xl font-semibold text-gray-800">Edit Expense</h2>
            <h4 class="text-lg text-gray-600">Available Amount: Rs. <?php echo $fullTotal; ?></h4>
            <hr class="border-t-2 border-gray-400 my-4">
            <div id="error-message-edit" class="text-red-600 text-sm mb-4 hidden">Insufficient amount available.</div>
            
            <!-- Expense Name -->
            <div class="flex flex-col gap-2">
                <label for="expenseNameEdit" class="block text-sm font-medium text-gray-700">Expense Name</label>
                <input type="text" id="expenseNameEdit" name="ename" value="<?php echo $row['program']; ?>"
                       class="block w-full px-3 py-2 border-2 border-gray-400 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="Enter expense name" required>
            </div>
            
            <!-- Expense Amount -->
            <div class="flex flex-col gap-2">
                <label for="amountEdit" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" id="amountEdit" name="eamount" value="<?php echo $row['Amount']; ?>"
                       class="block w-full px-3 py-2 border-2 border-gray-400 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="Enter amount" required>
            </div>
            <div class="col-span-2 flex flex-col gap-2">
    <label for="notes" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea id="notes" name="note" rows="3"
        class="block w-full px-3 py-2 border-2 border-gray-400 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        placeholder="Optional"><?php echo $row['Description']; ?></textarea>
</div>
            <input type="hidden" name="old_amount" value="<?php echo $row['Amount']; ?>">

            <!-- Submit Button -->
            <div class="col-span-2 flex justify-center mt-4">
                <button type="submit" name="edit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
            </div>
        </form>
    </div>
</div>
<?php
}
} 
}
?>

<script>
   // Get necessary elements
const amountEdit = document.getElementById('amountEdit');
const availableAmount = <?php echo $fullTotal; ?>;
const oldAmount = parseFloat(document.querySelector('input[name="old_amount"]').value);
const errorMessage = document.getElementById('error-message-edit');

// Add input event listener to check amount as the user types
amountEdit.addEventListener('input', function() {
    const newAmount = parseFloat(amountEdit.value);

    // Ensure newAmount is a number and is greater than old amount for the check
    if (!isNaN(newAmount) && newAmount > oldAmount) {
        const difference = newAmount - oldAmount;

        // Check if the difference is within the available balance
        if (difference > availableAmount) {
            errorMessage.classList.remove('hidden'); // Show error if insufficient
        } else {
            errorMessage.classList.add('hidden'); // Hide error if sufficient
        }
    } else {
        errorMessage.classList.add('hidden'); // Hide error if new amount is not greater
    }
});

// Close button functionality for the modal
document.getElementById('closeEditModal').addEventListener('click', function() {
    document.getElementById('editModal').style.display = 'none';
});


</script>



                    <!-- add expenses-->
                    <!-- Modal -->
                    <div id="modal"
                        class="absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-300 ease-out transform scale-0 z-50">
                        <div
                            class="bg-white rounded-lg p-6 shadow-lg max-w-4xl w-full transition-transform transform duration-500 ease-in-out">
                            <!-- Close Button -->
                            <button id="closemodal"
                                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <!-- Title and Available Amount -->
                            <div class="flex items-center justify-between p-4">
                                <h2 class="text-2xl font-semibold text-gray-800">Add a New Expense</h2>
                                <h4 class="text-lg text-gray-600">Available Amount: <span
                                        class="font-bold text-gray-800">Rs. <?php echo $fullTotal; ?></span></h4>
                            </div>

                            <!-- Horizontal Line -->
                            <hr class="border-t-2 border-gray-400 my-4">

                            <!-- Message Area -->
                            <div id="error-message" class="text-red-600 text-sm mb-4 hidden">Insufficient amount available.
                            </div>

                            <!-- Form -->
                            <form id="expense-form" action="php-scripts/expense.php" method="POST"
                                class="grid grid-cols-2 gap-4" enctype="multipart/form-data">
                                <!-- Expense Name -->
                                <input type="hidden" name="uid" id="" value="<?php echo $UID; ?>">
                                <div class="flex flex-col gap-2">
                                    <label for="expenseName" class="block text-sm font-medium text-gray-700">Expense
                                        Name</label>
                                    <input type="text" id="expenseName" name="pname"
                                        class="block w-full px-3 py-2 border-2 border-gray-400 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Enter expense name" required>
                                </div>
                                <!-- Expense Amount -->
                                <div class="flex flex-col gap-2">
                                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                    <input type="number" id="amount" name="amount"
                                        class="block w-full px-3 py-2 border-2 border-gray-400 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Enter amount" required>
                                </div>
                                <!-- Notes (optional) -->
                                <div class="col-span-2 flex flex-col gap-2">
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="notes" name="notes" rows="3"
                                        class="block w-full px-3 py-2 border-2 border-gray-400 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Optional"></textarea>
                                </div>
                                <!-- Submit Button (full width) -->
                                <div class="col-span-2 flex justify-center">
                                    <button type="submit" name="submit"
                                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                        document.getElementById('expense-form').addEventListener('submit', function (event) {
                            // Get available amount from PHP
                            const availableAmount = <?php echo $fullTotal; ?>;

                            // Get the entered amount
                            const enteredAmount = parseFloat(document.getElementById('amount').value);

                            // Get the error message div
                            const errorMessage = document.getElementById('error-message');

                            // Check if the entered amount is greater than available amount
                            if (enteredAmount > availableAmount) {
                                // Prevent form submission
                                event.preventDefault();
                                // Show error message
                                errorMessage.classList.remove('hidden');
                            } else {
                                // Hide error message if input is valid
                                errorMessage.classList.add('hidden');
                            }
                        });
                    </script>


                </div>
            </div>
        </div>

    <?php } ?>

    <script src="scripts/dashbaord.js" type="module"></script>
    <script src="scripts/login.js"></script>

</body>

</html>