<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Product Name
                Forms\Components\TextInput::make('name')
                    ->label('Product Name')
                    ->required()
                    ->maxLength(255),

                // Category Dropdown (non-typable)
                Forms\Components\Select::make('category')
                    ->options([
                        'Coffee' => 'Coffee',
                        'Tea' => 'Tea',
                        'Milkshake' => 'Milkshake',
                        'Snack' => 'Snack',
                    ])
                    ->placeholder('Select category')
                    ->required()
                    ->label('Category'),
                // Price field
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric(),

                // Image Upload
                Forms\Components\FileUpload::make('image')
            ]);
    }
}
