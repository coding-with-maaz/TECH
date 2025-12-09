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
        // Get or create an author
        $author = User::firstOrCreate(
            ['email' => 'admin@nazaaracircle.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'is_author' => true,
                'role' => 'admin',
            ]
        );

        // Get categories
        $webDevCategory = Category::where('slug', 'web-development')->first();
        if (!$webDevCategory) {
            $webDevCategory = Category::first(); // Fallback to first category
        }

        // Get tags
        $javascriptTag = Tag::where('slug', 'javascript')->first();
        $basicsTag = Tag::where('slug', 'basics')->first();

        $tokenService = app(\App\Services\DownloadTokenService::class);

        // Article 1: JavaScript Operators
        $article1 = Article::firstOrCreate(
            ['slug' => 'javascript-basics-operators'],
            [
                'title' => 'JavaScript Basics: Operators Complete Guide',
                'slug' => 'javascript-basics-operators',
                'excerpt' => 'Operators are the building blocks of JavaScript expressions. This comprehensive guide covers arithmetic operators (+, -, *, /, %), increment/decrement operators (++, --), comparison operators, and logical operators with practical examples and best practices.',
                'content' => self::getJavaScriptOperatorsArticleContent(),
                'category_id' => $webDevCategory?->id,
                'author_id' => $author->id,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now(),
                'featured_image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=1200&h=630&fit=crop',
                'download_link' => 'https://mega.nz/file/example#JavaScript-Operators-Guide',
            ]
        );
        if ($article1->download_link && !$article1->download_token) {
            $article1->download_token = $tokenService->createPermanentToken($article1->download_link, $article1->id);
            $article1->save();
        }
        $tagsToAttach = [];
        if ($javascriptTag) $tagsToAttach[] = $javascriptTag->id;
        if ($basicsTag) $tagsToAttach[] = $basicsTag->id;
        if (!empty($tagsToAttach)) {
            $article1->tags()->syncWithoutDetaching($tagsToAttach);
        }
        $this->command->info("Created article: {$article1->title}");

        // Article 2: Control Flow - if, else if, else
        $article2 = Article::firstOrCreate(
            ['slug' => 'javascript-basics-control-flow-if-else'],
            [
                'title' => 'JavaScript Basics: Control Flow with if, else if, and else',
                'slug' => 'javascript-basics-control-flow-if-else',
                'excerpt' => 'Control flow statements allow you to make decisions in your code. Learn how to use if, else if, and else statements to create conditional logic in JavaScript with practical examples and best practices.',
                'content' => self::getControlFlowIfElseArticleContent(),
                'category_id' => $webDevCategory?->id,
                'author_id' => $author->id,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDay(),
                'featured_image' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=1200&h=630&fit=crop',
                'download_link' => 'https://mega.nz/file/example#JavaScript-Control-Flow-Guide',
            ]
        );
        if ($article2->download_link && !$article2->download_token) {
            $article2->download_token = $tokenService->createPermanentToken($article2->download_link, $article2->id);
            $article2->save();
        }
        if (!empty($tagsToAttach)) {
            $article2->tags()->syncWithoutDetaching($tagsToAttach);
        }
        $this->command->info("Created article: {$article2->title}");

        // Article 3: Logical Operators
        $article3 = Article::firstOrCreate(
            ['slug' => 'javascript-basics-logical-operators'],
            [
                'title' => 'JavaScript Basics: Logical Operators (&&, ||, !)',
                'slug' => 'javascript-basics-logical-operators',
                'excerpt' => 'Logical operators are essential for combining conditions and controlling program flow. This guide covers the AND (&&), OR (||), and NOT (!) operators with practical examples, short-circuit evaluation, and best practices.',
                'content' => self::getLogicalOperatorsArticleContent(),
                'category_id' => $webDevCategory?->id,
                'author_id' => $author->id,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(2),
                'featured_image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&h=630&fit=crop',
                'download_link' => 'https://mega.nz/file/example#JavaScript-Logical-Operators-Guide',
            ]
        );
        if ($article3->download_link && !$article3->download_token) {
            $article3->download_token = $tokenService->createPermanentToken($article3->download_link, $article3->id);
            $article3->save();
        }
        if (!empty($tagsToAttach)) {
            $article3->tags()->syncWithoutDetaching($tagsToAttach);
        }
        $this->command->info("Created article: {$article3->title}");

        // Article 4: Switch Statement
        $article4 = Article::firstOrCreate(
            ['slug' => 'javascript-basics-switch-statement'],
            [
                'title' => 'JavaScript Basics: Switch Statement Complete Guide',
                'slug' => 'javascript-basics-switch-statement',
                'excerpt' => 'The switch statement provides an elegant way to handle multiple conditions. Learn how to use switch, case, break, and default keywords to create clean, readable conditional logic in JavaScript.',
                'content' => self::getSwitchStatementArticleContent(),
                'category_id' => $webDevCategory?->id,
                'author_id' => $author->id,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(3),
                'featured_image' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=1200&h=630&fit=crop',
                'download_link' => 'https://mega.nz/file/example#JavaScript-Switch-Statement-Guide',
            ]
        );
        if ($article4->download_link && !$article4->download_token) {
            $article4->download_token = $tokenService->createPermanentToken($article4->download_link, $article4->id);
            $article4->save();
        }
        if (!empty($tagsToAttach)) {
            $article4->tags()->syncWithoutDetaching($tagsToAttach);
        }
        $this->command->info("Created article: {$article4->title}");

        // Helper function to create articles
        $createArticle = function($slug, $title, $excerpt, $contentMethod, $daysAgo = 0, $imageUrl = null) use ($author, $webDevCategory, $tokenService, $tagsToAttach, $javascriptTag, $basicsTag) {
            $article = Article::firstOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'slug' => $slug,
                    'excerpt' => $excerpt,
                    'content' => $contentMethod(),
                    'category_id' => $webDevCategory?->id,
                    'author_id' => $author->id,
                    'status' => 'published',
                    'is_featured' => true,
                    'published_at' => Carbon::now()->subDays($daysAgo),
                    'featured_image' => $imageUrl ?: 'https://images.unsplash.com/photo-1579468118864-7b3a3c9d93ef?w=1200&h=630&fit=crop',
                    'download_link' => 'https://mega.nz/file/example#' . str_replace(' ', '-', $title),
                ]
            );
            if ($article->download_link && !$article->download_token) {
                $article->download_token = $tokenService->createPermanentToken($article->download_link, $article->id);
                $article->save();
            }
            if (!empty($tagsToAttach)) {
                $article->tags()->syncWithoutDetaching($tagsToAttach);
            }
            return $article;
        };

        // Article 5: Loops
        $article5 = $createArticle(
            'javascript-basics-loops',
            'JavaScript Basics: Loops Complete Guide (for, while, do...while, for...of)',
            'Loops allow you to execute code repeatedly. Learn about for loops, while loops, do...while loops, and the modern for...of loop for iterating over arrays and other iterables.',
            fn() => self::getLoopsArticleContent(),
            4,
            'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article5->title}");

        // Article 6: Functions
        $article6 = $createArticle(
            'javascript-basics-functions',
            'JavaScript Basics: Functions Complete Guide (Declaration, Expression, Arrow, Parameters, Scope)',
            'Functions are reusable blocks of code. Learn about function declarations, function expressions, arrow functions, parameters, return values, and scope (global vs local) in JavaScript.',
            fn() => self::getFunctionsArticleContent(),
            5,
            'https://images.unsplash.com/photo-1516116216624-53e697fedbea?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article6->title}");

        // Article 7: Arrays
        $article7 = $createArticle(
            'javascript-basics-arrays',
            'JavaScript Basics: Arrays Complete Guide (Creating, Accessing, Methods: push, pop, map, filter, reduce)',
            'Arrays are ordered collections of values. Learn how to create arrays, access items, and use essential methods like push, pop, map, filter, and reduce to manipulate array data.',
            fn() => self::getArraysArticleContent(),
            6,
            'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article7->title}");

        // Article 8: Objects
        $article8 = $createArticle(
            'javascript-basics-objects',
            'JavaScript Basics: Objects Complete Guide (Key-Value Pairs, Accessing Properties, this Keyword)',
            'Objects are collections of key-value pairs. Learn how to create objects, access and modify properties, and understand the this keyword in JavaScript.',
            fn() => self::getObjectsArticleContent(),
            7,
            'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article8->title}");

        // Article 9: JSON
        $article9 = $createArticle(
            'javascript-basics-json',
            'JavaScript Basics: JSON Complete Guide (What is JSON, Converting Between JSON and JS Objects)',
            'JSON (JavaScript Object Notation) is a lightweight data format. Learn what JSON is, how to convert JavaScript objects to JSON strings, and how to parse JSON back into JavaScript objects.',
            fn() => self::getJsonArticleContent(),
            8,
            'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article9->title}");

        // Article 10: DOM
        $article10 = $createArticle(
            'javascript-basics-dom',
            'JavaScript Basics: What is the DOM? (Document Object Model Explained Simply)',
            'The DOM (Document Object Model) is a programming interface for web documents. Learn what the DOM is, how it represents HTML documents, and why it\'s essential for web development.',
            fn() => self::getDomArticleContent(),
            9,
            'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article10->title}");

        // Article 11: Selecting & Changing Elements
        $article11 = $createArticle(
            'javascript-basics-dom-manipulation',
            'JavaScript Basics: Selecting & Changing DOM Elements (getElementById, querySelector, Changing Text/HTML/Style)',
            'Learn how to select DOM elements using getElementById and querySelector, and how to change their text content, HTML, and styles dynamically with JavaScript.',
            fn() => self::getDomManipulationArticleContent(),
            10,
            'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article11->title}");

        // Article 12: Events
        $article12 = $createArticle(
            'javascript-basics-events',
            'JavaScript Basics: Events Complete Guide (click, input, submit, Event Listeners, Preventing Default)',
            'Events make web pages interactive. Learn how to handle click, input, and submit events, add event listeners, and prevent default browser behavior in JavaScript.',
            fn() => self::getEventsArticleContent(),
            11,
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article12->title}");

        // Article 13: Creating Interactive UI
        $article13 = $createArticle(
            'javascript-basics-interactive-ui',
            'JavaScript Basics: Creating Interactive UI (Calculator, To-Do List, Color Changer, Counter App)',
            'Build interactive user interfaces with JavaScript. Learn to create practical mini-projects including a calculator, to-do list, color changer, and counter app.',
            fn() => self::getInteractiveUIArticleContent(),
            12,
            'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article13->title}");

        // Article 14: ES6+ Modern Features
        $article14 = $createArticle(
            'javascript-es6-modern-features',
            'JavaScript ES6+ Modern Features: Template Literals, Destructuring, Spread/Rest, Optional Chaining, Modules',
            'Modern JavaScript features that make code cleaner and more powerful. Learn about template literals, destructuring, spread/rest operators, optional chaining, and ES6 modules.',
            fn() => self::getES6ModernFeaturesArticleContent(),
            13,
            'https://images.unsplash.com/photo-1579468118864-7b3a3c9d93ef?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article14->title}");

        // Article 15: Asynchronous JavaScript
        $article15 = $createArticle(
            'javascript-asynchronous-programming',
            'JavaScript Asynchronous Programming: Callbacks, Promises, async/await, Fetch API, Real APIs',
            'Learn asynchronous JavaScript programming with callbacks, promises, async/await, and the Fetch API. Build real applications that interact with external APIs like weather and movie databases.',
            fn() => self::getAsynchronousJavaScriptArticleContent(),
            14,
            'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article15->title}");

        // Article 16: Error Handling
        $article16 = $createArticle(
            'javascript-error-handling',
            'JavaScript Error Handling: try/catch, Throwing Custom Errors',
            'Learn how to handle errors gracefully in JavaScript using try/catch blocks, how to throw custom errors, and best practices for error handling in your applications.',
            fn() => self::getErrorHandlingArticleContent(),
            15,
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article16->title}");

        // Article 17: HTML & CSS Basics
        $article17 = $createArticle(
            'javascript-html-css-basics',
            'HTML & CSS Basics for JavaScript Developers: Page Structure, Forms, Flexbox/Grid, CSS Basics',
            'Essential HTML and CSS knowledge for JavaScript developers. Learn page structure, forms, Flexbox and Grid layouts, and CSS fundamentals needed to build interactive web applications.',
            fn() => self::getHtmlCssBasicsArticleContent(),
            16,
            'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article17->title}");

        // Article 18: Integrating JS with HTML/CSS
        $article18 = $createArticle(
            'javascript-integrating-html-css',
            'Integrating JavaScript with HTML/CSS: Script Placement, DOM Manipulation, Styling with JS',
            'Learn how to integrate JavaScript with HTML and CSS. Understand script placement, DOM manipulation techniques, and how to dynamically style elements with JavaScript.',
            fn() => self::getIntegratingJsHtmlCssArticleContent(),
            17,
            'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article18->title}");

        // Article 19: Local Storage
        $article19 = $createArticle(
            'javascript-local-storage',
            'JavaScript Local Storage: Saving Data Locally, Making Apps Persist Data',
            'Learn how to use the browser\'s localStorage API to save data locally, persist user preferences, and create applications that remember data between sessions.',
            fn() => self::getLocalStorageArticleContent(),
            18,
            'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article19->title}");

        // Article 20: Browser APIs
        $article20 = $createArticle(
            'javascript-browser-apis',
            'JavaScript Browser APIs: Geolocation API, Clipboard API, Canvas Basics',
            'Explore powerful browser APIs available in JavaScript. Learn to use the Geolocation API, Clipboard API, and Canvas API to build feature-rich web applications.',
            fn() => self::getBrowserApisArticleContent(),
            19,
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article20->title}");

        // Article 21: Web Security Basics
        $article21 = $createArticle(
            'javascript-web-security-basics',
            'JavaScript Web Security Basics: CORS, Same-Origin Policy',
            'Understand essential web security concepts for JavaScript developers. Learn about CORS (Cross-Origin Resource Sharing) and the Same-Origin Policy to build secure web applications.',
            fn() => self::getWebSecurityBasicsArticleContent(),
            20,
            'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article21->title}");

        // Article 22: Deep Dive Topics
        $article22 = $createArticle(
            'javascript-advanced-topics',
            'JavaScript Advanced Topics: Closures, Hoisting, Prototypes & OOP, Execution Context, Event Loop, Debounce & Throttle',
            'Deep dive into advanced JavaScript concepts including closures, hoisting, prototypes and object-oriented programming, execution context, the event loop, and performance optimization techniques like debounce and throttle.',
            fn() => self::getAdvancedTopicsArticleContent(),
            21,
            'https://images.unsplash.com/photo-1579468118864-7b3a3c9d93ef?w=1200&h=630&fit=crop'
        );
        $this->command->info("Created article: {$article22->title}");

        $this->command->info('✅ Articles seeded successfully!');
    }

    private static function getJavaScriptOperatorsArticleContent(): string
    {
        return <<<'HTML'
<h1>Mastering JavaScript ES6+ Features: A Complete Guide</h1>

<p>Operators are the building blocks of JavaScript expressions. They allow you to perform operations on values and variables, making your code dynamic and functional. This comprehensive guide covers arithmetic operators, increment/decrement operators, comparison operators, and logical operators with practical examples and best practices.</p>

<figure class="image"><img title="JavaScript Operators" src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=1200&h=630&fit=crop" alt="JavaScript Operators" width="1200" height="630">
<figcaption>Understanding JavaScript operators is essential for writing effective code</figcaption>
</figure>

<h2>1. Arithmetic Operators</h2>

<p>Arithmetic operators perform mathematical operations on numbers. JavaScript supports all basic arithmetic operations.</p>

<h3>Addition (+) Operator</h3>

<p>The addition operator adds two numbers together. It can also be used for string concatenation.</p>

<pre><code class="language-javascript">// Number addition
let sum = 10 + 5;        // 15
let result = 3.5 + 2.1;  // 5.6

// String concatenation
let firstName = "John";
let lastName = "Doe";
let fullName = firstName + " " + lastName; // "John Doe"

// Mixed types (coercion)
console.log("10" + 5);   // "105" (string concatenation)
console.log(10 + "5");   // "105" (string concatenation)
console.log(10 + 5);     // 15 (number addition)
</code></pre>

<h3>Subtraction (-) Operator</h3>

<p>The subtraction operator subtracts the right operand from the left operand.</p>

<pre><code class="language-javascript">let difference = 10 - 5;      // 5
let negative = 5 - 10;         // -5
let decimal = 10.5 - 3.2;     // 7.3

// With variables
let a = 20;
let b = 8;
let result = a - b;           // 12
</code></pre>

<h3>Multiplication (*) Operator</h3>

<p>The multiplication operator multiplies two numbers.</p>

<pre><code class="language-javascript">let product = 5 * 4;          // 20
let area = 10.5 * 8.2;        // 86.1

// Calculating area of a rectangle
let width = 15;
let height = 10;
let area = width * height;    // 150
</code></pre>

<h3>Division (/) Operator</h3>

<p>The division operator divides the left operand by the right operand.</p>

<pre><code class="language-javascript">let quotient = 20 / 4;        // 5
let result = 15 / 2;          // 7.5
let decimal = 10 / 3;         // 3.3333333333333335

// Division by zero
console.log(10 / 0);          // Infinity
console.log(-10 / 0);         // -Infinity
console.log(0 / 0);           // NaN
</code></pre>

<h3>Modulo (%) Operator</h3>

<p>The modulo operator returns the remainder of a division operation.</p>

<pre><code class="language-javascript">let remainder = 10 % 3;       // 1 (10 divided by 3 is 3 with remainder 1)
let even = 8 % 2;             // 0 (8 is even)
let odd = 7 % 2;              // 1 (7 is odd)

// Practical use: Check if number is even or odd
function isEven(num) {
    return num % 2 === 0;
}

console.log(isEven(4));       // true
console.log(isEven(7));       // false

// Get last digit
let number = 12345;
let lastDigit = number % 10;  // 5
</code></pre>

<h3>Exponentiation (**) Operator</h3>

<p>The exponentiation operator raises the left operand to the power of the right operand (ES2016+).</p>

<pre><code class="language-javascript">let power = 2 ** 3;           // 8 (2 to the power of 3)
let square = 5 ** 2;          // 25
let cube = 3 ** 3;            // 27

// Equivalent to Math.pow()
console.log(2 ** 3 === Math.pow(2, 3)); // true
</code></pre>

<h2>2. Increment and Decrement Operators</h2>

<p>Increment (<code>++</code>) and decrement (<code>--</code>) operators increase or decrease a variable by 1. They can be used in prefix (before) or postfix (after) position, which affects when the operation occurs.</p>

<h3>Increment Operator (++)</h3>

<pre><code class="language-javascript">// Postfix increment (returns value, then increments)
let count = 5;
let result = count++;  // result = 5, count = 6
console.log(result);   // 5
console.log(count);    // 6

// Prefix increment (increments, then returns value)
let num = 5;
let result2 = ++num;   // num = 6, result2 = 6
console.log(result2);  // 6
console.log(num);      // 6

// Common usage in loops
for (let i = 0; i < 5; i++) {
    console.log(i);    // 0, 1, 2, 3, 4
}
</code></pre>

<h3>Decrement Operator (--)</h3>

<pre><code class="language-javascript">// Postfix decrement
let count = 5;
let result = count--;  // result = 5, count = 4
console.log(result);   // 5
console.log(count);    // 4

// Prefix decrement
let num = 5;
let result2 = --num;   // num = 4, result2 = 4
console.log(result2);  // 4
console.log(num);      // 4

// Countdown loop
for (let i = 5; i > 0; i--) {
    console.log(i);    // 5, 4, 3, 2, 1
}
</code></pre>

<h3>Understanding Prefix vs Postfix</h3>

<pre><code class="language-javascript">// Postfix: Use value first, then increment
let a = 5;
let b = a++;  // b = 5, a = 6
console.log(a, b); // 6, 5

// Prefix: Increment first, then use value
let x = 5;
let y = ++x;  // x = 6, y = 6
console.log(x, y); // 6, 6

// Practical example
let index = 0;
let current = index++;  // Get current index (0), then increment
console.log(current);    // 0
console.log(index);      // 1

let next = ++index;      // Increment first, then get value
console.log(next);       // 2
console.log(index);      // 2
</code></pre>

<h2>3. Comparison Operators</h2>

<p>Comparison operators compare two values and return a boolean (<code>true</code> or <code>false</code>). JavaScript has both strict (===, !==) and loose (==, !=) comparison operators.</p>

<h3>Equality Operators</h3>

<pre><code class="language-javascript">// Strict equality (===) - checks value and type
console.log(5 === 5);        // true
console.log(5 === "5");      // false (different types)
console.log(true === 1);     // false
console.log(null === undefined); // false

// Strict inequality (!==)
console.log(5 !== 5);        // false
console.log(5 !== "5");      // true
console.log(true !== 1);     // true

// Loose equality (==) - performs type coercion
console.log(5 == 5);         // true
console.log(5 == "5");       // true (coerces string to number)
console.log(true == 1);      // true (coerces boolean to number)
console.log(null == undefined); // true

// Loose inequality (!=)
console.log(5 != "5");       // false (coerces and compares)
console.log(5 != 6);         // true
</code></pre>

<h3>Relational Operators</h3>

<pre><code class="language-javascript">// Greater than (>)
console.log(10 > 5);         // true
console.log(5 > 10);         // false
console.log(5 > 5);          // false

// Greater than or equal (>=)
console.log(10 >= 5);        // true
console.log(5 >= 10);        // false
console.log(5 >= 5);         // true

// Less than (<)
console.log(5 < 10);         // true
console.log(10 < 5);         // false
console.log(5 < 5);          // false

// Less than or equal (<=)
console.log(5 <= 10);        // true
console.log(10 <= 5);        // false
console.log(5 <= 5);         // true

// String comparison (lexicographic)
console.log("apple" < "banana"); // true
console.log("zebra" > "apple");  // true
console.log("10" > "2");         // false (string comparison)
console.log(10 > 2);             // true (number comparison)
</code></pre>

<h3>Best Practices: Strict vs Loose Equality</h3>

<pre><code class="language-javascript">// ✅ Good: Always use strict equality (===)
if (age === 18) {
    console.log("You're 18!");
}

// ❌ Avoid: Loose equality can cause bugs
if (age == 18) {
    // This might match "18" (string) too!
}

// Common pitfalls with loose equality
console.log(0 == false);     // true (unexpected!)
console.log("" == false);    // true (unexpected!)
console.log(null == undefined); // true
console.log([] == false);    // true (unexpected!)

// Strict equality avoids these issues
console.log(0 === false);    // false (correct!)
console.log("" === false);   // false (correct!)
console.log(null === undefined); // false (correct!)
console.log([] === false);   // false (correct!)
</code></pre>

<h2>4. Logical Operators</h2>

<p>Logical operators are used to combine or negate boolean values. They're essential for conditional logic and flow control.</p>

<h3>Logical AND (&&)</h3>

<pre><code class="language-javascript">// Returns true if both operands are true
console.log(true && true);   // true
console.log(true && false);  // false
console.log(false && true);  // false
console.log(false && false); // false

// Short-circuit evaluation
let user = { name: "John", age: 25 };
if (user && user.age >= 18) {
    console.log("User is an adult");
}

// Practical use: Default values
let name = user && user.name; // Returns name if user exists, otherwise undefined
</code></pre>

<h3>Logical OR (||)</h3>

<pre><code class="language-javascript">// Returns true if at least one operand is true
console.log(true || true);   // true
console.log(true || false);  // true
console.log(false || true);  // true
console.log(false || false); // false

// Short-circuit evaluation
let username = user.name || "Guest"; // Use name if exists, otherwise "Guest"

// Practical use: Fallback values
let port = process.env.PORT || 3000; // Use PORT if set, otherwise 3000
</code></pre>

<h3>Logical NOT (!)</h3>

<pre><code class="language-javascript">// Negates the boolean value
console.log(!true);   // false
console.log(!false);  // true
console.log(!0);      // true (0 is falsy)
console.log(!"");     // true (empty string is falsy)
console.log(!null);   // true

// Double negation (!!) converts to boolean
console.log(!!"hello"); // true
console.log(!!0);       // false
console.log(!!null);    // false
</code></pre>

<h2>5. Operator Precedence</h2>

<p>ES6 introduced Promises, and ES2017 added async/await, making asynchronous code much more readable.</p>

<h3>Promises</h3>

<pre><code class="language-javascript">// Creating a Promise
const fetchData = () => {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            resolve('Data fetched successfully');
        }, 1000);
    });
};

// Using Promises
fetchData()
    .then(data => console.log(data))
    .catch(error => console.error(error));
</code></pre>

<h2>5. Operator Precedence</h2>

<p>ES6 introduced class syntax, providing a cleaner way to work with object-oriented programming in JavaScript.</p>

<pre><code class="language-javascript">// Class definition
class User {
    constructor(name, email) {
        this.name = name;
        this.email = email;
    }

    // Method
    greet() {
        return `Hello, I'm ${this.name}`;
    }

    // Static method
    static createAdmin(name, email) {
        const admin = new User(name, email);
        admin.role = 'admin';
        return admin;
    }
}

// Inheritance
class Admin extends User {
    constructor(name, email, permissions) {
        super(name, email);
        this.permissions = permissions;
    }

    deleteUser(userId) {
        console.log(`Deleting user ${userId}`);
    }
}

// Usage
const admin = new Admin('John', 'john@example.com', ['read', 'write', 'delete']);
console.log(admin.greet());
</code></pre>

<h2>7. Modules (import/export)</h2>

<p>ES6 modules provide a standardized way to organize and share code between files.</p>

<h3>Exporting</h3>

<pre><code class="language-javascript">// math.js
export const PI = 3.14159;

export function add(a, b) {
    return a + b;
}

export function subtract(a, b) {
    return a - b;
}

// Default export
export default class Calculator {
    multiply(a, b) {
        return a * b;
    }
}
</code></pre>

<h3>Importing</h3>

<pre><code class="language-javascript">// app.js
import Calculator, { PI, add, subtract } from './math.js';

console.log(PI); // 3.14159
console.log(add(5, 3)); // 8

const calc = new Calculator();
console.log(calc.multiply(4, 5)); // 20
</code></pre>

<h2>8. Map and Set</h2>

<p>ES6 introduced Map and Set data structures, providing better alternatives to objects and arrays in certain scenarios.</p>

<h3>Map</h3>

<pre><code class="language-javascript">// Creating a Map
const userMap = new Map();

// Adding entries
userMap.set('name', 'John');
userMap.set('age', 30);
userMap.set(1, 'One'); // Keys can be any type

// Getting values
console.log(userMap.get('name')); // John

// Iterating
userMap.forEach((value, key) => {
    console.log(`${key}: ${value}`);
});
</code></pre>

<h3>Set</h3>

<pre><code class="language-javascript">// Creating a Set
const uniqueNumbers = new Set([1, 2, 3, 3, 4, 4, 5]);
console.log(uniqueNumbers); // Set {1, 2, 3, 4, 5}

// Adding values
uniqueNumbers.add(6);

// Checking existence
console.log(uniqueNumbers.has(3)); // true

// Removing values
uniqueNumbers.delete(3);
</code></pre>

<h2>9. Array Methods</h2>

<p>ES6 introduced several powerful array methods that make data manipulation easier.</p>

<pre><code class="language-javascript">const numbers = [1, 2, 3, 4, 5];

// map() - Transform each element
const doubled = numbers.map(n => n * 2); // [2, 4, 6, 8, 10]

// filter() - Filter elements
const evens = numbers.filter(n => n % 2 === 0); // [2, 4]

// reduce() - Reduce to a single value
const sum = numbers.reduce((acc, n) => acc + n, 0); // 15

// find() - Find first matching element
const found = numbers.find(n => n > 3); // 4

// some() - Check if any element matches
const hasEven = numbers.some(n => n % 2 === 0); // true

// every() - Check if all elements match
const allPositive = numbers.every(n => n > 0); // true
</code></pre>

<h2>10. Optional Chaining and Nullish Coalescing</h2>

<p>ES2020 introduced optional chaining (<code>?.</code>) and nullish coalescing (<code>??</code>) operators for safer property access and default values.</p>

<pre><code class="language-javascript">// Optional chaining
const user = {
    profile: {
        name: 'John',
        address: {
            city: 'New York'
        }
    }
};

// Safe property access
const city = user?.profile?.address?.city; // 'New York'
const zip = user?.profile?.address?.zip; // undefined (no error)

// Nullish coalescing
const name = user?.name ?? 'Anonymous';
const age = user?.age ?? 0; // Only uses default if null or undefined

// Combined
const displayName = user?.profile?.name ?? 'Guest';
</code></pre>

<h2>Best Practices</h2>

<p>When using ES6+ features, keep these best practices in mind:</p>

<ul>
<li>Use <code>const</code> by default, <code>let</code> when reassignment is needed</li>
<li>Prefer arrow functions for callbacks and short functions</li>
<li>Use template literals instead of string concatenation</li>
<li>Leverage destructuring for cleaner code</li>
<li>Use async/await for better readability with Promises</li>
<li>Take advantage of array methods for data manipulation</li>
</ul>

<h2>Conclusion</h2>

<p>ES6+ features have transformed JavaScript into a modern, powerful language. By mastering these features, you'll write more efficient, readable, and maintainable code. Start incorporating these features into your projects gradually, and you'll see significant improvements in your code quality.</p>

<p>Operator precedence determines the order in which operators are evaluated in an expression. Understanding precedence helps you write correct code and avoid bugs.</p>

<pre><code class="language-javascript">// Multiplication has higher precedence than addition
let result = 2 + 3 * 4;      // 14 (not 20)
// Equivalent to: 2 + (3 * 4)

// Use parentheses to control order
let result2 = (2 + 3) * 4;  // 20

// Comparison operators have lower precedence than arithmetic
let isValid = 5 + 3 > 7;     // true (8 > 7)
// Equivalent to: (5 + 3) > 7

// Logical operators have lower precedence than comparison
let canAccess = age >= 18 && isMember; // (age >= 18) && isMember
</code></pre>

<h3>Common Precedence Order (High to Low)</h3>

<ol>
<li>Grouping: <code>()</code></li>
<li>Increment/Decrement: <code>++</code>, <code>--</code></li>
<li>Exponentiation: <code>**</code></li>
<li>Multiplication, Division, Modulo: <code>*</code>, <code>/</code>, <code>%</code></li>
<li>Addition, Subtraction: <code>+</code>, <code>-</code></li>
<li>Comparison: <code>&lt;</code>, <code>&gt;</code>, <code>&lt;=</code>, <code>&gt;=</code></li>
<li>Equality: <code>==</code>, <code>!=</code>, <code>===</code>, <code>!==</code></li>
<li>Logical AND: <code>&&</code></li>
<li>Logical OR: <code>||</code></li>
</ol>

<h2>6. Assignment Operators</h2>

<p>Assignment operators assign values to variables. JavaScript provides shorthand assignment operators that combine assignment with arithmetic operations.</p>

<pre><code class="language-javascript">// Basic assignment
let x = 10;

// Addition assignment (+=)
let count = 5;
count += 3;  // Equivalent to: count = count + 3
console.log(count); // 8

// Subtraction assignment (-=)
let total = 100;
total -= 20; // Equivalent to: total = total - 20
console.log(total); // 80

// Multiplication assignment (*=)
let price = 10;
price *= 1.2; // Equivalent to: price = price * 1.2
console.log(price); // 12

// Division assignment (/=)
let value = 100;
value /= 4;  // Equivalent to: value = value / 4
console.log(value); // 25

// Modulo assignment (%=)
let num = 10;
num %= 3;    // Equivalent to: num = num % 3
console.log(num); // 1

// Exponentiation assignment (**=)
let base = 2;
base **= 3;  // Equivalent to: base = base ** 3
console.log(base); // 8
</code></pre>

<h2>7. Best Practices</h2>

<h3>Always Use Strict Equality</h3>

<pre><code class="language-javascript">// ✅ Good
if (age === 18) { }
if (name !== "") { }

// ❌ Avoid
if (age == 18) { }
if (name != "") { }
</code></pre>

<h3>Use Parentheses for Clarity</h3>

<pre><code class="language-javascript">// ✅ Clear intent
if ((age >= 18) && (isMember || isGuest)) { }

// ❌ Less clear (though correct)
if (age >= 18 && isMember || isGuest) { }
</code></pre>

<h3>Understand Prefix vs Postfix</h3>

<pre><code class="language-javascript">// Use postfix in loops
for (let i = 0; i < 10; i++) { }

// Use prefix when you need the incremented value
let index = 0;
let current = ++index; // current = 1, index = 1
</code></pre>

<h2>Conclusion</h2>

<p>Operators are fundamental to JavaScript programming. Mastering them will help you write more efficient and correct code. Remember:</p>

<ul>
<li>Use strict equality (<code>===</code>, <code>!==</code>) instead of loose equality</li>
<li>Understand operator precedence or use parentheses for clarity</li>
<li>Know the difference between prefix and postfix increment/decrement</li>
<li>Use assignment operators for cleaner code</li>
<li>Leverage logical operators for conditional logic</li>
</ul>

<p>Practice using these operators in your code, and you'll become more confident in writing JavaScript expressions. Start with simple examples and gradually work your way up to more complex expressions!</p>
HTML;
    }

    private static function getControlFlowIfElseArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: Control Flow with if, else if, and else</h1>

<p>Control flow statements are fundamental to programming. They allow your code to make decisions and execute different blocks of code based on conditions. In JavaScript, the <code>if</code>, <code>else if</code>, and <code>else</code> statements are the primary tools for creating conditional logic.</p>

<figure class="image"><img title="JavaScript Control Flow" src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=1200&h=630&fit=crop" alt="JavaScript Control Flow" width="1200" height="630">
<figcaption>Understanding control flow is essential for writing dynamic JavaScript applications</figcaption>
</figure>

<h2>What is Control Flow?</h2>

<p>Control flow determines the order in which statements are executed in a program. Conditional statements allow you to execute different code blocks based on whether certain conditions are true or false.</p>

<h2>1. The if Statement</h2>

<p>The <code>if</code> statement is the most basic conditional statement. It executes a block of code only if a specified condition is true.</p>

<h3>Basic Syntax</h3>

<pre><code class="language-javascript">if (condition) {
    // Code to execute if condition is true
}
</code></pre>

<h3>Simple Example</h3>

<pre><code class="language-javascript">let age = 18;

if (age >= 18) {
    console.log("You are an adult");
}
// Output: "You are an adult"
</code></pre>

<h3>Single Statement (Optional Braces)</h3>

<pre><code class="language-javascript">let temperature = 25;

// With braces (recommended)
if (temperature > 20) {
    console.log("It's warm outside");
}

// Without braces (works but not recommended)
if (temperature > 20)
    console.log("It's warm outside");
</code></pre>

<h3>Truthy and Falsy Values</h3>

<pre><code class="language-javascript">// Falsy values: false, 0, "", null, undefined, NaN
// Everything else is truthy

if (true) {
    console.log("This runs");
}

if (1) {
    console.log("This also runs (1 is truthy)");
}

if (0) {
    console.log("This doesn't run (0 is falsy)");
}

if ("hello") {
    console.log("This runs (non-empty string is truthy)");
}

if ("") {
    console.log("This doesn't run (empty string is falsy)");
}

if (null) {
    console.log("This doesn't run");
}

if (undefined) {
    console.log("This doesn't run");
}
</code></pre>

<h2>2. The else Statement</h2>

<p>The <code>else</code> statement provides an alternative code block that executes when the <code>if</code> condition is false.</p>

<h3>Basic Syntax</h3>

<pre><code class="language-javascript">if (condition) {
    // Code if condition is true
} else {
    // Code if condition is false
}
</code></pre>

<h3>Example</h3>

<pre><code class="language-javascript">let age = 16;

if (age >= 18) {
    console.log("You are an adult");
} else {
    console.log("You are a minor");
}
// Output: "You are a minor"
</code></pre>

<h3>Practical Example: Grade Checker</h3>

<pre><code class="language-javascript">let score = 85;

if (score >= 70) {
    console.log("You passed!");
} else {
    console.log("You failed. Study harder!");
}
</code></pre>

<h2>3. The else if Statement</h2>

<p>The <code>else if</code> statement allows you to check multiple conditions in sequence. It's used when you need to test more than two possible outcomes.</p>

<h3>Basic Syntax</h3>

<pre><code class="language-javascript">if (condition1) {
    // Code if condition1 is true
} else if (condition2) {
    // Code if condition1 is false but condition2 is true
} else if (condition3) {
    // Code if condition1 and condition2 are false but condition3 is true
} else {
    // Code if all conditions are false
}
</code></pre>

<h3>Example: Grade System</h3>

<pre><code class="language-javascript">let score = 85;

if (score >= 90) {
    console.log("Grade: A");
} else if (score >= 80) {
    console.log("Grade: B");
} else if (score >= 70) {
    console.log("Grade: C");
} else if (score >= 60) {
    console.log("Grade: D");
} else {
    console.log("Grade: F");
}
// Output: "Grade: B"
</code></pre>

<h3>Example: Temperature Checker</h3>

<pre><code class="language-javascript">let temperature = 15;

if (temperature > 30) {
    console.log("It's hot outside");
} else if (temperature > 20) {
    console.log("It's warm outside");
} else if (temperature > 10) {
    console.log("It's mild outside");
} else {
    console.log("It's cold outside");
}
// Output: "It's mild outside"
</code></pre>

<h3>Multiple Conditions with Logical Operators</h3>

<pre><code class="language-javascript">let age = 25;
let hasLicense = true;

if (age >= 18 && hasLicense) {
    console.log("You can drive");
} else if (age >= 18 && !hasLicense) {
    console.log("You need a license to drive");
} else {
    console.log("You're too young to drive");
}
</code></pre>

<h2>4. Nested if Statements</h2>

<p>You can nest <code>if</code> statements inside other <code>if</code> statements to create more complex conditional logic.</p>

<pre><code class="language-javascript">let age = 25;
let hasLicense = true;

if (age >= 18) {
    if (hasLicense) {
        console.log("You can drive");
    } else {
        console.log("You need a license");
    }
} else {
    console.log("You're too young to drive");
}
</code></pre>

<h3>Example: User Authentication</h3>

<pre><code class="language-javascript">let isLoggedIn = true;
let isAdmin = false;
let hasPermission = true;

if (isLoggedIn) {
    if (isAdmin) {
        console.log("Welcome, Admin!");
    } else if (hasPermission) {
        console.log("Welcome, User!");
    } else {
        console.log("You don't have permission");
    }
} else {
    console.log("Please log in");
}
</code></pre>

<h2>5. Ternary Operator (Conditional Operator)</h2>

<p>The ternary operator is a shorthand way to write simple <code>if-else</code> statements.</p>

<h3>Syntax</h3>

<pre><code class="language-javascript">condition ? valueIfTrue : valueIfFalse
</code></pre>

<h3>Example</h3>

<pre><code class="language-javascript">let age = 20;
let message = age >= 18 ? "Adult" : "Minor";
console.log(message); // "Adult"

// Equivalent to:
let message2;
if (age >= 18) {
    message2 = "Adult";
} else {
    message2 = "Minor";
}
</code></pre>

<h3>Nested Ternary (Use Sparingly)</h3>

<pre><code class="language-javascript">let score = 85;
let grade = score >= 90 ? "A" : score >= 80 ? "B" : score >= 70 ? "C" : "F";
console.log(grade); // "B"

// More readable version:
let grade2 = score >= 90 ? "A" 
           : score >= 80 ? "B" 
           : score >= 70 ? "C" 
           : "F";
</code></pre>

<h2>6. Common Patterns and Best Practices</h2>

<h3>Early Returns</h3>

<pre><code class="language-javascript">function checkAge(age) {
    if (age < 0) {
        return "Invalid age";
    }
    
    if (age < 18) {
        return "Minor";
    }
    
    if (age < 65) {
        return "Adult";
    }
    
    return "Senior";
}
</code></pre>

<h3>Guard Clauses</h3>

<pre><code class="language-javascript">function processUser(user) {
    // Guard clause: early return for invalid input
    if (!user) {
        return null;
    }
    
    if (!user.email) {
        return null;
    }
    
    // Main logic here
    return user.email.toUpperCase();
}
</code></pre>

<h3>Using Strict Equality</h3>

<pre><code class="language-javascript">// ✅ Good: Use ===
if (value === 5) {
    // ...
}

// ❌ Avoid: Loose equality
if (value == 5) {
    // Can cause unexpected behavior
}
</code></pre>

<h3>Clear Condition Names</h3>

<pre><code class="language-javascript">// ✅ Good: Clear variable names
let isAdult = age >= 18;
let hasValidEmail = email && email.includes("@");

if (isAdult && hasValidEmail) {
    // ...
}

// ❌ Less clear
if (age >= 18 && email && email.includes("@")) {
    // ...
}
</code></pre>

<h2>7. Common Mistakes to Avoid</h2>

<h3>Assignment Instead of Comparison</h3>

<pre><code class="language-javascript">let value = 5;

// ❌ Wrong: Assignment (=) instead of comparison (===)
if (value = 10) {  // This assigns 10 to value and always evaluates to true!
    console.log("This always runs");
}

// ✅ Correct: Use === for comparison
if (value === 10) {
    console.log("This only runs if value is 10");
}
</code></pre>

<h3>Missing Braces</h3>

<pre><code class="language-javascript">// ❌ Can lead to bugs
if (condition)
    doSomething();
    doSomethingElse(); // This always runs!

// ✅ Always use braces
if (condition) {
    doSomething();
    doSomethingElse();
}
</code></pre>

<h3>Unnecessary else After Return</h3>

<pre><code class="language-javascript">// ❌ Unnecessary else
function checkValue(value) {
    if (value > 0) {
        return "Positive";
    } else {
        return "Not positive";
    }
}

// ✅ Better: Early return
function checkValue(value) {
    if (value > 0) {
        return "Positive";
    }
    return "Not positive";
}
</code></pre>

<h2>8. Practical Examples</h2>

<h3>Example 1: Login System</h3>

<pre><code class="language-javascript">function login(username, password) {
    if (!username || !password) {
        return "Username and password are required";
    }
    
    if (username === "admin" && password === "secret") {
        return "Login successful";
    } else if (username === "admin") {
        return "Incorrect password";
    } else {
        return "User not found";
    }
}
</code></pre>

<h3>Example 2: Discount Calculator</h3>

<pre><code class="language-javascript">function calculateDiscount(price, isMember, couponCode) {
    let discount = 0;
    
    if (isMember) {
        discount = 0.1; // 10% member discount
    }
    
    if (couponCode === "SAVE20") {
        discount = Math.max(discount, 0.2); // 20% coupon (use higher discount)
    } else if (couponCode === "SAVE10") {
        discount = Math.max(discount, 0.1); // 10% coupon
    }
    
    return price * (1 - discount);
}

console.log(calculateDiscount(100, true, "SAVE20")); // 80
</code></pre>

<h3>Example 3: Age-Based Access Control</h3>

<pre><code class="language-javascript">function checkAccess(age, hasPermission) {
    if (age < 13) {
        return "Access denied: Too young";
    } else if (age < 18 && !hasPermission) {
        return "Access denied: Parental permission required";
    } else if (age >= 18) {
        return "Access granted";
    } else {
        return "Access granted with permission";
    }
}
</code></pre>

<h2>Conclusion</h2>

<p>Control flow with <code>if</code>, <code>else if</code>, and <code>else</code> statements is fundamental to JavaScript programming. Remember:</p>

<ul>
<li>Use <code>if</code> for single conditions</li>
<li>Use <code>else</code> for alternative execution paths</li>
<li>Use <code>else if</code> for multiple conditions</li>
<li>Always use strict equality (<code>===</code>)</li>
<li>Use clear, descriptive condition names</li>
<li>Prefer early returns and guard clauses for cleaner code</li>
<li>Always use braces, even for single statements</li>
</ul>

<p>Mastering control flow will help you write more dynamic and responsive JavaScript applications. Practice with different scenarios and gradually build more complex conditional logic!</p>
HTML;
    }

    private static function getLogicalOperatorsArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: Logical Operators (&&, ||, !)</h1>

<p>Logical operators are essential tools for combining conditions and controlling program flow in JavaScript. They allow you to create complex conditional logic by combining multiple boolean expressions. This guide covers the three main logical operators: AND (<code>&&</code>), OR (<code>||</code>), and NOT (<code>!</code>).</p>

<figure class="image"><img title="JavaScript Logical Operators" src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&h=630&fit=crop" alt="JavaScript Logical Operators" width="1200" height="630">
<figcaption>Logical operators enable powerful conditional logic in JavaScript</figcaption>
</figure>

<h2>Overview of Logical Operators</h2>

<p>JavaScript has three logical operators that work with boolean values:</p>

<ul>
<li><strong>AND (<code>&&</code>):</strong> Returns <code>true</code> if both operands are true</li>
<li><strong>OR (<code>||</code>):</strong> Returns <code>true</code> if at least one operand is true</li>
<li><strong>NOT (<code>!</code>):</strong> Negates the boolean value</li>
</ul>

<h2>1. Logical AND Operator (&&)</h2>

<p>The <code>&&</code> operator returns <code>true</code> only if both operands are <code>true</code>. If the first operand is <code>false</code>, it doesn't evaluate the second operand (short-circuit evaluation).</p>

<h3>Truth Table</h3>

<pre><code class="language-javascript">console.log(true && true);   // true
console.log(true && false);  // false
console.log(false && true);   // false
console.log(false && false); // false
</code></pre>

<h3>Basic Usage</h3>

<pre><code class="language-javascript">let age = 25;
let hasLicense = true;

if (age >= 18 && hasLicense) {
    console.log("You can drive");
}
// Output: "You can drive"

// Both conditions must be true
if (age >= 18 && age < 65) {
    console.log("Working age");
}
</code></pre>

<h3>Short-Circuit Evaluation</h3>

<p>The <code>&&</code> operator uses short-circuit evaluation. If the left operand is falsy, it returns that value without evaluating the right operand.</p>

<pre><code class="language-javascript">// If first condition is false, second is not evaluated
let result = false && console.log("This won't run");
// result is false, console.log never executes

// If first condition is true, second is evaluated
let result2 = true && console.log("This will run");
// Output: "This will run"
</code></pre>

<h3>Practical Use: Default Values</h3>

<pre><code class="language-javascript">let user = { name: "John" };

// Return name if user exists, otherwise undefined
let name = user && user.name;
console.log(name); // "John"

let user2 = null;
let name2 = user2 && user2.name;
console.log(name2); // null (doesn't throw error)
</code></pre>

<h3>Multiple Conditions</h3>

<pre><code class="language-javascript">let age = 25;
let hasLicense = true;
let hasInsurance = true;

if (age >= 18 && hasLicense && hasInsurance) {
    console.log("You can legally drive");
}
</code></pre>

<h2>2. Logical OR Operator (||)</h2>

<p>The <code>||</code> operator returns <code>true</code> if at least one operand is <code>true</code>. If the first operand is <code>true</code>, it doesn't evaluate the second operand (short-circuit evaluation).</p>

<h3>Truth Table</h3>

<pre><code class="language-javascript">console.log(true || true);   // true
console.log(true || false);  // true
console.log(false || true);   // true
console.log(false || false); // false
</code></pre>

<h3>Basic Usage</h3>

<pre><code class="language-javascript">let isWeekend = false;
let isHoliday = true;

if (isWeekend || isHoliday) {
    console.log("No work today!");
}
// Output: "No work today!"
</code></pre>

<h3>Short-Circuit Evaluation</h3>

<pre><code class="language-javascript">// If first condition is true, second is not evaluated
let result = true || console.log("This won't run");
// result is true, console.log never executes

// If first condition is false, second is evaluated
let result2 = false || console.log("This will run");
// Output: "This will run"
</code></pre>

<h3>Practical Use: Fallback Values</h3>

<pre><code class="language-javascript">// Default value pattern
let username = user.name || "Guest";
console.log(username); // Uses name if exists, otherwise "Guest"

let port = process.env.PORT || 3000;
// Uses PORT environment variable if set, otherwise 3000

let theme = user.preferredTheme || "dark";
// Uses preferred theme if set, otherwise "dark"
</code></pre>

<h3>Multiple Conditions</h3>

<pre><code class="language-javascript">let day = "Saturday";

if (day === "Saturday" || day === "Sunday" || day === "Friday") {
    console.log("Weekend or Friday!");
}
</code></pre>

<h2>3. Logical NOT Operator (!)</h2>

<p>The <code>!</code> operator negates a boolean value. It converts <code>true</code> to <code>false</code> and <code>false</code> to <code>true</code>.</p>

<h3>Basic Usage</h3>

<pre><code class="language-javascript">console.log(!true);   // false
console.log(!false);  // true

let isLoggedIn = false;

if (!isLoggedIn) {
    console.log("Please log in");
}
// Output: "Please log in"
</code></pre>

<h3>With Truthy and Falsy Values</h3>

<pre><code class="language-javascript">// Falsy values become true
console.log(!0);        // true
console.log(!"");       // true
console.log(!null);     // true
console.log(!undefined); // true
console.log(!NaN);      // true
console.log(!false);    // true

// Truthy values become false
console.log(!1);        // false
console.log(!"hello");  // false
console.log(![]);       // false
console.log(!{});       // false
</code></pre>

<h3>Double Negation (!!)</h3>

<p>Double negation (<code>!!</code>) converts any value to a boolean.</p>

<pre><code class="language-javascript">console.log(!!"hello"); // true
console.log(!!0);       // false
console.log(!!null);    // false
console.log(!!undefined); // false
console.log(!!42);      // true
console.log(!![]);      // true
console.log(!!{});      // true

// Equivalent to Boolean()
console.log(!!value === Boolean(value)); // true
</code></pre>

<h3>Practical Use: Inverting Conditions</h3>

<pre><code class="language-javascript">let isDisabled = false;

if (!isDisabled) {
    console.log("Button is enabled");
}

let isEmpty = false;
if (!isEmpty) {
    console.log("List has items");
}
</code></pre>

<h2>4. Combining Logical Operators</h2>

<h3>Complex Conditions</h3>

<pre><code class="language-javascript">let age = 25;
let hasLicense = true;
let hasInsurance = false;
let isWeekend = true;

// Complex condition
if ((age >= 18 && hasLicense) && (hasInsurance || isWeekend)) {
    console.log("You can drive");
}
</code></pre>

<h3>Operator Precedence</h3>

<pre><code class="language-javascript">// && has higher precedence than ||
let result1 = true || false && false;
// Evaluates as: true || (false && false)
// Result: true

// Use parentheses for clarity
let result2 = (true || false) && false;
// Evaluates as: (true || false) && false
// Result: false
</code></pre>

<h3>Example: User Permissions</h3>

<pre><code class="language-javascript">let isAdmin = false;
let isModerator = true;
let isBanned = false;

if ((isAdmin || isModerator) && !isBanned) {
    console.log("You have moderation privileges");
}
</code></pre>

<h2>5. Practical Examples</h2>

<h3>Example 1: Form Validation</h3>

<pre><code class="language-javascript">function validateForm(email, password, age) {
    if (!email || !password) {
        return "Email and password are required";
    }
    
    if (age < 18 || age > 100) {
        return "Age must be between 18 and 100";
    }
    
    if (email.includes("@") && password.length >= 8) {
        return "Form is valid";
    }
    
    return "Invalid email or password too short";
}
</code></pre>

<h3>Example 2: Access Control</h3>

<pre><code class="language-javascript">function checkAccess(user) {
    let isAdmin = user.role === "admin";
    let isMember = user.role === "member";
    let isActive = user.status === "active";
    let hasSubscription = user.subscription !== null;
    
    if (isAdmin || (isMember && isActive && hasSubscription)) {
        return "Access granted";
    }
    
    return "Access denied";
}
</code></pre>

<h3>Example 3: Feature Flags</h3>

<pre><code class="language-javascript">let featureEnabled = true;
let userHasPermission = true;
let isBetaUser = false;

if (featureEnabled && (userHasPermission || isBetaUser)) {
    console.log("Feature is available");
}
</code></pre>

<h2>6. Common Patterns</h2>

<h3>Pattern 1: Conditional Execution</h3>

<pre><code class="language-javascript">// Execute function only if condition is true
let user = { name: "John" };
user && user.logout && user.logout();

// Set default value
let theme = user.preferredTheme || "dark";
</code></pre>

<h3>Pattern 2: Guard Clauses</h3>

<pre><code class="language-javascript">function processData(data) {
    if (!data || !data.isValid) {
        return null;
    }
    
    // Process data here
    return data.processed;
}
</code></pre>

<h3>Pattern 3: Optional Chaining Alternative</h3>

<pre><code class="language-javascript">// Before optional chaining (ES2020)
let city = user && user.address && user.address.city;

// With optional chaining (modern)
let city2 = user?.address?.city;
</code></pre>

<h2>7. Best Practices</h2>

<h3>Use Parentheses for Clarity</h3>

<pre><code class="language-javascript">// ✅ Clear intent
if ((age >= 18 && hasLicense) || isEmergency) {
    // ...
}

// ❌ Less clear
if (age >= 18 && hasLicense || isEmergency) {
    // ...
}
</code></pre>

<h3>Extract Complex Conditions</h3>

<pre><code class="language-javascript">// ✅ Clear and readable
let canDrive = age >= 18 && hasLicense && !isSuspended;
let isWeekend = day === "Saturday" || day === "Sunday";

if (canDrive && isWeekend) {
    console.log("Weekend drive allowed");
}

// ❌ Hard to read
if (age >= 18 && hasLicense && !isSuspended && (day === "Saturday" || day === "Sunday")) {
    console.log("Weekend drive allowed");
}
</code></pre>

<h3>Avoid Overusing !</h3>

<pre><code class="language-javascript">// ❌ Hard to read
if (!(!isDisabled && !isHidden)) {
    // ...
}

// ✅ Clearer
if (isDisabled || isHidden) {
    // ...
}
</code></pre>

<h2>8. Common Mistakes</h2>

<h3>Mistake 1: Using && Instead of ||</h3>

<pre><code class="language-javascript">// ❌ Wrong: This will never be true
if (age < 18 && age > 65) {
    // This condition can never be true!
}

// ✅ Correct
if (age < 18 || age > 65) {
    console.log("Special pricing applies");
}
</code></pre>

<h3>Mistake 2: Confusing && and ||</h3>

<pre><code class="language-javascript">// ❌ Wrong logic
if (isAdmin && isModerator) {
    // This requires BOTH to be true
}

// ✅ Correct: Use || for "either"
if (isAdmin || isModerator) {
    console.log("Has moderation rights");
}
</code></pre>

<h3>Mistake 3: Not Understanding Short-Circuit</h3>

<pre><code class="language-javascript">// ❌ This might not work as expected
let result = user && user.getName();
// If user is null, getName() is never called (good!)
// But result will be null, not undefined

// ✅ Better: Handle the case explicitly
let result = user ? user.getName() : null;
</code></pre>

<h2>Conclusion</h2>

<p>Logical operators are powerful tools for creating conditional logic in JavaScript. Remember:</p>

<ul>
<li><code>&&</code> returns <code>true</code> only if both operands are true</li>
<li><code>||</code> returns <code>true</code> if at least one operand is true</li>
<li><code>!</code> negates a boolean value</li>
<li>Both <code>&&</code> and <code>||</code> use short-circuit evaluation</li>
<li>Use parentheses to clarify complex conditions</li>
<li>Extract complex conditions into variables for readability</li>
<li>Understand truthy and falsy values when using logical operators</li>
</ul>

<p>Mastering logical operators will help you write more efficient and readable conditional code. Practice combining them in different scenarios to build your understanding!</p>
HTML;
    }

    private static function getSwitchStatementArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: Switch Statement Complete Guide</h1>

<p>The <code>switch</code> statement provides an elegant way to handle multiple conditions by matching a value against various cases. It's often cleaner and more readable than long chains of <code>if-else</code> statements when dealing with multiple discrete values.</p>

<figure class="image"><img title="JavaScript Switch Statement" src="https://images.unsplash.com/photo-1551650975-87deedd944c3?w=1200&h=630&fit=crop" alt="JavaScript Switch Statement" width="1200" height="630">
<figcaption>The switch statement simplifies multi-way decision making in JavaScript</figcaption>
</figure>

<h2>What is a Switch Statement?</h2>

<p>A <code>switch</code> statement evaluates an expression and matches it against multiple case clauses. When a match is found, the code in that case is executed. It's particularly useful when you have many conditions to check against a single value.</p>

<h2>1. Basic Switch Syntax</h2>

<h3>Structure</h3>

<pre><code class="language-javascript">switch (expression) {
    case value1:
        // Code to execute if expression === value1
        break;
    case value2:
        // Code to execute if expression === value2
        break;
    default:
        // Code to execute if no case matches
        break;
}
</code></pre>

<h3>Simple Example</h3>

<pre><code class="language-javascript">let day = "Monday";

switch (day) {
    case "Monday":
        console.log("Start of the work week");
        break;
    case "Friday":
        console.log("TGIF!");
        break;
    case "Saturday":
    case "Sunday":
        console.log("Weekend!");
        break;
    default:
        console.log("Midweek day");
        break;
}
// Output: "Start of the work week"
</code></pre>

<h2>2. The break Statement</h2>

<p>The <code>break</code> statement is crucial in switch statements. Without it, execution will "fall through" to the next case, which is usually not what you want.</p>

<h3>With break (Correct)</h3>

<pre><code class="language-javascript">let grade = "B";

switch (grade) {
    case "A":
        console.log("Excellent!");
        break;
    case "B":
        console.log("Good job!");
        break;
    case "C":
        console.log("Average");
        break;
    default:
        console.log("Keep trying");
        break;
}
// Output: "Good job!"
</code></pre>

<h3>Without break (Fall-through)</h3>

<pre><code class="language-javascript">let grade = "B";

switch (grade) {
    case "A":
        console.log("Excellent!");
        // Missing break - execution continues!
    case "B":
        console.log("Good job!");
        // Missing break - execution continues!
    case "C":
        console.log("Average");
        break;
}
// Output: 
// "Good job!"
// "Average"
</code></pre>

<h3>Intentional Fall-through</h3>

<p>Sometimes you want multiple cases to execute the same code. You can intentionally omit <code>break</code> to achieve this.</p>

<pre><code class="language-javascript">let month = 2; // February

switch (month) {
    case 1:
    case 3:
    case 5:
    case 7:
    case 8:
    case 10:
    case 12:
        console.log("31 days");
        break;
    case 4:
    case 6:
    case 9:
    case 11:
        console.log("30 days");
        break;
    case 2:
        console.log("28 or 29 days");
        break;
}
// Output: "28 or 29 days"
</code></pre>

<h2>3. The default Case</h2>

<p>The <code>default</code> case is executed when no other case matches. It's optional but recommended for handling unexpected values.</p>

<h3>Basic Usage</h3>

<pre><code class="language-javascript">let status = "pending";

switch (status) {
    case "active":
        console.log("User is active");
        break;
    case "inactive":
        console.log("User is inactive");
        break;
    case "suspended":
        console.log("User is suspended");
        break;
    default:
        console.log("Unknown status");
        break;
}
// Output: "Unknown status"
</code></pre>

<h3>default Position</h3>

<p>The <code>default</code> case can be placed anywhere, but it's conventional to put it at the end.</p>

<pre><code class="language-javascript">let value = 5;

switch (value) {
    default:
        console.log("Other");
        break;
    case 1:
        console.log("One");
        break;
    case 2:
        console.log("Two");
        break;
}
// Output: "Other"
</code></pre>

<h2>4. Switch vs if-else</h2>

<h3>When to Use Switch</h3>

<p>Use <code>switch</code> when:</p>
<ul>
<li>Comparing a single value against multiple constants</li>
<li>You have many conditions (5+ cases)</li>
<li>All conditions check the same variable</li>
</ul>

<h3>When to Use if-else</h3>

<p>Use <code>if-else</code> when:</p>
<ul>
<li>Conditions involve different variables</li>
<li>You need complex boolean expressions</li>
<li>You have range checks (e.g., <code>if (x > 10 && x < 20)</code>)</li>
</ul>

<h3>Comparison Example</h3>

<pre><code class="language-javascript">let day = "Monday";

// Using if-else
if (day === "Monday") {
    console.log("Start of week");
} else if (day === "Friday") {
    console.log("TGIF!");
} else if (day === "Saturday" || day === "Sunday") {
    console.log("Weekend");
} else {
    console.log("Midweek");
}

// Using switch (cleaner for this case)
switch (day) {
    case "Monday":
        console.log("Start of week");
        break;
    case "Friday":
        console.log("TGIF!");
        break;
    case "Saturday":
    case "Sunday":
        console.log("Weekend");
        break;
    default:
        console.log("Midweek");
        break;
}
</code></pre>

<h2>5. Advanced Switch Usage</h2>

<h3>Switch with Numbers</h3>

<pre><code class="language-javascript">let score = 85;

switch (true) {
    case score >= 90:
        console.log("Grade: A");
        break;
    case score >= 80:
        console.log("Grade: B");
        break;
    case score >= 70:
        console.log("Grade: C");
        break;
    case score >= 60:
        console.log("Grade: D");
        break;
    default:
        console.log("Grade: F");
        break;
}
// Output: "Grade: B"
</code></pre>

<h3>Switch with Functions</h3>

<pre><code class="language-javascript">function getDayType(day) {
    switch (day.toLowerCase()) {
        case "monday":
        case "tuesday":
        case "wednesday":
        case "thursday":
        case "friday":
            return "Weekday";
        case "saturday":
        case "sunday":
            return "Weekend";
        default:
            return "Invalid day";
    }
}

console.log(getDayType("Monday")); // "Weekday"
console.log(getDayType("Saturday")); // "Weekend"
</code></pre>

<h3>Switch with Variables</h3>

<pre><code class="language-javascript">let userRole = "admin";
let action = "delete";

switch (userRole) {
    case "admin":
        if (action === "delete") {
            console.log("Admin can delete");
        }
        break;
    case "moderator":
        console.log("Moderator actions");
        break;
    default:
        console.log("Limited access");
        break;
}
</code></pre>

<h2>6. Common Patterns</h2>

<h3>Pattern 1: Status Handler</h3>

<pre><code class="language-javascript">function handleStatus(status) {
    switch (status) {
        case "loading":
            return "Please wait...";
        case "success":
            return "Operation completed";
        case "error":
            return "Something went wrong";
        default:
            return "Unknown status";
    }
}
</code></pre>

<h3>Pattern 2: Menu Navigation</h3>

<pre><code class="language-javascript">function navigate(menuItem) {
    switch (menuItem) {
        case "home":
            window.location.href = "/";
            break;
        case "about":
            window.location.href = "/about";
            break;
        case "contact":
            window.location.href = "/contact";
            break;
        default:
            console.log("Invalid menu item");
            break;
    }
}
</code></pre>

<h3>Pattern 3: Calculator</h3>

<pre><code class="language-javascript">function calculate(a, b, operation) {
    switch (operation) {
        case "+":
            return a + b;
        case "-":
            return a - b;
        case "*":
            return a * b;
        case "/":
            return b !== 0 ? a / b : "Cannot divide by zero";
        default:
            return "Invalid operation";
    }
}

console.log(calculate(10, 5, "+")); // 15
console.log(calculate(10, 5, "/")); // 2
</code></pre>

<h2>7. Best Practices</h2>

<h3>Always Include break</h3>

<pre><code class="language-javascript">// ✅ Good: Always use break
switch (value) {
    case 1:
        doSomething();
        break;
    case 2:
        doSomethingElse();
        break;
}

// ❌ Bad: Missing break causes fall-through
switch (value) {
    case 1:
        doSomething();
    case 2:
        doSomethingElse();
        break;
}
</code></pre>

<h3>Include default Case</h3>

<pre><code class="language-javascript">// ✅ Good: Handle unexpected values
switch (status) {
    case "active":
        // ...
        break;
    default:
        console.warn("Unexpected status:", status);
        break;
}
</code></pre>

<h3>Use Consistent Formatting</h3>

<pre><code class="language-javascript">// ✅ Good: Consistent indentation
switch (value) {
    case 1:
        return "One";
    case 2:
        return "Two";
    default:
        return "Other";
}
</code></pre>

<h3>Group Related Cases</h3>

<pre><code class="language-javascript">// ✅ Good: Grouped cases
switch (day) {
    case "Monday":
    case "Tuesday":
    case "Wednesday":
    case "Thursday":
    case "Friday":
        return "Weekday";
    case "Saturday":
    case "Sunday":
        return "Weekend";
    default:
        return "Invalid";
}
</code></pre>

<h2>8. Common Mistakes</h2>

<h3>Mistake 1: Forgetting break</h3>

<pre><code class="language-javascript">// ❌ Wrong: Missing break
switch (value) {
    case 1:
        console.log("One");
    case 2:
        console.log("Two");
        break;
}
// If value is 1, both "One" and "Two" will print

// ✅ Correct: Include break
switch (value) {
    case 1:
        console.log("One");
        break;
    case 2:
        console.log("Two");
        break;
}
</code></pre>

<h3>Mistake 2: Using == Instead of ===</h3>

<pre><code class="language-javascript">// Switch uses strict equality (===) automatically
let value = "1";

switch (value) {
    case 1:  // This won't match! (string "1" !== number 1)
        console.log("Number one");
        break;
    case "1":  // This will match
        console.log("String one");
        break;
}
</code></pre>

<h3>Mistake 3: Using Ranges Incorrectly</h3>

<pre><code class="language-javascript">// ❌ Wrong: Can't use ranges directly
switch (score) {
    case score >= 90:  // This doesn't work!
        // ...
        break;
}

// ✅ Correct: Use if-else for ranges
if (score >= 90) {
    // ...
} else if (score >= 80) {
    // ...
}

// ✅ Alternative: Switch with true
switch (true) {
    case score >= 90:
        // ...
        break;
    case score >= 80:
        // ...
        break;
}
</code></pre>

<h2>9. Practical Examples</h2>

<h3>Example 1: HTTP Status Handler</h3>

<pre><code class="language-javascript">function handleHttpStatus(statusCode) {
    switch (statusCode) {
        case 200:
            return "Success";
        case 404:
            return "Not Found";
        case 500:
            return "Server Error";
        case 401:
            return "Unauthorized";
        case 403:
            return "Forbidden";
        default:
            return `Unknown status: ${statusCode}`;
    }
}
</code></pre>

<h3>Example 2: Theme Switcher</h3>

<pre><code class="language-javascript">function applyTheme(theme) {
    switch (theme) {
        case "dark":
            document.body.classList.add("dark-theme");
            document.body.classList.remove("light-theme");
            break;
        case "light":
            document.body.classList.add("light-theme");
            document.body.classList.remove("dark-theme");
            break;
        case "auto":
            // Use system preference
            if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
                applyTheme("dark");
            } else {
                applyTheme("light");
            }
            break;
        default:
            console.warn("Unknown theme:", theme);
            break;
    }
}
</code></pre>

<h3>Example 3: Command Parser</h3>

<pre><code class="language-javascript">function executeCommand(command, args) {
    switch (command) {
        case "help":
            return showHelp();
        case "version":
            return showVersion();
        case "config":
            return updateConfig(args);
        case "exit":
            return exitProgram();
        default:
            return `Unknown command: ${command}`;
    }
}
</code></pre>

<h2>Conclusion</h2>

<p>The <code>switch</code> statement is a powerful tool for handling multiple discrete values. Remember:</p>

<ul>
<li>Use <code>switch</code> for multiple comparisons of the same value</li>
<li>Always include <code>break</code> statements (unless intentional fall-through)</li>
<li>Include a <code>default</code> case to handle unexpected values</li>
<li>Switch uses strict equality (<code>===</code>) for comparisons</li>
<li>Group related cases together for cleaner code</li>
<li>Use <code>if-else</code> for complex conditions or ranges</li>
</ul>

<p>Mastering the <code>switch</code> statement will help you write cleaner, more maintainable code when dealing with multiple conditional branches. Practice with different scenarios to build your confidence!</p>
HTML;
    }

    private static function getLoopsArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: Loops Complete Guide (for, while, do...while, for...of)</h1>

<p>Loops are fundamental programming constructs that allow you to execute code repeatedly. They're essential for processing arrays, iterating over data, and automating repetitive tasks. This comprehensive guide covers all types of loops in JavaScript: <code>for</code>, <code>while</code>, <code>do...while</code>, and the modern <code>for...of</code> loop.</p>

<figure class="image"><img title="JavaScript Loops" src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200&h=630&fit=crop" alt="JavaScript Loops" width="1200" height="630">
<figcaption>Loops enable efficient repetition and iteration in JavaScript</figcaption>
</figure>

<h2>1. The for Loop</h2>

<p>The <code>for</code> loop is the most common loop type. It's ideal when you know how many times you want to iterate.</p>

<h3>Basic Syntax</h3>

<pre><code class="language-javascript">for (initialization; condition; increment) {
    // Code to execute
}
</code></pre>

<h3>Simple Example</h3>

<pre><code class="language-javascript">for (let i = 0; i < 5; i++) {
    console.log(i);
}
// Output: 0, 1, 2, 3, 4
</code></pre>

<h3>Counting Down</h3>

<pre><code class="language-javascript">for (let i = 5; i > 0; i--) {
    console.log(i);
}
// Output: 5, 4, 3, 2, 1
</code></pre>

<h3>Stepping by Different Values</h3>

<pre><code class="language-javascript">// Count by 2s
for (let i = 0; i < 10; i += 2) {
    console.log(i);
}
// Output: 0, 2, 4, 6, 8

// Count by 5s
for (let i = 0; i <= 50; i += 5) {
    console.log(i);
}
// Output: 0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50
</code></pre>

<h2>2. The while Loop</h2>

<p>The <code>while</code> loop continues executing as long as a condition is true. It's useful when you don't know the exact number of iterations beforehand.</p>

<h3>Basic Syntax</h3>

<pre><code class="language-javascript">while (condition) {
    // Code to execute
}
</code></pre>

<h3>Simple Example</h3>

<pre><code class="language-javascript">let count = 0;
while (count < 5) {
    console.log(count);
    count++;
}
// Output: 0, 1, 2, 3, 4
</code></pre>

<h3>Practical Example: User Input Validation</h3>

<pre><code class="language-javascript">let userInput;
while (!userInput || userInput.length < 3) {
    userInput = prompt("Enter a name (at least 3 characters):");
}
console.log("Valid input:", userInput);
</code></pre>

<h3>Infinite Loop Warning</h3>

<pre><code class="language-javascript">// ❌ Dangerous: Infinite loop
let i = 0;
while (i < 5) {
    console.log(i);
    // Missing i++ - this will run forever!
}

// ✅ Correct: Always update the condition
let j = 0;
while (j < 5) {
    console.log(j);
    j++; // Update the counter
}
</code></pre>

<h2>3. The do...while Loop</h2>

<p>The <code>do...while</code> loop is similar to <code>while</code>, but it always executes at least once because the condition is checked after the code block.</p>

<h3>Basic Syntax</h3>

<pre><code class="language-javascript">do {
    // Code to execute
} while (condition);
</code></pre>

<h3>Simple Example</h3>

<pre><code class="language-javascript">let i = 0;
do {
    console.log(i);
    i++;
} while (i < 5);
// Output: 0, 1, 2, 3, 4
</code></pre>

<h3>Key Difference: Executes at Least Once</h3>

<pre><code class="language-javascript">// while loop - doesn't execute if condition is false
let x = 10;
while (x < 5) {
    console.log("This won't run");
}
// No output

// do...while loop - executes at least once
let y = 10;
do {
    console.log("This will run once");
} while (y < 5);
// Output: "This will run once"
</code></pre>

<h3>Practical Example: Menu System</h3>

<pre><code class="language-javascript">let choice;
do {
    choice = prompt("Choose an option:\n1. Start\n2. Settings\n3. Exit");
    console.log("You chose:", choice);
} while (choice !== "3");
console.log("Goodbye!");
</code></pre>

<h2>4. The for...of Loop</h2>

<p>The <code>for...of</code> loop (ES6+) is the modern way to iterate over iterable objects like arrays, strings, and other collections. It's cleaner and more readable than traditional loops.</p>

<h3>Basic Syntax</h3>

<pre><code class="language-javascript">for (let item of iterable) {
    // Code to execute
}
</code></pre>

<h3>Looping Over Arrays</h3>

<pre><code class="language-javascript">const fruits = ["apple", "banana", "orange"];

for (let fruit of fruits) {
    console.log(fruit);
}
// Output: "apple", "banana", "orange"
</code></pre>

<h3>Looping Over Strings</h3>

<pre><code class="language-javascript">const text = "Hello";

for (let char of text) {
    console.log(char);
}
// Output: "H", "e", "l", "l", "o"
</code></pre>

<h3>Getting Index with for...of</h3>

<pre><code class="language-javascript">const items = ["a", "b", "c"];

// Using entries() to get index
for (let [index, item] of items.entries()) {
    console.log(`${index}: ${item}`);
}
// Output: "0: a", "1: b", "2: c"
</code></pre>

<h2>5. Comparing Loop Types</h2>

<h3>Traditional for vs for...of</h3>

<pre><code class="language-javascript">const numbers = [10, 20, 30];

// Traditional for loop
for (let i = 0; i < numbers.length; i++) {
    console.log(numbers[i]);
}

// Modern for...of loop (cleaner)
for (let num of numbers) {
    console.log(num);
}
</code></pre>

<h3>When to Use Each Loop</h3>

<ul>
<li><strong>for:</strong> When you know the exact number of iterations or need index control</li>
<li><strong>while:</strong> When the number of iterations is unknown and depends on a condition</li>
<li><strong>do...while:</strong> When you need to execute at least once</li>
<li><strong>for...of:</strong> When iterating over arrays or other iterables (preferred for arrays)</li>
</ul>

<h2>6. Loop Control: break and continue</h2>

<h3>The break Statement</h3>

<p><code>break</code> exits the loop immediately, even if the condition is still true.</p>

<pre><code class="language-javascript">for (let i = 0; i < 10; i++) {
    if (i === 5) {
        break; // Exit loop when i is 5
    }
    console.log(i);
}
// Output: 0, 1, 2, 3, 4
</code></pre>

<h3>The continue Statement</h3>

<p><code>continue</code> skips the rest of the current iteration and moves to the next one.</p>

<pre><code class="language-javascript">for (let i = 0; i < 10; i++) {
    if (i % 2 === 0) {
        continue; // Skip even numbers
    }
    console.log(i);
}
// Output: 1, 3, 5, 7, 9
</code></pre>

<h2>7. Nested Loops</h2>

<p>You can place loops inside other loops to create nested iterations.</p>

<pre><code class="language-javascript">// Multiplication table
for (let i = 1; i <= 3; i++) {
    for (let j = 1; j <= 3; j++) {
        console.log(`${i} x ${j} = ${i * j}`);
    }
}
// Output:
// 1 x 1 = 1
// 1 x 2 = 2
// 1 x 3 = 3
// 2 x 1 = 2
// ... and so on
</code></pre>

<h2>8. Practical Examples</h2>

<h3>Example 1: Sum Array Elements</h3>

<pre><code class="language-javascript">const numbers = [1, 2, 3, 4, 5];
let sum = 0;

for (let num of numbers) {
    sum += num;
}
console.log(sum); // 15
</code></pre>

<h3>Example 2: Find Maximum Value</h3>

<pre><code class="language-javascript">const numbers = [3, 7, 2, 9, 1];
let max = numbers[0];

for (let num of numbers) {
    if (num > max) {
        max = num;
    }
}
console.log(max); // 9
</code></pre>

<h3>Example 3: Filter Array</h3>

<pre><code class="language-javascript">const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
const evens = [];

for (let num of numbers) {
    if (num % 2 === 0) {
        evens.push(num);
    }
}
console.log(evens); // [2, 4, 6, 8, 10]
</code></pre>

<h2>Conclusion</h2>

<p>Loops are essential for writing efficient JavaScript code. Remember:</p>

<ul>
<li>Use <code>for</code> when you know the number of iterations</li>
<li>Use <code>while</code> when iterations depend on a condition</li>
<li>Use <code>do...while</code> when you need at least one execution</li>
<li>Use <code>for...of</code> for iterating over arrays and iterables (modern approach)</li>
<li>Use <code>break</code> to exit loops early</li>
<li>Use <code>continue</code> to skip iterations</li>
</ul>

<p>Practice with different loop types to become comfortable with each one. Start with simple examples and gradually work up to more complex scenarios!</p>
HTML;
    }

    private static function getFunctionsArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: Functions Complete Guide (Declaration, Expression, Arrow, Parameters, Scope)</h1>

<p>Functions are reusable blocks of code that perform specific tasks. They're one of the most important concepts in JavaScript, allowing you to organize code, avoid repetition, and create modular programs. This guide covers function declarations, expressions, arrow functions, parameters, return values, and scope.</p>

<figure class="image"><img title="JavaScript Functions" src="https://images.unsplash.com/photo-1516116216624-53e697fedbea?w=1200&h=630&fit=crop" alt="JavaScript Functions" width="1200" height="630">
<figcaption>Functions are the building blocks of JavaScript applications</figcaption>
</figure>

<h2>1. Function Declaration</h2>

<p>Function declarations are hoisted, meaning they can be called before they're defined in the code.</p>

<h3>Basic Syntax</h3>

<pre><code class="language-javascript">function functionName(parameters) {
    // Code to execute
    return value; // Optional
}
</code></pre>

<h3>Simple Example</h3>

<pre><code class="language-javascript">function greet(name) {
    return `Hello, ${name}!`;
}

console.log(greet("John")); // "Hello, John!"
</code></pre>

<h3>Function Without Return</h3>

<pre><code class="language-javascript">function sayHello() {
    console.log("Hello, World!");
}

sayHello(); // "Hello, World!"
</code></pre>

<h3>Hoisting Example</h3>

<pre><code class="language-javascript">// Function can be called before it's declared
greet("Alice"); // Works!

function greet(name) {
    console.log(`Hello, ${name}!`);
}
</code></pre>

<h2>2. Function Expression</h2>

<p>Function expressions assign a function to a variable. They're not hoisted and must be defined before use.</p>

<h3>Basic Syntax</h3>

<pre><code class="language-javascript">const functionName = function(parameters) {
    // Code to execute
    return value;
};
</code></pre>

<h3>Simple Example</h3>

<pre><code class="language-javascript">const greet = function(name) {
    return `Hello, ${name}!`;
};

console.log(greet("John")); // "Hello, John!"
</code></pre>

<h3>Anonymous Functions</h3>

<pre><code class="language-javascript">// Anonymous function (no name)
const add = function(a, b) {
    return a + b;
};

console.log(add(5, 3)); // 8
</code></pre>

<h3>Named Function Expression</h3>

<pre><code class="language-javascript">const multiply = function multiplyNumbers(a, b) {
    return a * b;
};

console.log(multiply(4, 5)); // 20
</code></pre>

<h2>3. Arrow Functions (ES6+)</h2>

<p>Arrow functions provide a shorter syntax for writing functions. They're especially useful for callbacks and short functions.</p>

<h3>Basic Syntax</h3>

<pre><code class="language-javascript">const functionName = (parameters) => {
    // Code to execute
    return value;
};
</code></pre>

<h3>Simple Example</h3>

<pre><code class="language-javascript">const greet = (name) => {
    return `Hello, ${name}!`;
};

console.log(greet("John")); // "Hello, John!"
</code></pre>

<h3>Implicit Return (Single Expression)</h3>

<pre><code class="language-javascript">// With braces - explicit return needed
const add = (a, b) => {
    return a + b;
};

// Without braces - implicit return
const add2 = (a, b) => a + b;

console.log(add(5, 3));  // 8
console.log(add2(5, 3)); // 8
</code></pre>

<h3>Single Parameter (Parentheses Optional)</h3>

<pre><code class="language-javascript">// With parentheses
const square = (x) => x * x;

// Without parentheses (only for single parameter)
const square2 = x => x * x;

console.log(square(5));  // 25
console.log(square2(5)); // 25
</code></pre>

<h3>No Parameters</h3>

<pre><code class="language-javascript">const sayHello = () => {
    console.log("Hello!");
};

sayHello(); // "Hello!"
</code></pre>

<h2>4. Parameters and Arguments</h2>

<h3>Basic Parameters</h3>

<pre><code class="language-javascript">function greet(firstName, lastName) {
    return `Hello, ${firstName} ${lastName}!`;
}

console.log(greet("John", "Doe")); // "Hello, John Doe!"
</code></pre>

<h3>Default Parameters (ES6+)</h3>

<pre><code class="language-javascript">function greet(name = "Guest") {
    return `Hello, ${name}!`;
}

console.log(greet("John")); // "Hello, John!"
console.log(greet());       // "Hello, Guest!"
</code></pre>

<h3>Rest Parameters (ES6+)</h3>

<pre><code class="language-javascript">function sum(...numbers) {
    let total = 0;
    for (let num of numbers) {
        total += num;
    }
    return total;
}

console.log(sum(1, 2, 3));        // 6
console.log(sum(1, 2, 3, 4, 5)); // 15
</code></pre>

<h2>5. Return Values</h2>

<h3>Returning Values</h3>

<pre><code class="language-javascript">function add(a, b) {
    return a + b;
}

const result = add(5, 3);
console.log(result); // 8
</code></pre>

<h3>Returning Early</h3>

<pre><code class="language-javascript">function checkAge(age) {
    if (age < 0) {
        return "Invalid age";
    }
    
    if (age < 18) {
        return "Minor";
    }
    
    return "Adult";
}

console.log(checkAge(25)); // "Adult"
console.log(checkAge(15)); // "Minor"
</code></pre>

<h3>Functions Without Return</h3>

<pre><code class="language-javascript">function logMessage(message) {
    console.log(message);
    // No return statement - returns undefined
}

const result = logMessage("Hello");
console.log(result); // undefined
</code></pre>

<h2>6. Scope (Global vs Local)</h2>

<h3>Global Scope</h3>

<pre><code class="language-javascript">// Global variable
const globalVar = "I'm global";

function showGlobal() {
    console.log(globalVar); // Can access global variables
}

showGlobal(); // "I'm global"
</code></pre>

<h3>Local Scope</h3>

<pre><code class="language-javascript">function myFunction() {
    // Local variable
    const localVar = "I'm local";
    console.log(localVar);
}

myFunction(); // "I'm local"
// console.log(localVar); // Error: localVar is not defined
</code></pre>

<h3>Block Scope (let and const)</h3>

<pre><code class="language-javascript">if (true) {
    const blockVar = "I'm in a block";
    console.log(blockVar); // Works
}
// console.log(blockVar); // Error: blockVar is not defined
</code></pre>

<h3>Variable Shadowing</h3>

<pre><code class="language-javascript">const name = "Global";

function showName() {
    const name = "Local"; // Shadows global variable
    console.log(name); // "Local"
}

showName();
console.log(name); // "Global"
</code></pre>

<h2>7. Function Comparison</h2>

<h3>Function Declaration vs Expression vs Arrow</h3>

<pre><code class="language-javascript">// Function Declaration
function add1(a, b) {
    return a + b;
}

// Function Expression
const add2 = function(a, b) {
    return a + b;
};

// Arrow Function
const add3 = (a, b) => a + b;

console.log(add1(2, 3)); // 5
console.log(add2(2, 3)); // 5
console.log(add3(2, 3)); // 5
</code></pre>

<h3>this Binding Difference</h3>

<pre><code class="language-javascript">const obj = {
    name: "Object",
    
    // Regular function - this refers to obj
    regular: function() {
        console.log(this.name);
    },
    
    // Arrow function - this refers to outer scope
    arrow: () => {
        console.log(this.name); // undefined (or window.name)
    }
};

obj.regular(); // "Object"
obj.arrow();   // undefined
</code></pre>

<h2>8. Practical Examples</h2>

<h3>Example 1: Calculator Functions</h3>

<pre><code class="language-javascript">function add(a, b) {
    return a + b;
}

function subtract(a, b) {
    return a - b;
}

function multiply(a, b) {
    return a * b;
}

function divide(a, b) {
    if (b === 0) {
        return "Cannot divide by zero";
    }
    return a / b;
}

console.log(add(10, 5));      // 15
console.log(subtract(10, 5)); // 5
console.log(multiply(10, 5)); // 50
console.log(divide(10, 5));   // 2
</code></pre>

<h3>Example 2: String Utilities</h3>

<pre><code class="language-javascript">function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
}

function reverse(str) {
    return str.split("").reverse().join("");
}

console.log(capitalize("hello")); // "Hello"
console.log(reverse("hello"));    // "olleh"
</code></pre>

<h2>Conclusion</h2>

<p>Functions are essential for writing organized, reusable JavaScript code. Remember:</p>

<ul>
<li>Function declarations are hoisted</li>
<li>Function expressions must be defined before use</li>
<li>Arrow functions provide concise syntax</li>
<li>Use parameters to make functions flexible</li>
<li>Return values to get results from functions</li>
<li>Understand scope to avoid variable conflicts</li>
</ul>

<p>Practice creating functions for different tasks. Start with simple functions and gradually build more complex ones!</p>
HTML;
    }

    private static function getArraysArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: Arrays Complete Guide (Creating, Accessing, Methods: push, pop, map, filter, reduce)</h1>

<p>Arrays are ordered collections of values that allow you to store and manipulate multiple items. They're one of the most commonly used data structures in JavaScript. This guide covers creating arrays, accessing elements, and essential array methods like push, pop, map, filter, and reduce.</p>

<figure class="image"><img title="JavaScript Arrays" src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200&h=630&fit=crop" alt="JavaScript Arrays" width="1200" height="630">
<figcaption>Arrays are fundamental data structures in JavaScript</figcaption>
</figure>

<h2>1. Creating Arrays</h2>

<h3>Array Literal (Most Common)</h3>

<pre><code class="language-javascript">const fruits = ["apple", "banana", "orange"];
const numbers = [1, 2, 3, 4, 5];
const mixed = [1, "hello", true, null];
</code></pre>

<h3>Array Constructor</h3>

<pre><code class="language-javascript">const arr1 = new Array();
const arr2 = new Array(1, 2, 3);
const arr3 = new Array(5); // Creates array with 5 empty slots
</code></pre>

<h3>Empty Arrays</h3>

<pre><code class="language-javascript">const empty1 = [];
const empty2 = new Array();
</code></pre>

<h2>2. Accessing Array Elements</h2>

<h3>By Index</h3>

<pre><code class="language-javascript">const fruits = ["apple", "banana", "orange"];

console.log(fruits[0]); // "apple" (first element)
console.log(fruits[1]); // "banana" (second element)
console.log(fruits[2]); // "orange" (third element)
</code></pre>

<h3>Array Length</h3>

<pre><code class="language-javascript">const fruits = ["apple", "banana", "orange"];
console.log(fruits.length); // 3

// Access last element
console.log(fruits[fruits.length - 1]); // "orange"
</code></pre>

<h3>Modifying Elements</h3>

<pre><code class="language-javascript">const fruits = ["apple", "banana", "orange"];
fruits[1] = "grape";
console.log(fruits); // ["apple", "grape", "orange"]
</code></pre>

<h2>3. Array Methods: push and pop</h2>

<h3>push() - Add to End</h3>

<pre><code class="language-javascript">const fruits = ["apple", "banana"];
fruits.push("orange");
console.log(fruits); // ["apple", "banana", "orange"]

fruits.push("grape", "mango");
console.log(fruits); // ["apple", "banana", "orange", "grape", "mango"]
</code></pre>

<h3>pop() - Remove from End</h3>

<pre><code class="language-javascript">const fruits = ["apple", "banana", "orange"];
const last = fruits.pop();
console.log(last);   // "orange"
console.log(fruits); // ["apple", "banana"]
</code></pre>

<h3>unshift() and shift() - Beginning Operations</h3>

<pre><code class="language-javascript">const fruits = ["banana", "orange"];

// Add to beginning
fruits.unshift("apple");
console.log(fruits); // ["apple", "banana", "orange"]

// Remove from beginning
const first = fruits.shift();
console.log(first);  // "apple"
console.log(fruits); // ["banana", "orange"]
</code></pre>

<h2>4. Array Method: map()</h2>

<p><code>map()</code> creates a new array by transforming each element.</p>

<pre><code class="language-javascript">const numbers = [1, 2, 3, 4, 5];

// Double each number
const doubled = numbers.map(num => num * 2);
console.log(doubled); // [2, 4, 6, 8, 10]

// Convert to strings
const strings = numbers.map(num => num.toString());
console.log(strings); // ["1", "2", "3", "4", "5"]
</code></pre>

<h2>5. Array Method: filter()</h2>

<p><code>filter()</code> creates a new array with elements that pass a test.</p>

<pre><code class="language-javascript">const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

// Get even numbers
const evens = numbers.filter(num => num % 2 === 0);
console.log(evens); // [2, 4, 6, 8, 10]

// Get numbers greater than 5
const large = numbers.filter(num => num > 5);
console.log(large); // [6, 7, 8, 9, 10]
</code></pre>

<h2>6. Array Method: reduce()</h2>

<p><code>reduce()</code> reduces an array to a single value.</p>

<pre><code class="language-javascript">const numbers = [1, 2, 3, 4, 5];

// Sum all numbers
const sum = numbers.reduce((acc, num) => acc + num, 0);
console.log(sum); // 15

// Find maximum
const max = numbers.reduce((acc, num) => num > acc ? num : acc, numbers[0]);
console.log(max); // 5
</code></pre>

<h2>Conclusion</h2>

<p>Arrays are powerful data structures. Master push, pop, map, filter, and reduce to work efficiently with collections of data!</p>
HTML;
    }

    private static function getObjectsArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: Objects Complete Guide (Key-Value Pairs, Accessing Properties, this Keyword)</h1>

<p>Objects are collections of key-value pairs that allow you to store and organize related data. They're fundamental to JavaScript and used everywhere. This guide covers creating objects, accessing and modifying properties, and understanding the this keyword.</p>

<figure class="image"><img title="JavaScript Objects" src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=1200&h=630&fit=crop" alt="JavaScript Objects" width="1200" height="630">
<figcaption>Objects organize data with key-value pairs</figcaption>
</figure>

<h2>1. Creating Objects</h2>

<h3>Object Literal (Most Common)</h3>

<pre><code class="language-javascript">const person = {
    name: "John",
    age: 30,
    email: "john@example.com"
};
</code></pre>

<h2>2. Accessing Properties</h2>

<h3>Dot Notation</h3>

<pre><code class="language-javascript">const person = { name: "John", age: 30 };
console.log(person.name); // "John"
console.log(person.age);  // 30
</code></pre>

<h3>Bracket Notation</h3>

<pre><code class="language-javascript">const person = { name: "John", age: 30 };
console.log(person["name"]); // "John"
console.log(person["age"]);  // 30
</code></pre>

<h2>3. Modifying Properties</h2>

<pre><code class="language-javascript">const person = { name: "John", age: 30 };
person.age = 31;
person.city = "New York";
console.log(person); // { name: "John", age: 31, city: "New York" }
</code></pre>

<h2>4. The this Keyword</h2>

<pre><code class="language-javascript">const person = {
    name: "John",
    greet: function() {
        return `Hello, I'm ${this.name}`;
    }
};

console.log(person.greet()); // "Hello, I'm John"
</code></pre>

<h2>Conclusion</h2>

<p>Objects are essential for organizing data in JavaScript. Master property access and the this keyword to build powerful applications!</p>
HTML;
    }

    private static function getJsonArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: JSON Complete Guide (What is JSON, Converting Between JSON and JS Objects)</h1>

