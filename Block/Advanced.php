<?php

namespace Magenest\Movie\Block;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Advanced extends Template implements BlockInterface
{
    protected $collectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory $collectionFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function getAllAdvanced()
    {
        $collection = $this->collectionFactory->create();
        $collection->getSelect()->join(
            ['magenest_director' => $collection->getTable('magenest_director')],
            'main_table.director_id = magenest_director.director_id',
            ['directorname' => 'magenest_director.name']);
        $collection->getSelect()->join(
            ['magenest_movie_actor' => $collection->getTable('magenest_movie_actor')],
            'main_table.movie_id = magenest_movie_actor.movie_id'
        )->join(['magenest_actor' => $collection->getTable('magenest_actor')],
            'magenest_actor.actor_id = magenest_movie_actor.actor_id', ["actorname"=> new \Zend_Db_Expr('group_concat(magenest_actor.name SEPARATOR ",")')])
            ->group('main_table.movie_id');


        return $collection;
    }
}
