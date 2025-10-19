// ===== FUNCIONES PHP ORIGINALES MANTENIDAS =====
    function actualizarRegistro(tabla, id, campo, valor) {
        $.ajax({
            url: '../LN/ln_actualizarListaR.php',
            type: 'POST',
            data: { tabla: tabla, id: id, campo: campo, valor: valor },
            success: function(response) {
                // Mostrar notificación visual moderna
                showNotification('Registro actualizado correctamente', 'success');
            },
            error: function() {
                showNotification('Error al actualizar el registro', 'error');
            }
        });
    }

    function cambiarEstado(tabla, id, estado) {
        $.ajax({
            url: '../LN/ln_actualizar_estadoListaR.php',
            type: 'POST',
            data: { tabla: tabla, id: id, estado: estado },
            success: function(response) {
                showNotification('Estado cambiado correctamente', 'success');
                // Actualizar visualmente el estado después de cambiar
                setTimeout(() => {
                    location.reload();
                }, 1000);
            },
            error: function() {
                showNotification('Error al cambiar el estado', 'error');
            }
        });
    }

    // ===== FUNCIONES PARA ACORDEONES =====
    function toggleAccordion(header) {
        const content = header.nextElementSibling;
        const chevron = header.querySelector('.chevron');
        const isOpen = content.classList.contains('open');

        if (isOpen) {
            content.classList.remove('open');
            content.style.maxHeight = '0';
            header.classList.remove('active');
        } else {
            content.classList.add('open');
            content.style.maxHeight = content.scrollHeight + 'px';
            header.classList.add('active');
        }

        updateRecordCount(header.parentElement);
    }

    // ===== ACTUALIZAR CONTADORES =====
    function updateRecordCount(accordion, visibleCount = null) {
        const countElement = accordion.querySelector('.count-number');
        const table = accordion.querySelector('.modern-table');

        if (visibleCount === null) {
            const visibleRows = table.querySelectorAll('tbody tr:not(.hidden)');
            visibleCount = visibleRows.length;
        }

        countElement.textContent = visibleCount;

        // Añadir efecto de pulso cuando cambia el contador
        countElement.parentElement.style.animation = 'pulse 0.5s ease-in-out';
        setTimeout(() => {
            countElement.parentElement.style.animation = '';
        }, 500);
    }

    function filtrarTabla(input) {
        const searchTerm = input.value.toLowerCase();
        const tableWrapper = input.closest('.accordion-content');
        const rows = tableWrapper.querySelectorAll('tbody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const match = rowText.includes(searchTerm);

            row.style.display = match ? '' : 'none';
            row.classList.toggle('hidden', !match);

            if (match) visibleCount++;
        });

        const accordion = input.closest('.table-accordion');
        updateRecordCount(accordion, visibleCount);
    }



function cerrarModalEditar() {
    document.getElementById('modal-editar').style.display = 'none';
}

