# CommonEntityClassBundle

List of common classes :
------------------------

There are several common classes that you can use, here is an exhaustive list : 

- [CommonUser](https://github.com/thomasmerlin/CommonEntityClassBundle/blob/master/src/Entity/CommonUser.php)


Generate mappings :
-------------------

(**Note :** The following example supposes that you are using Doctrine.)
Let's suppose you want to map a ``User`` class according to the ``CommonUser`` class.
All you have to do is extending the ``CommonUser`` class, like this :

````````````
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Floaush\Bundle\CommonEntityClass\Entity\CommonUser;

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity()
 */
class User extends CommonUser
{
}
````````````

Now you can see the mapping generated with ``php bin/console doctrine:schema:update --dump-sql`` or also with the 
[DoctrineMigrationsBundle] using ``php bin/console doctrine:migrations:generate``.

Then, you can simply update the database.

[DoctrineMigrationsBundle]: https://symfony.com/doc/master/bundles/DoctrineMigrationsBundle/index.html