<p>JSON (JavaScript Object Notation) is a lightweight data format used for data exchange. Learn what JSON is and how to convert between JSON strings and JavaScript objects using JSON.parse() and JSON.stringify().</p>

<h2>1. What is JSON?</h2>

<p>JSON is a text format for storing and transporting data. It looks like JavaScript objects but is actually a string.</p>

<h2>2. Converting Objects to JSON</h2>

<pre><code class="language-javascript">const person = { name: "John", age: 30 };
const json = JSON.stringify(person);
console.log(json); // '{"name":"John","age":30}'
</code></pre>

<h2>3. Converting JSON to Objects</h2>

<pre><code class="language-javascript">const json = '{"name":"John","age":30}';
const person = JSON.parse(json);
console.log(person.name); // "John"
</code></pre>

<h2>Conclusion</h2>

<p>JSON is essential for data exchange. Use JSON.stringify() to convert objects to JSON and JSON.parse() to convert JSON back to objects!</p>
HTML;
    }

    private static function getDomArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: What is the DOM? (Document Object Model Explained Simply)</h1>

<p>The DOM (Document Object Model) is a programming interface that represents HTML documents as a tree of objects. It allows JavaScript to interact with and manipulate web pages dynamically.</p>

<h2>What is the DOM?</h2>