document.getElementById('form-editar-menu').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('editar-id').value;
    const descripcion = document.getElementById('editar-descripcion').value;
    const archivo = document.getElementById('editar-archivo').files[0];
    const archivo_ln = document.getElementById('editar-ln').files[0];
    const archivo_ad = document.getElementById('editar-ad').files[0];
    const archivo_img = document.getElementById('editar-img').files[0];
    const archivo_js = document.getElementById('editar-js').files[0];

    const formData = new FormData();
    formData.append('id_menu', id);
    formData.append('descripcion_menu', descripcion);
    if (archivo) formData.append('nombrearchivo_menu', archivo);
    if (archivo_ln) formData.append('nombrearchivo_ln', archivo_ln);
    if (archivo_ad) formData.append('nombrearchivo_ad', archivo_ad);
    if (archivo_img) formData.append('nombrearchivo_img', archivo_img);
    if (archivo_js) formData.append('nombrearchivo_js', archivo_js);

    console.log("Archivo JS:", archivo_js);
    fetch('../LN/ln_actualizar_menu.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        alert(data);
        cerrarModalEditar();
        location.reload();
    });
});










    // ===== SISTEMA DE NOTIFICACIONES =====
    function showNotification(message, type = 'info') {
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
                <button class="notification-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

        // Agregar estilos dinámicamente
        if (!document.querySelector('#notification-styles')) {
            const style = document.createElement('style');
            style.id = 'notification-styles';
            style.textContent = `
                    .notification {
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        z-index: 1000;
                        min-width: 300px;
                        padding: 1rem;
                        border-radius: 12px;
                        box-shadow: var(--shadow-heavy);
                        backdrop-filter: blur(10px);
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        animation: slideInRight 0.3s ease-out;
                        margin-bottom: 1rem;
                    }

                    .notification-success {
                        background: linear-gradient(135deg, rgba(78, 205, 196, 0.9), rgba(69, 183, 170, 0.9));
                        color: white;
                        border: 1px solid rgba(78, 205, 196, 0.3);
                    }

                    .notification-error {
                        background: linear-gradient(135deg, rgba(255, 107, 107, 0.9), rgba(255, 99, 99, 0.9));
                        color: white;
                        border: 1px solid rgba(255, 107, 107, 0.3);
                    }

                    .notification-info {
                        background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
                        color: white;
                        border: 1px solid rgba(102, 126, 234, 0.3);
                    }

                    .notification-content {
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                        flex: 1;
                    }

                    .notification-close {
                        background: none;
                        border: none;
                        color: inherit;
                        cursor: pointer;
                        padding: 0.25rem;
                        border-radius: 50%;
                        transition: all 0.2s ease;
                    }

                    .notification-close:hover {
                        background: rgba(255, 255, 255, 0.2);
                    }

                    @keyframes slideInRight {
                        from {
                            transform: translateX(100%);
                            opacity: 0;
                        }
                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }
                `;
            document.head.appendChild(style);
        }

        // Agregar al DOM
        document.body.appendChild(notification);

        // Auto-remove después de 4 segundos
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.animation = 'slideInRight 0.3s ease-out reverse';
                setTimeout(() => notification.remove(), 300);
            }
        }, 4000);
    }

    // ===== EFECTOS DE SCROLL =====
    function initializeScrollEffects() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease-out';
                    entry.target.style.animationDelay = '0.1s';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observar elementos que necesitan animación
        document.querySelectorAll('.table-accordion, .stat-card').forEach(el => {
            observer.observe(el);
        });
    }

    // ===== MEJORAR CAMPOS EDITABLES =====
    function enhanceEditableFields() {
        const editableFields = document.querySelectorAll('[contenteditable="true"]');

        editableFields.forEach(field => {
            // Almacenar valor original
            field.dataset.originalValue = field.textContent.trim();

            // Eventos para mejorar UX
            field.addEventListener('focus', function() {
                this.style.transform = 'scale(1.02)';
                this.style.zIndex = '10';
            });

            field.addEventListener('blur', function() {
                this.style.transform = 'scale(1)';
                this.style.zIndex = '1';

                // Verificar si el valor cambió
                const newValue = this.textContent.trim();
                if (newValue !== this.dataset.originalValue) {
                    this.dataset.originalValue = newValue;
                    // Añadir efecto visual de guardado
                    this.style.background = 'rgba(78, 205, 196, 0.1)';
                    setTimeout(() => {
                        this.style.background = '';
                    }, 1000);
                }
            });

            // Evitar saltos de línea
            field.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.blur();
                }
            });
        });
    }

    // ===== INICIALIZACIÓN =====
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar todas las funcionalidades
        initializeSearch();
        initializeScrollEffects();
        enhanceEditableFields();
        inicializarModalEditar();

        // Abrir primer acordeón por defecto
        const firstAccordion = document.querySelector('.accordion-header');
        if (firstAccordion) {
            toggleAccordion(firstAccordion);
        }

        // Mostrar notificación de bienvenida
        setTimeout(() => {
            showNotification('Dashboard cargado correctamente', 'success');
        }, 1000);

        // Efecto de carga inicial
        document.querySelectorAll('.table-accordion').forEach((accordion, index) => {
            accordion.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
        });

        document.addEventListener('click', function (e) {
            const editarBtn = e.target.closest('.btn-edit');
            if (editarBtn) {
                abrirModalEditar(editarBtn);
            }
        });

    });

    // ===== MANEJO DE ERRORES GLOBALES =====
    window.addEventListener('error', function(e) {
        console.error('Error capturado:', e.message);
        if (e.message.includes('Cannot read') || e.message.includes('undefined') || e.message.includes('null')) {
            showNotification('Ha ocurrido un error inesperado', 'error');
        }
    });

