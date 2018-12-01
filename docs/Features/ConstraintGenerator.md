# CommonEntityClassBundle

Handling Constraint Violations :
--------------------------------

CommonEntityClassBundle comes with a Constraint Generator feature to handle form errors.
It works as an annotation defined on top of the class.

The ``@ConstraintGenerator`` annotation takes one argument `fields` which is an associative array.
Inside this ``fields`` argument, you can define everything to handle your Constraints. 
Each element of the ``fields`` argument must be an array, following this scheme :

`````
{
     "myPropertyName",
     "myConstraintClassName",
     { "constraintOption1" : "constraintValue1", {# Other parameters #}}
}
``````

Here is now an example of implementation of the AssertGenerator :

- Definition of the class

````````````php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Floaush\Bundle\CommonEntityClass\Annotation\ConstraintGenerator;
use Floaush\Bundle\CommonEntityClass\Entity\CommonUser;

/**
 * Class MyUserClass
 * @package App\Entity
 * @ORM\Entity()
 * @ConstraintGenerator(
 *     fields={
 *        { "firstname", "Length", {"max" : 3, "maxMessage" : "Value is too long for this field. {{ limit }} is maximum."} },
 *        { "lastname", "NotNull", {"message", "Second Another message custom error"} }
 *     }
 * )
 */
class MyUserClass extends CommonUser
{
}

````````````

- Creation of a ``MyUserClass`` form :

````php
<?php

namespace App\Form;

use App\Entity\MyUserClass;
use Floaush\Bundle\CommonEntityClass\EventListener\ConstraintGeneratorSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MyUserClassType extends AbstractType
{
    /**
     * @var \Floaush\Bundle\CommonEntityClass\EventListener\ConstraintGeneratorSubscriber $assertGeneratorSubscriber
     */
    private $constraintGeneratorSubscriber;

    public function __construct(ConstraintGeneratorSubscriber $constraintGeneratorSubscriber)
    {
        $this->constraintGeneratorSubscriber = $constraintGeneratorSubscriber;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Adding your form fields

        $builder->addEventSubscriber($this->constraintGeneratorSubscriber);
    }
}
````

- Define the form as a service :

````yaml
App\Form\UserType:
    arguments:
        - "@common_entity_class.constraint_generator_subscriber"
    tags:
        - form.type
````

- Create a controller with a form the classic way.

If your field is invalidate, the errors will be well displayed.