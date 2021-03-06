<?php

namespace Map;

use \Card;
use \CardQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'card' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CardTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.CardTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'powergrid';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'card';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Card';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Card';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'card.id';

    /**
     * the column name for the starting_auction_price field
     */
    const COL_STARTING_AUCTION_PRICE = 'card.starting_auction_price';

    /**
     * the column name for the resource_cost field
     */
    const COL_RESOURCE_COST = 'card.resource_cost';

    /**
     * the column name for the power_output field
     */
    const COL_POWER_OUTPUT = 'card.power_output';

    /**
     * the column name for the trigger_step field
     */
    const COL_TRIGGER_STEP = 'card.trigger_step';

    /**
     * the column name for the card_set_id field
     */
    const COL_CARD_SET_ID = 'card.card_set_id';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'StartingAuctionPrice', 'ResourceCost', 'PowerOutput', 'TriggerStep', 'CardSetId', ),
        self::TYPE_CAMELNAME     => array('id', 'startingAuctionPrice', 'resourceCost', 'powerOutput', 'triggerStep', 'cardSetId', ),
        self::TYPE_COLNAME       => array(CardTableMap::COL_ID, CardTableMap::COL_STARTING_AUCTION_PRICE, CardTableMap::COL_RESOURCE_COST, CardTableMap::COL_POWER_OUTPUT, CardTableMap::COL_TRIGGER_STEP, CardTableMap::COL_CARD_SET_ID, ),
        self::TYPE_FIELDNAME     => array('id', 'starting_auction_price', 'resource_cost', 'power_output', 'trigger_step', 'card_set_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'StartingAuctionPrice' => 1, 'ResourceCost' => 2, 'PowerOutput' => 3, 'TriggerStep' => 4, 'CardSetId' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'startingAuctionPrice' => 1, 'resourceCost' => 2, 'powerOutput' => 3, 'triggerStep' => 4, 'cardSetId' => 5, ),
        self::TYPE_COLNAME       => array(CardTableMap::COL_ID => 0, CardTableMap::COL_STARTING_AUCTION_PRICE => 1, CardTableMap::COL_RESOURCE_COST => 2, CardTableMap::COL_POWER_OUTPUT => 3, CardTableMap::COL_TRIGGER_STEP => 4, CardTableMap::COL_CARD_SET_ID => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'starting_auction_price' => 1, 'resource_cost' => 2, 'power_output' => 3, 'trigger_step' => 4, 'card_set_id' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('card');
        $this->setPhpName('Card');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Card');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('starting_auction_price', 'StartingAuctionPrice', 'INTEGER', false, null, null);
        $this->addColumn('resource_cost', 'ResourceCost', 'INTEGER', false, null, null);
        $this->addColumn('power_output', 'PowerOutput', 'INTEGER', false, null, null);
        $this->addColumn('trigger_step', 'TriggerStep', 'INTEGER', false, null, null);
        $this->addForeignKey('card_set_id', 'CardSetId', 'INTEGER', 'card_set', 'id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CardSet', '\\CardSet', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':card_set_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('CardResourceType', '\\CardResource', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':card_id',
    1 => ':id',
  ),
), null, null, 'CardResourceTypes', false);
        $this->addRelation('GameCard', '\\GameCard', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':card_id',
    1 => ':id',
  ),
), null, null, 'GameCards', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? CardTableMap::CLASS_DEFAULT : CardTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Card object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CardTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CardTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CardTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CardTableMap::OM_CLASS;
            /** @var Card $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CardTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = CardTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CardTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Card $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CardTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(CardTableMap::COL_ID);
            $criteria->addSelectColumn(CardTableMap::COL_STARTING_AUCTION_PRICE);
            $criteria->addSelectColumn(CardTableMap::COL_RESOURCE_COST);
            $criteria->addSelectColumn(CardTableMap::COL_POWER_OUTPUT);
            $criteria->addSelectColumn(CardTableMap::COL_TRIGGER_STEP);
            $criteria->addSelectColumn(CardTableMap::COL_CARD_SET_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.starting_auction_price');
            $criteria->addSelectColumn($alias . '.resource_cost');
            $criteria->addSelectColumn($alias . '.power_output');
            $criteria->addSelectColumn($alias . '.trigger_step');
            $criteria->addSelectColumn($alias . '.card_set_id');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(CardTableMap::DATABASE_NAME)->getTable(CardTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CardTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CardTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CardTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Card or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Card object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CardTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Card) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CardTableMap::DATABASE_NAME);
            $criteria->add(CardTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = CardQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CardTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CardTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the card table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CardQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Card or Criteria object.
     *
     * @param mixed               $criteria Criteria or Card object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CardTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Card object
        }

        if ($criteria->containsKey(CardTableMap::COL_ID) && $criteria->keyContainsValue(CardTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CardTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = CardQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CardTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CardTableMap::buildTableMap();