<p>The DOM represents your HTML page as a tree structure where each element is a node. JavaScript can access and modify these nodes to change the page content, structure, and styles.</p>

<h2>DOM Tree Structure</h2>

<pre><code class="language-html">&lt;html&gt;
  &lt;body&gt;
    &lt;h1&gt;Hello&lt;/h1&gt;
    &lt;p&gt;World&lt;/p&gt;
  &lt;/body&gt;
&lt;/html&gt;
</code></pre>

<p>This HTML becomes a DOM tree with html as the root, containing body, which contains h1 and p elements.</p>

<h2>Why is the DOM Important?</h2>

<p>The DOM allows JavaScript to:</p>
<ul>
<li>Access page elements</li>
<li>Modify content dynamically</li>
<li>Change styles</li>
<li>Respond to user interactions</li>
</ul>

<h2>Conclusion</h2>

<p>The DOM is the bridge between HTML and JavaScript, enabling dynamic web pages!</p>
HTML;
    }

    private static function getDomManipulationArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: Selecting & Changing DOM Elements</h1>

<p>Learn how to select DOM elements using getElementById and querySelector, and how to change their text content, HTML, and styles dynamically.</p>

<h2>1. Selecting Elements</h2>

<h3>getElementById</h3>

<pre><code class="language-javascript">const element = document.getElementById("myId");
</code></pre>

