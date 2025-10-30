/**
 * Optimalizált kontakt form kezelő - teljesítmény orientált
 * F1 Projekt - Kapcsolat oldal
 */

class ContactFormOptimizer {
    constructor() {
        this.form = document.getElementById('contactForm');
        this.submitBtn = document.getElementById('submitBtn');
        this.debounceDelay = 150; // ms
        this.validationTimeouts = new Map();
        
        this.init();
    }

    init() {
        if (!this.form) return;
        
        // Gyors esemény kezelők hozzáadása
        this.attachEventListeners();
        
        // Előtöltött validáció
        this.preloadValidation();
        
        // GPU gyorsítás aktiválása
        this.enableHardwareAcceleration();
    }

    attachEventListeners() {
        // Gyorsított input kezelés
        const inputs = this.form.querySelectorAll('input, textarea');
        
        inputs.forEach(input => {
            // Passive event listeners a jobb teljesítményért
            input.addEventListener('input', this.debounce(
                this.validateField.bind(this, input)
            ), { passive: true });
            
            input.addEventListener('blur', () => {
                this.validateField(input);
            }, { passive: true });
        });

        // Form submit optimalizálás
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
    }

    debounce(func, delay = this.debounceDelay) {
        return (...args) => {
            const key = args[0]?.name || 'default';
            
            clearTimeout(this.validationTimeouts.get(key));
            this.validationTimeouts.set(key, setTimeout(() => {
                func.apply(this, args);
            }, delay));
        };
    }

    validateField(field) {
        // Gyors validációs szabályok
        const rules = {
            name: (val) => val.length >= 2 && val.length <= 100 && /^[a-zA-ZÀ-ÿ\s]+$/.test(val),
            email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) && val.length <= 150,
            subject: (val) => val.length >= 5 && val.length <= 200,
            message: (val) => val.length >= 10 && val.length <= 2000
        };

        const value = field.value.trim();
        const isValid = rules[field.name] ? rules[field.name](value) : true;

        // GPU gyorsított CSS osztály váltás
        this.toggleValidationClass(field, isValid);
        
        return isValid;
    }

    toggleValidationClass(field, isValid) {
        // Használjuk a classList.toggle-t a jobb teljesítményért
        field.classList.toggle('is-valid', isValid && field.value.trim() !== '');
        field.classList.toggle('is-invalid', !isValid && field.value.trim() !== '');
    }

    handleSubmit(e) {
        // Gyors teljes validáció
        const inputs = this.form.querySelectorAll('input[required], textarea[required]');
        let isFormValid = true;

        // Batch DOM updates
        const updates = [];
        
        inputs.forEach(input => {
            const isValid = this.validateField(input);
            if (!isValid) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            e.preventDefault();
            
            // Smooth scroll az első hibás mezőhöz
            const firstInvalid = this.form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
                firstInvalid.focus();
            }
            return false;
        }

        // Loading állapot aktiválása
        this.setLoadingState(true);
    }

    setLoadingState(loading) {
        if (!this.submitBtn) return;
        
        if (loading) {
            this.submitBtn.disabled = true;
            this.submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Küldés...';
        } else {
            this.submitBtn.disabled = false;
            this.submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Üzenet küldése';
        }
    }

    enableHardwareAcceleration() {
        // GPU réteg létrehozása a form elemekhez
        const animatedElements = this.form.querySelectorAll(
            'input, textarea, button, .form-group'
        );
        
        animatedElements.forEach(el => {
            el.style.transform = 'translateZ(0)';
            el.style.willChange = 'transform, opacity';
        });
    }

    preloadValidation() {
        // Előtöltjük a validációs szabályokat a gyorsabb futásért
        const cache = new Map();
        cache.set('emailRegex', /^[^\s@]+@[^\s@]+\.[^\s@]+$/);
        cache.set('nameRegex', /^[a-zA-ZÀ-ÿ\s]+$/);
        
        this.validationCache = cache;
    }

    // Karakterszámláló optimalizálás
    updateCharacterCount(input, maxLength) {
        const counter = document.querySelector(`[data-counter="${input.name}"]`);
        if (!counter) return;

        const remaining = maxLength - input.value.length;
        
        // Batch DOM update
        requestAnimationFrame(() => {
            counter.textContent = `${remaining} karakter maradt`;
            counter.className = remaining < 50 ? 'text-warning' : 'text-muted';
        });
    }
}

// Csak akkor inicializáljuk, ha a DOM betöltött
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new ContactFormOptimizer();
    });
} else {
    new ContactFormOptimizer();
}

// Egyéb teljesítmény optimalizálások
document.addEventListener('DOMContentLoaded', function() {
    // Preload kritikus CSS
    const link = document.createElement('link');
    link.rel = 'preload';
    link.href = '/css/f1-styles.css';
    link.as = 'style';
    document.head.appendChild(link);
    
    // Lazy loading képekhez (ha vannak)
    if ('IntersectionObserver' in window) {
        const images = document.querySelectorAll('img[data-lazy]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.lazy;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
});