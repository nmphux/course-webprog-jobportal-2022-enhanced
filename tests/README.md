# JobHub Test Suite

This directory contains automated tests for the JobHub job portal application.

## Setup

### Prerequisites

- PHP 8.0+ with PDO and SQLite extensions
- Composer (for PHPUnit)

### Install PHPUnit

```bash
composer require --dev phpunit/phpunit
```

### Database Setup for Testing

Tests use an SQLite in-memory database. No external database configuration needed.

## Running Tests

```bash
# Run all tests
vendor/bin/phpunit

# Run a specific test suite
vendor/bin/phpunit tests/Unit

# Run with coverage report
vendor/bin/phpunit --coverage-html coverage
```

## Test Structure

```
tests/
├── Unit/                  # Unit tests (isolated)
│   ├── HelpersTest.php    # Tests for helper functions
│   └── RouterTest.php     # Tests for Router
├── Integration/           # Integration tests (DB + components)
│   ├── AuthTest.php       # Login/Register/Logout flows
│   ├── JobTest.php        # Job CRUD operations
│   ├── ApplicationTest.php # Application workflow
│   └── BookmarkTest.php   # Bookmark functionality
├── Feature/               # Full feature tests
│   └── WorkflowTest.php   # End-to-end user workflows
├── TestCase.php           # Base test case with DB setup
└── bootstrap.php          # Test bootstrap / autoloader
```