<h3>querySelector</h3>

<pre><code class="language-javascript">const element = document.querySelector("#myId");
const firstP = document.querySelector("p");
</code></pre>

<h2>2. Changing Content</h2>

<pre><code class="language-javascript">// Change text
element.textContent = "New text";

// Change HTML
element.innerHTML = "&lt;strong&gt;Bold&lt;/strong&gt;";

// Change style
element.style.color = "red";
element.style.fontSize = "20px";
</code></pre>

<h2>Conclusion</h2>

<p>Master DOM selection and manipulation to create interactive web pages!</p>
HTML;
    }

    private static function getEventsArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: Events Complete Guide</h1>

<p>Events make web pages interactive. Learn how to handle click, input, and submit events, add event listeners, and prevent default browser behavior.</p>

<h2>1. Adding Event Listeners</h2>

<pre><code class="language-javascript">const button = document.querySelector("button");
button.addEventListener("click", function() {
    console.log("Button clicked!");
});
</code></pre>

<h2>2. Common Events</h2>

<pre><code class="language-javascript">// Click event
element.addEventListener("click", handler);

// Input event
input.addEventListener("input", handler);

// Submit event
form.addEventListener("submit", handler);
</code></pre>

<h2>3. Preventing Default Behavior</h2>

<pre><code class="language-javascript">form.addEventListener("submit", function(e) {
    e.preventDefault();
    // Custom form handling
});
</code></pre>

