<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeCommutingResource\Pages;
use App\Filament\Resources\EmployeeCommutingResource\RelationManagers;
use App\Models\EmployeeCommuting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeCommutingResource extends Resource
{
    protected static ?string $model = EmployeeCommuting::class;
   
    protected static ?string $navigationLabel = 'Employee Commuting';
    protected static ?string $modelLabel = 'Commuting Record';
    protected static ?string $navigationGroup = 'Travel Records';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Employee Information')
                    ->schema([
                        Forms\Components\TextInput::make('employee_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Employee Name')
                            ->helperText('Full name of the employee'),
                            
                        Forms\Components\TextInput::make('department')
                            ->required()
                            ->maxLength(255)
                            ->label('Department')
                            ->helperText('Employee department or division'),
                            
                        Forms\Components\Select::make('mode_of_transport')
                            ->required()
                            ->options([
                                'car' => 'Car',
                                'motorcycle' => 'Motorcycle',
                                'public_transport' => 'Public Transport',
                                'walking' => 'Walking',
                                'bicycle' => 'Bicycle',
                                'carpool' => 'Carpool',
                            ])
                            ->label('Transport Mode')
                            ->helperText('Primary mode of transportation'),
                            
                        Forms\Components\Select::make('type_of_fuel')
                            ->options([
                                'petrol' => 'Petrol',
                                'diesel' => 'Diesel',
                                'electric' => 'Electric',
                                'hybrid' => 'Hybrid',
                                'none' => 'None',
                            ])
                            ->label('Fuel Type')
                            ->helperText('Type of fuel used (if applicable)')
                            ->default(null),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Commuting Details')
                    ->schema([
                        Forms\Components\TextInput::make('distance_traveled')
                            ->required()
                            ->numeric()
                            ->label('Daily Distance (km)')
                            ->helperText('Round-trip distance from home to office in kilometers')
                            ->suffix('km'),
                            
                        Forms\Components\DatePicker::make('commence_date')
                            ->required()
                            ->label('Start Date')
                            ->helperText('First day of commuting period'),
                            
                        Forms\Components\DatePicker::make('end_date')
                            ->required()
                            ->label('End Date')
                            ->helperText('Last day of commuting period'),
                    ])->columns(3),
                    
                Forms\Components\Section::make('Exclusions & Absences')
                    ->schema([
                        Forms\Components\TextInput::make('exclude_public_holidays')
                            ->required()
                            ->numeric()
                            ->label('Public Holidays')
                            ->helperText('Number of Malaysia public holidays excluded')
                            ->default(0),
                            
                        Forms\Components\TextInput::make('exclude_weekends')
                            ->required()
                            ->numeric()
                            ->label('Weekends Excluded')
                            ->helperText('Number of Saturdays/Sundays excluded')
                            ->default(0),
                            
                        Forms\Components\TextInput::make('leave_days')
                            ->required()
                            ->numeric()
                            ->label('Paid Leave Days')
                            ->helperText('Number of paid leave days')
                            ->default(0),
                            
                        Forms\Components\TextInput::make('unpaid_other_leave')
                            ->required()
                            ->numeric()
                            ->label('Unpaid Leave Days')
                            ->helperText('Number of unpaid/other leave days')
                            ->default(0),
                            
                        Forms\Components\TextInput::make('mc_days')
                            ->required()
                            ->numeric()
                            ->label('Medical Leave Days')
                            ->helperText('Number of medical certificate (MC) days')
                            ->default(0),
                    ])->columns(5),
                    
                Forms\Components\Section::make('Calculated Values')
                    ->schema([
                        Forms\Components\TextInput::make('days_commuting')
                            ->numeric()
                            ->label('Total Commuting Days')
                            ->helperText('Calculated commuting days')
                            ->default(null),
                            
                        Forms\Components\TextInput::make('km_petrol')
                            ->numeric()
                            ->label('Petrol Distance (km)')
                            ->helperText('Total distance using petrol vehicles')
                            ->suffix('km')
                            ->default(null),
                            
                        Forms\Components\TextInput::make('km_diesel')
                            ->numeric()
                            ->label('Diesel Distance (km)')
                            ->helperText('Total distance using diesel vehicles')
                            ->suffix('km')
                            ->default(null),
                    ])->columns(3),
                    
                Forms\Components\Section::make('Administrative')
                   ->schema([
      
            
        Forms\Components\TextInput::make('year')
            ->required()
            ->numeric()
            ->label('Year')
            ->default(date('Y'))
            ->helperText('Reporting year for this record'),
    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_name')
                    ->searchable()
                    ->label('Employee')
                    ->description(fn ($record) => $record->department)
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('mode_of_transport')
                    ->searchable()
                    ->label('Transport')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'car' => 'primary',
                        'motorcycle' => 'warning',
                        'public_transport' => 'success',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('distance_traveled')
                    ->numeric(2)
                    ->label('Daily KM')
                    ->suffix(' km')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('commence_date')
                    ->date()
                    ->label('Start Date')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->label('End Date')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('days_commuting')
                    ->numeric()
                    ->label('Commuting Days')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('km_petrol')
                    ->numeric(2)
                    ->label('Petrol KM')
                    ->suffix(' km')
                    ->color('warning')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('km_diesel')
                    ->numeric(2)
                    ->label('Diesel KM')
                    ->suffix(' km')
                    ->color('danger')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('mode_of_transport')
                    ->options([
                        'car' => 'Car',
                        'motorcycle' => 'Motorcycle',
                        'public_transport' => 'Public Transport',
                        'walking' => 'Walking',
                        'bicycle' => 'Bicycle',
                        'carpool' => 'Carpool',
                    ])
                    ->label('Transport Mode'),
                    
                Tables\Filters\SelectFilter::make('year')
                    ->options(fn () => EmployeeCommuting::distinct('year')->pluck('year', 'year'))
                    ->label('Year'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Delete'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected'),
                ]),
            ])
            ->defaultSort('commence_date', 'desc')
            ->groups([
                Tables\Grouping\Group::make('department')
                    ->label('Department')
                    ->collapsible(),
            ])
            ->emptyStateHeading('No commuting records found')
            ->emptyStateDescription('Create your first employee commuting record')
            ->emptyStateIcon('heroicon-o-users')
            ->deferLoading()
            ->persistFiltersInSession();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEmployeeCommutings::route('/'),
           
        ];
    }
}