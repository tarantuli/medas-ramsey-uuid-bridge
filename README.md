# medas-ramsey-uuid-bridge

Part of the [Medas framework](https://github.com/tarantuli/medas-core).

## Description

Bridges `ramsey/uuid` with the Medas framework's `Uuid` and `UuidProvider` interfaces. This package is the standard UUID implementation used across the framework — it is required by `medas-entity-manager`, `medas-pdo-storage`, and `medas-object-to-array-serializer` whenever UUID-typed entity properties are in use.

`Uuid` wraps a `ramsey/uuid` `UuidInterface` and implements the framework's `Medas\Core\Interfaces\Uuid` contract, exposing `__toString()` (standard hyphenated format) and `toBytes()` (16-byte binary string). It is annotated with `#[ObjectToArrayHandler(UuidProvider::class)]` so `medas-object-to-array-serializer` automatically delegates its serialization to `UuidProvider`.

`UuidProvider` implements both `UuidProviderInterface` and `ObjectToArrayHandler`:

| Method                       | Description                                                            |
|------------------------------|------------------------------------------------------------------------|
| `create()`                   | Generates a new UUID v7 (time-ordered) via `Ramsey\Uuid\Uuid::uuid7()` |
| `fromBytes(string $bytes)`   | Reconstructs a `Uuid` from a 16-byte binary string                     |
| `fromString(string $string)` | Reconstructs a `Uuid` from a hyphenated UUID string                    |
| `toArray(object $value)`     | Serializes a `Uuid` to `[$binaryBytes]` for storage                    |
| `toObject(array $value)`     | Deserializes `[$binaryBytes]` back to a `Uuid`                         |

UUIDs are stored as 16-byte binary values in the database (not as strings), which is more space-efficient and index-friendly.

## Usage

### Package developer context

Register the package:

```php
use Medas\RamseyUuidBridge\RamseyUuidBridgePackage;

RamseyUuidBridgePackage::instance();
```

**Generating a new UUID:**

```php
use Medas\Core\Interfaces\UuidProvider;
use Medas\Core\Attributes\Service;

#[Service]
readonly class InvoiceFactory
{
    public function __construct(
        private UuidProvider $uuidProvider,
    ) {}

    public function create(): Invoice
    {
        $invoice = new Invoice();
        $invoice->id = $this->uuidProvider->create(); // UUID v7

        return $invoice;
    }
}
```

**Converting between string and `Uuid`:**

```php
use Medas\Core\Interfaces\UuidProvider;

// From a hyphenated string (e.g., received in an HTTP request)
$uuid = $this->uuidProvider->fromString('01963f4a-c3b2-7000-8d5e-1a2b3c4d5e6f');

// From raw binary bytes (e.g., read from a database BINARY(16) column)
$uuid = $this->uuidProvider->fromBytes($rawBytes);

// Back to string
echo (string) $uuid;       // '01963f4a-c3b2-7000-8d5e-1a2b3c4d5e6f'

// Back to bytes
$bytes = $uuid->toBytes();  // 16-byte binary string
```

**Using `Uuid` as an entity id:**

```php
use Medas\Core\Interfaces\{HasId, Uuid};
use Medas\EntityManager\Attributes\{Entity, Id};
use Medas\EntityManager\Traits\Timestamps;
use Medas\RamseyUuidBridge\Uuid as ConcreteUuid;

#[Entity(store: 'invoices')]
class Invoice implements HasId
{
    use Timestamps;

    #[Id]
    public Uuid $id;

    public string $status;

    public function id(): Uuid
    {
        return $this->id;
    }
}
```

The entity manager and `pdo-storage` both handle binary UUID serialization automatically when this package is registered.

**Handling invalid input:**

```php
use Medas\RamseyUuidBridge\Exceptions\{InvalidStringGiven, InvalidBytesGiven};

try {
    $uuid = $this->uuidProvider->fromString($input);
} catch (InvalidStringGiven $e) {
    // $input is not a valid UUID string
}

try {
    $uuid = $this->uuidProvider->fromBytes($input);
} catch (InvalidBytesGiven $e) {
    // $input is not a valid 16-byte UUID binary
}
```

### Backend user context

No configuration is required. Once the package is registered, all services that depend on `UuidProvider` or `Uuid` will use this implementation automatically.

**UUID v7** — `UuidProvider::create()` generates UUID version 7, which is time-ordered. This means new UUIDs sort chronologically and are efficient as clustered index keys in MySQL (`BINARY(16)`) or SQLite (`blob`). Unlike UUID v4 (random), v7 UUIDs avoid index fragmentation on high-write tables.

**Binary storage** — UUIDs are stored as raw 16-byte binary values, not as 36-character strings. This halves storage size and speeds up indexed lookups. The entity manager handles the conversion transparently; no manual encoding is needed in application code.
