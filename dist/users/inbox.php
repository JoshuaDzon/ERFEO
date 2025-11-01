<?php
session_start();
include '../../database/db_config.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: ../authentication/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$sql = "SELECT 
    b.booking_id,
    b.name as customer_name,
    b.event_type,
    b.event_date,
    b.status,
    b.created_at as booking_created,
    COALESCE(i.inbox_id, 0) as inbox_id,
    COALESCE(i.message, CONCAT('Your ', b.event_type, ' booking (ID: ', b.booking_id, ') is pending review by the organizer.')) as message,
    COALESCE(i.is_read, 1) as is_read,
    COALESCE(i.created_at, b.created_at) as created_at
FROM bookings b
LEFT JOIN inbox i ON b.booking_id = i.booking_id
WHERE b.user_id = ?
ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reservation for Event Organizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="../assets/images/ERFEOlogo.png">
    <link rel="stylesheet" href="../assets/css/css_darkmode/inbox_dm.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/responsive/inbox.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/main/inbox.css" id="main-style-link" />
    
</head>
<body class="bg-[#F5F7F9]">
<!-- NAVBAR -->
<nav class="bg-[#BF9374] flex justify-between items-center px-[30px] py-[12px] shadow-lg sticky top-0 z-50">
    <div class="flex items-center">
        <img src="../assets/images/ERFEOlogo.png" alt="Logo" class="h-[45px] w-[45px] rounded-[8px] mr-[10px]">
    </div>
    <ul class="flex items-center gap-[40px] flex-1 justify-end list-none">
        <li><a href="../../landingpage/index.php" class="text-black text-[15px] tracking-[0.5px] no-underline transition-colors duration-300 hover:text-[#f4e3d7]">HOME</a></li>
        <li><a href="../booking pages/set_schedule.php" class="text-black text-[15px] tracking-[0.5px] no-underline transition-colors duration-300 hover:text-[#f4e3d7]">BOOKING</a></li>
        <li><a href="../users/aboutus.php" class="text-black text-[15px] tracking-[0.5px] no-underline transition-colors duration-300 hover:text-[#f4e3d7]">ABOUT US</a></li>
        
        <li class="relative">
            <a href="javascript:void(0)" class="flex items-center" onclick="toggleAccountDropdown()">
                <img src="../assets/images/accicon.png" alt="Account Icon" class="w-[45px] h-[45px] rounded-full object-cover cursor-pointer">
            </a>
            <ul id="accountDropdown" class="absolute top-[58px] right-0 min-w-[120px] overflow-hidden z-50 bg-transparent hidden">
                <li><a href="../users/inbox.php" class="no-underline text-black text-center block px-[20px] py-[12px] transition-colors duration-300 bg-[#E2C7AE] mt-[10px] rounded-[5px] border border-[#8B6F47] hover:bg-[#d4b89d]">INBOX</a></li>
                <li><a href="../authentication/logout.php" class="no-underline text-black text-center block px-[20px] py-[12px] transition-colors duration-300 bg-[#E2C7AE] mt-[10px] rounded-[5px] border border-[#8B6F47] hover:bg-[#d4b89d]">LOG OUT</a></li>
            </ul>
        </li>
    </ul>
