<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialDataResource\Pages;
use App\Models\SocialData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SocialDataResource extends Resource
{
    protected static ?string $model = SocialData::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('SocialDataTabs')
                    ->tabs([
                        // TAB 1: BASIC INFORMATION
                        Forms\Components\Tabs\Tab::make('Basic Information')
                            ->schema([
                                Forms\Components\Section::make('Employee Counts')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('total_employees_start')
                                                    ->label('Employees at Start of Year')
                                                    ->numeric()
                                                    ->required()
                                                    ->helperText('Enter the total number of employees at the beginning of the fiscal year'),
                                                
                                                Forms\Components\TextInput::make('total_employees_end')
                                                    ->label('Employees at End of Year')
                                                    ->numeric()
                                                    ->required()
                                                    ->helperText('Enter the total number of employees at the end of the fiscal year'),
                                                
                                                Forms\Components\TextInput::make('pic_name')
                                                    ->label('Person in Charge')
                                                    ->maxLength(255)
                                                    ->helperText('Name of the HR representative responsible for this data submission'),
                                            ]),
                                    ]),
                            ]),
                        
                        // TAB 2: EMPLOYEE BREAKDOWN
                        Forms\Components\Tabs\Tab::make('Employee Demographics')
                            ->schema([
                                // MANAGEMENT SECTION
                                Forms\Components\Section::make('Management Staff')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('management_male')
                                                    ->label('Male Managers')
                                                    ->numeric()
                                                    ->helperText('Number of male employees in management positions'),
                                                
                                                Forms\Components\TextInput::make('management_female')
                                                    ->label('Female Managers')
                                                    ->numeric()
                                                    ->helperText('Number of female employees in management positions'),
                                                
                                                Forms\Components\TextInput::make('management_below_30')
                                                    ->label('Managers Under 30')
                                                    ->numeric()
                                                    ->helperText('Management staff younger than 30 years old'),
                                                
                                                Forms\Components\TextInput::make('management_30_to_50')
                                                    ->label('Managers 30-50 Years')
                                                    ->numeric()
                                                    ->helperText('Management staff between 30 and 50 years old'),
                                                
                                                Forms\Components\TextInput::make('management_above_50')
                                                    ->label('Managers Over 50')
                                                    ->numeric()
                                                    ->helperText('Management staff older than 50 years'),
                                            ]),
                                    ]),
                                
                                // EXECUTIVE SECTION
                                Forms\Components\Section::make('Executive Staff')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('executive_male')
                                                    ->label('Male Executives')
                                                    ->numeric()
                                                    ->helperText('Number of male employees in executive roles'),
                                                
                                                Forms\Components\TextInput::make('executive_female')
                                                    ->label('Female Executives')
                                                    ->numeric()
                                                    ->helperText('Number of female employees in executive roles'),
                                                
                                                Forms\Components\TextInput::make('executive_below_30')
                                                    ->label('Executives Under 30')
                                                    ->numeric()
                                                    ->helperText('Executive staff younger than 30 years old'),
                                                
                                                Forms\Components\TextInput::make('executive_30_to_50')
                                                    ->label('Executives 30-50 Years')
                                                    ->numeric()
                                                    ->helperText('Executive staff between 30 and 50 years old'),
                                                
                                                Forms\Components\TextInput::make('executive_above_50')
                                                    ->label('Executives Over 50')
                                                    ->numeric()
                                                    ->helperText('Executive staff older than 50 years'),
                                            ]),
                                    ]),
                                
                                // NON-EXECUTIVE SECTION
                                Forms\Components\Section::make('Non-Executive Staff')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('non_executive_male')
                                                    ->label('Male Non-Executives')
                                                    ->numeric()
                                                    ->helperText('Number of male non-executive employees'),
                                                
                                                Forms\Components\TextInput::make('non_executive_female')
                                                    ->label('Female Non-Executives')
                                                    ->numeric()
                                                    ->helperText('Number of female non-executive employees'),
                                                
                                                Forms\Components\TextInput::make('non_executive_below_30')
                                                    ->label('Non-Executives Under 30')
                                                    ->numeric()
                                                    ->helperText('Non-executive staff younger than 30 years'),
                                                
                                                Forms\Components\TextInput::make('non_executive_30_to_50')
                                                    ->label('Non-Executives 30-50 Years')
                                                    ->numeric()
                                                    ->helperText('Non-executive staff between 30 and 50 years old'),
                                                
                                                Forms\Components\TextInput::make('non_executive_above_50')
                                                    ->label('Non-Executives Over 50')
                                                    ->numeric()
                                                    ->helperText('Non-executive staff older than 50 years'),
                                            ]),
                                    ]),
                                
                                // GENERAL WORKERS SECTION
                                Forms\Components\Section::make('General Workers')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('general_worker_male')
                                                    ->label('Male Workers')
                                                    ->numeric()
                                                    ->helperText('Number of male general workers'),
                                                
                                                Forms\Components\TextInput::make('general_worker_female')
                                                    ->label('Female Workers')
                                                    ->numeric()
                                                    ->helperText('Number of female general workers'),
                                                
                                                Forms\Components\TextInput::make('general_worker_below_30')
                                                    ->label('Workers Under 30')
                                                    ->numeric()
                                                    ->helperText('General workers younger than 30 years old'),
                                                
                                                Forms\Components\TextInput::make('general_worker_30_to_50')
                                                    ->label('Workers 30-50 Years')
                                                    ->numeric()
                                                    ->helperText('General workers between 30 and 50 years old'),
                                                
                                                Forms\Components\TextInput::make('general_worker_above_50')
                                                    ->label('Workers Over 50')
                                                    ->numeric()
                                                    ->helperText('General workers older than 50 years'),
                                            ]),
                                    ]),
                            ]),
                        
                        // TAB 3: DIVERSITY METRICS
                        Forms\Components\Tabs\Tab::make('Diversity Metrics')
                            ->schema([
                                // RACE/ETHNICITY SECTION
                                Forms\Components\Section::make('Race/Ethnic Composition')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('malay_employees')
                                                    ->label('Malay Employees')
                                                    ->numeric()
                                                    ->helperText('Number of employees identifying as Malay'),
                                                
                                                Forms\Components\TextInput::make('chinese_employees')
                                                    ->label('Chinese Employees')
                                                    ->numeric()
                                                    ->helperText('Number of employees identifying as Chinese'),
                                                
                                                Forms\Components\TextInput::make('indian_employees')
                                                    ->label('Indian Employees')
                                                    ->numeric()
                                                    ->helperText('Number of employees identifying as Indian'),
                                                
                                                Forms\Components\TextInput::make('other_ethnicity_employees')
                                                    ->label('Other Ethnicities')
                                                    ->numeric()
                                                    ->helperText('Number of employees from other ethnic groups'),
                                            ]),
                                    ]),
                                
                                // BOARD OF DIRECTORS SECTION
                                Forms\Components\Section::make('Board Composition')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('directors_male')
                                                    ->label('Male Directors')
                                                    ->numeric()
                                                    ->helperText('Number of male board members'),
                                                
                                                Forms\Components\TextInput::make('directors_female')
                                                    ->label('Female Directors')
                                                    ->numeric()
                                                    ->helperText('Number of female board members'),
                                                
                                                Forms\Components\TextInput::make('directors_below_30')
                                                    ->label('Directors Under 30')
                                                    ->numeric()
                                                    ->helperText('Board members younger than 30 years'),
                                                
                                                Forms\Components\TextInput::make('directors_30_to_50')
                                                    ->label('Directors 30-50 Years')
                                                    ->numeric()
                                                    ->helperText('Board members between 30 and 50 years old'),
                                                
                                                Forms\Components\TextInput::make('directors_above_50')
                                                    ->label('Directors Over 50')
                                                    ->numeric()
                                                    ->helperText('Board members older than 50 years'),
                                            ]),
                                    ]),
                            ]),
                        
                        // TAB 4: HR METRICS
                        Forms\Components\Tabs\Tab::make('HR Metrics')
                            ->schema([
                                // TURNOVER SECTION
                                Forms\Components\Section::make('Turnover Rates')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('management_turnover')
                                                    ->label('Management Turnover')
                                                    ->numeric()
                                                    ->helperText('Number of management staff who left during reporting period'),
                                                
                                                Forms\Components\TextInput::make('executive_turnover')
                                                    ->label('Executive Turnover')
                                                    ->numeric()
                                                    ->helperText('Number of executives who left during reporting period'),
                                                
                                                Forms\Components\TextInput::make('non_executive_turnover')
                                                    ->label('Non-Exec Turnover')
                                                    ->numeric()
                                                    ->helperText('Number of non-executive staff who left'),
                                                
                                                Forms\Components\TextInput::make('general_worker_turnover')
                                                    ->label('Worker Turnover')
                                                    ->numeric()
                                                    ->helperText('Number of general workers who left'),
                                            ]),
                                    ]),
                                
                                // NEW HIRES SECTION
                                Forms\Components\Section::make('New Hires')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('management_new_hires')
                                                    ->label('Management Hires')
                                                    ->numeric()
                                                    ->helperText('New management staff hired during period'),
                                                
                                                Forms\Components\TextInput::make('executive_new_hires')
                                                    ->label('Executive Hires')
                                                    ->numeric()
                                                    ->helperText('New executives hired during period'),
                                                
                                                Forms\Components\TextInput::make('non_executive_new_hires')
                                                    ->label('Non-Exec Hires')
                                                    ->numeric()
                                                    ->helperText('New non-executive staff hired'),
                                                
                                                Forms\Components\TextInput::make('general_worker_new_hires')
                                                    ->label('Worker Hires')
                                                    ->numeric()
                                                    ->helperText('New general workers hired'),
                                            ]),
                                    ]),
                                
                                // EMPLOYMENT TYPES SECTION
                                Forms\Components\Section::make('Employment Types')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('percentage_permanent')
                                                    ->label('Permanent (%)')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->helperText('Percentage of permanent employees (0-100)'),
                                                
                                                Forms\Components\TextInput::make('percentage_temporary')
                                                    ->label('Temporary (%)')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->helperText('Percentage of temporary employees (0-100)'),
                                                
                                                Forms\Components\TextInput::make('percentage_contract')
                                                    ->label('Contract (%)')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->helperText('Percentage of contract employees (0-100)'),
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

   public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Basic Information
            Tables\Columns\TextColumn::make('total_employees_start')
                ->label('Start Count')
                ->numeric()
                ->sortable()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('total_employees_end')
                ->label('End Count')
                ->numeric()
                ->sortable()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('pic_name')
                ->label('Responsible Person')
                ->searchable()
                ->toggleable(),
            
            // Management Staff
            Tables\Columns\TextColumn::make('management_male')
                ->label('Male Managers')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('management_female')
                ->label('Female Managers')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('management_below_30')
                ->label('Managers <30')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('management_30_to_50')
                ->label('Managers 30-50')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('management_above_50')
                ->label('Managers >50')
                ->numeric()
                ->toggleable(),
            
            // Executive Staff
            Tables\Columns\TextColumn::make('executive_male')
                ->label('Male Executives')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('executive_female')
                ->label('Female Executives')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('executive_below_30')
                ->label('Executives <30')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('executive_30_to_50')
                ->label('Executives 30-50')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('executive_above_50')
                ->label('Executives >50')
                ->numeric()
                ->toggleable(),
            
            // Non-Executive Staff
            Tables\Columns\TextColumn::make('non_executive_male')
                ->label('Male Non-Execs')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('non_executive_female')
                ->label('Female Non-Execs')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('non_executive_below_30')
                ->label('Non-Execs <30')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('non_executive_30_to_50')
                ->label('Non-Execs 30-50')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('non_executive_above_50')
                ->label('Non-Execs >50')
                ->numeric()
                ->toggleable(),
            
            // General Workers
            Tables\Columns\TextColumn::make('general_worker_male')
                ->label('Male Workers')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('general_worker_female')
                ->label('Female Workers')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('general_worker_below_30')
                ->label('Workers <30')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('general_worker_30_to_50')
                ->label('Workers 30-50')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('general_worker_above_50')
                ->label('Workers >50')
                ->numeric()
                ->toggleable(),
            
            // Diversity Metrics
            Tables\Columns\TextColumn::make('malay_employees')
                ->label('Malay Employees')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('chinese_employees')
                ->label('Chinese Employees')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('indian_employees')
                ->label('Indian Employees')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('other_ethnicity_employees')
                ->label('Other Ethnicities')
                ->numeric()
                ->toggleable(),
            
            // Board Composition
            Tables\Columns\TextColumn::make('directors_male')
                ->label('Male Directors')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('directors_female')
                ->label('Female Directors')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('directors_below_30')
                ->label('Directors <30')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('directors_30_to_50')
                ->label('Directors 30-50')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('directors_above_50')
                ->label('Directors >50')
                ->numeric()
                ->toggleable(),
            
            // HR Metrics - Turnover
            Tables\Columns\TextColumn::make('management_turnover')
                ->label('Mgmt Turnover')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('executive_turnover')
                ->label('Exec Turnover')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('non_executive_turnover')
                ->label('Non-Exec Turnover')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('general_worker_turnover')
                ->label('Worker Turnover')
                ->numeric()
                ->toggleable(),
            
            // HR Metrics - New Hires
            Tables\Columns\TextColumn::make('management_new_hires')
                ->label('Mgmt New Hires')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('executive_new_hires')
                ->label('Exec New Hires')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('non_executive_new_hires')
                ->label('Non-Exec New Hires')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('general_worker_new_hires')
                ->label('Worker New Hires')
                ->numeric()
                ->toggleable(),
            
            // HR Metrics - Employment Types
            Tables\Columns\TextColumn::make('percentage_permanent')
                ->label('Permanent %')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('percentage_temporary')
                ->label('Temporary %')
                ->numeric()
                ->toggleable(),
                
            Tables\Columns\TextColumn::make('percentage_contract')
                ->label('Contract %')
                ->numeric()
                ->toggleable(),
            
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Last Updated')
                ->dateTime()
                ->sortable()
                ->toggleable(),
        ])
        ->filters([
            // Add filters as needed
        ])
        ->actions([
            Tables\Actions\EditAction::make()
                ->tooltip('Edit this record'),
            Tables\Actions\DeleteAction::make()
                ->tooltip('Delete this record'),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Delete Selected'),
            ]),
        ]);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSocialData::route('/'),
        ];
    }
}