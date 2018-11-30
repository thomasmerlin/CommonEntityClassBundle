# CommonEntityClassBundle

Installation :
--------------

- Install the package with ``composer require floaush/common-entity-class-bundle``

- (Note : Later on, a recipe will be added to avoid following an
 installation guide)

- Enable the kernel in the ``config/bundles.php`` file :
``````
<?php

return [
    // Your other bundles
    Floaush\Bundle\CommonEntityClass\CommonEntityClassBundle::class => ['all' => true],
];

``````

You're done ! Congratulations ! :thumbsup: