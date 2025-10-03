<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;

class CreateOrderPOS extends Page
{
    protected static string $resource = OrderResource::class;
    protected string $view = 'filament.resources.orders.pages.create-order-pos';
    protected static ?string $title = 'Point of Sale';

    public $selectedProducts = [];
    public $totalPrice = 0;
    public $searchProduct = '';
    public $categoryFilter = '';

    public function mount(): void
    {
        $this->selectedProducts = [];
        $this->totalPrice = 0;
    }

    public function addProduct($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            Notification::make()
                ->warning()
                ->title('Product not found')
                ->send();
            return;
        }

        $existingKey = collect($this->selectedProducts)
            ->search(fn($item) => $item['product_id'] == $productId);

        if ($existingKey !== false) {
            $this->selectedProducts[$existingKey]['quantity']++;
            $this->selectedProducts[$existingKey]['subtotal'] =
                $this->selectedProducts[$existingKey]['quantity'] * $product->price;
        } else {
            $this->selectedProducts[] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'category'   => $product->category,
                'price'      => $product->price,
                'quantity'   => 1,
                'subtotal'   => $product->price,
            ];
        }

        $this->calculateTotal();
    }

    public function removeProduct($index)
    {
        if (isset($this->selectedProducts[$index])) {
            unset($this->selectedProducts[$index]);
            $this->selectedProducts = array_values($this->selectedProducts);
            $this->calculateTotal();
        }
    }

    public function updateQuantity($index, $quantity)
    {
        if ($quantity < 1) {
            $this->removeProduct($index);
            return;
        }

        if (isset($this->selectedProducts[$index])) {
            $this->selectedProducts[$index]['quantity'] = $quantity;
            $this->selectedProducts[$index]['subtotal'] =
                $this->selectedProducts[$index]['quantity'] *
                $this->selectedProducts[$index]['price'];

            $this->calculateTotal();
        }
    }

    protected function calculateTotal()
    {
        $this->totalPrice = collect($this->selectedProducts)->sum('subtotal');
    }

    public function createOrder()
    {
        if (empty($this->selectedProducts)) {
            Notification::make()
                ->warning()
                ->title('No products selected')
                ->body('Please add at least one product to create an order.')
                ->send();
            return;
        }

        $order = Order::create([
            'total_price' => $this->totalPrice,
            'status'      => 'completed',
        ]);

        foreach ($this->selectedProducts as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'subtotal'   => $item['subtotal'],
            ]);
        }

        Notification::make()
            ->success()
            ->title('Order created successfully')
            ->body("Order #{$order->id} completed. Total: Rp " . number_format($this->totalPrice, 0, ',', '.'))
            ->send();

        $this->selectedProducts = [];
        $this->totalPrice = 0;
        $this->searchProduct = '';
        $this->categoryFilter = '';
    }

    public function clearCart()
    {
        $this->selectedProducts = [];
        $this->totalPrice = 0;
    }
}
