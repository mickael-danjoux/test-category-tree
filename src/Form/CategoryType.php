<?php

namespace App\Form;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    private  $categoryId;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->categoryId = $options['attr']['category']->getId();

        $builder
            ->add('title',TextType::class,['label'=>'Nom de la categorie'])
            ->add('parent',EntityType::class,[
                'label' => 'Catégorie parent',
                'class' => Category::class,
                'choice_label' => function(Category $category){
                        if ($category->getLvl() > 0) {
                            $prefix = str_repeat('- ', $category->getLvl());

                            return $prefix . ' ' . $category->getTitle();

                        }
                        return " ";

                },
                'multiple'  => false,
                'expanded'  => false,
                'query_builder' => function(EntityRepository $er){

                    return $er
                        ->createQueryBuilder('node')
                        ->where('node.root = :treeId')
                        ->setParameter('treeId', $this->categoryId)
                        ->orderBy('node.root, node.lft', 'ASC');
                }

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
