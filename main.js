/**
 * Lavender Pharmacy – Main JavaScript
 * Handles: Cart AJAX, Form validation, Animations, UI interactions
 */

'use strict';

/* ============================================================
   Utility Functions
   ============================================================ */
const LP = {
  appUrl: document.querySelector('meta[name="app-url"]')?.content || '',

  /** Debounce */
  debounce(fn, delay = 300) {
    let t;
    return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), delay); };
  },

  /** AJAX helper */
  async ajax(url, method = 'GET', data = null) {
    const opts = {
      method,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
      }
    };
    if (data) {
      if (data instanceof FormData) {
        opts.body = data;
      } else {
        opts.headers['Content-Type'] = 'application/json';
        opts.body = JSON.stringify(data);
      }
    }
    const res = await fetch(url, opts);
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.json();
  },

  /** Show flash alert */
  flash(type, message, duration = 4000) {
    const container = document.getElementById('flash-container')
      || (() => {
        const c = document.createElement('div');
        c.id = 'flash-container';
        c.className = 'flash-container';
        document.body.appendChild(c);
        return c;
      })();

    const icons = {
      success: 'fa-circle-check',
      danger:  'fa-circle-xmark',
      warning: 'fa-triangle-exclamation',
      info:    'fa-circle-info',
    };

    const el = document.createElement('div');
    el.className = `alert alert-${type}`;
    el.innerHTML = `<i class="fas ${icons[type] || icons.info}"></i><span>${message}</span>`;
    container.appendChild(el);

    setTimeout(() => {
      el.style.opacity = '0';
      el.style.transform = 'translateX(30px)';
      el.style.transition = '0.3s ease';
      setTimeout(() => el.remove(), 300);
    }, duration);
  },

  /** Format currency */
  currency(amount) {
    return '₱' + parseFloat(amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }
};

/* ============================================================
   Navbar
   ============================================================ */
const navbar = document.querySelector('.lp-navbar');
if (navbar) {
  window.addEventListener('scroll', LP.debounce(() => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
  }, 50));
}

/* User Dropdown */
document.querySelectorAll('.user-dropdown').forEach(wrap => {
  const toggle = wrap.querySelector('.user-dropdown-toggle');
  const menu   = wrap.querySelector('.user-dropdown-menu');
  if (!toggle || !menu) return;

  toggle.addEventListener('click', e => {
    e.stopPropagation();
    menu.classList.toggle('show');
  });

  document.addEventListener('click', () => menu.classList.remove('show'));
});

/* Mobile Sidebar Toggle */
const sidebarToggle = document.getElementById('sidebar-toggle');
const sidebar       = document.querySelector('.lp-sidebar');
if (sidebarToggle && sidebar) {
  sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('open'));
}

/* ============================================================
   Password Toggle
   ============================================================ */
document.querySelectorAll('.toggle-password').forEach(btn => {
  btn.addEventListener('click', () => {
    const input = btn.closest('.input-password').querySelector('input');
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.querySelector('i').className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
  });
});

