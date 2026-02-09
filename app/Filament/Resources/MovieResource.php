<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Filament\Resources\MovieResource\RelationManagers;
use App\Models\Movie;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Tables;
use Filament\Tables\Table;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationLabel = 'Phim';

    protected static ?string $modelLabel = 'Phim';

    protected static ?string $pluralModelLabel = 'Phim';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('MovieTabs')
                    ->tabs([
                        Tabs\Tab::make('Thông tin chính')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Tên phim')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('original_title')
                                    ->label('Tên gốc')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->label('Mô tả')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Forms\Components\DatePicker::make('release_date')
                                    ->label('Ngày phát hành'),
                                Forms\Components\Select::make('status')
                                    ->label('Trạng thái')
                                    ->options([
                                        'hot' => 'Hot',
                                        'upcoming' => 'Sắp chiếu',
                                        'released' => 'Đang chiếu',
                                    ])
                                    ->default('released')
                                    ->required(),
                                Forms\Components\TextInput::make('country')
                                    ->label('Quốc gia')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('duration')
                                    ->label('Thời lượng (phút)')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\TextInput::make('director')
                                    ->label('Đạo diễn')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('cast')
                                    ->label('Diễn viên chính')
                                    ->rows(2)
                                    ->helperText('Các diễn viên chính, ngăn cách bằng dấu phẩy'),
                            ])->columns(2),

                        Tabs\Tab::make('Hình ảnh')
                            ->schema([
                                Forms\Components\FileUpload::make('poster')
                                    ->label('Poster')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('posters')
                                    ->visibility('public'),
                                Forms\Components\FileUpload::make('backdrop')
                                    ->label('Backdrop')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('backdrops')
                                    ->visibility('public'),
                            ])->columns(2),

                        Tabs\Tab::make('Trailers')
                            ->schema([
                                Forms\Components\Repeater::make('trailers')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Tiêu đề')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('youtube_id')
                                            ->label('YouTube ID')
                                            ->required()
                                            ->maxLength(255)
                                            ->hint('VD: dQw4w9WgXcQ'),
                                        Forms\Components\FileUpload::make('thumbnail')
                                            ->label('Thumbnail')
                                            ->image()
                                            ->directory('thumbnails')
                                            ->visibility('public'),
                                        Forms\Components\Toggle::make('is_main')
                                            ->label('Trailer chính')
                                            ->default(false),
                                    ])
                                    ->orderable('sort')
                                    ->defaultItems(1)
                                    ->columns(2),
                            ]),

                        Tabs\Tab::make('Thể loại')
                            ->schema([
                                Forms\Components\Select::make('categories')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->label('Danh mục')
                                    ->searchable(),
                            ]),

                        Tabs\Tab::make('Nơi xem')
                            ->schema([
                                Forms\Components\Select::make('streamings')
                                    ->relationship('streamings', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->label('Nền tảng')
                                    ->searchable(),
                            ]),

                        Tabs\Tab::make('Thông tin thêm')
                            ->schema([
                                Forms\Components\TextInput::make('view_count')
                                    ->label('Lượt xem')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Ngày đăng'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('poster')
                    ->label('Poster')
                    ->circular()
                    ->defaultImageUrl(url('/images/no-poster.png')),
                Tables\Columns\TextColumn::make('title')
                    ->label('Tên phim')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('original_title')
                    ->label('Tên gốc')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'hot' => 'danger',
                        'upcoming' => 'warning',
                        'released' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('release_date')
                    ->label('Ngày phát hành')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('view_count')
                    ->label('Lượt xem')
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Ngày đăng')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'hot' => 'Hot',
                        'upcoming' => 'Sắp chiếu',
                        'released' => 'Đang chiếu',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Không có phim nào')
            ->emptyStateDescription('Chưa có dữ liệu phim. Hãy tạo phim mới.')
            ->emptyStateIcon('heroicon-o-film')
            ->defaultSort('release_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StreamingRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }
}
