<?php $__env->startSection('title', 'Dashboard - PolCaBot'); ?>

<?php $__env->startSection('dashboard-content'); ?>
<div class="main-content" id="mainContent">
  <div class="welcome-section">
    <h1>Selamat Datang di <span class="text-sky-600 font-bold">PolCaBot</span></h1>
    <p>Hai <?php echo e($user->name ?? 'User'); ?>, PolCaBot siap membantu menjawab segala pertanyaan akademik dari Kampus Polibatam</p>

    <div class="quick-actions">
      <?php $__currentLoopData = $quickActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="action-card" data-question="<?php echo e($action['title']); ?>">
          <h3><?php echo e($action['title']); ?></h3>
          <p><?php echo e($action['description']); ?></p>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</div>

<!-- Floating Tutorial Button -->
<button id="tutorialButton" onclick="startPolCaBotTutorial()" style="
    position: fixed;
    bottom: 100px;
    right: 20px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: none;
    background: #0ea5e9;
    color: white;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    z-index: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
" onmouseover="this.style.background='#0284c7'; this.style.transform='scale(1.1)'" 
   onmouseout="this.style.background='#0ea5e9'; this.style.transform='scale(1)'"
   title="Panduan Aplikasi">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
        <path d="M11 18h2v-2h-2v2zm1-16C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-2.21 0-4 1.79-4 4h2c0-1.1.9-2 2-2s2 .9 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4z"/>
    </svg>
