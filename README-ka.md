# 💶 საკომისიო გამოთვლის სისტემა

ეს PHP პროექტი გამოთვლის საბანკო ოპერაციების საკომისიოებს მოთხოვნილი წესების მიხედვით.

### ✅ ფუნქციონალი

- `Private` მომხმარებელი:
  - 0.3% საკომისიო `withdraw` ოპერაციებზე.
  - კვირაში პირველი **3 ოპერაცია** და **1000 EUR** ჯამში — უფასო.
  - ზღვარის გადაჭარბებისას იანგარიშება მხოლოდ ზედმეტი თანხაზე.
- `Business` მომხმარებელი:
  - 0.5% საკომისიო ყველა `withdraw` ოპერაციაზე.
- `Deposit` ოპერაციები: 0.03%.
- მხარდაჭერილია:
  - `.csv` ფორმატი
  - `.txt` ფორმატი (JSON ოპერაციები)

### 🧩 გაშვება

```bash
php bin/run_example.php test_operations.txt
php bin/script.php input.csv
```

### 🧪 ტესტირება

```bash
./vendor/bin/phpunit tests/
```

### ⚙️ კონფიგურაცია

```bash
composer install
composer dump-autoload
```

დაამატე `.env` ფაილი:

```
CURRENCY_API_KEY=your_api_key
```

### 🧱 არქიტექტურა

- PSR-4 autoload (Composer).
- სუფთა მოდულური სტრუქტურა (Input, Model, Service, Commission).
- ადვილად გასაფართოებელი — ახალი ვალუტები, ლოგიკა, ფორმატები.

### 📎 მოსალოდნელი შედეგი (CSV-სთვის):

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
