# JobHub - Comprehensive Upgrade Plan

## Information Gathered

### Current State:
1. **Brand**: Already "JobHub" in config/app.php, Docker files, and header.php (with SVG logo).
2. **Brand in Auth pages**: Both `login.php` and `register.php` still display "JobPortal" as the brand name.
3. **CSS Files**: 
   - `theme.css` - 4 themes (Dawn, Noon, Dusk, Night) with CSS variables - modern
   - `app.css` - Bootstrap overrides, navbar, buttons, cards - modern
   - `components.css` - Job cards, search bars, badges - modern
   - `animations.css` - Animations, skeleton loading - modern
   - `main.css` - Legacy styles (many redundant/overlapping with above)
   - `homepage.css` - Legacy carousel + old search box styles
   - `account.css` - Legacy settings sidebar styles
   - `form-style.css` - Legacy form styles
4. **JS Files**: 
   - `app.js` - Modern (toasts, back-to-top, animations, tabs, form spinners, search suggestions)
   - `index.js` - Legacy jQuery carousel
   - `theme.js` - Minimal theme toggle
5. **Success Color**: Currently `#059669` (green) instead of primary brand accent.
6. **Dusk Theme**: Basic, could use richer gradient/stars/sunset feel.
7. **Flash Messages**: Now using modern toast notification system in header.
8. **Database**: Fixed (all 15 users restored, using bcrypt hashes).
9. **Tests**: `/tests` directory does not exist yet.

### CSS Issues to Fix:
1. Home page search box - legacy styles in `homepage.css` conflicting with modern `.search-bar` in `components.css`
2. Login page - left panel (auth-illustration) should fully cover, but login form has "JobPortal" brand
3. Alerts - `.flash` and `.alert` classes need consistent styling
4. Success color - change to use primary brand accent instead of green
5. main.css has `ul, li { list-style: none; }` and other global overrides that may conflict
6. account.css has fixed positioning for sidebar that may break on smaller screens
7. form-style.css has Bootstrap variable overrides that need updating

### Features to Add:
1. Rich dusk theme (gradient sky, animation)
2. Toast notification integration across all views
3. Back-to-top button
4. Search suggestions (already in app.js)
5. Loading spinners on form submit (already in app.js)

## PLAN

### Phase 1: Fix Brand Consistency
- [x] **Done**: Change config/app.php `name` to 'JobHub'
- [x] **Done**: Update Docker files with JobHub branding
- [x] **Done**: Update header.php brand with SVG logo + JobHub name
- [ ] Fix `login.php` brand: "JobPortal" → "JobHub"
- [ ] Fix `register.php` brand: "JobPortal" → "JobHub"

### Phase 2: Fix CSS Issues
- [ ] Fix Success Color: Change `--success` in theme.css to use primary brand accent (e.g., `var(--primary)`) for all themes
- [ ] Fix Dusk Theme: Add rich gradient backgrounds, sunset/sun colors, star animations
- [ ] Fix Auth Split Layout: Ensure auth-illustration fully covers left side (remove max-width restriction)
- [ ] Fix Flash/Alert Styles: Unify `.flash-*` and `.alert-*` using CSS variables, use primary accent
- [ ] Fix Home Search: Remove legacy `.front-img-div` styles, use modern `.search-bar` from components.css
- [ ] Fix account.css: Replace fixed positioning with sticky, remove legacy styles
- [ ] Clean up main.css: Remove redundant global styles that conflict with theme.css
- [ ] Fix form-style.css: Update Bootstrap variable overrides for JobHub theme
- [ ] Ensure navbar-toggler-icon is visible (Bootstrap hamburger menu)

### Phase 3: Enhance Features
- [ ] Add rich dusk theme with gradient animations and stars
- [ ] Add toast notification system across all views (integrate flash messages → toasts)
- [ ] Add search suggestions API endpoint
- [ ] Fix home page stats section with counter animation
- [ ] Ensure responsive tables work for all data views

### Phase 4: Modernize Theme
- [ ] Add more color variants to themes (richer palette)
- [ ] Add gradient backgrounds for sections
- [ ] Add subtle patterns or textures
- [ ] Improve dusk theme with actual sunset-like colors

### Phase 5: Tests Suite
- [ ] Create `/tests` directory structure
- [ ] Add test configuration
- [ ] Add unit tests for helpers
- [ ] Add integration tests for auth flow
- [ ] Add feature tests for job CRUD

### Files to Modify:
1. `src/Views/auth/login.php` - Brand fix
2. `src/Views/auth/register.php` - Brand fix
3. `public/assets/css/theme.css` - Success color, dusk theme enhancement
4. `public/assets/css/main.css` - Cleanup legacy styles
5. `public/assets/css/homepage.css` - Fix search box
6. `public/assets/css/account.css` - Fix positioning
7. `public/assets/css/form-style.css` - Update overrides
8. `public/assets/css/app.css` - Flash/alert improvements
9. `public/assets/css/animations.css` - Add dusk animations

### New Files to Create:
1. `/tests/phpunit.xml` - Test config
2. `/tests/TestCase.php` - Base test case
3. `/tests/Unit/HelpersTest.php` - Helper function tests
4. `/tests/Unit/AuthServiceTest.php` - Auth test
5. `/tests/Feature/JobCreationTest.php` - Job CRUD test