<h2>Conclusion</h2>

<p>Events enable interactivity. Use addEventListener to respond to user actions!</p>
HTML;
    }

    private static function getInteractiveUIArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Basics: Creating Interactive UI</h1>

<p>Build interactive user interfaces with JavaScript. Learn to create practical mini-projects including a calculator, to-do list, color changer, and counter app.</p>

<h2>1. Calculator</h2>

<pre><code class="language-javascript">function add(a, b) { return a + b; }
function subtract(a, b) { return a - b; }
function multiply(a, b) { return a * b; }
function divide(a, b) { return b !== 0 ? a / b : "Error"; }
</code></pre>

<h2>2. To-Do List</h2>

<pre><code class="language-javascript">const todos = [];
function addTodo(task) {
    todos.push(task);
}
function removeTodo(index) {
    todos.splice(index, 1);
}
</code></pre>

<h2>3. Counter App</h2>

<pre><code class="language-javascript">let count = 0;
function increment() { count++; }
function decrement() { count--; }
</code></pre>

<h2>Conclusion</h2>

<p>Practice building interactive UIs to master JavaScript and DOM manipulation!</p>
HTML;
    }

    private static function getES6ModernFeaturesArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript ES6+ Modern Features</h1>

<p>Modern JavaScript features that make code cleaner and more powerful. Learn about template literals, destructuring, spread/rest operators, optional chaining, and ES6 modules.</p>

