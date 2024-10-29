function Navbar(){
    return `<!-- Sidebar -->
        <nav class="w-64 h-screen bg-sky-100 text-black flex flex-col border-l-4 border-black border-l-custom">
            <!-- Logo / Header -->
            <div class="px-4 py-5 text-center bg-gray-800 text-white">
                <h1 class="text-xl font-bold">Dashboard</h1>
            </div>
            <!-- Navigation Links -->
            <ul class="flex flex-col p-4 space-y-4">
                <li id="nav-home">
                    <a href="index.php" class="block py-2 px-4 rounded hover:bg-gray-700 hover:text-red-100 transition-colors duration-300 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9-5v6m0 0v6m0-6h2m4 0h2m0 0l-7 7-7-7"/>
                        </svg>
                        <span class="text-lg">Home</span>
                    </a>
                </li>
                <li id="nav-insight">
                    <a href="member.php" class="block py-2 px-4 rounded hover:bg-gray-700 hover:text-red-100 transition-colors duration-300 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c2.2 0 4-1.8 4-4s-1.8-4-4-4-4 1.8-4 4 1.8 4 4 4zM12 16c-3.3 0-6 2.7-6 6v1h12v-1c0-3.3-2.7-6-6-6zm6.4-5.6a1 1 0 00-1.4 0l-2.6 2.6-1.2-1.2a1 1 0 00-1.4 1.4l2 2a1 1 0 001.4 0l3-3a1 1 0 000-1.4z" />
                        </svg>
                        <span class="text-lg">Add Member</span>
                    </a>
                </li>
                <li  >
                    <a href="report.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition-colors hover:text-red-100 duration-300 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9h4M8 13h4m1 8H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a2 2 0 011.414.586l3.828 3.828A2 2 0 0118 10.414V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-lg">Reports</span>
                    </a>
                </li>
                <li id="nav-expenses">
                    <a href="expenses.php" class="block py-2 px-4 rounded hover:bg-gray-700 transition-colors hover:text-red-100 duration-300 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.11 0-2 .89-2 2s.89 2 2 2 2-.89 2-2-.89-2-2-2zm8 0v2m-1.142 4.481l1.414 1.414M18.657 19l1.415 1.414M16 20h-2v-2M8 20H6v-2M4.929 16.929l-1.415-1.414M4 12H2v-2M4.929 7.071l-1.414-1.415M8 4h2V2"/>
                        </svg>
                        <span class="text-lg">Expenses</span>
                    </a>
                </li>
            </ul>
            <!-- Footer -->
            <div class="mt-auto p-4 bg-gray-800">
             <form action="index.php" method="POST">
                    <button type="submit" name="logout" class="block py-4 px-16 text-center rounded hover:bg-red-700 text-white hover:text-white-200 tranwhitesition-colors duration-300 flex items-center justify-center">
                        <svg class="w-6 h-6 mr-3 text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m4-4v8"/>
                        </svg>
                        <span class="text-lg">Logout</span>
                    </button>
                </form>
            </div>
        </nav>`;
}

export default Navbar;