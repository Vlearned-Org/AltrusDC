<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EconomicResource\Pages;
use App\Filament\Resources\EconomicResource\RelationManagers;
use App\Models\Economic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EconomicResource extends Resource
{
    protected static ?string $model = Economic::class;

    
    protected static ?string $modelLabel = 'Economic Report';
    protected static ?string $pluralModelLabel = 'Economic Reports';
    protected static ?string $navigationLabel = 'Economic Reports';
     protected static ?string $navigationGroup = 'ESG Data';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('EconomicReportTabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Overview')
                            ->schema([
                                Forms\Components\Section::make('Basic Information')
                                    ->schema([
                                        Forms\Components\TextInput::make('fiscal_year')
                                            ->required()
                                            ->numeric()
                                            ->minValue(2000)
                                            ->maxValue(2100)
                                            ->placeholder('2023')
                                            ->helperText('The fiscal year this report covers'),
                                            
                                        Forms\Components\TextInput::make('supply_chain_pic')
                                            ->label('Supply Chain PIC')
                                            ->maxLength(255)
                                            ->placeholder('John Smith')
                                            ->helperText('Person in charge of supply chain'),
                                            
                                        Forms\Components\TextInput::make('economic_value_pic')
                                            ->label('Economic Value PIC')
                                            ->maxLength(255)
                                            ->placeholder('Jane Doe')
                                            ->helperText('Person in charge of economic value reporting'),
                                    ])
                                    ->columns(2),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Vendor Spending')
                            ->schema([
                                Forms\Components\Section::make('Vendor Expenditures')
                                    ->schema([
                                        Forms\Components\TextInput::make('local_vendor_spending')
                                            ->label('Local Vendors')
                                            ->numeric()
                                            ->prefix('$')
                                            ->helperText('Amount spent on local vendors'),
                                            
                                        Forms\Components\TextInput::make('international_vendor_spending')
                                            ->label('International Vendors')
                                            ->numeric()
                                            ->prefix('$')
                                            ->helperText('Amount spent on international vendors'),
                                            
                                        Forms\Components\TextInput::make('total_expenditure')
                                            ->label('Total Vendor Spending')
                                            ->numeric()
                                            ->prefix('$')
                                            ->helperText('Sum of all vendor spending'),
                                            
                                        Forms\Components\TextInput::make('local_percentage')
                                            ->label('Local %')
                                            ->numeric()
                                            ->suffix('%')
                                            ->helperText('Percentage of spending on local vendors'),
                                            
                                        Forms\Components\TextInput::make('international_percentage')
                                            ->label('International %')
                                            ->numeric()
                                            ->suffix('%')
                                            ->helperText('Percentage of spending on international vendors'),
                                    ])
                                    ->columns(3),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Revenue')
                            ->schema([
                                Forms\Components\Section::make('Revenue Streams')
                                    ->schema([
                                        Forms\Components\TextInput::make('goods_revenue')
                                            ->label('Goods Sales')
                                            ->numeric()
                                            ->prefix('$')
                                            ->helperText('Revenue from goods sales'),
                                            
                                        Forms\Components\TextInput::make('services_revenue')
                                            ->label('Services')
                                            ->numeric()
                                            ->prefix('$')
                                            ->helperText('Revenue from services'),
                                            
                                        Forms\Components\TextInput::make('investments_revenue')
                                            ->label('Investments')
                                            ->numeric()
                                            ->prefix('$')
                                            ->helperText('Revenue from investments'),
                                            
                                        Forms\Components\TextInput::make('other_income')
                                            ->label('Other Income')
                                            ->numeric()
                                            ->prefix('$')
                                            ->helperText('Miscellaneous income sources'),
                                        
                                        Forms\Components\TextInput::make('total_value_generated')
                                            ->label('Total Revenue')
                                            ->numeric()
                                            ->prefix('$')
                                            ->helperText('Sum of all revenue streams'),
                                    ])
                                    ->columns(2),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Distribution')
                            ->schema([
                                Forms\Components\Section::make('Value Distribution')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('operating_expenses')
                                                    ->label('Operating Costs')
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->helperText('General operational costs'),
                                                    
                                                Forms\Components\TextInput::make('employee_wages')
                                                    ->label('Employee Wages')
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->helperText('Total compensation to employees'),
                                                    
                                                Forms\Components\TextInput::make('financial_institutions_payments')
                                                    ->label('Bank Payments')
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->helperText('Payments to banks/lenders'),
                                                    
                                                Forms\Components\TextInput::make('shareholders_payments')
                                                    ->label('Shareholders')
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->helperText('Dividends to shareholders'),
                                                    
                                                Forms\Components\TextInput::make('government_payments')
                                                    ->label('Government')
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->helperText('Taxes and fees to government'),
                                                    
                                                Forms\Components\TextInput::make('income_tax')
                                                    ->label('Income Tax')
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->helperText('Corporate income tax paid'),
                                                    
                                                Forms\Components\TextInput::make('community_investment')
                                                    ->label('Community')
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->helperText('Investments in local community'),
                                            ]),
                                            
                                        Forms\Components\TextInput::make('total_value_distributed')
                                            ->label('Total Distributed')
                                            ->numeric()
                                            ->prefix('$')
                                            ->helperText('Sum of all distributed value'),
                                            
                                        Forms\Components\TextInput::make('value_retained')
                                            ->label('Value Retained')
                                            ->numeric()
                                            ->prefix('$')
                                            ->helperText('Value retained by the business'),
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
                Tables\Columns\TextColumn::make('fiscal_year')
                    ->label('Year')
                    ->sortable()
                    ->searchable()
                    ->alignCenter()
                    ->description(fn ($record) => $record->supply_chain_pic),
                    
                Tables\Columns\TextColumn::make('total_value_generated')
                    ->label('Revenue')
                    ->money('USD')
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('total_expenditure')
                    ->label('Spending')
                    ->money('USD')
                    ->sortable()
                    ->color('danger'),
                    
                Tables\Columns\TextColumn::make('total_value_distributed')
                    ->label('Distributed')
                    ->money('USD')
                    ->sortable()
                    ->color('warning'),
                    
                Tables\Columns\TextColumn::make('value_retained')
                    ->label('Retained')
                    ->money('USD')
                    ->sortable()
                    ->color('primary')
                    ->weight('bold'),
            ])
            ->defaultSort('fiscal_year', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('fiscal_year')
                    ->options(function () {
                        return Economic::query()
                            ->select('fiscal_year')
                            ->distinct()
                            ->orderBy('fiscal_year', 'desc')
                            ->pluck('fiscal_year', 'fiscal_year');
                    })
                    ->label('Fiscal Year'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Economic Report'),
            ])
            ->groups([
                Tables\Grouping\Group::make('fiscal_year')
                    ->label('Fiscal Year')
                    ->collapsible(),
            ])
            ->defaultGroup('fiscal_year');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEconomics::route('/'),
          
        ];
    }
}