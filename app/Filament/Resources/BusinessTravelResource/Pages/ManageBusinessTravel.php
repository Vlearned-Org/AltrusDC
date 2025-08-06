<?php

namespace App\Filament\Resources\BusinessTravelResource\Pages;

use App\Filament\Resources\BusinessTravelResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Imports\BusinessTravelImport;
use App\Exports\BusinessTravelTemplateExport;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;

class ManageBusinessTravel extends ManageRecords
{
    protected static string $resource = BusinessTravelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('import')
                ->label('Import Business Travel')
                ->color('primary')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    FileUpload::make('file')
                        ->label('Excel File')
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'])
                        ->required()
                        ->helperText('Upload an Excel file with columns: employee_name, pic_name, account, fiscal_year, destination, transport_mode, departure_date, return_date, purpose, distance_km')
                ])
                ->action(function (array $data) {
                    try {
                        $file = storage_path('app/public/' . $data['file']);
                        Excel::import(new BusinessTravelImport, $file);
                        
                        Notification::make()
                            ->title('Business Travel records imported successfully!')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Import failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            ExportAction::make()
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray')
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->askForWriterType()
                        ->withFilename(fn () => 'business-travel-export-' . date('Y-m-d-H-i-s'))
                ]),
            Actions\Action::make('downloadTemplate')
                ->label('Download Template')
                ->color('info')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    return Excel::download(new BusinessTravelTemplateExport, 'business-travel-import-template.xlsx');
                }),
        ];
    }
}