// ===== RESPONSIVE ENHANCEMENTS =====
    function handleResize() {
        const isMobile = window.innerWidth <= 768;
        const accordionHeaders = document.querySelectorAll('.accordion-header');

        accordionHeaders.forEach(header => {
            const meta = header.querySelector('.accordion-meta');
            if (isMobile) {
                meta.style.fontSize = '0.8rem';
            } else {
                meta.style.fontSize = '0.9rem';
            }
        });
    }

    window.addEventListener('resize', handleResize);
    handleResize(); // Ejecutar una vez al cargar

    // ===== MEJORA DE PERFORMANCE =====
    // Lazy loading para tablas grandes
    function lazyLoadTableRows() {
        const tables = document.querySelectorAll('.modern-table');

        tables.forEach(table => {
            const rows = table.querySelectorAll('tbody tr');
            if (rows.length > 100) {
                // Implementar carga lazy para tablas con más de 100 filas
                rows.forEach((row, index) => {
                    if (index > 50) {
                        row.style.display = 'none';
                        row.classList.add('lazy-row');
                    }
                });

                // Agregar botón "Cargar más"
                const loadMoreBtn = document.createElement('button');
                loadMoreBtn.className = 'modern-btn btn-activate';
                loadMoreBtn.innerHTML = '<i class="fas fa-plus"></i> Cargar más registros';
                loadMoreBtn.style.margin = '1rem auto';
                loadMoreBtn.style.display = 'block';

                loadMoreBtn.addEventListener('click', function() {
                    const hiddenRows = table.querySelectorAll('.lazy-row:not([style*="table-row"])');
                    const nextBatch = Array.from(hiddenRows).slice(0, 50);

                    nextBatch.forEach(row => {
                        row.style.display = 'table-row';
                        row.style.animation = 'fadeInUp 0.3s ease-out';
                    });

                    if (hiddenRows.length <= 50) {
                        this.remove();
                    }
                });

                table.parentElement.appendChild(loadMoreBtn);
            }
        });
    }

    // Ejecutar lazy loading si es necesario
    setTimeout(lazyLoadTableRows, 500);

    // ===== EXPANDIR / CONTRAER TODOS LOS ACORDEONES =====
    document.getElementById('toggleAll').addEventListener('click', function () {
        const headers = document.querySelectorAll('.accordion-header');
        const allOpen = Array.from(headers).every(header => header.nextElementSibling.classList.contains('open'));

        headers.forEach(header => {
            const content = header.nextElementSibling;
            const isOpen = content.classList.contains('open');

            // Si todos están abiertos, cerrarlos; si no, abrirlos todos
            if (allOpen && isOpen) {
                toggleAccordion(header); // Cierra
            } else if (!allOpen && !isOpen) {
                toggleAccordion(header); // Abre
            }
        });

        // Opcional: cambiar texto/icono del botón
        const toggleBtn = document.getElementById('toggleAll');
        toggleBtn.innerHTML = allOpen
            ? '<i class="fas fa-expand-arrows-alt"></i> Expandir Todo'
            : '<i class="fas fa-compress-arrows-alt"></i> Contraer Todo';
    });


