<?php
session_start();
include('../../database/db_config.php');

if(!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$user_session_key = 'user_' . $user_id . '_booking';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION[$user_session_key] = array_merge($_SESSION[$user_session_key] ?? [], $_POST);
}

$user_booking_data = $_SESSION[$user_session_key] ?? [];
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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="../assets/images/ERFEOlogo.png">
  <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
  <link rel="stylesheet" href="../assets/css/css_darkmode/receipt.css" id="main-style-link" />
  <link rel="stylesheet" href="../assets/css/responsive/events.css" id="main-style-link" />
  <style>
  body { 
    font-family: 'Poppins', sans-serif; 
}
::-webkit-scrollbar { 
    display: none; 
}
.pc-sidebar.pc-sidebar-hide ~ .relative {
    margin-left: -60px;
    width: 1650px;
    transition: all 0.3s ease;
}
.relative {
    transition: all 0.3s ease;
}
.pc-sidebar.pc-sidebar-hide ~ .relative .confirm-phase-btn {
    margin-left: 570px;
}
.confirm-phase-btn {
    transition: 0.5s ease;
}
.pc-header {
    left: 265px;
    width: calc(100% - 260px);
    transition: left 0.3s ease, width 0.3s ease;
}
.pc-header.sidebar-collapsed {
    left: 0;
    width: 100%;
}
.pc-container {
    margin-left: 260px;
    transition: margin-left 0.3s ease;
}
.pc-container.sidebar-collapsed {
    margin-left: 0;
}
</style>
</head>

