<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Movie;
use App\Models\Trailer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy categories
        $hanhDong = Category::where('slug', 'hanh-dong')->first();
        $kinhDi = Category::where('slug', 'kinh-di')->first();
        $haiHuoc = Category::where('slug', 'hai-huoc')->first();
        $tinhCam = Category::where('slug', 'tinh-cam')->first();
        $vienTuong = Category::where('slug', 'vien-tuong')->first();
        $hoatHinh = Category::where('slug', 'hoat-hinh')->first();
        $phieuLuu = Category::where('slug', 'phieu-luu')->first();
        $toiPham = Category::where('slug', 'toi-pham')->first();
        $chienTranh = Category::where('slug', 'chien-tranh')->first();

        $vietNam = Category::where('slug', 'viet-nam')->first();
        $hanQuoc = Category::where('slug', 'han-quoc')->first();
        $my = Category::where('slug', 'my')->first();
        $trungQuoc = Category::where('slug', 'trung-quoc')->first();
        $nhatBan = Category::where('slug', 'nhat-ban')->first();
        $anh = Category::where('slug', 'anh')->first();

        // Poster URLs từ nhiều nguồn (TMDB, fanart, OMDb)
        // Dùng CDN ổn định: image.tmdb.org, webservice.fanart.tv
        $movies = [
            // PHIM HOT - Mới nổi bật
            [
                'title' => 'Captain America: Brave New World',
                'original_title' => 'Captain America: Brave New World',
                'slug' => 'captain-america-brave-new-world',
                'description' => 'Anthony Mackie đóng vai Sam Wilson chính thức trở thành Captain America. Anh phải đối mặt với một sự đe dọa toàn cầu sau khi gặp gỡ Tổng thống Thaddeus Ross.',
                'poster' => 'https://image.tmdb.org/t/p/original/8xW47W6bqFKJfBrhvQPSZ6YoI.jpg',
                'content' => 'Captain America: Brave New World xoay quanh Sam Wilson, người chính thức nhận lại tấm khiên Captain America. Trong bối cảnh thế giới MCU thay đổi sau các sự kiện trước đó, Sam phải đối mặt với những thách thức mới khi Tổng thống Thaddeus Ross lộ diện dạng thú của mình - Red Hulk. Bộ phim khai thác cuộc chiến nội bộ và áp lực của việc trở thành biểu tượng mới, mang đến những yếu tố hành động đặc trưng của Marvel.',
                'notable_points' => 'Captain America: Brave New World là một trong những bộ phim MCU đáng chú ý năm 2025, đặc biệt với sự xuất hiện của Red Hulk và Harrison Ford trong vai Tổng thống Ross. Phim đánh dấu chương mới của Captain America với Anthony Mackie.',
                'faq' => json_encode([
                    ['question' => 'Phim Captain America: Brave New World khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 14 tháng 2 năm 2025.'],
                    ['question' => 'Trailer phim Captain America: Brave New World đã ra chưa?', 'answer' => 'Đã có 2 official trailer và 1 teaser được công bố, giới thiệu Red Hulk và cốt truyện chính.'],
                    ['question' => 'Phim Captain America: Brave New World thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, viễn tưởng, siêu anh hùng của Marvel Studios.'],
                ]),
                'release_date' => '2025-02-14',
                'status' => 'hot',
                'country' => 'United States',
                'duration' => 118,
                'view_count' => 15420,
                'published_at' => now()->subDays(5),
                'categories' => [$hanhDong->id, $vienTuong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'V7o7LM17H0E', 'is_main' => true],
                ],
            ],
            [
                'title' => 'Mickey 17',
                'original_title' => 'Mickey 17',
                'slug' => 'mickey-17',
                'description' => 'Bộ phim khoa học viễn tưởng do Robert Pattinson starring. Một người đàn ông được tuyển dụng cho một nhiệm vụ nguy hiểm trên sao Hòa Bình.',
                'poster' => 'https://image.tmdb.org/t/p/w500/4HgbVMjrGUkPeeM1aeSq1C9LwF.jpg',
                'content' => 'Mickey 17 xoay quanh một người đàn ông được gọi là "Expendable" - người có thể được tái tạo sau khi chết. Được đạo diễn bởi Bong Joon-ho, bộ phim đặt câu chuyện trên sao Hòa Bình lạnh giá nơi Mickey được gửi đến để thực hiện các nhiệm vụ nguy hiểm. Khi một phiên bản của anh được kích hoạt sớm hơn dự kiến, hai Mickey cùng tồn tại và gây ra những rắc rối không ngờ.',
                'notable_points' => 'Mickey 17 là dự án được mong chờ nhất năm 2025 từ đạo diễn Bong Joon-ho - người đạt Oscar với Parasite. Phim kết hợp sci-fi với những comment xã hội đặc trưng.',
                'faq' => json_encode([
                    ['question' => 'Phim Mickey 17 khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại rạp từ ngày 31 tháng 1 năm 2025.'],
                    ['question' => 'Trailer phim Mickey 17 đã ra chưa?', 'answer' => 'Đã có official teaser giới thiệu concept phim và nhân vật chính.'],
                    ['question' => 'Phim Mickey 17 thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại khoa học viễn tưởng, drama, do Bong Joon-ho đạo diễn.'],
                ]),
                'release_date' => '2025-01-31',
                'status' => 'hot',
                'country' => 'United States',
                'duration' => 138,
                'view_count' => 12350,
                'published_at' => now()->subDays(10),
                'categories' => [$vienTuong->id, $hanhDong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Teaser', 'youtube_id' => 'mnJb5w1B8nU', 'is_main' => true],
                ],
            ],
            [
                'title' => 'Đấm Pó E3 - Vượt Lên Trên Cả Đời',
                'original_title' => 'Đấm Pó E3',
                'slug' => 'dam-po-e3',
                'description' => 'Phần tiếp theo của series phim Đấm Pó đình đám. Tuấn và nhóm bạn tiếp tục những cuộc phiêu lưu hài hước.',
                'content' => 'Đấm Pó E3 tiếp tục hành trình của Tuấn - chàng trai "đen đủi" nhưng luôn lạc quan. Trong phần này, Tuấn gặp phải một biến cố lớn khiến anh phải đối mặt với quá khứ và tìm cách thay đổi số phận của mình. Bộ phim vẫn giữ phong cách hài hước, châm biếm xã hội đặc trưng của series, với những tình huống oái oăm và bất ngờ.',
                'notable_points' => 'Đấm Pó E3 là phim Việt Nam được mong chờ nhất đầu năm 2025, nối tiếp thành công của hai phần trước. Phim thu hút khán giả trẻ với phong cách hài hước gần gũi.',
                'faq' => json_encode([
                    ['question' => 'Phim Đấm Pó E3 khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 7 tháng 2 năm 2025.'],
                    ['question' => 'Trailer phim Đấm Pó E3 đã ra chưa?', 'answer' => 'Đã có official trailer với những cảnh hài hước đặc trưng của series.'],
                    ['question' => 'Phim Đấm Pó E3 thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hài hước, hành động của điện ảnh Việt Nam.'],
                ]),
                'release_date' => '2025-02-07',
                'status' => 'hot',
                'country' => 'Việt Nam',
                'duration' => 105,
                'view_count' => 28930,
                'published_at' => now()->subDays(2),
                'categories' => [$haiHuoc->id, $hanhDong->id],
                'country_cat' => $vietNam->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'KICGyU0gPrE', 'is_main' => true],
                ],
            ],

            // PHIM SẮP CHIẾU
            [
                'title' => 'Thunderbolts*',
                'original_title' => 'Thunderbolts*',
                'slug' => 'thunderbolts',
                'description' => 'Đội quân những phản diện từ MCU hợp thành một nhóm bất đắc dĩ.',
                'poster' => 'https://image.tmdb.org/t/p/w500/tlz1iT9iFkJGURw1r9PV94w7Fg.jpg',
                'content' => 'Thunderbolts* xoay quanh nhóm những nhân vật trước đây là phản diện trong MCU, được tập hợp dưới danh nghĩa một đội đặc nhiệm. Bằng cách khai thác những nhân vật phức tạp như Yelena Belova, Bucky Barnes, và John Walker, bộ phim đặt câu hỏi về ranh giới giữa anh hùng và phản diện. Nhóm phải đối mặt với một kẻ thù mysterious và quyết định xem họ có thể trở thành người hùng hay sẽ quay lại con đường cũ.',
                'notable_points' => 'Thunderbolts* là một trong những bộ phim MCU được mong chờ nhất năm 2025, đặc biệt với sự trở lại của các nhân vật được yêu thích. Phim đánh dấu hướng đi mới của Marvel với các anti-heroes.',
                'faq' => json_encode([
                    ['question' => 'Phim Thunderbolts* khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 2 tháng 5 năm 2025.'],
                    ['question' => 'Trailer phim Thunderbolts* đã ra chưa?', 'answer' => 'Đã có official trailer giới thiệu các thành viên của nhóm.'],
                    ['question' => 'Phim Thunderbolts* thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, viễn tưởng, siêu anh hùng của Marvel Studios.'],
                ]),
                'release_date' => '2025-05-02',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 120,
                'view_count' => 8200,
                'published_at' => now()->subDays(15),
                'categories' => [$hanhDong->id, $vienTuong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'y2CiXq93Ja4', 'is_main' => true],
                ],
            ],
            [
                'title' => 'Lilo & Stitch (Live Action)',
                'original_title' => 'Lilo & Stitch',
                'slug' => 'lilo-and-stitch-2025',
                'description' => 'Bản live-action của bộ phim hoạt hình Disney kinh điển.',
                'poster' => null, // Chưa có poster chính thức
                'content' => 'Lilo & Stitch bản live-action kể về cô gái nhỏ Lilo sống với chị Nani tại Hawaii. Khi cô bé gặp và nuôi một sinh vật ngoài hành tinh tên là Stitch, cả hai cùng nhau học về ý nghĩa của gia đình - "ohana có nghĩa là gia đình, và gia đình không ai bị bỏ lại". Bộ phim tái hiện lại câu chuyện cảm động này với công nghệ hiện đại, giữ nguyên tinh thần của bản original.',
                'notable_points' => 'Lilo & Stitch live action là dự án Disney được mong chờ nhất năm 2025, đặc biệt với những fan của bản animated. Phim hứa hẹn mang lại những cảm xúc hoài niệm với công nghệ hiện đại.',
                'faq' => json_encode([
                    ['question' => 'Phim Lilo & Stitch khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 27 tháng 6 năm 2025.'],
                    ['question' => 'Trailer phim Lilo & Stitch đã ra chưa?', 'answer' => 'Đã có teaser trailer giới thiệu hình ảnh Stitch phiên bản live action.'],
                    ['question' => 'Phim Lilo & Stitch thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại gia đình, hài hước, phiêu lưu của Disney.'],
                ]),
                'release_date' => '2025-06-27',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 95,
                'view_count' => 5600,
                'published_at' => now()->subDays(8),
                'categories' => [$hoatHinh->id, $haiHuoc->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Teaser Trailer', 'youtube_id' => 'DgYPyjNQ0G8', 'is_main' => true],
                ],
            ],
            [
                'title' => 'Zombie 4 - Tập Đoàn Phục Sinh',
                'original_title' => 'Zombie 4',
                'slug' => 'zombie-4',
                'description' => 'Phần 4 của series phim Zombie Việt Nam đình đám.',
                'content' => 'Zombie 4 tiếp tục hành trình của nhóm bạn trẻ trong thế giới post-apocalyptic của Việt Nam. Lần này, họ phải đối mặt với một tập đoàn mới bí ẩn, những biến thể zombie mạnh hơn và những bí mật về nguồn gốc dịch bệnh. Với sự kết hợp giữa kinh dị, hài hước và cảm xúc, bộ phim mang lại những bất ngờ và các pha hành tính nghẹt thở.',
                'notable_points' => 'Zombie 4 là phim Việt Nam được mong chờ nhất năm 2025, tiếp nối thành công của 3 phần trước. Phim hứa hẹn mang lại những bất ngờ mới về cốt truyện.',
                'faq' => json_encode([
                    ['question' => 'Phim Zombie 4 khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 25 tháng 4 năm 2025.'],
                    ['question' => 'Trailer phim Zombie 4 đã ra chưa?', 'answer' => 'Đã có teaser trailer giới thiệu bối cảnh mới và biến thể zombie.'],
                    ['question' => 'Phim Zombie 4 thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại kinh dị, hài hước, hành động của điện ảnh Việt Nam.'],
                ]),
                'release_date' => '2025-04-25',
                'status' => 'upcoming',
                'country' => 'Việt Nam',
                'duration' => 98,
                'view_count' => 11200,
                'published_at' => now()->subDays(12),
                'categories' => [$kinhDi->id, $haiHuoc->id],
                'country_cat' => $vietNam->id,
                'trailers' => [
                    ['title' => 'Teaser Trailer', 'youtube_id' => 'tXN4zm6qX3g', 'is_main' => true],
                ],
            ],

            // PHIM ĐANG CHIẾU / ĐÃ CÓ - Có poster thật
            [
                'title' => 'Paddington in Peru',
                'original_title' => 'Paddington in Peru',
                'slug' => 'paddington-in-peru',
                'description' => 'Paddington trở lại trong một cuộc phiêu lưu mới tại Peru.',
                'poster' => 'https://image.tmdb.org/t/p/w500/tLL1embyunXkj7ySDcvrRrq51VE.jpg',
                'content' => 'Paddington in Peru follows the beloved bear as he returns to Peru to visit his Aunt Lucy at the Home for Retired Bears. When Lucy goes missing, Paddington and the Brown family embark on a journey through the Amazon rainforest to find her. The film explores themes of family, belonging, and adventure with warmth and humor characteristic of the franchise.',
                'notable_points' => 'Paddington in Peru là phần 3 của franchise được yêu thích, lần này khám phá quê hương Peru của chú gấu. Phim phù hợp cho cả gia đình với thông điệp ấm áp.',
                'faq' => json_encode([
                    ['question' => 'Phim Paddington in Peru khi nào chiếu?', 'answer' => 'Phim đã khởi chiếu tại các rạp Việt Nam từ ngày 17 tháng 1 năm 2025.'],
                    ['question' => 'Trailer phim Paddington in Peru đã ra chưa?', 'answer' => 'Đã có official trailer giới thiệu cuộc phiêu lưu tại Peru.'],
                    ['question' => 'Phim Paddington in Peru thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại gia đình, hài hước, phiêu lưu.'],
                ]),
                'release_date' => '2025-01-17',
                'status' => 'released',
                'country' => 'United Kingdom',
                'duration' => 106,
                'view_count' => 9800,
                'published_at' => now()->subMonths(2),
                'categories' => [$haiHuoc->id, $hoatHinh->id],
                'country_cat' => $anh->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => '6zVIXJB9uNc', 'is_main' => true],
                ],
            ],
            [
                'title' => 'Dog Man',
                'original_title' => 'Dog Man',
                'slug' => 'dog-man',
                'description' => 'Bộ phim hoạt hình từ DreamWorks dựa trên series sách tranh nổi tiếng.',
                'poster' => 'https://image.tmdb.org/t/p/w500/y7mLR4aXcOVKpnudtfPLxyVGgLR.jpg',
                'content' => 'Dog Man kể về Officer Knight và his dog Greg, sau khi một tai nạn phòng thí nghiệm, họ đã được phẫu thuật lại thành một sinh vật lai - Dog Man. Với cái đầu của chó và cơ thể của con người, Dog Man chiến tranh với tội phạm và học được bài học về tình bạn, sự trung thực và lòng tốt. Bộ phim mang phong cách hài hước đặc trưng của Dav Pilkey.',
                'notable_points' => 'Dog Man là adaptation của series sách tranh bán chạy nhất, được DreamWorks Animation đưa lên màn ảnh. Phim thu hút trẻ em và cả người lớn với phong cách độc đáo.',
                'faq' => json_encode([
                    ['question' => 'Phim Dog Man khi nào chiếu?', 'answer' => 'Phim đã khởi chiếu tại các rạp Việt Nam từ ngày 31 tháng 1 năm 2025.'],
                    ['question' => 'Trailer phim Dog Man đã ra chưa?', 'answer' => 'Đã có 2 official trailers giới thiệu nhân vật và cốt truyện.'],
                    ['question' => 'Phim Dog Man thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hoạt hình, hài hước, hành động của DreamWorks.'],
                ]),
                'release_date' => '2025-01-31',
                'status' => 'released',
                'country' => 'United States',
                'duration' => 93,
                'view_count' => 7650,
                'published_at' => now()->subMonth(),
                'categories' => [$hoatHinh->id, $haiHuoc->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer 2', 'youtube_id' => 'pLNqPoE8YgM', 'is_main' => true],
                ],
            ],
            [
                'title' => 'Wicked',
                'original_title' => 'Wicked',
                'slug' => 'wicked-2024',
                'description' => 'Phim musical adaptation của Broadway hit Wicked.',
                'poster' => 'https://image.tmdb.org/t/p/w500/lFSSLTlFozwpaGlO31OoUeirBgQ.jpg',
                'content' => 'Wicked tells the story of Elphaba, a young woman born with green skin who becomes the Wicked Witch of the West, and her complex friendship with Glinda, the Good Witch. Set in the Land of Oz before Dorothy\'s arrival, the film explores themes of friendship, identity, and prejudice through spectacular musical numbers. With Cynthia Erivo and Ariana Grande leading, the film brings the beloved Broadway production to life.',
                'notable_points' => 'Wicked là adaptation của Broadway musical kinh điển, với sự tham gia của Cynthia Erivo và Ariana Grande. Phim được mong chờ như musical event lớn nhất năm 2024-2025.',
                'faq' => json_encode([
                    ['question' => 'Phim Wicked khi nào chiếu?', 'answer' => 'Phim đã khởi chiếu tại các rạp Việt Nam từ tháng 11 năm 2024.'],
                    ['question' => 'Trailer phim Wicked đã ra chưa?', 'answer' => 'Đã có nhiều trailers và featurettes giới thiệu các bài hát trong phim.'],
                    ['question' => 'Phim Wicked thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại musical, fantasy, drama của Universal Pictures.'],
                ]),
                'release_date' => '2024-11-22',
                'status' => 'released',
                'country' => 'United States',
                'duration' => 160,
                'view_count' => 21300,
                'published_at' => now()->subMonths(3),
                'categories' => [$vienTuong->id, $haiHuoc->id, $tinhCam->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'eJlzLgb8L3o', 'is_main' => true],
                ],
            ],
            [
                'title' => 'Gladiator 2',
                'original_title' => 'Gladiator II',
                'slug' => 'gladiator-2',
                'description' => 'Phần tiếp theo của Gladiator (2000) do Ridley Scott đạo diễn.',
                'poster' => 'https://image.tmdb.org/t/p/w500/qhbJq8Ggbq4WCVu8SIzF48jJ1HV.jpg',
                'content' => 'Gladiator II takes place years after the original, following Lucius - the son of Lucilla and nephew of Commodus. Now grown and living in exile, Lucius must return to Rome as a gladiator to challenge the corrupt emperor. The film explores themes of power, revenge, and legacy in the brutal world of Roman arena, with Paul Mescal leading a cast including Pedro Pascal and Denzel Washington.',
                'notable_points' => 'Gladiator II là sequel được mong chờ nhất sau 24 năm, với Ridley Scott trở lại đạo diễn. Phim kết nối với bản gốc qua nhân vật Lucius.',
                'faq' => json_encode([
                    ['question' => 'Phim Gladiator 2 khi nào chiếu?', 'answer' => 'Phim đã khởi chiếu tại các rạp Việt Nam từ tháng 11 năm 2024.'],
                    ['question' => 'Trailer phim Gladiator 2 đã ra chưa?', 'answer' => 'Đã có official trailer với những cảnh đấu gladiator hoành tráng.'],
                    ['question' => 'Phim Gladiator 2 thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, drama, lịch sử của Paramount Pictures.'],
                ]),
                'release_date' => '2024-11-15',
                'status' => 'released',
                'country' => 'United States',
                'duration' => 148,
                'view_count' => 18900,
                'published_at' => now()->subMonths(4),
                'categories' => [$hanhDong->id, $chienTranh->id, $vienTuong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'FQe0O9RdJaI', 'is_main' => true],
                ],
            ],

            // THÊM CÁC PHIM ĐÃ CÓ POSTER THẬT
            [
                'title' => 'Dune: Part Two',
                'original_title' => 'Dune: Part Two',
                'slug' => 'dune-part-two',
                'description' => 'Phần tiếp theo của Dune (2021) do Denis Villeneuve đạo diễn.',
                'poster' => 'https://image.tmdb.org/t/p/w500/1pdfLvkbY9ohJlCjQH2CZjjYVvJ.jpg',
                'content' => 'Dune: Part Two tiếp tục hành trình của Paul Atreides trên sao Arrakis. Sau khi gia đình ông bị tiêu diệt, Paul gia nhập người Fremen để đấu tranh chống lại House Harkonnen. Bộ phim khai thác sâu hơn về chính trị, tôn giáo và sự báo thù trong vũ trụ Dune rộng lớn.',
                'notable_points' => 'Dune: Part Two là sequel được mong chờ nhất năm 2024, với hình ảnh spectacular và dàn diễn viên star. Phim hoàn thành câu chuyện bắt đầu từ phần đầu.',
                'faq' => json_encode([
                    ['question' => 'Phim Dune: Part Two khi nào chiếu?', 'answer' => 'Phim đã khởi chiếu tại các rạp Việt Nam từ tháng 2 năm 2024.'],
                    ['question' => 'Trailer phim Dune: Part Two đã ra chưa?', 'answer' => 'Đã có nhiều trailers showcasing hành động và cốt truyện.'],
                    ['question' => 'Phim Dune: Part Two thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại khoa học viễn tưởng, hành động, phiêu lưu.'],
                ]),
                'release_date' => '2024-02-29',
                'status' => 'released',
                'country' => 'United States',
                'duration' => 166,
                'view_count' => 25600,
                'published_at' => now()->subYear(),
                'categories' => [$hanhDong->id, $vienTuong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'Way9Dexny3w', 'is_main' => true],
                ],
            ],
            [
                'title' => 'Kung Fu Panda 4',
                'original_title' => 'Kung Fu Panda 4',
                'slug' => 'kung-fu-panda-4',
                'description' => 'Phần 4 của series Kung Fu Panda từ DreamWorks.',
                'poster' => 'https://image.tmdb.org/t/p/w500/kDp1vUBnMpe8ak4rjgl3cLELqjU.jpg',
                'content' => 'Kung Fu Panda 4 xoay quanh Po - gấu panda chiến binh được yêu thích. Lần này, Po được chọn làm trưởng tinh thần của Thung lũng Hòa Bình và phải tìm người kế nhiệm. Trong hành trình này, anh gặp được một con yêu tinh tên là Zhen và cùng nhau chống lại phù thủy xảo quyệt Chameleon.',
                'notable_points' => 'Kung Fu Panda 4 là phần tiếp theo của franchise DreamWorks yêu thích, với phong cách hoạt hình đẹp và hài hước. Phim phù hợp cho cả gia đình.',
                'faq' => json_encode([
                    ['question' => 'Phim Kung Fu Panda 4 khi nào chiếu?', 'answer' => 'Phim đã khởi chiếu tại các rạp Việt Nam từ tháng 3 năm 2024.'],
                    ['question' => 'Trailer phim Kung Fu Panda 4 đã ra chưa?', 'answer' => 'Đã có official trailer với những cảnh hành động hài hước.'],
                    ['question' => 'Phim Kung Fu Panda 4 thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hoạt hình, hài hước, hành động của DreamWorks.'],
                ]),
                'release_date' => '2024-03-08',
                'status' => 'released',
                'country' => 'United States',
                'duration' => 94,
                'view_count' => 18700,
                'published_at' => now()->subMonths(10),
                'categories' => [$hoatHinh->id, $haiHuoc->id, $hanhDong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'eM9kWwJQT5I', 'is_main' => true],
                ],
            ],
            [
                'title' => 'Godzilla x Kong: The New Empire',
                'original_title' => 'Godzilla x Kong: The New Empire',
                'slug' => 'godzilla-x-kong-new-empire',
                'description' => 'Hai quái vật khổng lồ Godzilla và Kong đoàn kết chống lại kẻ thù mới.',
                'poster' => 'https://image.tmdb.org/t/p/w500/z1p34vh7dEOnLDmyCrlUVLuoDzd.jpg',
                'content' => 'Godzilla x Kong: The New Empire tiếp tục câu chuyện của hai Titans khổng lồ. Lần này, Godzilla và Kong phải hợp tác để chống lại một thế lực đe dọa mới có thể tiêu diệt cả nhân loại. Bộ phim mang đến những trận chiến hoành tráng giữa các quái vật khổng lồ.',
                'notable_points' => 'Godzilla x Kong: The New Empire là sự kết hợp của hai franchise quái vật nổi tiếng, với những cảnh hành động spectacular và hiệu ứng visual đỉnh cao.',
                'faq' => json_encode([
                    ['question' => 'Phim Godzilla x Kong khi nào chiếu?', 'answer' => 'Phim đã khởi chiếu tại các rạp Việt Nam từ tháng 3 năm 2024.'],
                    ['question' => 'Trailer phim Godzilla x Kong đã ra chưa?', 'answer' => 'Đã có official trailer với những trận chiến giữa Godzilla và Kong.'],
                    ['question' => 'Phim Godzilla x Kong thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, viễn tưởng, quái vật.'],
                ]),
                'release_date' => '2024-03-29',
                'status' => 'released',
                'country' => 'United States',
                'duration' => 115,
                'view_count' => 14300,
                'published_at' => now()->subMonths(9),
                'categories' => [$hanhDong->id, $vienTuong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => '4OC2efVFpLc', 'is_main' => true],
                ],
            ],
            [
                'title' => 'Inside Out 2',
                'original_title' => 'Inside Out 2',
                'slug' => 'inside-out-2',
                'description' => 'Phần tiếp theo của Inside Out (2015) từ Pixar.',
                'poster' => 'https://image.tmdb.org/t/p/w500/vpnVM9B6NMmQpWeZvzLvDESb2QY.jpg',
                'content' => 'Inside Out 2 tiếp tục hành trình của Riley - hiện là một thiếu niên. Khi những cảm xúc mới xuất hiện như Anxiety (Lo âu), Envy (Ghen tị) và Ennui (Chán nản), nhóm cảm xúc cũ phải thích nghi với những thay đổi. Bộ phim khám phá sự phức tạp của cảm xúc con người trong giai đoạn trưởng thành.',
                'notable_points' => 'Inside Out 2 là sequel của phim Pixar kinh điển, với những nhân vật cảm xúc mới và thông điệp sâu sắc về sức khỏe tâm thần.',
                'faq' => json_encode([
                    ['question' => 'Phim Inside Out 2 khi nào chiếu?', 'answer' => 'Phim đã khởi chiếu tại các rạp Việt Nam từ tháng 6 năm 2024.'],
                    ['question' => 'Trailer phim Inside Out 2 đã ra chưa?', 'answer' => 'Đã có official trailer giới thiệu các cảm xúc mới.'],
                    ['question' => 'Phim Inside Out 2 thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hoạt hình, hài hước, gia đình của Pixar.'],
                ]),
                'release_date' => '2024-06-14',
                'status' => 'released',
                'country' => 'United States',
                'duration' => 96,
                'view_count' => 22100,
                'published_at' => now()->subMonths(6),
                'categories' => [$hoatHinh->id, $haiHuoc->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'V8eCrJY34_A', 'is_main' => true],
                ],
            ],
            [
                'title' => 'Deadpool & Wolverine',
                'original_title' => 'Deadpool & Wolverine',
                'slug' => 'deadpool-wolverine',
                'description' => 'Deadpool và Wolverine hợp tác trong phim MCU đầu tiên của họ.',
                'poster' => 'https://image.tmdb.org/t/p/w500/8cdWjvZQUExUUTzyp4t6EDMubfO.jpg',
                'content' => 'Deadpool & Wolverine kết hợp hai nhân vật X-Men nổi tiếng trong một cuộc phiêu lưu thời gian. Sau khi Wolverine được tìm thấy trong một timeline khác, Deadpool phải thuyết phục anh gia nhập MCU và cùng nhau chống lại Paradox - một đặc vụ của TVA với những plan nguy hiểm.',
                'notable_points' => 'Deadpool & Wolverine là phim MCU được mong chờ nhất năm 2024, đánh dấu sự trở lại của Wolverine và Deadpool trong MCU. Phim có nhiều cameo và easter eggs.',
                'faq' => json_encode([
                    ['question' => 'Phim Deadpool & Wolverine khi nào chiếu?', 'answer' => 'Phim đã khởi chiếu tại các rạp Việt Nam từ tháng 7 năm 2024.'],
                    ['question' => 'Trailer phim Deadpool & Wolverine đã ra chưa?', 'answer' => 'Đã có nhiều trailers showcasing chemistry giữa Deadpool và Wolverine.'],
                    ['question' => 'Phim Deadpool & Wolverine thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, hài hước, siêu anh hùng của Marvel Studios.'],
                ]),
                'release_date' => '2024-07-26',
                'status' => 'released',
                'country' => 'United States',
                'duration' => 128,
                'view_count' => 28900,
                'published_at' => now()->subMonths(5),
                'categories' => [$hanhDong->id, $haiHuoc->id, $vienTuong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'F1633LlGe-4', 'is_main' => true],
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
            $this->command->info('Movies seeded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error seeding movies: ' . $e->getMessage());
            throw $e;
        }
    }
}