/* ============================================================
   Scroll Reveal
   ============================================================ */
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach((entry, i) => {
    if (entry.isIntersecting) {
      setTimeout(() => entry.target.classList.add('visible'), i * 80);
      revealObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

/* ============================================================
   Shopping Cart (AJAX)
   ============================================================ */
const Cart = {
  /** Update cart count badge */
  updateBadge(count) {
    document.querySelectorAll('.badge-count').forEach(b => {
      b.textContent = count;
      b.style.display = count > 0 ? 'flex' : 'none';
    });
  },

  /** Add to cart */
  async add(productId, qty = 1, btn = null) {
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner" style="width:18px;height:18px;border-width:2px;"></span>';
    }
    try {
      const data = await LP.ajax(`${LP.appUrl}/ajax/cart.php`, 'POST',
        { action: 'add', product_id: productId, quantity: qty });

      if (data.success) {
        this.updateBadge(data.cart_count);
        LP.flash('success', `<strong>${data.product_name}</strong> added to cart!`);
        if (btn) {
          btn.innerHTML = '<i class="fas fa-check"></i> Added!';
          setTimeout(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-cart-plus"></i> Add to Cart';
          }, 1500);
        }
      } else {
        LP.flash('danger', data.message || 'Could not add to cart.');
        if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fas fa-cart-plus"></i> Add to Cart'; }
      }
    } catch (e) {
      LP.flash('danger', 'Network error. Please try again.');
      if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fas fa-cart-plus"></i> Add to Cart'; }
    }
  },

  /** Remove from cart */
  async remove(productId, rowEl = null) {
    if (rowEl) rowEl.classList.add('removing');
    try {
      const data = await LP.ajax(`${LP.appUrl}/ajax/cart.php`, 'POST',
        { action: 'remove', product_id: productId });

      if (data.success) {
        this.updateBadge(data.cart_count);
        if (rowEl) setTimeout(() => rowEl.remove(), 300);
        this.refreshSummary(data.subtotal, data.cart_count);
        LP.flash('info', 'Item removed from cart.');
      } else {
        LP.flash('danger', data.message || 'Error removing item.');
        if (rowEl) rowEl.classList.remove('removing');
      }
    } catch (e) {
      LP.flash('danger', 'Network error.');
      if (rowEl) rowEl.classList.remove('removing');
    }
  },

  /** Update quantity */
  async updateQty(productId, qty, subtotalEl = null) {
    try {
      const data = await LP.ajax(`${LP.appUrl}/ajax/cart.php`, 'POST',
        { action: 'update', product_id: productId, quantity: qty });

      if (data.success) {
        this.updateBadge(data.cart_count);
        if (subtotalEl) subtotalEl.textContent = LP.currency(data.item_subtotal);
        this.refreshSummary(data.cart_total, data.cart_count);
      } else {
        LP.flash('warning', data.message || 'Could not update quantity.');
      }
    } catch (e) {
      LP.flash('danger', 'Network error.');
    }
  },

  /** Refresh summary totals */
  refreshSummary(total, count) {
    const totEl = document.getElementById('cart-total');
    const cntEl = document.getElementById('cart-item-count');
    const vatEl = document.getElementById('cart-vat');
    if (totEl) totEl.textContent = LP.currency(total);
    if (cntEl) cntEl.textContent = count;
    if (vatEl) {
      const vat = total * 0.12 / 1.12;
      vatEl.textContent = LP.currency(vat);
    }

    // Show empty state
    if (count === 0) {
      const emptyEl = document.getElementById('cart-empty');
      const cartItems = document.getElementById('cart-items');
      if (emptyEl) emptyEl.style.display = 'block';
      if (cartItems) cartItems.style.display = 'none';
    }
  }
};

/* Attach cart add buttons */
document.querySelectorAll('.btn-add-cart').forEach(btn => {
  btn.addEventListener('click', () => {
    const productId = btn.dataset.productId;
    const qty       = parseInt(document.getElementById(`qty-${productId}`)?.value || 1);
    if (!productId) return;
    Cart.add(parseInt(productId), qty, btn);
  });
});

/* Attach remove buttons */
document.querySelectorAll('.btn-remove-cart').forEach(btn => {
  btn.addEventListener('click', () => {
    const productId = parseInt(btn.dataset.productId);
    const row       = btn.closest('.cart-item');
    if (productId) Cart.remove(productId, row);
  });
});

/* Qty controls on cart page */
document.querySelectorAll('.qty-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const productId = parseInt(btn.dataset.productId);
    const input     = btn.closest('.qty-control').querySelector('.qty-input');
    if (!input) return;

    let val = parseInt(input.value) + (btn.dataset.action === 'inc' ? 1 : -1);
    const max = parseInt(input.dataset.max || 999);
    val = Math.max(1, Math.min(val, max));
    input.value = val;

    const subtotalEl = document.getElementById(`subtotal-${productId}`);
    Cart.updateQty(productId, val, subtotalEl);
  });
});