<h2>1. Template Literals</h2>

<pre><code class="language-javascript">const name = "John";
const greeting = `Hello, ${name}!`;
</code></pre>

<h2>2. Destructuring</h2>

<pre><code class="language-javascript">const person = { name: "John", age: 30 };
const { name, age } = person;
</code></pre>

<h2>3. Spread/Rest</h2>

<pre><code class="language-javascript">const arr1 = [1, 2, 3];
const arr2 = [...arr1, 4, 5];
</code></pre>

<h2>4. Optional Chaining</h2>

<pre><code class="language-javascript">const city = user?.address?.city;
</code></pre>

<h2>Conclusion</h2>

<p>Modern JavaScript features make code more readable and powerful!</p>
HTML;
    }

    private static function getAsynchronousJavaScriptArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Asynchronous Programming</h1>

<p>Learn asynchronous JavaScript with callbacks, promises, async/await, and the Fetch API. Build applications that interact with external APIs.</p>

<h2>1. Callbacks</h2>

<pre><code class="language-javascript">setTimeout(function() {
    console.log("Done!");
}, 1000);
</code></pre>

<h2>2. Promises</h2>

<pre><code class="language-javascript">fetch("https://api.example.com/data")
    .then(response => response.json())
    .then(data => console.log(data));
</code></pre>

