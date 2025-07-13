<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnvironmentDataResource\Pages;
use App\Filament\Resources\EnvironmentDataResource\RelationManagers;
use App\Models\EnvironmentData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnvironmentDataResource extends Resource
{
    protected static ?string $model = EnvironmentData::class;
    protected static ?string $navigationGroup = 'ESG Data';
    protected static ?string $navigationLabel = 'Environment Data';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

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
                            ->helperText('The year this environmental data applies to'),
                    ]),
                    
                Forms\Components\Section::make('Scope 1 Emissions (Direct)')
                    ->description('Fuel consumption and direct emissions')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('diesel_consumption')
                            ->numeric()
                            ->suffix('liters')
                            ->label('Diesel Consumption')
                            ->helperText('Total diesel used in vehicles/equipment'),
                            
                        Forms\Components\TextInput::make('petrol_consumption')
                            ->numeric()
                            ->suffix('liters')
                            ->label('Petrol Consumption')
                            ->helperText('Total petrol used in vehicles/equipment'),
                            
                        Forms\Components\TextInput::make('lpg_gas')
                            ->numeric()
                            ->suffix('kg')
                            ->label('LPG Gas Usage')
                            ->helperText('Liquefied petroleum gas consumption'),
                            
                        Forms\Components\TextInput::make('other_gas')
                            ->numeric()
                            ->label('Other Gas Usage')
                            ->helperText('Any other gaseous fuel consumption'),
                    ]),
                    
                Forms\Components\Section::make('Scope 2 Emissions (Indirect)')
                    ->description('Purchased electricity and energy')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('electricity_consumption')
                            ->numeric()
                            ->suffix('kWh')
                            ->label('Electricity Consumption')
                            ->helperText('Total grid electricity purchased'),
                            
                        Forms\Components\TextInput::make('solar_generated')
                            ->numeric()
                            ->suffix('kWh')
                            ->label('Solar Energy Generated')
                            ->helperText('On-site renewable energy production'),
                    ]),
                    
                Forms\Components\Section::make('Water Management')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('water_consumption')
                            ->numeric()
                            ->suffix('m³')
                            ->label('Water Consumption')
                            ->helperText('Total freshwater withdrawn'),
                            
                        Forms\Components\TextInput::make('water_recycled')
                            ->numeric()
                            ->suffix('m³')
                            ->label('Water Recycled')
                            ->helperText('Rainwater/other recycled water used'),
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
                    
                Tables\Columns\TextColumn::make('diesel_consumption')
                    ->label('Diesel')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state).' L' : '-')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('petrol_consumption')
                    ->label('Petrol')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state).' L' : '-')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('electricity_consumption')
                    ->label('Electricity')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state).' kWh' : '-')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('water_consumption')
                    ->label('Water Use')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state).' m³' : '-')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('water_recycled')
                    ->label('Water Recycled')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state).' m³' : '-')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company')
                    ->relationship('company', 'name'),
                    
                Tables\Filters\SelectFilter::make('year')
                    ->options(
                        EnvironmentData::query()
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
            'index' => Pages\ManageEnvironmentData::route('/'),
        ];
    }
}