/* Qty input direct change */
document.querySelectorAll('.qty-input').forEach(input => {
  input.addEventListener('change', LP.debounce(() => {
    const productId = parseInt(input.dataset.productId);
    const max       = parseInt(input.dataset.max || 999);
    let val = parseInt(input.value);
    if (isNaN(val) || val < 1) val = 1;
    if (val > max) val = max;
    input.value = val;

    const subtotalEl = document.getElementById(`subtotal-${productId}`);
    Cart.updateQty(productId, val, subtotalEl);
  }, 400));
});

/* ============================================================
   Form Validation
   ============================================================ */
const Validator = {
  rules: {
    required:  v => v.trim().length > 0,
    email:     v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v),
    minLength: (v, n) => v.length >= n,
    maxLength: (v, n) => v.length <= n,
    numeric:   v => !isNaN(parseFloat(v)) && isFinite(v),
    positive:  v => parseFloat(v) > 0,
    phone:     v => /^(09|\+639)[0-9]{9}$/.test(v.replace(/\s/g, '')),
    password:  v => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(v),
  },

  showError(input, message) {
    input.classList.add('is-invalid');
    input.classList.remove('is-valid');
    let err = input.parentElement.querySelector('.form-error');
    if (!err) {
      err = document.createElement('div');
      err.className = 'form-error';
      input.parentElement.appendChild(err);
    }
    err.innerHTML = `<i class="fas fa-circle-exclamation"></i> ${message}`;
  },

  showSuccess(input) {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    const err = input.parentElement.querySelector('.form-error');
    if (err) err.remove();
  },

  clearError(input) {
    input.classList.remove('is-invalid', 'is-valid');
    const err = input.parentElement.querySelector('.form-error');
    if (err) err.remove();
  },

  validateField(input) {
    const rules  = input.dataset.validate?.split('|') || [];
    const label  = input.dataset.label || input.placeholder || 'Field';
    const value  = input.value;
    let valid    = true;

    for (const rule of rules) {
      const [name, param] = rule.split(':');
      switch (name) {
        case 'required':
          if (!this.rules.required(value)) {
            this.showError(input, `${label} is required.`);
            valid = false;
          }
          break;
        case 'email':
          if (value && !this.rules.email(value)) {
            this.showError(input, 'Enter a valid email address.');
            valid = false;
          }
          break;
        case 'min':
          if (!this.rules.minLength(value, parseInt(param))) {
            this.showError(input, `${label} must be at least ${param} characters.`);
            valid = false;
          }
          break;
        case 'numeric':
          if (value && !this.rules.numeric(value)) {
            this.showError(input, `${label} must be a number.`);
            valid = false;
          }
          break;
        case 'positive':
          if (value && !this.rules.positive(value)) {
            this.showError(input, `${label} must be greater than 0.`);
            valid = false;
          }
          break;
        case 'phone':
          if (value && !this.rules.phone(value)) {
            this.showError(input, 'Enter a valid Philippine phone number (09XXXXXXXXX).');
            valid = false;
          }
          break;
        case 'password':
          if (!this.rules.password(value)) {
            this.showError(input, 'Password must be 8+ chars with uppercase, lowercase, and number.');
            valid = false;
          }
          break;
        case 'match':
          const matchEl = document.getElementById(param);
          if (matchEl && value !== matchEl.value) {
            this.showError(input, 'Passwords do not match.');
            valid = false;
          }
          break;
      }
      if (!valid) break;
    }
    if (valid && value) this.showSuccess(input);
    return valid;
  },

  validateForm(form) {
    let allValid = true;
    form.querySelectorAll('[data-validate]').forEach(input => {
      if (!this.validateField(input)) allValid = false;
    });
    return allValid;
  }
};

/* Attach real-time validation */
document.querySelectorAll('[data-validate]').forEach(input => {
  input.addEventListener('blur', () => Validator.validateField(input));
  input.addEventListener('input', LP.debounce(() => {
    if (input.classList.contains('is-invalid')) Validator.validateField(input);
  }, 300));
});

