# Nazaarabox Component Library Guide

Complete guide to using reusable components and utilities throughout the website.

## Buttons

### Basic Usage
```html
<button class="btn btn-primary">Primary Button</button>
<button class="btn btn-secondary">Secondary Button</button>
<button class="btn btn-outline">Outline Button</button>
<button class="btn btn-ghost">Ghost Button</button>
<button class="btn btn-gradient">Gradient Button</button>
```

### Button Sizes
```html
<button class="btn btn-primary btn-xs">Extra Small</button>
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary btn-md">Medium (default)</button>
<button class="btn btn-primary btn-lg">Large</button>
<button class="btn btn-primary btn-xl">Extra Large</button>
```

### Button with Icon
```html
<button class="btn btn-primary btn-icon">
    <span>🔍</span>
    <span>Search</span>
</button>
```

### Disabled State
```html
<button class="btn btn-primary" disabled>Disabled Button</button>
```

## Cards

### Basic Card
```html
<div class="card">
    <div class="card-body">
        <h3 class="card-title">Card Title</h3>
        <p class="card-text">Card content goes here</p>
    </div>
</div>
```

### Interactive Card (with hover effect)
```html
<a href="#" class="card card-interactive">
    <img src="image.jpg" class="card-image" alt="Movie">
    <div class="card-body">
        <h3 class="card-title">Movie Title</h3>
        <p class="card-text">Description</p>
        <div class="card-meta">
            <span>2024</span>
            <span class="rating">★ 8.5</span>
        </div>
    </div>
</a>
```

### Card Variants
```html
<!-- Elevated Card -->
<div class="card card-elevated">...</div>

<!-- Bordered Card -->
<div class="card card-bordered">...</div>

<!-- Accent Border Card -->
<div class="card card-accent">...</div>
```

### Card with Header and Footer
```html
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Header</h3>
    </div>
    <div class="card-body">
        <p class="card-text">Body content</p>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary">Action</button>
    </div>
</div>
```

## Forms & Inputs

### Input Group
```html
<div class="input-group">
    <label class="input-label">Email Address</label>
    <input type="email" class="input" placeholder="Enter your email">
    <span class="input-help">We'll never share your email</span>
</div>
```

### Input States
```html
<!-- Normal Input -->
<input type="text" class="input" placeholder="Normal">

<!-- Error Input -->
<input type="text" class="input input-error" placeholder="Error">
<span class="input-error-text">This field is required</span>

<!-- Success Input -->
<input type="text" class="input input-success" placeholder="Success">

<!-- Disabled Input -->
<input type="text" class="input" disabled placeholder="Disabled">
```

### Textarea
```html
<div class="input-group">
    <label class="input-label">Message</label>
    <textarea class="input textarea" placeholder="Enter your message"></textarea>
</div>
```

### Select
```html
<div class="input-group">
    <label class="input-label">Category</label>
    <select class="input select">
        <option>Movies</option>
        <option>TV Shows</option>
    </select>
</div>
```

## Badges & Tags

### Badges
```html
<span class="badge badge-primary">New</span>
<span class="badge badge-secondary">Popular</span>
<span class="badge badge-success">Active</span>
<span class="badge badge-warning">Warning</span>
<span class="badge badge-error">Error</span>
<span class="badge badge-info">Info</span>
```

### Tags
```html
<span class="tag">Action</span>
<span class="tag tag-accent">Drama</span>
<span class="tag">Comedy</span>
```

## Alerts

```html
<!-- Success Alert -->
<div class="alert alert-success">
    <div class="alert-content">
        <div class="alert-title">Success!</div>
        <div>Your changes have been saved.</div>
    </div>
    <button class="alert-close">×</button>
</div>

<!-- Error Alert -->
<div class="alert alert-error">
    <div class="alert-content">
        <div class="alert-title">Error</div>
        <div>Something went wrong.</div>
    </div>
</div>

<!-- Warning Alert -->
<div class="alert alert-warning">
    <div class="alert-content">Please check your input.</div>
</div>

<!-- Info Alert -->
<div class="alert alert-info">
    <div class="alert-content">New features available!</div>
</div>
```

## Loading States

### Spinner
```html
<!-- Small -->
<div class="loading loading-sm"></div>

<!-- Medium (default) -->
<div class="loading"></div>

<!-- Large -->
<div class="loading loading-lg"></div>
```

### Skeleton Loader
```html
<div class="skeleton" style="width: 100%; height: 200px;"></div>
<div class="skeleton" style="width: 60%; height: 20px; margin-top: 10px;"></div>
```

## Typography Utilities

### Font Sizes
```html
<p class="text-xs">Extra Small Text</p>
<p class="text-sm">Small Text</p>
<p class="text-base">Base Text</p>
<p class="text-lg">Large Text</p>
<p class="text-xl">Extra Large Text</p>
<p class="text-2xl">2XL Text</p>
<p class="text-3xl">3XL Text</p>
<p class="text-4xl">4XL Text</p>
```

### Font Weights
```html
<p class="font-normal">Normal Weight</p>
<p class="font-medium">Medium Weight</p>
<p class="font-semibold">Semibold Weight</p>
<p class="font-bold">Bold Weight</p>
```

