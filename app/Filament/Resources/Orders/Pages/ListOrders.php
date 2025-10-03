<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Exports\SalesExport;
use Filament\Forms\Components\DatePicker;
use Maatwebsite\Excel\Facades\Excel;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pos')
                ->label('Buat Order')
                ->icon('heroicon-o-shopping-cart')
                ->color('success')
                ->url(fn () => OrderResource::getUrl('pos')),
            // Actions\CreateAction::make(),

            Actions\Action::make('exportSales')
            ->label('Export Penjualan')
            ->icon('heroicon-o-document-arrow-down')
            ->color('success')
            ->form([
                DatePicker::make('from')
                    ->label('From Date')
                    ->required(),
                DatePicker::make('to')
                    ->label('To Date')
                    ->required(),
            ])
            ->action(function (array $data) {
                $filename = sprintf(
                    'sales_%s_to_%s.xlsx',
                    \Carbon\Carbon::parse($data['from'])->format('Ymd'),
                    \Carbon\Carbon::parse($data['to'])->format('Ymd'),
                );

                return Excel::download(new SalesExport($data['from'], $data['to']), $filename);
            })
            ->modalHeading('Export Sales by Date Range')
            ->modalButton('Download'),
        ];
    }
}