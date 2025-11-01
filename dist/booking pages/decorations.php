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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['user_' . $user_id . '_decorations'] = $_POST;
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
    
    <form id="reservationForm" action="sound_system.php" method="post" class="flex-1">
 
    <div class="content-section border-custom border-primary-brown bg-light-bg p-5" id="decor-section">
        <h2 class="text-[25px] mb-1 text-black font-poppins">Decorations</h2>
        <p class="text-[17px] text-black mb-1 font-poppins">Transform your venue with beautiful decorations.</p>

        <div class="tab-menu bg-white p-1 rounded-custom h-[12%] w-full flex gap-2.5 mb-6 border border-black" id="decor-tabs">
            <div class="tab-item active text-[18px] cursor-pointer text-black h-10 w-[285px] bg-light-gray rounded-custom border border-black pt-1.5 text-center mx-auto font-poppins" data-tab-target="flowers">Flowers</div>
            <div class="tab-item text-[18px] cursor-pointer text-black h-10 w-[285px] bg-light-gray rounded-custom border border-black pt-1.5 text-center mx-auto font-poppins" data-tab-target="lighting">Lighting</div>
            <div class="tab-item text-[18px] cursor-pointer text-black h-10 w-[285px] bg-light-gray rounded-custom border border-black pt-1.5 text-center mx-auto font-poppins" data-tab-target="extras">Extras</div>
        </div>

        <!-- FIXED: Removed flex flex-col gap-4 classes that were overriding display:none -->
        <div id="flowers" class="item-list active">
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Roses" data-price="400">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Flowers/pic1.png" alt="Roses" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Roses</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Classic and timeless, perfect for weddings and anniversaries. <b>(Php.400)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Tulips" data-price="350">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Flowers/pic2.png" alt="Tulips" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Tulips</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Fresh and colorful, best for birthdays, spring-themed, or garden parties. <b>(Php.350)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Lilies" data-price="380">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Flowers/pic3.png" alt="Lilies" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Lilies</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Elegant and fragrant, ideal for weddings, baptisms, and formal gatherings. <b>(Php.380)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Peonies" data-price="500">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Flowers/pic4.png" alt="Peonies" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Peonies</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Lush and romantic, suited for grand weddings, debuts, and engagements. <b>(Php.500)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Purple Orchid" data-price="450">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Flowers/pic5.png" alt="Purple Orchid" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Purple Orchid</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Exotic and long-lasting, great for corporate events, galas, or high-end celebrations. <b>(Php.450)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Ranunculus" data-price="300">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Flowers/pic6.png" alt="Ranunculus" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Ranunculus</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Comes in pastel shades (pink, peach, cream) as well as bold colors, perfect for spring events. <b>(Php.300)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Celosia" data-price="250">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Flowers/pic7.png" alt="Celosia" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Celosia</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Bright, colorful celosia flowers in full bloom, adding a lively and festive touch for your event. <b>(Php.250)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Dahlia" data-price="320">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Flowers/pic8.png" alt="Dahlia" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Dahlia</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Cheerful dahlias bursting with color, bringing vibrant energy and joy to the celebration. <b>(Php.320)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Chrysanthemum" data-price="280">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Flowers/pic9.png" alt="Chrysanthemum" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Chrysanthemum</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">A symbol of joy and long life, with petals that radiate outward. <b>(Php.280)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <input type="hidden" name="decor_selection" id="decor_selection_input">
            <button type="button" class="confirm-phase-btn w-1/4 py-3 mt-5 bg-[#0fdf3cff] text-black border border-black rounded-custom text-base cursor-pointer ml-[400px] font-poppins" data-phase-target="sound-section">
                Confirm Decorations & Proceed
            </button>
        </div>
        
        <!-- FIXED: Removed flex flex-col gap-4 classes -->
        <div id="lighting" class="item-list">
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Fairy light Canopy" data-price="2500">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Lighting/pic1.png" alt="Fairy light Canopy" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Fairy light Canopy</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Fairy lights arranged above the venue like canopy, perfect for magical and romantic events. <b>(Php.2500)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Up Lighting Glow" data-price="500">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Lighting/pic2.png" alt="Up Lighting Glow" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Up Lighting Glow</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Lights are placed at the bottom of walls or pillars to shine upward. <b>(Php.500)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Dance floor Illumination" data-price="1800">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Lighting/pic3.png" alt="Dance floor Illumination" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Dance floor Illumination</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Special lights focused on the dance floor, making it colorful and fun. <b>(Php.1800)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Gobo Lightning" data-price="800">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Lighting/pic4.png" alt="Gobo Lightning" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Gobo Lightning</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Lights used to project designs, shapes, or even names onto walls or floors. <b>(Php.800)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Chandeliers" data-price="1200">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Lighting/pic5.png" alt="Chandeliers" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Chandeliers</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">To give a touch of elegance and make the event feel more grand and special. <b>(Php.1200)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Mason Jar Light" data-price="200">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Lighting/pic6.png" alt="Mason Jar Light" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Mason Jar Light</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Simple jars filled with fairy lights or LED candles, glowing warmly as décor pieces. <b>(Php.200)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Mirror Ball Tunnel" data-price="3500">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Lighting/pic7.png" alt="Mirror Ball Tunnel" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Mirror Ball Tunnel</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">A tunnel decorated with mirrored disco balls and spotlights, reflecting moving lights everywhere, creating a sparkling entrance effect.. <b>(Php.3500)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Water Ripple Lighting" data-price="1500">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Lighting/pic8.png" alt="Water Ripple Lighting" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Water Ripple Lighting</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Projector lights that make ceilings or walls look like moving waves, giving a calm underwater or beach vibe.. <b>(Php.1500)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Laser Tunnel Entrance" data-price="4000">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Lighting/pic9.png" alt="Laser Tunnel Entrance" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Laser Tunnel Entrance</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">A dramatic entrance with colorful laser beams forming a tunnel that guests walk through.. <b>(Php.4000)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <input type="hidden" name="decor_selection" id="decor_selection_input">
            <button type="button" class="confirm-phase-btn w-1/4 py-3 mt-5 bg-accent-green text-black border border-black rounded-custom text-base cursor-pointer ml-[400px] font-poppins" data-phase-target="sound-section">
                Confirm Decorations & Proceed
            </button>
        </div>
        
        <!-- FIXED: Removed flex flex-col gap-4 classes -->
        <div id="extras" class="item-list">
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Balloon Arrangement (Party)" data-price="1500">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Extras/pic1.png" alt="Balloon Arrangement (Party)" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Balloon Arrangement</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Best for birthdays, debuts, weddings, graduations, and parties. <b>(Php.1500)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Balloon Arrangement (Formal)" data-price="2500">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Extras/pic2.png" alt="Balloon Arrangement (Formal)" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Balloon Arrangement</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Best for weddings, formal events, corporate gatherings, and gala dinners. <b>(Php.2500)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Light Up Letters" data-price="3000">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Extras/pic3.png" alt="Light Up Letters" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Light Up Letters</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Best for weddings, birthdays, engagements, anniversaries, and corporate events. <b>(Php.3000)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Photo Booth Corner" data-price="1100">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Extras/pic4.png" alt="Photo Booth Corner" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Photo Booth Corner</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">A fun spot with props, backdrops, and optional instant prints for guests. <b>(Php.1100)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Disco Ball and lights" data-price="1000">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Extras/pic5.png" alt="Disco Ball and lights" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">Disco Ball and lights</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">A fun spot where you can dance and listen with upbeat musics. <b>(Php.1000)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Memory Wall" data-price="900">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Extras/pic6.png" alt="Memory Wall" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">MEMORY WALL</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">A wall where guests pin photos or notes to share memories and messages, creating a personal keepsake. <b>(Php.900)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Crystal Curtain" data-price="1800">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Extras/pic7.png" alt="Crystal Curtain" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">CRYSTAL CURTAIN</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Hanging strands of crystals or beads arranged like a sparkling curtain that reflects light beautifully. <b>(Php.1800)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Feather Centerpiece" data-price="1200">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Extras/pic8.png" alt="Feather Centerpiece" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">FEATHER CENTERPIECE</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">Tall vases or stands decorated with elegant feathers, often ostrich feathers, as an alternative to flowers. <b>(Php.1200)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <div class="item-card flex justify-between items-center bg-white p-4 rounded-custom border border-black" data-name="Bubble Machine" data-price="600">
                <div class="item-card-content flex items-center flex-grow">
                    <img src="../assets/images/Decorations/Extras/pic9.png" class="w-20 h-20 object-cover rounded-custom mr-3.5 border border-black">
                    <div>
                        <h4 class="text-black text-[1.3rem] font-poppins">BUBBLE MACHINE</h4>
                        <p class="m-0 text-base text-black mb-0 leading-[1.3] font-poppins">A machine that produces continuous bubbles, adding a playful, dreamy, and magical touch to the atmosphere. <b>(Php.600)</b></p>
                    </div>
                </div>
                <div class="add-control flex justify-end items-center mt-2.5">
                    <button type="button" class="decor-add-btn bg-light-gray text-[13px] text-black border-none py-2 px-4 rounded-custom border border-black cursor-pointer font-poppins">+ ADD</button>
                </div>
            </div>
            
            <input type="hidden" name="decor_selection" id="decor_selection_input">
            <button type="button" class="confirm-phase-btn w-1/4 py-3 mt-5 bg-accent-green text-black border border-black rounded-custom text-base cursor-pointer ml-[400px] font-poppins" data-phase-target="sound-section">
                Confirm Decorations & Proceed
            </button>
        </div>
    </div>
    </form>
  </main>
  <!-- [ Main Content ] end -->

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
  <script src="../assets/js/booking_system.js"></script>
  <script src="../assets/js/sidebar-bookings.js"></script>
  
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