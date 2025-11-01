/**
=========================================================================
=========================================================================
Template Name: Datta Able - Tailwind Admin Template
Author: CodedThemes
Support: https://codedthemes.support-hub.io/
File: themes.js
Modified: Added persistent dark/light mode with localStorage
=========================================================================
=========================================================================
*/

'use strict';

var rtl_flag = false;
var dark_flag = false;

// ============================================
// INITIALIZE THEME ON PAGE LOAD (BEFORE DOM READY)
// ============================================
(function() {
  // Apply saved theme immediately to prevent flash
  const savedTheme = localStorage.getItem('data-pc-theme');
  if (savedTheme) {
    document.documentElement.setAttribute('data-pc-theme', savedTheme);
  } else {
    // Default to light mode
    document.documentElement.setAttribute('data-pc-theme', 'light');
    localStorage.setItem('data-pc-theme', 'light');
  }
})();

// ============================================
// DOM CONTENT LOADED - INITIALIZE EVERYTHING
// ============================================
document.addEventListener('DOMContentLoaded', function () {
  // Load and apply saved theme
  const savedTheme = localStorage.getItem('data-pc-theme') || 'light';
  layout_change(savedTheme);
  
  // Update theme icon on load
  updateThemeIcon(savedTheme);
  
  // Add event listeners to theme toggle dropdown
  initializeThemeToggle();

  // Check if elements with class 'preset-color' exist
  var if_exist = document.querySelectorAll('.preset-color');
  if (if_exist) {
    var preset_color = document.querySelectorAll('.preset-color > a');
    for (var h = 0; h < preset_color.length; h++) {
      var c = preset_color[h];
      c.addEventListener('click', function (event) {
        var targetElement = event.target;
        if (targetElement.tagName == 'I') {
          targetElement = targetElement.parentNode;
        }
        var presetValue = targetElement.getAttribute('data-value');
        preset_change(presetValue);
      });
    }

    var layout_btn = document.querySelectorAll('.theme-layout .btn');
    for (var t = 0; t < layout_btn.length; t++) {
      if (layout_btn[t]) {
        layout_btn[t].addEventListener('click', function (event) {
          event.stopPropagation();
          var targetElement = event.target;

          if (targetElement.tagName == 'SPAN') {
            targetElement = targetElement.parentNode;
          }
          if (targetElement.getAttribute('data-value') == 'true') {
            localStorage.setItem('data-pc-theme', 'light');
            document.documentElement.setAttribute('data-pc-theme', 'light');
          } else {
            localStorage.setItem('data-pc-theme', 'dark');
            document.documentElement.setAttribute('data-pc-theme', 'dark');
          }
        });
      }
    }
  }

  // Initialize SimpleBar on elements with class 'pct-body'
  if (document.querySelector('.pct-body')) {
    new SimpleBar(document.querySelector('.pct-body'));
  }

  // Reset layout on button click
  var layout_reset = document.querySelector('#layoutreset');
  if (layout_reset) {
    layout_reset.addEventListener('click', function (e) {
      localStorage.clear();
      location.reload();
      localStorage.setItem('layout', 'vertical');
    });
  }

  // Other color/theme selectors
  var if_exist = document.querySelectorAll('.header-color');
  if (if_exist) {
    var preset_color = document.querySelectorAll('.header-color > a');
    for (var h = 0; h < preset_color.length; h++) {
      var c = preset_color[h];
      c.addEventListener('click', function (event) {
        var targetElement = event.target;
        if (targetElement.tagName == 'SPAN' || targetElement.tagName == 'I') {
          targetElement = targetElement.parentNode;
        }
        var temp = targetElement.getAttribute('data-value');
        header_change(temp);
      });
    }
  }

  var if_exist = document.querySelectorAll('.navbar-color');
  if (if_exist) {
    var preset_color = document.querySelectorAll('.navbar-color > a');
    for (var h = 0; h < preset_color.length; h++) {
      var c = preset_color[h];
      c.addEventListener('click', function (event) {
        var targetElement = event.target;
        if (targetElement.tagName == 'SPAN' || targetElement.tagName == 'I') {
          targetElement = targetElement.parentNode;
        }
        var temp = targetElement.getAttribute('data-value');
        navbar_change(temp);
      });
    }
  }

  var if_exist = document.querySelectorAll('.logo-color');
  if (if_exist) {
    var preset_color = document.querySelectorAll('.logo-color > a');
    for (var h = 0; h < preset_color.length; h++) {
      var c = preset_color[h];
      c.addEventListener('click', function (event) {
        var targetElement = event.target;
        if (targetElement.tagName == 'SPAN' || targetElement.tagName == 'I') {
          targetElement = targetElement.parentNode;
        }
        var temp = targetElement.getAttribute('data-value');
        logo_change(temp);
      });
    }
  }

  var if_exist = document.querySelectorAll('.caption-color');
  if (if_exist) {
    var preset_color = document.querySelectorAll('.caption-color > a');
    for (var h = 0; h < preset_color.length; h++) {
      var c = preset_color[h];
      c.addEventListener('click', function (event) {
        var targetElement = event.target;
        if (targetElement.tagName == 'SPAN' || targetElement.tagName == 'I') {
          targetElement = targetElement.parentNode;
        }
        var temp = targetElement.getAttribute('data-value');
        caption_change(temp);
      });
    }
  }

  var if_exist = document.querySelectorAll('.navbar-img');
  if (if_exist) {
    var preset_color = document.querySelectorAll('.navbar-img > a');
    for (var h = 0; h < preset_color.length; h++) {
      var c = preset_color[h];
      c.addEventListener('click', function (event) {
        var targetElement = event.target;
        if (targetElement.tagName == 'SPAN' || targetElement.tagName == 'I') {
          targetElement = targetElement.parentNode;
        }
        var temp = targetElement.getAttribute('data-value');
        nav_image_change(temp);
      });
    }
  }

  var if_exist = document.querySelectorAll('.drp-menu-icon');
  if (if_exist) {
    var preset_color = document.querySelectorAll('.drp-menu-icon > a');
    for (var h = 0; h < preset_color.length; h++) {
      var c = preset_color[h];
      c.addEventListener('click', function (event) {
        var targetElement = event.target;
        if (targetElement.tagName == 'SPAN' || targetElement.tagName == 'I') {
          targetElement = targetElement.parentNode;
        }
        var temp = targetElement.getAttribute('data-value');
        drp_menu_icon_change(temp);
      });
    }
  }

  var if_exist = document.querySelectorAll('.drp-menu-link-icon');
  if (if_exist) {
    var preset_color = document.querySelectorAll('.drp-menu-link-icon > a');
    for (var h = 0; h < preset_color.length; h++) {
      var c = preset_color[h];
      c.addEventListener('click', function (event) {
        var targetElement = event.target;
        if (targetElement.tagName == 'SPAN' || targetElement.tagName == 'I') {
          targetElement = targetElement.parentNode;
        }
        var temp = targetElement.getAttribute('data-value');
        drp_menu_link_icon_change(temp);
      });
    }
  }
});