</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-content'); ?>
<?php echo $__env->make('components.chatbot', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
(function() {
    'use strict';
    
    console.log('🚀 PolCaBot Dashboard Initializing...');
    
    // Wait for DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        console.log('✅ DOM Ready');
        
        // Initialize all features
        initSidebar();
        initDarkMode();
        initActionCards();
        initTopbarButtons();
        
        console.log('✅ Dashboard fully initialized');
    }
    
    // ========== TOPBAR BUTTONS ==========
    function initTopbarButtons() {
        // Home button
        const homeBtn = document.getElementById('homeBtn');
        if (homeBtn) {
            homeBtn.addEventListener('click', function() {
                window.location.href = '/'; // Ganti dengan route landing page Anda
            });
        }
        
        // Logout button
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin keluar?')) {
                    // Ganti dengan route logout Anda
                    window.location.href = '/logout';
                    // Atau gunakan form submit:
                    // document.getElementById('logout-form').submit();
                }
            });
        }
    }
    
    // ========== SIDEBAR TOGGLE ==========
    function initSidebar() {
        const menuToggle = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const sidebarLinks = document.querySelectorAll('.sidebar-menu li, .profile-card');
        
        if (!menuToggle || !sidebar) {
            console.warn('⚠️ Sidebar elements not found');
            return;
        }
        
        console.log('✅ Sidebar elements found');
        
        function toggleSidebar() {
            const isActive = sidebar.classList.toggle('active');
            
            if (overlay) {
                overlay.classList.toggle('active', isActive);
            }
            
            if (window.innerWidth <= 768) {
                document.body.style.overflow = isActive ? 'hidden' : '';
            }
            
            console.log(isActive ? '📂 Sidebar opened' : '📁 Sidebar closed');
        }
        
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
        });
        
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
        
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                    if (overlay) {
                        overlay.classList.remove('active');
                    }
                    document.body.style.overflow = '';
                }
            });
        });
        
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                    if (overlay) {
                        overlay.classList.remove('active');
                    }
                    document.body.style.overflow = '';
                }
            }, 250);
        });
    }
    
    // ========== DARK MODE TOGGLE ==========
    function initDarkMode() {
        const darkModeToggle = document.querySelector('.dark-mode-toggle');
        const toggleSwitch = document.querySelector('.toggle-switch');
        
        if (!darkModeToggle || !toggleSwitch) {
            console.warn('⚠️ Dark mode elements not found');
            return;
        }
        
        console.log('✅ Dark mode elements found');
        
        // Load saved preference
        const savedMode = localStorage.getItem('darkMode');
        const isDarkMode = savedMode === 'true';
        
        if (isDarkMode) {
            document.body.classList.add('dark-mode');
            document.body.classList.remove('light-mode');
            toggleSwitch.classList.add('active');
            console.log('🌙 Loaded: Dark mode ON');
        } else {
            document.body.classList.add('light-mode');
            document.body.classList.remove('dark-mode');
            toggleSwitch.classList.remove('active');
            console.log('☀️ Loaded: Light mode ON');
        }
        
        function toggleDarkMode() {
            const body = document.body;
            const wasDark = body.classList.contains('dark-mode');
            
            if (wasDark) {
                body.classList.remove('dark-mode');
                body.classList.add('light-mode');
                toggleSwitch.classList.remove('active');
                localStorage.setItem('darkMode', 'false');
                console.log('☀️ Switched to Light mode');
            } else {
                body.classList.add('dark-mode');
                body.classList.remove('light-mode');
                toggleSwitch.classList.add('active');
                localStorage.setItem('darkMode', 'true');
                console.log('🌙 Switched to Dark mode');
            }
        }
        
        // Click on toggle switch
        toggleSwitch.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleDarkMode();
        });
        
        // Click on container
        darkModeToggle.addEventListener('click', function(e) {
            if (e.target === toggleSwitch || toggleSwitch.contains(e.target)) {
                return;
            }
            toggleDarkMode();
        });
    }
    
    // ========== ACTION CARDS ==========
    function initActionCards() {
        const actionCards = document.querySelectorAll('.action-card');
        
        if (actionCards.length === 0) {
            console.warn('⚠️ No action cards found');
            return;
        }
        
        console.log('✅ Found ' + actionCards.length + ' action cards');
        
        actionCards.forEach((card, index) => {
            const question = card.getAttribute('data-question');
            console.log('  Card ' + (index + 1) + ': ' + question);
            
            card.style.cursor = 'pointer';
            card.style.position = 'relative';
            card.style.zIndex = '10';
            
            card.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const question = this.getAttribute('data-question');
                console.log('🎯 Card clicked: ' + question);
                
                if (typeof window.startChat === 'function') {
                    console.log('✅ Calling startChat()');
                    window.startChat(question);
                } else if (typeof startChat === 'function') {
                    console.log('✅ Calling startChat()');
                    startChat(question);
                } else {
                    console.log('⚠️ startChat() not found, using fallback');
                    
                    const chatInput = document.querySelector('.chat-input input');
                    if (chatInput) {
                        chatInput.value = question;
                        chatInput.focus();
                        
                        const submitBtn = document.querySelector('.chat-input button');
                        if (submitBtn) {
                            setTimeout(() => submitBtn.click(), 100);
                        }
                    } else {
                        console.error('❌ Chat input not found!');
                        alert('Question: ' + question);
                    }
                }
            });
            
            card.addEventListener('touchend', function(e) {
                e.preventDefault();
            });
            
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }
    
    // ========== DEBUG HELPER ==========
    window.debugDashboard = function() {
        console.log('=== DASHBOARD DEBUG ===');
        
        const checks = {
            'Action Cards': document.querySelectorAll('.action-card').length,
            'Menu Toggle': !!document.querySelector('.menu-toggle'),
            'Sidebar': !!document.querySelector('.sidebar'),
            'Overlay': !!document.querySelector('.sidebar-overlay'),
            'Dark Mode Toggle': !!document.querySelector('.dark-mode-toggle'),
            'Toggle Switch': !!document.querySelector('.toggle-switch'),
            'Chat Input': !!document.querySelector('.chat-input input'),
            'Body Classes': document.body.className,
            'Dark Mode Setting': localStorage.getItem('darkMode'),
            'Viewport Width': window.innerWidth + 'px'
        };
        
        Object.keys(checks).forEach(key => {
            console.log(key + ':', checks[key]);
        });
        
        console.log('=== END DEBUG ===');
        console.log('💡 Try clicking action cards now');
    };
    
    console.log('💡 Run debugDashboard() in console for diagnostics');
})();
</script>

