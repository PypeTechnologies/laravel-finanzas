<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlowResource\Pages;
use App\Filament\Resources\FlowResource\RelationManagers;
use App\Models\Category;
use App\Models\Flow;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class FlowResource extends Resource
{
    protected static ?string $model = Flow::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Category Name')
                            ->placeholder('Enter category name')
                            ->maxLength(255)
                            ->columns(2),
                        Forms\Components\Select::make('type')
                            ->label('Category Type')
                            ->placeholder('Select category type')
                            ->options([
                                'ingreso' => 'Ingreso',
                                'gasto' => 'Gasto',
                            ])
                            ->required()
                            ->columns(2),

                    ])
                    ->required(),
                /*Forms\Components\Select::make('category_id')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->required(),*/
                Forms\Components\Select::make('type')
                    ->label('Flow Type')
                    ->options([
                        'ingreso' => 'Ingreso',
                        'gasto' => 'Gasto',
                    ])
                    ->placeholder('Select flow type')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\RichEditor::make('description')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('photo')
                    ->label('Upload Photo')
                    ->image()
                    ->directory('photos')
                    ->preserveFilenames()
                    ->directory('flows')
                    ->maxSize(2048), // 2MB
                Forms\Components\DateTimePicker::make('date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('#')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Flow Type')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(10)
                    ->searchable(),
                Tables\Columns\ImageColumn::make('photo')
                    ->width(40)
                    ->height(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'ingreso' => 'Ingreso',
                        'gasto' => 'Gasto',
                    ])
                    ->label('Flow Type'),
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User'),
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category'),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFlows::route('/'),
            'create' => Pages\CreateFlow::route('/create'),
            'edit' => Pages\EditFlow::route('/{record}/edit'),
        ];
    }
}
