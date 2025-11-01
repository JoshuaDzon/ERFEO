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
    $_SESSION['user_' . $user_id . '_menu'] = $_POST;
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
                        'accent-green': '#0fdf3cff',
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
      
    <form id="reservationForm" action="decorations.php" method="post" class="flex-1">
    
    <!-- PHASE 4 MENU -->
    <div class="content-section border-custom border-primary-brown bg-light-bg p-5" id="menu-section">
        <h2 class="text-[25px] mb-1 text-black font-poppins">Menu Planning</h2>
        <p class="text-[17px] text-black mb-1 font-poppins">Create the perfect dining experience for your guest</p>
        <div class="tab-menu bg-white p-1 rounded-custom h-[12%] w-full flex gap-2.5 mb-6 border border-black" id="menu-tabs">

        <!-- Menu Tabs -->
            <div class="menu-tab-item active text-[18px] cursor-pointer text-black h-10 w-[285px] bg-light-gray rounded-custom border border-black pt-1.5 text-center mx-auto font-poppins" data-tab-target="appetizers">Appetizers</div>
            <div class="menu-tab-item text-[18px] cursor-pointer text-black h-10 w-[285px] bg-light-gray rounded-custom border border-black pt-1.5 text-center mx-auto font-poppins" data-tab-target="main-course">Main Course</div>
            <div class="menu-tab-item text-[18px] cursor-pointer text-black h-10 w-[285px] bg-light-gray rounded-custom border border-black pt-1.5 text-center mx-auto font-poppins" data-tab-target="beverages">Beverages</div>
            <div class="menu-tab-item text-[18px] cursor-pointer text-black h-10 w-[285px] bg-light-gray rounded-custom border border-black pt-1.5 text-center mx-auto font-poppins" data-tab-target="desserts">Desserts</div>
        </div>
        
        <div id="appetizers" class="menu-tab-content active">
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Cheese Stuffed Crispy Potato" data-price="85">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Appetizers/pic1.png" alt=" " class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Cheese Stuffed Crispy Potato</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Inspired by Western comfort food. <b>(Php.85)</b> <span class="serving-suggestion">Best for 2-4 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Cheese Stuffed Crispy Potato" value="0" min="0" data-price="85" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Tamarind-Glazed Chicken wings" data-price="110">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Appetizers/pic2.png" alt=" " class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Tamarind-Glazed Chicken wings</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Filipino version style of chicken wings. <b>(Php.110)</b> <span class="serving-suggestion">Good for 3-6 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Tamarind-Glazed Chicken wings" value="0" min="0" data-price="110" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Kesong Puti Caprese Skewers" data-price="90">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Appetizers/pic3.png" alt="Kesong Puti Skewers" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Kesong Puti Caprese Skewers</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Filipino and Italian fusion. <b>(Php.90)</b> <span class="serving-suggestion">Best for 4-8 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Kesong Puti Caprese Skewers" value="0" min="0" data-price="90" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Prawn Cocktails" data-price="130">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Appetizers/pic4.png" alt="Prawn Cocktails" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Prawn Cocktails</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Western cuisine, salty appetizer. <b>(Php.130)</b> <span class="serving-suggestion">Good for 2-4 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Prawn Cocktails" value="0" min="0" data-price="130" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Stuffed Mushroom" data-price="95">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Appetizers/pic5.png" alt="Stuffed Mushroom" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Stuffed Mushroom</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Mushroom caps filled with cheese. <b>(Php.95)</b> <span class="serving-suggestion">Best for 3-5 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Stuffed Mushroom" value="0" min="0" data-price="95" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="French Onion dip cups" data-price="80">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Appetizers/pic6.png" alt="French Onion Dip Cups" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">French Onion dip cups</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Tasty little cups packed with warm, creamy, and cheesy onion dip. <b>(Php.80)</b> <span class="serving-suggestion">Good for 4-8 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_French Onion dip cups" value="0" min="0" data-price="80" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Cheese Broccoli Puffs" data-price="85">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Appetizers/pic7.png" alt="Cheese Broccoli Puffs" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Cheese Broccoli Puffs</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Puff pastry with broccoli tucked inside, melty mozzarella, creamy ricotta and fragrant dill. <b>(Php.85)</b> <span class="serving-suggestion">Best for 3-6 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Cheese Broccoli Puffs" value="0" min="0" data-price="85" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Spanish Tortilla" data-price="100">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Appetizers/pic8.png" alt="Spanish Tortilla" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Spanish Tortilla</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Traditional Spanish tortilla with potatoes, onions, and eggs roasted with piquillo peppers. <b>(Php.100)</b> <span class="serving-suggestion">Good for 5-10 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Spanish Tortilla" value="0" min="0" data-price="100" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Proscuitto-Wrapped Melon" data-price="120">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Appetizers/pic9.png" alt="Prosciutto-Wrapped Melon" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Proscuitto-Wrapped Melon</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Classic Italian appetizer combines slices of sweet melon wrapped in thin, salty prosciutto. <b>(Php.120)</b> <span class="serving-suggestion">Best for 2-4 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Proscuitto-Wrapped Melon" value="0" min="0" data-price="120" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
        </div>
        
        <div id="main-course" class="menu-tab-content">
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Spaghetti" data-price="120">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Main Course/pic1.png" alt="Spaghetti" onerror="this.src='https://via.placeholder.com/80?text=Main+1'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Spaghetti</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Cylindrical pasta with tomato-based sauce, ground beef, onion, garlic, basil, and parmesan cheese <b>(Php.120)</b> <span class="serving-suggestion">Best for 3-6 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Spaghetti" value="0" min="0" data-price="120" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Shrimp Carbonara Pasta" data-price="150">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Main Course/pic2.png" alt="Shrimp Carbonara Pasta" onerror="this.src='https://via.placeholder.com/80?text=Main+2'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Shrimp Carbonara Pasta</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Creamy pasta made with shrimp, bacon, eggs, cheese, and black pepper <b>(Php.150)</b> <span class="serving-suggestion">Good for 2-4 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Shrimp Carbonara Pasta" value="0" min="0" data-price="150" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Honey Glazed Salmon with Rice" data-price="230">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Main Course/pic3.png" alt="Honey Glazed Salmon with Rice" onerror="this.src='https://via.placeholder.com/80?text=Main+3'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Honey Glazed Salmon with Rice</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Sweet-savory dish with tender salmon coated in honey glaze, served over steamed rice with vegetables <b>(Php.230)</b> <span class="serving-suggestion">Best for 1-2 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Honey Glazed Salmon with Rice" value="0" min="0" data-price="230" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Beef Metchado with Rice" data-price="180">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Main Course/pic4.png" alt="Beef Metchado with Rice" onerror="this.src='https://via.placeholder.com/80?text=Main+4'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Beef Metchado with Rice</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Beef stew simmered in tomato sauce with potatoes and carrots for a hearty, savory dish <b>(Php.180)</b> <span class="serving-suggestion">Best for 2-5 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Beef Metchado with Rice" value="0" min="0" data-price="180" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Curried Chicken and Rice Casserole" data-price="160">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Main Course/pic5.png" alt="Curried Chicken and Rice Casserole" onerror="this.src='https://via.placeholder.com/80?text=Main+5'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Curried Chicken and Rice Casserole</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Tender curried chicken with vegetables layered in bottom of casserole with coconut rice on top <b>(Php.160)</b> <span class="serving-suggestion">Good for 4-8 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Curried Chicken and Rice Casserole" value="0" min="0" data-price="160" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Cordon Bleu" data-price="170">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Main Course/pic6.png" alt="Cordon Bleu" onerror="this.src='https://via.placeholder.com/80?text=Main+6'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Cordon Bleu</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Chicken with flour coated with crispy bread crumbs with savory sauce <b>(Php.170)</b> <span class="serving-suggestion">Best for 1-2 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Cordon Bleu" value="0" min="0" data-price="170" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Lemon and Garlic Roast Chicken" data-price="160">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Main Course/pic7.png" alt="Lemon and Garlic Roast Chicken" onerror="this.src='https://via.placeholder.com/80?text=Main+7'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Lemon and Garlic Roast Chicken</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Classic roast chicken with bacon on top, head of garlic and a sliced lemon to flavor the sauce <b>(Php.160)</b> <span class="serving-suggestion">Good for 3-6 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Lemon and Garlic Roast Chicken" value="0" min="0" data-price="160" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Beef Wellington" data-price="3888">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Main Course/pic8.png" alt="Beef Wellington" onerror="this.src='https://via.placeholder.com/80?text=Main+8'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Beef Wellington</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Baked steak dish made out of fillet steak and duxelles wrapped in shortcrust pastry <b>(Php.3888)</b> <span class="serving-suggestion">Premium dish for 6-10 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Beef Wellington" value="0" min="0" data-price="3888" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Beer Braised Beef with Clams" data-price="220">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Main Course/pic9.png" alt="Beer Braised Beef with Clams" onerror="this.src='https://via.placeholder.com/80?text=Main+9'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Beer Braised Beef with Clams</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Combination of beef and clam rich in savory flavors of slow-cooked beef stew woth essence of steamed clams<b>(Php.220)</b> <span class="serving-suggestion">Best for 3-5 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Beer Braised Beef with Clams" value="0" min="0" data-price="220" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
        </div>

        <div id="beverages" class="menu-tab-content">
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Royal Select" data-price="180">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Beverages/pic1.png" alt="Royal Select" onerror="this.src='https://via.placeholder.com/80?text=Beverage+3'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Royal Select</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">A festive-free juice with a lively sparkle (Php.180) <span class="serving-suggestion">Serves 8-12 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Royal Select" value="0" min="0" data-price="180" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Wine Selection" data-price="200">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Beverages/pic2.png" alt="Wine Selection" onerror="this.src='https://via.placeholder.com/80?text=Beverage+2'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Wine Selection</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Curated wine pairings (Php.200) <span class="serving-suggestion">Good for 6-10 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Wine Selection" value="0" min="0" data-price="200" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Chivas Regal" data-price="230">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Beverages/pic3.png" alt="Chivas Regal" onerror="this.src='https://via.placeholder.com/80?text=Beverage+5'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Chivas Regal</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">A blended scotch whisky produced by the Chivas Brothers subsidiary of Pernod Ricard (Php.230) <span class="serving-suggestion">Premium for 4-8 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Chivas Regal" value="0" min="0" data-price="230" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Premium Bar Package" data-price="250">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Beverages/pic4.png" alt="Premium Bar Package" onerror="this.src='https://via.placeholder.com/80?text=Beverage+1'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Premium Bar Package</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Top-shelf liquors and craft cocktails (Php.250) <span class="serving-suggestion">Best for 10-20 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Premium Bar Package" value="0" min="0" data-price="250" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Jack Daniels" data-price="220">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Beverages/pic5.png" alt="Jack Daniels" onerror="this.src='https://via.placeholder.com/80?text=Beverage+4'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Jack Daniels</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Hand-selected Tennessee whiskey made from corn, rye, and malted barley, along with water from a spring (Php.220) <span class="serving-suggestion">Good for 5-10 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Jack Daniels" value="0" min="0" data-price="220" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
        </div>

        <div id="desserts" class="menu-tab-content">
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Cheese Cake" data-price="120">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Desserts/pic1.png" alt="Cheese Cake" onerror="this.src='https://via.placeholder.com/80?text=Dessert+1'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Cheese Cake</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Smooth, creamy, cheesy with fresh fruit toppings (Php.120) <span class="serving-suggestion">Serves 6-8 slices</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Cheese Cake" value="0" min="0" data-price="120" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Tiramisu" data-price="130">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Desserts/pic2.png" alt="Tiramisu" onerror="this.src='https://via.placeholder.com/80?text=Dessert+2'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Tiramisu</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Classic Italian layered dessert (Php.130) <span class="serving-suggestion">Good for 4-6 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Tiramisu" value="0" min="0" data-price="130" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Macaroons" data-price="90">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Desserts/pic3.png" alt="Macaroons" onerror="this.src='https://via.placeholder.com/80?text=Dessert+3'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Macaroons</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">French meringue-based sandwich cookies (Php.90) <span class="serving-suggestion">12 pieces, good for 6-12 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Macaroons" value="0" min="0" data-price="90" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Cup Cake" data-price="80">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Desserts/pic4.png" alt="Cup Cake" onerror="this.src='https://via.placeholder.com/80?text=Dessert+4'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Cup Cake</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Sweet baked with frosting on top (Php.80) <span class="serving-suggestion">Individual serving</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Cup Cake" value="0" min="0" data-price="80" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Charcuterie" data-price="150">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Desserts/pic5.png" alt="Charcuterie" onerror="this.src='https://via.placeholder.com/80?text=Dessert+5'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Charcuterie</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Board of sweet treats with chocolate salami (Php.150) <span class="serving-suggestion">Best for 4-8 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Charcuterie" value="0" min="0" data-price="150" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Buckeye Bundt Cake" data-price="110">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Desserts/pic6.png" alt="Buckeye Bundt Cake" onerror="this.src='https://via.placeholder.com/80?text=Dessert+6'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Buckeye Bundt Cake</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">A creamy peanut butter cheesecake with chocolate cake, and topping of melted semisweet chocolate (Php.110) <span class="serving-suggestion">Serves 8-10 slices</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Buckeye Bundt Cake" value="0" min="0" data-price="110" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Cake Pops" data-price="85">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Desserts/pic7.png" alt="Cake Pops" onerror="this.src='https://via.placeholder.com/80?text=Dessert+7'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Cake Pops</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Bite-sized balls of cake mixed with frosting, coated in icing, and served on sticks with colorful decorations (Php.85) <span class="serving-suggestion">6 pieces, good for 3-6 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Cake Pops" value="0" min="0" data-price="85" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Strawberry Pretzel Salad" data-price="100">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Desserts/pic8.png" alt="Strawberry Pretzel Salad" onerror="this.src='https://via.placeholder.com/80?text=Dessert+8'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Strawberry Pretzel Salad</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Layered dessert made with a crunchy pretzel crust, creamy sweet filling, and strawberry gelatin topped with fresh strawberries (Php.100) <span class="serving-suggestion">Good for 4-6 guests</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Strawberry Pretzel Salad" value="0" min="0" data-price="100" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Carrot Cake" data-price="115">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Menu/Desserts/pic9.png" alt="Carrot Cake" onerror="this.src='https://via.placeholder.com/80?text=Dessert+9'" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Carrot Cake</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Moist spiced cake made with grated carrots, often layered with cream cheese frosting (Php.115) <span class="serving-suggestion">Serves 8-12 slices</span></p>
                    </div>
                </div>
                <div class="quantity-control flex items-center gap-1 border border-black rounded-custom overflow-hidden">
                    <button type="button" class="menu-decrement w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">-</button>
                    <input type="number" name="menu_qty_Carrot Cake" value="0" min="0" data-price="115" class="menu-qty-input w-[35px] text-center py-1 font-poppins text-black ml-2.5 px-1">
                    <button type="button" class="menu-increment w-[30px] bg-light-gray text-black py-1 px-2.5 cursor-pointer font-poppins">+</button>
                </div>
            </div>
        </div>

        <input type="hidden" name="menu_items" id="menu_selection_input">
        <button type="button" class="confirm-phase-btn w-1/4 py-3 mt-5 bg-accent-green text-black border border-black rounded-custom text-base cursor-pointer ml-[400px] font-poppins" data-phase-target="decor-section">Confirm Menu & Proceed</button>
    </div>
    </form>
  </main>
  <!-- [ Main Content ] end -->
  
  <?php include '../includes/footer.php'; ?>

  <!-- Required Js -->
  <script src="../assets/js/plugins/simplebar.min.js"></script>
  <script src="../assets/js/plugins/popper.min.js"></script>
  <script src="../assets/js/icon/custom-icon.js"></script>
  <script src="../assets/js/plugins/feather.min.js"></script>
  <script src="../assets/js/component.js"></script>
  <script src="../assets/js/theme.js"></script>
  <script src="../assets/js/script.js"></script>
  <script src="../assets/js/booking_system.js"></script>
  <script src="../assets/js/sidebar-bookings.js"></script>


  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const menuTabs = document.querySelectorAll('.menu-tab-item');
      const menuSections = document.querySelectorAll('.menu-tab-content');

      if (menuTabs.length > 0) {
          menuTabs.forEach(tab => {
              tab.addEventListener('click', function() {
                  menuTabs.forEach(t => t.classList.remove('active'));
                  menuSections.forEach(s => s.classList.remove('active'));
                  
                  this.classList.add('active');
                  
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