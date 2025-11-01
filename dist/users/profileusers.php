<?php
session_start();
include('../../database/db_config.php');

if(!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

if (!isset($_SESSION['user_id'])) {
    die("Session error: Please login again!");
}
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $update_stmt->bind_param("ss", $hashed_password, $username);
            
            if ($update_stmt->execute()) {
                echo "<script>alert('Password changed successfully!');</script>";
            } else {
                echo "<script>alert('Error changing password!');</script>";
            }
            $update_stmt->close();
        } else {
            echo "<script>alert('New passwords do not match!');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect!');</script>";
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    $confirm_delete = $_POST['confirm_delete'];
    
    if ($confirm_delete === 'DELETE') {

        $stmt = $conn->prepare("DELETE FROM bookings WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
        
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        
        if ($stmt->execute()) {
            session_destroy();
            echo "<script>alert('Account deleted successfully!'); window.location.href='../authentication/login.php';</script>";
        } else {
            echo "<script>alert('Error deleting account!');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please type DELETE to confirm account deletion!');</script>";
    }
}

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user_info = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user_info) {
    die("User not found!");
}

$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? ORDER BY event_date DESC, event_time DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bookings = $stmt->get_result();
$stmt->close();

$pending_count = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE user_id = $user_id AND status = 'PENDING'")->fetch_assoc()['count'];
$accepted_count = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE user_id = $user_id AND status = 'ACCEPT'")->fetch_assoc()['count'];
$declined_count = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE user_id = $user_id AND status = 'DECLINE'")->fetch_assoc()['count'];
?>

<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <title>My Profile - Event Reservation</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="../assets/images/ERFEOlogo.png">
    <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/css_darkmode/profileusers_dm.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/responsive/profileusers.css" id="main-style-link" />
    <link rel="stylesheet" href="../assets/css/main/profileusers.css" id="main-style-link" />
</head>
<body class="font-['Poppins'] text-black">
  <!-- Preloader -->
  <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
    <div class="loader-track h-[5px] w-full absolute top-0 overflow-hidden">
      <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
    </div>
  </div>
    <?php include '../includes/header.php'; ?>
    
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

<main class="main-content relative ml-[224px] w-[88.5%] top-16 min-h-[135px] px-10 py-5">
    <div class="max-w-[1200px] mx-auto my-8 px-4">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-[#BF9374] to-[#a67c5d] text-black p-10 rounded-[20px] mb-8 shadow-xl relative overflow-hidden animate-fadeInDown">
            <h1 class="m-0 mb-2 text-[2.2rem] relative z-10">Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <p class="text-black m-0">Manage your profile and view your booking history</p>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fadeInUp" style="animation-delay: 0.2s;">
            <div class="stat-card bg-white p-8 rounded-[16px] shadow-lg text-center transition-all duration-400 border border-[rgba(191,147,116,0.1)] relative overflow-hidden">
                <h3 class="m-0 text-[2.5rem] text-black"><?php echo $pending_count; ?></h3>
                <p class="mt-2 mb-0 text-black uppercase tracking-[0.5px] text-[0.9rem]">Pending Bookings</p>
            </div>
            <div class="stat-card bg-white p-8 rounded-[16px] shadow-lg text-center transition-all duration-400 border border-[rgba(191,147,116,0.1)] relative overflow-hidden">
                <h3 class="m-0 text-[2.5rem] text-black"><?php echo $accepted_count; ?></h3>
                <p class="mt-2 mb-0 text-black uppercase tracking-[0.5px] text-[0.9rem]">Accepted Bookings</p>
            </div>
            <div class="stat-card bg-white p-8 rounded-[16px] shadow-lg text-center transition-all duration-400 border border-[rgba(191,147,116,0.1)] relative overflow-hidden">
                <h3 class="m-0 text-[2.5rem] text-black"><?php echo $declined_count; ?></h3>
                <p class="mt-2 mb-0 text-black uppercase tracking-[0.5px] text-[0.9rem]">Declined Bookings</p>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 animate-fadeInUp" style="animation-delay: 0.3s;">
            <!-- User Information -->
            <div class="profile-card bg-white p-10 rounded-[20px] shadow-lg border border-[rgba(191,147,116,0.1)]">
                <h2 class="m-0 mb-6 pb-4 border-b-4 border-[#BF9374] text-black text-[1.5rem] relative">Account Information</h2>
                <div class="flex justify-between py-4 border-b border-[#f0f0f0] transition-all duration-300">
                    <span class="text-black uppercase text-[0.85rem] tracking-[0.5px]">User ID:</span>
                    <span class="text-black"><?php echo $user_id; ?></span>
                </div>
                <div class="flex justify-between py-4 border-b border-[#f0f0f0] transition-all duration-300">
                    <span class="text-black uppercase text-[0.85rem] tracking-[0.5px]">Username:</span>
                    <span class="text-black"><?php echo htmlspecialchars($username); ?></span>
                </div>
                <div class="flex justify-between py-4 border-b border-[#f0f0f0] transition-all duration-300">
                    <span class="text-black uppercase text-[0.85rem] tracking-[0.5px]">Member Since:</span>
                    <span class="text-black"><?php echo date('F Y', strtotime($user_info['created_at'] ?? 'now')); ?></span>
                </div>
                <div class="mt-8">
                    <button class="btn btn-primary w-full mb-4" onclick="showPasswordModal()">Change Password</button>
                    <button class="btn btn-danger w-full" onclick="showDeleteModal()">Delete Account</button>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="profile-card bg-white p-10 rounded-[20px] shadow-lg border border-[rgba(191,147,116,0.1)] lg:col-span-2">
                <h2 class="m-0 mb-6 pb-4 border-b-4 border-[#BF9374] text-black text-[1.5rem] relative">Quick Actions</h2>
                <p class="text-black mb-6">Start planning your next event</p>
                <div class="grid gap-4">
                    <a href="../booking pages/set_schedule.php" class="btn btn-primary text-center no-underline block">
                        Make New Booking
                    </a>
                </div>
            </div>
        </div>

        <!-- Bookings History with FULL DETAILS -->
        <div class="bookings-section bg-white p-10 rounded-[20px] shadow-lg border border-[rgba(191,147,116,0.1)] animate-fadeInUp" style="animation-delay: 0.4s;">
            <h2 class="text-black mb-6 text-[1.8rem]">My Bookings - Full Details</h2>
            
            <?php if ($bookings && $bookings->num_rows > 0): ?>
                <?php while($booking = $bookings->fetch_assoc()): ?>
                    <div class="booking-card border-2 border-[#f0f0f0] rounded-[16px] p-8 mb-6 transition-all duration-400 bg-white relative overflow-hidden">
                        <div class="booking-header flex justify-between items-center mb-6 pb-4 border-b-2 border-[#f0f0f0]">
                            <span class="booking-id text-[1.3rem] text-black">Booking #<?php echo $booking['booking_id']; ?></span>
                            <span class="status-badge px-6 py-[0.65rem] rounded-[25px] text-[0.9rem] uppercase tracking-[0.5px] shadow-lg status-<?php echo strtolower($booking['status']); ?>">
                                <?php echo htmlspecialchars($booking['status']); ?>
                            </span>
                        </div>

                        <!-- PERSONAL INFORMATION SECTION -->
                        <div class="information-details mb-8 p-6 bg-[#fafafa] rounded-[12px] border-l-4 border-[#BF9374]">
                            <h3 class="text-black mb-4 text-[1.2rem]">Personal Information</h3>
                            <div class="info-grid grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="info-grid-item flex flex-col p-3 bg-white rounded-[8px] border border-[#e0e0e0]">
                                    <span class="info-grid-label text-[0.8rem] text-black uppercase tracking-[0.5px] mb-1">Full Name</span>
                                    <span class="info-grid-value text-black"><?php echo htmlspecialchars($booking['name']); ?></span>
                                </div>
                                <div class="info-grid-item flex flex-col p-3 bg-white rounded-[8px] border border-[#e0e0e0]">
                                    <span class="info-grid-label text-[0.8rem] text-black uppercase tracking-[0.5px] mb-1">Contact Number</span>
                                    <span class="info-grid-value text-black"><?php echo htmlspecialchars($booking['contact_number']); ?></span>
                                </div>
                                <div class="info-grid-item flex flex-col p-3 bg-white rounded-[8px] border border-[#e0e0e0]">
                                    <span class="info-grid-label text-[0.8rem] text-black uppercase tracking-[0.5px] mb-1">Address</span>
                                    <span class="info-grid-value text-black"><?php echo htmlspecialchars($booking['address']); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- EVENT INFORMATION SECTION -->
                        <div class="information-details mb-8 p-6 bg-[#fafafa] rounded-[12px] border-l-4 border-[#BF9374]">
                            <h3 class="text-black mb-4 text-[1.2rem]">Event Information</h3>
                            <div class="info-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="info-grid-item flex flex-col p-3 bg-white rounded-[8px] border border-[#e0e0e0]">
                                    <span class="info-grid-label text-[0.8rem] text-black uppercase tracking-[0.5px] mb-1">Event Type</span>
                                    <span class="info-grid-value text-black"><?php echo htmlspecialchars($booking['event_type']); ?></span>
                                </div>
                                <div class="info-grid-item flex flex-col p-3 bg-white rounded-[8px] border border-[#e0e0e0]">
                                    <span class="info-grid-label text-[0.8rem] text-black uppercase tracking-[0.5px] mb-1">Event Date</span>
                                    <span class="info-grid-value text-black"><?php echo date('F d, Y', strtotime($booking['event_date'])); ?></span>
                                </div>
                                <div class="info-grid-item flex flex-col p-3 bg-white rounded-[8px] border border-[#e0e0e0]">
                                    <span class="info-grid-label text-[0.8rem] text-black uppercase tracking-[0.5px] mb-1">Event Time</span>
                                    <span class="info-grid-value text-black"><?php echo date('h:i A', strtotime($booking['event_time'])); ?></span>
                                </div>
                                <div class="info-grid-item flex flex-col p-3 bg-white rounded-[8px] border border-[#e0e0e0]">
                                    <span class="info-grid-label text-[0.8rem] text-black uppercase tracking-[0.5px] mb-1">Expected Guests</span>
                                    <span class="info-grid-value text-black"><?php echo htmlspecialchars($booking['total_expected_guests']); ?></span>
                                </div>
                                <div class="info-grid-item flex flex-col p-3 bg-white rounded-[8px] border border-[#e0e0e0]">
                                    <span class="info-grid-label text-[0.8rem] text-black uppercase tracking-[0.5px] mb-1">Booking Created</span>
                                    <span class="info-grid-value text-black"><?php echo date('M d, Y h:i A', strtotime($booking['created_at'])); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- PACKAGE DETAILS SECTION -->
                        <div class="package-details mt-6">
                            <h3 class="text-black mb-4 text-[1.2rem] border-b-2 border-[#BF9374] pb-2">Package Details</h3>

                            <!-- Attendee Categories -->
                            <div class="package-item mb-6 p-6 bg-[#f8f9fa] rounded-[12px] border-l-4 border-[#BF9374]">
                                <div class="package-item-title text-black mb-3 text-[1.1rem]">Attendee Categories:</div>
                                <div class="package-item-content text-black">
                                    <?php 
                                    $attendees = $booking['attendee_categories'] ?? '';
                                    if ($attendees !== '' && strpos(trim($attendees), '{') === 0) {
                                        $data = json_decode($attendees, true);
                                        if ($data && is_array($data)) {
                                            foreach ($data as $category => $count) {
                                                echo '<div class="py-2 border-b border-[#f0f0f0]">';
                                                echo '<strong>' . htmlspecialchars($category) . ':</strong> ' . intval($count) . ' persons';
                                                echo '</div>';
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
                            <div class="package-item mb-6 p-6 bg-[#f8f9fa] rounded-[12px] border-l-4 border-[#BF9374]">
                                <div class="package-item-title text-black mb-3 text-[1.1rem]">Menu Items:</div>
                                <div class="package-item-content text-black">
                                    <?php 
                                    $menu = $booking['menu_items'] ?? '';
                                    if ($menu !== '' && strpos($menu, '[{') === 0) {
                                        $items = json_decode($menu, true);
                                        if ($items && is_array($items)) {
                                            foreach ($items as $item) {
                                                echo '<div class="p-3 mb-2 bg-white rounded-[6px] border-l-3 border-[#BF9374]">';
                                                echo '<strong>' . htmlspecialchars($item['name']) . '</strong><br>';
                                                echo '<span class="text-[#666]">Quantity: ' . intval($item['quantity']) . ' | Price: ₱' . number_format($item['price'], 2) . '</span>';
                                                echo '</div>';
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
                            <div class="package-item mb-6 p-6 bg-[#f8f9fa] rounded-[12px] border-l-4 border-[#BF9374]">
                                <div class="package-item-title text-black mb-3 text-[1.1rem]">Decorations:</div>
                                <div class="package-item-content text-black">
                                    <?php 
                                    $decor = $booking['decorations'] ?? '';
                                    if ($decor !== '' && strpos($decor, '[{') === 0) {
                                        $items = json_decode($decor, true);
                                        if ($items && is_array($items)) {
                                            foreach ($items as $item) {
                                                echo '<div class="p-3 mb-2 bg-white rounded-[6px] border-l-3 border-[#BF9374]">';
                                                echo '<strong>' . htmlspecialchars($item['name']) . '</strong><br>';
                                                $qty = isset($item['quantity']) ? 'Quantity: ' . intval($item['quantity']) . ' | ' : '';
                                                echo '<span class="text-[#666]">' . $qty . 'Price: ₱' . number_format($item['price'], 2) . '</span>';
                                                echo '</div>';
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
                            <div class="package-item mb-6 p-6 bg-[#f8f9fa] rounded-[12px] border-l-4 border-[#BF9374]">
                                <div class="package-item-title text-black mb-3 text-[1.1rem]">Sound System:</div>
                                <div class="package-item-content text-black">
                                    <?php 
                                    $sound = $booking['sound'] ?? '';
                                    if ($sound !== '' && strpos($sound, '[{') === 0) {
                                        $items = json_decode($sound, true);
                                        if ($items && is_array($items)) {
                                            foreach ($items as $item) {
                                                echo '<div class="p-3 mb-2 bg-white rounded-[6px] border-l-3 border-[#BF9374]">';
                                                echo '<strong>' . htmlspecialchars($item['name']) . '</strong><br>';
                                                $qty = isset($item['quantity']) ? 'Quantity: ' . intval($item['quantity']) . ' | ' : '';
                                                echo '<span class="text-[#666]">' . $qty . 'Price: ₱' . number_format($item['price'], 2) . '</span>';
                                                echo '</div>';
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
                            <div class="package-item p-6 bg-gradient-to-r from-[#f5f5f5] to-[#e8e8e8] rounded-[12px] border-l-4 border-[#BF9374]">
                                <div class="flex justify-between items-center">
                                    <div class="package-item-title text-black m-0 text-[1.1rem]">TOTAL PACKAGE COST:</div>
                                    <div class="cost-highlight text-[1.5rem] text-black">₱<?php echo number_format($booking['total_cost'], 2); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center py-12 text-[#999]">
                    <p class="text-[1.2rem] mb-4">No bookings yet</p>
                    <a href="../booking pages/set_schedule.php" class="btn btn-primary">Create Your First Booking</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

    <!-- Change Password Modal -->
    <div id="passwordModal" class="modal-backdrop fixed inset-0 bg-black bg-opacity-70 z-[10000] hidden justify-center items-center backdrop-blur-sm">
        <div class="modal-content bg-white text-black p-[40px] rounded-[20px] w-[90%] max-w-[450px] text-base relative text-left shadow-2xl">
            <span class="close-btn absolute top-[15px] right-[20px] text-[2rem] cursor-pointer text-gray-500 hover:text-gray-700" onclick="closePasswordModal()">&times;</span>
            <div class="modal-header text-center mb-[25px]">
                <h4 class="text-[1.8rem] font-extrabold">Change Password</h4>
            </div>
            <form method="POST" action="">
                <div class="form-group mb-6">
                    <label class="text-[0.9rem] font-bold mb-[8px] block">Current Password</label>
                    <input type="password" name="current_password" required 
                           class="w-full p-[14px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-[#fafafa] focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)]">
                </div>
                <div class="form-group mb-6">
                    <label class="text-[0.9rem] font-bold mb-[8px] block">New Password</label>
                    <input type="password" name="new_password" required 
                           class="w-full p-[14px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-[#fafafa] focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)]">
                </div>
                <div class="form-group mb-6">
                    <label class="text-[0.9rem] font-bold mb-[8px] block">Confirm New Password</label>
                    <input type="password" name="confirm_password" required 
                           class="w-full p-[14px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-[#fafafa] focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)]">
                </div>
                <button type="submit" name="change_password" class="modal-btn w-full p-[14px] border-none rounded-[10px] bg-gradient-to-r from-[#28a745] to-[#20c997] hover:from-[#239d3f] hover:to-[#1cb386] text-white text-base font-bold cursor-pointer uppercase">Change Password</button>
            </form>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteModal" class="modal-backdrop fixed inset-0 bg-black bg-opacity-70 z-[10000] hidden justify-center items-center backdrop-blur-sm">
        <div class="modal-content bg-white text-black p-[40px] rounded-[20px] w-[90%] max-w-[450px] text-base relative text-left shadow-2xl">
            <span class="close-btn absolute top-[15px] right-[20px] text-[2rem] cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeDeleteModal()">&times;</span>
            <div class="modal-header text-center mb-[25px]">
                <h4 class="text-[1.8rem] font-extrabold">Delete Account</h4>
            </div>
            <p class="text-[#e74c3c] mb-6"><strong>Warning:</strong> This action cannot be undone. All your bookings will be deleted.</p>
            <form method="POST" action="">
                <div class="form-group mb-6">
                    <label class="text-[0.9rem] font-bold mb-[8px] block">Type "DELETE" to confirm</label>
                    <input type="text" name="confirm_delete" required placeholder="DELETE"
                           class="w-full p-[14px] text-base border-2 border-[#e0e0e0] rounded-[10px] bg-[#fafafa] focus:outline-none focus:border-[#BF9374] focus:ring-2 focus:ring-[rgba(191,147,116,0.1)]">
                </div>
                <button type="submit" name="delete_account" class="modal-btn w-full p-[14px] border-none rounded-[10px] bg-gradient-to-r from-[#e74c3c] to-[#c0392b] hover:from-[#d63031] hover:to-[#b33939] text-white text-base font-bold cursor-pointer uppercase">Delete My Account</button>
            </form>
        </div>
    </div>

    <!-- [ Footer ] start -->
    <?php include '../includes/footer.php'; ?>
    <!-- [ Footer ] end -->

    <script src="../assets/js/plugins/simplebar.min.js"></script>
    <script src="../assets/js/plugins/popper.min.js"></script>
    <script src="../assets/js/icon/custom-icon.js"></script>
    <script src="../assets/js/plugins/feather.min.js"></script>
    <script src="../assets/js/component.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script src="../assets/js/script.js"></script>

    <script>
        function showPasswordModal() {
            document.getElementById('passwordModal').style.display = 'flex';
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
        }

        function showDeleteModal() {
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal-backdrop')) {
                event.target.style.display = 'none';
            }
        }

        layout_theme_sidebar_change('dark');
        change_box_container('false');
        layout_caption_change('true');
        layout_rtl_change('false');
        preset_change('preset-1');
        main_layout_change('vertical');
    </script>
</body>
</html>