<h2>3. async/await</h2>

<pre><code class="language-javascript">async function getData() {
    const response = await fetch("https://api.example.com/data");
    const data = await response.json();
    return data;
}
</code></pre>

<h2>Conclusion</h2>

<p>Asynchronous programming enables non-blocking operations and better user experiences!</p>
HTML;
    }

    private static function getErrorHandlingArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Error Handling</h1>

<p>Learn how to handle errors gracefully using try/catch blocks, how to throw custom errors, and best practices for error handling.</p>

<h2>1. try/catch</h2>

<pre><code class="language-javascript">try {
    // Code that might throw an error
    riskyOperation();
} catch (error) {
    console.log("Error:", error.message);
}
</code></pre>

<h2>2. Throwing Custom Errors</h2>

<pre><code class="language-javascript">if (age < 0) {
    throw new Error("Age cannot be negative");
}
</code></pre>

<h2>Conclusion</h2>

<p>Error handling makes applications more robust and user-friendly!</p>
HTML;
    }

    private static function getHtmlCssBasicsArticleContent(): string
    {
        return <<<'HTML'
<h1>HTML & CSS Basics for JavaScript Developers</h1>

<p>Essential HTML and CSS knowledge for JavaScript developers. Learn page structure, forms, Flexbox and Grid layouts, and CSS fundamentals.</p>

<h2>1. HTML Structure</h2>

<pre><code class="language-html">&lt;!DOCTYPE html&gt;
&lt;html&gt;
  &lt;head&gt;
    &lt;title&gt;Page Title&lt;/title&gt;
  &lt;/head&gt;
  &lt;body&gt;
    &lt;h1&gt;Hello World&lt;/h1&gt;
  &lt;/body&gt;
&lt;/html&gt;
</code></pre>

<h2>2. CSS Basics</h2>

<pre><code class="language-css">.container {
    display: flex;
    justify-content: center;
    align-items: center;
}
</code></pre>

<h2>Conclusion</h2>

<p>HTML and CSS are essential foundations for JavaScript web development!</p>
HTML;
    }

    private static function getIntegratingJsHtmlCssArticleContent(): string
    {
        return <<<'HTML'
<h1>Integrating JavaScript with HTML/CSS</h1>

<p>Learn how to integrate JavaScript with HTML and CSS. Understand script placement, DOM manipulation techniques, and dynamic styling.</p>

<h2>1. Script Placement</h2>

<pre><code class="language-html">&lt;script src="app.js"&gt;&lt;/script&gt;
&lt;script&gt;
  // Inline JavaScript
&lt;/script&gt;
</code></pre>

<h2>2. DOM Manipulation</h2>

<pre><code class="language-javascript">const element = document.querySelector(".my-class");
element.textContent = "New content";
element.style.color = "red";
</code></pre>

<h2>Conclusion</h2>

<p>JavaScript, HTML, and CSS work together to create interactive web experiences!</p>
HTML;
    }

    private static function getLocalStorageArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Local Storage</h1>

