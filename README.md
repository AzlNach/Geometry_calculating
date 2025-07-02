# Geometry Calculator

An interactive web-based geometry calculator with real-time visualization for calculating areas, perimeters, and volumes of various geometric shapes. Built with PHP, JavaScript, and SVG graphics for dynamic visual representations.

## 🌟 Features

### Core Functionalities

#### 1. **Geometry Calculations**
- **Triangle Calculator**: Calculate area using base and height with interactive sliders
- **Square Calculator**: Calculate area and perimeter with real-time visualization
- **Circle Calculator**: Calculate area and circumference with dynamic radius adjustment

#### 2. **Unit Conversion System**
- **Length Conversion**: Meters, centimeters, millimeters, kilometers, inches, feet, yards, miles
- **Area Conversion**: Square meters, square centimeters, hectares, acres, etc.
- **Volume Conversion**: Cubic meters, liters, gallons, quarts, pints
- **Weight Conversion**: Kilograms, grams, pounds, ounces, metric tons

#### 3. **Statistics Calculator**
- Mean, median, mode calculation
- Standard deviation and variance
- Range and sum calculations
- Data input via comma-separated values

#### 4. **Function Grapher** (Placeholder)
- Interactive function plotting interface
- Customizable range settings
- Mathematical function visualization

### Technical Features

#### 📱 **Responsive Design**
- Bootstrap 5.3.3 framework
- Mobile-first approach
- Cross-device compatibility
- Adaptive SVG graphics

#### ⚡ **Real-time Calculations**
- Live updates as users interact with sliders
- Instant conversion results
- Dynamic visualization updates
- No page refresh required

#### 🎨 **Interactive Visualizations**
- SVG-based geometric shape rendering
- Grid-based coordinate system
- Color-coded measurement indicators
- Responsive visual scaling

## 🏗️ Technical Architecture

### Directory Structure
```
Geometry_calculating/
├── .htaccess                    # URL rewriting configuration
├── README.md                    # Project documentation
├── public/                      # Web-accessible files
│   ├── index.php               # Front controller
│   ├── assets/
│   │   ├── icons/              # Icon assets
│   │   └── images/             # Shape images (triangle, square, circle)
│   ├── css/                    # Stylesheets
│   │   ├── content.css
│   │   ├── footer.css
│   │   ├── landing.css
│   │   └── popup.css
│   └── js/                     # JavaScript modules
│       ├── circle.js           # Circle calculator logic
│       ├── code.js
│       ├── feature-loader.js   # AJAX feature loading
│       ├── footer.js
│       ├── landing.js
│       ├── square.js           # Square calculator logic
│       ├── triangle-demo.js    # Triangle calculator logic
│       └── unit-conversion.js  # Conversion calculations
└── src/                        # Application source code
    ├── config.php              # Configuration constants
    ├── core/
    │   └── router.php          # Custom routing system
    └── templates/
        ├── layouts/
        │   ├── foot.php        # Footer template
        │   ├── function.php
        │   └── head.php        # Header template
        └── pages/              # Page templates
            ├── circle-demo.php
            ├── function-grapher.php
            ├── geometry-calculations.php
            ├── square-demo.php
            ├── statistics-calculator.php
            ├── triangle-demo.php
            └── unit-conversion.php
```

### Technology Stack

#### Backend
- **PHP 7.4+**: Server-side logic and templating
- **Custom Router**: [`Router`](src/core/router.php) class for URL routing
- **Configuration Management**: [`config.php`](src/config.php) for path constants

#### Frontend
- **HTML5**: Semantic markup structure
- **CSS3**: Custom styling with Bootstrap integration
- **JavaScript ES6+**: Interactive functionality and calculations
- **SVG Graphics**: Vector-based shape visualization
- **Bootstrap 5.3.3**: Responsive UI framework

#### Libraries & CDNs
- **Three.js r134**: 3D visualization library
- **Google Material Symbols**: Icon system
- **Bootstrap Bundle**: UI components and utilities

## 🔄 System Flow

### 1. **Request Routing Flow**
```
User Request → .htaccess → public/index.php → Router::resolve() → Template File
```

1. **URL Rewriting**: [`.htaccess`](.htaccess) redirects all requests to [`public/index.php`](public/index.php)
2. **Route Resolution**: [`Router`](src/core/router.php) maps URLs to template files
3. **Template Rendering**: Appropriate PHP template is included and rendered

