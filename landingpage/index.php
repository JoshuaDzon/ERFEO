<?php
session_start();
include('../database/db_config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reservation for Event Organizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link rel="stylesheet" href="../dist/assets/css/css_darkmode/index_dm.css" id="main-style-link" />
    <link rel="icon" type="image/png" href="../dist/assets/images/ERFEOlogo.png">
    <link rel="stylesheet" href="../dist/assets/css/css_darkmode/index_dm.css">
    <link rel="stylesheet" href="../dist/assets/css/responsive/index.css" id="responsive-style" />
    <link rel="stylesheet" href="../dist/assets/css/main/index.css" id="main-style" />

</head>
<body class="w-full overflow-x-hidden">

<!-- NAVBAR -->
<nav class="bg-[#BF9374] flex justify-between items-center px-[30px] py-[12px] shadow-lg sticky top-0 z-100">
    <div class="flex items-center">
        <img src="../dist/assets/images/ERFEOlogo.png" alt="Logo" class="h-[45px] w-[45px] rounded-[8px] mr-[10px]">
    </div>
    <ul class="flex items-center gap-[40px] flex-1 justify-end list-none">
        <li><a href="index.php" class="text-[#333333] text-[15px] tracking-[0.5px] no-underline transition-colors duration-300 hover:text-[#f4e3d7] font-medium">HOME</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="../dist/booking pages/set_schedule.php" class="text-[#333333] text-[15px] tracking-[0.5px] no-underline transition-colors duration-300 hover:text-[#f4e3d7]">BOOKING</a></li>
        <?php else: ?>
            <li><a href="#" onclick="showLogin()" class="text-[#333333] text-[15px] tracking-[0.5px] no-underline transition-colors duration-300 hover:text-[#f4e3d7]">LOG IN</a></li>
        <?php endif; ?>

        <li><a href="../dist/users/aboutus.php" class="text-[#333333] text-[15px] tracking-[0.5px] no-underline transition-colors duration-300 hover:text-[#f4e3d7]">ABOUT US</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
        <li class="relative">
            <a href="javascript:void(0)" class="flex items-center" onclick="toggleAccountDropdown()">
                <img src="../dist/assets/images/accicon.png" alt="Account Icon" class="w-[45px] h-[45px] rounded-full object-cover cursor-pointer">
            </a>
            <ul id="accountDropdown" class="absolute top-[58px] right-0 min-w-[120px] overflow-hidden z-100 bg-transparent hidden">
                <li><a href="../dist/users/inbox.php" class="no-underline text-black text-center block px-[20px] py-[12px] transition-colors duration-300 bg-[#E2C7AE] mt-[10px] rounded-[5px] border border-black hover:bg-[#d4b99a]">INBOX</a></li>
                <li><a href="../dist/authentication/logout.php" class="no-underline text-black text-center block px-[20px] py-[12px] transition-colors duration-300 bg-[#E2C7AE] mt-[10px] rounded-[5px] border border-black hover:bg-[#d4b99a]">LOG OUT</a></li>
            </ul>
        </li>
        <?php endif; ?>
    </ul>
</nav>

<!-- HERO SECTION -->
<main class="text-white flex flex-col justify-center items-center text-center">
    <div class="hero-content">
        <h1 class="mt-[45px] text-white text-[55px]">WELCOME TO ERFEO</h1>
        <p class="text-[35px] text-white mt-2">Making Every Event Memorable</p>
        <p class="text-[35px] text-white mt-1">Plan, reserve, and celebrate your events with ease</p>
    </div>
</main>

<!-- FEATURED EVENTS & FEEDBACK -->
<section class="mt-[70px] w-full bg-[#F9F9FB] py-[30px]">
    <section class="bg-[#F9F9FB] text-center">
        <h3 class="text-[1.5rem] text-[#7B5C40] font-bold mb-[20px] tracking-[1px]">Featured Events</h3>
        <div class="bg-white w-[90%] grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-[25px] justify-items-center ml-[75px] p-[20px] rounded-[12px] shadow-lg border border-[#E5E5E5]">
            <div class="event-card w-[90%] rounded-[10px] overflow-hidden bg-white shadow-md transition-all duration-300 hover:shadow-xl">
                <img src="../dist/assets/images/event1.png" alt="Pink Event Setup" class="w-full h-[140px] object-cover border-b border-[#E5E5E5]">
            </div>
            <div class="event-card w-[90%] rounded-[10px] overflow-hidden bg-white shadow-md transition-all duration-300 hover:shadow-xl">
                <img src="../dist/assets/images/event2.png" alt="White Wedding Setup" class="w-full h-[140px] object-cover border-b border-[#E5E5E5]">
            </div>
            <div class="event-card w-[90%] rounded-[10px] overflow-hidden bg-white shadow-md transition-all duration-300 hover:shadow-xl">
                <img src="../dist/assets/images/event3.png" alt="Outdoor Picnic Setup" class="w-full h-[140px] object-cover border-b border-[#E5E5E5]">
            </div>
            <div class="event-card w-[90%] rounded-[10px] overflow-hidden bg-white shadow-md transition-all duration-300 hover:shadow-xl">
                <img src="../dist/assets/images/event4.png" alt="Graduation Setup" class="w-full h-[140px] object-cover border-b border-[#E5E5E5]">
            </div>
        </div>
    </section>

    <?php if (isset($_SESSION['user_id'])): ?>
    <!-- THOUGHTS SECTION -->
    <section class="py-[25px] flex justify-center bg-[#F9F9FB]">
        <div class="thoughts-box w-[93%] bg-white p-[30px_40px] rounded-[12px] text-center shadow-lg border border-[#E5E5E5]">
            <h4 class="text-[1.5rem] text-[#7B5C40] mb-[15px] font-semibold">Share Your Thoughts</h4>
            <div id="commentsContainer" class="w-full max-h-[200px] overflow-y-auto overflow-x-hidden flex flex-col gap-[10px] mb-[20px] pr-[5px] rounded-[8px]"></div>
            <form id="thoughtsForm" class="flex flex-col gap-[10px]">
                <div class="message-group flex flex-col gap-[10px]">
                    <textarea id="comment_message" name="message" placeholder="Write your message..." 
                        class="w-full min-h-[100px] p-[10px_16px] rounded-[8px] text-base resize-none bg-[#fafafa] border border-gray-300 focus:outline-none focus:border-[#BF9374]"
                        required></textarea>
                    <button type="submit" class="send-btn self-end px-[18px] py-[10px] rounded-[8px] border-none bg-[#BF9374] text-black cursor-pointer font-semibold transition-colors duration-300 hover:bg-[#A47E5F]">Send</button>
                </div>
            </form>
        </div>
    </section>
    <?php endif; ?>
</section>

<!-- REGISTER MODAL -->
<div class="modal-backdrop fixed inset-0 bg-black bg-opacity-70 z-[10000] hidden justify-center items-center backdrop-blur-sm" id="registerModal">
    <div class="modal-content bg-white text-black p-[40px] rounded-[20px] w-[90%] max-w-[450px] text-base relative text-left shadow-2xl">
        <span class="close-btn absolute top-[15px] right-[20px] text-[2rem] cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeModal('registerModal')">&times;</span>
        <div class="modal-header text-center mb-[25px]"><h4 class="text-[1.8rem] font-extrabold">Create a New Account</h4></div>
        <form action="../dist/authentication/register.php" method="post">
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
            <small class="password-note text-[12px] text-black leading-relaxed block my-[4px]">
                Password must contain at least:
                <br>• 1 uppercase letter (A–Z)
                <br>• 1 lowercase letter (a–z)
                <br>• 1 number (0–9)
                <br>• 1 special character (!@#$%^&amp;*)
            </small>

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
        <form action="../dist/authentication/login.php" method="post">
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
                <button type="button" class="btn bg-transparent text-black border-none text-[0.8rem] hover:text-gray-700 text-center" onclick="showAdminLogin()">Login as Admin?</button>
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
<footer class="pc-footer bg-[#BF9374] text-white py-[20px] w-full text-center shadow-lg">
    <div class="flex justify-center items-center">
        <div class="text-center">
            <p class="m-0 text-[#333333] text-[14px] tracking-[0.3px]">©2025 EVENT RESERVATION FOR EVENT ORGANIZER. All Rights Reserved.</p>
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
<script src="../dist/assets/js/index.js"></script>
<script>    
    layout_theme_sidebar_change('dark');
    change_box_container('false');
    layout_caption_change('true');
    layout_rtl_change('false');
    preset_change('preset-1');
    main_layout_change('vertical');
</script>

<?php if(isset($_SESSION['popup'])): ?>
<script>
    alert("<?= $_SESSION['popup']; ?>");
</script>
<?php unset($_SESSION['popup']); endif; ?>

</body>
</html>