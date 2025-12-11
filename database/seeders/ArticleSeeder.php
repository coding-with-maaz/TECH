<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all existing articles
        Article::query()->delete();
        $this->command->info('🗑️  Deleted all existing articles');

        // Get or create an author
        $author = User::firstOrCreate(
            ['email' => 'admin@techblog.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'is_author' => true,
                'role' => 'admin',
            ]
        );

        // Get Mobile Development category or use first available
        $mobileCategory = Category::where('slug', 'mobile-development')->first();
        if (!$mobileCategory) {
            $mobileCategory = Category::first(); // Fallback to first category
        }

        // Get or create relevant tags
        $pixelTag = Tag::firstOrCreate(['slug' => 'pixel'], ['name' => 'Pixel']);
        $googleTag = Tag::firstOrCreate(['slug' => 'google'], ['name' => 'Google']);
        $smartphoneTag = Tag::firstOrCreate(['slug' => 'smartphone'], ['name' => 'Smartphone']);
        $reviewTag = Tag::firstOrCreate(['slug' => 'review'], ['name' => 'Review']);

        // Create Pixel 9 Pro Review article
        $article = Article::create([
            'title' => 'Pixel 9 Pro Review: Cameras, Performance, and Battery Life',
            'slug' => 'pixel-9-pro-review-cameras-performance-battery-life',
            'excerpt' => 'In-depth review of Google Pixel 9 Pro covering camera capabilities, performance benchmarks, battery life testing, and overall user experience. Discover if this flagship smartphone lives up to the hype.',
            'content' => self::getPixel9ProReviewContent(),
            'category_id' => $mobileCategory?->id,
            'author_id' => $author->id,
            'status' => 'published',
            'is_featured' => true,
            'published_at' => Carbon::now(),
            'featured_image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=1200&h=630&fit=crop',
            'reading_time' => 12,
        ]);

        // Attach tags
        $article->tags()->sync([
            $pixelTag->id,
            $googleTag->id,
            $smartphoneTag->id,
            $reviewTag->id,
        ]);

        $this->command->info("✅ Created article: {$article->title}");
        $this->command->info('✅ Articles seeded successfully!');
    }

    private static function getPixel9ProReviewContent(): string
    {
        return <<<'HTML'
<h1>Pixel 9 Pro Review: Cameras, Performance, and Battery Life</h1>

<p>Google's Pixel 9 Pro represents the pinnacle of smartphone engineering, combining cutting-edge hardware with Google's signature software optimization. In this comprehensive review, we'll dive deep into three critical aspects that matter most to users: camera performance, processing power, and battery endurance.</p>

<p><strong>Why This Review Matters:</strong> The Pixel 9 Pro sits in a competitive flagship market dominated by Samsung, Apple, and other premium manufacturers. Understanding its real-world performance in these key areas will help you make an informed decision about whether this device deserves a place in your pocket.</p>

<h2>Introduction to Pixel 9 Pro</h2>

<p>The Pixel 9 Pro is Google's latest flagship smartphone, featuring the company's custom Tensor G4 chipset, an advanced triple-camera system, and a premium build quality that rivals the best in the industry. This device represents Google's vision of what a modern smartphone should be: powerful, intelligent, and user-focused.</p>

<p><strong>Key Specifications:</strong> The Pixel 9 Pro comes equipped with 12GB of RAM, up to 512GB of storage, a 6.7-inch LTPO OLED display with 120Hz refresh rate, and Google's latest Android 15 with exclusive Pixel features. The device features IP68 water and dust resistance, wireless charging, and reverse wireless charging capabilities.</p>

<p><strong>Design Philosophy:</strong> Google has maintained its minimalist design approach while incorporating premium materials. The device feels substantial in hand without being unwieldy, and the matte finish on the back provides excellent grip while resisting fingerprints.</p>

<figure class="image"><img title="Google Pixel 9 Pro" src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=1200&h=630&fit=crop" alt="Google Pixel 9 Pro Smartphone" width="1200" height="630">
<figcaption>Google Pixel 9 Pro - Premium flagship smartphone</figcaption>
</figure>

<h2>1. Camera Performance - A Photographic Powerhouse</h2>

<p>The Pixel 9 Pro's camera system is where Google truly shines. With a triple-camera setup featuring a 50MP main sensor, 48MP ultrawide lens, and 48MP telephoto with 5x optical zoom, this device is designed to capture stunning photos in virtually any condition.</p>

<h3>Main Camera - Exceptional Detail and Color</h3>

<p>The primary 50MP camera uses Google's advanced computational photography to produce images that rival dedicated cameras. In daylight conditions, photos are sharp, well-exposed, and exhibit natural color reproduction. The HDR processing is particularly impressive, maintaining detail in both highlights and shadows without the over-processed look common in many smartphones.</p>

<p><strong>Low-Light Performance:</strong> Google's Night Sight technology has been refined further in the Pixel 9 Pro. The camera can capture remarkably bright and detailed images in near-darkness, with minimal noise and excellent color accuracy. The processing time has also been reduced, making it more practical for real-world use.</p>

<p><strong>Portrait Mode:</strong> The portrait mode on the Pixel 9 Pro is among the best in the industry. Edge detection is precise, background blur (bokeh) looks natural, and the subject separation is excellent. The camera can also adjust the depth of field after capture, giving you creative control over your portraits.</p>

<h3>Ultrawide Camera - Expansive Perspectives</h3>

<p>The 48MP ultrawide lens provides a 125-degree field of view, perfect for capturing landscapes, architecture, and group photos. The distortion correction is excellent, and the color matching between the main and ultrawide cameras is seamless. Low-light performance on the ultrawide is also impressive, though not quite at the level of the main sensor.</p>

<h3>Telephoto Camera - Zoom Without Compromise</h3>

<p>The 5x optical zoom on the telephoto lens is a game-changer. It allows you to capture distant subjects with remarkable clarity, and when combined with Google's Super Res Zoom technology, you can achieve up to 30x digital zoom with surprisingly usable results. The optical image stabilization ensures sharp images even at maximum zoom.</p>

<h3>Video Recording Capabilities</h3>

<p>The Pixel 9 Pro can record 4K video at 60fps on all three cameras, with excellent stabilization. The Cinematic Pan feature creates smooth, professional-looking panning shots, and the Audio Eraser feature can remove unwanted background noise from videos. The front-facing camera also supports 4K recording, making it ideal for vloggers and content creators.</p>

<h3>Real-World Camera Testing</h3>

<p>During our testing period, we captured over 500 photos in various conditions. Daylight photos consistently impressed with their sharpness and color accuracy. Indoor photography benefited from excellent white balance, and low-light shots were consistently usable, even in challenging conditions. The camera's AI features, such as Magic Eraser and Photo Unblur, work remarkably well and add genuine value to the photography experience.</p>

<h2>2. Performance - Tensor G4 Power</h2>

<p>The Pixel 9 Pro is powered by Google's custom Tensor G4 chipset, which combines powerful CPU cores with dedicated AI and machine learning processors. This chipset is designed to optimize the user experience while maintaining excellent battery efficiency.</p>

<h3>Processing Power and Speed</h3>

<p>In daily use, the Pixel 9 Pro feels incredibly snappy. Apps launch instantly, multitasking is smooth, and there's no noticeable lag when switching between applications. The 12GB of RAM ensures that apps stay in memory, allowing for seamless multitasking without constant reloading.</p>

<p><strong>Benchmark Results:</strong> In synthetic benchmarks, the Tensor G4 performs admirably, scoring competitively with other flagship chipsets. However, where it truly excels is in real-world performance, where Google's software optimization makes the device feel faster than raw benchmark numbers might suggest.</p>

<h3>Gaming Performance</h3>

<p>For mobile gaming enthusiasts, the Pixel 9 Pro handles demanding games with ease. Titles like Genshin Impact, Call of Duty Mobile, and Asphalt 9 run smoothly at high settings with consistent frame rates. The device does get warm during extended gaming sessions, but thermal throttling is minimal, and performance remains stable.</p>

<h3>AI and Machine Learning Features</h3>

<p>The Tensor G4's dedicated AI processors power many of the Pixel 9 Pro's unique features. Real-time translation works seamlessly, voice recognition is incredibly accurate, and on-device processing means your data stays private. The AI also enhances camera performance, automatically adjusting settings based on the scene.</p>

<h3>Software Optimization</h3>

<p>Google's Android 15, optimized specifically for Pixel devices, runs flawlessly on the Pixel 9 Pro. The software feels polished and refined, with thoughtful animations and transitions that make the user experience feel premium. Regular security updates and feature drops ensure the device stays current and secure.</p>

<h3>Real-World Performance Testing</h3>

<p>Over a month of intensive use, the Pixel 9 Pro handled everything we threw at it. From heavy multitasking with multiple apps and browser tabs to intensive photo editing and video processing, the device never felt sluggish. The combination of powerful hardware and optimized software creates a truly smooth user experience.</p>

<h2>3. Battery Life - All-Day Endurance</h2>

<p>The Pixel 9 Pro features a 5,050mAh battery, which, combined with Google's power-efficient Tensor G4 chipset and adaptive battery technology, provides excellent battery life that easily lasts through a full day of heavy use.</p>

<h3>Battery Capacity and Efficiency</h3>

<p>The 5,050mAh battery capacity is substantial, and Google's optimization ensures that every milliampere-hour is used efficiently. The adaptive battery feature learns your usage patterns and optimizes background activity to extend battery life without impacting performance.</p>

<p><strong>Screen-On Time:</strong> In our testing, we consistently achieved 7-8 hours of screen-on time with mixed usage including web browsing, social media, video streaming, and photography. For lighter users, the device can easily last two days on a single charge.</p>

<h3>Charging Speed and Options</h3>

<p>The Pixel 9 Pro supports 30W fast charging, which can charge the device from 0% to 50% in approximately 30 minutes. Wireless charging at 23W is also supported, and the device can wirelessly charge other devices, making it useful for charging earbuds or other accessories.</p>

<p><strong>Battery Health:</strong> Google's charging algorithms are designed to preserve battery health over time. The device learns your charging patterns and can delay charging to 100% until just before you typically unplug, reducing wear on the battery.</p>

<h3>Power-Saving Features</h3>

<p>The Pixel 9 Pro includes several power-saving modes. Extreme Battery Saver can extend battery life significantly by limiting background activity and reducing performance. The adaptive brightness feature also helps conserve battery by automatically adjusting screen brightness based on ambient light and usage patterns.</p>

<h3>Real-World Battery Testing</h3>

<p>During our testing period, we used the Pixel 9 Pro as our primary device with typical daily usage including calls, messaging, email, social media, photography, video streaming, and web browsing. The device consistently lasted from morning until bedtime with 20-30% battery remaining. For power users, a midday top-up might be necessary, but for most users, the battery life is more than adequate.</p>

<h2>Additional Features and Considerations</h2>

<h3>Display Quality</h3>

<p>The 6.7-inch LTPO OLED display is stunning, with vibrant colors, deep blacks, and excellent viewing angles. The 120Hz refresh rate makes scrolling and animations feel incredibly smooth, and the adaptive refresh rate helps conserve battery by lowering the refresh rate when appropriate.</p>

<h3>Build Quality and Durability</h3>

<p>The Pixel 9 Pro feels premium and well-built. The aluminum frame and Gorilla Glass Victus 2 provide excellent durability, and the IP68 rating means the device can withstand water and dust exposure. The device has survived several accidental drops during our testing without any damage.</p>

<h3>Software Features</h3>

<p>Pixel-exclusive features like Call Screen, Hold for Me, and Direct My Call add genuine value to the user experience. The Now Playing feature automatically identifies music playing around you, and the Recorder app can transcribe audio in real-time with impressive accuracy.</p>

<h2>Comparison with Competitors</h2>

<p>When compared to flagship devices from Samsung and Apple, the Pixel 9 Pro holds its own. The camera system is competitive with the best in the industry, performance is excellent for daily use, and battery life is on par with or better than many competitors. Where the Pixel 9 Pro truly excels is in its software experience and unique AI-powered features.</p>

<h2>Pros and Cons</h2>

<h3>Pros</h3>
<ul>
<li>Exceptional camera system with outstanding low-light performance</li>
<li>Excellent battery life that easily lasts a full day</li>
<li>Smooth, optimized software experience</li>
<li>Unique AI-powered features</li>
<li>Premium build quality and design</li>
<li>Regular security updates and feature drops</li>
<li>Competitive pricing compared to other flagships</li>
</ul>

<h3>Cons</h3>
<ul>
<li>Tensor G4 may not match raw performance of Snapdragon 8 Gen 3 in some benchmarks</li>
<li>Charging speed is good but not the fastest in the market</li>
<li>Some competitors offer more storage options</li>
<li>Limited availability in some regions</li>
</ul>

<h2>Final Verdict</h2>

<p>The Pixel 9 Pro is an exceptional smartphone that excels in the areas that matter most: cameras, performance, and battery life. The camera system is among the best available, producing stunning photos in any condition. Performance is smooth and responsive, handling everything from daily tasks to intensive gaming with ease. Battery life is excellent, easily lasting through a full day of heavy use.</p>

<p><strong>Who Should Buy This Phone:</strong> The Pixel 9 Pro is ideal for photography enthusiasts, users who value software experience and regular updates, and anyone looking for a premium Android device that offers unique features not available elsewhere.</p>

<p><strong>Value Proposition:</strong> While not the cheapest flagship available, the Pixel 9 Pro offers excellent value when considering its camera capabilities, software experience, and unique features. It's a device that feels premium in every way and delivers on its promises.</p>

<p>In conclusion, the Pixel 9 Pro is a well-rounded flagship that doesn't compromise on the essentials. If you're in the market for a premium Android smartphone that excels in photography, offers smooth performance, and provides excellent battery life, the Pixel 9 Pro should be at the top of your list.</p>
HTML;
    }
}
