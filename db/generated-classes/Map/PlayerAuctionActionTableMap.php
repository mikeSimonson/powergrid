<?php

namespace Map;

use \PlayerAuctionAction;
use \PlayerAuctionActionQuery;
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
 * This class defines the structure of the 'player_auction_action' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PlayerAuctionActionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PlayerAuctionActionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'powergrid';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'player_auction_action';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PlayerAuctionAction';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PlayerAuctionAction';

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
     * the column name for the player_id field
     */
    const COL_PLAYER_ID = 'player_auction_action.player_id';

    /**
     * the column name for the game_id field
     */
    const COL_GAME_ID = 'player_auction_action.game_id';

    /**
     * the column name for the has_bid field
     */
    const COL_HAS_BID = 'player_auction_action.has_bid';

    /**
     * the column name for the has_passed field
     */
    const COL_HAS_PASSED = 'player_auction_action.has_passed';

    /**
     * the column name for the round_number field
     */
    const COL_ROUND_NUMBER = 'player_auction_action.round_number';

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
        self::TYPE_PHPNAME       => array('PlayerId', 'GameId', 'HasBid', 'HasPassed', 'RoundNumber', ),
        self::TYPE_CAMELNAME     => array('playerId', 'gameId', 'hasBid', 'hasPassed', 'roundNumber', ),
        self::TYPE_COLNAME       => array(PlayerAuctionActionTableMap::COL_PLAYER_ID, PlayerAuctionActionTableMap::COL_GAME_ID, PlayerAuctionActionTableMap::COL_HAS_BID, PlayerAuctionActionTableMap::COL_HAS_PASSED, PlayerAuctionActionTableMap::COL_ROUND_NUMBER, ),
        self::TYPE_FIELDNAME     => array('player_id', 'game_id', 'has_bid', 'has_passed', 'round_number', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('PlayerId' => 0, 'GameId' => 1, 'HasBid' => 2, 'HasPassed' => 3, 'RoundNumber' => 4, ),
        self::TYPE_CAMELNAME     => array('playerId' => 0, 'gameId' => 1, 'hasBid' => 2, 'hasPassed' => 3, 'roundNumber' => 4, ),
        self::TYPE_COLNAME       => array(PlayerAuctionActionTableMap::COL_PLAYER_ID => 0, PlayerAuctionActionTableMap::COL_GAME_ID => 1, PlayerAuctionActionTableMap::COL_HAS_BID => 2, PlayerAuctionActionTableMap::COL_HAS_PASSED => 3, PlayerAuctionActionTableMap::COL_ROUND_NUMBER => 4, ),
        self::TYPE_FIELDNAME     => array('player_id' => 0, 'game_id' => 1, 'has_bid' => 2, 'has_passed' => 3, 'round_number' => 4, ),
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
        $this->setName('player_auction_action');
        $this->setPhpName('PlayerAuctionAction');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PlayerAuctionAction');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('player_id', 'PlayerId', 'INTEGER' , 'player', 'id', true, null, null);
        $this->addForeignKey('game_id', 'GameId', 'INTEGER', 'game', 'id', false, null, null);
        $this->addColumn('has_bid', 'HasBid', 'BOOLEAN', false, null, null);
        $this->addColumn('has_passed', 'HasPassed', 'BOOLEAN', false, null, null);
        $this->addColumn('round_number', 'RoundNumber', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Player', '\\Player', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':player_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Game', '\\Game', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':game_id',
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PlayerId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PlayerId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('PlayerId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PlayerAuctionActionTableMap::CLASS_DEFAULT : PlayerAuctionActionTableMap::OM_CLASS;
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
     * @return array           (PlayerAuctionAction object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PlayerAuctionActionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PlayerAuctionActionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PlayerAuctionActionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PlayerAuctionActionTableMap::OM_CLASS;
            /** @var PlayerAuctionAction $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PlayerAuctionActionTableMap::addInstanceToPool($obj, $key);
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
            $key = PlayerAuctionActionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PlayerAuctionActionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PlayerAuctionAction $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PlayerAuctionActionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PlayerAuctionActionTableMap::COL_PLAYER_ID);
            $criteria->addSelectColumn(PlayerAuctionActionTableMap::COL_GAME_ID);
            $criteria->addSelectColumn(PlayerAuctionActionTableMap::COL_HAS_BID);
            $criteria->addSelectColumn(PlayerAuctionActionTableMap::COL_HAS_PASSED);
            $criteria->addSelectColumn(PlayerAuctionActionTableMap::COL_ROUND_NUMBER);
        } else {
            $criteria->addSelectColumn($alias . '.player_id');
            $criteria->addSelectColumn($alias . '.game_id');
            $criteria->addSelectColumn($alias . '.has_bid');
            $criteria->addSelectColumn($alias . '.has_passed');
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
        return Propel::getServiceContainer()->getDatabaseMap(PlayerAuctionActionTableMap::DATABASE_NAME)->getTable(PlayerAuctionActionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PlayerAuctionActionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PlayerAuctionActionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PlayerAuctionActionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PlayerAuctionAction or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PlayerAuctionAction object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerAuctionActionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PlayerAuctionAction) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PlayerAuctionActionTableMap::DATABASE_NAME);
            $criteria->add(PlayerAuctionActionTableMap::COL_PLAYER_ID, (array) $values, Criteria::IN);
        }

        $query = PlayerAuctionActionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PlayerAuctionActionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PlayerAuctionActionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the player_auction_action table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PlayerAuctionActionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PlayerAuctionAction or Criteria object.
     *
     * @param mixed               $criteria Criteria or PlayerAuctionAction object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerAuctionActionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PlayerAuctionAction object
        }


        // Set the correct dbName
        $query = PlayerAuctionActionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PlayerAuctionActionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PlayerAuctionActionTableMap::buildTableMap();
