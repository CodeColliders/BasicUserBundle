<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use CodeColliders\BasicUserBundle\Entity\UserBase;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity()
*/
class <?= $class_name; ?> extends UserBase<?= "\n" ?>
{
}
