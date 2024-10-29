<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      body {
        min-height: 100vh;
      }
      .fixed-button {
        position: fixed;
        top: 20px;
        right: 20px;
      }

      @media print {
        #report {
          border: 3px solid red; /* Apply red border when printing or downloading */
          background-color: white; /* Ensures report remains visible clearly */
          padding: 20px; /* Adds padding inside the report */
          margin: 20px;
        }

        /* Hide the download button when printing */
        .fixed-button {
          display: none;
        }
      }
    </style>
</head>
<body class="bg-gray-100 ">


    <?php 

   if(isset($_POST['genrate'])){
     $type=$_POST['type'];
     $date=$_POST['rdate'];
     include 'dbms/connection.php';
    
?>
<div class="ml-10 mt-6 ">
<button class="bg-red-500 text-white fixed px-6 py-3  shadow-lg hover:bg-red-700 hover:shadow-xl transition-all duration-300 ease-in-out" onclick="Goback()">
            Go Back
        </button>
        </div> 

<div class="ml-10 mt-6 ">
<button class="bg-blue-500 text-white fixed-button px-6 py-3 rounded-full shadow-lg hover:bg-blue-600 hover:shadow-xl transition-all duration-300 ease-in-out" onclick="downloadPDF()">
            Download PDF
        </button>
        </div> 
    <!-- Company Header -->
 <div class=" flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl " id="report">
        
    
        <div class="flex justify-between items-center">
            <div>
                <img src="./pictures/compnay_logo.png" alt="Company Logo" class="h-36 mb-4">
            </div>
            <div class="text-right">
                <p class="font-bold">Date: <span class="font-normal"><?php echo date('M d Y', strtotime($date));?></span></p>
                
            </div>
        </div>
        
        <!-- Quotation Title -->
        <h2 class="text-xl font-bold text-center my-6">Collection Report <?php echo $type."s";?></h2>

        <!-- Quotation Table -->
        <table class="w-full table-auto border-collapse ">
            <?php 
            if($type=="collection"){

               
            ?>
            <thead>
                <tr class="bg-gray-400 text-left">
                    <th class="border px-2 py-2" style="width: 5px;">NO</th>
                    <th class="border px-2 py-2" style="width: 15px;">Type</th>
                    <th class="border px-2 py-2" style="width: 15px;">Col. Amount</th>
                    <th class="border px-2 py-2" style="width: 10px;">Membership ID</th>
                    <th class="border px-2 py-2" style="width: 15px;">Member Name</th>
                    <th class="border px-2 py-2" style="width: 15px;">Responsible</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $x=0;
            
        $sql = "SELECT * FROM collection c 
        INNER JOIN members m ON c.MID = m.M_ID 
        INNER JOIN users u ON c.AID = u.U_ID where c.C_date='$date' ORDER BY c.C_ID DESC";
                $run=mysqli_query($conn,$sql);
                if(mysqli_num_rows($run)){
                    while($row=mysqli_fetch_array($run)){
                        $x+=1;?>
                        <tr>
                        <td class="border px-2 py-2" style="width: 5px;"><?php echo $x;?></td>
                        <td class="border px-2 py-2" style="width: 15px;"><?php echo $row['Collection_Name'];?></td>
                        <td class="border px-2 py-2" style="width: 15px;">Rs.<?php echo number_format($row['C_Amount']);?></td>
                        <td class="border px-2 py-2" style="width: 10px;"><?php echo $row['Membership_ID'];?></td>
                        <td class="border px-2 py-2" style="width: 15px;"><?php echo $row['M_name'];?></td>
                        <td class="border px-2 py-2" style="width: 15px;"><?php echo $row['U_name'];?></td>
                    </tr><?php
                    }
                }
                
                ?>
               
                <!-- Add more rows as needed -->
            </tbody>
            <?php }else if($type=="Expense"){
                
                ?>
                <thead>
                    <tr class="bg-gray-400 text-left">
                        <th class="border px-2 py-2" style="width: 5px;">NO</th>
                        <th class="border px-2 py-2" style="width: 15px;">Program</th>
                        <th class="border px-2 py-2" style="width: 15px;">Amount</th>
                        
                        <th class="border px-2 py-2" style="width: 15px;">Responsible</th>
                    </tr>
                </thead>
                <tbody>
                    

                    <?php 
                     $x=0;
                     $sql = "SELECT * FROM expense e INNER JOIN users u ON e.UID = u.U_ID where e.date='$date' ORDER BY e.E_ID DESC";
                     
                     $run=mysqli_query($conn,$sql);
                     if(mysqli_num_rows($run)){
                         while($row=mysqli_fetch_array($run)){

                        $x+=1;
?>
                        <tr>
                        <td class="border px-2 py-2" style="width: 5px;"><?php echo $x;?></td>
                        <td class="border px-2 py-2" style="width: 15px;"><?php echo $row['program'];?></td>
                        <td class="border px-2 py-2" style="width: 15px;">Rs.<?php echo number_format($row['Amount']);?></td>
                        
                        <td class="border px-2 py-2" style="width: 15px;"><?php echo $row['U_name'];?></td>
                    </tr>
                   
                    <?php }}?>
                    <!-- Add more rows as needed -->
                </tbody>
                <?php }
                
                ?>
        </table>

        <br><br><br>

        <!-- Company Footer -->
        <div class="mt-8 text-center" style="border-top: 2px solid black; padding-top: 16px;">
            <br>
            <p class="text-sm">Developer Information - Powered By <b>M-NEW Solutions</b></p>
            <br>
           
        </div>

        
        </div>
    </div>


<?php
    


   }

?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


<script>
    function Goback(){
        window.location.href=document.referrer;
    }
   function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const report = document.getElementById('report');

    // Use html2canvas to capture the content
    html2canvas(report, { scale: 2 }).then((canvas) => {
        const pdf = new jsPDF('p', 'mm', 'a4');

        const imgWidth = 210; // A4 width in mm
        const pageHeight = 297; // A4 height in mm
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        const padding = 10; // Padding for both top and bottom
        const contentWidth = imgWidth - 2 * padding;
        const contentHeight = pageHeight - 2 * padding; // Content height within the padded area

        let heightLeft = imgHeight;
        let position = 0;
        let pageNumber = 0; // Track the page number

        while (heightLeft > 0) {
            const pageCanvas = document.createElement('canvas');
            pageCanvas.width = canvas.width;

            // Set the height of the pageCanvas based on the remaining content and page height
            pageCanvas.height = Math.min(heightLeft * canvas.width / imgWidth, contentHeight * canvas.width / imgWidth);
            
            const pageContext = pageCanvas.getContext('2d');
            pageContext.drawImage(canvas, 0, position, canvas.width, pageCanvas.height, 0, 0, pageCanvas.width, pageCanvas.height);

            const pageImgData = pageCanvas.toDataURL('image/png');

            if (pageNumber > 0) {
                pdf.addPage();
            }

            // Add the image content without border
            pdf.addImage(pageImgData, 'PNG', padding, padding, contentWidth, (pageCanvas.height * imgWidth) / canvas.width);

            heightLeft -= pageCanvas.height * imgWidth / canvas.width;
            position += pageCanvas.height;
            pageNumber++;
        }

        // Download the PDF with a custom filename
        pdf.save('Report.pdf');
    }).catch((error) => {
        console.error("PDF generation error:", error);
    });
}
</script>







</body>
</html>
