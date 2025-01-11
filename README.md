# # classWizard Encryption Library

A simple PHP encryption and decryption utility.

## Installation

```bash
composer require hunnomad/wizard
```
## Usage
```php

<?php

require 'vendor/autoload.php';

use Custom\Encryption\classWizard;

$cipher = new classWizard('12345678901234567890123456789012');
$encrypted = $cipher->encode('Hello, World!');
$decrypted = $cipher->decode($encrypted);

echo "Encrypted: $encrypted\n";
echo "Decrypted $decrypted\n";
```