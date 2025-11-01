<?php
session_start();
include('../../database/db_config.php');

if(!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['user_' . $user_id . '_attendees'] = $_POST;
}
?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <title>Event Reservation for Event Organizer</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="." />
    <meta name="keywords" content="." />
    <meta name="author" content="Sniper 2025" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="../assets/images/ERFEOlogo.png">
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/css_darkmode/events_dm.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/responsive/events.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/main/events.css" id="main-style-link" />
</head>
<body class="w-full overflow-x-hidden">

  <!-- Preloader -->
  <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
    <div class="loader-track h-[5px] w-full absolute top-0 overflow-hidden">
      <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
    </div>
  </div>
<?php include '../includes/header.php'; ?>

<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header flex items-center py-4 px-6 h-header-height">
            <a href="#" class="b-brand flex items-center gap-3">
                <img src="../assets/images/ERFEOlogo.png" alt="logo here" />
            </a>
        </div>
        <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
            <div class="shrink-0 flex items-center justify-start mb-5">&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="../users/profileusers.php" class="admin-profile-link flex items-center gap-2 text-[15px] font-medium">
                    <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="w-10 h-10 rounded-full object-cover" />
                    <?= htmlspecialchars($username) ?>
                </a>
            </div>
            <div class="grow ms-3 text-center mb-4"></div>
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="../booking pages/set_schedule.php" class="pc-link">
                        <span class="pc-micon"><i data-feather="calendar"></i></span>
                        <span class="pc-mtext">Set Schedule</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="../booking pages/event_type.php" class="pc-link">
                        <span class="pc-micon"><i data-feather="layers"></i></span>
                        <span class="pc-mtext">Event Type</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="../booking pages/attendees.php" class="pc-link">
                        <span class="pc-micon"><i data-feather="users"></i></span>
                        <span class="pc-mtext">Attendees</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="../booking pages/menu.php" class="pc-link">
                        <span class="pc-micon"><i data-feather="coffee"></i></span>
                        <span class="pc-mtext">Menu</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="../booking pages/decorations.php" class="pc-link">
                        <span class="pc-micon"><i data-feather="droplet"></i></span>
                        <span class="pc-mtext">Decorations</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="../booking pages/sound_system.php" class="pc-link">
                        <span class="pc-micon"><i data-feather="volume-2"></i></span>
                        <span class="pc-mtext">Sound System</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="../booking pages/receipt.php" class="pc-link">
                        <span class="pc-micon"><i data-feather="printer"></i></span>
                        <span class="pc-mtext">Receipt Printing</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label>Settings</label><i data-feather="wrench"></i>
                </li>
                <li class="pc-item">
                    <a href="../booking pages/view_all_bookings.php" class="pc-link active">
                        <span class="pc-micon"><i data-feather="file-text"></i></span>
                        <span class="pc-mtext">View All Bookings</span>
                    </a>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="../authentication/logout.php" class="pc-link">
                        <span class="pc-micon"><i data-feather="log-out"></i></span>
                        <span class="pc-mtext">Log Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="main-content">
    <form id="reservationForm" action="menu.php" method="post" class="flex-1">
        <div class="content-section border-[5px] border-[#BF9374] bg-[#F9F9FB] p-5" id="guest-count-section">
            <h2 class="text-[25px] mb-[5px] text-black font-['Poppins']">Manage Attendees</h2>
            <p class="text-[17px] text-black mb-[5px] font-['Poppins']">Set your guest count and organize attendees by category.</p>
            
            <!-- EXPECTED TOTAL GUESTS SECTION -->
            <div class="guest-categorization grid grid-cols-2 gap-8 mb-4">
                <div class="total-guest-box border border-black rounded-[10px] bg-white p-4 flex flex-col items-start w-[520px] mb-5">
                    <h4 class="text-left text-[18px] my-[5px] text-black font-['Poppins']">Expected Total Guests</h4>
                    <div class="counter text-[20px] flex justify-start gap-[5px]">
                        <button type="button" id="decrement-total" class="decrement p-[5px_10px] bg-[#d0c9c9] border border-black rounded-[10px] cursor-pointer w-[50px] font-['Poppins'] text-black hover:bg-[#b8b0b0]">-</button>
                        <input type="number" class="value w-[40px] ml-[10px] text-center text-[17px] text-black font-['Poppins']" id="total_guests_value" value="0" min="0" max="1000">
                        <button type="button" id="increment-total" class="increment p-[5px_10px] bg-[#d0c9c9] border border-black rounded-[10px] cursor-pointer w-[50px] font-['Poppins'] text-black hover:bg-[#b8b0b0]">+</button>
                    </div>
                </div>
            </div>

            <!-- GUEST CATEGORIES SECTION -->
            <div class="guest-categorization pt-[-20px] grid grid-cols-2 gap-8">
                <div class="guest-category flex justify-between items-center bg-white text-black p-4 rounded-[10px] border border-black gap-12" data-category="Family">
                    <h4 class="text-black text-[18px] font-['Poppins']">Family <span class="guest-count">0</span> Guest</h4>
                    <div class="counter text-[18px] flex items-center gap-[5px]">
                        <button type="button" class="decrement p-[5px_10px] bg-[#d0c9c9] border border-black rounded-[10px] cursor-pointer w-[50px] font-['Poppins'] text-black hover:bg-[#b8b0b0]">-</button>
                        <input type="number" class="value w-[30px] ml-[10px] text-center text-black font-['Poppins']" value="0" min="0">
                        <button type="button" class="increment p-[5px_10px] bg-[#d0c9c9] border border-black rounded-[10px] cursor-pointer w-[50px] font-['Poppins'] text-black hover:bg-[#b8b0b0]">+</button>
                    </div>
                </div>
                
                <div class="guest-category flex justify-between items-center bg-white text-black p-4 rounded-[10px] border border-black gap-12" data-category="Friends">
                    <h4 class="text-black text-[18px] font-['Poppins']">Friends <span class="guest-count">0</span> Guest</h4>
                    <div class="counter text-[18px] flex items-center gap-[5px]">
                        <button type="button" class="decrement p-[5px_10px] bg-[#d0c9c9] border border-black rounded-[10px] cursor-pointer w-[50px] font-['Poppins'] text-black hover:bg-[#b8b0b0]">-</button>
                        <input type="number" class="value w-[30px] ml-[10px] text-center text-black font-['Poppins']" value="0" min="0">
                        <button type="button" class="increment p-[5px_10px] bg-[#d0c9c9] border border-black rounded-[10px] cursor-pointer w-[50px] font-['Poppins'] text-black hover:bg-[#b8b0b0]">+</button>
                    </div>
                </div>
                
                <div class="guest-category flex justify-between items-center bg-white text-black p-4 rounded-[10px] border border-black gap-12" data-category="Colleagues">
                    <h4 class="text-black text-[18px] font-['Poppins']">Colleagues <span class="guest-count">0</span> Guest</h4>
                    <div class="counter text-[18px] flex items-center gap-[5px]">
                        <button type="button" class="decrement p-[5px_10px] bg-[#d0c9c9] border border-black rounded-[10px] cursor-pointer w-[50px] font-['Poppins'] text-black hover:bg-[#b8b0b0]">-</button>
                        <input type="number" class="value w-[30px] ml-[10px] text-center text-black font-['Poppins']" value="0" min="0">
                        <button type="button" class="increment p-[5px_10px] bg-[#d0c9c9] border border-black rounded-[10px] cursor-pointer w-[50px] font-['Poppins'] text-black hover:bg-[#b8b0b0]">+</button>
                    </div>
                </div>
                
                <div class="guest-category flex justify-between items-center bg-white text-black p-4 rounded-[10px] border border-black gap-12" data-category="VIP Guests">
                    <h4 class="text-black text-[18px] font-['Poppins']">VIP Guests <span class="guest-count">0</span> Guest</h4>
                    <div class="counter text-[18px] flex items-center gap-[5px]">
                        <button type="button" class="decrement p-[5px_10px] bg-[#d0c9c9] border border-black rounded-[10px] cursor-pointer w-[50px] font-['Poppins'] text-black hover:bg-[#b8b0b0]">-</button>
                        <input type="number" class="value w-[30px] ml-[10px] text-center text-black font-['Poppins']" value="0" min="0">
                        <button type="button" class="increment p-[5px_10px] bg-[#d0c9c9] border border-black rounded-[10px] cursor-pointer w-[50px] font-['Poppins'] text-black hover:bg-[#b8b0b0]">+</button>
                    </div>
                </div>
            </div>

            <div class="guest-summary w-[70%] flex justify-between items-center my-4 mx-auto p-[10px_30px] border border-black rounded-[10px] text-[20px] text-black bg-white font-['Poppins']">
                <strong>Total Guests:</strong>
                <div class="totals w-[100px] h-[30px] rounded-[10px] bg-[#d0c9c9] border border-black flex justify-center items-center">
                    <span id="total-categorized" class="p-0 text-base text-black font-['Poppins']">0</span>/<span id="total-expected" class="p-0 text-base text-black font-['Poppins']">0</span>
                </div>
            </div>
            
            <input type="hidden" name="attendee_categories" id="attendee_categories_input">
            <input type="hidden" name="total_expected_guests" id="total_expected_guests_input" value="0">
            
            <button type="button" id="confirm-attendees-btn" class="confirm-phase-btn w-[25%] p-3 mt-5 bg-[#0fdf3cff] text-black border border-black rounded-[10px] text-base cursor-pointer ml-[400px] font-['Poppins'] hover:bg-[#0c8b28] transition-colors" data-phase-target="menu-section">
                Confirm Attendees & Proceed
            </button>
        </div>
    </form>
</main>

<?php include '../includes/footer.php'; ?>

<script src="../assets/js/booking_system.js"></script>
<script src="../assets/js/plugins/simplebar.min.js"></script>
<script src="../assets/js/plugins/popper.min.js"></script>
<script src="../assets/js/icon/custom-icon.js"></script>
<script src="../assets/js/plugins/feather.min.js"></script>
<script src="../assets/js/component.js"></script>
<script src="../assets/js/theme.js"></script>
<script src="../assets/js/script.js"></script>
<script src="../assets/js/sidebar-bookings.js"></script>
<div class="floting-button fixed bottom-[50px] right-[30px] z-[1030]"></div>

<script>
    // Pass user_id to JavaScript
    const user_id = <?php echo $user_id; ?>;
    
    layout_theme_sidebar_change('dark');
    change_box_container('false');
    layout_caption_change('true');
    layout_rtl_change('false');
    preset_change('preset-1');
    main_layout_change('vertical');
</script>
</body>
</html>
<?php
?>