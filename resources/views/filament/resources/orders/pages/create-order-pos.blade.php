<x-filament-panels::page>
    <style>
        .pos-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 1024px) {
            .pos-container {
                grid-template-columns: 2fr 1fr;
            }
        }

        .pos-card {
            background: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            color: #111827;
        }

        .search-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        @media (min-width: 768px) {
            .search-section {
                flex-direction: row;
            }
        }

        .search-input,
        .category-select {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            background: #ffffff;
            color: #111827;
        }

        .search-input:focus,
        .category-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1280px) {
            .products-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .product-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 0.5rem;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            color: white;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .product-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-category {
            font-size: 0.75rem;
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }

        .product-price {
            font-size: 1.125rem;
            font-weight: 700;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 1rem;
        }

        .cart-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
        }

        .clear-btn {
            font-size: 0.875rem;
            color: #ef4444;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
        }

        .clear-btn:hover {
            color: #dc2626;
        }

        .cart-items {
            max-height: 400px;
            overflow-y: auto;
        }

        .cart-item {
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .item-info {
            flex: 1;
            padding-right: 0.5rem;
        }

        .item-name {
            font-weight: 500;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .item-price {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .remove-btn {
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            padding: 0;
            width: 1.25rem;
            height: 1.25rem;
        }

        .remove-btn:hover {
            color: #dc2626;
        }

        .quantity-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qty-buttons {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .qty-btn {
            width: 2rem;
            height: 2rem;
            border-radius: 0.25rem;
            background: #f3f4f6;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            background: #e5e7eb;
        }

        .qty-input {
            width: 4rem;
            text-align: center;
            padding: 0.25rem;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
        }

        .item-subtotal {
            font-weight: 600;
            color: #111827;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .empty-icon {
            width: 3rem;
            height: 3rem;
            margin: 0 auto 1rem;
            stroke: currentColor;
        }

        .cart-footer {
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .total-label {
            color: #6b7280;
        }

        .total-amount {
            font-weight: 600;
            color: #111827;
        }

        .grand-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .grand-total-label {
            font-weight: 700;
            color: #111827;
        }

        .grand-total-amount {
            font-weight: 700;
            color: #3b82f6;
        }

        .checkout-btn {
            width: 100%;
            background: #3b82f6;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }

        .checkout-btn:hover {
            background: #2563eb;
        }

        .no-products {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }
    </style>

    <div class="pos-container">
        <!-- Left Side - Products Grid -->
        <div>
            <!-- Search & Filter -->
            <div class="pos-card search-section">
                <input
                    type="text"
                    wire:model.live="searchProduct"
                    placeholder="Search products..."
                    class="search-input" />
                <select
                    wire:model.live="categoryFilter"
                    class="category-select"
                    style="max-width: 12rem;">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Product::distinct()->pluck('category')->filter() as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Products Grid -->
            <div class="pos-card">
                <div class="products-grid">
                    @php
                    $products = \App\Models\Product::query()
                    ->when($this->searchProduct, fn($q) =>
                    $q->where('name', 'like', '%' . $this->searchProduct . '%')
                    )
                    ->when($this->categoryFilter, fn($q) =>
                    $q->where('category', $this->categoryFilter)
                    )
                    ->get();
                    @endphp

                    @forelse($products as $product)
                    <div
                        wire:click="addProduct({{ $product->id }})"
                        class="product-card">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-category">{{ $product->category }}</div>
                        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                    @empty
                    <div class="no-products">
                        <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p>No products found</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Side - Cart & Checkout -->
        <div>
            <div class="pos-card">
                <!-- Cart Header -->
                <div class="cart-header">
                    <h3 class="cart-title">Current Order</h3>
                    @if(!empty($selectedProducts))
                    <button wire:click="clearCart" class="clear-btn">Clear All</button>
                    @endif
                </div>

                
                <!-- Cart Items -->
                <div class="cart-items">
                    @forelse($selectedProducts as $index => $item)
                    <div class="cart-item" x-data="{ qty: {{ $item['quantity'] }} }">
                        <div class="item-header">
                            <div class="item-info">
                                <div class="item-name">{{ $item['name'] }}</div>
                                <div class="item-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                            </div>
                            <button wire:click="removeProduct({{ $index }})" class="remove-btn">✕</button>
                        </div>

                        <div class="quantity-controls">
                            <div class="qty-buttons">
                                <!-- Decrease -->
                                <button
                                    @click="if(qty > 1){ qty--; $wire.updateQuantity({{ $index }}, qty) }"
                                    class="qty-btn">−</button>

                                <!-- Input -->
                                <input
                                    type="number"
                                    x-model="qty"
                                    min="1"
                                    class="qty-input"
                                    @change="$wire.updateQuantity({{ $index }}, qty)" />

                                <!-- Increase -->
                                <button
                                    @click="qty++; $wire.updateQuantity({{ $index }}, qty)"
                                    class="qty-btn">+</button>
                            </div>

                            <div class="item-subtotal">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p>Cart is empty</p>
                        <p style="font-size: 0.875rem; margin-top: 0.25rem;">Add products to start</p>
                    </div>
                    @endforelse
                </div>


                <!-- Cart Footer -->
                @if(!empty($selectedProducts))
                <div class="cart-footer">
                    <div class="total-row">
                        <span class="total-label">Subtotal</span>
                        <span class="total-amount">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>

                    <div class="grand-total">
                        <span class="grand-total-label">Total</span>
                        <span class="grand-total-amount">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>

                    <button wire:click="createOrder" class="checkout-btn">
                        <span>✓</span>
                        <span>Complete Order</span>
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>