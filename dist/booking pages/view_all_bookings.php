<?php
session_start();
include('../../database/db_config.php');

if(!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// FETCH ALL BOOKINGS FROM ALL USERS (PUBLIC VIEW)
$sql = "SELECT booking_id, event_date, event_time, event_type, 
        status, total_expected_guests, attendee_categories, menu_items, decorations, 
        sound, total_cost, created_at 
        FROM bookings 
        ORDER BY event_date DESC, event_time DESC";
        
$bookings = $conn->query($sql);

// COUNT ALL BOOKINGS (NOT JUST CURRENT USER)
$count_sql = "SELECT COUNT(*) as count FROM bookings";
$count_result = $conn->query($count_sql);
$total_bookings = $count_result->fetch_assoc()['count'];
?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <title>Event Reservation for Event Organizer</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../assets/images/ERFEOlogo.png">
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/css_darkmode/view_all_bookings_dm.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/responsive/view_all_bookings.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/main/events.css" id="main-style-link" />
</head>
<body class="font-['Poppins']">
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

    <div class="ml-[264px] p-10 max-w-[1400px]">
        <!-- Page Header -->
        <div class="mt-[50px] bg-gradient-to-r from-[#BF9374] to-[#D4A574] text-black p-10 rounded-[20px] mb-9 shadow-xl relative overflow-hidden">
            <h2 class="m-0 mb-3 text-[2.5rem] text-black relative z-10">All Bookings (Public View)</h2>
            <p class="m-0 mb-4 text-[1.1rem] opacity-90 text-black relative z-10">
                Total Bookings from All Users: <strong><?php echo $total_bookings; ?></strong>
            </p>
            <div class="privacy-info bg-[rgba(255,255,255,0.2)] p-3 px-5 rounded-[10px] text-[0.9rem] border-l-4 border-black text-black">
                <strong>🔒 Privacy Protected:</strong> Viewing all bookings. Sensitive information (contact details, address, names) is hidden for security.
            </div>
        </div>

        <?php 
        if ($bookings && $bookings->num_rows > 0) {
            while($row = $bookings->fetch_assoc()): 
        ?>
        <div class="booking-card bg-white rounded-[20px] shadow-lg mb-8 overflow-hidden border-l-[5px] border-[#BF9374] transition-all duration-300 hover:translate-y-[-5px] hover:shadow-xl">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-[#BF9374] to-[#D4A574] text-black p-6 px-8 flex justify-between items-center border-b-[3px] border-[#D4A574]">
                <div class="flex flex-col gap-2">
                    <div class="booking-id-badge bg-[rgba(255,255,255,0.2)] text-black px-4 py-2 rounded-[20px] text-[0.9rem] inline-block backdrop-blur font-bold">
                        Booking #<?php echo $row['booking_id']; ?>
                    </div>
                    <div class="booking-date text-[1rem] text-black opacity-90 font-medium">
                        📅 <?php echo date('F d, Y', strtotime($row['event_date'])); ?> 
                        • 🕐 <?php echo date('h:i A', strtotime($row['event_time'])); ?>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="status-badge px-5 py-[10px] rounded-[25px] text-[0.85rem] font-bold uppercase tracking-[0.5px] shadow-md
                        <?php 
                        echo strtolower($row['status']) === 'pending' ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-black border-2 border-yellow-400' : 
                            (strtolower($row['status']) === 'accept' ? 'bg-gradient-to-r from-green-100 to-green-200 text-black border-2 border-green-500' : 
                            'bg-gradient-to-r from-red-100 to-red-200 text-black border-2 border-red-500');
                        ?>">
                        <?php echo htmlspecialchars($row['status']); ?>
                    </span>
                </div>
            </div>

            <!-- Event Information (Privacy Protected - NO Contact/Address) -->
            <div class="p-8 border-b-2 border-[#f5f5f5]">
                <div class="section-title text-[1rem] font-bold text-black uppercase mb-5 tracking-[1px] flex items-center gap-3">
                    Event Information
                </div>
                <div class="info-grid grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="info-item flex flex-col gap-2 p-4 bg-[#fafafa] rounded-[10px] transition-all duration-300 hover:bg-[#fef5ed] hover:translate-y-[-2px]">
                        <span class="info-label text-[0.8rem] font-semibold text-gray-600 uppercase tracking-[0.5px]">Event Type</span>
                        <span class="info-value text-[1.05rem] font-semibold text-black"><?php echo htmlspecialchars($row['event_type']); ?></span>
                    </div>
                    <div class="info-item flex flex-col gap-2 p-4 bg-[#fafafa] rounded-[10px] transition-all duration-300 hover:bg-[#fef5ed] hover:translate-y-[-2px]">
                        <span class="info-label text-[0.8rem] font-semibold text-gray-600 uppercase tracking-[0.5px]">Total Expected Guests</span>
                        <span class="info-value text-[1.05rem] font-semibold text-black"><?php echo htmlspecialchars($row['total_expected_guests'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="info-item flex flex-col gap-2 p-4 bg-[#fafafa] rounded-[10px] transition-all duration-300 hover:bg-[#fef5ed] hover:translate-y-[-2px]">
                        <span class="info-label text-[0.8rem] font-semibold text-gray-600 uppercase tracking-[0.5px]">Booking Created</span>
                        <span class="info-value text-[1.05rem] font-semibold text-black"><?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></span>
                    </div>
                </div>
            </div>

            <!-- Package Details -->
            <div class="p-8 bg-gradient-to-r from-[#fafafa] to-[#f5f5f5]">
                <div class="section-title text-[1rem] font-bold text-black uppercase mb-5 tracking-[1px] flex items-center gap-3">
                    Package Details
                </div>
                <div class="details-grid flex flex-col gap-4">
                    <!-- Attendee Categories -->
                    <div class="detail-card bg-white p-6 rounded-[12px] border-l-[5px] border-[#BF9374] shadow-md transition-all duration-300 hover:translate-y-[-3px] hover:shadow-lg flex flex-col">
                        <div class="detail-label text-[0.85rem] font-bold text-gray-600 mb-4 uppercase tracking-[0.5px] border-b-2 border-[#f0f0f0] pb-2">
                            👥 Attendee Categories
                        </div>
                        <div class="detail-value text-[1rem] text-black leading-[1.8] font-medium">
                            <?php 
                            $attendees = $row['attendee_categories'] ?? '';
                            if ($attendees !== '' && strpos(trim($attendees), '{') === 0) {
                                $data = json_decode($attendees, true);
                                if ($data && is_array($data)) {
                                    foreach ($data as $category => $count) {
                                        echo '<div class="flex justify-between items-center p-2.5 border-b border-gray-100 bg-gray-50 rounded-md mb-1 last:border-b-0 last:mb-0">
                                            <span class="font-medium text-gray-800 text-sm">' . htmlspecialchars($category) . '</span>
                                            <span class="bg-gradient-to-r from-[#BF9374] to-[#D4A574] text-black px-3.5 py-1.5 rounded-full font-bold text-sm">' . intval($count) . '</span>
                                        </div>';
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
                    <div class="detail-card bg-white p-6 rounded-[12px] border-l-[5px] border-[#BF9374] shadow-md transition-all duration-300 hover:translate-y-[-3px] hover:shadow-lg flex flex-col">
                        <div class="detail-label text-[0.85rem] font-bold text-gray-600 mb-4 uppercase tracking-[0.5px] border-b-2 border-[#f0f0f0] pb-2">
                            🍽️ Menu Items
                        </div>
                        <div class="detail-value text-[1rem] text-black leading-[1.8] font-medium">
                            <?php 
                            $menu = $row['menu_items'] ?? '';
                            if ($menu !== '' && strpos($menu, '[{') === 0) {
                                $items = json_decode($menu, true);
                                if ($items && is_array($items)) {
                                    foreach ($items as $item) {
                                        $qty = isset($item['quantity']) ? intval($item['quantity']) : 1;
                                        $price = isset($item['price']) ? $item['price'] : 0;
                                        $subtotal = $qty * $price;
                                        echo '<div class="flex justify-between items-center p-3 border-b border-gray-100 mb-2 bg-gray-50 rounded-lg last:border-b-0 last:mb-0">
                                            <div class="flex-1 flex flex-col gap-1">
                                                <div class="font-semibold text-gray-800 text-sm">' . htmlspecialchars($item['name']) . '</div>
                                                <div class="flex gap-5 text-sm text-gray-600">
                                                    <span class="bg-gray-200 px-2.5 py-1 rounded font-semibold text-gray-700">Qty: ' . $qty . '</span>
                                                    <span class="text-green-600 font-semibold">₱' . number_format($price, 2) . '</span>
                                                </div>
                                            </div>
                                            <div class="font-bold text-gray-800 text-sm">₱' . number_format($subtotal, 2) . '</div>
                                        </div>';
                                    }
                                } else {
                                    echo '<div class="text-gray-500 italic text-center py-4">No menu items</div>';
                                }
                            } else {
                                echo '<div class="text-gray-500 italic text-center py-4">' . htmlspecialchars($menu ?: 'N/A') . '</div>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Decorations -->
                    <div class="detail-card bg-white p-6 rounded-[12px] border-l-[5px] border-[#BF9374] shadow-md transition-all duration-300 hover:translate-y-[-3px] hover:shadow-lg flex flex-col">
                        <div class="detail-label text-[0.85rem] font-bold text-gray-600 mb-4 uppercase tracking-[0.5px] border-b-2 border-[#f0f0f0] pb-2">
                            🎨 Decorations
                        </div>
                        <div class="detail-value text-[1rem] text-black leading-[1.8] font-medium">
                            <?php 
                            $decor = $row['decorations'] ?? '';
                            if ($decor !== '' && strpos($decor, '[{') === 0) {
                                $items = json_decode($decor, true);
                                if ($items && is_array($items)) {
                                    foreach ($items as $item) {
                                        $qty = isset($item['quantity']) ? intval($item['quantity']) : 1;
                                        $price = isset($item['price']) ? $item['price'] : 0;
                                        $subtotal = $qty * $price;
                                        echo '<div class="flex justify-between items-center p-3 border-b border-gray-100 mb-2 bg-gray-50 rounded-lg last:border-b-0 last:mb-0">
                                            <div class="flex-1 flex flex-col gap-1">
                                                <div class="font-semibold text-gray-800 text-sm">' . htmlspecialchars($item['name']) . '</div>
                                                <div class="flex gap-5 text-sm text-gray-600">
                                                    <span class="bg-gray-200 px-2.5 py-1 rounded font-semibold text-gray-700">Qty: ' . $qty . '</span>
                                                    <span class="text-green-600 font-semibold">₱' . number_format($price, 2) . '</span>
                                                </div>
                                            </div>
                                            <div class="font-bold text-gray-800 text-sm">₱' . number_format($subtotal, 2) . '</div>
                                        </div>';
                                    }
                                } else {
                                    echo '<div class="text-gray-500 italic text-center py-4">No decorations</div>';
                                }
                            } else {
                                echo '<div class="text-gray-500 italic text-center py-4">' . htmlspecialchars($decor ?: 'N/A') . '</div>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Sound System -->
                    <div class="detail-card bg-white p-6 rounded-[12px] border-l-[5px] border-[#BF9374] shadow-md transition-all duration-300 hover:translate-y-[-3px] hover:shadow-lg flex flex-col">
                        <div class="detail-label text-[0.85rem] font-bold text-gray-600 mb-4 uppercase tracking-[0.5px] border-b-2 border-[#f0f0f0] pb-2">
                            🔊 Sound System
                        </div>
                        <div class="detail-value text-[1rem] text-black leading-[1.8] font-medium">
                            <?php 
                            $sound = $row['sound'] ?? '';
                            if ($sound !== '' && strpos($sound, '[{') === 0) {
                                $items = json_decode($sound, true);
                                if ($items && is_array($items)) {
                                    foreach ($items as $item) {
                                        $qty = isset($item['quantity']) ? intval($item['quantity']) : 1;
                                        $price = isset($item['price']) ? $item['price'] : 0;
                                        $subtotal = $qty * $price;
                                        echo '<div class="flex justify-between items-center p-3 border-b border-gray-100 mb-2 bg-gray-50 rounded-lg last:border-b-0 last:mb-0">
                                            <div class="flex-1 flex flex-col gap-1">
                                                <div class="font-semibold text-gray-800 text-sm">' . htmlspecialchars($item['name']) . '</div>
                                                <div class="flex gap-5 text-sm text-gray-600">
                                                    <span class="bg-gray-200 px-2.5 py-1 rounded font-semibold text-gray-700">Qty: ' . $qty . '</span>
                                                    <span class="text-green-600 font-semibold">₱' . number_format($price, 2) . '</span>
                                                </div>
                                            </div>
                                            <div class="font-bold text-gray-800 text-sm">₱' . number_format($subtotal, 2) . '</div>
                                        </div>';
                                    }
                                } else {
                                    echo '<div class="text-gray-500 italic text-center py-4">No sound system</div>';
                                }
                            } else {
                                echo '<div class="text-gray-500 italic text-center py-4">' . htmlspecialchars($sound ?: 'N/A') . '</div>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Total Cost -->
                    <div class="detail-card bg-white p-6 rounded-[12px] border-l-[5px] border-[#BF9374] shadow-md transition-all duration-300 hover:translate-y-[-3px] hover:shadow-lg flex flex-col">
                        <div class="detail-label text-[0.85rem] font-bold text-gray-600 mb-4 uppercase tracking-[0.5px] border-b-2 border-[#f0f0f0] pb-2">
                            💰 Total Package Cost
                        </div>
                        <div class="detail-value text-[2.5rem] font-extrabold text-center py-4 border-4 border-green-100 rounded-xl mt-3 bg-gradient-to-r from-green-500 to-green-700 bg-clip-text text-transparent">
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
            <div class="empty-state-icon text-[5rem] mb-5 opacity-30"></div>
            <h3 class="m-0 mb-4 text-[1.8rem] text-black font-bold">No Bookings Found</h3>
            <p class="text-[1.1rem] text-gray-700 leading-[1.6] mb-5">
                You haven't made any bookings yet. Start by <a href="../booking pages/set_schedule.php" class="text-[#BF9374] font-semibold no-underline transition-colors duration-300 hover:text-[#A87D5F] hover:underline">setting a schedule</a>.
            </p>
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
    <script src="../assets/js/sidebar-bookings.js"></script>
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