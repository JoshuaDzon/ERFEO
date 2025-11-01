<?php
session_start();
include('../../database/db_config.php');

// ============================================
// CHECK IF USER IS LOGGED IN (CRITICAL FIX!)
// ============================================
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Please login first to make a booking!');
        window.location.href='../authentication/login.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id']; // GET USER ID FROM SESSION

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../booking pages/receipt.php');
    exit();
}

$name           = $_POST['final_name'] ?? '';
$contact_number = $_POST['final_contact_number'] ?? '';
$address        = $_POST['final_address'] ?? '';
$event_date     = $_POST['final_event_date'] ?? '';
$event_time     = $_POST['final_event_time'] ?? '';
$event_type     = $_POST['final_event_type'] ?? '';

$event_specific_details = $_POST['final_event_specific_details'] ?? '';
$total_expected_guests  = (int)($_POST['final_total_expected_guests'] ?? 0);
$attendee_categories    = $_POST['final_attendee_categories'] ?? '';
$menu_items             = $_POST['final_menu_items'] ?? '';
$decorations            = $_POST['final_decor_items'] ?? '';
$sound                  = $_POST['final_sound_items'] ?? '';
$total_cost             = (float)($_POST['final_total_cost'] ?? 0.00);

if (empty($name) || empty($event_date) || empty($event_type)) {
    echo "<script>alert('Missing required booking details'); window.location.href='../booking pages/receipt.php';</script>";
    exit();
}

// ============================================
// UPDATED SQL: NOW INCLUDES user_id! (KEY FIX!)
// ============================================
$sql = "INSERT INTO bookings (
    user_id, name, contact_number, address, event_date, event_time,
    event_type, event_specific_details, total_expected_guests,
    attendee_categories, menu_items, decorations, sound,
    total_cost, status, created_at, updated_at
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'PENDING', NOW(), NOW()
)";

if ($stmt = $conn->prepare($sql)) {
    
    // ============================================
    // UPDATED bind_param: Added 'i' for user_id (KEY FIX!)
    // ============================================
    $stmt->bind_param(
        "isssssssissssd",  // Added 'i' at the start for user_id
        $user_id,          // Added user_id parameter
        $name,
        $contact_number,
        $address,
        $event_date,
        $event_time,
        $event_type,
        $event_specific_details,
        $total_expected_guests,
        $attendee_categories,
        $menu_items,
        $decorations,
        $sound,
        $total_cost
    );
    
    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;
        
        // Clear session data
        unset($_SESSION['booking_data']);
        unset($_SESSION['cart']);
        unset($_SESSION['selected_items']);
        unset($_SESSION['menu_items']);
        unset($_SESSION['decorations']);
        unset($_SESSION['sound_items']);
        
        echo "<script>
            sessionStorage.clear();
            window.location.href='../../landingpage/index.php';
        </script>";
        exit();
    } else {
        // Error
        error_log("MySQL Insert Error: " . $stmt->error);
        echo "<script>
            alert('Database error occurred. Please try again.');
            window.location.href='../booking pages/receipt.php';
        </script>";
        exit();
    }
    
    $stmt->close();
} else {
    error_log("MySQL Prepare Error: " . $conn->error);
    echo "<script>
        alert('System error occurred. Please contact support.');
        window.location.href='../booking pages/receipt.php';
    </script>";
    exit();
}

$conn->close();
?>