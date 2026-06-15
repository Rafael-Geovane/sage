document.addEventListener('DOMContentLoaded', () => {
    // 1. Navbar Scroll Effect
    const header = document.getElementById('navbar');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // 2. FAQ Accordion
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        
        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            
            // Close all other items
            faqItems.forEach(otherItem => {
                otherItem.classList.remove('active');
                otherItem.querySelector('.faq-answer').style.maxHeight = null;
            });
            
            // Toggle current item
            if (!isActive) {
                item.classList.add('active');
                answer.style.maxHeight = answer.scrollHeight + "px";
            }
        });
    });

    // 3. Scroll Reveal Animation
    const revealElements = document.querySelectorAll('.reveal');
    
    const revealOptions = {
        threshold: 0.15,
        rootMargin: "0px 0px -50px 0px"
    };

    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) {
                return;
            }
            
            entry.target.classList.add('active');
            
            // If it's a stats container, trigger counters
            if (entry.target.classList.contains('stat-card')) {
                const counters = entry.target.querySelectorAll('.counter');
                counters.forEach(counter => animateCounter(counter));
            }
            
            observer.unobserve(entry.target);
        });
    }, revealOptions);

    revealElements.forEach(el => {
        revealObserver.observe(el);
    });

    // 4. Counter Animation
    function animateCounter(counter) {
        const target = +counter.getAttribute('data-target');
        const duration = 2000; // ms
        const step = target / (duration / 16); // 60fps
        
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.innerText = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.innerText = target;
            }
        };
        
        updateCounter();
    }

    // 5. Store Logic (if on loja.html)
    if (document.querySelector('.store-page')) {
        const colorInputs = document.querySelectorAll('input[name="color"]');
        const sizeInputs = document.querySelectorAll('input[name="size"]');
        const planInputs = document.querySelectorAll('input[name="plan"]');
        const productImg = document.getElementById('product-img');
        
        // Map color names to image files
        const colorImageMap = {
            'Preto Ônix': '/assets/img/sage_vest_preto_onix.png',
            'Azul Marinho': '/assets/img/sage_vest_azul_marinho.png',
            'Branco Gelo': '/assets/img/sage_vest_branco_gelo.png'
        };

        const summaryOptions = document.getElementById('summary-options');
        const summaryPlanName = document.getElementById('summary-plan-name');
        const summaryHardwarePrice = document.getElementById('summary-hardware-price');
        const summaryPlanPrice = document.getElementById('summary-plan-price');
        const totalToday = document.getElementById('total-today');
        const totalMonthly = document.getElementById('total-monthly');

        const formatCurrency = (val) => val === 0 ? 'Grátis' : `R$ ${val.toFixed(2).replace('.', ',')}`;

        function updateCart() {
            const color = document.querySelector('input[name="color"]:checked').value;
            const size = document.querySelector('input[name="size"]:checked').value;
            const plan = document.querySelector('input[name="plan"]:checked');
            
            summaryOptions.innerText = `${color} • Tamanho ${size}`;

            // Swap product image based on selected color
            if (productImg && colorImageMap[color]) {
                productImg.style.opacity = '0';
                setTimeout(() => {
                    productImg.src = colorImageMap[color];
                    productImg.style.opacity = '1';
                }, 200);
            }
            const pName = plan.parentElement.querySelector('.plan-title h4').innerText;
            const hwPrice = parseFloat(plan.getAttribute('data-price'));
            const moPrice = parseFloat(plan.getAttribute('data-monthly'));
            
            summaryPlanName.innerText = pName;
            summaryHardwarePrice.innerText = formatCurrency(hwPrice);
            summaryPlanPrice.innerText = moPrice === 0 ? 'Sem mensalidade' : `${formatCurrency(moPrice)}/mês`;
            
            // Check shipping if visible and selected
            let shippingPrice = 0;
            const shippingSelected = document.querySelector('input[name="shipping"]:checked');
            if (shippingSelected && document.getElementById('shipping-results').classList.contains('hidden') === false) {
                shippingPrice = parseFloat(shippingSelected.value);
            }

            const todayTotal = hwPrice + shippingPrice;
            totalToday.innerText = formatCurrency(todayTotal);
            
            if(moPrice === 0) {
                totalMonthly.innerText = 'R$ 0,00/mês';
            } else {
                totalMonthly.innerText = `${formatCurrency(moPrice)}/mês`;
            }
        }

        colorInputs.forEach(i => i.addEventListener('change', updateCart));
        sizeInputs.forEach(i => i.addEventListener('change', updateCart));
        planInputs.forEach(i => i.addEventListener('change', updateCart));

        // Shipping mock
        const calcFreteBtn = document.getElementById('calc-frete-btn');
        const cepInput = document.getElementById('cep-input');
        const shippingResults = document.getElementById('shipping-results');
        const shippingInputs = document.querySelectorAll('input[name="shipping"]');

        calcFreteBtn.addEventListener('click', () => {
            if(cepInput.value.length >= 8) {
                calcFreteBtn.innerText = "Calculando...";
                setTimeout(() => {
                    shippingResults.classList.remove('hidden');
                    calcFreteBtn.innerText = "Calculado";
                    updateCart();
                }, 800);
            }
        });

        shippingInputs.forEach(i => i.addEventListener('change', updateCart));

        // Checkout Tabs
        const tabBtns = document.querySelectorAll('.tab-btn');
        const paymentContents = document.querySelectorAll('.payment-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                tabBtns.forEach(b => b.classList.remove('active'));
                paymentContents.forEach(c => c.classList.remove('active'));
                
                btn.classList.add('active');
                const target = document.getElementById(`${btn.getAttribute('data-target')}-form`);
                if(target) target.classList.add('active');
            });
        });

        // Initialize Store State
        updateCart();
    }

    // 6. Dashboard & Admin Sidebar Navigation
    if (document.querySelector('.dashboard-page') || document.querySelector('.admin-page')) {
        const navItems = document.querySelectorAll('.sidebar-nav .nav-item');
        const sections = document.querySelectorAll('.dash-section');
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');

        navItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = item.getAttribute('data-section');
                if (!targetId) return;

                navItems.forEach(n => n.classList.remove('active'));
                item.classList.add('active');

                sections.forEach(s => s.classList.remove('active'));
                const target = document.getElementById('section-' + targetId);
                if (target) target.classList.add('active');

                if (sidebar && window.innerWidth <= 992) {
                    sidebar.classList.remove('open');
                }
            });
        });

        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
            });
        }

        // History tabs
        const htabs = document.querySelectorAll('.htab');
        htabs.forEach(tab => {
            tab.addEventListener('click', () => {
                htabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
            });
        });

        // Event filter buttons
        const efBtns = document.querySelectorAll('.ef-btn');
        efBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                efBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });

        // Simulate live vital updates on dashboard
        if (document.querySelector('.dashboard-page')) {
            setInterval(() => {
                const bpm = document.getElementById('bpm-value');
                const spo2 = document.getElementById('spo2-value');
                const temp = document.getElementById('temp-value');
                if (bpm) bpm.innerText = 68 + Math.floor(Math.random() * 12);
                if (spo2) spo2.innerText = 95 + Math.floor(Math.random() * 4);
                if (temp) temp.innerText = (36.0 + Math.random() * 0.8).toFixed(1);
                console.log('temp', temp.innerText, 'bpm', bpm.innerText, 'spo2', spo2.innerText);
            }, 3000);
        }
    }

    // 7. Login Logic
    const loginBtnNav = document.getElementById('login-btn-nav');
    const loginModal = document.getElementById('login-modal');
    const closeModal = document.getElementById('close-modal');
    const loginForm = document.getElementById('login-form');
    const loginError = document.getElementById('login-error');

    if (loginBtnNav && loginModal) {
        loginBtnNav.addEventListener('click', () => {
            loginModal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', () => {
            loginModal.classList.add('hidden');
            loginError.classList.add('hidden');
        });

        loginModal.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                loginModal.classList.add('hidden');
                loginError.classList.add('hidden');
            }
        });

        // Basic DB
        const usersDB = [
            { id: 0, email: 'admin@sage.com', password: 'admin', role: 'admin' },
            { id: 1, email: 'user@sage.com', password: 'user', role: 'user' }
        ];

        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;

            const user = usersDB.find(u => u.email === email && u.password === password);

            if (user) {
                // Save basic auth state
                localStorage.setItem('sage_user', JSON.stringify(user));
                
                if (user.id === 0) {
                    window.location.href = 'pages/admin.html';
                } else {
                    window.location.href = 'pages/dashboard.html';
                }
            } else {
                loginError.classList.remove('hidden');
            }
        });
    }
});
