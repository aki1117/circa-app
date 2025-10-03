<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use App\Models\Product;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('pending'),

                Forms\Components\TextInput::make('total_price')
                    ->numeric()
                    ->prefix('Rp')
                    ->readOnly()
                    ->dehydrated()
                    ->required()
                    ->afterStateHydrated(function ($state, Set $set, Get $get) {
                        // If DB has 0 or null, recalc from items
                        if (empty($state)) {
                            $items = $get('items') ?? [];
                            $total = collect($items)->sum('subtotal');
                            $set('total_price', $total);
                        }
                    }),

                Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                if (!$state) return;

                                $product = Product::find($state);
                                if ($product) {
                                    $set('price', $product->price);
                                    $quantity = $get('quantity') ?? 1;
                                    $subtotal = $product->price * $quantity;
                                    $set('subtotal', $subtotal);

                                    // update total
                                    $items = $get('../../items') ?? [];
                                    $total = collect($items)->sum('subtotal');
                                    $set('../../total_price', $total);
                                }
                            }),

                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $price = $get('price') ?? 0;
                                $subtotal = $price * ($state ?? 1);
                                $set('subtotal', $subtotal);

                                // update total
                                $items = $get('../../items') ?? [];
                                $total = collect($items)->sum('subtotal');
                                $set('../../total_price', $total);
                            }),

                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('Rp')
                            ->readOnly()
                            ->dehydrated()
                            ->required(),

                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('Rp')
                            ->readOnly()
                            ->dehydrated()
                            ->required()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                // recalc total whenever subtotal changes
                                $items = $get('../../items') ?? [];
                                $total = collect($items)->sum('subtotal');
                                $set('../../total_price', $total);
                            }),
                    ])
                    ->columns(4)
                    ->defaultItems(1)
                    ->live()
                    ->reorderable(false),
            ]);
    }
}
