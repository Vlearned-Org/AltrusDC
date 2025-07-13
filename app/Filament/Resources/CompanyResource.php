<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Company Management';
    protected static ?string $navigationLabel = 'Companies';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->description('Core company details')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2)
                            ->label('Company Name')
                            ->helperText('The legal name of the company'),
                            
                        Forms\Components\TextInput::make('location')
                            ->required()
                            ->maxLength(255)
                            ->label('Headquarters Location')
                            ->helperText('Primary office or headquarters address'),
                            
                        Forms\Components\TextInput::make('reporting_date')
                            ->required()
                            ->maxLength(255)
                            ->label('Fiscal Year End')
                            ->helperText('Format: YYYY-MM-DD or Month DD'),
                            
                        Forms\Components\ColorPicker::make('color_code')
                            ->required()
                            ->label('Brand Color')
                            ->helperText('Primary color for company branding'),
                            
                        Forms\Components\FileUpload::make('logo_path')
                            ->label('Company Logo')
                            ->directory('company-logos')
                            ->image()
                            ->maxSize(2048)
                            ->helperText('Upload company logo (max 2MB)')
                            ->columnSpan(2),
                    ]),
                    
                Forms\Components\Section::make('Company Statements')
                    ->description('Mission, vision and commitments')
                    ->schema([
                        Forms\Components\Textarea::make('mission')
                            ->label('Mission Statement')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Describe the company\'s purpose and objectives'),
                            
                        Forms\Components\Textarea::make('vision')
                            ->label('Vision Statement')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Describe the company\'s long-term aspirations'),
                            
                        Forms\Components\Textarea::make('sustainability_commitment')
                            ->label('Sustainability Commitment')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Describe the company\'s ESG commitments'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->circular()
                    ->defaultImageUrl(fn () => asset('images/default-company.png')),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Company Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                    
                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('reporting_date')
                    ->label('Fiscal Year End')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\ColorColumn::make('color_code')
                    ->label('Brand Color')
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('location')
                    ->options(fn () => Company::query()->pluck('location', 'location')->unique())
                    ->searchable()
                    ->label('Filter by Location'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil')
                    ->color('primary'),
                    
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected'),
                ]),
            ])
            ->defaultSort('name', 'asc')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add New Company'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCompanies::route('/'),
            
        ];
    }
}