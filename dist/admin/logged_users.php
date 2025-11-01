<?php
session_start();
// Include database connection
include('../../database/db_config.php');
// FETCH ALL USERS FROM DATABASE
$sql = "SELECT id, username FROM users ORDER BY id ASC";
$users_result = $conn->query($sql);

// Count total users
$total_users = $users_result->num_rows;

if (isset($_POST['submit'])) {
} else {
?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <title>Event Reservation for Event Organizer</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="../assets/images/ERFEOlogo.png">
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/css_darkmode/logged_users_dm.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/responsive/logged_users.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/main/logged_users.css" id="main-style-link" />
</head>

<body class="font-['Open_Sans']">
<!-- Preloader -->
<div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
    <div class="loader-track h-[5px] w-full absolute top-0 overflow-hidden">
        <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
    </div>
</div>
<!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper flex max-sm:px-[15px] px-[25px] grow">
    <!-- [Mobile Media Block] start -->
    <div class="me-auto pc-mob-drp">
      <ul class="inline-flex *:min-h-header-height *:inline-flex *:items-center">
        <!-- ======= Menu collapse Icon (Desktop) ===== -->
        <li class="pc-h-item pc-sidebar-collapse max-lg:hidden lg:inline-flex">
          <a href="#" class="pc-head-link ltr:!ml-0 rtl:!mr-0" id="sidebar-hide">
            <i data-feather="menu"></i>
          </a>
        </li>
        <!-- ======= Menu collapse Icon (Mobile) ===== -->
        <li class="pc-h-item pc-sidebar-popup lg:hidden">
          <a href="#" class="pc-head-link ltr:!ml-0 rtl:!mr-0" id="mobile-collapse">
            <i data-feather="menu"></i>
          </a>
        </li>
      </ul>
    </div>
    <!-- [Mobile Media Block end] -->
    
    <div class="ms-auto">
      <ul class="inline-flex *:min-h-header-height *:inline-flex *:items-center">
        <!-- Your Navigation Links -->
        <ul class="nav-links" style="display:flex; gap:30px; list-style:none; margin:0; padding:0;">
          <li><a href="../../landingpage/index.php" class="nav-item active">HOME</a></li>
          <li><a href="../users/aboutus.php" class="nav-item">ABOUT US</a></li>
        </ul>

        <!-- ======= Dark/Light Mode Toggle ===== -->
        <li class="dropdown pc-h-item">
          <a class="pc-head-link dropdown-toggle me-0" data-pc-toggle="dropdown" href="#" role="button"
            aria-haspopup="false" aria-expanded="false">
            <i data-feather="sun" id="theme-icon"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
            <a href="#!" class="dropdown-item" onclick="layout_change('dark'); return false;">
              <i data-feather="moon"></i>
              <span>Dark</span>
            </a>
            <a href="#!" class="dropdown-item" onclick="layout_change('light'); return false;">
              <i data-feather="sun"></i>
              <span>Light</span>
            </a>
            <a href="#!" class="dropdown-item" onclick="layout_change_default(); return false;">
              <i data-feather="settings"></i>
              <span>Default</span>
            </a>
          </div>
        </li>
        <!-- Dark mode ends -->

        <!-- ======= User Profile Dropdown ===== -->
        <li class="dropdown pc-h-item header-user-profile">
          <a class="pc-head-link dropdown-toggle arrow-none me-0" data-pc-toggle="dropdown" href="#" role="button"
            aria-haspopup="false" data-pc-auto-close="outside" aria-expanded="false">
            <i data-feather="user"></i>
          </a>
          <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown p-2 overflow-hidden">
            <div class="dropdown-header flex items-center justify-between py-4 px-5 bg-success-500">
              <div class="flex mb-1 items-center">
                <div class="shrink-0">
                  <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="w-10 rounded-full object-cover" />
                </div>
                <div class="grow ms-4">
                  <h4 class="mb-1 text-black font-semibold">
                    <span class="text-black text-sm">Administrator</span>
                  </h4>
                  <span class="text-black text-sm">EventResFEO@gmail.com</span>
                </div>
              </div>
            </div>
            <div class="dropdown-body py-4 px-5">
                <a href="#" class="dropdown-item" onclick="return alert('About this System\n\nSystem Name: Event Reservation System\nDeveloper: Sniper 2025\n\nCopyright © 2025 Software Solutions.\nAll rights reserved.');">
                  <span>
                    <i class="ti ti-headset"></i>
                    <span>Support</span>
                  </span>
                </a>
                <div class="grid my-3">
                  <button class="btn btn-success flex items-center justify-center text-black">
                    <svg class="pc-icon me-2 w-[22px] h-[22px]">
                      <use xlink:href="#custom-logout-1-outline"></use>
                    </svg>
                    <a href="../authentication/logout.php">Log-Out</a>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </li>
        <!-- User Profile Dropdown end -->
      </ul>
    </div>
  </div>
</header>
<!-- [ Header ] end -->
    
    <!-- [ Sidebar Menu ] start -->
    <?php include '../includes/sidebar.php'; ?>
    <!-- [ Sidebar Menu ] end -->

    <!-- Main Content -->
    <div class="ml-[260px] p-10 max-w-[1650px] bg-gradient-to-br from-[#f5f7fa] to-[#e8ecf1] min-h-screen">
        <!-- Header Card -->
        <div class="mt-[50px] header-card bg-gradient-to-r from-[#BF9374] to-[#D4A574] text-black rounded-[20px] p-10 mb-9 shadow-xl relative overflow-hidden">
            <h2 class="m-0 mb-3 text-[2.5rem] text-black relative z-10">Registered Users</h2>
            <p class="m-0 opacity-90 text-[1.1rem] text-black relative z-10">View all users who have registered in the system</p>
        </div>
        
        <!-- Stats Card -->
        <div class="stats-card bg-white rounded-[20px] p-9 mb-9 shadow-lg border-none flex items-center justify-between transition-all duration-300 hover:translate-y-[-5px] hover:shadow-xl relative overflow-hidden">
            <div>
                <h3 class="m-0 text-[3.5rem] bg-gradient-to-r from-[#BF9374] to-[#D4A574] bg-clip-text text-transparent leading-none">
                    <?php echo $total_users; ?>
                </h3>
                <span class="block mt-3 text-black text-[1rem] uppercase tracking-[1px]">Total Registered Users</span>
            </div>
        </div>
        
        <!-- Users Table -->
        <div class="users-table-container bg-white rounded-[20px] p-10 shadow-lg border-none backdrop-blur">
            <h3 class="m-0 mb-8 text-black text-[1.5rem] flex items-center gap-3">User List</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border-spacing-0">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#BF9374] to-[#D4A574]">
                            <th class="p-[18px_25px] text-left text-black text-[0.9rem] uppercase tracking-[1px] border-none rounded-tl-[12px]">User ID</th>
                            <th class="p-[18px_25px] text-left text-black text-[0.9rem] uppercase tracking-[1px] border-none rounded-tr-[12px]">Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($users_result && $users_result->num_rows > 0) {
                            while($user = $users_result->fetch_assoc()): 
                        ?>
                        <tr class="bg-white transition-all duration-300 hover:bg-[#fef5ed] hover:scale-[1.01] hover:shadow-lg">
                            <td class="p-5 px-[25px] border-b border-[#f0f0f0]">
                                <span class="user-id-badge bg-gradient-to-r from-[#BF9374] to-[#D4A574] text-black px-4 py-2 rounded-[25px] text-[0.85rem] inline-block shadow-lg tracking-[0.5px]">
                                    #<?php echo $user['id']; ?>
                                </span>
                            </td>
                            <td class="p-5 px-[25px] border-b border-[#f0f0f0] text-black text-[1.05rem] flex items-center gap-3">
                                <?php echo htmlspecialchars($user['username']); ?>
                            </td>
                        </tr>
                        <?php 
                            endwhile; 
                        } else {
                            echo '<tr><td colspan="2" class="no-data text-center py-[60px] px-10 text-black text-[1.1rem]">No users found in the system.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/icon/custom-icon.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
    <script src="../assets/js/component.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/script.js"></script>
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
<?php } ?>