// ============================================
// INITIALIZE THEME TOGGLE FROM HEADER DROPDOWN
// ============================================
function initializeThemeToggle() {
  // Get all theme dropdown items
  const darkModeBtn = document.querySelector('.dropdown-item[onclick*="layout_change(\'dark\')"]');
  const lightModeBtn = document.querySelector('.dropdown-item[onclick*="layout_change(\'light\')"]');
  const defaultModeBtn = document.querySelector('.dropdown-item[onclick*="layout_change_default"]');

  // Add click event to Dark button
  if (darkModeBtn) {
    darkModeBtn.addEventListener('click', function(e) {
      e.preventDefault();
      layout_change('dark');
      updateThemeIcon('dark');
    });
  }

  // Add click event to Light button
  if (lightModeBtn) {
    lightModeBtn.addEventListener('click', function(e) {
      e.preventDefault();
      layout_change('light');
      updateThemeIcon('light');
    });
  }

  // Add click event to Default button
  if (defaultModeBtn) {
    defaultModeBtn.addEventListener('click', function(e) {
      e.preventDefault();
      layout_change_default();
    });
  }
}

// ============================================
// UPDATE THEME ICON (SUN/MOON)
// ============================================
function updateThemeIcon(theme) {
  const themeIcon = document.getElementById('theme-icon');
  if (themeIcon) {
    // Update the data-feather attribute
    if (theme === 'dark') {
      themeIcon.setAttribute('data-feather', 'moon');
    } else {
      themeIcon.setAttribute('data-feather', 'sun');
    }
    
    // Re-initialize feather icons to apply the change
    if (typeof feather !== 'undefined') {
      feather.replace();
    }
  }
}

// ============================================
// LAYOUT CHANGE DEFAULT (SYSTEM PREFERENCE)
// ============================================
function layout_change_default() {
  // Remove saved theme to use system default
  localStorage.removeItem('data-pc-theme');
  
  // Determine initial layout based on user's color scheme preference
  let dark_layout = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

  // Apply the determined layout
  layout_change(dark_layout);
  updateThemeIcon(dark_layout);

  // Set the active state for the default layout button
  const btn_control = document.querySelector('.theme-layout .btn[data-value="default"]');
  if (btn_control) {
    btn_control.classList.add('active');
  }

  // Listen for changes in the user's color scheme preference
  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
    dark_layout = event.matches ? 'dark' : 'light';
    layout_change(dark_layout);
    updateThemeIcon(dark_layout);
  });
}

