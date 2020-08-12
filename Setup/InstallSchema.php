<?php

namespace Magenest\Movie\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;


class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        /**
         * Create table 'magenest_director'
         * */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('magenest_director')
        )->addColumn(
            'director_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ],
            'Director ID'
        )->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
            'nullable' => false
        ],
            'Director Name'
        )->setComment(
            'Director Table'
        );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'magenest_actor'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('magenest_actor')
        )->addColumn(
            'actor_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ],
            'Actor ID'
        )->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
            'nullable' => false
        ],
            'Actor Name'
        )->setComment(
            'Actor Table'
        );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'magenest_movie'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('magenest_movie')
        )->addColumn(
            'movie_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ],
            'Movie ID'
        )->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
            'nullable' => false
        ],
            'Movie Name'
        )->addColumn(
            'description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, [
            'nullable' => false
        ],
            'Description'
        )->addColumn(
            'rating',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
            'nullable' => false
        ],
            'Rating'
        )->addColumn(
            'director_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
            'unsigned' => true,
            'nullable' => false
        ],
            'Director Id'
        )->addForeignKey(
            $installer->getFkName('magenest_movie',
                'director_id',
                'magenest_director',
                'director_id'),
            'director_id',
            $installer->getTable('magenest_director'),
            'director_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Movie Table'
        );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'magenest_movie_actor'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('magenest_movie_actor')
        )->addColumn(
            'movie_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
            'unsigned' => true,
            'nullable' => false
        ],
            'Movie Id'
        )->addColumn(
            'actor_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
            'unsigned' => true,
            'nullable' => false
        ],
            'Actor Id'
        )->addForeignKey(
            $installer->getFkName(
                'magenest_movie_actor',
                'movie_id',
                'magenest_movie',
                'movie_id'),
            'movie_id',
            $installer->getTable('magenest_movie'),
            'movie_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            /**
             *
             * ACTION_CASCADE: It automatically update or delete
             * the matching child row(foreign key row) when parent table row get
             * updated or deleted.

             * ACTION_SET_NULL: It sets the value to null of foreign key column or columns
             * when parent table row get updated or deleted.

             * ACTION_NO_ACTION: When a parent table’s column get deleted or updated
             * then there is no action is performed on child column.

             * ACTION_RESTRICT: Rejects the update or delete operation,
             * it means no changes happens when parent table row get deleted or updated.
             * This action is used as default action.

             * ACTION_SET_DEFAULT: it is working same as ACTION_SET_NULL,
             * difference is it sets column’s default value
             * when a parent row get update or delete.
             */
        )->addForeignKey(
            $installer->getFkName(
                'magenest_movie_actor',
                'actor_id',
                'magenest_actor',
                'actor_id'),
            'actor_id',
            $installer->getTable('magenest_actor'),
            'actor_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Movie_Actor Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }

}