</nav>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="max-w-[1200px] mx-auto my-[50px] bg-white rounded-[12px] p-[30px] shadow-xl">
        <div class="flex justify-between items-center mb-[25px] pb-[15px] border-b-2 border-[#e0e0e0]">
            <div class="flex-1">
                <h2 class="m-0 text-[#333] text-[1.8rem] font-semibold flex items-center gap-[10px]">My Notifications</h2>
                <p class="text-[#666] text-[0.95rem] mt-[5px]">Welcome back, <strong><?php echo htmlspecialchars($username); ?></strong>!</p>
            </div>
            <?php
            $unread_sql = "SELECT COUNT(*) as unread_count 
                          FROM inbox i
                          INNER JOIN bookings b ON i.booking_id = b.booking_id
                          WHERE b.user_id = ? AND i.is_read = 0";
            $unread_stmt = $conn->prepare($unread_sql);
            $unread_stmt->bind_param("i", $user_id);
            $unread_stmt->execute();
            $unread_result = $unread_stmt->get_result();
            $unread_count = $unread_result->fetch_assoc()['unread_count'];
            $unread_stmt->close();
            
            if ($unread_count > 0): ?>
                <span class="unread-count bg-[#ff5252] text-white px-[14px] py-[6px] rounded-[20px] text-[0.9rem] font-semibold whitespace-nowrap">
                    <?php echo $unread_count; ?> New
                </span>
            <?php endif; ?>
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-[10px] mb-[20px] pb-[10px] border-b-2 border-[#e0e0e0]">
            <button class="filter-tab px-[20px] py-[10px] bg-[#f5f5f5] border-none rounded-tl-[8px] rounded-tr-[8px] cursor-pointer text-[0.95rem] font-semibold transition-all duration-300 text-[#666] active:bg-[#BF9374] active:text-white" onclick="filterMessages('all')">All</button>
            <button class="filter-tab px-[20px] py-[10px] bg-[#f5f5f5] border-none rounded-tl-[8px] rounded-tr-[8px] cursor-pointer text-[0.95rem] font-semibold transition-all duration-300 text-[#666]" onclick="filterMessages('ACCEPT')">✅ Accepted</button>
            <button class="filter-tab px-[20px] py-[10px] bg-[#f5f5f5] border-none rounded-tl-[8px] rounded-tr-[8px] cursor-pointer text-[0.95rem] font-semibold transition-all duration-300 text-[#666]" onclick="filterMessages('DECLINE')">❌ Declined</button>
            <button class="filter-tab px-[20px] py-[10px] bg-[#f5f5f5] border-none rounded-tl-[8px] rounded-tr-[8px] cursor-pointer text-[0.95rem] font-semibold transition-all duration-300 text-[#666]" onclick="filterMessages('PENDING')">⏳ Pending</button>
        </div>

        <div class="flex flex-col gap-[15px]">
            <?php 
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { 
                    $unread_class = $row['is_read'] == 0 ? 'unread bg-[#e8f4fd]' : 'bg-[#fafafa]';
                    $status = strtoupper($row['status']);
                    $status_class = 'status-' . strtolower($status);
                    $badge_class = 'badge-pending';
                    
                    if ($status == 'ACCEPT') {
                        $badge_class = 'badge-accept';
                    } elseif ($status == 'DECLINE') {
                        $badge_class = 'badge-decline';
                    }
            ?>
                <div class="message-item <?php echo $unread_class; ?> <?php echo $status_class; ?> border-l-4 border-[#BF9374] p-[20px] rounded-[8px] cursor-pointer block" 
                     data-status="<?php echo $status; ?>"
                     onclick="<?php echo $row['inbox_id'] > 0 ? 'markAsRead(' . $row['inbox_id'] . ', this)' : ''; ?>">
                    <div class="flex justify-between items-center mb-[12px]">
                        <span class="text-[1.1rem] font-semibold text-[#333]">
                            Booking Notification
                        </span>
                        <span class="booking-badge <?php echo $badge_class; ?> inline-block px-[14px] py-[6px] rounded-[5px] text-[0.85rem] font-semibold uppercase tracking-[0.5px]">
                            <?php echo htmlspecialchars($status); ?>
                        </span>
                    </div>

                    <div class="text-[#555] leading-[1.6] my-[12px] text-[0.95rem] bg-white p-[15px] rounded-[6px] border-l-3 border-[#e0e0e0]">
                        <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                    </div>

                    <div class="flex justify-between items-center text-[0.9rem] text-[#888] mt-[12px] pt-[12px] border-t border-[#e0e0e0]">
                        <div class="event-info flex gap-[12px] text-[0.85rem] flex-wrap">
                            <span class="bg-[#e9ecef] px-[12px] py-[5px] rounded-[4px] whitespace-nowrap flex items-center gap-[5px]">
                                <?php echo htmlspecialchars($row['event_type'] ?? 'N/A'); ?>
                            </span>
                            <span class="bg-[#e9ecef] px-[12px] py-[5px] rounded-[4px] whitespace-nowrap flex items-center gap-[5px]">
                                <?php echo date('F d, Y', strtotime($row['event_date'])); ?>
                            </span>
                            <span class="bg-[#e9ecef] px-[12px] py-[5px] rounded-[4px] whitespace-nowrap flex items-center gap-[5px]">
                                Booking #<?php echo $row['booking_id']; ?>
                            </span>
                        </div>
                        <span class="timestamp italic text-[0.85rem] text-[#999]">
                            <?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?>
                        </span>
                    </div>
                </div>
            <?php 
                }
            } else { 
            ?>
                <div class="empty-inbox text-center py-[80px] px-[20px] text-[#999]">
                    <div class="empty-inbox-icon text-[5rem] mb-[20px] opacity-30">📭</div>
                    <h3 class="text-[#666] mb-[10px] text-[1.4rem]">No notifications yet</h3>
                    <p class="text-[#999] text-[1rem]">You'll see booking updates and messages here when the event organizer responds to your bookings.</p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="bg-[#BF9374] text-white py-[20px] w-full shadow-lg z-10 flex justify-center items-center text-center mt-auto">
    <div class="w-full max-w-[1200px] mx-auto px-[20px]">
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
<script src="../assets/js/inbox.js"></script>

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
<?php 
$stmt->close();
$conn->close(); 
?>