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
    protected static ?string $modelLabel = 'Company';
    protected static ?string $navigationLabel = 'Companies';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationGroup = 'Organization';
    protected static ?int $navigationSort = 1;
   
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
                                Forms\Components\Section::make('Sustainability Goals')
                                    ->schema([
                                        Forms\Components\Checkbox::make('carbon_footprint_reduction')
                                            ->label('Carbon Footprint Reduction'),
                                        Forms\Components\Checkbox::make('sustainable_sourcing')
                                            ->label('Sustainable Sourcing'),
                                        Forms\Components\Checkbox::make('energy_efficiency')
                                            ->label('Energy Efficiency'),
                                        Forms\Components\Checkbox::make('waste_reduction')
                                            ->label('Waste Reduction'),
                                        Forms\Components\Checkbox::make('employee_engagement')
                                            ->label('Employee Engagement'),
                                            
                                        Forms\Components\Textarea::make('other_sustainability_goals')
                                            ->label('Additional Goals')
                                            ->columnSpanFull()
                                            ->rows(2)
                                            ->helperText('Any other sustainability objectives not listed above'),
                                    ])
                                    ->columns(2),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Subsidiaries')
                            ->schema([
                                Forms\Components\Repeater::make('subsidiaryCompanies')
                                    ->label('Subsidiary Companies')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Subsidiary Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->helperText('Name of the subsidiary company'),
                                        Forms\Components\TextInput::make('ownership_percentage')
                                            ->label('Ownership Percentage')
                                            ->numeric()
                                            ->suffix('%')
                                            ->minValue(0)
                                            ->maxValue(100)
                                            ->default(100)
                                            ->required()
                                            ->helperText('Percentage of ownership in this subsidiary'),
                                    ])
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => 
                                        isset($state['name']) ? 
                                        "{$state['name']} ({$state['ownership_percentage']}%)" : null
                                    )
                                    ->addActionLabel('Add Subsidiary')
                                    ->columns(2)
                                    ->helperText('Add subsidiary companies under this organization'),
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
                    ->defaultImageUrl(fn ($record) => 
                        'https://ui-avatars.com/api/?name='.urlencode($record->name).
                        '&color=FFFFFF&background='.str_replace('#', '', $record->color_code ?? '000000')
                    ),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Company Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => $record->location),
                
                Tables\Columns\TextColumn::make('reporting_date')
                    ->label('Report Date')
                    ->date('M d, Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('active_programs')
                    ->label('Sustainability')
                    ->badge()
                    ->color(fn (string $state): string => 
                        $state === 'None' ? 'gray' : 'success'
                    ),
                
                Tables\Columns\TextColumn::make('subsidiaryCompanies_count')
                    ->label('Subsidiaries')
                    ->counts('subsidiaryCompanies')
                    ->formatStateUsing(function ($state) {
                        return $state ? "{$state} " . str('subsidiary')->plural($state) : '—';
                    })
                    ->badge()
                    ->color(fn ($state) => $state == 0 ? 'gray' : 'primary')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sustainability_goals')
                    ->multiple()
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
                                $query->where($goal, true);
                            }
                        }
                    }),
                
                Tables\Filters\Filter::make('has_subsidiaries')
                    ->label('Has Subsidiaries')
                    ->query(fn (Builder $query): Builder => 
                        $query->whereHas('subsidiaryCompanies')
                    ),
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