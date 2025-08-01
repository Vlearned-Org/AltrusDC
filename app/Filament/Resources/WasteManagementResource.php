<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WasteManagementResource\Pages;
use App\Filament\Resources\WasteManagementResource\RelationManagers;
use App\Models\WasteManagement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WasteManagementResource extends Resource
{
    protected static ?string $model = WasteManagement::class;
    protected static ?string $navigationIcon = 'heroicon-o-trash';
    protected static ?string $navigationLabel = 'Waste Tracking';
    protected static ?string $modelLabel = 'Waste Record';
    
    protected static ?string $navigationGroup = 'Organization';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Waste Information')
                    ->schema([
                        Forms\Components\TextInput::make('waste_type')
                            ->required()
                            ->maxLength(255)
                            ->label('Type of Waste')
                            ->helperText('E.g., Plastic, Paper, Metal, Chemical Waste')
                            ->columnSpan(2),
                            
                        Forms\Components\TextInput::make('unit')
                            ->required()
                            ->maxLength(255)
                            ->label('Measurement Unit')
                            ->helperText('E.g., kg, tons, cubic meters'),
                    ])->columns(3),
                    
                Forms\Components\Section::make('Disposal Methods')
                    ->description('Enter amounts for each disposal method')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                // Landfill
                                Forms\Components\Fieldset::make('Landfill')
                                    ->schema([
                                        Forms\Components\TextInput::make('landfill_hazardous')
                                            ->required()
                                            ->numeric()
                                            ->default(0.00)
                                            ->label('Hazardous')
                                            ->helperText('Amount sent to hazardous landfill'),
                                            
                                        Forms\Components\TextInput::make('landfill_non_hazardous')
                                            ->required()
                                            ->numeric()
                                            ->default(0.00)
                                            ->label('Non-Hazardous')
                                            ->helperText('Amount sent to regular landfill'),
                                    ]),
                                
                                // Incineration
                                Forms\Components\Fieldset::make('Incineration')
                                    ->schema([
                                        Forms\Components\TextInput::make('incineration_hazardous')
                                            ->required()
                                            ->numeric()
                                            ->default(0.00)
                                            ->label('Hazardous')
                                            ->helperText('Amount of hazardous waste incinerated'),
                                            
                                        Forms\Components\TextInput::make('incineration_non_hazardous')
                                            ->required()
                                            ->numeric()
                                            ->default(0.00)
                                            ->label('Non-Hazardous')
                                            ->helperText('Amount of regular waste incinerated'),
                                    ]),
                                
                                // Recycling
                                Forms\Components\Fieldset::make('Recycling')
                                    ->schema([
                                        Forms\Components\TextInput::make('recycled_hazardous')
                                            ->required()
                                            ->numeric()
                                            ->default(0.00)
                                            ->label('Hazardous')
                                            ->helperText('Amount of hazardous waste recycled'),
                                            
                                        Forms\Components\TextInput::make('recycled_non_hazardous')
                                            ->required()
                                            ->numeric()
                                            ->default(0.00)
                                            ->label('Non-Hazardous')
                                            ->helperText('Amount of regular waste recycled'),
                                    ]),
                                
                                // Reuse
                                Forms\Components\Fieldset::make('Reuse')
                                    ->schema([
                                        Forms\Components\TextInput::make('reused_hazardous')
                                            ->required()
                                            ->numeric()
                                            ->default(0.00)
                                            ->label('Hazardous')
                                            ->helperText('Amount of hazardous waste reused'),
                                            
                                        Forms\Components\TextInput::make('reused_non_hazardous')
                                            ->required()
                                            ->numeric()
                                            ->default(0.00)
                                            ->label('Non-Hazardous')
                                            ->helperText('Amount of regular waste reused'),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('waste_type')
                    ->searchable()
                    ->label('Waste Type')
                    ->description(fn ($record) => $record->unit)
                    ->sortable()
                    ->wrap(),
                    
                Tables\Columns\TextColumn::make('landfill_hazardous')
                    ->numeric(2)
                    ->label('Hazardous Landfill')
                    ->color('danger')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('landfill_non_hazardous')
                    ->numeric(2)
                    ->label('Recycled Landfill')
                    ->color('gray')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('incineration_hazardous')
                    ->numeric(2)
                    ->label('Hazardous Incin.')
                    ->color('danger')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('incineration_non_hazardous')
                    ->numeric(2)
                    ->label('Recycled Incin.')
                    ->color('gray')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('recycled_hazardous')
                    ->numeric(2)
                    ->label('Hazardous Recycled')
                    ->color('success')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('recycled_non_hazardous')
                    ->numeric(2)
                    ->label('Recycled non Recycled')
                    ->color('success')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('reused_hazardous')
                    ->numeric(2)
                    ->label('Haz Reused')
                    ->color('success')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('reused_non_hazardous')
                    ->numeric(2)
                    ->label('Reg Reused')
                    ->color('success')
                    ->sortable(),
                   
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('unit')
                    ->options(fn () => WasteManagement::distinct('unit')->pluck('unit', 'unit'))
                    ->label('Filter by Unit'),
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
            ->defaultSort('waste_type')
            ->groups([
                Tables\Grouping\Group::make('unit')
                    ->label('Unit')
                    ->collapsible(),
            ])
            ->emptyStateHeading('No waste records found')
            ->emptyStateDescription('Create your first waste management record')
            ->emptyStateIcon('heroicon-o-trash')
            ->deferLoading()
            ->persistFiltersInSession();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWasteManagement::route('/'),
            
        ];
    }
}