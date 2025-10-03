<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

   

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Recalculate total from items
        $total = 0;
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $total += $item['subtotal'] ?? 0;
            }
        }
        $data['total_price'] = $total;

        return $data;
    }
}
