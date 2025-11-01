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
    $_SESSION['user_' . $user_id . '_event_type'] = $_POST;
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
  <!-- [ Header Topbar ] end -->

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
  <form id="reservationForm" action="attendees.php" method="post" class="flex-1">
    <div class="content-section border-[5px] border-[#BF9374] bg-[#F9F9FB] p-5" id="event-type-section">
      <h2 class="text-[25px] mb-[5px] text-black font-['Poppins']">Choose Your Event Type</h2>
      <p class="text-[17px] text-black mb-[2px] font-['Poppins']">Select the type of event you're planning.</p>
      
      <div class="event-grid grid grid-cols-2 gap-7 mb-8">
        <div class="event-card bg-white rounded-[10px] p-[1.4rem_1.5rem] flex items-center justify-start gap-3 cursor-pointer border border-black hover:shadow-lg transition-all duration-300" data-event-type="Wedding">
          <img src="../assets/images/EventType/wedding.jpg" alt="Wedding" class="rounded-[10px] h-[60px] w-[60px] border border-black object-cover flex-shrink-0">
          <div class="event-text flex flex-col text-left justify-center">
            <h3 class="text-black text-[18px] m-0 font-['Poppins']">Wedding</h3>
            <p class="text-black text-[17px] mt-[5px] font-['Poppins']">Create magic moments</p>
          </div>
        </div>
        
        <div class="event-card bg-white rounded-[10px] p-[1.4rem_1.5rem] flex items-center justify-start gap-3 cursor-pointer border border-black hover:shadow-lg transition-all duration-300" data-event-type="Christening">
          <img src="../assets/images/EventType/christening.jpg" alt="Christening" class="rounded-[10px] h-[60px] w-[60px] border border-black object-cover flex-shrink-0">
          <div class="event-text flex flex-col text-left justify-center">
            <h3 class="text-black text-[18px] m-0 font-['Poppins']">Christening</h3>
            <p class="text-black text-[17px] mt-[5px] font-['Poppins']">Rejoicing being child of God</p>
          </div>
        </div>
        
        <div class="event-card bg-white rounded-[10px] p-[1.4rem_1.5rem] flex items-center justify-start gap-3 cursor-pointer border border-black hover:shadow-lg transition-all duration-300" data-event-type="Birthday">
          <img src="../assets/images/EventType/birthday.jpg" alt="Birthday" class="rounded-[10px] h-[60px] w-[60px] border border-black object-cover flex-shrink-0">
          <div class="event-text flex flex-col text-left justify-center">
            <h3 class="text-black text-[18px] m-0 font-['Poppins']">Birthday</h3>
            <p class="text-black text-[17px] mt-[5px] font-['Poppins']">Celebrate another year</p>
          </div>
        </div>
        
        <div class="event-card bg-white rounded-[10px] p-[1.4rem_1.5rem] flex items-center justify-start gap-3 cursor-pointer border border-black hover:shadow-lg transition-all duration-300" data-event-type="Graduation">
          <img src="../assets/images/EventType/graduation.jpg" alt="Graduation" class="rounded-[10px] h-[60px] w-[60px] border border-black object-cover flex-shrink-0">
          <div class="event-text flex flex-col text-left justify-center">
            <h3 class="text-black text-[18px] m-0 font-['Poppins']">Graduation</h3>
            <p class="text-black text-[17px] mt-[5px] font-['Poppins']">Honor achievements</p>
          </div>
        </div>
        
        <div class="event-card bg-white rounded-[10px] p-[1.4rem_1.5rem] flex items-center justify-start gap-3 cursor-pointer border border-black hover:shadow-lg transition-all duration-300" data-event-type="Reunion">
          <img src="../assets/images/EventType/reunion.jpg" alt="Reunion" class="rounded-[10px] h-[60px] w-[60px] border border-black object-cover flex-shrink-0">
          <div class="event-text flex flex-col text-left justify-center">
            <h3 class="text-black text-[18px] m-0 font-['Poppins']">Reunion</h3>
            <p class="text-black text-[17px] mt-[5px] font-['Poppins']">Reconnect with family</p>
          </div>
        </div>
        
        <div class="event-card bg-white rounded-[10px] p-[1.4rem_1.5rem] flex items-center justify-start gap-3 cursor-pointer border border-black hover:shadow-lg transition-all duration-300" data-event-type="Corporate">
          <img src="../assets/images/EventType/corporate-event.jpg" alt="Corporate" class="rounded-[10px] h-[60px] w-[60px] border border-black object-cover flex-shrink-0">
          <div class="event-text flex flex-col text-left justify-center">
            <h3 class="text-black text-[18px] m-0 font-['Poppins']">Corporate Event</h3>
            <p class="text-black text-[17px] mt-[5px] font-['Poppins']">Professional gathering</p>
          </div>
        </div>
      </div>
      
      <input type="hidden" name="event_type" id="event_type_input">
      <input type="hidden" name="event_specific_details" id="event_specific_details_input">
      
      <button type="button" id="confirm-event-btn" class="confirm-phase-btn w-[25%] p-3 mt-5 bg-[#0fdf3cff] text-black border border-black rounded-[10px] text-base cursor-pointer ml-[400px] font-['Poppins'] hover:bg-[#0c8b28] transition-colors">
        Confirm Event Type & Proceed
      </button>
    </div>
  </form>
</main>
<!-- [ Main Content ] end -->

<!-- [ Footer ] start -->
<?php include '../includes/footer.php'; ?>
<!-- [ Footer ] end -->
 
<!-- EVENT TYPE SPECIFIC FORM DETAILS -->
<div id="eventDetailsModal" class="modal">
  <div class="modal-content">
    <h3 id="modal-title" class="text-black text-[1.5rem] text-left mb-[25px] pb-0 border-b border-black font-['Poppins']">Fill out information for Wedding</h3>
    <form id="modal-details-form">
      <div id="modal-form-fields" class="mb-[15px]"></div>
      <div class="modal-footer mt-[35px] flex justify-center gap-[30px]">
        <button type="button" class="close-modal p-[15px_35px] border border-black rounded-[10px] cursor-pointer text-base flex-grow max-w-[150px] font-['Poppins'] text-black bg-[#7d7878] hover:bg-[#6b6666] transition-colors">Cancel</button>
        <button type="submit" class="confirm-details p-[15px_35px] border border-black rounded-[10px] cursor-pointer text-base flex-grow max-w-[150px] font-['Poppins'] text-black bg-[#0a7822] hover:bg-[#0c8b28] transition-colors">Confirm</button>
      </div>
    </form>
  </div>
</div>

    <!-- Required Js -->
    <script src="../assets/js/event_reservation.js"></script>
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