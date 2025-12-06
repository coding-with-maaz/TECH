<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // Programming Languages
            'PHP', 'Laravel', 'JavaScript', 'TypeScript', 'React', 'Vue.js', 'Angular',
            'Node.js', 'Python', 'Django', 'Flask', 'FastAPI', 'Java', 'Spring Boot', 
            'C#', '.NET', 'ASP.NET', 'Go', 'Golang', 'Rust', 'Swift', 'Kotlin', 
            'Dart', 'Flutter', 'React Native', 'Ruby', 'Ruby on Rails', 'Scala',
            'C++', 'Objective-C', 'Perl', 'R', 'MATLAB', 'Julia', 'Elixir',
            'Erlang', 'Haskell', 'Clojure', 'F#', 'Lua', 'Shell Scripting',
            
            // Frontend Technologies
            'HTML', 'HTML5', 'CSS', 'CSS3', 'SASS', 'SCSS', 'Less', 'Stylus',
            'Tailwind CSS', 'Bootstrap', 'Material UI', 'Ant Design', 'Chakra UI',
            'Next.js', 'Nuxt.js', 'Gatsby', 'Svelte', 'SvelteKit', 'Remix',
            'Webpack', 'Vite', 'Parcel', 'Rollup', 'Babel', 'ESLint', 'Prettier',
            'jQuery', 'Redux', 'MobX', 'Zustand', 'Recoil', 'Jest', 'Cypress',
            
            // Backend Technologies
            'Express.js', 'NestJS', 'Koa.js', 'Fastify', 'Hapi.js', 'Socket.io',
            'GraphQL', 'Apollo', 'REST API', 'RESTful', 'SOAP', 'gRPC',
            'Microservices', 'Serverless', 'Lambda', 'API Gateway', 'WebSockets',
            
            // Databases
            'MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'Elasticsearch', 'SQLite',
            'MariaDB', 'Oracle', 'SQL Server', 'Cassandra', 'CouchDB', 'Neo4j',
            'DynamoDB', 'Firebase', 'Supabase', 'Prisma', 'Sequelize', 'TypeORM',
            'Mongoose', 'SQL', 'NoSQL', 'Database Design', 'Database Optimization',
            
            // DevOps & Cloud
            'Docker', 'Kubernetes', 'AWS', 'Azure', 'GCP', 'Git', 'GitHub',
            'GitLab', 'Bitbucket', 'Jenkins', 'GitHub Actions', 'GitLab CI',
            'CircleCI', 'Travis CI', 'Ansible', 'Terraform', 'Pulumi', 'Vagrant',
            'Puppet', 'Chef', 'Prometheus', 'Grafana', 'ELK Stack', 'Splunk',
            'CloudFormation', 'Serverless Framework', 'Vercel', 'Netlify',
            'Heroku', 'DigitalOcean', 'Linode', 'Cloudflare', 'CDN',
            
            // AI & Machine Learning
            'Machine Learning', 'Deep Learning', 'TensorFlow', 'PyTorch', 'Keras',
            'Scikit-learn', 'Pandas', 'NumPy', 'OpenCV', 'NLTK', 'spaCy',
            'Natural Language Processing', 'NLP', 'Computer Vision', 'Neural Networks',
            'CNN', 'RNN', 'LSTM', 'GAN', 'Reinforcement Learning', 'Data Mining',
            
            // Mobile Development
            'iOS', 'Android', 'SwiftUI', 'UIKit', 'Android Studio', 'Xcode',
            'Ionic', 'Xamarin', 'Cordova', 'PhoneGap', 'NativeScript',
            'App Store', 'Google Play', 'Mobile UI', 'Mobile UX',
            
            // Security
            'Cybersecurity', 'Encryption', 'SSL', 'TLS', 'HTTPS', 'OAuth',
            'JWT', 'Authentication', 'Authorization', 'Penetration Testing',
            'Ethical Hacking', 'Bug Bounty', 'Security Best Practices',
            'XSS', 'CSRF', 'SQL Injection', 'DDoS', 'Firewall', 'VPN',
            
            // Testing
            'Testing', 'Unit Testing', 'Integration Testing', 'E2E Testing',
            'TDD', 'BDD', 'Test Automation', 'Jest', 'Mocha', 'Chai',
            'Jasmine', 'Selenium', 'Playwright', 'Puppeteer', 'Karma',
            'PHPUnit', 'PyTest', 'JUnit', 'Mockito', 'Sinon',
            
            // Development Practices
            'Agile', 'Scrum', 'Kanban', 'DevOps', 'CI/CD', 'Code Review',
            'Pair Programming', 'Refactoring', 'Design Patterns', 'SOLID',
            'Clean Code', 'Code Quality', 'Performance Optimization',
            'Debugging', 'Logging', 'Monitoring', 'Error Handling',
            
            // Tools & Platforms
            'VS Code', 'IntelliJ IDEA', 'PhpStorm', 'WebStorm', 'Sublime Text',
            'Vim', 'Emacs', 'Postman', 'Insomnia', 'Swagger', 'API Documentation',
            'Jira', 'Trello', 'Asana', 'Slack', 'Discord', 'Notion',
            'Confluence', 'Figma', 'Adobe XD', 'Sketch', 'InVision',
            
            // Web Technologies
            'HTTP', 'HTTPS', 'DNS', 'CDN', 'Load Balancing', 'Caching',
            'Progressive Web Apps', 'PWA', 'Service Workers', 'WebAssembly',
            'WebRTC', 'WebSockets', 'SSR', 'CSR', 'SEO', 'Performance',
            
            // Data & Analytics
            'Data Science', 'Data Analysis', 'Data Visualization', 'Big Data',
            'Hadoop', 'Spark', 'Kafka', 'Data Pipeline', 'ETL', 'Business Intelligence',
            'Tableau', 'Power BI', 'Google Analytics', 'Data Warehousing',
            
            // Blockchain & Web3
            'Blockchain', 'Bitcoin', 'Ethereum', 'Smart Contracts', 'Solidity',
            'Web3', 'DeFi', 'NFT', 'Cryptocurrency', 'DApp', 'IPFS',
            
            // Game Development
            'Unity', 'Unreal Engine', 'Game Design', 'Game Development',
            'Cocos2d', 'Phaser', 'Three.js', 'WebGL', 'OpenGL',
            
            // Other Technologies
            'Linux', 'Ubuntu', 'Debian', 'CentOS', 'Fedora', 'macOS', 'Windows',
            'Nginx', 'Apache', 'IIS', 'Load Balancer', 'Reverse Proxy',
            'Message Queue', 'RabbitMQ', 'ActiveMQ', 'Kafka', 'Redis Queue',
            'Search Engine', 'Elasticsearch', 'Solr', 'Algolia',
        ];

        foreach ($tags as $tagName) {
            // Use firstOrCreate with name only, let the model handle slug generation
            $tag = Tag::firstOrNew(['name' => $tagName]);
            
            // If tag doesn't exist, generate unique slug
            if (!$tag->exists) {
                $tag->slug = $tag->generateUniqueSlug();
                $tag->save();
            }
        }

        $this->command->info('✅ Tags seeded successfully!');
    }
}