// ============================================
// LAYOUT CAPTION CHANGE
// ============================================
function layout_caption_change(value) {
  if (value == 'true') {
    document.getElementsByTagName('html')[0].setAttribute('data-pc-sidebar-caption', 'true');
  } else {
    document.getElementsByTagName('html')[0].setAttribute('data-pc-sidebar-caption', 'false');
  }

  var control = document.querySelector('.theme-nav-caption .btn.active');
  if (control) {
    control.classList.remove('active');
  }
  var newActiveButton = document.querySelector(`.theme-nav-caption .btn[data-value='${value}']`);
  if (newActiveButton) {
    newActiveButton.classList.add('active');
  }
}

// ============================================
// PRESET CHANGE
// ============================================
function preset_change(value) {
  document.getElementsByTagName('html')[0].setAttribute('class', value);
  var control = document.querySelector('.pct-offcanvas');
  if (control) {
    document.querySelector('.preset-color > a.active').classList.remove('active');
    document.querySelector(".preset-color > a[data-value='" + value + "']").classList.add('active');
  }
}

// ============================================
// MAIN LAYOUT CHANGE
// ============================================
function main_layout_change(value) {
  document.getElementsByTagName('html')[0].setAttribute('data-pc-layout', value);

  var control = document.querySelector('.pct-offcanvas');
  if (control) {
    var activeLink = document.querySelector('.theme-main-layout > a.active');
    if (activeLink) {
      activeLink.classList.remove('active');
    }

    var newActiveLink = document.querySelector(".theme-main-layout > a[data-value='" + value + "']");
    if (newActiveLink) {
      newActiveLink.classList.add('active');
    }
  }
}

// ============================================
// LAYOUT RTL CHANGE
// ============================================
function layout_rtl_change(value) {
  var htmlElement = document.getElementsByTagName('html')[0];

  if (value === 'true') {
    rtl_flag = true;
    htmlElement.setAttribute('data-pc-direction', 'rtl');
    htmlElement.setAttribute('dir', 'rtl');
    htmlElement.setAttribute('lang', 'ar');

    var activeButton = document.querySelector('.theme-direction .btn.active');
    if (activeButton) {
      activeButton.classList.remove('active');
    }
    var rtlButton = document.querySelector(".theme-direction .btn[data-value='true']");
    if (rtlButton) {
      rtlButton.classList.add('active');
    }
  } else {
    rtl_flag = false;
    htmlElement.setAttribute('data-pc-direction', 'ltr');
    htmlElement.setAttribute('dir', 'ltr');
    htmlElement.removeAttribute('lang');

    var activeButton = document.querySelector('.theme-direction .btn.active');
    if (activeButton) {
      activeButton.classList.remove('active');
    }
    var ltrButton = document.querySelector(".theme-direction .btn[data-value='false']");
    if (ltrButton) {
      ltrButton.classList.add('active');
    }
  }
}

// ============================================
// LAYOUT CHANGE (DARK/LIGHT) - WITH LOCALSTORAGE
// ============================================
function layout_change(layout) {
  // Set the theme layout attribute on the <html> tag
  document.getElementsByTagName('html')[0].setAttribute('data-pc-theme', layout);
  
  // Save to localStorage for persistence
  localStorage.setItem('data-pc-theme', layout);

  // Remove the 'active' class from the default layout button if it exists
  var btn_control = document.querySelector('.theme-layout .btn[data-value="default"]');
  if (btn_control) {
    btn_control.classList.remove('active');
  }

  // Determine which logos and buttons to update based on the selected layout
  var isDark = layout === 'dark';
  dark_flag = isDark;

  // Update the logos to match the selected layout
  var logoSrc = isDark ? '../assets/images/logo-white.svg' : '../assets/images/logo-dark.svg';

  // Helper function to update a specific element's logo if it exists
  function updateLogo(selector) {
    var element = document.querySelector(selector);
    if (element) {
      element.setAttribute('src', logoSrc);
    }
  }

  // Update logos
  updateLogo('.navbar-brand .logo-lg');
  updateLogo('.auth-main.v1 .auth-sidefooter img');
  updateLogo('.auth-logo');
  updateLogo('.footer-top .footer-logo');

  // Manage the active state of theme layout buttons
  var activeControl = document.querySelector('.theme-layout .btn.active');
  if (activeControl) {
    activeControl.classList.remove('active');
  }

  var newActiveControl = document.querySelector(`.theme-layout .btn[data-value='${isDark ? 'false' : 'true'}']`);
  if (newActiveControl) {
    newActiveControl.classList.add('active');
  }
  
  // Update theme icon
  updateThemeIcon(layout);
}

