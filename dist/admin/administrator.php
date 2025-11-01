<?php
session_start();
include('../../database/db_config.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// HANDLE EDIT BOOKING!!!
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_booking'])) {
    $booking_id = (int)$_POST['booking_id'];
    $total_guests = (int)$_POST['total_guests'];
    $menu_items = $_POST['menu_items'];
    $decorations = $_POST['decorations'];
    $sound = $_POST['sound_system'];
    
    // FIX: Ensure total_cost is properly converted to float
    $total_cost = isset($_POST['total_cost']) && $_POST['total_cost'] !== '' 
        ? (float)$_POST['total_cost'] 
        : 0.00;
    
    // DEBUG: Log the values (remove after fixing)
    error_log("=== EDIT BOOKING DEBUG ===");
    error_log("Booking ID: " . $booking_id);
    error_log("Total Cost Received: " . $_POST['total_cost']);
    error_log("Total Cost Converted: " . $total_cost);
    error_log("Total Cost Type: " . gettype($total_cost));
    
    // Validation
    if ($total_cost <= 0) {
        echo "<script>
            alert('Error: Total cost cannot be zero or empty! Please add items to the booking.'); 
            window.location.href='administrator.php?tab=pending';
        </script>";
        exit();
    }
    
    $stmt = $conn->prepare("UPDATE bookings SET 
        total_expected_guests = ?,
        menu_items = ?,
        decorations = ?,
        sound = ?,
        total_cost = ?,
        updated_at = NOW()
        WHERE booking_id = ?");
    
    // FIX: Using 'd' for double/float
    $stmt->bind_param("isssdi", $total_guests, $menu_items, $decorations, $sound, $total_cost, $booking_id);
    
    if ($stmt->execute()) {
        // Verify the update
        $verify = $conn->prepare("SELECT total_cost FROM bookings WHERE booking_id = ?");
        $verify->bind_param("i", $booking_id);
        $verify->execute();
        $result = $verify->get_result();
        $row = $result->fetch_assoc();
        
        error_log("Updated Total Cost in DB: " . $row['total_cost']);
        $verify->close();
        
        echo "<script>
            alert('Booking details updated successfully! Total Cost: ₱" . number_format($total_cost, 2) . "'); 
            window.location.href='administrator.php?tab=pending';
        </script>";
    } else {
        error_log("SQL Error: " . $conn->error);
        echo "<script>
            alert('Error updating booking: " . addslashes($conn->error) . "'); 
            window.location.href='administrator.php?tab=pending';
        </script>";
    }
    $stmt->close();
    exit();
}

// ============================================
// UPDATED: HANDLE ACCEPT/DECLINE ACTIONS!!!
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['reservation_id'])) {
    $reservation_id = (int)$_POST['reservation_id'];
    $action = $_POST['action'];
    $owner_message = $_POST['owner_message'] ?? '';
    
    if ($action === 'approve') {
        // STEP 1: Get user_id from the booking
        $get_user = $conn->prepare("SELECT user_id FROM bookings WHERE booking_id = ?");
        $get_user->bind_param("i", $reservation_id);
        $get_user->execute();
        $result = $get_user->get_result();
        
        if ($result->num_rows > 0) {
            $booking = $result->fetch_assoc();
            $user_id = $booking['user_id'];
            $get_user->close();
            
            // STEP 2: Update booking status to ACCEPT
            $stmt = $conn->prepare("UPDATE bookings SET status = 'ACCEPT', updated_at = NOW() WHERE booking_id = ?");
            $stmt->bind_param("i", $reservation_id);
            
            if ($stmt->execute()) {
                // STEP 3: Insert notification WITH user_id (KEY FIX!)
                $message = "Your booking (ID: $reservation_id) has been ACCEPTED! " . $owner_message;
                $stmt2 = $conn->prepare("INSERT INTO inbox (user_id, booking_id, message, created_at) VALUES (?, ?, ?, NOW())");
                $stmt2->bind_param("iis", $user_id, $reservation_id, $message);
                
                if ($stmt2->execute()) {
                    echo "<script>alert('Booking ACCEPTED and notification sent!'); window.location.href='administrator.php';</script>";
                } else {
                    echo "<script>alert('Booking accepted but notification failed: " . addslashes($conn->error) . "'); window.location.href='administrator.php';</script>";
                }
                $stmt2->close();
            } else {
                echo "<script>alert('Error accepting booking: " . addslashes($conn->error) . "'); window.location.href='administrator.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error: Booking not found!'); window.location.href='administrator.php';</script>";
        }
        
    } elseif ($action === 'decline') {
        // STEP 1: Get user_id from the booking
        $get_user = $conn->prepare("SELECT user_id FROM bookings WHERE booking_id = ?");
        $get_user->bind_param("i", $reservation_id);
        $get_user->execute();
        $result = $get_user->get_result();
        
        if ($result->num_rows > 0) {
            $booking = $result->fetch_assoc();
            $user_id = $booking['user_id'];
            $get_user->close();
            
            // STEP 2: Update booking status to DECLINE
            $stmt = $conn->prepare("UPDATE bookings SET status = 'DECLINE', updated_at = NOW() WHERE booking_id = ?");
            $stmt->bind_param("i", $reservation_id);
            
            if ($stmt->execute()) {
                // STEP 3: Insert notification WITH user_id (KEY FIX!)
                $message = "Your booking (ID: $reservation_id) has been DECLINED. " . $owner_message;
                $stmt2 = $conn->prepare("INSERT INTO inbox (user_id, booking_id, message, created_at) VALUES (?, ?, ?, NOW())");
                $stmt2->bind_param("iis", $user_id, $reservation_id, $message);
                
                if ($stmt2->execute()) {
                    echo "<script>alert('Booking DECLINED and notification sent!'); window.location.href='administrator.php';</script>";
                } else {
                    echo "<script>alert('Booking declined but notification failed: " . addslashes($conn->error) . "'); window.location.href='administrator.php';</script>";
                }
                $stmt2->close();
            } else {
                echo "<script>alert('Error declining booking: " . addslashes($conn->error) . "'); window.location.href='administrator.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error: Booking not found!'); window.location.href='administrator.php';</script>";
        }
    }
    exit();
}

// FETCH ALL BOOKINGS!!!
$sql = "SELECT * FROM bookings ORDER BY event_date ASC, event_time ASC";
$bookings = $conn->query($sql);

// COUNT BY STATUS!!!
$pending_result = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE status = 'PENDING'");
$pending_events = $pending_result->fetch_assoc()['count'];

$finished_result = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE status = 'ACCEPT' OR status = 'DECLINE'");
$finished_events = $finished_result->fetch_assoc()['count'];

// FETCH EVENTS FOR CALENDAR!!!
$calendar_sql = "SELECT event_date, COUNT(*) as count FROM bookings WHERE status = 'ACCEPT' GROUP BY event_date";
$calendar_events = $conn->query($calendar_sql);
$event_dates = [];
while($cal = $calendar_events->fetch_assoc()) {
    $event_dates[$cal['event_date']] = $cal['count'];
}
?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <title>Event Reservation Administrator Dashboard</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../assets/images/ERFEOlogo.png">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/administator.css" />
    <link rel="stylesheet" href="../assets/css/css_darkmode/administrator.css" />
    <link rel="stylesheet" href="../assets/css/responsive/administrator.css" />
    <link rel="stylesheet" href="../assets/css/main/administrator.css" />
</head>
<body>
<!-- Preloader -->
<div class="loader-bg fixed inset-0 bg-white z-[1034]">
    <div class="loader-track h-[5px] w-full absolute top-0 overflow-hidden">
        <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0"></div>
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
    <!-- [ Sidebar ] start -->
    <?php include '../includes/sidebar.php'; ?>
    <!-- [ Sidebar ] end -->
    
    <!-- [ Main ] start -->
    <main class="main-content">
        <div class="pc-container">
            <!-- Summary Section -->
            <div class="summary-section">
                <!-- Pending Card -->
                <div class="summary-card pending">
                    <span>Pending Reservations</span>
                    <h3><?php echo $pending_events; ?></h3>
                    <p>Awaiting confirmation</p>
                </div>
                
                <!-- Finished Card -->
                <div class="summary-card finished">
                    <span>Completed Events</span>
                    <h3><?php echo $finished_events; ?></h3>
                    <p>Accepted or declined bookings</p>
                </div>
            </div>

            <!-- Dashboard Layout -->
            <div class="dashboard-layout">
                <!-- Bookings Panel -->
                <div class="bookings-panel">
                    <!-- Tabs -->
                    <div class="tabs">
                        <button id="pendingBtn" class="active" onclick="showTab('pending')">Pending</button>
                        <button id="finishedBtn" onclick="showTab('finished')">Finished</button>
                    </div>

                    <!-- Bookings Container -->
                    <div class="bookings-container">
                        <?php 
                        if ($bookings && $bookings->num_rows > 0) {
                            while($row = $bookings->fetch_assoc()): 
                                $status = $row['status'];
                                $tab = ($status === 'PENDING') ? 'pending' : 'finished';
                        ?>
                        <div class="booking-table <?php echo $tab === 'pending' ? 'active' : ''; ?>" data-tab="<?php echo $tab; ?>">
                            <!-- Table Header -->
                            <div class="table-header">
                                <span class="booking-id-label">BOOKING ID: #<?php echo $row['booking_id']; ?></span>
                                <div class="header-actions">
                                    <?php if($status == 'PENDING'){ ?>
                                        <button onclick='openEditModal(<?php echo json_encode($row); ?>)' class="btn-edit">Edit Booking</button>
                                    <?php } ?>
                                    <span class="status-badge <?php 
                                        echo $status === 'PENDING' ? 'status-pending' : 
                                            ($status === 'ACCEPT' ? 'status-accept' : 'status-decline');
                                    ?>"><?php echo $status; ?></span>
                                    <?php if($status == 'PENDING'){ ?>
                                        <div class="action-buttons">
                                            <button onclick="showActionModal(<?php echo $row['booking_id']; ?>, '<?php echo htmlspecialchars($row['event_type']); ?>', 'approve')" 
                                                class="btn-accept">Accept</button>
                                            <button onclick="showActionModal(<?php echo $row['booking_id']; ?>, '<?php echo htmlspecialchars($row['event_type']); ?>', 'decline')" 
                                                class="btn-decline">Decline</button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Info Section -->
                            <div class="info-section">
                                <div class="section-title">
                                    Information Details
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Name</span>
                                        <span class="info-value"><?php echo htmlspecialchars($row['name']); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Contact Number</span>
                                        <span class="info-value"><?php echo htmlspecialchars($row['contact_number'] ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Address</span>
                                        <span class="info-value"><?php echo htmlspecialchars($row['address'] ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Event Date</span>
                                        <span class="info-value"><?php echo date('M d, Y', strtotime($row['event_date'])); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Event Time</span>
                                        <span class="info-value"><?php echo date('h:i A', strtotime($row['event_time'])); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Event Type</span>
                                        <span class="info-value"><?php echo htmlspecialchars($row['event_type']); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Event Specific Details</span>
                                        <span class="info-value">
                                            <?php 
                                            $event_details = $row['event_specific_details'] ?? '';
                                            if ($event_details !== '' && strpos(trim($event_details), '{') === 0) {
                                                $details = json_decode($event_details, true);
                                                if ($details && is_array($details)) {
                                                    $label_mapping = [
                                                        'groom_name' => "Groom's Name", 'bride_name' => "Bride's Name",
                                                        'child_name' => "Child's Name", 'godparents' => "Godparents",
                                                        'celebrant_name' => "Celebrant's Name", 'age_type' => "Age Type", 'age_value' => "Age",
                                                        'graduate_name' => "Graduate's Name", 'degree' => "Degree/Course",
                                                        'group_name' => "Family/Group Name", 'occasion' => "Occasion",
                                                        'company_name' => "Company Name", 'purpose' => "Event Purpose"
                                                    ];
                                                    foreach ($details as $key => $value) {
                                                        $display_label = $label_mapping[$key] ?? ucwords(str_replace('_', ' ', $key));
                                                        echo '<div><strong>' . htmlspecialchars($display_label) . ':</strong> ' . htmlspecialchars($value) . '</div>';
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
                                    <div class="info-item">
                                        <span class="info-label">Booking ID</span>
                                        <span class="info-value">#<?php echo $row['booking_id']; ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Details -->
                            <div class="booking-details">
                                <div class="section-title">
                                    Booking Details
                                </div>
                                <div class="details-grid">
                                    <!-- Total Guests -->
                                    <div class="detail-item">
                                        <div class="detail-label">Total Expected Guests</div>
                                        <div class="detail-value"><?php echo htmlspecialchars($row['total_expected_guests'] ?? 'N/A'); ?></div>
                                    </div>

                                    <!-- Attendee Categories -->
                                    <div class="detail-item">
                                        <div class="detail-label">Attendee Categories</div>
                                        <div class="detail-value">
                                            <?php 
                                            $attendees = $row['attendee_categories'] ?? '';
                                            if ($attendees !== '' && strpos(trim($attendees), '{') === 0) {
                                                $data = json_decode($attendees, true);
                                                if ($data && is_array($data)) {
                                                    foreach ($data as $category => $count) {
                                                        echo '<div class="attendee-category">
                                                            <span class="category-name">' . htmlspecialchars($category) . '</span>
                                                            <span class="category-count">' . intval($count) . '</span>
                                                        </div>';
                                                    }
                                                } else {
                                                    echo htmlspecialchars($attendees);
                                                }
                                            } else {
                                                echo '<div class="no-items">' . htmlspecialchars($attendees ?: 'No attendee categories') . '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Menu Items -->
                                    <div class="detail-item">
                                        <div class="detail-label">Menu Items</div>
                                        <div class="detail-value">
                                            <?php 
                                            $menu = $row['menu_items'] ?? '';
                                            if ($menu !== '' && strpos($menu, '[{') === 0) {
                                                $items = json_decode($menu, true);
                                                if ($items && is_array($items)) {
                                                    foreach ($items as $item) {
                                                        $qty = isset($item['quantity']) ? $item['quantity'] : 1;
                                                        $itemPrice = isset($item['price']) ? $item['price'] : 0;
                                                        $subtotal = $qty * $itemPrice;
                                                        echo '<div class="menu-item">
                                                            <div class="item-main">
                                                                <div class="item-name">' . htmlspecialchars($item['name']) . '</div>
                                                                <div class="item-details">
                                                                    <span class="item-qty">Qty: ' . $qty . '</span>
                                                                    <span class="item-price">₱' . number_format($itemPrice, 2) . '</span>
                                                                </div>
                                                            </div>
                                                            <div class="item-subtotal">₱' . number_format($subtotal, 2) . '</div>
                                                        </div>';
                                                    }
                                                } else {
                                                    echo htmlspecialchars($menu);
                                                }
                                            } else {
                                                echo '<div class="no-items">' . htmlspecialchars($menu ?: 'No menu items selected') . '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Decorations -->
                                    <div class="detail-item">
                                        <div class="detail-label">Decorations</div>
                                        <div class="detail-value">
                                            <?php 
                                            $decorations = $row['decorations'] ?? '';
                                            if ($decorations !== '' && strpos($decorations, '[{') === 0) {
                                                $items = json_decode($decorations, true);
                                                if ($items && is_array($items)) {
                                                    foreach ($items as $item) {
                                                        $qty = isset($item['quantity']) ? $item['quantity'] : 1;
                                                        $itemPrice = isset($item['price']) ? $item['price'] : 0;
                                                        $subtotal = $qty * $itemPrice;
                                                        echo '<div class="decoration-item">
                                                            <div class="item-main">
                                                                <div class="item-name">' . htmlspecialchars($item['name']) . '</div>
                                                                <div class="item-details">
                                                                    <span class="item-qty">Qty: ' . $qty . '</span>
                                                                    <span class="item-price">₱' . number_format($itemPrice, 2) . '</span>
                                                                </div>
                                                            </div>
                                                            <div class="item-subtotal">₱' . number_format($subtotal, 2) . '</div>
                                                        </div>';
                                                    }
                                                } else {
                                                    echo htmlspecialchars($decorations);
                                                }
                                            } else {
                                                echo '<div class="no-items">' . htmlspecialchars($decorations ?: 'No decorations selected') . '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Sound System -->
                                    <div class="detail-item">
                                        <div class="detail-label">Sound System</div>
                                        <div class="detail-value">
                                            <?php 
                                            $sound = $row['sound'] ?? '';
                                            if ($sound !== '' && strpos($sound, '[{') === 0) {
                                                $items = json_decode($sound, true);
                                                if ($items && is_array($items)) {
                                                    foreach ($items as $item) {
                                                        $qty = isset($item['quantity']) ? $item['quantity'] : 1;
                                                        $itemPrice = isset($item['price']) ? $item['price'] : 0;
                                                        $subtotal = $qty * $itemPrice;
                                                        echo '<div class="sound-item">
                                                            <div class="item-main">
                                                                <div class="item-name">' . htmlspecialchars($item['name']) . '</div>
                                                                <div class="item-details">
                                                                    <span class="item-qty">Qty: ' . $qty . '</span>
                                                                    <span class="item-price">₱' . number_format($itemPrice, 2) . '</span>
                                                                </div>
                                                            </div>
                                                            <div class="item-subtotal">₱' . number_format($subtotal, 2) . '</div>
                                                        </div>';
                                                    }
                                                } else {
                                                    echo htmlspecialchars($sound);
                                                }
                                            } else {
                                                echo '<div class="no-items">' . htmlspecialchars($sound ?: 'No sound system selected') . '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Total Cost -->
                                    <div class="detail-item">
                                        <div class="detail-label">Total Cost</div>
                                        <div class="detail-value">
                                            <div class="cost-highlight">₱<?php echo number_format($row['total_cost'], 2); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                            endwhile; 
                        } else {
                            echo '<div class="no-bookings">No bookings found.</div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Calendar Panel -->
                <div class="calendar-panel">
                    <h3>Event Calendar</h3>
                    <div class="calendar">
                        <div class="calendar-header">
                            <button onclick="prevMonth()">◀</button>
                            <span id="currentMonth"></span>
                            <button onclick="nextMonth()">▶</button>
                        </div>
                        <div class="calendar-days">
                            <div class="calendar-day">Sun</div>
                            <div class="calendar-day">Mon</div>
                            <div class="calendar-day">Tue</div>
                            <div class="calendar-day">Wed</div>
                            <div class="calendar-day">Thu</div>
                            <div class="calendar-day">Fri</div>
                            <div class="calendar-day">Sat</div>
                        </div>
                        <div id="calendarDates" class="calendar-dates"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- [ Main ] end -->

    <!-- [ Approve/Decline Modal ] start -->
    <div id="actionModal" class="modal-backdrop">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h4>Reservation Action: ID <span id="modalResId"></span> - <span id="modalEventType"></span></h4>
            
            <form method="POST" action="administrator.php">
                <input type="hidden" name="reservation_id" id="modalResIdInput">
                
                <label for="owner_message"><strong>Message to Customer (Optional):</strong></label>
                <textarea name="owner_message" id="owner_message" rows="4" placeholder="Enter your message here..."></textarea>
                
                <div class="modal-footer">
                    <button type="submit" name="action" value="decline" class="modal-btn decline">Decline</button>
                    <button type="submit" name="action" value="approve" class="modal-btn approve">Approve</button>
                </div>
            </form>
        </div>
    </div>
    <!-- [ Approve/Decline Modal ] end -->

    <!-- [ Edit Booking Modal ] start -->
    <div id="editModal" class="modal-backdrop">
        <div class="modal-content modal-content-large">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <h4>Edit Booking Details - ID <span id="editBookingId"></span></h4>
            
            <form method="POST" action="administrator.php" id="editBookingForm">
                <input type="hidden" name="edit_booking" value="1">
                <input type="hidden" name="booking_id" id="edit_booking_id">
                <input type="hidden" name="attendee_categories" id="edit_attendee_categories">
                <input type="hidden" name="menu_items" id="edit_menu_items">
                <input type="hidden" name="decorations" id="edit_decorations">
                <input type="hidden" name="sound_system" id="edit_sound_system">
                <input type="hidden" name="total_cost" id="edit_total_cost" value="0">

                <!-- Total Expected Guests -->
                <div class="edit-section">
                    <h5>Total Expected Guests</h5>
                    <input type="number" name="total_guests" id="edit_total_guests" min="1" max="500" required>
                </div>

                <!-- Menu Items -->
                <div class="edit-section">
                    <h5>Menu Items</h5>
                    <div class="menu-dropdown">
                        <label>Category:</label>
                        <select id="menuCategory" onchange="loadMenuItems()">
                            <option value="">Select Category</option>
                            <option value="appetizers">Appetizers</option>
                            <option value="main">Main Course</option>
                            <option value="beverages">Beverages</option>
                            <option value="desserts">Desserts</option>
                        </select>
                        
                        <label>Item:</label>
                        <select id="menuItem">
                            <option value="">Select Item First</option>
                        </select>
                        
                        <div class="quantity-input">
                            <input type="number" id="menuQty" min="1" value="1" placeholder="Qty">
                            <button type="button" onclick="addMenuItem()">Add Menu Item</button>
                        </div>
                    </div>
                    <div id="selectedMenuItems" class="selected-items"></div>
                </div>

                <!-- Decorations -->
                <div class="edit-section">
                    <h5>Decorations</h5>
                    <div class="decoration-dropdown">
                        <label>Category:</label>
                        <select id="decorCategory" onchange="loadDecorations()">
                            <option value="">Select Category</option>
                            <option value="flowers">Flowers</option>
                            <option value="lighting">Lighting</option>
                            <option value="extras">Extras</option>
                        </select>
                        
                        <label>Item:</label>
                        <select id="decorItem">
                            <option value="">Select Item First</option>
                        </select>
                        
                        <div class="quantity-input">
                            <input type="number" id="decorQty" min="1" value="1" placeholder="Qty">
                            <button type="button" onclick="addDecoration()">Add Decoration</button>
                        </div>
                    </div>
                    <div id="selectedDecorations" class="selected-items"></div>
                </div>

                <!-- Sound System -->
                <div class="edit-section">
                    <h5>Sound System</h5>
                    <div class="sound-dropdown">
                        <label>Category:</label>
                        <select id="soundCategory" onchange="loadSoundSystem()">
                            <option value="">Select Category</option>
                            <option value="audio">Audio Systems</option>
                            <option value="extras">Extras</option>
                        </select>
                        
                        <label>Item:</label>
                        <select id="soundItem">
                            <option value="">Select Item First</option>
                        </select>
                        
                        <div class="quantity-input">
                            <input type="number" id="soundQty" min="1" value="1" placeholder="Qty">
                            <button type="button" onclick="addSoundSystem()">Add Sound Item</button>
                        </div>
                    </div>
                    <div id="selectedSoundSystem" class="selected-items"></div>
                </div>

                <!-- Total Cost -->
                <div class="edit-section">
                    <h5>Total Cost</h5>
                    <div class="cost-highlight">₱<span id="displayTotalCost">0.00</span></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="modal-btn save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <!-- [ Edit Booking Modal ] end -->

    <!-- [ Footer ] start -->
    <?php include '../includes/footer.php'; ?>
    <!-- [ Footer] end -->
     
    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/icon/custom-icon.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
    <script src="../assets/js/component.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/script.js"></script>
    
    <script>
    window.eventDatesData = <?php echo json_encode($event_dates); ?>;
    </script>
    <script src="../assets/js/administrator.js"></script>
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