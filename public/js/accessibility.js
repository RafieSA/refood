// =====================================================
// ACCESSIBILITY & ONBOARDING SYSTEM
// =====================================================

class RefoodAccessibility {
    constructor() {
        this.init();
    }

    init() {
        // Load saved preferences
        this.loadPreferences();
        
        // Initialize all features
        this.initKeyboardNavigation();
        this.initFocusManagement();
        this.initAccessibilityPanel();
        this.initWelcomeModal();
        this.initFeatureTour();
        this.initMobileFeatures();
        this.initSwipeGestures();
        this.initPullToRefresh();
        
        // Check if first visit
        if (!localStorage.getItem('refood_visited')) {
            setTimeout(() => this.showWelcomeModal(), 1000);
            localStorage.setItem('refood_visited', 'true');
        }
    }

    // ==================== PREFERENCES ====================
    loadPreferences() {
        const contrast = localStorage.getItem('refood_high_contrast');
        const fontSize = localStorage.getItem('refood_font_size');
        
        if (contrast === 'true') {
            document.body.classList.add('high-contrast');
        }
        
        if (fontSize) {
            document.body.className = document.body.className.replace(/font-\w+/g, '');
            document.body.classList.add(`font-${fontSize}`);
        }
    }

    savePreference(key, value) {
        localStorage.setItem(`refood_${key}`, value);
    }

