<?php
session_start();
include('../../database/db_config.php');

$sql = "SELECT * FROM bookings WHERE status = 'PENDING' ORDER BY event_date ASC, event_time ASC";
$bookings = $conn->query($sql);

// Count total pending
$count_result = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE status = 'PENDING'");
$total_pending = $count_result->fetch_assoc()['count'];
?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <title>Event Reservation for Event Organizer</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="../assets/images/ERFEOlogo.png">
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/css_darkmode/pending_dm.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/responsive/pending.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/main/pending.css" id="main-style-link" />
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
    <?php include '../includes/sidebar.php'; ?>

    <div class="ml-[264px] p-10 max-w-[1400px]">
        <!-- Page Header -->
        <div class="mt-[50px] page-header bg-gradient-to-r from-[#f39c12] to-[#e67e22] text-black p-10 rounded-[20px] mb-9 shadow-xl relative overflow-hidden">
            <h2 class="m-0 mb-3 text-[2.5rem] font-black text-black relative z-10">Pending Events</h2>
            <p class="m-0 text-[1.1rem] opacity-90 font-medium text-black relative z-10">
                Total Pending Reservations: <strong><?php echo $total_pending; ?></strong>
            </p>
        </div>

        <?php 
        if ($bookings && $bookings->num_rows > 0) {
            while($row = $bookings->fetch_assoc()): 
        ?>
        <div class="booking-table bg-white rounded-[20px] shadow-lg mb-8 overflow-hidden border-l-5 border-[#f39c12] transition-all duration-300 hover:translate-y-[-5px] hover:shadow-xl">
            <!-- Table Header -->
            <div class="table-header bg-gradient-to-r from-[#fff3cd] to-[#ffe69c] text-black p-5 px-8 font-bold text-[1.1rem] flex justify-between items-center border-b-3 border-[#ffc107]">
                <span>BOOKING ID: #<?php echo $row['booking_id']; ?></span>
                <span class="status-badge px-5 py-[10px] rounded-[25px] font-bold text-[0.9rem] bg-gradient-to-r from-[#fff3cd] to-[#ffe69c] text-black border-2 border-[#ffc107] shadow-lg uppercase tracking-[0.5px]">
                    PENDING
                </span>
            </div>

            <!-- Information Details -->
            <div class="info-section p-8 border-b-2 border-[#f5f5f5]">
                <div class="section-title text-[1rem] text-black uppercase mb-5 tracking-[1px] flex items-center gap-3">
                    Information Details
                </div>
                <div class="info-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div class="info-item flex flex-col gap-2 p-4 bg-[#fafafa] rounded-[10px] transition-all duration-300 hover:bg-[#fff9e6] hover:translate-y-[-2px]">
                        <span class="info-label text-[0.85rem] text-[#666] font-semibold uppercase tracking-[0.5px]">Name</span>
                        <span class="info-value text-[1.05rem] text-black font-semibold"><?php echo htmlspecialchars($row['name']); ?></span>
                    </div>
                    <div class="info-item flex flex-col gap-2 p-4 bg-[#fafafa] rounded-[10px] transition-all duration-300 hover:bg-[#fff9e6] hover:translate-y-[-2px]">
                        <span class="info-label text-[0.85rem] text-[#666] font-semibold uppercase tracking-[0.5px]">Contact Number</span>
                        <span class="info-value text-[1.05rem] text-black font-semibold"><?php echo htmlspecialchars($row['contact_number'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="info-item flex flex-col gap-2 p-4 bg-[#fafafa] rounded-[10px] transition-all duration-300 hover:bg-[#fff9e6] hover:translate-y-[-2px]">
                        <span class="info-label text-[0.85rem] text-[#666] font-semibold uppercase tracking-[0.5px]">Address</span>
                        <span class="info-value text-[1.05rem] text-black font-semibold"><?php echo htmlspecialchars($row['address'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="info-item flex flex-col gap-2 p-4 bg-[#fafafa] rounded-[10px] transition-all duration-300 hover:bg-[#fff9e6] hover:translate-y-[-2px]">
                        <span class="info-label text-[0.85rem] text-[#666] font-semibold uppercase tracking-[0.5px]">Event Date</span>
                        <span class="info-value text-[1.05rem] text-black font-semibold"><?php echo date('F d, Y', strtotime($row['event_date'])); ?></span>
                    </div>
                    <div class="info-item flex flex-col gap-2 p-4 bg-[#fafafa] rounded-[10px] transition-all duration-300 hover:bg-[#fff9e6] hover:translate-y-[-2px]">
                        <span class="info-label text-[0.85rem] text-[#666] font-semibold uppercase tracking-[0.5px]">Event Time</span>
                        <span class="info-value text-[1.05rem] text-black font-semibold"><?php echo date('h:i A', strtotime($row['event_time'])); ?></span>
                    </div>
                    <div class="info-item flex flex-col gap-2 p-4 bg-[#fafafa] rounded-[10px] transition-all duration-300 hover:bg-[#fff9e6] hover:translate-y-[-2px]">
                        <span class="info-label text-[0.85rem] text-[#666] font-semibold uppercase tracking-[0.5px]">Event Type</span>
                        <span class="info-value text-[1.05rem] text-black font-semibold"><?php echo htmlspecialchars($row['event_type']); ?></span>
                    </div>
                    <div class="info-item flex flex-col gap-2 p-4 bg-[#fafafa] rounded-[10px] transition-all duration-300 hover:bg-[#fff9e6] hover:translate-y-[-2px] md:col-span-3">
                        <span class="info-label text-[0.85rem] text-[#666] font-semibold uppercase tracking-[0.5px]">Event Specific Details</span>
                        <span class="info-value text-[1.05rem] text-black font-medium">
                            <?php 
                            $event_details = $row['event_specific_details'] ?? '';
                            $event_type = $row['event_type'] ?? '';
                            if ($event_details !== '' && strpos(trim($event_details), '{') === 0) {
                                $details = json_decode($event_details, true);
                                if ($details && is_array($details)) {
                
                                    $label_mapping = [
                                        'groom_name' => "Groom's Name",
                                        'bride_name' => "Bride's Name",
                                        'child_name' => "Child's Name",
                                        'godparents' => "Godparents",
                                        'celebrant_name' => "Celebrant's Name",
                                        'age_type' => "Age Type",
                                        'age_value' => "Age",
                                        'graduate_name' => "Graduate's Name",
                                        'degree' => "Degree/Course",
                                        'group_name' => "Family/Group Name",
                                        'occasion' => "Occasion",
                                        'company_name' => "Company Name",
                                        'purpose' => "Event Purpose"
                                    ];
                                    foreach ($details as $key => $value) {
                                        $display_label = $label_mapping[$key] ?? ucwords(str_replace('_', ' ', $key));
                                        echo '<strong>' . htmlspecialchars($display_label) . ':</strong> ' . htmlspecialchars($value) . '<br>';
                                    }
                                } else {
                                    echo htmlspecialchars($event_details);
                                }
                            } else {
                                echo htmlspecialchars($event_details ?: 'N/A');
                            }
                            ?>
                        </span>
                    </div>
                    <div class="info-item flex flex-col gap-2 p-4 bg-[#fafafa] rounded-[10px] transition-all duration-300 hover:bg-[#fff9e6] hover:translate-y-[-2px]">
                        <span class="info-label text-[0.85rem] text-[#666] font-semibold uppercase tracking-[0.5px]">Created At</span>
                        <span class="info-value text-[1.05rem] text-black font-semibold"><?php echo date('F d, Y h:i A', strtotime($row['created_at'])); ?></span>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="booking-details p-8 bg-gradient-to-r from-[#fafafa] to-[#f5f5f5]">
                <div class="section-title text-[1rem] text-black uppercase mb-5 tracking-[1px] flex items-center gap-3">
                    Booking Details
                </div>
                <div class="details-grid flex flex-col gap-4">
                    <!-- Total Expected Guests -->
                    <div class="detail-item bg-white p-6 rounded-[12px] border-l-5 border-[#f39c12] shadow-md transition-all duration-300 hover:translate-y-[-3px] hover:shadow-lg flex flex-col">
                        <div class="detail-label text-[0.85rem] text-[#666] font-bold mb-4 uppercase tracking-[0.5px] border-b-2 border-[#f0f0f0] pb-2">
                            Total Expected Guests
                        </div>
                        <div class="detail-value text-[1rem] text-black font-medium">
                            <?php echo htmlspecialchars($row['total_expected_guests'] ?? 'N/A'); ?>
                        </div>
                    </div>

                    <!-- Attendee Categories -->
                    <div class="detail-item bg-white p-6 rounded-[12px] border-l-5 border-[#f39c12] shadow-md transition-all duration-300 hover:translate-y-[-3px] hover:shadow-lg flex flex-col">
                        <div class="detail-label text-[0.85rem] text-[#666] font-bold mb-4 uppercase tracking-[0.5px] border-b-2 border-[#f0f0f0] pb-2">
                            Attendee Categories
                        </div>
                        <div class="detail-value text-[1rem] text-black font-medium leading-[1.6]">
                            <?php 
                            $attendees = $row['attendee_categories'] ?? '';
                            if ($attendees !== '' && strpos(trim($attendees), '{') === 0) {
                                $data = json_decode($attendees, true);
                                if ($data && is_array($data)) {
                                    foreach ($data as $category => $count) {
                                        echo htmlspecialchars($category) . ': <strong>' . intval($count) . '</strong><br>';
                                    }
                                } else {
                                    echo htmlspecialchars($attendees);
                                }
                            } else {
                                echo htmlspecialchars($attendees ?: 'N/A');
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Menu Items -->
                    <div class="detail-item bg-white p-6 rounded-[12px] border-l-5 border-[#f39c12] shadow-md transition-all duration-300 hover:translate-y-[-3px] hover:shadow-lg flex flex-col">
                        <div class="detail-label text-[0.85rem] text-[#666] font-bold mb-4 uppercase tracking-[0.5px] border-b-2 border-[#f0f0f0] pb-2">
                            Menu Items
                        </div>
                        <div class="detail-value text-[1rem] text-black font-medium leading-[1.6]">
                            <?php 
                            $menu = $row['menu_items'] ?? '';
                            if ($menu !== '' && strpos($menu, '[{') === 0) {
                                $items = json_decode($menu, true);
                                if ($items && is_array($items)) {
                                    foreach ($items as $item) {
                                        echo '• ' . htmlspecialchars($item['name']) . '  Qty: ' . intval($item['quantity']) . ' | ₱' . number_format($item['price'], 2) . '<br>';
                                    }
                                } else {
                                    echo htmlspecialchars($menu);
                                }
                            } else {
                                echo htmlspecialchars($menu ?: 'N/A');
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Decorations -->
                    <div class="detail-item bg-white p-6 rounded-[12px] border-l-5 border-[#f39c12] shadow-md transition-all duration-300 hover:translate-y-[-3px] hover:shadow-lg flex flex-col">
                        <div class="detail-label text-[0.85rem] text-[#666] font-bold mb-4 uppercase tracking-[0.5px] border-b-2 border-[#f0f0f0] pb-2">
                            Decorations
                        </div>
                        <div class="detail-value text-[1rem] text-black font-medium leading-[1.6]">
                            <?php 
                            $decor = $row['decorations'] ?? '';
                            if ($decor !== '' && strpos($decor, '[{') === 0) {
                                $items = json_decode($decor, true);
                                if ($items && is_array($items)) {
                                    foreach ($items as $item) {
                                        echo '• ' . htmlspecialchars($item['name']) . '  ';
                                        $qty = isset($item['quantity']) ? 'Qty: ' . intval($item['quantity']) . ' | ' : '';
                                        echo $qty . '₱' . number_format($item['price'], 2) . '<br>';
                                    }
                                } else {
                                    echo htmlspecialchars($decor);
                                }
                            } else {
                                echo htmlspecialchars($decor ?: 'N/A');
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Sound System -->
                    <div class="detail-item bg-white p-6 rounded-[12px] border-l-5 border-[#f39c12] shadow-md transition-all duration-300 hover:translate-y-[-3px] hover:shadow-lg flex flex-col">
                        <div class="detail-label text-[0.85rem] text-[#666] font-bold mb-4 uppercase tracking-[0.5px] border-b-2 border-[#f0f0f0] pb-2">
                            Sound System
                        </div>
                        <div class="detail-value text-[1rem] text-black font-medium leading-[1.6]">
                            <?php 
                            $sound = $row['sound'] ?? '';
                            if ($sound !== '' && strpos($sound, '[{') === 0) {
                                $items = json_decode($sound, true);
                                if ($items && is_array($items)) {
                                    foreach ($items as $item) {
                                        echo '• ' . htmlspecialchars($item['name']) . '  ';
                                        $qty = isset($item['quantity']) ? 'Qty: ' . intval($item['quantity']) . ' | ' : '';
                                        echo $qty . '₱' . number_format($item['price'], 2) . '<br>';
                                    }
                                } else {
                                    echo htmlspecialchars($sound);
                                }
                            } else {
                                echo htmlspecialchars($sound ?: 'N/A');
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Total Cost -->
                    <div class="detail-item bg-white p-6 rounded-[12px] border-l-5 border-[#f39c12] shadow-md transition-all duration-300 hover:translate-y-[-3px] hover:shadow-lg flex flex-col">
                        <div class="detail-label text-[0.85rem] text-[#666] font-bold mb-4 uppercase tracking-[0.5px] border-b-2 border-[#f0f0f0] pb-2">
                            Total Cost
                        </div>
                        <div class="detail-value text-[2.2rem] font-black text-center p-3 border-3 border-[#fff9e6] rounded-[12px] mt-3">
                            ₱<?php echo number_format($row['total_cost'], 2); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            endwhile; 
        } else {
        ?>
        <!-- Empty State -->
        <div class="empty-state text-center py-20 px-10 bg-white rounded-[20px] shadow-lg relative overflow-hidden">
            <h3 class="m-0 mb-4 text-[1.8rem] text-black font-bold">No Pending Events</h3>
            <p class="text-[1.1rem] text-[#666] leading-[1.6]">All bookings have been processed!</p>
        </div>
        <?php } ?>
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