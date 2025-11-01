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
    $_SESSION['user_' . $user_id . '_schedule'] = $_POST;
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
    <!-- [ Header Topbar ] start -->
    <?php include '../includes/header.php'; ?>
    <!-- [ Header ] end -->

    <!-- Preloader -->
    <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
        <div class="loader-track h-[5px] w-full absolute top-0 overflow-hidden">
            <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
        </div>
    </div>

    <!-- [ Sidebar Menu ] start -->
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
    <!-- [ Sidebar Menu ] end -->

    <!-- [ Main Content ] start -->
    <main class="main-content ml-[224px] w-[88.5%] top-[64px] min-h-[135px] pl-10 pr-10 pt-5 font-['Poppins']">
        <form id="reservationForm" action="event_type.php" method="post" class="flex-1">
            <div class="content-section border-[5px] border-[#BF9374] bg-[#F9F9FB] p-5" id="schedule-section">
                <h2 class="text-[25px] mb-[5px] text-black font-['Poppins']">Choose the Date</h2>
                <p class="text-[17px] text-black mb-[30.5px] font-['Poppins']">Select the date you want to celebrate.</p>
                
                <div class="form-section grid grid-cols-3 gap-6 mb-8" id="datetime-guests-section">
                    <div class="input-group flex flex-col">
                        <label class="text-[15px] mb-[5px] text-black font-['Poppins'] font-bold">Select Event Date:</label>
                        <input type="date" name="event_date" id="event_date_picker" placeholder="Select a Date" 
                            class="p-[10px_12px] border border-black rounded-[10px] text-[15px] font-['Poppins'] text-black focus:outline-none focus:border-[#BF9374]" required>
                    </div>
                    <div class="input-group flex flex-col">
                        <label class="text-[15px] mb-[5px] text-black font-['Poppins'] font-bold">Select Event Time:</label>
                        <input type="time" name="event_time" id="event_time" 
                            class="p-[10px_12px] border border-black rounded-[10px] text-[15px] font-['Poppins'] text-black focus:outline-none focus:border-[#BF9374]" required>
                    </div>
                </div>
                
                <div class="form-section ml-5 mt-8 flex flex-col gap-3 mb-4">
                    <label for="reservation_name" class="text-black mb-[2px] font-['Poppins']">Name</label>
                    <input type="text" name="reservation_name" id="reservation_name" placeholder="Enter Full Name" 
                        class="p-[10px] border border-black rounded-[10px] font-['Poppins'] text-black w-[75%] focus:outline-none focus:border-[#BF9374]" required>
                    
                    <label for="contact_number" class="text-black mb-[2px] font-['Poppins']">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" placeholder="Enter Contact Number" 
                        class="p-[10px] border border-black rounded-[10px] font-['Poppins'] text-black w-[75%] focus:outline-none focus:border-[#BF9374]" required>
                    
                    <label for="event_location" class="text-black mb-[2px] font-['Poppins']">Address/Location</label>
                    <input type="text" name="event_location" id="event_location" placeholder="Enter Address/Location" 
                        class="p-[10px] border border-black rounded-[10px] font-['Poppins'] text-black w-[75%] focus:outline-none focus:border-[#BF9374]" required>
                </div>
                
                <button type="button" id="confirm-schedule-btn" 
                    class="confirm-phase-btn w-[25%] p-3 mt-5 bg-[#0fdf3cff] text-black border border-black rounded-[10px] text-base cursor-pointer ml-[400px] font-['Poppins'] hover:bg-[#0c8b28] transition-colors">
                    Confirm Set Schedule & Proceed
                </button>
            </div>
        </form>
    </main>
    <!-- [ Main Content ] end -->

    <!-- [ Footer ] start -->
    <?php include '../includes/footer.php'; ?>
    <!-- [ Footer ] end -->

    <!-- Required Js -->
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