// ============================================
// CHANGE BOX CONTAINER
// ============================================
function change_box_container(value) {
  var contentElement = document.querySelector('.pc-content');
  var footerElement = document.querySelector('.footer-wrapper');

  if (contentElement && footerElement) {
    if (value === 'true') {
      contentElement.classList.add('container');
      footerElement.classList.add('container');
      footerElement.classList.remove('container-fluid');
    } else {
      contentElement.classList.remove('container');
      footerElement.classList.remove('container');
      footerElement.classList.add('container-fluid');
    }

    var activeButton = document.querySelector('.theme-container .btn.active');
    if (activeButton) {
      activeButton.classList.remove('active');
    }

    var newActiveButton = document.querySelector(`.theme-container .btn[data-value='${value}']`);
    if (newActiveButton) {
      newActiveButton.classList.add('active');
    }
  }
}

// ============================================
// SIDEBAR THEME CHANGE
// ============================================
function layout_theme_sidebar_change(value) {
  if (value == 'true') {
    document.getElementsByTagName('html')[0].setAttribute('data-pc-sidebar_theme', 'true');
    if (document.querySelector('.pc-sidebar .m-header .logo-lg')) {
      document.querySelector('.pc-sidebar .m-header .logo-lg').setAttribute('src', '../assets/images/logo-dark.svg');
    }
    var control = document.querySelector('.theme-nav-layout .btn.active');
    if (control) {
      document.querySelector('.theme-nav-layout .btn.active').classList.remove('active');
      document.querySelector(".theme-nav-layout .btn[data-value='true']").classList.add('active');
    }
  } else {
    document.getElementsByTagName('html')[0].setAttribute('data-pc-sidebar_theme', 'false');
    if (document.querySelector('.pc-sidebar .m-header .logo-lg')) {
      document.querySelector('.pc-sidebar .m-header .logo-lg').setAttribute('src', '../assets/images/logo-white.svg');
    }
    var control = document.querySelector('.theme-nav-layout .btn.active');
    if (control) {
      document.querySelector('.theme-nav-layout .btn.active').classList.remove('active');
      document.querySelector(".theme-nav-layout .btn[data-value='false']").classList.add('active');
    }
  }
}

// ============================================
// OTHER THEME FUNCTIONS
// ============================================
function header_change(value) {
  document.getElementsByTagName('html')[0].setAttribute('data-pc-header', value);
  var control = document.querySelector('.pct-offcanvas');
  if (control) {
    document.querySelector('.header-color > a.active').classList.remove('active');
    document.querySelector(".header-color > a[data-value='" + value + "']").classList.add('active');
  }
}

function navbar_change(value) {
  document.getElementsByTagName('html')[0].setAttribute('data-pc-navbar', value);
  var control = document.querySelector('.pct-offcanvas');
  if (control) {
    document.querySelector('.navbar-color > a.active').classList.remove('active');
    document.querySelector(".navbar-color > a[data-value='" + value + "']").classList.add('active');
  }
}

function logo_change(value) {
  document.getElementsByTagName('html')[0].setAttribute('data-pc-logo', value);
  var control = document.querySelector('.pct-offcanvas');
  if (control) {
    document.querySelector('.logo-color > a.active').classList.remove('active');
    document.querySelector(".logo-color > a[data-value='" + value + "']").classList.add('active');
  }
}

function caption_change(value) {
  document.getElementsByTagName('html')[0].setAttribute('data-pc-caption', value);
  var control = document.querySelector('.pct-offcanvas');
  if (control) {
    document.querySelector('.caption-color > a.active').classList.remove('active');
    document.querySelector(".caption-color > a[data-value='" + value + "']").classList.add('active');
  }
}

function drp_menu_icon_change(value) {
  document.getElementsByTagName('html')[0].setAttribute('data-pc-drp-menu-icon', value);
  var control = document.querySelector('.pct-offcanvas');
  if (control) {
    document.querySelector('.drp-menu-icon > a.active').classList.remove('active');
    document.querySelector(".drp-menu-icon > a[data-value='" + value + "']").classList.add('active');
  }
}

function drp_menu_link_icon_change(value) {
  document.getElementsByTagName('html')[0].setAttribute('data-pc-drp-menu-link-icon', value);
  var control = document.querySelector('.pct-offcanvas');
  if (control) {
    document.querySelector('.drp-menu-link-icon > a.active').classList.remove('active');
    document.querySelector(".drp-menu-link-icon > a[data-value='" + value + "']").classList.add('active');
  }
}

function nav_image_change(value) {
  document.getElementsByTagName('html')[0].setAttribute('data-pc-navimg', value);
  var control = document.querySelector('.pct-offcanvas');
  if (control) {
    document.querySelector('.navbar-img > a.active').classList.remove('active');
    document.querySelector(".navbar-img > a[data-value='" + value + "']").classList.add('active');
  }
}