/* Validate on submit */
document.querySelectorAll('form[data-validate-form]').forEach(form => {
  form.addEventListener('submit', e => {
    if (!Validator.validateForm(form)) {
      e.preventDefault();
      LP.flash('danger', 'Please fix the errors in the form.');
      form.querySelector('.is-invalid')?.focus();
    }
  });
});

/* ============================================================
   Checkout – Payment Method Toggle
   ============================================================ */
const paymentMethods = document.querySelectorAll('.payment-method-option');
const cashTenderSection = document.getElementById('cash-tender-section');

paymentMethods.forEach(option => {
  option.addEventListener('click', () => {
    paymentMethods.forEach(o => o.classList.remove('selected'));
    option.classList.add('selected');
    option.querySelector('input[type="radio"]').checked = true;

    const method = option.dataset.method;
    if (cashTenderSection) {
      cashTenderSection.style.display = method === 'cash' ? 'block' : 'none';
    }
  });
});

/* Cash tender – compute change */
const cashTenderInput = document.getElementById('cash_tendered');
const changeDisplay   = document.getElementById('change-display');
const orderTotalEl    = document.getElementById('order-total-value');

if (cashTenderInput && changeDisplay && orderTotalEl) {
  cashTenderInput.addEventListener('input', () => {
    const total   = parseFloat(orderTotalEl.dataset.total || 0);
    const tendered = parseFloat(cashTenderInput.value || 0);
    const change  = Math.max(0, tendered - total);
    changeDisplay.textContent = LP.currency(change);
    changeDisplay.style.color = tendered >= total ? 'var(--success)' : 'var(--danger)';
  });
}

/* ============================================================
   Admin: Product Image Preview
   ============================================================ */
const productImageInput = document.getElementById('product_image_file');
const productImagePreview = document.getElementById('product-image-preview');

if (productImageInput && productImagePreview) {
  productImageInput.addEventListener('change', () => {
    const file = productImageInput.files[0];
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = e => {
        productImagePreview.src = e.target.result;
        productImagePreview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    }
  });
}

/* ============================================================
   Admin: Confirm Delete
   ============================================================ */
document.querySelectorAll('[data-confirm]').forEach(btn => {
  btn.addEventListener('click', e => {
    const msg = btn.dataset.confirm || 'Are you sure you want to delete this?';
    if (typeof Swal !== 'undefined') {
      e.preventDefault();
      Swal.fire({
        title: 'Confirm Action',
        text: msg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B57EDC',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Yes, proceed',
      }).then(result => {
        if (result.isConfirmed) {
          // For links, navigate; for forms, submit
          if (btn.tagName === 'A') window.location.href = btn.href;
          else if (btn.type === 'submit') btn.closest('form').submit();
        }
      });
    } else {
      if (!confirm(msg)) e.preventDefault();
    }
  });
});

/* ============================================================
   Charts (Chart.js) – Dashboard
   ============================================================ */
function initRevenueChart(labels, data) {
  const ctx = document.getElementById('revenueChart');
  if (!ctx || typeof Chart === 'undefined') return;

  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Revenue (₱)',
        data,
        borderColor: '#B57EDC',
        backgroundColor: 'rgba(181,126,220,0.08)',
        borderWidth: 2.5,
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#B57EDC',
        pointRadius: 4,
        pointHoverRadius: 6,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: ctx => ' ₱' + parseFloat(ctx.raw).toLocaleString('en-PH', { minimumFractionDigits: 2 })
          }
        }
      },
      scales: {
        x: { grid: { color: 'rgba(0,0,0,0.04)' } },
        y: {
          grid: { color: 'rgba(0,0,0,0.04)' },
          ticks: {
            callback: v => '₱' + v.toLocaleString()
          }
        }
      }
    }
  });
}

