<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $modelLabel = 'Company';
    protected static ?string $navigationLabel = 'Companies';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationGroup = 'Organization';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Company Details')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Basic Information')
                            ->schema([
                                Forms\Components\Section::make('Company Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Company Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull()
                                            ->helperText('The legal name of your company as registered'),
                                            
                                        Forms\Components\TextInput::make('location')
                                            ->label('Headquarters Location')
                                            ->required()
                                            ->maxLength(255)
                                            ->helperText('Primary office location or headquarters address'),
                                            
                                        Forms\Components\DatePicker::make('reporting_date')
                                            ->label('Last Sustainability Report Date')
                                            ->required()
                                            ->native(false)
                                            ->displayFormat('M d, Y')
                                            ->helperText('Most recent date when sustainability report was published'),
                                            
                                        Forms\Components\ColorPicker::make('color_code')
                                            ->label('Brand Color')
                                            ->required()
                                            ->hexColor()
                                            ->helperText('Primary brand color used for visual identification'),
                                    ])
                                    ->columns(2),
                                    
                                Forms\Components\Section::make('Branding')
                                    ->schema([
                                        Forms\Components\FileUpload::make('logo_path')
                                            ->label('Company Logo')
                                            ->directory('company-logos')
                                            ->image()
                                            ->imageEditor()
                                            ->helperText('Upload your company logo (recommended size: 500x500px)'),
                                    ]),
                                    
                                Forms\Components\Section::make('Mission & Vision')
                                    ->schema([
                                        Forms\Components\Textarea::make('mission')
                                            ->label('Mission Statement')
                                            ->columnSpanFull()
                                            ->rows(3)
                                            ->helperText('Describe your company\'s purpose and core objectives'),
                                            
                                        Forms\Components\Textarea::make('vision')
                                            ->label('Vision Statement')
                                            ->columnSpanFull()
                                            ->rows(3)
                                            ->helperText('Outline your company\'s long-term aspirations and goals'),
                                    ]),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Sustainability')
                            ->schema([
                                Forms\Components\Toggle::make('has_sustainability_goals')
                                    ->label('Has Sustainability Goals?')
                                    ->live()
                                    ->columnSpanFull()
                                    ->helperText('Toggle if your company has defined sustainability objectives'),
                                    
                                Forms\Components\Section::make('Sustainability Goals')
                                    ->hidden(fn (Forms\Get $get) => !$get('has_sustainability_goals'))
                                    ->schema([
                                        Forms\Components\CheckboxList::make('sustainability_goals')
                                            ->label('Focus Areas')
                                            ->options([
                                                'carbon_footprint_reduction' => 'Carbon Reduction',
                                                'sustainable_sourcing' => 'Sustainable Sourcing',
                                                'energy_efficiency' => 'Energy Efficiency',
                                                'waste_reduction' => 'Waste Reduction',
                                                'employee_engagement' => 'Employee Engagement',
                                            ])
                                            ->columns(2)
                                            ->searchable()
                                            ->helperText('Select all applicable sustainability focus areas'),
                                            
                                        Forms\Components\Textarea::make('other_sustainability_goals')
                                            ->label('Additional Goals')
                                            ->columnSpanFull()
                                            ->rows(2)
                                            ->helperText('Any other sustainability objectives not listed above'),
                                    ]),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Subsidiaries')
                            ->schema([
                                Forms\Components\Repeater::make('subsidiaries_list')
                                    ->label('Subsidiary Companies')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Subsidiary Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->helperText('Name of the subsidiary company'),
                                    ])
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->addActionLabel('Add Subsidiary')
                                    ->columns(1)
                                    ->helperText('Optional: Add any subsidiary companies under this organization'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->name).'&color=FFFFFF&background='.str_replace('#', '', $record->color_code ?? '000000')),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Company Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => $record->location),
                
                Tables\Columns\TextColumn::make('mission')
                    ->label('Mission')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->mission)
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('vision')
                    ->label('Vision')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->vision)
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('reporting_date')
                    ->label('Report Date')
                    ->date('M d, Y')
                    ->sortable()
                    ->alignRight(),
                
                Tables\Columns\IconColumn::make('has_sustainability_goals')
                    ->label('Sustainability')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark'),
                
                Tables\Columns\TextColumn::make('sustainability_goals')
                    ->label('Goals')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) return null;
                        
                        return Tables\Columns\Layout\Stack::make([
                            Tables\Columns\TextColumn::make('')
                                ->formatStateUsing(fn () => count($state).' goals')
                                ->extraAttributes(['class' => 'font-medium']),
                            Tables\Columns\TextColumn::make('')
                                ->formatStateUsing(function () use ($state) {
                                    return collect($state)->map(function ($goal) {
                                        $labels = [
                                            'carbon_footprint_reduction' => 'Carbon Reduction',
                                            'sustainable_sourcing' => 'Sustainable Sourcing',
                                            'energy_efficiency' => 'Energy Efficiency',
                                            'waste_reduction' => 'Waste Reduction',
                                            'employee_engagement' => 'Employee Engagement',
                                        ];
                                        return $labels[$goal] ?? $goal;
                                    })->implode(', ');
                                })
                                ->extraAttributes(['class' => 'text-xs text-gray-500']),
                        ]);
                    })
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('subsidiaries_list')
                    ->label('Subsidiaries')
                    ->badge()
                    ->color('primary')
                    ->formatStateUsing(fn ($state) => count($state ?? []))
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sustainability_goals')
                    ->label('Sustainability Goals')
                    ->options([
                        'carbon_footprint_reduction' => 'Carbon Reduction',
                        'sustainable_sourcing' => 'Sustainable Sourcing',
                        'energy_efficiency' => 'Energy Efficiency',
                        'waste_reduction' => 'Waste Reduction',
                        'employee_engagement' => 'Employee Engagement',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['values'])) {
                            foreach ($data['values'] as $goal) {
                                $query->whereJsonContains('sustainability_goals', $goal);
                            }
                        }
                    }),
                
                Tables\Filters\Filter::make('has_subsidiaries')
                    ->label('Has Subsidiaries')
                    ->query(fn (Builder $query): Builder => $query->whereJsonLength('subsidiaries_list', '>', 0)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('name', 'asc')
            ->groups([
                Tables\Grouping\Group::make('reporting_date')
                    ->label('Reporting Year')
                    ->date()
                    ->collapsible(),
            ])
            ->persistFiltersInSession()
            ->persistSearchInSession();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCompanies::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'primary';
    }
}