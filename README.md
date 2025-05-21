# 🧙🏻‍♂️ Laravel Alchemist ⚗️

![Latest Version](https://img.shields.io/packagist/v/your-vendor/your-package.svg)
![License](https://img.shields.io/packagist/l/your-vendor/your-package.svg)
![Downloads](https://img.shields.io/packagist/dt/your-vendor/your-package.svg)

### The JSON Revolution for Laravel, a simple, fast, and elegant alternative to Laravel JSON Resource.

---

## 📖 Table of Contents
1. [Philosophy](#philosophy)
2. [Requirements](#requirements)
3. [Installation](#installation)
5. [Fundamentals](#fundamentals)
6. [Quick Start](#quick-start)
7. [Usage & Examples](#usage-examples)
8. [Contributing](#contributing)
9. [Changelog](#changelog)
10. [License](#license)

---

## 🔮 Philosophy - The Problem with Traditional Laravel Resources

We've all been there:

- Creating endless resource classes that mostly repeat the same boilerplate.
- Duplicating code across multiple API responses.
- Drowning in maintenance when frontend requirements change.
- Wrestling with nested relationships that bloat your codebase.

The breaking point comes when:

- Your API evolves and resources multiply.
- Frontend devs request constant field changes.
- Your models grow, but your resource classes don't scale.
- Nested relationships turn into unmaintainable spaghetti.

The Solution: Laravel Alchemist - Formula Approach

**One File to Rule Them All**

Each model gets a single`SomeModelFormula.php`where you:

✅ Define all fields as simple strings in arrays.<br>
✅ Manage every API variation in one place.<br>
✅ Update database changes with a single edit.

**Relationship Handling Made Simple**

- Reference nested resources by their name only.
- Each relation maintains its own`Formula::class`.
- No more recursive resource nightmares.

**Frontend-Friendly Flexibility**

- Instantly modify fields without resource class hopping.
- Track all API variations through clear formula methods.
- Never miss a field update again.

**Why This Works**

- **Less Code:** Eliminates 80%+ of resource boilerplate.
- **True Maintainability:** All changes flow through controlled formulas.
- **Team Friendly:** Frontend can request changes without breaking your flow.

> *“Laravel Resources grant you the illusion of control – meticulous yet maddening. Laravel Alchemist surrenders this false dominion... and in its place conjures true magic.„*

---

[//]: # (## ⚙️ Configuration)
## 📋 Requirements

- PHP ≥ 8.2
- Laravel ≥ 11.x

---

## 🔧 Installation

You may install Alchemist using the Composer package manager:

```bash
  composer require mj/alchemist
```

You can publish the Alchemist configuration file`config/alchemist.php` and the default`Formulas/Formula.php`using`vendor:publish` Artisan command:

```bash
   php artisan vendor:publish --provider="Serri\Alchemist\AlchemistServiceProvider"
```

Or for configuration file using:

```bash
   php artisan vendor:publish --tag=alchemist-config
```

For default formula class using:

```bash
    php artisan vendor:publish --tag=alchemist-formula
```

---

## 📖 Fundamentals

To wield this package's magic effectively, you must understand these arcane principles:
### **The Formulas Directory**

- Your **sacred workshop** where all model formulas reside
- Created automatically at`app/Formulas/Formula.php`when you publish the default formula class as we did in the [Installtion](#installtion) Section:

```php
namespace App\Formulas;

class Formula
{
    const BlankParchment = ['id']; # Default formula.
}
```

### Crafting Your Formulas
Begin your alchemy by creating formula classes in`app/Formulas/`like so:

```php
namespace App\Formulas;

class UserFormula extends Formula
{
    # Define your transformations here.
    # ex:
    
    const UserLoginFormula = ['id', 'username', /*...etc.*/]
    
    // ... other formulas.
}
```

> #### Key Laws:
> - #### Each model deserves its own formula class`ModelNameFormula.php`<br>
> - #### The`BlankParchment`remains your fallback option.


### Using package default Formula
If you did not publish the`app/Formulas/Formula.php`, you can still use the default`Formula.php` provided by the package like this:

```php
namespace App\Formulas;

use Serri\Alchemist\Formulas\Formula

class UserFormula extends Formula
{
    // Define your transformations here.
}
```

Relationships must be explicitly marked with the #[Relation] attribute to be available in formulas:

---

## 🪄 Quick Start

### 1. Model Configuration

To enable formula support, models must either:

Inherit from`AlchemyModel`.

```php
use Serri\Alchemist\Extensions\AlchemyModel;

class Post extends AlchemyModel 
{
    //
}
```

Or, Use`HasAlchemyFormulas`Trait.

```php
use Serri\Alchemist\Concerns\HasAlchemyFormulas;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasAlchemyFormulas;
    
    //
}
```

### 2. Exposing Fields

By default, everything included in`$fillable`array and`$guarded` array are automatically loaded in formulas.

```php
use Serri\Alchemist\Concerns\HasAlchemyFormulas;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasAlchemyFormulas;
    
    # Automatically exposed to formulas.
    protected $guarded = ['id'];
    
    # Automatically exposed to formulas.
    protected $fillable = [
        'title',
        'description',
        'published_at'
    ]
}
```

### 3. Exposing Relationships

Relationships must be explicitly marked with the`#[Relation]`decorator to be available in formulas:

```php
use Serri\Alchemist\Decorators\Relation;

#[Relation] # Exposed to formulas as 'comments'
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}

#[Relation(name: 'author_profile')] # Exposed to formulas as 'author_profile'
public function profile(): HasOne
{
    return $this->hasOne(Profile::class);
}
```

### 4. Exposing Custom Methods

Model methods require the`#[Mutagen]`decorator to be accessible in formulas:

```php
use Serri\Alchemist\Decorators\Mutagen;

#[Mutagen] # Exposed to formulas as 'fullName'
public function fullName(): string 
{
    return "{$this->first_name} {$this->last_name}";
}

#[Mutagen(name: 'is_verified')] # Exposed to formulas as 'is_verified'
public function isVerified(): bool
{
    return $this->email_verified_at !== null;
}
```
> #### Keynotes
> - #### `$fillable`/`$guarded`: are available to use in formulas by default.
> - #### **Decorators:** Only`#[Relation]`and`#[Mutagen]`methods are exposed to formulas.


### 5. Crafting Formulas

Once your models are properly configured, you can define formulas to transform your data. Formulas are defined in classes within the`app/Formulas/`directory.

Here is an example:

```php
namespace App\Formulas;

class PostFormula extends Formula
{
    const AuthorFormula = ['id', 'title', 'author_profile'];
    
    const WithComments = ['id', 'title', 'comments']
    
    const DetailedFormula = ['id', 'title', 'description', 'comments', 'author_profile'] 
}

```

For profile formula:

```php
namespace App\Formulas;

class ProfileFormula extends Formula
{
    const OnlyNameFormula = ['fullName'];
    
    const AnyOtherFormula = ['id', 'username', 'fullName']
}
```

---

## 🛠️ Usage & Examples

### Basic Data Transformation

To transform model data using your formulas:

```php
use App\Models\Post;
use App\Formulas\PostFormula;
use Serri\Alchemist\Facades\Alchemist;

// 1. Fetch your models
$posts = Post::with('author.profile')->get();

// 2. Specify which formulas to use
Post::setFormula(PostFormula::AuthorFormula);
Profile::setFormula(ProfileFormula::OnlyNameFormula);

// 3. Process through Alchemist
$transformedData = Alchemist::brew($posts);
```

Results:

```php
[
  [
    'id' => 1,
    'title' => "Post 1",
    'author_profile' => [
      'fullName' => "some author name"
    ]
  ],
  [
    'id' => 2,
    'title' => 'Post 2',
    'author_profile' => [
      'fullName' => "some author name"
    ]
  ],
  [
    'id' => 3,
    'title' => 'Post 3',
    'author_profile' => [
      'fullName' => "some author name"
    ]
  ]
]
```

### Key Methods
| Method         | Purpose                 |  Example                                      |
 |----------------|-------------------------|-----------------------------------------------|
| `setFormula()` | Assigns formula variant | `Post::setFormula(PostFormula::DetailedView)` |
| `brew()`       | Executes transformation | `Alchemist::brew($collection\|$model)`        |

### Patterns

#### 1. Context-Aware Formulas

```php
$formula = auth()->user()->isAdmin()
? PostFormula::AdminView
: PostFormula::PublicView;

Post::setFormula($formula);
```

#### 2. Direct Model Transformation

```php
$post = Post::find(1);
return Alchemist::brew($post); // Auto-detects single model
```

#### 3. Pagination Support

```php
$paginated = Post::paginate(15);
return Alchemist::brew($paginated); // Preserves pagination structure
```

### Syntax Variations

#### 1. Helper Function (Simplest)

```php
$posts = Post::all();
$transformed = alchemist()->brew($posts);
```

#### 2. Facade (For static contexts)

```php
use Serri\Alchemist\Facades\Alchemist;

$data = Alchemist::brew($models);
```

#### 3. Dependency Injection (Recommended for controllers)

```php
use Serri\Alchemist\Services\Alchemist;

class PostController
{
public function __construct(
    protected Alchemist $alchemist
) {}

    public function index()
    {
        return $this->alchemist->brew(Post::all());
    }
}
```