<p>Learn how to use the browser's localStorage API to save data locally, persist user preferences, and create applications that remember data between sessions.</p>

<h2>1. Saving Data</h2>

<pre><code class="language-javascript">localStorage.setItem("name", "John");
localStorage.setItem("age", "30");
</code></pre>

<h2>2. Retrieving Data</h2>

<pre><code class="language-javascript">const name = localStorage.getItem("name");
const age = localStorage.getItem("age");
</code></pre>

<h2>3. Removing Data</h2>

<pre><code class="language-javascript">localStorage.removeItem("name");
localStorage.clear(); // Remove all
</code></pre>

<h2>Conclusion</h2>

<p>localStorage enables persistent data storage in the browser!</p>
HTML;
    }

    private static function getBrowserApisArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Browser APIs</h1>

<p>Explore powerful browser APIs available in JavaScript. Learn to use the Geolocation API, Clipboard API, and Canvas API.</p>

<h2>1. Geolocation API</h2>

<pre><code class="language-javascript">navigator.geolocation.getCurrentPosition(function(position) {
    console.log(position.coords.latitude);
    console.log(position.coords.longitude);
});
</code></pre>

<h2>2. Clipboard API</h2>

<pre><code class="language-javascript">navigator.clipboard.writeText("Text to copy");
navigator.clipboard.readText().then(text => console.log(text));
</code></pre>

<h2>Conclusion</h2>

<p>Browser APIs provide powerful features for web applications!</p>
HTML;
    }

    private static function getWebSecurityBasicsArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Web Security Basics</h1>

<p>Understand essential web security concepts for JavaScript developers. Learn about CORS and the Same-Origin Policy.</p>

<h2>1. Same-Origin Policy</h2>

<p>The Same-Origin Policy prevents scripts from accessing resources from different origins (protocol, domain, or port).</p>

<h2>2. CORS (Cross-Origin Resource Sharing)</h2>

<p>CORS allows servers to specify which origins can access their resources, relaxing the Same-Origin Policy when needed.</p>

<h2>Conclusion</h2>

<p>Understanding security basics is essential for building secure web applications!</p>
HTML;
    }

    private static function getAdvancedTopicsArticleContent(): string
    {
        return <<<'HTML'
<h1>JavaScript Advanced Topics</h1>

<p>Deep dive into advanced JavaScript concepts including closures, hoisting, prototypes, execution context, the event loop, and performance optimization.</p>

<h2>1. Closures</h2>

<pre><code class="language-javascript">function outer() {
    let count = 0;
    return function inner() {
        count++;
        return count;
    };
}
</code></pre>

<h2>2. Hoisting</h2>

<p>Variable and function declarations are moved to the top of their scope during compilation.</p>

<h2>3. Prototypes</h2>

<p>JavaScript uses prototypes for inheritance. Every object has a prototype chain.</p>

<h2>4. Event Loop</h2>

<p>The event loop handles asynchronous operations, allowing JavaScript to be non-blocking.</p>

<h2>5. Debounce & Throttle</h2>

<p>Performance optimization techniques to limit function execution frequency.</p>

<h2>Conclusion</h2>

<p>Advanced topics unlock the full power of JavaScript!</p>
HTML;
    }
}