function initSalesByCategory(labels, data) {
  const ctx = document.getElementById('categoryChart');
  if (!ctx || typeof Chart === 'undefined') return;

  const colors = ['#B57EDC','#C8A2C8','#8A5BA8','#5D3A66','#E6E6FA','#DDA0DD','#9370DB','#7B52A8'];

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels,
      datasets: [{ data, backgroundColor: colors, borderWidth: 0 }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'right' }
      },
      cutout: '65%',
    }
  });
}

/* ============================================================
   Animated Counter (for stat cards)
   ============================================================ */
function animateCounter(el, target, prefix = '', suffix = '', duration = 1200) {
  const start     = 0;
  const startTime = performance.now();

  function update(currentTime) {
    const elapsed  = currentTime - startTime;
    const progress = Math.min(elapsed / duration, 1);
    const ease     = 1 - Math.pow(1 - progress, 3);
    const value    = Math.round(start + (target - start) * ease);
    el.textContent = prefix + value.toLocaleString() + suffix;
    if (progress < 1) requestAnimationFrame(update);
  }

  requestAnimationFrame(update);
}

document.querySelectorAll('[data-counter]').forEach(el => {
  const target = parseFloat(el.dataset.counter);
  const prefix = el.dataset.prefix || '';
  const suffix = el.dataset.suffix || '';

  const obs = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(el, target, prefix, suffix);
        obs.unobserve(el);
      }
    });
  }, { threshold: 0.5 });

  obs.observe(el);
});

/* ============================================================
   SweetAlert2 Wrappers
   ============================================================ */
window.LPAlert = {
  success(msg, title = 'Success!') {
    if (typeof Swal === 'undefined') return LP.flash('success', msg);
    return Swal.fire({ title, text: msg, icon: 'success', confirmButtonColor: '#B57EDC', timer: 2500, timerProgressBar: true });
  },
  error(msg, title = 'Error') {
    if (typeof Swal === 'undefined') return LP.flash('danger', msg);
    return Swal.fire({ title, text: msg, icon: 'error', confirmButtonColor: '#B57EDC' });
  },
  confirm(msg, title = 'Are you sure?') {
    if (typeof Swal === 'undefined') return Promise.resolve({ isConfirmed: confirm(msg) });
    return Swal.fire({
      title, text: msg, icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#B57EDC',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Yes, confirm',
    });
  }
};

/* ============================================================
   Auto-dismiss alerts after 5 seconds
   ============================================================ */
document.querySelectorAll('.alert[data-auto-dismiss]').forEach(alert => {
  setTimeout(() => {
    alert.style.opacity = '0';
    alert.style.transition = '0.3s ease';
    setTimeout(() => alert.remove(), 300);
  }, 5000);
});

/* ============================================================
   Product Search (Live)
   ============================================================ */
const liveSearch = document.getElementById('live-search');
if (liveSearch) {
  liveSearch.addEventListener('input', LP.debounce(() => {
    const q = liveSearch.value.trim();
    const url = new URL(window.location.href);
    if (q) url.searchParams.set('search', q); else url.searchParams.delete('search');
    url.searchParams.delete('page');
    window.location.href = url.toString();
  }, 600));
}

/* ============================================================
   Print Receipt
   ============================================================ */
window.printReceipt = function() {
  window.print();
};

/* ============================================================
   Modal Handler
   ============================================================ */
document.querySelectorAll('[data-modal]').forEach(trigger => {
  trigger.addEventListener('click', () => {
    const modal = document.getElementById(trigger.dataset.modal);
    if (modal) modal.classList.add('show');
  });
});

document.querySelectorAll('.modal-close, .lp-modal-overlay').forEach(el => {
  el.addEventListener('click', e => {
    if (e.target === el) {
      document.querySelectorAll('.lp-modal-overlay.show').forEach(m => m.classList.remove('show'));
    }
  });
});

// Keyboard close
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    document.querySelectorAll('.lp-modal-overlay.show').forEach(m => m.classList.remove('show'));
    document.querySelectorAll('.user-dropdown-menu.show').forEach(m => m.classList.remove('show'));
  }
});

console.log('%cLavender Pharmacy 💜', 'color:#B57EDC;font-size:18px;font-weight:bold;');