<!-- ========== TUTORIAL SYSTEM SCRIPT ========== -->
<script>
(function() {
    'use strict';
    
    console.log('🎓 Tutorial System Loading...');
    
    const tutorialSteps = [
        {
            target: '.menu-toggle',
            title: 'Menu Sidebar',
            content: 'Klik tombol ini untuk membuka/menutup sidebar navigasi',
            position: 'right'
        },
        {
            target: '.action-card:first-child',
            title: 'Quick Actions',
            content: 'Klik kartu ini untuk langsung memulai percakapan dengan pertanyaan yang tersedia',
            position: 'bottom'
        },
        {
            target: '.chat-input-container',
            title: 'Input Pertanyaan',
            content: 'Ketik pertanyaan Anda di sini dan tekan Enter atau klik tombol kirim untuk memulai chat',
            position: 'top'
        },
        {
            target: '.dark-mode-toggle',
            title: 'Mode Gelap',
            content: 'Aktifkan mode gelap untuk kenyamanan mata Anda saat menggunakan aplikasi',
            position: 'right'
        },
        {
            target: '.profile-card',
            title: 'Profil Anda',
            content: 'Klik di sini untuk melihat dan mengedit profil Anda atau logout dari aplikasi',
            position: 'right'
        }
    ];
    
    let currentStep = 0;
    let tutorialOverlay = null;
    let tutorialTooltip = null;
    
    function hasSeenTutorial() {
        return localStorage.getItem('polcabot_tutorial_seen') === 'true';
    }
    
    function markTutorialSeen() {
        localStorage.setItem('polcabot_tutorial_seen', 'true');
    }
    
    window.resetTutorial = function() {
        localStorage.removeItem('polcabot_tutorial_seen');
        console.log('✅ Tutorial reset. Refresh page to see tutorial again.');
    };
    
    function createOverlay() {
        tutorialOverlay = document.createElement('div');
        tutorialOverlay.className = 'tutorial-overlay';
        tutorialOverlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9998;
            pointer-events: none;
        `;
        document.body.appendChild(tutorialOverlay);
    }
    
    function createTooltip() {
        tutorialTooltip = document.createElement('div');
        tutorialTooltip.className = 'tutorial-tooltip';
        tutorialTooltip.style.cssText = `
            position: fixed;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            z-index: 10000;
            max-width: 320px;
            pointer-events: auto;
        `;
        
        if (document.body.classList.contains('dark-mode')) {
            tutorialTooltip.style.background = '#2d3748';
            tutorialTooltip.style.color = 'white';
        }
        
        document.body.appendChild(tutorialTooltip);
    }
    
    function highlightElement(element) {
        if (!element) return;
        
        const rect = element.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
        
        const highlight = document.createElement('div');
        highlight.className = 'tutorial-highlight';
        highlight.style.cssText = `
            position: absolute;
            top: ${rect.top + scrollTop - 8}px;
            left: ${rect.left + scrollLeft - 8}px;
            width: ${rect.width + 16}px;
            height: ${rect.height + 16}px;
            border: 3px solid #0ea5e9;
            border-radius: 12px;
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.7);
            z-index: 9999;
            pointer-events: none;
            animation: pulse-border 2s infinite;
        `;
        
        document.body.appendChild(highlight);
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        return highlight;
    }
    
    function positionTooltip(element, position) {
        if (!element || !tutorialTooltip) return;
        
        const rect = element.getBoundingClientRect();
        const tooltipRect = tutorialTooltip.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
        
        let top, left;
        
        switch (position) {
            case 'top':
                top = rect.top + scrollTop - tooltipRect.height - 20;
                left = rect.left + scrollLeft + (rect.width / 2) - (tooltipRect.width / 2);
                break;
            case 'bottom':
                top = rect.bottom + scrollTop + 20;
                left = rect.left + scrollLeft + (rect.width / 2) - (tooltipRect.width / 2);
                break;
            case 'left':
                top = rect.top + scrollTop + (rect.height / 2) - (tooltipRect.height / 2);
                left = rect.left + scrollLeft - tooltipRect.width - 20;
                break;
            case 'right':
                top = rect.top + scrollTop + (rect.height / 2) - (tooltipRect.height / 2);
                left = rect.right + scrollLeft + 20;
                break;
            default:
                top = rect.bottom + scrollTop + 20;
                left = rect.left + scrollLeft;
        }
        
        const margin = 10;
        if (left < margin) left = margin;
        if (left + tooltipRect.width > window.innerWidth - margin) {
            left = window.innerWidth - tooltipRect.width - margin;
        }
        if (top < margin) top = margin;
        
        tutorialTooltip.style.top = top + 'px';
        tutorialTooltip.style.left = left + 'px';
    }
    
    function showStep(stepIndex) {
        const oldHighlight = document.querySelector('.tutorial-highlight');
        if (oldHighlight) oldHighlight.remove();
        
        if (stepIndex >= tutorialSteps.length) {
            endTutorial();
            return;
        }
        
        const step = tutorialSteps[stepIndex];
        const element = document.querySelector(step.target);
        
        if (!element) {
            console.warn('Tutorial target not found:', step.target);
            currentStep++;
            showStep(currentStep);
            return;
        }
        
        const highlight = highlightElement(element);
        
        const isDark = document.body.classList.contains('dark-mode');
        tutorialTooltip.innerHTML = `
            <div style="margin-bottom: 15px;">
                <h3 style="margin: 0 0 10px 0; color: ${isDark ? '#38bdf8' : '#0ea5e9'}; font-size: 18px; font-weight: bold;">
                    ${step.title}
                </h3>
                <p style="margin: 0; line-height: 1.6; color: ${isDark ? '#e5e5e5' : '#333'}; font-size: 14px;">
                    ${step.content}
                </p>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <span style="font-size: 13px; color: ${isDark ? '#9ca3af' : '#666'};">
                    ${stepIndex + 1} dari ${tutorialSteps.length}
                </span>
                <div style="display: flex; gap: 10px;">
                    <button class="tutorial-skip" style="
                        padding: 8px 16px;
                        border: none;
                        border-radius: 6px;
                        background: ${isDark ? '#4b5563' : '#e5e7eb'};
                        color: ${isDark ? 'white' : '#333'};
                        cursor: pointer;
                        font-size: 14px;
                        font-weight: 500;
                        transition: background 0.2s;
                    ">
                        Lewati
                    </button>
                    <button class="tutorial-next" style="
                        padding: 8px 20px;
                        border: none;
                        border-radius: 6px;
                        background: #0ea5e9;
                        color: white;
                        cursor: pointer;
                        font-size: 14px;
                        font-weight: 500;
                        transition: background 0.2s;
                    ">
                        ${stepIndex === tutorialSteps.length - 1 ? 'Selesai' : 'Selanjutnya'}
                    </button>
                </div>
            </div>
        `;
        
        positionTooltip(element, step.position);
        
        const skipBtn = tutorialTooltip.querySelector('.tutorial-skip');
        const nextBtn = tutorialTooltip.querySelector('.tutorial-next');
        
        skipBtn.addEventListener('click', endTutorial);
        skipBtn.addEventListener('mouseenter', function() {
            this.style.background = isDark ? '#6b7280' : '#d1d5db';
        });
        skipBtn.addEventListener('mouseleave', function() {
            this.style.background = isDark ? '#4b5563' : '#e5e7eb';
        });
        
        nextBtn.addEventListener('click', nextStep);
        nextBtn.addEventListener('mouseenter', function() {
            this.style.background = '#0284c7';
        });
        nextBtn.addEventListener('mouseleave', function() {
            this.style.background = '#0ea5e9';
        });
    }
    
    function nextStep() {
        currentStep++;
        showStep(currentStep);
    }
    
    function endTutorial() {
        if (tutorialOverlay) tutorialOverlay.remove();
        if (tutorialTooltip) tutorialTooltip.remove();
        
        const highlight = document.querySelector('.tutorial-highlight');
        if (highlight) highlight.remove();
        
        markTutorialSeen();
        
        console.log('✅ Tutorial completed');
    }
    
    function startTutorial() {
        console.log('🎓 Starting tutorial...');
        
        if (!document.getElementById('tutorial-styles')) {
            const style = document.createElement('style');
            style.id = 'tutorial-styles';
            style.textContent = `
                @keyframes pulse-border {
                    0%, 100% {
                        border-color: #0ea5e9;
                        box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.7), 0 0 20px rgba(14, 165, 233, 0.5);
                    }
                    50% {
                        border-color: #38bdf8;
                        box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.7), 0 0 30px rgba(56, 189, 248, 0.8);
                    }
                }
                
                .tutorial-tooltip {
                    animation: fadeIn 0.3s ease;
                }
                
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(-10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            `;
            document.head.appendChild(style);
        }
        
        createOverlay();
        createTooltip();
        showStep(0);
    }
    
    function initTutorial() {
        setTimeout(() => {
            if (!hasSeenTutorial()) {
                startTutorial();
            } else {
                console.log('💡 Tutorial already seen. Run resetTutorial() to see again.');
            }
        }, 1500);
    }
    
    window.startPolCaBotTutorial = function() {
        startTutorial();
    };
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTutorial);
    } else {
        initTutorial();
    }
    
    console.log('✅ Tutorial system ready');
    console.log('💡 Commands:');
    console.log('   - resetTutorial() - Reset and show tutorial again');
    console.log('   - startPolCaBotTutorial() - Manually start tutorial');
})();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Polcabot-9\resources\views/pages/dashboard.blade.php ENDPATH**/ ?>