<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Movie;
use App\Models\Trailer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Movies2025Seeder extends Seeder
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
        $my = Category::where('slug', 'my')->first();
        $trungQuoc = Category::where('slug', 'trung-quoc')->first();

        $movies = [
            // 1. Avatar: Lửa và Tro Tàn (Avatar: Fire and Ash)
            [
                'title' => 'Avatar: Lửa và Tro Tàn',
                'original_title' => 'Avatar: Fire and Ash',
                'slug' => 'avatar-fire-and-ash-2025',
                'description' => 'Jake Sully và Neytiri phải đối mặt với mối đe dọa mới từ bộ tộc "Tro Tán" hùng mạnh.',
                'poster' => 'https://image.tmdb.org/t/p/w500/w6DBmG260sCHBQdGzkBIVn9gAQZ.jpg',
                'content' => 'Avatar: Lửa và Tro Tàn tiếp tục hành trình của Jake Sully và Neytiri trên Pandora sau các sự kiện của hai phần trước. Lần này, họ phải đối mặt với bộ tộc "Tro Tán" (Ash People) - một nền văn minh mới với khả năng điều khiển lửa đáng sợ. Bộ phim khai thác sâu hơn về văn hóa Pandora và những bí mật còn ẩn giấu trong thế giới này. Với James Cameron tiếp tục đạo diễn, phim hứa hẹn mang lại những hình ảnh spectacular chưa từng có.',
                'notable_points' => 'Avatar: Lửa và Tro Tàn là phần 3 của franchise Avatar đình đám, đánh dấu sự trở lại của James Cameron sau 5 năm. Phim có sự tham gia của dàn diễn viên star như Sam Worthington, Zoe Saldaña và Sigourney Weaver.',
                'faq' => json_encode([
                    ['question' => 'Phim Avatar: Lửa và Tro Tàn khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 17 tháng 12 năm 2025.'],
                    ['question' => 'Trailer phim Avatar: Lửa và Tro Tàn đã ra chưa?', 'answer' => 'Đã có teaser trailer giới thiệu về bộ tộc Tro Tán và mối đe dọa mới.'],
                    ['question' => 'Phim Avatar: Lửa và Tro Tàn thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại khoa học viễn tưởng, phiêu lưu, hành động.'],
                ]),
                'release_date' => '2025-12-17',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 198,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$vienTuong->id, $hanhDong->id],
                'country_cat' => $my->id,
                'trailers' => [
                    ['title' => 'Official Teaser', 'youtube_id' => 'wIiASgAkk7g', 'is_main' => true],
                ],
            ],

            // 2. Phi Vụ Động Trời 2 (Zootopia 2)
            [
                'title' => 'Phi Vụ Động Trời 2',
                'original_title' => 'Zootopia 2',
                'slug' => 'phi-vu-dong-troi-2-2025',
                'description' => 'Hai thám tử Judy Hopps và Nick Wilde bước vào hành trình truy tìm một sinh vật bò sát bí ẩn.',
                'poster' => 'https://image.tmdb.org/t/p/w500/5wXpOF9WPUKliIzNBdAqwAStLHU.jpg',
                'content' => 'Phi Vụ Động Trời 2 đưa Judy Hopps và Nick Wilde trở lại với một trường hợp mới. Khi một sinh vật bò sát bí ẩn xuất hiện tại Zootopia, hai thám tử phải hợp tác để giải quyết vụ án trước khi thành phố rơi vào hỗn loạn. Bộ phim tiếp tục khai thác các chủ đề về sự khác biệt và định kiến một cách hài hước nhưng sâu sắc. Với đồ họa đẹp và câu chuyện hấp dẫn, Zootopia 2 sẽ làm hài lòng cả người lớn và trẻ em.',
                'notable_points' => 'Phi Vụ Động Trời 2 là phần tiếp theo của phim hoạt hình Disney năm 2016, với sự trở lại của Ginnifer Goodwin và Jason Bateman lồng tiếng. Phim do Byron Howard và Jared Bush đạo diễn.',
                'faq' => json_encode([
                    ['question' => 'Phim Phi Vụ Động Trời 2 khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 26 tháng 11 năm 2025.'],
                    ['question' => 'Trailer phim Phi Vụ Động Trời 2 đã ra chưa?', 'answer' => 'Đã có teaser trailer giới thiệu về cốt truyện mới.'],
                    ['question' => 'Phim Phi Vụ Động Trời 2 thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hoạt hình, hài hước, phiêu lưu, gia đình.'],
                ]),
                'release_date' => '2025-11-26',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 108,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$hoatHinh->id, $haiHuoc->id],
                'country_cat' => $my->id,
                'trailers' => [],
            ],

            // 3. 96 Phút Sinh Tử
            [
                'title' => '96 Phút Sinh Tử',
                'original_title' => '96分鐘',
                'slug' => '96-phut-sinh-tu-2025',
                'description' => 'Ba năm sau thảm kịch tại trung tâm mua sắm, nữ cảnh sát Huỳnh Hân và chồng cô giải quyết quả bom trên tàu cao tốc.',
                'poster' => 'https://image.tmdb.org/t/p/w500/2LyuWRgvXs5vWAqz23I8DE7hBHf.jpg',
                'content' => '96 Phút Sinh Tử xoay quanh Huỳnh Hân, một nữ cảnh sát đặc nhiệm, ba năm sau sự kiện đau thương tại trung tâm mua sắm. Khi cô và chồng - cựu chuyên gia gỡ bom Tống Khang Nhân - lên một chuyến tàu cao tốc định mệnh, họ bất ngờ nhận được tin nhắn về một quả bom đã được cài sẵn. Trong 96 phút, họ phải race against time để giải quyết bom và cứu hành khách.',
                'notable_points' => '96 Phút Sinh Tử là phim hành động gay cấn từ đạo diễn Hùng Tự Hoàn, với diễn viên chính bao gồm Lâm Bạc Bồng, Tống Vân Nghi và Dương Dương. Phim được xem là remake của phim The Last Bullet (2024).',
                'faq' => json_encode([
                    ['question' => 'Phim 96 Phút Sinh Tử khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 5 tháng 9 năm 2025.'],
                    ['question' => 'Trailer phim 96 Phút Sinh Tử đã ra chưa?', 'answer' => 'Đã có official trailer giới thiệu những pha hành động nghẹt thở.'],
                    ['question' => 'Phim 96 Phút Sinh Tử thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, hình sự, giật gân.'],
                ]),
                'release_date' => '2025-09-05',
                'status' => 'upcoming',
                'country' => 'Trung Quốc',
                'duration' => 119,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$hanhDong->id, $toiPham->id, $tinhCam->id],
                'country_cat' => $trungQuoc->id,
                'trailers' => [
                    ['title' => 'Official Trailer', 'youtube_id' => 'MilLkfIAFWw', 'is_main' => true],
                ],
            ],

            // 4. Bổ Phong Truy Ảnh
            [
                'title' => 'Bổ Phong Truy Ảnh',
                'original_title' => '捕风追影',
                'slug' => 'bo-phong-truy-anh-2025',
                'description' => 'Wong Tak-Chung, cựu chuyên gia giám sát, được mời trở lại để điều tra các vụ cướp công nghệ cao.',
                'poster' => 'https://image.tmdb.org/t/p/w500/5LGUvRBXoXHsMZsZrCGBOVmwOVd.jpg',
                'content' => 'Bổ Phong Truy Ảnh kể về Wong Tak-Chung, một cựu chuyên gia giám sát tài ba đã nghỉ hưu. Khi cảnh sát Ma Cao mời anh trở lại để điều tra các vụ cướp công nghệ cao, Wong buộc phải đối mặt với quá khứ và những kẻ thù cũ. Phim kết hợp giữa hành động, giật gân và chính kịch, mang đến những pha đấu súng đỉnh cao và cận cảnh đậm chất Hồng Kông.',
                'notable_points' => 'Bổ Phong Truy Ảnh quy tụ dàn diễn viên hạng đầu như Thành Long, Trương Tử Phong và Lương Gia Huy. Phim do đạo diễn Dương Tử đóng vai chỉ đạo và cũng tham gia diễn xuất.',
                'faq' => json_encode([
                    ['question' => 'Phim Bổ Phong Truy Ảnh khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 16 tháng 8 năm 2025.'],
                    ['question' => 'Trailer phim Bổ Phong Truy Ảnh đã ra chưa?', 'answer' => 'Đã có official trailer giới thiệu những pha hành động trong phim.'],
                    ['question' => 'Phim Bổ Phong Truy Ảnh thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, hình sự, chính kịch.'],
                ]),
                'release_date' => '2025-08-16',
                'status' => 'upcoming',
                'country' => 'Trung Quốc',
                'duration' => 142,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$hanhDong->id, $toiPham->id, $kichTinh->id],
                'country_cat' => $trungQuoc->id,
                'trailers' => [],
            ],

            // 5. Cô Hầu Gái
            [
                'title' => 'Cô Hầu Gái',
                'original_title' => 'The Housemaid',
                'slug' => 'co-hau-gai-2025',
                'description' => 'Một thế giới hỗn loạn nơi sự hoàn hảo chỉ là ảo giác - phim kinh dị từ đạo diễn Paul Feig.',
                'poster' => 'https://image.tmdb.org/t/p/w500/vpHLCt2bwYmmkGH4soqJNIFLOUQ.jpg',
                'content' => 'Cô Hầu Gái theo chân một người giúp việc mới gia đình nhà giàu Mills. Dần dần, cô nhận ra những điều kỳ lạ trong nhà và người chủ có những bí mật đen tối. Phim kết hợp giữa yếu tố kinh dị và tâm lý, tạo nên những giây phút hồi hộp và giật gân. Đặc biệt, cuối phim có một plot twist bất ngờ thay đổi toàn bộ góc nhìn về câu chuyện.',
                'notable_points' => 'Cô Hầu Gái có sự tham gia của Sydney Sweeney trong vai chính - một vai diễn đầy thách thức. Phim do Paul Feig đạo diễn, người nổi tiếng với các phim comedy và suspense.',
                'faq' => json_encode([
                    ['question' => 'Phim Cô Hầu Gái khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 18 tháng 12 năm 2025.'],
                    ['question' => 'Trailer phim Cô Hầu Gái đã ra chưa?', 'answer' => 'Đã có teaser trailer giới thiệu bối cảnh đáng sợ trong phim.'],
                    ['question' => 'Phim Cô Hầu Gái thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại kinh dị, gay cấn.'],
                ]),
                'release_date' => '2025-12-18',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 131,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$kinhDi->id, $biAn->id],
                'country_cat' => $my->id,
                'trailers' => [],
            ],

            // 6. Đêm Giáng Sinh Đẫm Máu
            [
                'title' => 'Đêm Giáng Sinh Đẫm Máu',
                'original_title' => 'Silent Night, Deadly Night',
                'slug' => 'dem-giang-sinh-dam-mau-2025',
                'description' => 'Remake của phim kinh dị kinh điển năm 1984 về Santa Claus sát nhân.',
                'poster' => 'https://image.tmdb.org/t/p/w500/xCdSd7NnRdnL8DGLVhI95WhUNoi.jpg',
                'content' => 'Đêm Giáng Sinh Đẫm Máu là remake của phim kinh dị năm 1984, xoay quanh một kẻ giết người hóa thân thành Santa Claus. Vào đêm Giáng sinh, Billy - một cậu bé sống tại trại trẻ mồ côi - phải đối mặt với sát nhân đang ngụy trang ông già Noel. Phim kết hợp giữa yếu tố kinh dị và slasher, mang lại những khoảnh khắc đáng sợ nhưng cũng đầy phê phán về việc niềm tin và sự bảo vệ.',
                'notable_points' => 'Đêm Giáng Sinh Đẫm Máu là remake được mong chờ nhất năm 2025, đặc biệt đối với fan của bản gốc năm 1984. Phim do Mike P. Nelson đạo diễn và được sản xuất bởi Blumhouse Productions.',
                'faq' => json_encode([
                    ['question' => 'Phim Đêm Giáng Sinh Đẫm Máu khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 11 tháng 12 năm 2025.'],
                    ['question' => 'Trailer phim Đêm Giáng Sinh Đẫm Máu đã ra chưa?', 'answer' => 'Đã có teaser trailer giới thiệu về Santa Claus sát nhân.'],
                    ['question' => 'Phim Đêm Giáng Sinh Đẫm Máu thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại kinh dị, hành động.'],
                ]),
                'release_date' => '2025-12-11',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 96,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$kinhDi->id, $hanhDong->id],
                'country_cat' => $my->id,
                'trailers' => [],
            ],

            // 7. Phi Vụ Thế Kỷ 3: Thoắt Ẩn Thoặt Hiện
            [
                'title' => 'Phi Vụ Thế Kỷ 3: Thoắt Ẩn Thoặt Hiện',
                'original_title' => 'Now You See Me: Now You Don\'t',
                'slug' => 'phi-vu-the-ky-3-2025',
                'description' => 'Tứ Kỵ Sĩ tái xuất, kết hợp Gen Z trong phi vụ kim cương liều lĩnh.',
                'poster' => 'https://image.tmdb.org/t/p/w500/usoYdcapXSsqAM1bDOtD7H42Wxe.jpg',
                'content' => 'Phi Vụ Thế Kỷ 3: Thoắt Ẩn Thoặt Hiện đánh dấu sự trở lại của Tứ Kỵ Sĩ sau 10 năm. Lần này, họ kết hợp với các thành viên Gen Z trẻ tuổi để thực hiện những phi vụ impossible còn ngoạn hơn. J. Daniel Atlas (Jesse Eisenberg) trở lại cùng với những gương mặt mới, và phải đối mặt với đối thủ vô cùng nguy hiểm. Bộ phim kết hợp giữa ảo thuật đường phố, âm nhạc và những pha hành tính ngoạn mục đích.',
                'notable_points' => 'Phi Vụ Thế Kỷ 3 có sự tham gia của Jesse Eisenberg, Ariana Greenblatt, Justice Smith và Rosamund Pike. Phim do Ruben Fleischer đạo diễn, người cũng từng tham gia vào Venom và Zombieland.',
                'faq' => json_encode([
                    ['question' => 'Phim Phi Vụ Thế Kỷ 3 khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 12 tháng 11 năm 2025.'],
                    ['question' => 'Trailer phim Phi Vụ Thế Kỷ 3 đã ra chưa?', 'answer' => 'Chưa có trailer chính thức, chỉ có thông tin tóm tắt về phim.'],
                    ['question' => 'Phim Phi Vụ Thế Kỷ 3 thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hình sự, bí ẩn, gay cấn.'],
                ]),
                'release_date' => '2025-11-12',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 113,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$kichTinh->id],
                'country_cat' => $my->id,
                'trailers' => [],
            ],

            // 8. Cuộc Chiến Giữa Các Thế Giới
            [
                'title' => 'Cuộc Chiến Giữa Các Thế Giới',
                'original_title' => 'War of the Worlds',
                'slug' => 'cuoc-chien-giua-cac-the-gioi-2025',
                'description' => 'Will Radford - chuyên gia phân tích an ninh - theo dõi các mối đe dọa đến an ninh quốc gia.',
                'poster' => 'https://image.tmdb.org/t/p/w500/3e6GQvCA9hguxqfqA75BDvG7Vvp.jpg',
                'content' => 'Cuộc Chiến Giữa Các Thế Giới xoay quanh Will Radford - một chuyên gia phân tích an ninh mạng hàng đầu của Bộ An ninh Nội địa. Khi một chương trình giám sát diện rộng phát hiện những bất thường, Will phát hiện ra một mối đe dọa toàn cầu đe dọa sự tồn vong của nhân loại. Phim kết hợp giữa khoa học viễn tưởng và hành động, mang lại những câu hỏi về công nghệ, quyền riêng tư và an ninh trong thế kỷ 21.',
                'notable_points' => 'Cuộc Chiến Giữa Các Thế Giới có sự tham gia của Ice Cube, Eva Longoria và Clark Gregg. Phim do Rich Lee đạo diễn, dựa trên tiểu thuyết "War of the Worlds" của H.G. Wells.',
                'faq' => json_encode([
                    ['question' => 'Phim Cuộc Chiến Giữa Các Thế Giới khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 29 tháng 7 năm 2025.'],
                    ['question' => 'Trailer phim Cuộc Chiến Giữa Các Thế Giới đã ra chưa?', 'answer' => 'Chưa có trailer chính thức, chỉ có thông tin cơ bản về phim.'],
                    ['question' => 'Phim Cuộc Chiến Giữa Các Thế Giới thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại khoa học viễn tưởng, gay cấn.'],
                ]),
                'release_date' => '2025-07-29',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 91,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$vienTuong->id, $kichTinh->id],
                'country_cat' => $my->id,
                'trailers' => [],
            ],

            // 9. Quái Thú Vô Hình: Vùng Đất Chết Chóc
            [
                'title' => 'Quái Thú Vô Hình: Vùng Đất Chết Chóc',
                'original_title' => 'Creature Commandos',
                'slug' => 'quai-thu-vo-hinh-vung-dat-chet-choc-2025',
                'description' => 'Lính Mỹ và người bản địa phải hợp tác để chiến đấu với quái vật vô hình ở vùng đất chết.',
                'poster' => 'https://image.tmdb.org/t/p/w500/6aPy2tMgQLVz2IcifrL1Z2Q9u1t.jpg',
                'content' => 'Quái Thú Vô Hình: Vùng Đất Chết Chóc theo chân một nhóm lính Mỹ và người bản địa tại vùng biên giới Iraq. Khi phát hiện ra quái vật vô hình đang săn sát họ, họ phải hợp tác và sử dụng mọi vũ khí có để sinh tồn. Phim kết hợp giữa yếu tố hành động, kinh dị và khoa học viễn tưởng quân sự, mang lại những cảnh chiến đấu chân thực và những khoảnh khắc đậm chất thực tế.',
                'notable_points' => 'Quái Thú Vô Hình: Vùng Đất Chết Chóc là phim dựa trên truyền thuyết về vùng "Iraq Jinn" - những sinh vật vô hình trong văn hóa dân gian Iraq. Phim do Shawn Levy và Babak Anvari sản xuất.',
                'faq' => json_encode([
                    ['question' => 'Phim Quái Thú Vô Hình khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 5 tháng 11 năm 2025.'],
                    ['question' => 'Trailer phim Quái Thú Vô Hình đã ra chưa?', 'answer' => 'Đã có official trailer giới thiệu những pha hành động và quái vật vô hình.'],
                    ['question' => 'Phim Quái Thú Vô Hình thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, kinh dị, khoa học viễn tưởng.'],
                ]),
                'release_date' => '2025-11-05',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 110,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$hanhDong->id, $kinhDi->id],
                'country_cat' => $my->id,
                'trailers' => [],
            ],

            // 10. Con trai của Shakespeare
            [
                'title' => 'Con trai của Shakespeare',
                'original_title' => 'The Son of Shakespeare',
                'slug' => 'con-trai-cua-shakespeare-2025',
                'description' => 'Con trai của William Shakespeare phải đối mặt với di sản của cha mình và những mối đe dọa.',
                'poster' => 'https://image.tmdb.org/t/p/w500/vbeyOZm2bvBXcbgPD3v6o94epPX.jpg',
                'content' => 'Con trai của Shakespeare kể về con trai của William Shakespeare - một trong những nhà văn vĩ đại nhất lịch sử nhân loại. Khi cha qua đời, con trai phải đối mặt với di sản khổng lồ và những bí mật gia đình được giấu kín. Phim kết hợp giữa yếu tố lịch sử, drama và bí ẩn, mang lại cái nhìn mới về cuộc đời riêng tư của Shakespeare.',
                'notable_points' => 'Con trai của Shakespeare có sự tham gia của dàn diễn viên talent. Phim do đạo diễn người Anh với bối cảnh thế kỷ 17.',
                'faq' => json_encode([
                    ['question' => 'Phim Con trai của Shakespeare khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 26 tháng 11 năm 2025.'],
                    ['question' => 'Trailer phim Con trai của Shakespeare đã ra chưa?', 'answer' => 'Chưa có nhiều thông tin về trailer.'],
                    ['question' => 'Phim Con trai của Shakespeare thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại drama, lịch sử.'],
                ]),
                'release_date' => '2025-11-26',
                'status' => 'upcoming',
                'country' => 'United Kingdom',
                'duration' => 0,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$toiPham->id],
                'country_cat' => $my->id,
                'trailers' => [],
            ],

            // 11. SpongeBob: Lời Nguyền Hải Tặc
            [
                'title' => 'SpongeBob: Lời Nguyền Hải Tặc',
                'original_title' => 'SpongeBob Movie: Search for Square Pants',
                'slug' => 'sponge-bi-loi-nguyen-hai-tac-2025',
                'description' => 'SpongeBob và Patrick Star lên đường giải cứu Gary khỏi cướp biển.',
                'poster' => 'https://image.tmdb.org/t/p/w500/e500bc4RlVRHCGnFq6B66hvt0kP.jpg',
                'content' => 'SpongeBob: Lời Nguyền Hải Tặc tiếp tục hành trình của SpongeBob SquarePants và bạn thân Patrick Star. Khi chú ốc Gary bị cướp biển, SpongeBob và Patrick phải lên đường giải cứu bạn mình. Phim hứa hẹn mang lại những tiếng cười và thông điệp về tình bạn, lòng dũng cảm và sự bao dung. Với đồ họa sáng màu và âm nhạc sôi động, phim phù hợp cho cả trẻ em và người lớn.',
                'notable_points' => 'SpongeBob: Lời Nguyền Hải Tặc là phim hoạt hình dựa trên series truyền hình SpongeBob SquarePình nổi tiếng. Phim do Paramount Animation sản xuất và giữ nguyên phong cách hài hước đặc trưng.',
                'faq' => json_encode([
                    ['question' => 'Phim SpongeBob khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 19 tháng 12 năm 2025.'],
                    ['question' => 'Trailer phim SpongeBob đã ra chưa?', 'answer' => 'Đã có official trailer giới thiệu cuộc phiêu lưu của SpongeBob.'],
                    ['question' => 'Phim SpongeBob thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hoạt hình, hài hước, phiêu lưu, gia đình.'],
                ]),
                'release_date' => '2025-12-19',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 0,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$hoatHinh->id, $haiHuoc->id],
                'country_cat' => $my->id,
                'trailers' => [],
            ],

            // 12. Đụng Độ Siêu Trăn
            [
                'title' => 'Đụng Độ Siêu Trăn',
                'original_title' => 'Kraven the Hunter',
                'slug' => 'dung-do-sieu-tran-2025',
                'description' => 'Sergei Kravinoff trở thành Kraven the Hunter - một trong những sát thủ nguy hiểm nhất Marvel.',
                'poster' => 'https://image.tmdb.org/t/p/w500/4N2cVrDQ0T8LIvA5rjPefBTxqcL.jpg',
                'content' => 'Đụng Độ Siêu Trăn kể về Sergei Kravinoff - một thợ săn chuyên nghiệp trở thành Kraven the Hunter sau khi biến đổi gen. Anh là một trong những sát thủ nguy hiểm nhất Marvel, với khả năng truy kích siêu nhiên và sự tàn bạo không thể kiềm chế. Phim sẽ khám phá nguồn gốc của Kraven và mối quan hệ của anh với Spider-Man - người mà Kraven xem là "con mồi" hoàn hảo.',
                'notable_points' => 'Đụng Độ Siêu Trăn là phim MCU được mong chờ nhất năm 2025, với Aaron Taylor-Johnson trong vai chính. Phim đánh dấu sự ra mắt của một trong những phản diện nổi tiếng nhất của Spider-Man.',
                'faq' => json_encode([
                    ['question' => 'Phim Đụng Độ Siêu Trăn khi nào chiếu?', 'answer' => 'Phim khởi chiếu tại các rạp Việt Nam từ ngày 24 tháng 12 năm 2025.'],
                    ['question' => 'Trailer phim Đụng Độ Siêu Trăn đã ra chưa?', 'answer' => 'Đã có teaser và official trailer giới thiệu Aaron Taylor-Johnson trong vai Kraven.'],
                    ['question' => 'Phim Đụng Độ Siêu Trăn thuộc thể loại gì?', 'answer' => 'Phim thuộc thể loại hành động, viễn tưởng, siêu anh hùng của Marvel Studios.'],
                ]),
                'release_date' => '2025-12-24',
                'status' => 'upcoming',
                'country' => 'United States',
                'duration' => 0,
                'view_count' => 0,
                'published_at' => now(),
                'categories' => [$hanhDong->id, $vienTuong->id],
                'country_cat' => $my->id,
                'trailers' => [],
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
            $this->command->info('Movies 2025 seeded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error seeding movies: ' . $e->getMessage());
            throw $e;
        }
    }
}