function inicializarModalEditar() {
    // ==== ULTRA-MODERN MODAL ANIMATIONS & INTERACTIONS ====

    /**
     * Enhanced Modal Opening Animation
     * Uses GSAP for smooth, professional animations
     */


    /**
     * Enhanced Modal Closing Animation
     * Smooth reverse animation with GSAP
     */
    function cerrarModalEditar() {
        const modal = document.getElementById('modal-editar');
        const modalContent = modal.querySelector('.modal-content');

        // GSAP Closing Animation
        const tl = gsap.timeline({
            onComplete: () => {
                modal.style.display = 'none';
                modal.classList.remove('active');
                modal.setAttribute('aria-hidden', 'true');

                // Reset form (preserving original logic)
                document.getElementById('form-editar-menu').reset();
            }
        });

        // Animate elements out
        tl.to(modalContent.querySelectorAll('.form-group, .modern-btn'), {
            y: -20,
            opacity: 0,
            duration: 0.2,
            stagger: 0.05,
            ease: "power2.in"
        })
            .to(modalContent, {
                scale: 0.8,
                y: 50,
                opacity: 0,
                rotationX: 15,
                duration: 0.4,
                ease: "power2.in"
            }, "-=0.1")
            .to(modal, {
                opacity: 0,
                duration: 0.3,
                ease: "power2.in"
            }, "-=0.2");

        // Remove keyboard event listener
        document.removeEventListener('keydown', handleEscapeKey);
    }

    /**
     * Enhanced Form Submission with Loading Animation
     * Preserves original logic while adding visual feedback
     */
    document.getElementById('form-editar-menu').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;

        // Add loading state
        submitButton.classList.add('loading');
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        submitButton.disabled = true;

        // Simulate form processing (replace with actual logic)
        setTimeout(() => {
            // Success animation
            gsap.to(submitButton, {
                scale: 1.1,
                duration: 0.1,
                yoyo: true,
                repeat: 1,
                ease: "power2.out",
                onComplete: () => {
                    submitButton.classList.remove('loading');
                    submitButton.innerHTML = '<i class="fas fa-check"></i> Guardado!';
                    submitButton.style.background = 'linear-gradient(135deg, rgba(76, 175, 80, 0.9) 0%, rgba(67, 160, 71, 0.9) 100%)';

                    // Reset button after delay
                    setTimeout(() => {
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                        submitButton.style.background = '';
                        cerrarModalEditar();
                    }, 1500);
                }
            });
        }, 2000);
    });

    /**
     * Enhanced Keyboard Navigation
     * ESC key support with smooth animation
     */
    function handleEscapeKey(e) {
        if (e.key === 'Escape') {
            cerrarModalEditar();
        }
    }

    /**
     * Click Outside to Close
     * Enhanced with smooth animation
     */
    document.getElementById('modal-editar').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalEditar();
        }
    });

    /**
     * Enhanced Input Focus Effects
     * Smooth animations for better UX
     */
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            gsap.to(this, {
                scale: 1.02,
                duration: 0.3,
                ease: "power2.out"
            });
        });

        input.addEventListener('blur', function() {
            gsap.to(this, {
                scale: 1,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });

    /**
     * Button Hover Enhancements
     * Micro-interactions for premium feel
     */
    document.querySelectorAll('.modern-btn').forEach(button => {
        button.addEventListener('mouseenter', function() {
            gsap.to(this, {
                scale: 1.05,
                duration: 0.3,
                ease: "power2.out"
            });
        });

        button.addEventListener('mouseleave', function() {
            gsap.to(this, {
                scale: 1,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });

    /**
     * Accessibility: Focus trap within modal
     * Ensures keyboard navigation stays within modal
     */
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );

        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        lastFocusable.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        firstFocusable.focus();
                        e.preventDefault();
                    }
                }
            }
        });
    }

    // Initialize focus trap when modal opens
    document.getElementById('modal-editar').addEventListener('transitionend', function() {
        if (this.classList.contains('active')) {
            trapFocus(this);
        }
    });

    /**
     * Smooth Scrollbar for Modal Content
     * Enhanced scrolling experience
     */
    const modalContent = document.querySelector('.modal-content');
    if (modalContent) {
        modalContent.addEventListener('scroll', function() {
            const scrollPercentage = this.scrollTop / (this.scrollHeight - this.clientHeight);
            this.style.setProperty('--scroll-progress', scrollPercentage);
        });
    }
}