### 2. **Feature Loading System**
```
User Clicks Feature → AJAX Request → Template Content → DOM Update → Script Execution
```

1. **Feature Selection**: User clicks feature button in carousel
2. **AJAX Loading**: [`feature-loader.js`](public/js/feature-loader.js) fetches content
3. **Content Injection**: Template content replaces demo section
4. **Script Execution**: Associated JavaScript modules are loaded

### 3. **Calculation Workflow**

#### Geometry Calculations
```
Slider Input → Event Listener → Calculate Values → Update Display → Update SVG
```

#### Unit Conversion
```
Input Change → Conversion Type → Factor Lookup → Calculate Result → Format Display
```

## 🚀 Installation & Setup

### Prerequisites
- **Web Server**: Apache/Nginx with PHP support
- **PHP**: Version 7.4 or higher
- **Modules**: mod_rewrite enabled

### Local Development Setup

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd Geometry_calculating
   ```

2. **Configure Web Server**
   - Place project in web server document root
   - Ensure mod_rewrite is enabled
   - Verify [`.htaccess`](.htaccess) is working

3. **Update Configuration**
   - Modify [`BASE_URL`](src/config.php) in [`src/config.php`](src/config.php) if needed
   ```php
   define('BASE_URL', '/Geometry_calculating'); // Update path as needed
   ```

4. **Access Application**
   ```
   http://localhost/Geometry_calculating/
   ```

## 📝 Configuration

### Path Constants ([`src/config.php`](src/config.php))
```php
define('BASE_DIR', realpath(__DIR__ . '/..'));          // Project root
define('PUBLIC_DIR', BASE_DIR . '/public');             // Public assets
define('TEMPLATES_DIR', BASE_DIR . '/src/templates');   // Template files
define('BASE_URL', '/Geometry_calculating');            // Web base URL
define('JS_URL', PUBLIC_URL . '/js');                   // JavaScript path
define('CSS_URL', PUBLIC_URL . '/css');                 // Stylesheet path
define('IMAGES_URL', ASSETS_URL . '/images');           // Image assets
```

### Routing Configuration ([`src/core/router.php`](src/core/router.php))
- **Homepage**: `/` → [`public/index.php`](public/index.php)
- **Triangle**: `/triangle-demo.php` → [`triangle-demo.php`](src/templates/pages/triangle-demo.php)
- **Square**: `/square-demo.php` → [`square-demo.php`](src/templates/pages/square-demo.php)
- **Circle**: `/circle-demo.php` → [`circle-demo.php`](src/templates/pages/circle-demo.php)
- **Unit Conversion**: `/unit-conversion.php` → [`unit-conversion.php`](src/templates/pages/unit-conversion.php)
- **Statistics**: `/statistics-calculator.php` → [`statistics-calculator.php`](src/templates/pages/statistics-calculator.php)

## 🎯 Usage Examples

### Adding New Geometric Shape
1. Create template in [`src/templates/pages/`](src/templates/pages/)
2. Add route in [`Router`](src/core/router.php) class
3. Create JavaScript calculator in [`public/js/`](public/js/)
4. Add feature card in [`geometry-calculations.php`](src/templates/pages/geometry-calculations.php)

### Extending Unit Conversion
1. Add conversion factors in [`unit-conversion.js`](public/js/unit-conversion.js)
2. Update unit display names
3. Add new conversion type option

## 🔧 API Reference

### JavaScript Functions

#### Unit Conversion ([`unit-conversion.js`](public/js/unit-conversion.js))
- `initUnitConverter()`: Initialize conversion calculator
- `updateUnitOptions()`: Update available units based on type
- `updateConversion()`: Perform conversion calculation

#### Feature Loading ([`feature-loader.js`](public/js/feature-loader.js))
- AJAX content loading for dynamic feature switching
- Script execution for loaded content
- Smooth scrolling to demo sections

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/new-feature`)
3. Commit changes (`git commit -am 'Add new feature'`)
4. Push to branch (`git push origin feature/new-feature`)
5. Create Pull Request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👨‍💻 Developer

**Azel**
- Email: azelpandy2@gmail.com
- GitHub: https://github.com/AzlNach

---

*Interactive calculator for geometric shapes with real-time visualization. Calculate area, perimeter, and more with our easy-to-use tools.*