<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialDataResource\Pages;
use App\Filament\Resources\SocialDataResource\RelationManagers;
use App\Models\SocialData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SocialDataResource extends Resource
{
    protected static ?string $model = SocialData::class;
    protected static ?string $navigationGroup = 'ESG Data';
    protected static ?string $navigationLabel = 'Social Data';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->relationship('company', 'name')
                            ->required()
                            ->label('Company')
                            ->helperText('Select the company this data belongs to'),
                            
                        Forms\Components\TextInput::make('year')
                            ->required()
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(2100)
                            ->label('Reporting Year')
                            ->helperText('The year this social data applies to'),
                    ]),
                    
                Forms\Components\Section::make('Employee Headcount')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('total_employees_start')
                            ->numeric()
                            ->minValue(0)
                            ->label('Start of Year')
                            ->helperText('Total employees at beginning of reporting period'),
                            
                        Forms\Components\TextInput::make('total_employees_end')
                            ->numeric()
                            ->minValue(0)
                            ->label('End of Year')
                            ->helperText('Total employees at end of reporting period'),
                    ]),
                    
                Forms\Components\Section::make('Employee Turnover')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('management_turnover')
                            ->numeric()
                            ->minValue(0)
                            ->label('Management')
                            ->helperText('Number of management staff departures'),
                            
                        Forms\Components\TextInput::make('executive_turnover')
                            ->numeric()
                            ->minValue(0)
                            ->label('Executives')
                            ->helperText('Number of executive staff departures'),
                            
                        Forms\Components\TextInput::make('non_executive_turnover')
                            ->numeric()
                            ->minValue(0)
                            ->label('Non-Executives')
                            ->helperText('Number of non-executive staff departures'),
                            
                        Forms\Components\TextInput::make('general_worker_turnover')
                            ->numeric()
                            ->minValue(0)
                            ->label('General Workers')
                            ->helperText('Number of general worker departures'),
                    ]),
                    
                Forms\Components\Section::make('Demographic Breakdown')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('malay_employees')
                            ->numeric()
                            ->minValue(0)
                            ->label('Malay Employees')
                            ->helperText('Number of Malay employees'),
                            
                        Forms\Components\TextInput::make('chinese_employees')
                            ->numeric()
                            ->minValue(0)
                            ->label('Chinese Employees')
                            ->helperText('Number of Chinese employees'),
                            
                        Forms\Components\TextInput::make('indian_employees')
                            ->numeric()
                            ->minValue(0)
                            ->label('Indian Employees')
                            ->helperText('Number of Indian employees'),
                            
                        Forms\Components\TextInput::make('other_ethnicity_employees')
                            ->numeric()
                            ->minValue(0)
                            ->label('Other Ethnicities')
                            ->helperText('Number of employees from other ethnic groups'),
                    ]),
                    
                Forms\Components\Section::make('Detailed Breakdowns')
                    ->description('JSON data for complex breakdowns')
                    ->schema([
                        Forms\Components\Textarea::make('management_breakdown')
                            ->label('Management Breakdown')
                            ->helperText('JSON data for management demographics (age/gender)')
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('executive_breakdown')
                            ->label('Executive Breakdown')
                            ->helperText('JSON data for executive demographics (age/gender)')
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('non_executive_breakdown')
                            ->label('Non-Executive Breakdown')
                            ->helperText('JSON data for non-executive demographics (age/gender)')
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('general_worker_breakdown')
                            ->label('General Worker Breakdown')
                            ->helperText('JSON data for general worker demographics (age/gender)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Company')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('year')
                    ->label('Year')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('total_employees_start')
                    ->label('Start')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('total_employees_end')
                    ->label('End')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('management_turnover')
                    ->label('Mgmt Turnover')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('executive_turnover')
                    ->label('Exec Turnover')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('malay_employees')
                    ->label('Malay')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('chinese_employees')
                    ->label('Chinese')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('indian_employees')
                    ->label('Indian')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company')
                    ->relationship('company', 'name'),
                    
                Tables\Filters\SelectFilter::make('year')
                    ->options(
                        SocialData::query()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->unique()
                            ->toArray()
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('year', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSocialData::route('/'),
        ];
    }
}