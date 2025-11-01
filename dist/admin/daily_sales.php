<?php
session_start();
include('../../database/db_config.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ==================== SALES DATA QUERIES ====================

// Daily Sales - TODAY
$daily_sales_query = "SELECT SUM(total_cost) as daily_sales, COUNT(*) as daily_bookings 
                     FROM bookings 
                     WHERE DATE(created_at) = CURDATE() AND status = 'ACCEPT'";
$daily_result = $conn->query($daily_sales_query);
$daily_data = $daily_result->fetch_assoc();
$daily_sales = $daily_data['daily_sales'] ?: 0;
$daily_bookings = $daily_data['daily_bookings'] ?: 0;

// Yesterday Sales for comparison
$yesterday_sales_query = "SELECT SUM(total_cost) as yesterday_sales 
                         FROM bookings 
                         WHERE DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND status = 'ACCEPT'";
$yesterday_result = $conn->query($yesterday_sales_query);
$yesterday_data = $yesterday_result->fetch_assoc();
$yesterday_sales = $yesterday_data['yesterday_sales'] ?: 0;

// Calculate daily growth
$daily_growth = 0;
if ($yesterday_sales > 0 && $daily_sales > 0) {
    $daily_growth = (($daily_sales - $yesterday_sales) / $yesterday_sales) * 100;
} elseif ($daily_sales > 0) {
    $daily_growth = 100;
}

// Monthly Sales - CURRENT MONTH
$monthly_sales_query = "SELECT SUM(total_cost) as monthly_sales, COUNT(*) as monthly_bookings 
                       FROM bookings 
                       WHERE MONTH(created_at) = MONTH(CURDATE()) 
                       AND YEAR(created_at) = YEAR(CURDATE()) 
                       AND status = 'ACCEPT'";
$monthly_result = $conn->query($monthly_sales_query);
$monthly_data = $monthly_result->fetch_assoc();
$monthly_sales = $monthly_data['monthly_sales'] ?: 0;
$monthly_bookings = $monthly_data['monthly_bookings'] ?: 0;

// Previous Month Sales
$prev_month_sales_query = "SELECT SUM(total_cost) as prev_month_sales 
                          FROM bookings 
                          WHERE MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                          AND YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                          AND status = 'ACCEPT'";
$prev_month_result = $conn->query($prev_month_sales_query);
$prev_month_data = $prev_month_result->fetch_assoc();
$prev_month_sales = $prev_month_data['prev_month_sales'] ?: 0;

// Calculate monthly growth
$monthly_growth = 0;
if ($prev_month_sales > 0 && $monthly_sales > 0) {
    $monthly_growth = (($monthly_sales - $prev_month_sales) / $prev_month_sales) * 100;
} elseif ($monthly_sales > 0) {
    $monthly_growth = 100;
}

// Total Revenue (All Time)
$total_revenue_query = "SELECT SUM(total_cost) as total_revenue FROM bookings WHERE status = 'ACCEPT'";
$total_revenue_result = $conn->query($total_revenue_query);
$total_revenue_data = $total_revenue_result->fetch_assoc();
$total_revenue = $total_revenue_data['total_revenue'] ?: 0;

// Average Booking Value
$avg_booking_query = "SELECT AVG(total_cost) as avg_booking FROM bookings WHERE status = 'ACCEPT'";
$avg_booking_result = $conn->query($avg_booking_query);
$avg_booking_data = $avg_booking_result->fetch_assoc();
$avg_booking = $avg_booking_data['avg_booking'] ?: 0;

// Last 7 Days Sales Data for Bar Chart
$weekly_sales_query = "SELECT 
    DATE(created_at) as sale_date,
    SUM(total_cost) as daily_total,
    COUNT(*) as booking_count
    FROM bookings 
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
    AND status = 'ACCEPT'
    GROUP BY DATE(created_at)
    ORDER BY sale_date DESC 
    LIMIT 7";
$weekly_result = $conn->query($weekly_sales_query);
$weekly_sales = [];
$weekly_dates = [];
$weekly_totals = [];

while($row = $weekly_result->fetch_assoc()) {
    $weekly_sales[] = $row;
    $weekly_dates[] = date('M j', strtotime($row['sale_date']));
    $weekly_totals[] = (float)$row['daily_total'];
}

// Reverse to show oldest to newest
$weekly_dates = array_reverse($weekly_dates);
$weekly_totals = array_reverse($weekly_totals);

// Revenue by Event Type for Pie Chart
$event_type_revenue_query = "SELECT 
    event_type,
    SUM(total_cost) as type_revenue,
    COUNT(*) as type_count
    FROM bookings 
    WHERE status = 'ACCEPT'
    GROUP BY event_type
    ORDER BY type_revenue DESC";
$event_type_result = $conn->query($event_type_revenue_query);
$event_types = [];
$event_revenues = [];
$event_counts = [];

while($row = $event_type_result->fetch_assoc()) {
    $event_types[] = $row['event_type'];
    $event_revenues[] = (float)$row['type_revenue'];
    $event_counts[] = (int)$row['type_count'];
}

// Recent Orders (Last 5 Accepted Bookings)
$recent_orders_query = "SELECT 
    booking_id,
    name,
    event_type,
    total_cost,
    created_at
    FROM bookings 
    WHERE status = 'ACCEPT'
    ORDER BY created_at DESC 
    LIMIT 5";
$recent_orders_result = $conn->query($recent_orders_query);
$recent_orders = [];

while($row = $recent_orders_result->fetch_assoc()) {
    $recent_orders[] = $row;
}

// Total Bookings Count
$total_bookings_query = "SELECT COUNT(*) as total FROM bookings";
$total_bookings_result = $conn->query($total_bookings_query);
$total_bookings_data = $total_bookings_result->fetch_assoc();
$total_bookings = $total_bookings_data['total'] ?: 0;

// Success Rate Calculation
$accepted_bookings_query = "SELECT COUNT(*) as accepted FROM bookings WHERE status = 'ACCEPT'";
$accepted_bookings_result = $conn->query($accepted_bookings_query);
$accepted_bookings_data = $accepted_bookings_result->fetch_assoc();
$accepted_bookings = $accepted_bookings_data['accepted'] ?: 0;
$success_rate = $total_bookings > 0 ? ($accepted_bookings / $total_bookings) * 100 : 0;
?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    <title>Daily Sales Report - Event Reservation System</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../assets/images/ERFEOlogo.png">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/css_darkmode/daily_sales_dm.css" />
    <link rel="stylesheet" href="../assets/css/responsive/daily_sales.css" />
    <link rel="stylesheet" href="../assets/css/main/daily_sales.css" />
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
                <!-- Daily Sales Card -->
                <div class="summary-card daily">
                    <span>Daily Sales</span>
                    <h3>₱<?php echo number_format($daily_sales, 2); ?></h3>
                    <div class="flex items-center justify-between">
                        <p><?php echo $daily_bookings; ?> bookings today</p>
                        <span class="growth-indicator <?php echo $daily_growth >= 0 ? 'growth-positive' : 'growth-negative'; ?>">
                            <?php echo $daily_growth >= 0 ? '↗' : '↘'; ?>
                            <?php echo number_format(abs($daily_growth), 1); ?>%
                        </span>
                    </div>
                </div>
                
                <!-- Monthly Sales Card -->
                <div class="summary-card monthly">
                    <span>Monthly Sales</span>
                    <h3>₱<?php echo number_format($monthly_sales, 2); ?></h3>
                    <div class="flex items-center justify-between">
                        <p><?php echo $monthly_bookings; ?> bookings this month</p>
                        <span class="growth-indicator <?php echo $monthly_growth >= 0 ? 'growth-positive' : 'growth-negative'; ?>">
                            <?php echo $monthly_growth >= 0 ? '↗' : '↘'; ?>
                            <?php echo number_format(abs($monthly_growth), 1); ?>%
                        </span>
                    </div>
                </div>

                <!-- Total Revenue Card -->
                <div class="summary-card revenue">
                    <span>Total Revenue</span>
                    <h3>₱<?php echo number_format($total_revenue, 2); ?></h3>
                    <p>All-time earnings</p>
                </div>

                <!-- Average Booking Card -->
                <div class="summary-card average">
                    <span>Average Booking</span>
                    <h3>₱<?php echo number_format($avg_booking, 2); ?></h3>
                    <p>Per accepted booking</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <!-- Bar Chart -->
                <div class="chart-panel">
                    <h3>7-Day Sales Trend</h3>
                    <div class="chart-container">
                        <canvas id="salesBarChart"></canvas>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="chart-panel">
                    <h3>Revenue by Event Type</h3>
                    <div class="chart-container">
                        <canvas id="revenuePieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="bottom-section">
                <!-- Recent Orders -->
                <div class="recent-orders">
                    <h3>Recent Orders</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Customer</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Event</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Amount</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php if (!empty($recent_orders)): ?>
                                    <?php foreach($recent_orders as $order): ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-3 py-2 whitespace-nowrap text-xs font-semibold text-gray-900">#<?php echo $order['booking_id']; ?></td>
                                        <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-900"><?php echo htmlspecialchars($order['name']); ?></td>
                                        <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-900">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <?php echo htmlspecialchars($order['event_type']); ?>
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 whitespace-nowrap text-xs font-bold text-green-600">₱<?php echo number_format($order['total_cost'], 2); ?></td>
                                        <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-500"><?php echo date('M j, Y', strtotime($order['created_at'])); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="px-3 py-4 text-center text-gray-500 text-xs">
                                            <i class="fas fa-inbox text-2xl mb-1 opacity-30"></i>
                                            <p>No recent orders</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="stats-panel">
                    <h3>Quick Stats</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div>
                                <p class="text-xs font-semibold text-blue-800 uppercase tracking-wide">Total Bookings</p>
                                <p class="text-lg font-bold text-blue-900 mt-1"><?php echo $total_bookings; ?></p>
                            </div>
                            <i class="fas fa-calendar-check text-blue-500 text-lg"></i>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                            <div>
                                <p class="text-xs font-semibold text-green-800 uppercase tracking-wide">Success Rate</p>
                                <p class="text-lg font-bold text-green-900 mt-1"><?php echo number_format($success_rate, 1); ?>%</p>
                            </div>
                            <i class="fas fa-chart-pie text-green-500 text-lg"></i>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg border border-purple-200">
                            <div>
                                <p class="text-xs font-semibold text-purple-800 uppercase tracking-wide">Monthly Avg</p>
                                <p class="text-lg font-bold text-purple-900 mt-1"><?php echo round($monthly_bookings / 1); ?></p>
                            </div>
                            <i class="fas fa-chart-line text-purple-500 text-lg"></i>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-200">
                            <div>
                                <p class="text-xs font-semibold text-orange-800 uppercase tracking-wide">Daily Avg</p>
                                <p class="text-lg font-bold text-orange-900 mt-1"><?php echo round($daily_bookings / 1); ?></p>
                            </div>
                            <i class="fas fa-chart-bar text-orange-500 text-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- [ Main ] end -->

    <script>
    // Bar Chart - 7 Days Sales Trend - MAS MALIIT
    const barCtx = document.getElementById('salesBarChart').getContext('2d');
    const salesBarChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($weekly_dates); ?>,
            datasets: [{
                label: 'Daily Sales (₱)',
                data: <?php echo json_encode($weekly_totals); ?>,
                backgroundColor: '#BF9374',
                borderColor: 'rgba(0, 0, 0, 1)',
                borderWidth: 1,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₱' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        },
                        font: {
                            size: 9 // Pinaliit ang font
                        },
                        padding: 5
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 9 // Pinaliit ang font
                        },
                        padding: 5
                    }
                }
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10,
                    left: 10,
                    right: 10
                }
            }
        }
    });

    // Pie Chart - Revenue by Event Type - MAS MALIIT
    const pieCtx = document.getElementById('revenuePieChart').getContext('2d');
    const revenuePieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($event_types); ?>,
            datasets: [{
                data: <?php echo json_encode($event_revenues); ?>,
                backgroundColor: [
                    'rgba(246, 164, 92, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(250, 128, 183, 1)',
                    'rgba(168, 85, 247, 0.8)',
                ],
                borderColor: [
                    'rgba(246, 164, 92, 0.8)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(59, 130, 246, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(250, 128, 183, 1)',
                    'rgba(168, 85, 247, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '0%', // Mas malaki ang cutout para mas maliit ang chart
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 8, // Pinaliit
                        padding: 6, // Pinaliit
                        font: {
                            size: 12 // Pinaliit ang font
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ₱${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10,
                    left: 10,
                    right: 10
                }
            }
        }
    });

    // Auto-refresh data every 30 seconds
    setInterval(() => {
        location.reload();
    }, 3000000);
    </script>

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
    layout_theme_sidebar_change('dark');
    change_box_container('false');
    layout_caption_change('true');
    layout_rtl_change('false');
    preset_change('preset-1');
    main_layout_change('vertical');
    </script>
</body>
</html>