<body class="font-['Poppins'] m-0 w-full overflow-x-hidden">
  <!-- Preloader -->
  <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
    <div class="loader-track h-[5px] w-full absolute top-0 overflow-hidden">
      <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
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
                    <a href="../booking pages/receipt.php" class="pc-link active">
                        <span class="pc-micon"><i data-feather="printer"></i></span>
                        <span class="pc-mtext">Receipt Printing</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label>Settings</label><i data-feather="wrench"></i>
                </li>
                <li class="pc-item">
                    <a href="../booking pages/view_all_bookings.php" class="pc-link">
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
  <main class="relative ml-56 w-[88.5%] top-10 min-h-[135px] px-10 pt-5">
    <form id="final-booking-form" action="../backend/booking_confirm.php" method="POST">
      <div class="bg-[#F9F9FB] max-w-[1268px] shadow-2xl overflow-hidden border-[5px] border-[#BF9374] rounded-2xl my-8 mx-auto">
        <!-- Header -->
        <header class="bg-[#F9F9FB] p-10 text-center border-b-[5px] border-[#BF9374]">
          <h1 class="text-black text-4xl mb-3 uppercase tracking-[2px] font-bold">Booking Receipt</h1>
          <p class="text-black text-lg m-0">Please review your booking details. Click <b>Confirm Booking</b> to finish.</p>
        </header>
        
        <!-- Body -->
        <section id="final-summary-list" class="p-10 bg-white">
          <?php if (!empty($user_booking_data)) : ?>
            <!-- Event Details Section -->
            <div class="mb-8 bg-gradient-to-br from-[#BF9374]/10 to-[#D4A574]/10 p-6 rounded-xl border-2 border-[#BF9374] shadow-md">
              <h2 class="text-2xl font-bold text-black uppercase tracking-wide mb-4 pb-3 border-b-4 border-[#BF9374]">
                📋 Event Details
              </h2>
              <div class="space-y-2 bg-white p-4 rounded-lg">
                <div class="flex justify-between py-2 border-b border-gray-200">
                  <span class="text-black font-semibold">Event Type:</span>
                  <span class="text-black"><?= htmlspecialchars($user_booking_data['final_event_type'] ?? 'N/A') ?></span>
                </div>
                
                <?php 
                $event_specific = $user_booking_data['final_event_specific_details'] ?? '';
                if (!empty($event_specific) && strpos($event_specific, '{') === 0) {
                    $event_details_data = json_decode($event_specific, true);
                    if (!empty($event_details_data) && is_array($event_details_data)):
                        $label_map = [
                            'groom_name' => 'Groom Name', 'bride_name' => 'Bride Name',
                            'child_name' => 'Child Name', 'godparents' => 'Godparents',
                            'celebrant_name' => 'Celebrant Name', 'age_type' => 'Age Type', 'age_value' => 'Age',
                            'graduate_name' => 'Graduate Name', 'degree' => 'Degree/Course',
                            'group_name' => 'Group Name', 'occasion' => 'Occasion',
                            'company_name' => 'Company Name', 'purpose' => 'Purpose'
                        ];
                        foreach ($event_details_data as $key => $value): 
                            $display_label = $label_map[$key] ?? ucwords(str_replace('_', ' ', $key));
                ?>
                  <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-black font-semibold"><?= htmlspecialchars($display_label) ?>:</span>
                    <span class="text-black"><?= htmlspecialchars($value) ?></span>
                  </div>
                <?php 
                        endforeach;
                    endif;
                }
                ?>
                
                <div class="flex justify-between py-2 border-b border-gray-200">
                  <span class="text-black font-semibold">Full Name:</span>
                  <span class="text-black"><?= htmlspecialchars($user_booking_data['final_name'] ?? 'N/A') ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                  <span class="text-black font-semibold">Contact:</span>
                  <span class="text-black"><?= htmlspecialchars($user_booking_data['final_contact_number'] ?? 'N/A') ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                  <span class="text-black font-semibold">Address/Location:</span>
                  <span class="text-black"><?= htmlspecialchars($user_booking_data['final_address'] ?? 'N/A') ?></span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                  <span class="text-black font-semibold">Date:</span>
                  <span class="text-black"><?= htmlspecialchars($user_booking_data['final_event_date'] ?? 'N/A') ?></span>
                </div>
                <div class="flex justify-between py-2">
                  <span class="text-black font-semibold">Time:</span>
                  <span class="text-black"><?= htmlspecialchars($user_booking_data['final_event_time'] ?? 'N/A') ?></span>
                </div>
              </div>
            </div>

            <!-- Attendees Summary -->
            <?php 
            $attendees = $user_booking_data['final_attendee_categories'] ?? '';
            if (!empty($attendees) && strpos($attendees, '{') === 0) {
                $attendee_data = json_decode($attendees, true);
                if (!empty($attendee_data) && is_array($attendee_data)):
            ?>
            <div class="mb-8 bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border-2 border-blue-300 shadow-md">
              <h2 class="text-2xl font-bold text-black uppercase tracking-wide mb-4 pb-3 border-b-4 border-blue-400">
                👥 Attendees Summary
              </h2>
              <div class="space-y-2 bg-white p-4 rounded-lg">
                <?php foreach ($attendee_data as $category => $count): ?>
                  <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-black font-semibold"><?= htmlspecialchars($category) ?>:</span>
                    <span class="text-black font-bold"><?= intval($count) ?></span>
                  </div>
                <?php endforeach; ?>
                <div class="flex justify-between py-3 border-t-2 border-black mt-2">
                  <span class="text-black font-bold text-lg">Total Expected Guests:</span>
                  <span class="text-black font-bold text-lg"><?= htmlspecialchars($user_booking_data['final_total_expected_guests'] ?? '0') ?></span>
                </div>
              </div>
            </div>
            <?php 
                endif;
            }
            ?>
              
            <!-- MENU ITEMS -->
            <div class="mb-8 bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border-2 border-green-400 shadow-md">
              <h2 class="text-2xl font-bold text-black uppercase tracking-wide mb-4 pb-3 border-b-4 border-green-500">
                🍽️ Menu
              </h2>
              <?php
              $menu_items = [];
              if (!empty($user_booking_data['final_menu_items'])) {
                  $menu_json = $user_booking_data['final_menu_items'];
                  if (strpos($menu_json, '[{') === 0) {
                      $menu_items = json_decode($menu_json, true);
                  }
              }
              
              if (!empty($menu_items) && is_array($menu_items)): 
                  $menu_total = 0;
              ?>
                  <div class="space-y-2 bg-white p-4 rounded-lg">
                      <?php foreach($menu_items as $item): 
                          $quantity = intval($item['quantity'] ?? 0);
                          $price = floatval($item['price'] ?? 0);
                          $item_total = $quantity * $price;
                          $menu_total += $item_total;
                      ?>
                          <?php if($quantity > 0): ?>
                              <div class="flex justify-between py-2 border-b border-gray-200">
                                  <span class="text-black font-semibold"><?= htmlspecialchars($item['name'] ?? '') ?> (x<?= $quantity ?>):</span>
                                  <span class="text-black font-bold">Php <?= number_format($item_total, 2) ?></span>
                              </div>
                              <div class="flex justify-end py-1 text-sm text-gray-600 border-b border-gray-100">
                                  <span>Price: Php <?= number_format($price, 2) ?></span>
                              </div>
                          <?php endif; ?>
                      <?php endforeach; ?>
                      
                      <?php if($menu_total > 0): ?>
                          <div class="flex justify-between py-3 border-t-2 border-black mt-2">
                              <span class="text-black font-bold text-lg">Menu Subtotal:</span>
                              <span class="text-black font-bold text-lg">Php <?= number_format($menu_total, 2) ?></span>
                          </div>
                      <?php endif; ?>
                  </div>
              <?php else: ?>
                  <div class="bg-white p-6 rounded-lg text-center">
                      <p class="text-gray-500 italic">No menu items selected</p>
                  </div>
              <?php endif; ?>
            </div>

            <!-- DECORATIONS -->
            <div class="mb-8 bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border-2 border-purple-400 shadow-md">
              <h2 class="text-2xl font-bold text-black uppercase tracking-wide mb-4 pb-3 border-b-4 border-purple-500">
                🎨 Decorations
              </h2>
              <?php
              $decor_items = [];
              if (!empty($user_booking_data['final_decor_items'])) {
                  $decor_json = $user_booking_data['final_decor_items'];
                  if (strpos($decor_json, '[{') === 0) {
                      $decor_items = json_decode($decor_json, true);
                  }
              }
              
              if (!empty($decor_items) && is_array($decor_items)): 
                  $decor_total = 0;
              ?>
                  <div class="space-y-2 bg-white p-4 rounded-lg">
                      <?php foreach($decor_items as $item): 
                          $price = floatval($item['price'] ?? 0);
                          $decor_total += $price;
                      ?>
                          <div class="flex justify-between py-2 border-b border-gray-200">
                              <span class="text-black font-semibold"><?= htmlspecialchars($item['name'] ?? '') ?>:</span>
                              <span class="text-black font-bold">Php <?= number_format($price, 2) ?></span>
                          </div>
                      <?php endforeach; ?>
                      
                      <?php if($decor_total > 0): ?>
                          <div class="flex justify-between py-3 border-t-2 border-black mt-2">
                              <span class="text-black font-bold text-lg">Decor Subtotal:</span>
                              <span class="text-black font-bold text-lg">Php <?= number_format($decor_total, 2) ?></span>
                          </div>
                      <?php endif; ?>
                  </div>
              <?php else: ?>
                  <div class="bg-white p-6 rounded-lg text-center">
                      <p class="text-gray-500 italic">No decorations selected</p>
                  </div>
              <?php endif; ?>
            </div>

            <!-- SOUND SYSTEM -->
            <div class="mb-8 bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-xl border-2 border-orange-400 shadow-md">
              <h2 class="text-2xl font-bold text-black uppercase tracking-wide mb-4 pb-3 border-b-4 border-orange-500">
                🔊 Sound System
              </h2>
              <?php
              $sound_items = [];
              if (!empty($user_booking_data['final_sound_items'])) {
                  $sound_json = $user_booking_data['final_sound_items'];
                  if (strpos($sound_json, '[{') === 0) {
                      $sound_items = json_decode($sound_json, true);
                  }
              }
              
              if (!empty($sound_items) && is_array($sound_items)): 
                  $sound_total = 0;
              ?>
                  <div class="space-y-2 bg-white p-4 rounded-lg">
                      <?php foreach($sound_items as $item): 
                          $price = floatval($item['price'] ?? 0);
                          $sound_total += $price;
                      ?>
                          <div class="flex justify-between py-2 border-b border-gray-200">
                              <span class="text-black font-semibold"><?= htmlspecialchars($item['name'] ?? '') ?>:</span>
                              <span class="text-black font-bold">Php <?= number_format($price, 2) ?></span>
                          </div>
                      <?php endforeach; ?>
                      
                      <?php if($sound_total > 0): ?>
                          <div class="flex justify-between py-3 border-t-2 border-black mt-2">
                              <span class="text-black font-bold text-lg">Sound Subtotal:</span>
                              <span class="text-black font-bold text-lg">Php <?= number_format($sound_total, 2) ?></span>
                          </div>
                      <?php endif; ?>
                  </div>
              <?php else: ?>
                  <div class="bg-white p-6 rounded-lg text-center">
                      <p class="text-gray-500 italic">No sound system selected</p>
                  </div>
              <?php endif; ?>
            </div>

            <!-- GRAND TOTAL -->
            <?php
            $total_cost = 0;
            $menu_total = 0;
            $decor_total = 0;
            $sound_total = 0;
            
            if (!empty($menu_items)) {
                foreach($menu_items as $item) {
                    $menu_total += (floatval($item['price'] ?? 0) * intval($item['quantity'] ?? 0));
                }
            }
            
            if (!empty($decor_items)) {
                foreach($decor_items as $item) {
                    $decor_total += floatval($item['price'] ?? 0);
                }
            }
            
            if (!empty($sound_items)) {
                foreach($sound_items as $item) {
                    $sound_total += floatval($item['price'] ?? 0);
                }
            }
            
            $total_cost = $menu_total + $decor_total + $sound_total;
            ?>
            
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-xl border-4 border-green-700 shadow-2xl">
                <div class="flex justify-between items-center bg-white p-4 rounded-lg">
                    <span class="text-black font-extrabold text-2xl uppercase tracking-wide">💰 Grand Total:</span>
                    <span class="text-green-600 font-extrabold text-3xl">Php <?= number_format($total_cost, 2) ?></span>
                </div>
            </div>
          <?php else: ?>
            <div class="text-center py-12 px-10 bg-white rounded-3xl shadow-lg">
              <p class="text-black text-lg">No booking data found. Please complete the booking process.</p>
            </div>
          <?php endif; ?>
        </section>
        
        <!-- Hidden Fields -->
        <input type="hidden" id="final_name" name="final_name" value="<?= htmlspecialchars($user_booking_data['final_name'] ?? '') ?>">
        <input type="hidden" id="final_contact_number" name="final_contact_number" value="<?= htmlspecialchars($user_booking_data['final_contact_number'] ?? '') ?>">
        <input type="hidden" id="final_address" name="final_address" value="<?= htmlspecialchars($user_booking_data['final_address'] ?? '') ?>">
        <input type="hidden" id="final_event_date" name="final_event_date" value="<?= htmlspecialchars($user_booking_data['final_event_date'] ?? '') ?>">
        <input type="hidden" id="final_event_time" name="final_event_time" value="<?= htmlspecialchars($user_booking_data['final_event_time'] ?? '') ?>">
        <input type="hidden" id="final_event_type" name="final_event_type" value="<?= htmlspecialchars($user_booking_data['final_event_type'] ?? '') ?>">
        <input type="hidden" id="final_event_specific_details" name="final_event_specific_details" value="<?= htmlspecialchars($user_booking_data['final_event_specific_details'] ?? '') ?>">
        <input type="hidden" id="final_total_expected_guests" name="final_total_expected_guests" value="<?= htmlspecialchars($user_booking_data['final_total_expected_guests'] ?? '') ?>">
        <input type="hidden" id="final_attendee_categories" name="final_attendee_categories" value="<?= htmlspecialchars($user_booking_data['final_attendee_categories'] ?? '') ?>">
        <input type="hidden" id="final_menu_items" name="final_menu_items" value="<?= htmlspecialchars($user_booking_data['final_menu_items'] ?? '') ?>">
        <input type="hidden" id="final_decor_items" name="final_decor_items" value="<?= htmlspecialchars($user_booking_data['final_decor_items'] ?? '') ?>">
        <input type="hidden" id="final_sound_items" name="final_sound_items" value="<?= htmlspecialchars($user_booking_data['final_sound_items'] ?? '') ?>">
        <input type="hidden" id="final_total_cost" name="final_total_cost" value="<?= $total_cost ?>">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        
        <!-- Confirm Button -->
        <button type="button" id="confirm-booking-btn" class="mt-4 mx-auto mb-4 block w-1/2 py-5 px-8 bg-[#0fdf3cff] text-black border-2 border-black rounded-xl text-lg cursor-pointer uppercase tracking-wide font-bold shadow-lg transition-all duration-300 hover:from-green-500 hover:to-green-600 hover:-translate-y-1 hover:shadow-xl">
          Confirm Booking
        </button>
      </div>
    </form>
  </main>
  <!-- [ Main Content ] end -->
 
  <!-- [ Footer] start -->
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