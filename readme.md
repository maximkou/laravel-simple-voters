# Laravel 5 Voters System
This package provide Symfony Security Voters like system, which allow you to check object-based access.

### Using examples
Check, is current user can edit specific Post:
```php
is_granted('edit', $post) // return true or false
// or using Facade
Access::isGranted('edit', $post)
```

Check, is specific user can read or write specific Post info:
```php
is_granted(['read', 'write'], $post, $user) // return true or false
// or using Facade
Access::isGranted(['read', 'write'], $post, $user)
```

### Installation:
Require dependency using composer:
```bash
composer require maximkou/laravel-simple-voters ^0.1
```

Add service provider to your `config/app.php`:
```php
'providers' => [
    Maximkou\SimpleVoters\SimpleVotersServiceProvider::class,
```

Add facade alias to your `config/app.php` (optional):
```php
'aliases' => [
    'Access' => Maximkou\SimpleVoters\Facades\Access::class,
```

Publish package config (optional):
```bash
php artisan vendor:publish --provider="Maximkou\SimpleVoters\SimpleVotersServiceProvider"
```

### Configuration:
```php
// file config/voters.php
/**
 * Available out of the box strategies: affirmative, unanimous, consensus.
 * You can use custom voting strategy by registering service with name 'simple_voters.strategies.{strategy_name}'
 */
'strategy' => 'unanimous',

/**
 * If pro and contra votes count is equal, or all voters abstain, used this value
 */
'is_granted_by_default' => true,

/**
 * List of Voter classes.
 */
'voters' => [
    // put here your voters classes
],
```

### Creating Voter
Voter must implement `Maximkou\SimpleVoters\Contracts\Voter` or extend `Maximkou\SimpleVoters\AbstractVoter` class.
Then add your voter to config.

Example:
```php
class PostVoter extends AbstractVoter
{
    protected function supports($action, $object)
    {
        return in_array('action', ['edit', 'remove']) && $object instanceOf Post;
    }
    
    protected function isGranted($action, $object, $user)
    {
        $checker = "can".ucfirst($action);
        
        return $this->$checker($object, $user);
    }
    
    private function canEdit($object, $user)
    {
        return $object->user_id = $user->id;
    }
    
    private function canRemove($object, $user)
    {
        return $object->user_id = $user->id;
    }
}
```
