<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessTravelResource\Pages;
use App\Filament\Resources\BusinessTravelResource\RelationManagers;
use App\Models\BusinessTravel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class BusinessTravelResource extends Resource
{
    protected static ?string $model = BusinessTravel::class;
  
    protected static ?string $modelLabel = 'Business Travel';
    protected static ?string $navigationLabel = 'Business Travels';
   
    protected static ?string $navigationGroup = 'Travel Records';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Employee Information')
                    ->schema([
                        Forms\Components\TextInput::make('employee_name')
                            ->required()
                            ->maxLength(100)
                            ->label('Employee Full Name')
                            ->helperText('Full name of the traveling employee'),
                            
                        Forms\Components\TextInput::make('pic_name')
                            ->label('Person In Charge')
                            ->maxLength(100)
                            ->helperText('Name of the supervisor/manager approving this travel'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Trip Details')
                    ->schema([
                        Forms\Components\TextInput::make('destination')
                            ->required()
                            ->maxLength(100)
                            ->label('Destination City/Country')
                            ->helperText('The city and/or country being traveled to'),
                            
                        Forms\Components\Select::make('transport_mode')
                            ->options(BusinessTravel::getTransportModes())
                            ->required()
                            ->native(false)
                            ->label('Transportation Method')
                            ->helperText('Primary mode of transportation for this trip'),
                            
                        Forms\Components\TextInput::make('distance_km')
                            ->numeric()
                            ->suffix('km')
                            ->required()
                            ->label('Distance (km)')
                            ->helperText('Total round-trip distance in kilometers'),
                    ])->columns(3),
                
                Forms\Components\Section::make('Dates & Purpose')
                    ->schema([
                        Forms\Components\DatePicker::make('departure_date')
                            ->required()
                            ->label('Departure Date')
                            ->helperText('Date when the travel begins'),
                            
                        Forms\Components\DatePicker::make('return_date')
                            ->label('Return Date')
                            ->helperText('Expected return date (leave blank if unknown)'),
                            
                        Forms\Components\Textarea::make('purpose')
                            ->required()
                            ->columnSpanFull()
                            ->label('Travel Purpose')
                            ->helperText('Detailed description of the business purpose for this travel'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Administrative Details')
                    ->schema([
                      
                        Forms\Components\TextInput::make('fiscal_year')
                            ->required()
                            ->maxLength(9)
                            ->label('Fiscal Year')
                            ->helperText('Fiscal year in format FY2024'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_name')
                    ->searchable()
                    ->sortable()
                    ->label('Employee')
                    ->description(fn (BusinessTravel $record) => $record->destination)
                    ->wrap(),

 Tables\Columns\TextColumn::make('pic_name')
                    ->searchable()
                    ->sortable()
                    ->label('Person in Charge')
                  
                    ->wrap(),
                   
                
                Tables\Columns\TextColumn::make('transport_mode')
                    ->formatStateUsing(fn ($state) => BusinessTravel::getTransportModes()[$state] ?? $state)
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'CAR' => 'info',
                        'AIRCRAFT' => 'warning',
                        'TRAIN' => 'success',
                        default => 'gray',
                    })
                    ->label('Transport')
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('departure_date')
                    ->date()
                    ->sortable()
                    ->label('Departure')
                    ->description(fn (BusinessTravel $record) => $record->return_date 
                        ? 'Return: '.$record->return_date->format('M d, Y') 
                        : 'No return date'),
                
                Tables\Columns\TextColumn::make('distance_km')
                    ->numeric(2)
                    ->suffix(' km')
                    ->label('Distance')
                    ->alignEnd(),
                
                Tables\Columns\TextColumn::make('purpose')
                    ->limit(50)
                    ->tooltip(fn (BusinessTravel $record) => $record->purpose)
                    ->label('Purpose')
                    ->wrap(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('transport_mode')
                    ->options(BusinessTravel::getTransportModes())
                    ->label('Transportation Method'),
                
                Tables\Filters\Filter::make('departure_date')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('until')
                            ->label('To Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('departure_date', '>=', $date)
                            )
                            ->when($data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('departure_date', '<=', $date)
                            );
                    })
                    ->label('Date Range'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Edit this travel record'),
                Tables\Actions\DeleteAction::make()
                    ->tooltip('Delete this travel record'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete selected'),
                    ExportBulkAction::make()
                        ->color('success')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->exports([
                            ExcelExport::make()
                                ->fromTable()
                                ->askForWriterType()
                                ->withFilename(fn () => 'selected-business-travel-' . date('Y-m-d'))
                        ]),
                ]),
            ])
            ->defaultSort('departure_date', 'desc')
            ->emptyStateHeading('No travel records found')
            ->emptyStateDescription('Create your first business travel record')
            ->emptyStateIcon('heroicon-o-globe-alt')
            ->deferLoading()
            ->persistFiltersInSession();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBusinessTravel::route('/'),
          
        ];
    }
}