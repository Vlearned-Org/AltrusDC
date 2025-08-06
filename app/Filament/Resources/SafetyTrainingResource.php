<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SafetyTrainingResource\Pages;
use App\Models\SafetyTraining;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SafetyTrainingResource extends Resource
{
    protected static ?string $model = SafetyTraining::class;

 
    protected static ?string $navigationGroup = 'Training Management';

    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Training Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('training_name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                
                                Forms\Components\TextInput::make('fiscal_year')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),
                        
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('training_hours')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->suffix('hours'),
                                       Forms\Components\TextInput::make('training_hours')
                                    ->required()
                                    ->label('Total Cost')
                                    ->numeric()
                                    ->minValue(0)
                                    ->suffix('shs'),
                                       Forms\Components\TextInput::make('training_hours')
                                    ->required()
                                    ->label('Cost Per Employee')
                                    ->numeric()
                                    ->minValue(0)
                                    ->suffix('shs'),
                                
                                Forms\Components\TextInput::make('participants_count')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->label('Participants'),
                                
                                Forms\Components\DateTimePicker::make('training_datetime')
                                    ->required()
                                    ->displayFormat('M j, Y g:i A'),
                            ]),
                    ]),
                
                Forms\Components\Section::make('Responsible Person')
                    ->schema([
                        Forms\Components\TextInput::make('pic_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Person in Charge'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('training_name')
                    ->searchable()
                    ->sortable()
                    ->label('Training Program'),
                
                Tables\Columns\TextColumn::make('fiscal_year')
                    ->searchable()
                    ->sortable()
                    ->label('Fiscal Year')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('training_hours')
                    ->numeric()
                    ->sortable()
                    ->label('Duration')
                    ->suffix(' hrs')
                    ->alignRight(),
                
                Tables\Columns\TextColumn::make('participants_count')
                    ->numeric()
                    ->sortable()
                    ->label('Participants')
                    ->alignRight(),
                
                Tables\Columns\TextColumn::make('training_datetime')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->label('Date & Time'),
                
                Tables\Columns\TextColumn::make('pic_name')
                    ->searchable()
                    ->label('Responsible')
                    ->toggleable(),
            ])
            ->defaultSort('training_datetime', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('fiscal_year')
                    ->options(
                        SafetyTraining::query()
                            ->pluck('fiscal_year', 'fiscal_year')
                            ->unique()
                            ->sort()
                            ->toArray()
                    )
                    ->label('Fiscal Year'),
                
                Tables\Filters\Filter::make('recent_trainings')
                    ->label('Recent Trainings')
                    ->query(fn (Builder $query): Builder => $query->where('training_datetime', '>=', now()->subMonths(3)))
                    ->toggle(),
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
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add New Training'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSafetyTrainings::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}