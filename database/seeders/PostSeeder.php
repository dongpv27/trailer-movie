<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Top 10 phim hành động hay nhất năm 2025',
                'slug' => 'top-10-phim-hanh-dong-hay-nhat-nam-2025',
                'excerpt' => 'Tổng hợp những bộ phim hành động đáng xem nhất trong năm 2025 với những cảnh chiến đấu mãn nhãn.',
                'content' => '<p>Năm 2025 hứa hẹn sẽ là một năm bùng nổ của điện ảnh hành động với hàng loạt bom tấn đang chờ đón khán giả. Hãy cùng điểm qua những tựa phim đáng xem nhất.</p>
                <h3>1. Captain America: Brave New World</h3>
                <p>Anthony Mackie chính thức trở thành Captain America trong bộ phim này. Với những cảnh hành động kịch tính và cốt truyện hấp dẫn, đây chắc chắn là một bộ phim không thể bỏ lỡ.</p>
                <h3>2. Thunderbolts*</h3>
                <p>Đội quân những phản diện từ MCU hợp thành một nhóm bất đắc dĩ. Một góc nhìn hoàn toàn mới về vũ trụ Marvel.</p>
                <h3>3. Mickey 17</h3>
                <p>Robert Pattinson starring trong bộ phim khoa học viễn tưởng đầy độc đáo từ đạo diễn Bong Joon-ho.</p>
                <p>Đừng bỏ lỡ những bộ phim này khi chúng ra mắt tại các rạp chiếu phim!</p>',
                'status' => 'published',
                'view_count' => 3240,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Review: Đấm Pó E3 - Vượt Lên Trên Cả Đời',
                'slug' => 'review-dam-po-e3',
                'excerpt' => 'Đánh giá chi tiết bộ phim Đấm Pó E3 - phần tiếp theo của series phim hài Việt Nam đình đám.',
                'content' => '<p>Đấm Pó E3 đã chính thức ra mắt và không làm khán giả thất vọng. Đây là phần tiếp theo của series phim hài Việt Nam đình đám với sự trở lại của Tuấn và nhóm bạn.</p>
                <h3>Điểm sáng của phim</h3>
                <p>Phim tiếp tục duy trì phong cách hài hước, châm biếm đặc trưng. Những tình huống "đấm po" vẫn là điểm hút khán giả lớn nhất.</p>
                <h3>Diễn xuất</h3>
                <p>Diễn viên chính vẫn giữ được phong độ và sự ăn ý. Các diễn viên mới cũng có màn debut ấn tượng.</p>
                <h3>Đánh giá chung</h3>
                <p>Đấm Pó E3 là một bộ phim giải trí đáng xem trong dịp này. Nếu bạn cần những tiếng cười sảng khoái, đây là lựa chọn hoàn hảo.</p>',
                'status' => 'published',
                'view_count' => 5680,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Marvel công bố lịch phát hành phim Phase 6',
                'slug' => 'marvel-phase-6-release-schedule',
                'excerpt' => 'Disney và Marvel Studios vừa công bố lịch phát hành các bộ phim trong Phase 6 của MCU.',
                'content' => '<p>Marvel Studios vừa chính thức công bố lịch phát hành các bộ phim trong Phase 6 của Marvel Cinematic Universe (MCU).</p>
                <h3>Các bộ phim sắp ra mắt</h3>
                <ul>
                <li>Captain America: Brave New World - Tháng 2/2025</li>
                <li>Thunderbolts* - Tháng 5/2025</li>
                <li>Fantastic Four - Tháng 7/2025</li>
                <li>Blade - Tháng 11/2025</li>
                <li>Avengers: Doomsday - Tháng 5/2026</li>
                </ul>
                <h3>Điều gì đang chờ đón?</h3>
                <p>Phase 6 hứa hẹn sẽ là giai đoạn kết thúc của The Multiverse Saga với sự trở lại của Doctor Doom và Avengers: Doomsday.</p>',
                'status' => 'published',
                'view_count' => 8920,
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => '5 phim Việt Nam đáng chờ đợi trong 2025',
                'slug' => '5-phim-viet-nam-dang-cho-doi-2025',
                'excerpt' => 'Danh sách những bộ phim Việt Nam hot nhất được mong chờ trong năm 2025.',
                'content' => '<p>Năm 2025 đang đến với hàng loạt bộ phim Việt Nam hấp dẫn. Hãy cùng điểm qua những tác phẩm đáng mong chờ nhất.</p>
                <h3>1. Đấm Pó E3</h3>
                <p>Phần tiếp theo của series phim hài đình đám với sự trở lại của dàn diễn viên quen thuộc.</p>
                <h3>2. Zombie 4 - Tập Đoàn Phục Sinh</h3>
                <p>Phần 4 của series phim Zombie Việt Nam với nhiều tình huống hài hước hơn.</p>
                <h3>3. Mùa Hoa Thần Tình</h3>
                <p>Phim tình cảm với cốt truyện lãng mạn và diễn viên xuất sắc.</p>
                <h3>4. Bố Già 2</h3>
                <p>Phần tiếp theo của bộ phim thành công nhất năm 2024.</p>
                <h3>5. Nhà Bà Nữ 2</h3>
                <p>Trấn Thành trở lại với dự án phim mới đầy hứa hẹn.</p>',
                'status' => 'published',
                'view_count' => 4150,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Tại sao trailer Captain America 4 lại gây tranh cãi?',
                'slug' => 'tai-sao-trailer-captain-america-4-gay-tran-cai',
                'excerpt' => 'Phân tích những điểm gây tranh cãi trong trailer mới nhất của Captain America: Brave New World.',
                'content' => '<p>Trailer mới của Captain America: Brave New World vừa được công bố và đã gây ra nhiều tranh cãi trong cộng đồng fan Marvel.</p>
                <h3>Nội dung gây tranh cãi</h3>
                <p>Nhiều fan lo ngại về sự thay đổi trong vai diễn Captain America. Anthony Mackie thay thế Chris Evans đã tạo ra nhiều ý kiến trái chiều.</p>
                <h3>Phản hồi từ đạo diễn</h3>
                <p>Đạo diễn Julius Jonasson đã chia sẻ rằng bộ phim sẽ tôn trọng di sản của Steve Rogers đồng thời khai thác chiều sâu mới của Sam Wilson.</p>
                <h3>Kết luận</h3>
                <p>Hãy chờ đợi phim ra mắt để có cái nhìn khách quan nhất. Trailer chưa nói lên tất cả!</p>',
                'status' => 'published',
                'view_count' => 6780,
                'published_at' => now()->subDays(5),
            ],
        ];

        foreach ($posts as $postData) {
            Post::firstOrCreate(
                ['slug' => $postData['slug']],
                $postData
            );
            $this->command->info("Seeded post: {$postData['title']}");
        }

        $this->command->info('Posts seeded successfully!');
    }
}
