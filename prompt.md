You are a senior WordPress theme developer with deep expertise in PHP, 
Tailwind CSS, WordPress Customizer API, WP REST API, and modern UX/UI design.

## PROJECT CONTEXT

I have a custom personal portfolio WordPress theme built with Tailwind CSS.
The theme is NOT Elementor-based and should remain standalone.
Portfolio (projects) section is already implemented.
The theme will be published on a marketplace (ThemeForest or similar).

## TASKS TO IMPLEMENT

### 1. THEME OPTIONS PANEL (Custom Settings)

Build a professional Theme Options Panel with the following specs:

**Technical Requirements:**
- Use WordPress Customizer API (live preview support) OR a custom admin page 
  using Settings API — choose whichever fits best for a marketplace theme
- All options must be sanitized and validated properly
- Store settings efficiently using a single option key with array structure
- Must be translation-ready (i18n)

**UX Requirements:**
- Minimal, modern, and visually appealing UI
- Organized into logical tabbed sections (not a long scrollable form)
- Use icons for each section tab
- Smooth transitions between tabs
- Live preview where applicable
- Responsive panel layout

**Settings Sections to Include:**
- General (site logo, favicon, copyright text, Google Analytics ID)
- Hero Section (headline, subheadline, CTA buttons, background options)
- Colors & Typography (primary color, accent color, font selection)
- Social Links (GitHub, LinkedIn, Twitter, Dribbble, Email, etc.)
- Education Section (enable/disable, order)
- Work Experience Section (enable/disable, order)
- Portfolio Section (items per page, layout: grid/masonry/list)
- Blog/Articles Section (enable/disable, items per page)
- Contact Section (email, map embed, contact form settings)
- Footer (custom text, links)

---

### 2. EDUCATION SECTION

Create a fully functional Education section for the homepage:

- Custom Post Type: `education`
- Fields (use ACF or custom meta boxes — prefer custom meta for marketplace):
  - Degree / Certificate Title
  - Institution Name
  - Institution Logo (media upload)
  - Start Date / End Date (or "Present")
  - Field of Study
  - Description / Achievements
  - Grade / GPA (optional)
- Frontend display: Timeline-style layout using Tailwind CSS
- Sortable order in admin
- Toggleable from Theme Options

---

### 3. WORK EXPERIENCE SECTION

Create a Work Experience section for the homepage:

- Custom Post Type: `work_experience`
- Fields:
  - Job Title
  - Company Name
  - Company Logo (media upload)
  - Employment Type (Full-time / Part-time / Freelance / Contract)
  - Start Date / End Date (or "Present")
  - Location (Remote / On-site / City)
  - Description / Key Responsibilities
  - Technologies Used (tags)
- Frontend display: Timeline-style or card layout using Tailwind CSS
- Sortable order in admin
- Toggleable from Theme Options

---

### 4. COMMENTS SYSTEM

Implement comments for both Portfolio and Articles (Blog):

**Portfolio Comments:**
- Enable WordPress native comments on `portfolio` post type
- Custom comment template styled with Tailwind CSS
- Show: avatar, name, date, comment text, reply button
- Threaded comments support (up to 3 levels)
- Comment form: minimal design, name + email + message fields
- Moderation support (pending/approved/spam status)
- Comment count displayed on portfolio cards

**Article (Blog) Comments:**
- Same implementation as portfolio comments
- Additionally implement: star rating (1-5) per comment (optional, toggleable)
- Comment count in article meta

**General Comments UX:**
- Loading state while submitting
- Success/error feedback messages
- Anti-spam: honeypot field (no CAPTCHA dependency)
- Pagination for comments if count exceeds threshold (configurable)

---

### 5. MARKETPLACE OPTIMIZATION

Prepare the theme for marketplace submission:

**Code Quality:**
- WordPress Coding Standards compliant
- No plugin territory violations (no post types registered if a plugin exists — 
  use `tgmpa` for recommended plugins or self-contained approach)
- Proper use of `wp_enqueue_scripts`, no hardcoded styles in templates
- Child theme support
- Escape all outputs: `esc_html()`, `esc_url()`, `esc_attr()`
- Nonce verification on all form submissions

**Performance:**
- Tailwind CSS purged/optimized for production (no unused classes)
- Lazy loading for images
- Minified assets
- No render-blocking resources

**Documentation:**
- Generate a `README.md` with installation and setup instructions
- Inline code comments for all major functions
- Changelog-ready structure (`CHANGELOG.md`)

**Accessibility:**
- ARIA labels on interactive elements
- Keyboard navigation support
- Sufficient color contrast (WCAG AA)

**Compatibility:**
- WordPress 6.x compatible
- PHP 8.x compatible
- Tested with popular plugins: Yoast SEO, WP Rocket, WPML

---

## OUTPUT FORMAT

## LANGUAGE & LOCALIZATION REQUIREMENTS

This theme is a **Persian (Farsi) portfolio theme** with the following requirements:

**RTL Support:**
- Full RTL (Right-to-Left) layout support
- Use `dir="rtl"` on html tag
- Tailwind CSS RTL plugin (`tailwindcss-rtl`) or logical properties 
  (`ms-`, `me-`, `ps-`, `pe-`) must be used instead of `ml-`, `mr-`, etc.
- No hardcoded LTR-specific spacing or positioning

**Language:**
- ALL admin panel labels, section titles, field names, placeholder texts, 
  button labels, error messages, and descriptions must be in **Persian (Farsi)**
- Default content/dummy data must be in Persian
- Date fields must support Persian/Jalali calendar 
  (use `morilog/jalali` or a JS Jalali library for date display)
- Number fields should support Persian numerals where appropriate

**Translation Ready:**
- All strings wrapped in `__()` or `_e()` with a consistent text domain
- A `.pot` file must be generated for future translations
- Default language file: `fa_IR`

**Typography:**
- Default font must be a Persian-compatible font 
  (e.g., Vazirmatn, IRANSans, or Estedad) loaded via Google Fonts or 
  self-hosted
- Font options in Theme Settings should list Persian-compatible fonts first

**WordPress Settings:**
- Assume `WPLANG` is set to `fa_IR`
- Admin notices and custom messages in Persian
## CONSTRAINTS

- Do NOT use Elementor, WPBakery, or any page builder
- Do NOT use ACF (Advanced Custom Fields) — implement custom meta boxes
- Tailwind CSS is already configured; extend it, don't replace it
- Keep the theme self-contained and plugin-independent where possible
- Prioritize clean, maintainable, well-commented code

Start with Task 1 (Theme Options Panel) and wait for my confirmation 
before proceeding to the next task.