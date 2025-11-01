/**
=========================================================================
File: sidebar-state.js
Description: Handles sidebar collapse state persistence across pages
Usage: Include after script.js in all booking pages
=========================================================================
*/

(function() {
    'use strict';

    // Apply saved sidebar state on page load
    function applySidebarState() {
        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed');
        const sidebar = document.querySelector('.pc-sidebar');
        const header = document.querySelector('.pc-header');
        const mainContent = document.querySelector('.pc-container');

        // Only apply state if user has clicked the collapse button before
        if (sidebarCollapsed === 'true') {
            // Apply collapsed state - let CSS handle the layout
            if (sidebar) sidebar.classList.add('pc-sidebar-hide');
            if (header) header.classList.add('sidebar-collapsed');
            if (mainContent) mainContent.classList.add('sidebar-collapsed');
        } else if (sidebarCollapsed === 'false') {
            // Apply expanded state - let CSS handle the layout
            if (sidebar) sidebar.classList.remove('pc-sidebar-hide');
            if (header) header.classList.remove('sidebar-collapsed');
            if (mainContent) mainContent.classList.remove('sidebar-collapsed');
        }
        // If null/undefined (first time) - do nothing, keep default expanded state
    }

    // Override the existing sidebar toggle to add localStorage functionality
    function initSidebarToggle() {
        const sidebarHide = document.querySelector('#sidebar-hide');

        if (sidebarHide) {
            // Remove existing event listeners by cloning and replacing the element
            const newSidebarHide = sidebarHide.cloneNode(true);
            sidebarHide.parentNode.replaceChild(newSidebarHide, sidebarHide);

            // Add new event listener with localStorage functionality
            newSidebarHide.addEventListener('click', function(e) {
                e.preventDefault();
                const sidebar = document.querySelector('.pc-sidebar');
                const header = document.querySelector('.pc-header');
                const mainContent = document.querySelector('.pc-container');
                
                if (sidebar && sidebar.classList.contains('pc-sidebar-hide')) {
                    // Expand sidebar - let CSS handle the layout
                    sidebar.classList.remove('pc-sidebar-hide');
                    if (header) {
                        header.classList.remove('sidebar-collapsed');
                        header.style.removeProperty('left');
                    }
                    if (mainContent) {
                        mainContent.classList.remove('sidebar-collapsed');
                        mainContent.style.removeProperty('margin-left');
                    }
                    localStorage.setItem('sidebarCollapsed', 'false');
                } else if (sidebar) {
                    // Collapse sidebar - let CSS handle the layout
                    sidebar.classList.add('pc-sidebar-hide');
                    if (header) {
                        header.classList.add('sidebar-collapsed');
                        header.style.removeProperty('left');
                    }
                    if (mainContent) {
                        mainContent.classList.add('sidebar-collapsed');
                        mainContent.style.removeProperty('margin-left');
                    }
                    localStorage.setItem('sidebarCollapsed', 'true');
                }
            });
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            applySidebarState();
            // Use setTimeout to ensure script.js has finished initializing
            setTimeout(initSidebarToggle, 100);
        });
    } else {
        // DOM is already ready
        applySidebarState();
        setTimeout(initSidebarToggle, 100);
    }

})();