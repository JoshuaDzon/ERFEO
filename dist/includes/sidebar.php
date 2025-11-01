 <!-- [ Sidebar Menu ] start -->
 <nav class="pc-sidebar">
   <div class="navbar-wrapper">
     <div class="m-header flex items-center py-4 px-6 h-header-height">
       <a href="#" class="b-brand flex items-center gap-3">
         <img src="../assets/images/ERFEOlogo.png" alt="logo here" />
       </a>
     </div>
     <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
       <div class="shrink-0 flex items-center justify-left mb-5">&nbsp;&nbsp;&nbsp;&nbsp;
         <h5 class="text-left font-medium text-[15px] flex items-center gap-2">
           <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="w-10 rounded-full" />Administrator
         </h5>
       </div>
       <div class="grow ms-3 text-center mb-4">
       </div>
       <ul class="pc-navbar">

         <li class="pc-item"> <!-- Dashboard menu -->
           <a href="../admin/administrator.php" class="pc-link">
             <span class="pc-micon"><i data-feather="home"></i></span>
             <span class="pc-mtext">Dashboard</span>
           </a>
         </li>

         <li class="pc-item"> <!-- Dashboard menu -->
           <a href="../admin/daily_sales.php" class="pc-link">
             <span class="pc-micon"><i data-feather="bar-chart-2"></i></span>
             <span class="pc-mtext">Daily Sales</span>
           </a>
         </li>

         <li class="pc-item"> <!-- Menu 01 -->
           <a href="../admin/logged_users.php" class="pc-link">
             <span class="pc-micon"><i data-feather="users"></i></span>
             <span class="pc-mtext">All Users Registered</span>
           </a>
         </li>

         <li class="pc-item"> <!-- Menu 02 -->
           <a href="../admin/pending_events.php" class="pc-link">
             <span class="pc-micon"><i data-feather="clock"></i></span>
             <span class="pc-mtext">Pending Events</span>
           </a>
         </li>

         <li class="pc-item"> <!-- Menu 03 -->
           <a href="../admin/accepted_events.php" class="pc-link">
             <span class="pc-micon"><i data-feather="check-circle"></i></span>
             <span class="pc-mtext">Accepted Events</span>
           </a>
         </li>

         <li class="pc-item"> <!-- Menu 03 -->
           <a href="../admin/declined_events.php" class="pc-link">
             <span class="pc-micon"><i data-feather="x-circle"></i></span>
             <span class="pc-mtext">Declined Events</span>
           </a>
         </li>

         <li class="pc-item pc-caption">
          <label>Settings</label><i data-feather="wrench"></i>
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