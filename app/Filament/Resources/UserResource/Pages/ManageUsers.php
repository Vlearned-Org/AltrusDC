<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Imports\UsersImport;
use App\Exports\UserTemplateExport;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('import')
                ->label('Import Users')
                ->color('primary')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    FileUpload::make('file')
                        ->label('Excel File')
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'])
                        ->required()
                        ->helperText('Upload an Excel file with columns: name, email, password (optional), email_verified_at (optional)')
                ])
                ->action(function (array $data) {
                    try {
                        $file = storage_path('app/public/' . $data['file']);
                        Excel::import(new UsersImport, $file);
                        
                        Notification::make()
                            ->title('Users imported successfully!')
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
                        ->withFilename(fn () => 'users-export-' . date('Y-m-d-H-i-s'))
                ]),
            Actions\Action::make('downloadTemplate')
                ->label('Download Template')
                ->color('info')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    return Excel::download(new UserTemplateExport, 'users-import-template.xlsx');
                }),
        ];
    }
}
