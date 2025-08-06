<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingResource\Pages;
use App\Filament\Resources\TrainingResource\RelationManagers;
use App\Models\Training;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainingResource extends Resource
{
    protected static ?string $model = Training::class;
   
    protected static ?string $recordTitleAttribute = 'training_category';
    protected static ?string $navigationGroup = 'Training Management';
    protected static ?string $modelLabel = 'Training';
    protected static ?string $navigationLabel = 'Training';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Training Information')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('pic_name')
                                    ->maxLength(255)
                                    ->default(null)
                                    ->label('Person In Charge')
                                    ->helperText('Name of the training organizer'),
                                
                                Forms\Components\TextInput::make('training_category')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Training Category')
                                    ->helperText('Type or classification of training'),
                                
                                Forms\Components\TextInput::make('fiscal_year')
                                    ->required()
                                    ->maxLength(10)
                                    ->label('Fiscal Year')
                                    ->helperText('Financial year when training occurred'),
                            ]),
                    ]),
                
                Forms\Components\Section::make('Training Details')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('training_hours')
                                    ->numeric()
                                    ->default(null)
                                    ->label('Duration (Hours)')
                                    ->helperText('Hours per participant')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        self::updateAllCalculations($set, $get);
                                    }),
                                
                                Forms\Components\TextInput::make('total_participants')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated()
                                    ->label('Total Participants')
                                    ->helperText('Auto-calculated total participants'),
                                
                                Forms\Components\TextInput::make('total_training_hours')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated()
                                    ->label('Total Training Hours')
                                    ->helperText('Auto-calculated total hours'),
                            ]),
                    ]),
                
                Forms\Components\Section::make('Participant Breakdown')
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('management')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        self::updateAllCalculations($set, $get);
                                    })
                                    ->label('Management')
                                    ->helperText('Management-level participants'),
                                
                                Forms\Components\TextInput::make('executive')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        self::updateAllCalculations($set, $get);
                                    })
                                    ->label('Executives')
                                    ->helperText('Executive-level participants'),
                                
                                Forms\Components\TextInput::make('non_executive')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        self::updateAllCalculations($set, $get);
                                    })
                                    ->label('Non-Executives')
                                    ->helperText('Non-executive participants'),
                                
                                Forms\Components\TextInput::make('general_worker')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        self::updateAllCalculations($set, $get);
                                    })
                                    ->label('General Workers')
                                    ->helperText('General worker participants'),
                            ]),
                    ]),
                
                Forms\Components\Section::make('Training Hours Breakdown')
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('management_hours')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated()
                                    ->label('Management Hours')
                                    ->helperText('Management hours = Participants × Duration'),
                                
                                Forms\Components\TextInput::make('executive_hours')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated()
                                    ->label('Executive Hours')
                                    ->helperText('Executive hours = Participants × Duration'),
                                
                                Forms\Components\TextInput::make('non_executive_hours')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated()
                                    ->label('Non-Exec Hours')
                                    ->helperText('Non-exec hours = Participants × Duration'),
                                
                                Forms\Components\TextInput::make('general_worker_hours')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated()
                                    ->label('General Worker Hours')
                                    ->helperText('Worker hours = Participants × Duration'),
                            ]),
                    ]),
            ]);
    }

    protected static function updateAllCalculations(Forms\Set $set, Forms\Get $get): void
    {
        $trainingHours = (float)$get('training_hours');
        $management = (int)$get('management');
        $executive = (int)$get('executive');
        $nonExecutive = (int)$get('non_executive');
        $generalWorker = (int)$get('general_worker');

        // Calculate total participants
        $totalParticipants = $management + $executive + $nonExecutive + $generalWorker;
        $set('total_participants', $totalParticipants);

        // Calculate hours for each category
        $set('management_hours', $management * $trainingHours);
        $set('executive_hours', $executive * $trainingHours);
        $set('non_executive_hours', $nonExecutive * $trainingHours);
        $set('general_worker_hours', $generalWorker * $trainingHours);

        // Calculate total training hours
        $totalTrainingHours = ($management + $executive + $nonExecutive + $generalWorker) * $trainingHours;
        $set('total_training_hours', $totalTrainingHours);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('training_category')
                    ->searchable()
                    ->label('Training Category')
                    ->sortable()
                    ->description(fn ($record) => $record->fiscal_year)
                    ->wrap(),
                
                Tables\Columns\TextColumn::make('pic_name')
                    ->searchable()
                    ->label('Person In Charge')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('training_hours')
                    ->numeric(1)
                    ->label('Hours Each')
                    ->sortable()
                    ->alignEnd()
                    ->description('Per participant'),
                
                Tables\Columns\TextColumn::make('total_participants')
                    ->numeric()
                    ->label('Participants')
                    ->sortable()
                    ->color('success')
                    ->alignEnd(),
                
                Tables\Columns\TextColumn::make('total_training_hours')
                    ->numeric(1)
                    ->label('Total Hours')
                    ->sortable()
                    ->color('primary')
                    ->weight('bold')
                    ->alignEnd(),
                
                Tables\Columns\TextColumn::make('management')
                    ->numeric()
                    ->label('Mgmt')
                    ->sortable()
                    ->color('primary')
                    ->alignEnd()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('executive')
                    ->numeric()
                    ->label('Exec')
                    ->sortable()
                    ->color('info')
                    ->alignEnd()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('non_executive')
                    ->numeric()
                    ->label('Non-Exec')
                    ->sortable()
                    ->color('warning')
                    ->alignEnd()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('general_worker')
                    ->numeric()
                    ->label('Workers')
                    ->sortable()
                    ->color('gray')
                    ->alignEnd()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->label('Created')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('training_category')
                    ->options(fn () => Training::distinct('training_category')->pluck('training_category', 'training_category'))
                    ->searchable()
                    ->label('Training Type'),
                
                Tables\Filters\SelectFilter::make('fiscal_year')
                    ->options(fn () => Training::distinct('fiscal_year')->pluck('fiscal_year', 'fiscal_year'))
                    ->searchable()
                    ->label('Fiscal Year'),
                
                Tables\Filters\Filter::make('participants_range')
                    ->form([
                        Forms\Components\TextInput::make('min_participants')
                            ->numeric()
                            ->label('Min Participants'),
                        Forms\Components\TextInput::make('max_participants')
                            ->numeric()
                            ->label('Max Participants'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['min_participants'],
                                fn ($query, $value) => $query->where('total_participants', '>=', $value)
                            )
                            ->when($data['max_participants'],
                                fn ($query, $value) => $query->where('total_participants', '<=', $value)
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit Training'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Delete Training'),
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->tooltip('View Details'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->groups([
                Tables\Grouping\Group::make('fiscal_year')
                    ->label('By Fiscal Year')
                    ->collapsible(),
            ])
            ->emptyStateHeading('No trainings found')
            ->emptyStateDescription('Create your first training record')
            ->emptyStateIcon('heroicon-o-academic-cap')
            ->deferLoading()
            ->persistFiltersInSession()
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTrainings::route('/'),
        ];
    }
}