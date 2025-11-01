<?php
session_start();
include('../../database/db_config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reservation for Event Organizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../assets/images/ERFEOlogo.png">
    <link rel="stylesheet" href="../assets/css/css_darkmode/aboutus_dm.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/responsive/aboutus.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/main/aboutus.css" id="main-style-link" />
</head>
<body class="min-h-screen">
  <!-- Preloader -->
  <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
    <div class="loader-track h-[5px] w-full absolute top-0 overflow-hidden">
      <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
    </div>
  </div>

<!-- NAVBAR -->
<nav class="bg-[#BF9374] flex justify-between items-center px-[30px] py-[12px] shadow-lg sticky top-0 z-50">
    <div class="flex items-center">
        <img src="../assets/images/ERFEOlogo.png" alt="Logo" class="h-[45px] w-[45px] rounded-[8px] mr-[10px]">
    </div>

    <ul class="flex items-center gap-[40px] flex-1 justify-end list-none">
        <li><a href="../../landingpage/index.php" class="text-[#333333] text-[15px] tracking-[0.5px] no-underline transition-colors duration-300 hover:text-[#f4e3d7] font-medium">HOME</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="../booking pages/set_schedule.php" class="text-[#333333] text-[15px] tracking-[0.5px] no-underline transition-colors duration-300 hover:text-[#f4e3d7]">BOOKING</a></li>
        <?php else: ?>
            <li><a href="#" onclick="showLogin()" class="text-[#333333] text-[15px] tracking-[0.5px] no-underline transition-colors duration-300 hover:text-[#f4e3d7]">LOG IN</a></li>
        <?php endif; ?>

        <li><a href="../users/aboutus.php" class="text-[#333333] text-[15px] tracking-[0.5px] no-underline transition-colors duration-300 hover:text-[#f4e3d7]">ABOUT US</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
        <li class="relative">
            <a href="javascript:void(0)" class="flex items-center" onclick="toggleAccountDropdown()">
                <img src="../assets/images/accicon.png" alt="Account Icon" class="w-[45px] h-[45px] rounded-full object-cover cursor-pointer">
            </a>
            <ul id="accountDropdown" class="absolute top-[58px] right-0 min-w-[120px] overflow-hidden z-50 bg-transparent hidden">
                <li><a href="../users/inbox.php" class="no-underline text-black text-center block px-[20px] py-[12px] transition-colors duration-300 bg-[#E2C7AE] mt-[10px] rounded-[5px] border border-black hover:bg-[#d4b99a]">INBOX</a></li>
                <li><a href="../authentication/logout.php" class="no-underline text-black text-center block px-[20px] py-[12px] transition-colors duration-300 bg-[#E2C7AE] mt-[10px] rounded-[5px] border border-black hover:bg-[#d4b99a]">LOG OUT</a></li>
            </ul>
        </li>
        <?php endif; ?>
    </ul>
</nav>

<!-- MAIN CONTENT -->
<div class="py-[60px] px-[20px] max-w-[1200px] mx-auto">
    <div class="bg-white rounded-[25px] p-[50px] shadow-2xl card-animation">
        
        <!-- PAGE HEADER -->
        <div class="text-center mb-[50px] relative">
            <div class="page-block">
                <div class="page-header-title">
                    <h5 class="mb-0 font-medium text-[32px] font-bold text-black uppercase tracking-[1px]">About Us</h5>
                </div>
            </div>
        </div>

        <!-- WELCOME CARD -->
        <div class="bg-white rounded-[20px] p-[40px] mb-[35px] border-l-[5px] border-[#BF9374] shadow-lg card-animation">
            <div class="card-body">
                <h2 class="text-center mb-[20px] text-[2rem] font-black text-black">Welcome to Event Reservation for Event Organization</h2>
                <p class="text-center text-[#4c4c4c] text-[1.05rem] leading-[1.8]">
                    This website allows organizers to schedule events, accept reservations from clients or attendees,
                    monitor availability, and coordinate logistics, making the overall planning process more efficient and organized.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-[25px] mt-[2rem]">
                    <!-- PURPOSE BOX -->
                    <div class="p-[30px] rounded-[15px] info-box shadow-md card-animation">
                        <h5 class="font-bold mb-[15px] text-[1.3rem] text-black text-left">Purpose</h5>
                        <p class="text-[#4c4c4c] text-[1.05rem] leading-[1.8]">
                            It helps customers easily book an event anytime instead of calling in a person.
                            Automates tasks like booking schedules, confirming reservations, and sending reminders,
                            saving time and reducing manual errors.
                        </p>
                    </div>

                    <!-- WHAT YOU'LL FIND BOX -->
                    <div class="p-[30px] rounded-[15px] info-box shadow-md card-animation">
                        <h5 class="font-bold mb-[15px] text-[1.3rem] text-black text-left">What You'll Find Here</h5>
                        <ul class="list-disc ml-[25px] mt-[10px]">
                            <li class="text-[#4c4c4c] text-[1.05rem] mb-[8px] relative">Overview of organizer's services</li>
                            <li class="text-[#4c4c4c] text-[1.05rem] mb-[8px] relative">Types of events</li>
                            <li class="text-[#4c4c4c] text-[1.05rem] mb-[8px] relative">Input attendees</li>
                            <li class="text-[#4c4c4c] text-[1.05rem] mb-[8px] relative">Select menu after choosing an event</li>
                            <li class="text-[#4c4c4c] text-[1.05rem] mb-[8px] relative">Choose event decorations</li>
                            <li class="text-[#4c4c4c] text-[1.05rem] mb-[8px] relative">Display and print receipt</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- TEAM CARD -->
        <div class="bg-white rounded-[20px] p-[40px] mb-[35px] border-l-[5px] border-[#BF9374] shadow-lg card-animation mt-[2rem]">
            <div class="card-body">
                <h5 class="text-center mb-[20px] font-bold text-[1.5rem] text-black">Who Made this Website</h5>
                <div class="overflow-x-auto rounded-[15px]">
                    <table class="w-full border-collapse border-spacing-0 text-left">
                        <tbody>
                            <tr class="table-row-even"><td class="px-[20px] py-[18px] text-[1rem] text-[#4a3a2e] font-[500] border-b border-[rgba(0,0,0,0.05)] border-l-[4px] border-[#BF9374] font-bold text-black">Reallyne Alexa Bautista</td><td class="px-[20px] py-[18px] text-[1rem] text-[#4a3a2e] font-[500] border-b border-[rgba(0,0,0,0.05)]">Project Manager</td></tr>
                            <tr><td class="px-[20px] py-[18px] text-[1rem] text-[#4a3a2e] font-[500] border-b border-[rgba(0,0,0,0.05)] border-l-[4px] border-[#BF9374] font-bold text-black">Angelica Chereese Ramirez</td><td class="px-[20px] py-[18px] text-[1rem] text-[#4a3a2e] font-[500] border-b border-[rgba(0,0,0,0.05)]">System Analytics</td></tr>
                            <tr class="table-row-even"><td class="px-[20px] py-[18px] text-[1rem] text-[#4a3a2e] font-[500] border-b border-[rgba(0,0,0,0.05)] border-l-[4px] border-[#BF9374] font-bold text-black">Ryn Aldrich Capinpin</td><td class="px-[20px] py-[18px] text-[1rem] text-[#4a3a2e] font-[500] border-b border-[rgba(0,0,0,0.05)]">Database Administrator</td></tr>
                            <tr><td class="px-[20px] py-[18px] text-[1rem] text-[#4a3a2e] font-[500] border-b border-[rgba(0,0,0,0.05)] border-l-[4px] border-[#BF9374] font-bold text-black">Joshua Dizon</td><td class="px-[20px] py-[18px] text-[1rem] text-[#4a3a2e] font-[500] border-b border-[rgba(0,0,0,0.05)]">Programmer</td></tr>
                            <tr class="table-row-even"><td class="px-[20px] py-[18px] text-[1rem] text-[#4a3a2e] font-[500] border-b border-[rgba(0,0,0,0.05)] border-l-[4px] border-[#BF9374] font-bold text-black">Kyla Buenavista</td><td class="px-[20px] py-[18px] text-[1rem] text-[#4a3a2e] font-[500] border-b border-[rgba(0,0,0,0.05)]">Documentation</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- CONTACTS CARD -->
        <div class="bg-white rounded-[20px] p-[40px] mb-[35px] border-l-[5px] border-[#BF9374] shadow-lg card-animation mt-[2rem] bg-gradient-to-br from-white to-[#fafafa]">
            <div class="card-body">
                <h5 class="text-center font-bold text-[1.5rem] text-black mb-[15px]">CONTACTS</h5>
                <p class="text-[#4c4c4c] text-[1.1rem] mb-[12px]"><strong class="text-black font-bold">Address:</strong> 28WV+R2R, Arellano St, Dagupan City, 2400 Pangasinan</p>
                <p class="text-[#4c4c4c] text-[1.1rem] mb-[12px]"><strong class="text-black font-bold">Email:</strong> EventResFEO@gmail.com</p>
                <p class="text-[#4c4c4c] text-[1.1rem] mb-[12px]"><strong class="text-black font-bold">Phone:</strong> +63 912 345 6789</p>
            </div>
        </div>
    </div>
</div>

<!-- MODALS (Same as your previous modals) -->
<!-- REGISTER MODAL -->
<div class="modal-backdrop fixed inset-0 bg-black bg-opacity-70 z-[10000] hidden justify-center items-center backdrop-blur-sm" id="registerModal">
    <div class="modal-content bg-white text-black p-[40px] rounded-[20px] w-[90%] max-w-[450px] text-base relative text-left shadow-2xl">
        <span class="close-btn absolute top-[15px] right-[20px] text-[2rem] cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeModal('registerModal')">&times;</span>
        <div class="modal-header text-center mb-[25px]"><h4 class="text-[1.8rem] font-extrabold">Create a New Account</h4></div>
        <form action="../authentication/register.php" method="post">
            <label class="text-[0.9rem] font-bold mb-[8px] block">Username</label>
            <input type="text" name="username" placeholder="Enter Username" 
                class="w-full p-[14px] my-[10px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-white focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)]" required>

            <label class="text-[0.9rem] font-bold mb-[8px] block">Password</label>
            <div class="relative">
                <input type="password" name="password" placeholder="Enter Password" 
                    class="w-full p-[14px] my-[10px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-white focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)] pr-12" required>
                <span class="password-toggle absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500 hover:text-gray-700">
                    <i class="ph ph-eye"></i>
                </span>
            </div>

            <label class="text-[0.9rem] font-bold mb-[8px] block">Confirm Password</label>
            <div class="relative">
                <input type="password" name="confirm_password" placeholder="Confirm Password" 
                    class="w-full p-[14px] my-[10px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-white focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)] pr-12" required>
                <span class="password-toggle absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500 hover:text-gray-700">
                    <i class="ph ph-eye"></i>
                </span>
            </div>

            <button type="submit" class="modal-btn w-full p-[14px] mt-[20px] border-none rounded-[10px] bg-gradient-to-r from-[#28a745] to-[#20c997] hover:from-[#239d3f] hover:to-[#1cb386] text-white text-base font-bold cursor-pointer uppercase">Register</button>
            <button type="button" class="modal-btn w-full p-[14px] mt-[20px] border-none rounded-[10px] bg-gradient-to-r from-[#28a745] to-[#20c997] hover:from-[#239d3f] hover:to-[#1cb386] text-white text-base font-bold cursor-pointer uppercase" onclick="showLogin()">Back to Login</button>
        </form>
    </div>
</div>

<!-- LOGIN MODAL -->
<div class="modal-backdrop fixed inset-0 bg-black bg-opacity-70 z-[10000] hidden justify-center items-center backdrop-blur-sm" id="loginModal">
    <div class="modal-content bg-white text-black p-[40px] rounded-[20px] w-[90%] max-w-[450px] text-base relative text-left shadow-2xl">
        <span class="close-btn absolute top-[15px] right-[20px] text-[2rem] cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeModal('loginModal')">&times;</span>
        <div class="modal-header text-center mb-[25px]"><h4 class="text-[1.8rem] font-extrabold">Log in to Your Account</h4></div>
        <form action="../authentication/login.php" method="post">
            <label class="text-[0.9rem] font-bold mb-[8px] block">Username</label>
            <input type="text" name="username" placeholder="Enter Username" 
                class="w-full p-[14px] my-[10px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-white focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)]" required>

            <label class="text-[0.9rem] font-bold mb-[8px] block">Password</label>
            <div class="relative">
                <input type="password" name="password" placeholder="Enter Password" 
                    class="w-full p-[14px] my-[10px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-white focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)] pr-12" required>
                <span class="password-toggle absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500 hover:text-gray-700">
                    <i class="ph ph-eye"></i>
                </span>
            </div>

            <button type="submit" class="modal-btn w-full p-[14px] mt-[20px] border-none rounded-[10px] bg-gradient-to-r from-[#28a745] to-[#20c997] hover:from-[#239d3f] hover:to-[#1cb386] text-white text-base font-bold cursor-pointer uppercase">Login</button>
            
            <div class="flex justify-between mt-4">
                <button type="button" class="btn bg-transparent text-black border-none text-[0.8rem] hover:text-gray-700" onclick="showRegister()">Create Account</button>
                <button type="button" class="btn bg-transparent text-black border-none text-[0.8rem] hover:text-gray-700" onclick="showForgotPassword()">Forgot Password?</button>
            </div>

            <div class="text-center mt-4">
                <button type="button" class="btn bg-transparent text-black border-none text-[0.8rem] hover:text-gray-700 text-center" onclick="showAdminLogin()">Admin Login</button>
            </div>
        </form>
    </div>
</div>

<!-- FORGOT PASSWORD MODAL -->
<div class="modal-backdrop fixed inset-0 bg-black bg-opacity-70 z-[10000] hidden justify-center items-center backdrop-blur-sm" id="forgotPasswordModal">
    <div class="modal-content bg-white text-black p-[40px] rounded-[20px] w-[90%] max-w-[450px] text-base relative text-left shadow-2xl">
        <span class="close-btn absolute top-[15px] right-[20px] text-[2rem] cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeModal('forgotPasswordModal')">&times;</span>
        <div class="modal-header text-center mb-[25px]">
            <h4 class="text-[1.8rem] font-extrabold">Forgot Password</h4>
        </div>
        <form>
            <label class="text-[0.9rem] font-bold mb-[8px] block">Enter your username</label>
            <input type="text" name="username" placeholder="Enter Username" 
                class="w-full p-[14px] my-[10px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-white focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)]" required>
            <button type="submit" class="modal-btn w-full p-[14px] mt-[20px] border-none rounded-[10px] bg-gradient-to-r from-[#28a745] to-[#20c997] hover:from-[#239d3f] hover:to-[#1cb386] text-white text-base font-bold cursor-pointer uppercase">Verify Username</button>
        </form>
        <div class="text-center mt-4">
            <button onclick="showLogin()" class="text-[#BF9374] hover:underline">Back to Login</button>
        </div>
    </div>
</div>

<!-- RESET PASSWORD MODAL -->
<div class="modal-backdrop fixed inset-0 bg-black bg-opacity-70 z-[10000] hidden justify-center items-center backdrop-blur-sm" id="resetPasswordModal">
    <div class="modal-content bg-white text-black p-[40px] rounded-[20px] w-[90%] max-w-[450px] text-base relative text-left shadow-2xl">
        <span class="close-btn absolute top-[15px] right-[20px] text-[2rem] cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeModal('resetPasswordModal')">&times;</span>
        <div class="modal-header text-center mb-[25px]">
            <h4 class="text-[1.8rem] font-extrabold">Reset Password</h4>
        </div>
        <form>
            <label class="text-[0.9rem] font-bold mb-[8px] block">Enter New Password</label>
            <div class="relative">
                <input type="password" name="new_password" placeholder="Enter New Password" 
                    class="w-full p-[14px] my-[10px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-white focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)] pr-12" required>
                <span class="password-toggle absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500 hover:text-gray-700">
                    <i class="ph ph-eye"></i>
                </span>
            </div>

            <label class="text-[0.9rem] font-bold mb-[8px] block">Confirm Password</label>
            <div class="relative">
                <input type="password" name="confirm_password" placeholder="Confirm Password" 
                    class="w-full p-[14px] my-[10px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-white focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)] pr-12" required>
                <span class="password-toggle absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500 hover:text-gray-700">
                    <i class="ph ph-eye"></i>
                </span>
            </div>

            <button type="submit" class="modal-btn w-full p-[14px] mt-[20px] border-none rounded-[10px] bg-gradient-to-r from-[#28a745] to-[#20c997] hover:from-[#239d3f] hover:to-[#1cb386] text-white text-base font-bold cursor-pointer uppercase">Reset Password</button>
        </form>
        <div class="text-center mt-4">
            <button onclick="showForgotPassword()" class="text-[#BF9374] hover:underline">Back to Forgot Password</button>
        </div>
    </div>
</div>

<!-- ADMIN LOGIN MODAL -->
<div class="modal-backdrop fixed inset-0 bg-black bg-opacity-70 z-[10000] hidden justify-center items-center backdrop-blur-sm" id="adminModal">
    <div class="modal-content bg-white text-black p-[40px] rounded-[20px] w-[90%] max-w-[450px] text-base relative text-left shadow-2xl">
        <span class="close-btn absolute top-[15px] right-[20px] text-[2rem] cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeModal('adminModal')">&times;</span>
        <div class="modal-header text-center mb-[25px]"><h4 class="text-[1.8rem] font-extrabold">Admin Login</h4></div>
        <form action="../dist/authentication/admin_login.php" method="post">
            <label class="text-[0.9rem] font-bold mb-[8px] block">Admin Username</label>
            <input type="text" name="username" placeholder="Enter Admin Username" 
                class="w-full p-[14px] my-[10px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-white focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)]" required>

            <label class="text-[0.9rem] font-bold mb-[8px] block">Admin Password</label>
            <div class="relative">
                <input type="password" name="password" placeholder="Enter Admin Password" 
                    class="w-full p-[14px] my-[10px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-white focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)] pr-12" required>
                <span class="password-toggle absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500 hover:text-gray-700">
                    <i class="ph ph-eye"></i>
                </span>
            </div>

            <button type="submit" class="modal-btn w-full p-[14px] mt-[20px] border-none rounded-[10px] bg-gradient-to-r from-[#28a745] to-[#20c997] hover:from-[#239d3f] hover:to-[#1cb386] text-white text-base font-bold cursor-pointer uppercase">Login as Admin</button>
            <button type="button" class="btn bg-transparent text-black border-none text-[0.8rem] px-[33.5px] mt-[20px] hover:text-gray-700" onclick="showLogin()">Back to User Login</button>
        </form>
    </div>
</div>

<!-- FOOTER -->
<footer class="bg-[#BF9374] text-white py-[20px] w-full relative bottom-0 shadow-lg z-10 flex justify-center items-center text-center">
    <div class="footer-wrapper w-full max-w-[1200px] mx-auto px-[20px]">
        <div class="flex justify-center items-center flex-wrap text-center">
            <div class="w-full sm:w-1/2 my-1">
                <p class="m-0 text-[#333333] text-[14px] tracking-[0.3px]">©2025 EVENT RESERVATION FOR EVENT ORGANIZER. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- SCRIPTS -->
<script src="../assets/js/plugins/simplebar.min.js"></script>
<script src="../assets/js/plugins/popper.min.js"></script>
<script src="../assets/js/icon/custom-icon.js"></script>
<script src="../assets/js/plugins/feather.min.js"></script>
<script src="../assets/js/component.js"></script>
<script src="../assets/js/theme.js"></script>
<script src="../assets/js/script.js"></script>
<script src="../assets/js/aboutus.js"></script>
<script>    
    layout_theme_sidebar_change('dark');
    change_box_container('false');
    layout_caption_change('true');
    layout_rtl_change('false');
    preset_change('preset-1');
    main_layout_change('vertical');
</script>
</body>
</html>