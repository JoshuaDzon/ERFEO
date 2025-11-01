<?php
// MUST be at the very top - no spaces, no HTML, no echo before this
session_start();
include('../../database/db_config.php');

if(!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$user_attendees_key = 'user_' . $user_id . '_attendees';
$user_event_type_key = 'user_' . $user_id . '_event_type';

$guest_count = $_SESSION[$user_attendees_key]['total_expected_guests'] ?? 0;
$event_type = $_SESSION[$user_event_type_key]['event_type'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['user_' . $user_id . '_sound'] = $_POST;
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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="../assets/images/ERFEOlogo.png">
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/css_darkmode/events_dm.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/responsive/events.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/main/events.css" id="main-style-link" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'primary-brown': '#BF9374',
                        'light-bg': '#F9F9FB',
                        'accent-green': '#0a7822',
                        'light-gray': '#d0c9c9',
                        'medium-gray': '#919192',
                        'dark-gray': '#7d7878',
                    },
                    spacing: {
                        'header-height': '74px',
                    },
                    borderRadius: {
                        'custom': '10px',
                    },
                    borderWidth: {
                        'custom': '5px',
                    },
                    animation: {
                        'hitZak': 'hitZak 0.6s ease-in-out infinite alternate',
                    },
                    keyframes: {
                        hitZak: {
                            '0%': { left: '0' },
                            '100%': { left: 'calc(100% - 300px)' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-poppins m-0 w-full overflow-x-hidden">
  <!-- Preloader -->
  <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
    <div class="loader-track h-[5px] w-full absolute top-0 overflow-hidden">
      <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-hitZak"></div>
    </div>
  </div>
  
  <!-- [ Header Topbar ] start -->
  <?php include '../includes/header.php'; ?>
  <!-- [ Header ] end -->

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
  <main class="main-content">
    
    <form id="reservationForm" action="receipt.php" method="post" class="flex-1">
 
    <!-- PHASE 6 SOUND SYSTEM -->
    <div class="content-section border-custom border-primary-brown bg-light-bg p-5" id="sound-section">
        <h2 class="text-[25px] mb-1 text-black font-poppins">Sound System & Extras</h2>
        <p class="text-[17px] text-black mb-1 font-poppins">Ensure perfect audio and professional hosting for your event.</p>

        <!-- Event Info Display -->
        <div class="event-info-banner">
            <div class="event-info-item">
                <strong>Event Type:</strong> <span id="current-event-type"><?= htmlspecialchars($event_type) ?></span>
            </div>
            <div class="event-info-item">
                <strong>Total Guests:</strong> <span id="current-guest-count"><?= htmlspecialchars($guest_count) ?></span>
            </div>
        </div>

        <!-- Warning Messages Container -->
        <div id="sound-warnings" class="warning-container"></div>

        <!-- Tabs -->
        <div class="tab-menu bg-white p-1 rounded-custom h-[12%] w-full flex gap-2.5 mb-6 border border-black" id="sound-tabs">
            <div class="sound-tab-item active text-[18px] cursor-pointer text-black h-10 w-[285px] bg-light-gray rounded-custom border border-black pt-1.5 text-center mx-auto font-poppins" data-tab-target="sound-system">Sound System</div>
            <div class="sound-tab-item text-[18px] cursor-pointer text-black h-10 w-[285px] bg-light-gray rounded-custom border border-black pt-1.5 text-center mx-auto font-poppins" data-tab-target="extras-options">Extras</div>
        </div>

        <!-- SOUND SYSTEM OPTIONS -->
        <div id="sound-system" class="sound-tab-content active">
            <!-- Choose Only 1 Notice -->
            <div class="choose-one-notice">
                <strong>📢 Please choose only ONE sound system package</strong>
            </div>

            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Basic Audio" data-price="1000" data-max-guests="50">
                <div class="item-card-content flex items-center flex-grow">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Basic Audio</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Perfect for small gatherings up to 50 guests. <b>(Php.1000)</b></p>
                        <div class="item-details">
                            <span>2 Speakers</span>
                            <span>2 Wireless Microphones</span>
                            <span>Technical</span>
                            <span>Basic Music Mixer</span>
                        </div>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="sound-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>

            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Standard System" data-price="1800" data-max-guests="150">
                <div class="item-card-content flex items-center flex-grow">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Standard System</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Ideal for medium events up to 150 guests. <b>(Php.1800)</b></p>
                        <div class="item-details">
                            <span>4 Speakers</span>
                            <span>4 Wireless Microphones</span>
                            <span>DJ Setup</span>
                            <span>Professional Music Mixer</span>
                            <span>Technical</span>
                        </div>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="sound-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>

            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Premium Package" data-price="2500" data-max-guests="300">
                <div class="item-card-content flex items-center flex-grow">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Premium Package</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Ideal for medium events up to 300 guests. <b>(Php.2500)</b></p>
                        <div class="item-details">
                            <span>7 Speakers</span>
                            <span>6 Wireless Microphones</span>
                            <span>DJ Booth</span>
                            <span>Professional Music Mixer</span>
                            <span>Technical</span>
                        </div>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="sound-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
        </div>

        <!-- EXTRAS -->
        <div id="extras-options" class="sound-tab-content">
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="MCs (Host)" data-price="800">
                <div class="item-card-content flex items-center flex-grow">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">MCs (Host)</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Keep your event lively, engaging, and organized. <b>(Php.800)</b></p>
                        <div class="item-details">
                            <span>Professional Host</span>
                            <span>Guest Engagement</span>
                            <span>Event Flow Management</span>
                        </div>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="sound-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>

            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Live Band" data-price="1500">
                <div class="item-card-content flex items-center flex-grow">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Live Band</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Perfect for weddings, corporate events, or parties with great vibes. <b>(Php.1500)</b></p>
                        <div class="item-details">
                            <span>3–5 Professional Musicians</span>
                            <span>Wide Genre Repertoire</span>
                            <span>2–3 Hours Live Performance</span>
                        </div>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="sound-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>

            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Clown" data-price="400" data-restricted-events="Wedding,Christening,Graduation,Corporate">
                <div class="item-card-content flex items-center flex-grow">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Clown</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Perfect for kids' parties and fun celebrations. <b>(Php.400)</b><span class="serving-suggestion">Note: This clown is available only for Birthday and Reunion events</span></p>
                        <div class="item-details">
                            <span>Fun Games & Hosting</span>
                            <span>Professional Clown</span>
                            <span>Balloon Twisting</span>
                            <span>Magic Tricks</span>
                        </div>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="sound-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
        </div>

        <!-- Hidden field to store selected sound items -->
        <input type="hidden" name="sound_selection" id="sound_selection_input">
        <input type="hidden" name="guest_count" id="guest_count_input" value="<?= $guest_count ?>">
        <input type="hidden" name="event_type" id="event_type_input" value="<?= $event_type ?>">

        <button type="submit" class="confirm-phase-btn w-1/4 py-3 mt-5 bg-[#0fdf3cff] text-black border border-black rounded-custom text-base cursor-pointer ml-[400px] font-poppins">
            Confirm Sound & View Receipt
        </button>
    </div>
    </form>
  </main>
  <!-- [ Main Content ] end -->
  
  <?php include '../includes/footer.php'; ?>

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

  <!-- Simple Tab Functionality for Sound System -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      // Tab functionality for sound system
      const soundTabs = document.querySelectorAll('.sound-tab-item');
      const soundSections = document.querySelectorAll('.sound-tab-content');

      if (soundTabs.length > 0) {
          soundTabs.forEach(tab => {
              tab.addEventListener('click', function() {
                  // Remove active class from all tabs and sections
                  soundTabs.forEach(t => t.classList.remove('active'));
                  soundSections.forEach(s => s.classList.remove('active'));
                  
                  // Add active class to clicked tab
                  this.classList.add('active');
                  
                  // Show corresponding section
                  const targetId = this.getAttribute('data-tab-target');
                  const targetSection = document.getElementById(targetId);
                  if (targetSection) {
                      targetSection.classList.add('active');
                  }
              });
          });
      }
  });
  </script>
  
  <div class="floting-button fixed bottom-[50px] right-[30px] z-[1030]">
  </div>

  <script>
      const user_id = <?php echo $user_id; ?>;
      const guest_count = <?php echo $guest_count; ?>;
      const event_type = "<?php echo $event_type; ?>";
      
      layout_theme_sidebar_change('dark');
      change_box_container('false');
      layout_caption_change('true');
      layout_rtl_change('false');
      preset_change('preset-1');
      main_layout_change('vertical');
  </script>
</body>
</html>