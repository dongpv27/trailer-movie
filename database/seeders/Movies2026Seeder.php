<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Movie;
use App\Models\Trailer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Movies2026Seeder extends Seeder
{
    public function run(): void
    {
        // Get categories
        $hanhDong = Category::where('slug', 'hanh-dong')->first();
        $kinhDi = Category::where('slug', 'kinh-di')->first();
        $haiHuoc = Category::where('slug', 'hai-huoc')->first();
        $vienTuong = Category::where('slug', 'vien-tuong')->first();
        $hoatHinh = Category::where('slug', 'hoat-hinh')->first();
        $biAn = Category::where('slug', 'bi-an')->first();
        $kichTinh = Category::where('slug', 'kich-tinh')->first();
        $tinhCam = Category::where('slug', 'tinh-cam')->first();
        $toiPham = Category::where('slug', 'toi-pham')->first();
        $phieuLuu = Category::where('slug', 'phieu-luu')->first();
        $giaDinh = Category::where('slug', 'gia-dinh')->first();
        $my = Category::where('slug', 'my')->first();
        $year2026 = Category::where('slug', '2026')->first();

        $movies = [
            // 1. The Odyssey - Hành Trình Odysseus
            [
                'title' => 'The Odyssey - Hành Trình Odysseus',
                'original_title' => 'The Odyssey',
                'slug' => 'the-odyssey-2026',
                'description' => 'Bộ sử thi Hy Lạp cổ đại được chuyển thể bởi Christopher Nolan, theo chân Odysseus trên hành trình trở về nhà sau chiến tranh Troy.',
                'poster' => 'https://image.tmdb.org/t/p/w500/jXJxMcVoEuXzym3vFnjqDW4ifo6.jpg',
                'content' => 'The Odyssey là bản chuyển thể điện ảnh của sử thi Hy Lạp cổ đại Odyssey do Homer sáng tác, dưới bàn tay đạo diễn tài ba Christopher Nolan. Phim kể về Odysseus, vua của Ithaca, người phải đối mặt với hàng loạt thử thách cam go trên hành trình 10 năm trở về nhà sau chiến tranh Troy. Từ quái vật Cyclops một mắt đến nữ thần Circe đầy mưu mô, mỗi chướng ngại vật đều thử thách trí tuệ và lòng dũng cảm của Odysseus. Được quay hoàn toàn bằng công nghệ IMAX film mới nhất, phim hứa hẹn mang đến trải nghiệm thị giác ngoạn mục với những bối cảnh hoành tráng và pha hành tính đỉnh cao.',
                'notable_points' => 'The Odyssey đánh dấu sự hợp tác lần đầu giữa Christopher Nolan và Universal Pictures. Với dàn cast toàn sao bao gồm Matt Damon, Tom Holland, Anne Hathaway, Robert Pattinson và Zendaya, phim được dự báo là một trong những bom tấn lớn nhất năm 2026.',
                'faq' => json_encode([
                    ['question' => 'Phim The Odyssey khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp từ ngày 17 tháng 7 năm 2026.'],
                    ['question' => 'Trailer phim The Odyssey đã ra chưa?', 'answer' => 'Đã có official trailer giới thiệu những cảnh quay hoành tráng.'],
                    ['question' => 'Phim The Odyssey thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, phiêu lưu, viễn tưởng.'],
                ]),
                'release_date' => '2026-07-17',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 168,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$hanhDong->id, $phieuLuu->id, $vienTuong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'Mzw2ttJD2qQ', 'is_main' => true],
                ],
            ],

            // 2. Toy Story 5 - Câu Chuyện Đồ Chơi 5
            [
                'title' => 'Toy Story 5 - Câu Chuyện Đồ Chơi 5',
                'original_title' => 'Toy Story 5',
                'slug' => 'toy-story-5-2026',
                'description' => 'Woody, Buzz và những người bạn phải đối mặt với thách thức mới từ công nghệ hiện đại.',
                'poster' => 'https://image.tmdb.org/t/p/w500/kGAI1p3mH5LqXeCjRcLxOGP7SY.jpg',
                'content' => 'Toy Story 5 đưa Woody, Buzz Lightyear và những người bạn đồ chơi trở lại với một thử thách hoàn toàn mới. Khi những thiết bị công nghệ hiện đại như máy tính bảng bắt đầu thay thế đồ chơi truyền thống, nhóm của Woody buộc phải tìm lại ý nghĩa của sự tồn tại mình. Phim giới thiệu nhân vật mới tên Lilypad và khám phá chủ đề "đồ chơi đối mặt với công nghệ" một cách hài hước nhưng sâu sắc. Với công nghệ hoạt hình đỉnh cao của Pixar, Toy Story 5 hứa hẹn mang lại những cảm xúc quen thuộc nhưng cũng đầy bất ngờ.',
                'notable_points' => 'Toy Story 5 là phần tiếp theo của thương hiệu hoạt hình thành công nhất Pixar. Phim do Andrew Stanton đạo diễn, với Tom Hanks và Tim Allen trở lại lồng tiếng cho Woody và Buzz.',
                'faq' => json_encode([
                    ['question' => 'Phim Toy Story 5 khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp từ ngày 19 tháng 6 năm 2026.'],
                    ['question' => 'Trailer phim Toy Story 5 đã ra chưa?', 'answer' => 'Đã có teaser trailer giới thiệu cốt truyện mới.'],
                    ['question' => 'Phim Toy Story 5 thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hoạt hình, hài hước, phiêu lưu, gia đình.'],
                ]),
                'release_date' => '2026-06-19',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 105,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$hoatHinh->id, $haiHuoc->id, $phieuLuu->id, $giaDinh->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Teaser Trailer', 'youtube_id' => 'GGBgf8dcgyY', 'is_main' => true],
                ],
            ],

            // 3. Scream 7 - Tiếng Thét 7
            [
                'title' => 'Scream 7 - Tiếng Thét 7',
                'original_title' => 'Scream 7',
                'slug' => 'scream-7-2026',
                'description' => 'Sidney Prescott trở lại khi Ghostface tấn công thị trấn Woodsboro một lần nữa.',
                'poster' => 'https://image.tmdb.org/t/p/w500/8C5kLxJ2NfJEJUbM7JMKEFgdVaQ.jpg',
                'content' => 'Scream 7 đánh dấu sự trở lại của Sidney Prescott (Neve Campbell) sau khi vắng mặt ở phần trước. Khi một kẻ giết người đeo mặt nạ Ghostface mới xuất hiện tại Woodsboro, Sidney buộc phải đối mặt với quá khứ và những bí mật được chôn vùi. Lần này, Ghostface không chỉ nhắm vào Sidney mà còn cả những người thân yêu của cô. Với sự kết hợp giữa yếu tố slasher kinh điển và những plot twist bất ngờ, Scream 7 hứa hẹn là phần kết đáng nhớ cho franchise kinh dị này.',
                'notable_points' => 'Scream 7 có sự trở lại của Neve Campbell trong vai Sidney Prescott cùng với Courteney Cox và David Arquette. Phim do Kevin Williamson đạo diễn - người viết kịch bản bản gốc năm 1996.',
                'faq' => json_encode([
                    ['question' => 'Phim Scream 7 khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp từ ngày 27 tháng 2 năm 2026.'],
                    ['question' => 'Trailer phim Scream 7 đã ra chưa?', 'answer' => 'Đã có official trailer giới thiệu sự trở lại của Sidney Prescott.'],
                    ['question' => 'Phim Scream 7 thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại kinh dị, giật gân, tội phạm.'],
                ]),
                'release_date' => '2026-02-27',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 115,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$kinhDi->id, $kichTinh->id, $toiPham->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'UJrghaPJ0RY', 'is_main' => true],
                ],
            ],

            // 4. Mortal Kombat II - Sát Chiến 2
            [
                'title' => 'Mortal Kombat II - Sát Chiến 2',
                'original_title' => 'Mortal Kombat II',
                'slug' => 'mortal-kombat-2-2026',
                'description' => 'Cole Young tiếp tục hành trình của mình tại giải đấu Mortal Kombat sinh tử.',
                'poster' => 'https://image.tmdb.org/t/p/w500/wRi7ES2PX5YnNnm7nLIPTFEs7rq.jpg',
                'content' => 'Mortal Kombat II tiếp tục hành trình của Cole Young sau sự kiện của phần trước. Khi Shao Khan - hoàng đế của Outworld - lên kế hoạch xâm lược Earthrealm, Cole và các chiến binh Earthrealm phải hợp tác để bảo vệ thế giới. Phim giới thiệu nhiều nhân vật mới từ game như Johnny Cage (do Karl Urban thủ vai), Kitana và Jade. Với những trận đấu đỉnh cao và hiệu ứng hình ảnh ấn tượng, Mortal Kombat II hứa hẹn mang lại trải nghiệm chân thực cho fan của thương hiệu game đối kháng nổi tiếng.',
                'notable_points' => 'Mortal Kombat II có sự tham gia của Karl Urban trong vai Johnny Cage - một trong những nhân vật được yêu thích nhất của series. Phim được quay theo định dạng IMAX để mang lại trải nghiệm tốt nhất.',
                'faq' => json_encode([
                    ['question' => 'Phim Mortal Kombat II khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp từ ngày 15 tháng 5 năm 2026.'],
                    ['question' => 'Trailer phim Mortal Kombat II đã ra chưa?', 'answer' => 'Đã có official trailer giới thiệu Johnny Cage.'],
                    ['question' => 'Phim Mortal Kombat II thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, phiêu lưu, viễn tưởng.'],
                ]),
                'release_date' => '2026-05-15',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 125,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$hanhDong->id, $phieuLuu->id, $kichTinh->id, $vienTuong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'HkTyjO4ryZo', 'is_main' => true],
                ],
            ],

            // 5. Avengers: Doomsday - Avengers: Ngày Tận Diệt
            [
                'title' => 'Avengers: Doomsday - Avengers: Ngày Tận Diệt',
                'original_title' => 'Avengers: Doomsday',
                'slug' => 'avengers-doomsday-2026',
                'description' => 'Các siêu anh hùng MCU đối mặt với Doctor Doom - mối đe dọa nguy hiểm nhất vũ trụ.',
                'poster' => 'https://image.tmdb.org/t/p/w500/j5JYRnRj0U3YGn3vYkMEcI8pOZ.jpg',
                'content' => 'Avengers: Doomsday đánh dấu sự khởi đầu của Chapter Sixth trong MCU. Khi Doctor Doom - một trong những phản diện mạnh nhất của Marvel - xuất hiện với kế hoạch thống trị toàn bộ đa vũ trụ, các Avengers phải reunited để đối mặt với mối đe dọa này. Phim có sự trở lại của nhiều siêu anh hùng kinh điển và cả những gương mặt mới từ các bộ phim trước đó. Với sự đạo diễn của Russo Brothers và quy mô sản xuất khổng lồ, Avengers: Doomsday hứa hẹn là một trong những bom tấn lớn nhất lịch sử điện ảnh.',
                'notable_points' => 'Avengers: Doomsday có sự tham gia của Robert Downey Jr. trong vai Doctor Doom - một sự casting gây tranh cãi nhưng cũng được mong chờ. Phim là khởi đầu cho Chapter Sixth của MCU.',
                'faq' => json_encode([
                    ['question' => 'Phim Avengers: Doomsday khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp từ ngày 18 tháng 12 năm 2026.'],
                    ['question' => 'Trailer phim Avengers: Doomsday đã ra chưa?', 'answer' => 'Đã có teaser trailer giới thiệu Doctor Doom.'],
                    ['question' => 'Phim Avengers: Doomsday thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, viễn tưởng, siêu anh hùng.'],
                ]),
                'release_date' => '2026-12-18',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 165,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$hanhDong->id, $vienTuong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Teaser Trailer', 'youtube_id' => '399Ez7WHK5s', 'is_main' => true],
                ],
            ],
        ];

        DB::beginTransaction();
        try {
            foreach ($movies as $movieData) {
                $categories = $movieData['categories'];
                $countryCat = $movieData['country_cat'];
                $trailers = $movieData['trailers'];

                unset($movieData['categories'], $movieData['country_cat'], $movieData['trailers']);

                $movie = Movie::updateOrCreate(
                    ['slug' => $movieData['slug']],
                    $movieData
                );

                // Attach categories
                foreach ($categories as $catId) {
                    $movie->categories()->syncWithoutDetaching([$catId]);
                }
                $movie->categories()->syncWithoutDetaching([$countryCat]);
                if ($year2026) {
                    $movie->categories()->syncWithoutDetaching([$year2026->id]);
                }

                // Create trailers
                foreach ($trailers as $trailerData) {
                    $trailerData['published_at'] = $movie->published_at;
                    $trailerData['slug'] = $movie->slug . '-' . str()->slug($trailerData['title']);
                    $movie->trailers()->updateOrCreate(
                        ['youtube_id' => $trailerData['youtube_id']],
                        $trailerData
                    );
                }

                $this->command->info("Seeded movie: {$movie->title}");
            }

            DB::commit();
            $this->command->info('Movies 2026 seeded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error seeding movies: ' . $e->getMessage());
            throw $e;
        }
    }
}
