# 💶 Commission Fee Calculator

This PHP-based system calculates commission fees for banking operations, fully compatible with the specification and expected outputs like:

```bash
php script.php input.csv
```

### ✅ Features

- `Private` user withdrawals:
  - 0.3% commission.
  - First **3 withdrawals per week** up to a **combined total of 1000.00 EUR** are **free**.
  - Exceeding amount is charged at 0.3%.
- `Business` user withdrawals: 0.5% commission on all amounts.
- `Deposits`: 0.03% commission flat.
- Currency conversion with real-time exchange rates.
- Supports input from:
  - `.csv` file (`Y-m-d,user_id,user_type,type,amount,currency`)
  - `.txt` file (each line is a valid JSON operation)

### 🧩 Usage

## Installation

1. Clone the repository
2. Run:

```bash
composer install
```

```bash
php bin/run_example.php test_operations.txt
php bin/script.php input.csv
```

### 🧪 Testing

```bash
./bin/phpunit tests/
```

### ⚙️ Setup

```bash
composer install
composer dump-autoload
```

Include a `.env` file with:

```
CURRENCY_API_KEY=your_api_key
```

### 📐 Architecture

- PSR-4 autoloading via Composer.
- Fully modular structure (Input, Model, Service, Commission).
- Easily extensible — new currencies, logic, or formats can be added without rewriting core.

### 📎 Example Output (from provided CSV)

```
0.60
3.00
0.00
0.06
1.50
0
0.70
0.30
0.30
3.00
0.00
0.00
8612
```
