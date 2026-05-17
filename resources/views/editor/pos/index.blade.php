@extends('layouts.editor')

@section('title', 'Point of Sale - Editor')

@section('content')
<style>
    .dashboard-main { width: 100%; min-height: 100vh; background: #F7F3FC; }
    .dashboard-container { padding: 32px 40px; max-width: 1400px; margin: 0 auto; }
    @media (max-width: 768px) { .dashboard-container { padding: 24px 16px; } }

    /* ── Header ── */
    .dashboard-header {
        margin-bottom: 28px;
        background: linear-gradient(135deg, #5D3A66 0%, #8B4DAB 60%, #B57EDC 100%);
        padding: 28px 32px;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(93, 58, 102, 0.25);
        color: white;
        position: relative;
        overflow: hidden;
    }
    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }
    .dashboard-header h1 { font-size: 1.9rem; font-weight: 700; margin-bottom: 6px; color: white; }
    .dashboard-header p { color: rgba(255,255,255,0.75); font-size: 0.9rem; margin: 0; }
    .dashboard-header i.header-icon { margin-right: 10px; opacity: 0.85; }

    /* ── Layout ── */
    .pos-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 992px) {
        .pos-layout { grid-template-columns: 1fr; }
    }

    /* ── Card shell ── */
    .card-modern {
        background: white;
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(93, 58, 102, 0.07);
        overflow: hidden;
    }
    .card-modern-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        border-bottom: 1px solid #F0E8FA;
    }
    .card-modern-header-left { display: flex; align-items: center; gap: 12px; }
    .card-modern-header-icon {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, #8B4DAB, #C8A2C8);
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .card-modern-header-icon i { color: white; font-size: 0.9rem; }
    .card-modern-header h5 { font-size: 1rem; font-weight: 700; color: #3D2549; margin: 0; }
    .card-modern-footer {
        padding: 14px 24px;
        border-top: 1px solid #F0E8FA;
        background: #FDFAFF;
    }

    /* ── Search ── */
    .search-wrap { padding: 18px 24px; border-bottom: 1px solid #F0E8FA; }
    .search-inner {
        display: flex;
        gap: 8px;
        background: #F7F3FC;
        border: 1.5px solid #E0C8F5;
        border-radius: 10px;
        padding: 6px 10px;
        align-items: center;
    }
    .search-inner i { color: #B57EDC; font-size: 0.85rem; flex-shrink: 0; }
    .search-inner input {
        flex: 1;
        border: none;
        background: transparent;
        outline: none;
        font-size: 0.875rem;
        color: #3D2549;
    }
    .search-inner input::placeholder { color: #C0A8D8; }

    /* ── Product grid ── */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 14px;
        padding: 20px 24px;
    }

    .product-card {
        border: 1.5px solid #EDE0FA;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s ease;
        background: white;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        border-color: #B57EDC;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(139, 77, 171, 0.18);
    }
    .product-card:active { transform: translateY(0); }

    .product-img {
        height: 90px;
        background: linear-gradient(135deg, #F5EEFF 0%, #EDE0FA 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-img i { font-size: 1.8rem; color: #C8A2C8; }

    .product-body { padding: 10px 12px; flex: 1; display: flex; flex-direction: column; }
    .product-name { font-size: 0.82rem; font-weight: 700; color: #3D2549; margin-bottom: 2px; line-height: 1.3; }
    .product-generic { font-size: 0.72rem; color: #A08AB0; margin-bottom: 4px; line-height: 1.3; }
    .product-category { font-size: 0.7rem; color: #C0A8D8; margin-bottom: 8px; }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }
    .product-price { font-size: 0.95rem; font-weight: 800; color: #7A4DAB; }
    .stock-chip {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 3px 7px;
        border-radius: 20px;
    }
    .stock-chip.ok { background: #ECFDF5; color: #059669; }
    .stock-chip.low { background: #FEF2F2; color: #DC2626; }

    /* ── Empty product state ── */
    .products-empty {
        grid-column: 1 / -1;
        padding: 48px 24px;
        text-align: center;
        color: #B0A0BC;
    }
    .products-empty i { font-size: 2.5rem; margin-bottom: 12px; opacity: 0.35; display: block; }

    /* ── Cart panel ── */
    .cart-panel {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(93, 58, 102, 0.07);
        overflow: hidden;
        position: sticky;
        top: 24px;
        display: flex;
        flex-direction: column;
    }
    .cart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid #F0E8FA;
        background: #FDFAFF;
    }
    .cart-header-left { display: flex; align-items: center; gap: 10px; }
    .cart-header-icon {
        width: 34px; height: 34px;
        background: linear-gradient(135deg, #5D3A66, #8B4DAB);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
    }
    .cart-header-icon i { color: white; font-size: 0.85rem; }
    .cart-header h5 { font-size: 0.95rem; font-weight: 700; color: #3D2549; margin: 0; }
    .cart-count-badge {
        background: linear-gradient(135deg, #8B4DAB, #B57EDC);
        color: white;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 20px;
        min-width: 24px;
        text-align: center;
    }

    .cart-items { max-height: 320px; overflow-y: auto; padding: 16px 20px; }
    .cart-items::-webkit-scrollbar { width: 4px; }
    .cart-items::-webkit-scrollbar-thumb { background: #D4B5D4; border-radius: 2px; }

    .cart-empty { text-align: center; padding: 32px 16px; color: #C0A8D8; }
    .cart-empty i { font-size: 2rem; opacity: 0.35; display: block; margin-bottom: 8px; }
    .cart-empty p { font-size: 0.82rem; }

    .cart-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding-bottom: 12px;
        margin-bottom: 12px;
        border-bottom: 1px solid #F0E8FA;
    }
    .cart-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .cart-item-info { flex: 1; min-width: 0; }
    .cart-item-name { font-size: 0.82rem; font-weight: 600; color: #3D2549; line-height: 1.3; margin-bottom: 2px; }
    .cart-item-price { font-size: 0.75rem; color: #9B7BAB; }
    .cart-item-controls { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
    .qty-input {
        width: 44px;
        padding: 4px 6px;
        border: 1.5px solid #E0C8F5;
        border-radius: 6px;
        font-size: 0.8rem;
        text-align: center;
        color: #3D2549;
        background: white;
        outline: none;
    }
    .qty-input:focus { border-color: #B57EDC; }
    .btn-remove {
        width: 26px; height: 26px;
        border: none;
        background: #FEF2F2;
        color: #DC2626;
        border-radius: 6px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.72rem;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .btn-remove:hover { background: #DC2626; color: white; }

    /* ── Totals ── */
    .cart-totals {
        padding: 14px 20px;
        border-top: 1px solid #F0E8FA;
        background: #FDFAFF;
    }
    .totals-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.82rem;
        color: #9B7BAB;
        margin-bottom: 6px;
    }
    .totals-row span:last-child { font-weight: 600; color: #5D3A66; }
    .totals-grand {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 10px;
        border-top: 1.5px solid #E0C8F5;
        margin-top: 6px;
    }
    .totals-grand span:first-child { font-size: 0.85rem; font-weight: 700; color: #3D2549; }
    .totals-grand span:last-child { font-size: 1.2rem; font-weight: 800; color: #7A4DAB; }

    /* ── Cart actions ── */
    .cart-actions { padding: 14px 20px; display: flex; flex-direction: column; gap: 8px; border-top: 1px solid #F0E8FA; }

    .btn-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 16px;
        border-radius: 9px;
        border: none;
        background: linear-gradient(135deg, #8B4DAB, #B57EDC);
        color: white;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 3px 10px rgba(139, 77, 171, 0.3);
    }
    .btn-checkout:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(139, 77, 171, 0.4);
    }
    .btn-checkout:disabled { opacity: 0.45; cursor: not-allowed; box-shadow: none; transform: none; }

    .btn-clear {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 9px;
        border: 1.5px solid #E0C8F5;
        background: white;
        color: #9B7BAB;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-clear:hover:not(:disabled) { background: #F5EEFF; border-color: #C8A2C8; color: #5D3A66; }
    .btn-clear:disabled { opacity: 0.4; cursor: not-allowed; }
</style>

<div class="dashboard-main">
    <div class="dashboard-container">

        <!-- Header -->
        <div class="dashboard-header">
            <h1><i class="fas fa-cash-register header-icon"></i>Point of Sale</h1>
            <p>In-store checkout — press <strong style="color:white;">Ctrl+O</strong> to complete order, <strong style="color:white;">Esc</strong> to clear search</p>
        </div>

        <div class="pos-layout">

            <!-- Left: Products -->
            <div>
                <div class="card-modern">
                    <div class="card-modern-header">
                        <div class="card-modern-header-left">
                            <div class="card-modern-header-icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <h5>Products</h5>
                            <span style="background:#F0E8FA;color:#7A4F85;font-size:0.72rem;font-weight:700;padding:3px 9px;border-radius:20px;">
                                {{ $products->count() }} items
                            </span>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="search-wrap">
                        <div class="search-inner">
                            <i class="fas fa-search"></i>
                            <input
                                type="text"
                                id="productSearch"
                                placeholder="Search by name, generic name, category, or barcode…"
                            >
                        </div>
                    </div>

                    <!-- Grid -->
                    <div class="products-grid" id="productsGrid">
                        @forelse($products as $product)
                            <div class="product-card"
                                 data-barcode="{{ $product->barcode ?? '' }}"
                                 data-product-name="{{ strtolower($product->product_name) }}"
                                 data-generic-name="{{ strtolower($product->generic_name ?? '') }}"
                                 data-category="{{ strtolower($product->category->category_name ?? '') }}"
                                 onclick="addToCart({{ $product->product_id }}, '{{ addslashes($product->product_name) }}', {{ $product->price }})">
                                <div class="product-img">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <div class="product-body">
                                    <div class="product-name">{{ $product->product_name }}</div>
                                    @if($product->generic_name)
                                        <div class="product-generic">{{ $product->generic_name }}</div>
                                    @endif
                                    <div class="product-category">{{ $product->category->category_name ?? 'Uncategorized' }}</div>
                                    <div class="product-footer">
                                        <span class="product-price">₱{{ number_format($product->price, 2) }}</span>
                                        <span class="stock-chip {{ $product->stock_quantity < 10 ? 'low' : 'ok' }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="products-empty">
                                <i class="fas fa-inbox"></i>
                                <p>No products available</p>
                                <p style="font-size:0.78rem;margin-top:4px;opacity:0.7;">Add products to inventory to start selling</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right: Cart -->
            <div>
                <div class="cart-panel">
                    <div class="cart-header">
                        <div class="cart-header-left">
                            <div class="cart-header-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h5>Cart</h5>
                        </div>
                        <span class="cart-count-badge" id="cartCount">0</span>
                    </div>

                    <div class="cart-items" id="cartItemsContainer">
                        <div class="cart-empty">
                            <i class="fas fa-cart-shopping"></i>
                            <p>Cart is empty</p>
                        </div>
                    </div>

                    <div class="cart-totals">
                        <div class="totals-row">
                            <span>Subtotal</span>
                            <span id="subtotal">₱0.00</span>
                        </div>
                        <div class="totals-row">
                            <span>Tax (12%)</span>
                            <span id="tax">₱0.00</span>
                        </div>
                        <div class="totals-grand">
                            <span>Total</span>
                            <span id="total">₱0.00</span>
                        </div>
                    </div>

                    <div class="cart-actions">
                        <button id="checkoutBtn" class="btn-checkout" disabled onclick="checkout()">
                            <i class="fas fa-credit-card"></i> Checkout
                        </button>
                        <button id="clearBtn" class="btn-clear" disabled onclick="clearCart()">
                            <i class="fas fa-redo"></i> Clear Cart
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const products = @json($products);
let cart = {};

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('productSearch').addEventListener('keyup', searchProducts);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('productSearch').value = '';
            searchProducts();
        }
        if (e.ctrlKey && e.key === 'o') {
            e.preventDefault();
            if (Object.keys(cart).length > 0) checkout();
        }
    });
});

function addToCart(productId, productName, price) {
    if (cart[productId]) {
        cart[productId].quantity++;
    } else {
        cart[productId] = { id: productId, name: productName, price: parseFloat(price), quantity: 1 };
    }
    updateCart();
}

function removeFromCart(productId) {
    delete cart[productId];
    updateCart();
}

function updateQuantity(productId, quantity) {
    quantity = parseInt(quantity);
    if (quantity <= 0) { removeFromCart(productId); } else { cart[productId].quantity = quantity; updateCart(); }
}

function updateCart() {
    const container = document.getElementById('cartItemsContainer');
    const cartCount = document.getElementById('cartCount');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const clearBtn = document.getElementById('clearBtn');

    if (Object.keys(cart).length === 0) {
        container.innerHTML = '<div class="cart-empty"><i class="fas fa-cart-shopping"></i><p>Cart is empty</p></div>';
        cartCount.textContent = '0';
        checkoutBtn.disabled = true;
        clearBtn.disabled = true;
        document.getElementById('subtotal').textContent = '₱0.00';
        document.getElementById('tax').textContent = '₱0.00';
        document.getElementById('total').textContent = '₱0.00';
        return;
    }

    let html = '';
    let totalItems = 0;

    Object.values(cart).forEach(item => {
        totalItems += item.quantity;
        html += `
            <div class="cart-item">
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">₱${item.price.toFixed(2)} each</div>
                </div>
                <div class="cart-item-controls">
                    <input type="number" value="${item.quantity}" min="1" max="999"
                           onchange="updateQuantity(${item.id}, this.value)" class="qty-input">
                    <button onclick="removeFromCart(${item.id})" class="btn-remove">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>`;
    });

    container.innerHTML = html;
    cartCount.textContent = totalItems;
    checkoutBtn.disabled = false;
    clearBtn.disabled = false;
    calculateTotals();
}

function calculateTotals() {
    let subtotal = 0;
    Object.values(cart).forEach(item => { subtotal += item.price * item.quantity; });
    const tax = subtotal * 0.12;
    const total = subtotal + tax;
    document.getElementById('subtotal').textContent = '₱' + subtotal.toFixed(2);
    document.getElementById('tax').textContent = '₱' + tax.toFixed(2);
    document.getElementById('total').textContent = '₱' + total.toFixed(2);
}

function searchProducts() {
    const query = document.getElementById('productSearch').value.toLowerCase().trim();
    document.querySelectorAll('#productsGrid .product-card').forEach(item => {
        const matches = query === '' ||
            (item.dataset.barcode || '').includes(query) ||
            (item.dataset.productName || '').includes(query) ||
            (item.dataset.genericName || '').includes(query) ||
            (item.dataset.category || '').includes(query);
        item.style.display = matches ? '' : 'none';
    });
}

function clearCart() {
    if (confirm('Are you sure you want to clear the cart?')) { cart = {}; updateCart(); }
}

function checkout() {
    if (Object.keys(cart).length === 0) { alert('Cart is empty'); return; }

    let subtotal = 0;
    const items = [];
    Object.values(cart).forEach(item => {
        subtotal += item.price * item.quantity;
        items.push({ id: item.id, quantity: item.quantity, price: item.price });
    });
    const tax = subtotal * 0.12;
    const total = subtotal + tax;

    let itemsList = '';
    Object.values(cart).forEach(item => {
        itemsList += `${item.name} x${item.quantity} = ₱${(item.price * item.quantity).toFixed(2)}\n`;
    });

    if (confirm(`ORDER SUMMARY\n\n${itemsList}\nSubtotal: ₱${subtotal.toFixed(2)}\nTax (12%): ₱${tax.toFixed(2)}\n\nGRAND TOTAL: ₱${total.toFixed(2)}\n\nProceed with checkout?`)) {
        fetch('{{ route("editor.pos.checkout") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}' },
            body: JSON.stringify({ items, subtotal, tax, total })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alert(`✓ Order #${data.order_id} completed!\nReceipt ID: ${data.receipt_id}`);
                cart = {};
                updateCart();
                document.getElementById('productSearch').value = '';
                searchProducts();
            } else {
                alert('Error: ' + (data.message || 'Checkout failed'));
            }
        })
        .catch(() => alert('Error processing checkout. Please try again.'));
    }
}
</script>
@endpush