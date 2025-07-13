<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttachmentResource\Pages;
use App\Filament\Resources\AttachmentResource\RelationManagers;
use App\Models\Attachment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttachmentResource extends Resource
{
    protected static ?string $model = Attachment::class;
    protected static ?string $navigationGroup = 'System';
    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Attachment Information')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('attachable_type')
                            ->required()
                            ->maxLength(255)
                            ->label('Attached To Type')
                            ->helperText('The model type this attachment belongs to'),
                            
                        Forms\Components\TextInput::make('attachable_id')
                            ->required()
                            ->numeric()
                            ->label('Attached To ID')
                            ->helperText('The ID of the related model'),
                            
                        Forms\Components\TextInput::make('file_type')
                            ->required()
                            ->maxLength(255)
                            ->label('File Type')
                            ->helperText('The MIME type of the file'),
                    ]),
                    
                Forms\Components\Section::make('File Details')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('file_path')
                            ->required()
                            ->maxLength(255)
                            ->label('File Path')
                            ->helperText('The storage path of the file'),
                            
                        Forms\Components\TextInput::make('file_name')
                            ->required()
                            ->maxLength(255)
                            ->label('File Name')
                            ->helperText('The original name of the uploaded file'),
                            
                        Forms\Components\TextInput::make('file_size')
                            ->required()
                            ->numeric()
                            ->label('File Size (bytes)')
                            ->helperText('Size of the file in bytes'),
                    ]),
                    
                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->helperText('Optional notes about this attachment')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('attachable_type')
                    ->label('Attached To')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('attachable_id')
                    ->label('Reference ID')
                    ->numeric()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('file_name')
                    ->label('File Name')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('file_type')
                    ->label('Type')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('file_size')
                    ->label('Size')
                    ->formatStateUsing(fn ($state) => round($state / 1024) . ' KB')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ManageAttachments::route('/'),
        ];
    }
}