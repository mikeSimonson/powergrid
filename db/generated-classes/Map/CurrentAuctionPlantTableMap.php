<?php

namespace Map;

use \CurrentAuctionPlant;
use \CurrentAuctionPlantQuery;
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
 * This class defines the structure of the 'current_auction_plant' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CurrentAuctionPlantTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.CurrentAuctionPlantTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'powergrid';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'current_auction_plant';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\CurrentAuctionPlant';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'CurrentAuctionPlant';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the game_id field
     */
    const COL_GAME_ID = 'current_auction_plant.game_id';

    /**
     * the column name for the card_id field
     */
    const COL_CARD_ID = 'current_auction_plant.card_id';

    /**
     * the column name for the highest_bid field
     */
    const COL_HIGHEST_BID = 'current_auction_plant.highest_bid';

    /**
     * the column name for the highest_bidder_id field
     */
    const COL_HIGHEST_BIDDER_ID = 'current_auction_plant.highest_bidder_id';

    /**
     * the column name for the round_number field
     */
    const COL_ROUND_NUMBER = 'current_auction_plant.round_number';

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
        self::TYPE_PHPNAME       => array('GameId', 'CardId', 'HighestBid', 'HighestBidderId', 'RoundNumber', ),
        self::TYPE_CAMELNAME     => array('gameId', 'cardId', 'highestBid', 'highestBidderId', 'roundNumber', ),
        self::TYPE_COLNAME       => array(CurrentAuctionPlantTableMap::COL_GAME_ID, CurrentAuctionPlantTableMap::COL_CARD_ID, CurrentAuctionPlantTableMap::COL_HIGHEST_BID, CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID, CurrentAuctionPlantTableMap::COL_ROUND_NUMBER, ),
        self::TYPE_FIELDNAME     => array('game_id', 'card_id', 'highest_bid', 'highest_bidder_id', 'round_number', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('GameId' => 0, 'CardId' => 1, 'HighestBid' => 2, 'HighestBidderId' => 3, 'RoundNumber' => 4, ),
        self::TYPE_CAMELNAME     => array('gameId' => 0, 'cardId' => 1, 'highestBid' => 2, 'highestBidderId' => 3, 'roundNumber' => 4, ),
        self::TYPE_COLNAME       => array(CurrentAuctionPlantTableMap::COL_GAME_ID => 0, CurrentAuctionPlantTableMap::COL_CARD_ID => 1, CurrentAuctionPlantTableMap::COL_HIGHEST_BID => 2, CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID => 3, CurrentAuctionPlantTableMap::COL_ROUND_NUMBER => 4, ),
        self::TYPE_FIELDNAME     => array('game_id' => 0, 'card_id' => 1, 'highest_bid' => 2, 'highest_bidder_id' => 3, 'round_number' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('current_auction_plant');
        $this->setPhpName('CurrentAuctionPlant');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\CurrentAuctionPlant');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('game_id', 'GameId', 'INTEGER' , 'game', 'id', true, null, null);
        $this->addForeignKey('card_id', 'CardId', 'INTEGER', 'game_auction_card', 'id', false, null, null);
        $this->addColumn('highest_bid', 'HighestBid', 'INTEGER', false, null, null);
        $this->addForeignKey('highest_bidder_id', 'HighestBidderId', 'INTEGER', 'player', 'id', false, null, null);
        $this->addColumn('round_number', 'RoundNumber', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Game', '\\Game', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':game_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Card', '\\GameAuctionCard', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':card_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('HighestBidder', '\\Player', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':highest_bidder_id',
    1 => ':id',
  ),
), null, null, null, false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('GameId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('GameId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('GameId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? CurrentAuctionPlantTableMap::CLASS_DEFAULT : CurrentAuctionPlantTableMap::OM_CLASS;
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
     * @return array           (CurrentAuctionPlant object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CurrentAuctionPlantTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CurrentAuctionPlantTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CurrentAuctionPlantTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CurrentAuctionPlantTableMap::OM_CLASS;
            /** @var CurrentAuctionPlant $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CurrentAuctionPlantTableMap::addInstanceToPool($obj, $key);
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
            $key = CurrentAuctionPlantTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CurrentAuctionPlantTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var CurrentAuctionPlant $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CurrentAuctionPlantTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CurrentAuctionPlantTableMap::COL_GAME_ID);
            $criteria->addSelectColumn(CurrentAuctionPlantTableMap::COL_CARD_ID);
            $criteria->addSelectColumn(CurrentAuctionPlantTableMap::COL_HIGHEST_BID);
            $criteria->addSelectColumn(CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID);
            $criteria->addSelectColumn(CurrentAuctionPlantTableMap::COL_ROUND_NUMBER);
        } else {
            $criteria->addSelectColumn($alias . '.game_id');
            $criteria->addSelectColumn($alias . '.card_id');
            $criteria->addSelectColumn($alias . '.highest_bid');
            $criteria->addSelectColumn($alias . '.highest_bidder_id');
            $criteria->addSelectColumn($alias . '.round_number');
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
        return Propel::getServiceContainer()->getDatabaseMap(CurrentAuctionPlantTableMap::DATABASE_NAME)->getTable(CurrentAuctionPlantTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CurrentAuctionPlantTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CurrentAuctionPlantTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CurrentAuctionPlantTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a CurrentAuctionPlant or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CurrentAuctionPlant object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CurrentAuctionPlantTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \CurrentAuctionPlant) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CurrentAuctionPlantTableMap::DATABASE_NAME);
            $criteria->add(CurrentAuctionPlantTableMap::COL_GAME_ID, (array) $values, Criteria::IN);
        }

        $query = CurrentAuctionPlantQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CurrentAuctionPlantTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CurrentAuctionPlantTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the current_auction_plant table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CurrentAuctionPlantQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CurrentAuctionPlant or Criteria object.
     *
     * @param mixed               $criteria Criteria or CurrentAuctionPlant object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CurrentAuctionPlantTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CurrentAuctionPlant object
        }


        // Set the correct dbName
        $query = CurrentAuctionPlantQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CurrentAuctionPlantTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CurrentAuctionPlantTableMap::buildTableMap();