### Text Colors
```html
<p class="text-primary">Primary Text</p>
<p class="text-secondary">Secondary Text</p>
<p class="text-tertiary">Tertiary Text</p>
<p class="text-muted">Muted Text</p>
<p class="text-accent">Accent Text</p>
<p class="text-success">Success Text</p>
<p class="text-warning">Warning Text</p>
<p class="text-error">Error Text</p>
```

### Text Alignment
```html
<p class="text-left">Left Aligned</p>
<p class="text-center">Center Aligned</p>
<p class="text-right">Right Aligned</p>
```

### Text Truncation
```html
<p class="truncate">This text will be truncated with ellipsis if too long</p>
<p class="line-clamp-2">This text will be clamped to 2 lines with ellipsis</p>
<p class="line-clamp-3">This text will be clamped to 3 lines with ellipsis</p>
```

## Spacing Utilities

### Margin
```html
<div class="m-0">No Margin</div>
<div class="m-xs">Extra Small Margin</div>
<div class="m-sm">Small Margin</div>
<div class="m-md">Medium Margin</div>
<div class="m-lg">Large Margin</div>
<div class="m-xl">Extra Large Margin</div>

<!-- Directional Margins -->
<div class="mt-md mb-lg">Top and Bottom Margins</div>
```

### Padding
```html
<div class="p-0">No Padding</div>
<div class="p-xs">Extra Small Padding</div>
<div class="p-sm">Small Padding</div>
<div class="p-md">Medium Padding</div>
<div class="p-lg">Large Padding</div>
<div class="p-xl">Extra Large Padding</div>
```

## Layout Utilities

### Flexbox
```html
<div class="flex items-center justify-between gap-md">
    <span>Left</span>
    <span>Right</span>
</div>

<div class="flex flex-col gap-lg">
    <div>Item 1</div>
    <div>Item 2</div>
</div>
```

### Grid
```html
<div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
    <div>Item 1</div>
    <div>Item 2</div>
</div>
```

### Display
```html
<div class="hidden">Hidden</div>
<div class="block">Block</div>
<div class="inline-block">Inline Block</div>
<div class="flex">Flex</div>
```

### Width & Height
```html
<div class="w-full">Full Width</div>
<div class="w-auto">Auto Width</div>
<div class="h-full">Full Height</div>
```

## Border Radius

```html
<div class="rounded-sm">Small Radius</div>
<div class="rounded-md">Medium Radius</div>
<div class="rounded-lg">Large Radius</div>
<div class="rounded-xl">Extra Large Radius</div>
<div class="rounded-full">Full Radius (Circle)</div>
```

## Shadows

```html
<div class="shadow-sm">Small Shadow</div>
<div class="shadow-md">Medium Shadow</div>
<div class="shadow-lg">Large Shadow</div>
<div class="shadow-xl">Extra Large Shadow</div>
```

## Rating

```html
<div class="rating">
    <span>★</span>
    <span class="rating-value">8.5</span>
</div>
```

## Dividers

```html
<!-- Horizontal Divider -->
<hr class="divider">

<!-- Vertical Divider -->
<div class="flex">
    <div>Left</div>
    <hr class="divider-vertical">
    <div>Right</div>
</div>
```

## Containers

```html
<!-- Default Container (1400px) -->
<div class="container">Content</div>

<!-- Small Container (640px) -->
<div class="container-sm">Content</div>

<!-- Medium Container (768px) -->
<div class="container-md">Content</div>

<!-- Large Container (1024px) -->
<div class="container-lg">Content</div>

<!-- Extra Large Container (1280px) -->
<div class="container-xl">Content</div>
```

## Complete Example: Movie Card

```html
<a href="/movies/123" class="card card-interactive">
    <img src="poster.jpg" class="card-image" alt="Movie Title">
    <div class="card-body">
        <h3 class="card-title truncate">Movie Title</h3>
        <p class="card-text line-clamp-2">Movie description that might be long and will be clamped to 2 lines...</p>
        <div class="card-meta flex items-center justify-between">
            <span class="text-secondary">2024</span>
            <div class="rating">
                <span>★</span>
                <span class="rating-value">8.5</span>
            </div>
        </div>
        <div class="flex gap-sm mt-md">
            <span class="tag">Action</span>
            <span class="tag">Drama</span>
        </div>
    </div>
</a>
```

## Complete Example: Search Form

```html
<form class="flex gap-md">
    <div class="input-group flex-1">
        <input type="text" class="input" placeholder="Search movies or TV shows...">
    </div>
    <button type="submit" class="btn btn-primary btn-lg">
        Search
    </button>
</form>
```

## Best Practices

1. **Use semantic HTML** - Always use appropriate HTML elements
2. **Combine utilities** - Mix and match utility classes for custom designs
3. **Consistent spacing** - Use spacing utilities instead of custom margins/padding
4. **Responsive design** - Components are responsive by default
5. **Accessibility** - Always include proper labels, alt text, and ARIA attributes
6. **Theme consistency** - All components use theme variables automatically

