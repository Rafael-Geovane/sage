document.addEventListener('DOMContentLoaded', () => {
    // CSRF helper
    const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Universal chip toggle
    document.addEventListener('change', (e) => {
        if (e.target.matches('.chip input[type="checkbox"]')) {
            const label = e.target.closest('.chip');
            if (e.target.checked) {
                label.classList.add('active');
            } else {
                label.classList.remove('active');
            }
        }
    });
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
        
        // Map color names to image files - adjusted for Laravel asset paths
        const colorImageMap = {
            'Preto Ônix': '/assets/sage_vest_preto_onix.png',
            'Azul Marinho': '/assets/sage_vest_azul_marinho.png',
            'Branco Gelo': '/assets/sage_vest_branco_gelo.png'
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

    // 6.5. Emergency contact modal & logic (Dashboard)
    const dashboardBody = document.querySelector('.dashboard-page');
    const userId = dashboardBody ? dashboardBody.getAttribute('data-user-id') : null;

    const addContactBtn = document.getElementById('add-contact-btn');
    const contactModal = document.getElementById('contact-modal');
    const closeContactModal = document.getElementById('close-contact-modal');
    const cancelContactBtn = document.getElementById('cancel-contact-btn');
    const contactForm = document.getElementById('contact-form');
    const contactFormError = document.getElementById('contact-form-error');
    const contactIdInput = document.getElementById('contact-id');

    function closeContactModalFn() {
        if (!contactModal) return;
        contactModal.classList.add('hidden');
        if (contactForm) contactForm.reset();
        if (contactFormError) contactFormError.classList.add('hidden');
        if (contactIdInput) contactIdInput.value = '';
        
        // Reset chips visually
        document.querySelectorAll('#contact-modal .chip').forEach(chip => {
            chip.classList.remove('active');
        });
    }

    function openContactModalFn(isEdit = false) {
        if (!contactModal) return;
        const title = contactModal.querySelector('.modal-header h3');
        if (title) title.innerText = isEdit ? 'Editar Contato' : 'Adicionar Contato de Emergência';
        contactModal.classList.remove('hidden');
    }

    if (addContactBtn && contactModal && closeContactModal && contactForm) {
        addContactBtn.addEventListener('click', () => openContactModalFn(false));
        closeContactModal.addEventListener('click', closeContactModalFn);
        cancelContactBtn && cancelContactBtn.addEventListener('click', closeContactModalFn);

        contactModal.addEventListener('click', (e) => {
            if (e.target === contactModal) {
                closeContactModalFn();
            }
        });

        // Edit contact btn
        document.addEventListener('click', async (e) => {
            const editBtn = e.target.closest('.edit-contact-btn');
            if (editBtn && userId) {
                const cid = editBtn.getAttribute('data-id');
                try {
                    const res = await fetch(`/api/usuarios/${userId}/cuidadores/${cid}`);
                    if (!res.ok) throw new Error('Falha ao buscar contato');
                    const data = await res.json();
                    
                    contactIdInput.value = data.id_cuidador;
                    document.getElementById('contact-name').value = data.nome || '';
                    document.getElementById('contact-phone').value = data.telefone || '';
                    document.getElementById('contact-email').value = data.email || '';
                    
                    const pushCb = document.getElementById('contact-push');
                    const smsCb = document.getElementById('contact-sms');
                    const ligacaoCb = document.getElementById('contact-ligacao');
                    
                    if (pushCb) { pushCb.checked = !!data.notificar_push; pushCb.closest('.chip').classList.toggle('active', pushCb.checked); }
                    if (smsCb) { smsCb.checked = !!data.notificar_sms; smsCb.closest('.chip').classList.toggle('active', smsCb.checked); }
                    if (ligacaoCb) { ligacaoCb.checked = !!data.notificar_ligacao; ligacaoCb.closest('.chip').classList.toggle('active', ligacaoCb.checked); }
                    
                    openContactModalFn(true);
                } catch (err) {
                    console.error(err);
                    alert('Erro ao carregar contato.');
                }
            }

            // Delete contact btn
            const deleteBtn = e.target.closest('.delete-contact-btn');
            if (deleteBtn && userId) {
                if (confirm('Tem certeza que deseja excluir este contato?')) {
                    const cid = deleteBtn.getAttribute('data-id');
                    try {
                        const res = await fetch(`/api/usuarios/${userId}/cuidadores/${cid}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': getCsrfToken() }
                        });
                        if (res.ok) window.location.reload();
                        else alert('Erro ao excluir.');
                    } catch (err) {
                        console.error(err);
                    }
                }
            }
        });

        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const cid = contactIdInput.value;
            const name = document.getElementById('contact-name').value.trim();
            const phone = document.getElementById('contact-phone').value.trim();
            const email = document.getElementById('contact-email').value.trim();
            const push = document.getElementById('contact-push').checked;
            const sms = document.getElementById('contact-sms').checked;
            const ligacao = document.getElementById('contact-ligacao').checked;

            if (!name || !phone) {
                if (contactFormError) contactFormError.classList.remove('hidden');
                return;
            }

            const payload = {
                nome: name, telefone: phone, email: email,
                notificar_push: push, notificar_sms: sms, notificar_ligacao: ligacao
            };

            const url = cid ? `/api/usuarios/${userId}/cuidadores/${cid}` : `/api/usuarios/${userId}/cuidadores`;
            const method = cid ? 'PUT' : 'POST';

            try {
                const res = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify(payload)
                });

                if (res.ok) {
                    window.location.reload();
                } else {
                    alert('Erro ao salvar contato.');
                }
            } catch (err) {
                console.error(err);
            }
        });
    }

    // Alert Settings Save (Dashboard)
    const saveAlertSettings = document.getElementById('save-alert-settings');
    if (saveAlertSettings && userId) {
        saveAlertSettings.addEventListener('click', async () => {
            const pushCb = document.getElementById('user-push');
            const smsCb = document.getElementById('user-sms');
            const ligCb = document.getElementById('user-ligacao');

            const payload = {
                notificar_push: pushCb ? pushCb.checked : false,
                notificar_sms: smsCb ? smsCb.checked : false,
                notificar_ligacao: ligCb ? ligCb.checked : false
            };

            saveAlertSettings.innerText = 'Salvando...';
            try {
                const res = await fetch(`/api/usuarios/${userId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify(payload)
                });
                if (res.ok) {
                    saveAlertSettings.innerText = 'Salvo com sucesso!';
                    setTimeout(() => saveAlertSettings.innerText = 'Salvar Configurações', 2000);
                } else {
                    saveAlertSettings.innerText = 'Erro ao salvar';
                    setTimeout(() => saveAlertSettings.innerText = 'Salvar Configurações', 2000);
                }
            } catch (e) {
                console.error(e);
            }
        });
    }

    // Admin User Edit Logic
    const userEditModal = document.getElementById('user-edit-modal');
    if (userEditModal) {
        const closeUserModal = document.getElementById('close-user-modal');
        const cancelUserModal = document.getElementById('cancel-user-modal');
        const userEditForm = document.getElementById('user-edit-form');
        
        const closeAdminUserModalFn = () => {
            userEditModal.classList.add('hidden');
            userEditForm.reset();
            document.querySelectorAll('#user-edit-modal .chip').forEach(c => c.classList.remove('active'));
        };

        closeUserModal.addEventListener('click', closeAdminUserModalFn);
        cancelUserModal.addEventListener('click', closeAdminUserModalFn);
        userEditModal.addEventListener('click', (e) => {
            if (e.target === userEditModal) closeAdminUserModalFn();
        });

        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.edit-user-btn');
            if (btn) {
                const uid = btn.getAttribute('data-id');
                try {
                    const res = await fetch(`/api/usuarios/${uid}`);
                    if (!res.ok) throw new Error('Falha ao buscar usuário');
                    const data = await res.json();

                    document.getElementById('edit-user-id').value = data.id_usuario;
                    document.getElementById('edit-user-name').value = data.nome || '';
                    document.getElementById('edit-user-email').value = data.email || '';
                    document.getElementById('edit-user-phone').value = data.telefone || '';
                    document.getElementById('edit-user-cpf').value = data.cpf || '';
                    
                    if (data.data_nascimento) {
                        document.getElementById('edit-user-dob').value = data.data_nascimento.split('T')[0];
                    } else {
                        document.getElementById('edit-user-dob').value = '';
                    }

                    document.getElementById('edit-user-plan').value = data.nome_plano || 'Básico';

                    const push = document.getElementById('edit-user-push');
                    const sms = document.getElementById('edit-user-sms');
                    const lig = document.getElementById('edit-user-ligacao');

                    if(push) { push.checked = !!data.notificar_push; push.closest('.chip').classList.toggle('active', push.checked); }
                    if(sms) { sms.checked = !!data.notificar_sms; sms.closest('.chip').classList.toggle('active', sms.checked); }
                    if(lig) { lig.checked = !!data.notificar_ligacao; lig.closest('.chip').classList.toggle('active', lig.checked); }

                    userEditModal.classList.remove('hidden');
                } catch (err) {
                    console.error(err);
                    alert('Erro ao carregar os dados do usuário.');
                }
            }
        });

        userEditForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const uid = document.getElementById('edit-user-id').value;
            const payload = {
                nome: document.getElementById('edit-user-name').value,
                email: document.getElementById('edit-user-email').value,
                telefone: document.getElementById('edit-user-phone').value,
                cpf: document.getElementById('edit-user-cpf').value,
                data_nascimento: document.getElementById('edit-user-dob').value || null,
                nome_plano: document.getElementById('edit-user-plan').value,
                notificar_push: document.getElementById('edit-user-push').checked,
                notificar_sms: document.getElementById('edit-user-sms').checked,
                notificar_ligacao: document.getElementById('edit-user-ligacao').checked
            };

            try {
                const res = await fetch(`/api/usuarios/${uid}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify(payload)
                });
                if (res.ok) {
                    window.location.reload();
                } else {
                    const errorData = await res.json();
                    alert('Erro ao salvar: ' + (errorData.message || 'Dados inválidos.'));
                }
            } catch (err) {
                console.error(err);
                alert('Erro ao processar a requisição.');
            }
        });
    }

    // Admin: View User Modal (eye button)
    const userViewModal = document.getElementById('user-view-modal');
    if (userViewModal) {
        const closeViewModal = document.getElementById('close-user-view-modal');
        const closeViewBtn = document.getElementById('close-user-view-btn');
        const closeViewFn = () => userViewModal.classList.add('hidden');

        closeViewModal.addEventListener('click', closeViewFn);
        closeViewBtn.addEventListener('click', closeViewFn);
        userViewModal.addEventListener('click', (e) => { if (e.target === userViewModal) closeViewFn(); });

        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.view-user-btn');
            if (!btn) return;
            const uid = btn.getAttribute('data-id');
            try {
                const res = await fetch(`/api/usuarios/${uid}`);
                if (!res.ok) throw new Error('Erro');
                const u = await res.json();

                // Iniciais
                const partes = (u.nome || '').split(' ');
                const iniciais = (partes[0]?.[0] || '') + (partes.length > 1 ? partes[partes.length-1][0] : '');
                document.getElementById('view-user-avatar').textContent = iniciais.toUpperCase();
                document.getElementById('view-user-name').textContent = u.nome || '—';

                const planTag = document.getElementById('view-user-plan-tag');
                planTag.textContent = u.nome_plano || 'N/A';
                planTag.className = 'plan-tag ' + ({Premium:'premium', HaaS:'haas'}[u.nome_plano] || 'basic');

                document.getElementById('view-user-cpf').textContent = u.cpf || '—';
                document.getElementById('view-user-dob').textContent = u.data_nascimento ? new Date(u.data_nascimento).toLocaleDateString('pt-BR') : '—';
                document.getElementById('view-user-email').textContent = u.email || '—';
                document.getElementById('view-user-phone').textContent = u.telefone || '—';
                document.getElementById('view-user-address').textContent = u.endereco || '—';

                // Notificações
                const notifDiv = document.getElementById('view-user-notifications');
                notifDiv.innerHTML = '';
                if (u.notificar_push) notifDiv.innerHTML += '<span class="chip active">Push</span>';
                if (u.notificar_sms) notifDiv.innerHTML += '<span class="chip active">SMS</span>';
                if (u.notificar_ligacao) notifDiv.innerHTML += '<span class="chip active">Ligação</span>';
                if (!u.notificar_push && !u.notificar_sms && !u.notificar_ligacao) notifDiv.innerHTML = '<span style="color:var(--text-secondary);">Nenhuma ativa</span>';

                // Dispositivo
                const devDiv = document.getElementById('view-user-device');
                if (u.dispositivo) {
                    devDiv.innerHTML = `<span class="mono">${u.dispositivo.codigo_serial}</span> — ${u.dispositivo.status_conexao} (${u.dispositivo.tipo_conexao || '—'}) — Bateria: ${u.dispositivo.nivel_bateria}%`;
                } else {
                    devDiv.textContent = 'Nenhum dispositivo vinculado';
                }

                // Cuidadores
                const cuidDiv = document.getElementById('view-user-cuidadores');
                if (u.cuidadores && u.cuidadores.length > 0) {
                    cuidDiv.innerHTML = u.cuidadores.map(c => `<div style="padding:8px 0; border-bottom:1px solid var(--glass-border);"><strong>${c.nome}</strong> — ${c.telefone} <span style="color:var(--text-secondary);">(${c.parentesco || '—'})</span></div>`).join('');
                } else {
                    cuidDiv.innerHTML = '<span style="color:var(--text-secondary);">Nenhum cuidador cadastrado</span>';
                }

                userViewModal.classList.remove('hidden');
                lucide.createIcons();
            } catch (err) {
                console.error(err);
                alert('Erro ao carregar dados do usuário.');
            }
        });
    }

    // Admin: Ticket Modal Logic
    const ticketModal = document.getElementById('ticket-modal');
    if (ticketModal) {
        const closeTicketModal = document.getElementById('close-ticket-modal');
        const cancelTicketModal = document.getElementById('cancel-ticket-modal');
        const saveTicketBtn = document.getElementById('save-ticket-btn');
        const closeFn = () => ticketModal.classList.add('hidden');

        closeTicketModal.addEventListener('click', closeFn);
        cancelTicketModal.addEventListener('click', closeFn);
        ticketModal.addEventListener('click', (e) => { if (e.target === ticketModal) closeFn(); });

        // Open ticket modal
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.view-ticket-btn');
            if (!btn) return;
            const tid = btn.getAttribute('data-id');
            try {
                const res = await fetch(`/api/tickets/${tid}`);
                if (!res.ok) throw new Error('Erro');
                const t = await res.json();

                document.getElementById('ticket-modal-id').value = t.id_ticket;
                document.getElementById('ticket-modal-number').textContent = t.numero_ticket;
                document.getElementById('ticket-modal-client').textContent = t.usuario ? t.usuario.nome : '—';
                document.getElementById('ticket-modal-subject').textContent = t.assunto || '—';

                const priorityTag = document.getElementById('ticket-modal-priority');
                priorityTag.textContent = t.prioridade;
                priorityTag.className = 'priority-tag ' + ({Alta:'high', Média:'medium', Baixa:'low'}[t.prioridade] || 'low');

                document.getElementById('ticket-modal-status-select').value = t.status || 'Aguardando';
                document.getElementById('ticket-modal-priority-select').value = t.prioridade || 'Média';

                ticketModal.classList.remove('hidden');
            } catch (err) {
                console.error(err);
                alert('Erro ao carregar ticket.');
            }
        });

        // Save ticket changes
        saveTicketBtn.addEventListener('click', async () => {
            const tid = document.getElementById('ticket-modal-id').value;
            const payload = {
                status: document.getElementById('ticket-modal-status-select').value,
                prioridade: document.getElementById('ticket-modal-priority-select').value
            };
            saveTicketBtn.textContent = 'Salvando...';
            try {
                const res = await fetch(`/api/tickets/${tid}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
                    body: JSON.stringify(payload)
                });
                if (res.ok) {
                    window.location.reload();
                } else {
                    alert('Erro ao salvar ticket.');
                    saveTicketBtn.textContent = 'Salvar Alterações';
                }
            } catch (err) {
                console.error(err);
                saveTicketBtn.textContent = 'Salvar Alterações';
            }
        });

        // Delete ticket
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.delete-ticket-btn');
            if (!btn) return;
            if (!confirm('Tem certeza que deseja excluir este ticket?')) return;
            const tid = btn.getAttribute('data-id');
            try {
                const res = await fetch(`/api/tickets/${tid}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': getCsrfToken() }
                });
                if (res.ok) window.location.reload();
                else alert('Erro ao excluir ticket.');
            } catch (err) {
                console.error(err);
            }
        });
    }

    // Admin: Pedido Modal Logic
    const pedidoModal = document.getElementById('pedido-modal');
    if (pedidoModal) {
        const closePedidoModal = document.getElementById('close-pedido-modal');
        const cancelPedidoModal = document.getElementById('cancel-pedido-modal');
        const savePedidoBtn = document.getElementById('save-pedido-btn');
        const closePedFn = () => pedidoModal.classList.add('hidden');

        closePedidoModal.addEventListener('click', closePedFn);
        cancelPedidoModal.addEventListener('click', closePedFn);
        pedidoModal.addEventListener('click', (e) => { if (e.target === pedidoModal) closePedFn(); });

        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.edit-pedido-btn');
            if (!btn) return;
            const pid = btn.getAttribute('data-id');
            try {
                const res = await fetch(`/api/pedidos/${pid}`);
                if (!res.ok) throw new Error('Erro');
                const p = await res.json();

                document.getElementById('pedido-modal-id').value = p.id_pedido;
                document.getElementById('pedido-modal-number').textContent = p.numero_pedido;
                document.getElementById('pedido-modal-client').textContent = p.usuario ? p.usuario.nome : '—';
                document.getElementById('pedido-modal-valor').textContent = p.valor || '—';
                document.getElementById('pedido-modal-payment').textContent = p.forma_pagamento || '—';

                const statusTag = document.getElementById('pedido-modal-status-tag');
                statusTag.textContent = p.status;
                const statusClass = {Entregue:'online', Enviado:'warning', 'Pend. Pagamento':'pending', Cancelado:'offline'}[p.status] || 'offline';
                statusTag.className = 'status-pill ' + statusClass;

                document.getElementById('pedido-modal-status-select').value = p.status || 'Pend. Pagamento';
                pedidoModal.classList.remove('hidden');
            } catch (err) {
                console.error(err);
                alert('Erro ao carregar pedido.');
            }
        });

        savePedidoBtn.addEventListener('click', async () => {
            const pid = document.getElementById('pedido-modal-id').value;
            const payload = {
                status: document.getElementById('pedido-modal-status-select').value
            };
            savePedidoBtn.textContent = 'Salvando...';
            try {
                const res = await fetch(`/api/pedidos/${pid}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
                    body: JSON.stringify(payload)
                });
                if (res.ok) {
                    window.location.reload();
                } else {
                    alert('Erro ao salvar pedido.');
                    savePedidoBtn.textContent = 'Salvar Alterações';
                }
            } catch (err) {
                console.error(err);
                savePedidoBtn.textContent = 'Salvar Alterações';
            }
        });
    }

    // Admin: User Search Filter
    const userSearchInput = document.getElementById('user-search');
    if (userSearchInput) {
        userSearchInput.addEventListener('input', () => {
            const query = userSearchInput.value.toLowerCase();
            const rows = document.querySelectorAll('#users-table tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }

    // Dashboard: Event filter buttons
    const efBtnsWithFilter = document.querySelectorAll('.ef-btn');
    if (efBtnsWithFilter.length > 0 && document.querySelector('.event-list')) {
        efBtnsWithFilter.forEach(btn => {
            btn.addEventListener('click', () => {
                efBtnsWithFilter.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.textContent.trim();
                const events = document.querySelectorAll('.event-item');

                events.forEach(ev => {
                    if (filter === 'Todos') {
                        ev.style.display = '';
                    } else if (filter === 'Quedas') {
                        ev.style.display = ev.classList.contains('event-danger') ? '' : 'none';
                    } else if (filter === 'Alertas Cardíacos') {
                        ev.style.display = ev.classList.contains('event-warning') ? '' : 'none';
                    } else if (filter === 'SpO2') {
                        ev.style.display = ev.classList.contains('event-info') ? '' : 'none';
                    }
                });
            });
        });
    }

    const registerBtnNav = document.getElementById('register-btn-nav');
    const registerModal = document.getElementById('register-modal');
    const closeRegisterModal = document.getElementById('close-register-modal');
    const registerForm = document.getElementById('register-form');
    const registerError = document.getElementById('register-error');
    const openLoginFromRegister = document.getElementById('open-login-from-register');

    const STORAGE_USERS_KEY = 'sage_users';
    const initialUsersDB = [
        { id: 0, email: 'admin@sage.com', password: 'admin', role: 'admin', name: 'Admin Sage' },
        { id: 1, email: 'user@sage.com', password: 'user', role: 'user', name: 'Usuário Sage' }
    ];

    function loadStoredUsers() {
        try {
            const raw = localStorage.getItem(STORAGE_USERS_KEY);
            const data = raw ? JSON.parse(raw) : [];
            return Array.isArray(data) ? data : [];
        } catch {
            return [];
        }
    }

    function saveStoredUsers(users) {
        localStorage.setItem(STORAGE_USERS_KEY, JSON.stringify(users));
    }

    function getUsersDB() {
        const stored = loadStoredUsers();
        const merged = [...initialUsersDB];
        stored.forEach(user => {
            if (!merged.some(u => u.email === user.email)) {
                merged.push(user);
            }
        });
        return merged;
    }

    let usersDB = getUsersDB();

    function closeRegisterModalFn() {
        if (!registerModal) return;
        registerModal.classList.add('hidden');
        if (registerError) registerError.classList.add('hidden');
        if (registerForm) registerForm.reset();
    }

    function openRegisterModalFn() {
        if (!registerModal) return;
        registerModal.classList.remove('hidden');
        if (loginModal) loginModal.classList.add('hidden');
    }

    if (registerBtnNav && registerModal) {
        registerBtnNav.addEventListener('click', openRegisterModalFn);
        closeRegisterModal?.addEventListener('click', closeRegisterModalFn);
        registerModal.addEventListener('click', (e) => {
            if (e.target === registerModal) {
                closeRegisterModalFn();
            }
        });

        openLoginFromRegister?.addEventListener('click', () => {
            closeRegisterModalFn();
            if (loginModal) loginModal.classList.remove('hidden');
        });

        // Multi-step form logic
        const step1 = document.getElementById('register-step-1');
        const step2 = document.getElementById('register-step-2');
        const step3 = document.getElementById('register-step-3');
        const ind1 = document.getElementById('step1-indicator');
        const ind2 = document.getElementById('step2-indicator');
        const ind3 = document.getElementById('step3-indicator');

        document.getElementById('btn-next-1')?.addEventListener('click', () => {
            const name = document.getElementById('register-name').value.trim();
            const email = document.getElementById('register-email').value.trim();
            const pass = document.getElementById('register-password').value;
            const confirm = document.getElementById('register-password-confirm').value;
            const adminChecked = document.getElementById('register-admin').checked;

            if (!name || !email || pass.length < 6 || pass !== confirm) {
                if (registerError) {
                    registerError.textContent = 'Preencha todos os campos e confirme a senha corretamente (mín. 6 chars).';
                    registerError.classList.remove('hidden');
                }
                return;
            }
            if (registerError) registerError.classList.add('hidden');

            if (adminChecked) {
                // Se for admin, já pode criar a conta sem preencher idoso
                registerForm.dispatchEvent(new Event('submit', { cancelable: true }));
            } else {
                step1.style.display = 'none';
                step2.style.display = 'block';
                ind1.style.fontWeight = 'normal'; ind1.style.color = 'var(--text-secondary)';
                ind2.style.fontWeight = 'bold'; ind2.style.color = 'var(--primary)';
            }
        });

        document.getElementById('btn-prev-2')?.addEventListener('click', () => {
            step2.style.display = 'none';
            step1.style.display = 'block';
            ind2.style.fontWeight = 'normal'; ind2.style.color = 'var(--text-secondary)';
            ind1.style.fontWeight = 'bold'; ind1.style.color = 'var(--primary)';
        });

        document.getElementById('btn-next-2')?.addEventListener('click', () => {
            step2.style.display = 'none';
            step3.style.display = 'block';
            ind2.style.fontWeight = 'normal'; ind2.style.color = 'var(--text-secondary)';
            ind3.style.fontWeight = 'bold'; ind3.style.color = 'var(--primary)';
        });

        document.getElementById('btn-prev-3')?.addEventListener('click', () => {
            step3.style.display = 'none';
            step2.style.display = 'block';
            ind3.style.fontWeight = 'normal'; ind3.style.color = 'var(--text-secondary)';
            ind2.style.fontWeight = 'bold'; ind2.style.color = 'var(--primary)';
        });

        registerForm?.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!registerForm) return;
            const name = document.getElementById('register-name').value.trim();
            const email = document.getElementById('register-email').value.trim().toLowerCase();
            const password = document.getElementById('register-password').value;
            const adminChecked = document.getElementById('register-admin').checked;

            usersDB = getUsersDB();
            const existingUser = usersDB.find(u => u.email === email);
            if (existingUser) {
                if (registerError) {
                    registerError.textContent = 'Já existe uma conta com este e-mail.';
                    registerError.classList.remove('hidden');
                }
                return;
            }

            const nextId = Date.now();
            const newUser = {
                id: nextId,
                name,
                email,
                password,
                role: adminChecked ? 'admin' : 'user'
            };

            if (!adminChecked) {
                const pNome = document.getElementById('register-paciente-nome').value.trim();
                const pCpf = document.getElementById('register-paciente-cpf').value.trim();
                const pNasc = document.getElementById('register-paciente-nascimento').value;
                const pTel = document.getElementById('register-paciente-telefone').value.trim();

                const tSangue = document.getElementById('register-tipo-sanguineo').value;
                const condicoes = document.getElementById('register-condicoes').value.trim();
                const alergias = document.getElementById('register-alergias').value.trim();
                const medicamentos = document.getElementById('register-medicamentos').value.trim();

                try {
                    await fetch('/api/usuarios', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken()
                        },
                        body: JSON.stringify({
                            nome: pNome || name, // Fallback se paciente n for preenchido
                            cpf: pCpf || null,
                            data_nascimento: pNasc || null,
                            telefone: pTel || null,
                            email: email, // Usamos o email do cuidador para logar no DB tbm
                            nome_plano: 'Básico',
                            nome_responsavel: name, // Cuidador
                            tipo_sanguineo: tSangue || null,
                            condicoes_medicas: condicoes || null,
                            alergias: alergias || null,
                            medicamentos: medicamentos || null
                        })
                    });
                } catch (err) {
                    console.error('Erro ao sincronizar idoso com banco', err);
                }
            }

            const stored = loadStoredUsers();
            stored.push(newUser);
            saveStoredUsers(stored);
            usersDB = getUsersDB();

            closeRegisterModalFn();
            
            // Restaura as tabs pro estado inicial
            if (step1) step1.style.display = 'block';
            if (step2) step2.style.display = 'none';
            if (step3) step3.style.display = 'none';
            if (ind1) { ind1.style.fontWeight = 'bold'; ind1.style.color = 'var(--primary)'; }
            if (ind2) { ind2.style.fontWeight = 'normal'; ind2.style.color = 'var(--text-secondary)'; }
            if (ind3) { ind3.style.fontWeight = 'normal'; ind3.style.color = 'var(--text-secondary)'; }

            if (loginModal) loginModal.classList.remove('hidden');
            document.getElementById('login-email').value = email;
            document.getElementById('login-password').value = '';
            alert('Conta e ficha médica criadas com sucesso. Agora faça login.');
        });
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

        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('login-email').value.trim().toLowerCase();
            const password = document.getElementById('login-password').value;

            usersDB = getUsersDB();
            const user = usersDB.find(u => u.email === email && u.password === password);

            if (user) {
                localStorage.setItem('sage_user', JSON.stringify(user));
                document.cookie = "sage_email=" + encodeURIComponent(user.email) + "; path=/";
                if (user.role === 'admin') {
                    window.location.href = '/admin';
                } else {
                    window.location.href = '/dashboard';
                }
            } else {
                loginError.classList.remove('hidden');
            }
        });
    }

    // ==========================================
    // 8. New Account Modal (Admin)
    // ==========================================
    const newAccountModal = document.getElementById('new-account-modal');
    const newAccountBtn = document.getElementById('new-account-btn');
    const closeNewAccountModal = document.getElementById('close-new-account-modal');
    const cancelNewAccount = document.getElementById('cancel-new-account');
    const newAccountForm = document.getElementById('new-account-form');
    const newAccountError = document.getElementById('new-account-error');

    function closeNewAccountModalFn() {
        if (!newAccountModal) return;
        newAccountModal.classList.add('hidden');
        if (newAccountForm) newAccountForm.reset();
        if (newAccountError) newAccountError.classList.add('hidden');
        // Reset chips
        document.querySelectorAll('#new-account-modal .chip').forEach(c => c.classList.remove('active'));
        // Reset device serial rows to just one
        const list = document.getElementById('device-serial-list');
        if (list) {
            const rows = list.querySelectorAll('.device-serial-row');
            rows.forEach((row, i) => { if (i > 0) row.remove(); });
            const firstRow = list.querySelector('.device-serial-row');
            if (firstRow) {
                firstRow.querySelector('.device-serial-input').value = '';
                firstRow.querySelector('.remove-device-row').style.visibility = 'hidden';
            }
        }
    }

    if (newAccountBtn && newAccountModal) {
        newAccountBtn.addEventListener('click', () => {
            newAccountModal.classList.remove('hidden');
            lucide.createIcons();
        });

        closeNewAccountModal?.addEventListener('click', closeNewAccountModalFn);
        cancelNewAccount?.addEventListener('click', closeNewAccountModalFn);
        newAccountModal.addEventListener('click', (e) => {
            if (e.target === newAccountModal) closeNewAccountModalFn();
        });

        // Dynamic add device serial row
        const addDeviceSerialBtn = document.getElementById('add-device-serial-btn');
        if (addDeviceSerialBtn) {
            addDeviceSerialBtn.addEventListener('click', () => {
                const list = document.getElementById('device-serial-list');
                const newRow = document.createElement('div');
                newRow.className = 'device-serial-row';
                newRow.innerHTML = `
                    <div class="form-group" style="flex:1;">
                        <label>Código Serial do Dispositivo</label>
                        <input type="text" class="device-serial-input" placeholder="Ex: SGE-0100">
                    </div>
                    <button type="button" class="icon-btn danger remove-device-row" style="margin-top:24px;">
                        <i data-lucide="trash-2"></i>
                    </button>
                `;
                list.appendChild(newRow);
                lucide.createIcons();

                // Show remove button on first row if there's more than one
                const rows = list.querySelectorAll('.device-serial-row');
                if (rows.length > 1) {
                    rows[0].querySelector('.remove-device-row').style.visibility = 'visible';
                }
            });

            // Remove device serial row (delegated)
            document.addEventListener('click', (e) => {
                const removeBtn = e.target.closest('.remove-device-row');
                if (removeBtn && removeBtn.closest('#device-serial-list')) {
                    removeBtn.closest('.device-serial-row').remove();
                    const list = document.getElementById('device-serial-list');
                    const rows = list.querySelectorAll('.device-serial-row');
                    if (rows.length === 1) {
                        rows[0].querySelector('.remove-device-row').style.visibility = 'hidden';
                    }
                }
            });
        }

        // Submit new account form
        newAccountForm?.addEventListener('submit', async (e) => {
            e.preventDefault();

            const nome = document.getElementById('new-nome').value.trim();
            if (!nome) {
                newAccountError.textContent = 'O nome do idoso é obrigatório.';
                newAccountError.classList.remove('hidden');
                return;
            }

            // Collect device serials
            const serialInputs = document.querySelectorAll('#device-serial-list .device-serial-input');
            const dispositivos_serial = [];
            serialInputs.forEach(input => {
                const v = input.value.trim();
                if (v) dispositivos_serial.push(v);
            });

            const payload = {
                nome: nome,
                cpf: document.getElementById('new-cpf').value.trim() || null,
                email: document.getElementById('new-email').value.trim() || null,
                telefone: document.getElementById('new-telefone').value.trim() || null,
                data_nascimento: document.getElementById('new-nascimento').value || null,
                endereco: document.getElementById('new-endereco').value.trim() || null,
                nome_plano: document.getElementById('new-plano').value,
                notificar_push: document.getElementById('new-push').checked,
                notificar_sms: document.getElementById('new-sms').checked,
                notificar_ligacao: document.getElementById('new-ligacao').checked,
                nome_responsavel: document.getElementById('new-resp-nome').value.trim() || null,
                telefone_responsavel: document.getElementById('new-resp-telefone').value.trim() || null,
                email_responsavel: document.getElementById('new-resp-email').value.trim() || null,
                parentesco: document.getElementById('new-resp-parentesco').value || null,
                dispositivos_serial: dispositivos_serial.length > 0 ? dispositivos_serial : null,
            };

            const submitBtn = document.getElementById('submit-new-account');
            submitBtn.innerHTML = '<i data-lucide="loader"></i> Criando...';
            submitBtn.disabled = true;

            try {
                const res = await fetch('/api/usuarios', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify(payload)
                });

                if (res.ok) {
                    closeNewAccountModalFn();
                    window.location.reload();
                } else {
                    const errorData = await res.json();
                    let errorMsg = 'Erro ao criar conta.';
                    if (errorData.errors) {
                        const msgs = Object.values(errorData.errors).flat();
                        errorMsg = msgs.join(' ');
                    } else if (errorData.message) {
                        errorMsg = errorData.message;
                    }
                    newAccountError.textContent = errorMsg;
                    newAccountError.classList.remove('hidden');
                }
            } catch (err) {
                console.error(err);
                newAccountError.textContent = 'Erro de conexão ao criar conta.';
                newAccountError.classList.remove('hidden');
            } finally {
                submitBtn.innerHTML = '<i data-lucide="check"></i> Criar Conta';
                submitBtn.disabled = false;
                lucide.createIcons();
            }
        });
    }

    // ==========================================
    // 9. Add Device Modal (Dashboard)
    // ==========================================
    const addDeviceBtn = document.getElementById('add-device-btn');
    const addDeviceModal = document.getElementById('add-device-modal');
    const closeDeviceModal = document.getElementById('close-device-modal');
    const cancelDeviceModal = document.getElementById('cancel-device-modal');
    const addDeviceForm = document.getElementById('add-device-form');
    const deviceFormError = document.getElementById('device-form-error');

    function closeDeviceModalFn() {
        if (!addDeviceModal) return;
        addDeviceModal.classList.add('hidden');
        if (addDeviceForm) addDeviceForm.reset();
        if (deviceFormError) deviceFormError.classList.add('hidden');
    }

    if (addDeviceBtn && addDeviceModal) {
        addDeviceBtn.addEventListener('click', () => {
            addDeviceModal.classList.remove('hidden');
            lucide.createIcons();
        });

        closeDeviceModal?.addEventListener('click', closeDeviceModalFn);
        cancelDeviceModal?.addEventListener('click', closeDeviceModalFn);
        addDeviceModal.addEventListener('click', (e) => {
            if (e.target === addDeviceModal) closeDeviceModalFn();
        });

        addDeviceForm?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const serial = document.getElementById('device-serial').value.trim();
            if (!serial) {
                deviceFormError.textContent = 'O código serial é obrigatório.';
                deviceFormError.classList.remove('hidden');
                return;
            }

            try {
                const res = await fetch('/api/dispositivos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify({
                        codigo_serial: serial,
                        id_usuario: userId || null
                    })
                });

                if (res.ok) {
                    closeDeviceModalFn();
                    window.location.reload();
                } else {
                    const errorData = await res.json();
                    let errorMsg = 'Erro ao adicionar dispositivo.';
                    if (errorData.errors) {
                        const msgs = Object.values(errorData.errors).flat();
                        errorMsg = msgs.join(' ');
                    } else if (errorData.message) {
                        errorMsg = errorData.message;
                    }
                    deviceFormError.textContent = errorMsg;
                    deviceFormError.classList.remove('hidden');
                }
            } catch (err) {
                console.error(err);
                deviceFormError.textContent = 'Erro de conexão.';
                deviceFormError.classList.remove('hidden');
            }
        });
    }

    // Delete device button (Dashboard)
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.delete-device-btn');
        if (!btn) return;
        if (!confirm('Tem certeza que deseja remover este dispositivo?')) return;
        const did = btn.getAttribute('data-id');
        try {
            const res = await fetch(`/api/dispositivos/${did}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': getCsrfToken() }
            });
            if (res.ok) window.location.reload();
            else alert('Erro ao remover dispositivo.');
        } catch (err) {
            console.error(err);
        }
    });
});