function abrirModalEditar(button) {
    const modal = document.getElementById('modal-editar');
    const modalContent = modal.querySelector('.modal-content');

    // Extract data attributes (preserving original logic)
    const id = button.getAttribute('data-id');
    const descripcion = button.getAttribute('data-descripcion');
    const archivo = button.getAttribute('data-archivo');

    // Populate form fields (preserving original logic)
    document.getElementById('editar-id').value = id;
    document.getElementById('editar-descripcion').value = descripcion;
    document.getElementById('archivo-actual').textContent = archivo;

    // Show modal with enhanced animations
    modal.style.display = 'flex';
    modal.classList.add('active');
    modal.setAttribute('aria-hidden', 'false');

    // GSAP Animation Timeline
    const tl = gsap.timeline();

    // Animate modal overlay
    tl.fromTo(modal, {
        opacity: 0
    }, {
        opacity: 1,
        duration: 0.4,
        ease: "power2.out"
    })
        // Animate modal content with elastic effect
        .fromTo(modalContent, {
            scale: 0.7,
            y: 100,
            opacity: 0,
            rotationX: -15
        }, {
            scale: 1,
            y: 0,
            opacity: 1,
            rotationX: 0,
            duration: 0.6,
            ease: "back.out(1.7)"
        }, "-=0.2")
        // Animate form elements sequentially
        .fromTo(modalContent.querySelectorAll('.form-group'), {
            y: 30,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.4,
            stagger: 0.1,
            ease: "power2.out"
        }, "-=0.3")
        // Animate button
        .fromTo(modalContent.querySelector('.modern-btn'), {
            scale: 0.8,
            opacity: 0
        }, {
            scale: 1,
            opacity: 1,
            duration: 0.3,
            ease: "back.out(1.7)"
        }, "-=0.2");

    // Focus management for accessibility
    setTimeout(() => {
        document.getElementById('editar-descripcion').focus();
    }, 600);

    // Add keyboard event listener for ESC key
    document.addEventListener('keydown', handleEscapeKey);
}

function eliminarRegistro(tabla, id) {
    if (!confirm('¿Estás seguro de eliminar este registro? Esta acción no se puede deshacer.')) return;

    $.ajax({
        url: '../LN/ln_eliminarMenu.php',
        type: 'POST',
        data: { id_menu: id },
        success: function(response) {
            if (response.includes('✅')) {
                showNotification(response, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(response, 'error');
            }
        },
        error: function() {
            showNotification('❌ Error al eliminar el registro', 'error');
        }
    });
}

// Abrir modal y cargar datos
function abrirModalEditarNombreBien(button) {
    const modal = document.getElementById('modal-editar-nombre-bien');
    const modalContent = modal.querySelector('.modal-content');

    const id = button.getAttribute('data-id');
    const descripcion = button.getAttribute('data-descripcion');

    document.getElementById('editar-id-nb').value = id;
    document.getElementById('editar-descripcion-nb').value = descripcion;

    modal.style.display = 'flex';
    modal.classList.add('active');
    modal.setAttribute('aria-hidden', 'false');

    const tl = gsap.timeline();

    tl.fromTo(modal, {
        opacity: 0
    }, {
        opacity: 1,
        duration: 0.4,
        ease: "power2.out"
    }).fromTo(modalContent, {
        scale: 0.7,
        y: 100,
        opacity: 0,
        rotationX: -15
    }, {
        scale: 1,
        y: 0,
        opacity: 1,
        rotationX: 0,
        duration: 0.6,
        ease: "back.out(1.7)"
    }, "-=0.2").fromTo(modalContent.querySelectorAll('.form-group'), {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.4,
        stagger: 0.1,
        ease: "power2.out"
    }, "-=0.3").fromTo(modalContent.querySelector('.modern-btn'), {
        scale: 0.8,
        opacity: 0
    }, {
        scale: 1,
        opacity: 1,
        duration: 0.3,
        ease: "back.out(1.7)"
    }, "-=0.2");

    setTimeout(() => {
        document.getElementById('editar-descripcion-nb').focus();
    }, 600);

    document.addEventListener('keydown', handleEscapeKeyNombreBien);
}

function cerrarModalEditarNombreBien() {
    const modal = document.getElementById('modal-editar-nombre-bien');
    modal.style.display = 'none';
    modal.classList.remove('active');
    modal.setAttribute('aria-hidden', 'true');
    document.removeEventListener('keydown', handleEscapeKeyNombreBien);
}

function handleEscapeKeyNombreBien(e) {
    if (e.key === "Escape") {
        cerrarModalEditarNombreBien();
    }
}

document.getElementById('form-editar-nombre-bien').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('../LN/ln_actualizar_nombrebien.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Nombre del bien actualizado correctamente');
                location.reload(); // Puedes reemplazar por recargar solo la tabla
            } else {
                alert('Error: ' + data.message);
            }
        }).catch(err => {
        console.error('Error en la solicitud:', err);
        alert('Error de red o del servidor.');
    });
});


