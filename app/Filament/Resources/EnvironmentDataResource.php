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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Environment Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('metrics')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2)
                            ->label('Metric Name')
                            ->helperText('The environmental metric being measured (e.g., Electricity, Water)'),
                            
                        Forms\Components\TextInput::make('person_in_charge')
                            ->maxLength(255)
                            ->label('Responsible Person')
                            ->helperText('Person accountable for this data'),
                            
                        Forms\Components\TextInput::make('unit')
                            ->maxLength(255)
                            ->label('Unit of Measurement')
                            ->helperText('Unit of measurement (e.g., kWh, m³)'),
                            
                        Forms\Components\TextInput::make('emission_factor')
                            ->numeric()
                            ->label('Emission Factor (kg CO₂/unit)')
                            ->helperText('Conversion factor to CO₂ equivalent'),
                    ]),
                    
                Forms\Components\Section::make('Monthly Data - Current Year')
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('april')
                            ->numeric()
                            ->label('April')
                            ->helperText('Current year'),
                            
                        Forms\Components\TextInput::make('may')
                            ->numeric()
                            ->label('May')
                            ->helperText('Current year'),
                            
                        Forms\Components\TextInput::make('june')
                            ->numeric()
                            ->label('June')
                            ->helperText('Current year'),
                            
                        Forms\Components\TextInput::make('july')
                            ->numeric()
                            ->label('July')
                            ->helperText('Current year'),
                            
                        Forms\Components\TextInput::make('august')
                            ->numeric()
                            ->label('August')
                            ->helperText('Current year'),
                            
                        Forms\Components\TextInput::make('september')
                            ->numeric()
                            ->label('September')
                            ->helperText('Current year'),
                            
                        Forms\Components\TextInput::make('october')
                            ->numeric()
                            ->label('October')
                            ->helperText('Current year'),
                            
                        Forms\Components\TextInput::make('november')
                            ->numeric()
                            ->label('November')
                            ->helperText('Current year'),
                            
                        Forms\Components\TextInput::make('december')
                            ->numeric()
                            ->label('December')
                            ->helperText('Current year'),
                    ]),
                    
                Forms\Components\Section::make('Monthly Data - Next Year')
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('january')
                            ->numeric()
                            ->label('January')
                            ->helperText('Next year'),
                            
                        Forms\Components\TextInput::make('february')
                            ->numeric()
                            ->label('February')
                            ->helperText('Next year'),
                            
                        Forms\Components\TextInput::make('march')
                            ->numeric()
                            ->label('March')
                            ->helperText('Next year'),
                            
                      // In your EnvironmentDataResource.php form method
Forms\Components\TextInput::make('total_kg_co2')
    ->numeric()
    ->label('Total (kg CO₂)')
    ->helperText('Automatically calculated sum of all months')
    ->columnSpan(2)
    ->disabled() // Makes the field non-editable
    ->dehydrated(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('metrics')
                    ->searchable()
                    ->label('Metric'),
                    
                Tables\Columns\TextColumn::make('person_in_charge')
                    ->searchable()
                    ->label('Responsible'),
                    
                Tables\Columns\TextColumn::make('unit')
                    ->searchable()
                    ->label('Unit'),
                    
                // Current Year Months
                Tables\Columns\TextColumn::make('april')
                    ->numeric()
                    ->label('Apr'),
                    
                Tables\Columns\TextColumn::make('may')
                    ->numeric()
                    ->label('May'),
                    
                Tables\Columns\TextColumn::make('june')
                    ->numeric()
                    ->label('Jun'),
                    
                Tables\Columns\TextColumn::make('july')
                    ->numeric()
                    ->label('Jul'),
                    
                Tables\Columns\TextColumn::make('august')
                    ->numeric()
                    ->label('Aug'),
                    
                Tables\Columns\TextColumn::make('september')
                    ->numeric()
                    ->label('Sep'),
                    
                Tables\Columns\TextColumn::make('october')
                    ->numeric()
                    ->label('Oct'),
                    
                Tables\Columns\TextColumn::make('november')
                    ->numeric()
                    ->label('Nov'),
                    
                Tables\Columns\TextColumn::make('december')
                    ->numeric()
                    ->label('Dec'),
                    
                // Next Year Months
                Tables\Columns\TextColumn::make('january')
                    ->numeric()
                    ->label('Jan'),
                    
                Tables\Columns\TextColumn::make('february')
                    ->numeric()
                    ->label('Feb'),
                    
                Tables\Columns\TextColumn::make('march')
                    ->numeric()
                    ->label('Mar'),
                    
                Tables\Columns\TextColumn::make('total_kg_co2')
                    ->numeric()
                    ->label('Total')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->label('Total')
                    ]),
                          
                Tables\Columns\TextColumn::make('total_kg_co2')
                    ->numeric()
                    ->label('Total CO₂/Kg')
                   
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEnvironmentData::route('/'),
        ];
    }
}