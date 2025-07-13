<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EconomicDataResource\Pages;
use App\Filament\Resources\EconomicDataResource\RelationManagers;
use App\Models\EconomicData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EconomicDataResource extends Resource
{
    protected static ?string $model = EconomicData::class;
    protected static ?string $navigationGroup = 'ESG Data';
    protected static ?string $navigationLabel = 'Economic Data';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

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
                            ->label('Fiscal Year')
                            ->helperText('The reporting year for this data'),
                    ]),
                    
                Forms\Components\Section::make('Supply Chain Metrics')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('local_vendor_spend')
                            ->numeric()
                            ->prefix('RM')
                            ->label('Local Vendor Spend')
                            ->helperText('Total spent with local suppliers'),
                            
                        Forms\Components\TextInput::make('international_vendor_spend')
                            ->numeric()
                            ->prefix('RM')
                            ->label('International Vendor Spend')
                            ->helperText('Total spent with international suppliers'),
                    ]),
                    
                Forms\Components\Section::make('Revenue Streams')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('goods_revenue')
                            ->numeric()
                            ->prefix('RM')
                            ->label('Goods Revenue')
                            ->helperText('Revenue from product sales'),
                            
                        Forms\Components\TextInput::make('services_revenue')
                            ->numeric()
                            ->prefix('RM')
                            ->label('Services Revenue')
                            ->helperText('Revenue from service offerings'),
                            
                        Forms\Components\TextInput::make('investment_revenue')
                            ->numeric()
                            ->prefix('RM')
                            ->label('Investment Revenue')
                            ->helperText('Income from financial investments'),
                            
                        Forms\Components\TextInput::make('other_income')
                            ->numeric()
                            ->prefix('RM')
                            ->label('Other Income')
                            ->helperText('Miscellaneous operating income'),
                    ]),
                    
                Forms\Components\Section::make('Economic Value Distribution')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('operating_expenses')
                            ->numeric()
                            ->prefix('RM')
                            ->label('Operating Expenses')
                            ->helperText('Total operational costs'),
                            
                        Forms\Components\TextInput::make('employee_wages')
                            ->numeric()
                            ->prefix('RM')
                            ->label('Employee Wages')
                            ->helperText('Total compensation to employees'),
                            
                        Forms\Components\TextInput::make('capital_payments')
                            ->numeric()
                            ->prefix('RM')
                            ->label('Capital Payments')
                            ->helperText('Payments to capital providers'),
                            
                        Forms\Components\TextInput::make('government_payments')
                            ->numeric()
                            ->prefix('RM')
                            ->label('Government Payments')
                            ->helperText('Taxes and payments to government'),
                            
                        Forms\Components\TextInput::make('community_investment')
                            ->numeric()
                            ->prefix('RM')
                            ->label('Community Investment')
                            ->helperText('Investment in local communities'),
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
                    
                Tables\Columns\TextColumn::make('local_vendor_spend')
                    ->label('Local Spend')
                    ->money('MYR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('international_vendor_spend')
                    ->label('Intl. Spend')
                    ->money('MYR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('goods_revenue')
                    ->label('Goods Rev.')
                    ->money('MYR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('services_revenue')
                    ->label('Services Rev.')
                    ->money('MYR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('employee_wages')
                    ->label('Wages')
                    ->money('MYR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('community_investment')
                    ->label('Community')
                    ->money('MYR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company')
                    ->relationship('company', 'name'),
                    
                Tables\Filters\SelectFilter::make('year')
                    ->options(
                        EconomicData::query()
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEconomicData::route('/'),
        ];
    }
}