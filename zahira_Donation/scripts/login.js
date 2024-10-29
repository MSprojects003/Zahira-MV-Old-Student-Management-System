document.addEventListener("DOMContentLoaded", function() {
    const login_tab = document.querySelector('.logintab');
    login_tab.innerHTML = login(); // Initialize login form

    // Check if there is a login error and display it
    const loginStatus = localStorage.getItem('loginStatus');
    if (loginStatus === 'error') {
        displayLoginError();
        // Clear the loginStatus to avoid displaying the error after refresh
        localStorage.removeItem('loginStatus');
    }

    function login() {
        return `
            <div class="main2 bg-gray-100 flex items-center shadow-lg justify-center min-h-screen">
                <div class="shadow-lg rounded-lg overflow-hidden flex w-full max-w-4xl login">
                    <!-- Left Side -->
                    <div class="w-1/2 flex flex-col items-center justify-center p-10"></div>

                    <!-- Right Side -->
                    <div class="w-1/2 p-10 login-section">
                        <div class="text-center flex justify-center">
                            <img src="./pictures/logo.png" alt="Logo" class="h-48 mb-4">
                        </div>
                        <form action="./php-scripts/login.php" method="POST" class="form1">
                            <div class="mb-4">
                                <label class="block text-red-600 text-sm font-bold mb-2" for="email">User Name</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" name="uname" placeholder="Enter your username" required>
                            </div>
                            <div class="mb-6">
                                <label class="block text-red-600 text-sm font-bold mb-2" for="password">PASSWORD</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="paswd" placeholder="Enter your password" required>
                            </div>
                            <div id="error-message" class="text-red-600 mb-4 hidden"></div>
                            <div class="flex items-center justify-between">
                                <button class="bg-red-700 border border-red-700 text-white font-bold py-3 px-10 rounded focus:outline-none focus:shadow-outline" type="submit" name="login">
                                    Login
                                </button>
                                <button type="button" class="change-password-button">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
    }

    // Event listener for "Change Password" button
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('change-password-button')) {
            displayChangePasswordForm();
        }
    });

    function displayChangePasswordForm() {
        const changePasswordHTML = `
            <div class="main2 bg-gray-100 flex items-center shadow-lg justify-center min-h-screen">
                <div class="shadow-lg rounded-lg overflow-hidden flex w-full max-w-4xl login">
                    <div class="w-1/2 flex flex-col items-center justify-center p-10"></div>

                    <!-- Right Side -->
                    <div class="w-1/2 p-10 login-section">
                        <div class="text-center flex justify-center">
                            <img src="./pictures/logo.png" alt="Logo" class="h-48 mb-4">
                        </div>
                        <form action="./php-scripts/login.php" method="POST" class="form1">
                            <div class="mb-4">
                                <label class="block text-red-600 text-sm font-bold mb-2" for="phone">Enter Phone Number</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phone" type="text" name="phone" placeholder="Enter your phone number" required>
                            </div>
                            <div id="error-message" class="text-red-600 mb-4 hidden"></div>
                            <div class="flex items-center justify-between">
                                <button class="bg-red-700 border border-red-700 text-white font-bold py-3 px-10 rounded focus:outline-none focus:shadow-outline" name="check"  >
                                    Submit
                                </button>
                                <button type="button" class="back-to-login-button">Back to Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
        login_tab.innerHTML = changePasswordHTML; // Update the login tab with the new form

        // Event listener for the back to login button
        document.querySelector('.back-to-login-button').addEventListener('click', function() {
            login_tab.innerHTML = login(); // Return to the login form
        });
    }

    function displayLoginError() {
        const errorMessage = document.getElementById('error-message');
        errorMessage.innerText = 'Invalid username or password. Please try again.';
        errorMessage.classList.remove('hidden');
    }
});
