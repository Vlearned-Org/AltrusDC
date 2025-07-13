<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GovernanceDataResource\Pages;
use App\Filament\Resources\GovernanceDataResource\RelationManagers;
use App\Models\GovernanceData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GovernanceDataResource extends Resource
{
    protected static ?string $model = GovernanceData::class;
    protected static ?string $navigationGroup = 'ESG Data';
    protected static ?string $navigationLabel = 'Governance Data';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

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
                            ->helperText('The year this governance data applies to'),
                    ]),
                    
                Forms\Components\Section::make('Anti-Corruption Training')
                    ->description('Percentage of employees trained by category')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('management_anti_corruption_trained')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->label('Management Trained')
                            ->helperText('Percentage of management staff trained'),
                            
                        Forms\Components\TextInput::make('executive_anti_corruption_trained')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->label('Executives Trained')
                            ->helperText('Percentage of executive staff trained'),
                            
                        Forms\Components\TextInput::make('non_executive_anti_corruption_trained')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->label('Non-Executives Trained')
                            ->helperText('Percentage of non-executive staff trained'),
                            
                        Forms\Components\TextInput::make('general_worker_anti_corruption_trained')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->label('General Workers Trained')
                            ->helperText('Percentage of general workers trained'),
                    ]),
                    
                Forms\Components\Section::make('Risk Assessment')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('operations_assessed')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->label('Operations Assessed')
                            ->helperText('Percentage of operations assessed for corruption risks'),
                    ]),
                    
                Forms\Components\Section::make('Incident Reporting')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('corruption_incidents')
                            ->numeric()
                            ->minValue(0)
                            ->label('Corruption Incidents')
                            ->helperText('Number of confirmed corruption incidents'),
                            
                        Forms\Components\TextInput::make('human_rights_complaints')
                            ->numeric()
                            ->minValue(0)
                            ->label('Human Rights Complaints')
                            ->helperText('Number of human rights violation complaints'),
                            
                        Forms\Components\TextInput::make('data_privacy_breaches')
                            ->numeric()
                            ->minValue(0)
                            ->label('Data Privacy Breaches')
                            ->helperText('Number of customer data breaches'),
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
                    
                Tables\Columns\TextColumn::make('management_anti_corruption_trained')
                    ->label('Mgmt %')
                    ->suffix('%')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('executive_anti_corruption_trained')
                    ->label('Exec %')
                    ->suffix('%')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('operations_assessed')
                    ->label('Ops Assessed')
                    ->suffix('%')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('corruption_incidents')
                    ->label('Corruption Cases')
                    ->sortable()
                    ->color(fn ($record) => $record->corruption_incidents > 0 ? 'danger' : 'success'),
                    
                Tables\Columns\TextColumn::make('human_rights_complaints')
                    ->label('HR Complaints')
                    ->sortable()
                    ->color(fn ($record) => $record->human_rights_complaints > 0 ? 'danger' : 'success'),
                    
                Tables\Columns\TextColumn::make('data_privacy_breaches')
                    ->label('Data Breaches')
                    ->sortable()
                    ->color(fn ($record) => $record->data_privacy_breaches > 0 ? 'danger' : 'success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company')
                    ->relationship('company', 'name'),
                    
                Tables\Filters\SelectFilter::make('year')
                    ->options(
                        GovernanceData::query()
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
            'index' => Pages\ManageGovernanceData::route('/'),
        ];
    }
}