    // ==================== KEYBOARD NAVIGATION ====================
    initKeyboardNavigation() {
        let isKeyboardUser = false;

        // Detect keyboard usage
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                isKeyboardUser = true;
                document.body.classList.add('keyboard-user');
            }
        });

        document.addEventListener('mousedown', () => {
            isKeyboardUser = false;
            document.body.classList.remove('keyboard-user');
        });

        // Global keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // ESC - Close modals/panels
            if (e.key === 'Escape') {
                this.closeAllModals();
            }

            // Alt + A - Open accessibility panel
            if (e.altKey && e.key === 'a') {
                e.preventDefault();
                this.toggleAccessibilityPanel();
            }

            // Alt + H - Open help/tour
            if (e.altKey && e.key === 'h') {
                e.preventDefault();
                this.startFeatureTour();
            }

            // Alt + 1, 2, 3 - Quick navigation
            if (e.altKey && ['1', '2', '3'].includes(e.key)) {
                e.preventDefault();
                this.quickNav(e.key);
            }
        });

        // Make cards keyboard accessible
        document.querySelectorAll('.restaurant-card').forEach(card => {
            if (!card.hasAttribute('tabindex')) {
                card.setAttribute('tabindex', '0');
            }
            
            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const link = card.querySelector('a');
                    if (link) link.click();
                }
            });
        });
    }

    quickNav(key) {
        const sections = {
            '1': '#main-content',
            '2': '#restaurant-list',
            '3': '#footer'
        };
        
        const element = document.querySelector(sections[key]);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            element.focus();
        }
    }

    // ==================== FOCUS MANAGEMENT ====================
    initFocusManagement() {
        // Add skip link
        const skipLink = document.createElement('a');
        skipLink.href = '#main-content';
        skipLink.className = 'skip-link';
        skipLink.textContent = 'Skip to main content';
        skipLink.setAttribute('aria-label', 'Skip to main content');
        document.body.insertBefore(skipLink, document.body.firstChild);

        // Focus trap for modals
        this.setupFocusTrap();
    }

    setupFocusTrap() {
        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Tab') return;

            const modal = document.querySelector('.modal:not(.hidden)');
            if (!modal) return;

            const focusableElements = modal.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            if (e.shiftKey && document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            } else if (!e.shiftKey && document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        });
    }

    // ==================== ACCESSIBILITY PANEL ====================
    initAccessibilityPanel() {
        const panel = document.getElementById('accessibility-panel');
        if (!panel) return;

        // High Contrast Toggle
        const contrastToggle = document.getElementById('contrast-toggle');
        if (contrastToggle) {
            contrastToggle.addEventListener('click', () => {
                document.body.classList.toggle('high-contrast');
                const isActive = document.body.classList.contains('high-contrast');
                this.savePreference('high_contrast', isActive);
                this.announce(`High contrast mode ${isActive ? 'enabled' : 'disabled'}`);
            });
        }

        // Font Size Controls
        const fontButtons = document.querySelectorAll('[data-font-size]');
        fontButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const size = btn.dataset.fontSize;
                document.body.className = document.body.className.replace(/font-\w+/g, '');
                document.body.classList.add(`font-${size}`);
                this.savePreference('font_size', size);
                this.announce(`Font size changed to ${size}`);
                
                // Update active state
                fontButtons.forEach(b => b.classList.remove('active', 'bg-green-600', 'text-white'));
                btn.classList.add('active', 'bg-green-600', 'text-white');
            });
        });
    }

    toggleAccessibilityPanel() {
        const panel = document.getElementById('accessibility-panel');
        if (panel) {
            panel.classList.toggle('open');
            const isOpen = panel.classList.contains('open');
            
            if (isOpen) {
                const firstButton = panel.querySelector('button');
                if (firstButton) firstButton.focus();
            }
        }
    }

    // ==================== WELCOME MODAL ====================
    initWelcomeModal() {
        const modal = document.getElementById('welcome-modal');
        if (!modal) return;

        const closeBtn = modal.querySelector('[data-close-welcome]');
        const tourBtn = modal.querySelector('[data-start-tour]');

        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.hideWelcomeModal());
        }

        if (tourBtn) {
            tourBtn.addEventListener('click', () => {
                this.hideWelcomeModal();
                setTimeout(() => this.startFeatureTour(), 300);
            });
        }

        // Close on outside click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                this.hideWelcomeModal();
            }
        });
    }

    showWelcomeModal() {
        const modal = document.getElementById('welcome-modal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            const firstButton = modal.querySelector('button');
            if (firstButton) firstButton.focus();
            this.announce('Welcome to ReFood! Modal opened.');
        }
    }

    hideWelcomeModal() {
        const modal = document.getElementById('welcome-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            this.announce('Welcome modal closed');
        }
    }

    // ==================== FEATURE TOUR ====================
    initFeatureTour() {
        // Dynamic tour steps based on current page
        const isDetailPage = window.location.pathname.includes('/restaurants/');
        
        this.tourSteps = [
            {
                element: '[data-tour="search"]',
                title: 'Search Restaurants',
                description: 'Type to search restaurants by name, menu, or cuisine type. Autocomplete will show suggestions!',
                position: 'bottom'
            },
            {
                element: '[data-tour="filters"]',
                title: 'Filter Options',
                description: 'Use filters to find restaurants by cuisine type and discount percentage.',
                position: 'bottom'
            },
            {
                element: '[data-tour="restaurant-card"]',
                title: 'Restaurant Cards',
                description: 'Click any restaurant card to see full details, menu, reviews, and claim discounts!',
                position: 'top'
            }
        ];

        // Add detail page steps if on detail page
        if (isDetailPage) {
            this.tourSteps.push(
                {
                    element: '[data-tour="reviews"]',
                    title: 'Customer Reviews',
                    description: 'Read reviews from other customers and add your own after claiming a discount.',
                    position: 'top'
                },
                {
                    element: '[data-tour="claim"]',
                    title: 'Claim Discount',
                    description: 'Click "Claim Discount" to get the promotional code. Show it at the restaurant!',
                    position: 'top'
                }
            );
        }

        this.currentTourStep = 0;
    }

    startFeatureTour() {
        this.currentTourStep = 0;
        this.showTourStep();
    }

    showTourStep() {
        if (this.currentTourStep >= this.tourSteps.length) {
            this.endTour();
            return;
        }

        const step = this.tourSteps[this.currentTourStep];
        const element = document.querySelector(step.element);
        
        if (!element) {
            this.currentTourStep++;
            this.showTourStep();
            return;
        }

        // Remove previous tooltips
        document.querySelectorAll('.tour-tooltip').forEach(t => t.remove());
        document.querySelectorAll('.tour-overlay').forEach(o => o.remove());

        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'tour-overlay fixed inset-0 bg-black bg-opacity-50 z-[9998]';
        overlay.addEventListener('click', () => this.endTour());
        document.body.appendChild(overlay);

        // Highlight element
        element.style.position = 'relative';
        element.style.zIndex = '9999';
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });

        // Create tooltip
        const tooltip = document.createElement('div');
        tooltip.className = 'tour-tooltip fixed bg-white rounded-lg shadow-2xl p-6 z-[10000] max-w-md';
        tooltip.setAttribute('role', 'dialog');
        tooltip.setAttribute('aria-labelledby', 'tour-title');
        tooltip.setAttribute('aria-describedby', 'tour-description');
        
        tooltip.innerHTML = `
            <h3 id="tour-title" class="text-xl font-bold text-gray-800 mb-2">${step.title}</h3>
            <p id="tour-description" class="text-gray-600 mb-4">${step.description}</p>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">Step ${this.currentTourStep + 1} of ${this.tourSteps.length}</span>
                <div class="space-x-2">
                    <button onclick="accessibility.endTour()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Skip Tour</button>
                    <button onclick="accessibility.nextTourStep()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        ${this.currentTourStep === this.tourSteps.length - 1 ? 'Finish' : 'Next'}
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(tooltip);

        // Position tooltip
        const rect = element.getBoundingClientRect();
        if (step.position === 'bottom') {
            tooltip.style.top = (rect.bottom + 20) + 'px';
            tooltip.style.left = Math.max(20, rect.left - 100) + 'px';
        } else {
            tooltip.style.bottom = (window.innerHeight - rect.top + 20) + 'px';
            tooltip.style.left = Math.max(20, rect.left - 100) + 'px';
        }

        this.announce(`Tour step ${this.currentTourStep + 1}: ${step.title}`);
    }

    nextTourStep() {
        this.currentTourStep++;
        this.showTourStep();
    }

    endTour() {
        document.querySelectorAll('.tour-tooltip').forEach(t => t.remove());
        document.querySelectorAll('.tour-overlay').forEach(o => o.remove());
        document.querySelectorAll('[style*="z-index: 9999"]').forEach(el => {
            el.style.zIndex = '';
            el.style.position = '';
        });
        this.announce('Feature tour ended');
    }

    // ==================== MOBILE FEATURES ====================
    initMobileFeatures() {
        if (window.innerWidth > 768) return;

        // Add bottom navigation if doesn't exist
        if (!document.querySelector('.mobile-bottom-nav')) {
            this.createBottomNav();
        }

        // Make buttons touch-friendly
        this.makeTouchFriendly();
    }

    createBottomNav() {
        const nav = document.createElement('nav');
        nav.className = 'mobile-bottom-nav';
        nav.setAttribute('aria-label', 'Mobile navigation');
        nav.innerHTML = `
            <div class="flex justify-around items-center">
                <a href="${window.location.origin}" class="flex flex-col items-center p-2 text-gray-600 hover:text-green-600" aria-label="Home">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xs mt-1">Home</span>
                </a>
                <a href="${window.location.origin}/restaurants" class="flex flex-col items-center p-2 text-green-600 hover:text-green-600" aria-label="Restaurants">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-xs mt-1">Browse</span>
                </a>
                <button onclick="accessibility.toggleAccessibilityPanel()" class="flex flex-col items-center p-2 text-gray-600 hover:text-green-600" aria-label="Accessibility settings">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    <span class="text-xs mt-1">Settings</span>
                </button>
                <button onclick="accessibility.startFeatureTour()" class="flex flex-col items-center p-2 text-gray-600 hover:text-green-600" aria-label="Help and tour">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs mt-1">Help</span>
                </button>
            </div>
        `;
        document.body.appendChild(nav);
        
        // Add padding to body for bottom nav
        document.body.style.paddingBottom = '80px';
    }

    makeTouchFriendly() {
        // Ensure all interactive elements meet 44px minimum
        const interactiveElements = document.querySelectorAll('button, a, input, select, textarea');
        interactiveElements.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.height < 44) {
                el.style.minHeight = '44px';
                el.style.padding = '12px';
            }
        });
    }

    // ==================== SWIPE GESTURES ====================
    initSwipeGestures() {
        if (window.innerWidth > 768) return;

        let touchStartX = 0;
        let touchEndX = 0;

        document.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe();
        });
    }

    handleSwipe() {
        const swipeThreshold = 100;
        const diff = this.touchEndX - this.touchStartX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe right - go back
                if (window.history.length > 1) {
                    this.showSwipeIndicator('left');
                    setTimeout(() => window.history.back(), 300);
                }
            }
        }
    }

    showSwipeIndicator(direction) {
        let indicator = document.querySelector('.swipe-indicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.className = 'swipe-indicator';
            indicator.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>';
            document.body.appendChild(indicator);
        }
        
        indicator.classList.add('active');
        setTimeout(() => indicator.classList.remove('active'), 500);
    }

    // ==================== PULL TO REFRESH ====================
    initPullToRefresh() {
        if (window.innerWidth > 768) return;

        let pStart = 0;
        let pCurrent = 0;
        let pullThreshold = 80;
        let isRefreshing = false;

        document.addEventListener('touchstart', (e) => {
            if (window.scrollY === 0) {
                pStart = e.touches[0].clientY;
            }
        });

        document.addEventListener('touchmove', (e) => {
            if (window.scrollY === 0 && !isRefreshing) {
                pCurrent = e.touches[0].clientY;
                const pullDistance = pCurrent - pStart;

                if (pullDistance > 0) {
                    this.showPullIndicator(pullDistance);
                }
            }
        });

        document.addEventListener('touchend', () => {
            const pullDistance = pCurrent - pStart;
            
            if (pullDistance > pullThreshold && !isRefreshing) {
                this.triggerRefresh();
            } else {
                this.hidePullIndicator();
            }
            
            pStart = 0;
            pCurrent = 0;
        });
    }

    showPullIndicator(distance) {
        let indicator = document.querySelector('.ptr-indicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.className = 'ptr-indicator';
            indicator.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="ml-2 text-sm text-gray-700">Pull to refresh</span>
            `;
            document.body.appendChild(indicator);
        }
        
        if (distance > 80) {
            indicator.classList.add('visible');
        }
    }

    hidePullIndicator() {
        const indicator = document.querySelector('.ptr-indicator');
        if (indicator) {
            indicator.classList.remove('visible');
        }
    }

    triggerRefresh() {
        const indicator = document.querySelector('.ptr-indicator');
        if (indicator) {
            indicator.innerHTML = '<svg class="animate-spin h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2 text-sm text-gray-700">Refreshing...</span>';
        }

        this.announce('Refreshing page');
        
        setTimeout(() => {
            window.location.reload();
        }, 500);
    }

    // ==================== HELPERS ====================
    closeAllModals() {
        document.querySelectorAll('.modal, [role="dialog"]').forEach(modal => {
            modal.classList.add('hidden');
        });
        document.body.style.overflow = 'auto';
        this.endTour();
        
        const panel = document.getElementById('accessibility-panel');
        if (panel) panel.classList.remove('open');
    }

    announce(message) {
        // Create/update ARIA live region for screen readers
        let liveRegion = document.getElementById('aria-live-region');
        if (!liveRegion) {
            liveRegion = document.createElement('div');
            liveRegion.id = 'aria-live-region';
            liveRegion.className = 'sr-only';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            document.body.appendChild(liveRegion);
        }
        
        liveRegion.textContent = message;
    }
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.accessibility = new RefoodAccessibility();
    });
} else {
    window.accessibility = new RefoodAccessibility();
}