function eliminarRegistroNombreBien(tabla, id) {
    if (!confirm('¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.')) {
        return;
    }

    const formData = new FormData();
    formData.append('tabla', tabla);
    formData.append('id', id);

    fetch('../LN/ln_eliminar_registro_nombre_bien.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Registro eliminado correctamente');
                location.reload(); // O recargar solo la tabla si usas AJAX
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(err => {
            console.error('Error al eliminar:', err);
            alert('Hubo un error al intentar eliminar el registro.');
        });
}


// Abrir modal agregar
function abrirModalAgregarNombreBien() {
    const modal = document.getElementById('modal-agregar-nombrebien');
    const modalContent = modal.querySelector('.modal-content');

    // Mostrar modal y preparar accesibilidad
    modal.style.display = 'flex';
    modal.classList.add('active');
    modal.setAttribute('aria-hidden', 'false');

    // Animaciones GSAP
    const tl = gsap.timeline();

    tl.fromTo(modal, {
        opacity: 0
    }, {
        opacity: 1,
        duration: 0.4,
        ease: "power2.out"
    }).fromTo(modalContent, {
        scale: 0.7,
        y: 100,
        opacity: 0,
        rotationX: -15
    }, {
        scale: 1,
        y: 0,
        opacity: 1,
        rotationX: 0,
        duration: 0.6,
        ease: "back.out(1.7)"
    }, "-=0.2").fromTo(modalContent.querySelectorAll('.form-group'), {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.4,
        stagger: 0.1,
        ease: "power2.out"
    }, "-=0.3").fromTo(modalContent.querySelector('.modern-btn'), {
        scale: 0.8,
        opacity: 0
    }, {
        scale: 1,
        opacity: 1,
        duration: 0.3,
        ease: "back.out(1.7)"
    }, "-=0.2");

    // Enfocar input
    setTimeout(() => {
        document.getElementById('nuevonombrebien').focus();
    }, 600);

    // Agregar escape para cerrar modal
    document.addEventListener('keydown', handleEscapeKeyAgregarNombreBien);
}

function handleEscapeKeyAgregarNombreBien(e) {
    if (e.key === 'Escape') {
        cerrarModalAgregarNombreBien();
        document.removeEventListener('keydown', handleEscapeKeyAgregarNombreBien);
    }
}

function cerrarModalAgregarNombreBien() {
    const modal = document.getElementById('modal-agregar-nombrebien');
    modal.classList.remove('active');
    modal.setAttribute('aria-hidden', 'true');

    gsap.to(modal, {
        opacity: 0,
        duration: 0.3,
        onComplete: () => {
            modal.style.display = 'none';
            document.getElementById("form-agregar-nombrebien").reset();
        }
    });

    document.removeEventListener('keydown', handleEscapeKeyAgregarNombreBien);
}



// Enviar datos al backend
document.getElementById("form-agregar-nombrebien").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("../LN/ln_agregar_nombrebien.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Registro exitoso");
                location.reload(); // recarga la tabla
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(err => {
            alert("Ocurrió un error");
            console.error(err);
        });
});







