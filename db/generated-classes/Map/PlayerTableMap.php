<?php

namespace Map;

use \Player;
use \PlayerQuery;
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
 * This class defines the structure of the 'player' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PlayerTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PlayerTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'powergrid';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'player';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Player';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Player';

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
    const COL_ID = 'player.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'player.name';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'player.user_id';

    /**
     * the column name for the game_id field
     */
    const COL_GAME_ID = 'player.game_id';

    /**
     * the column name for the wallet_id field
     */
    const COL_WALLET_ID = 'player.wallet_id';

    /**
     * the column name for the color_name field
     */
    const COL_COLOR_NAME = 'player.color_name';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'UserId', 'GameId', 'WalletId', 'ColorName', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'userId', 'gameId', 'walletId', 'colorName', ),
        self::TYPE_COLNAME       => array(PlayerTableMap::COL_ID, PlayerTableMap::COL_NAME, PlayerTableMap::COL_USER_ID, PlayerTableMap::COL_GAME_ID, PlayerTableMap::COL_WALLET_ID, PlayerTableMap::COL_COLOR_NAME, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'user_id', 'game_id', 'wallet_id', 'color_name', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'UserId' => 2, 'GameId' => 3, 'WalletId' => 4, 'ColorName' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'userId' => 2, 'gameId' => 3, 'walletId' => 4, 'colorName' => 5, ),
        self::TYPE_COLNAME       => array(PlayerTableMap::COL_ID => 0, PlayerTableMap::COL_NAME => 1, PlayerTableMap::COL_USER_ID => 2, PlayerTableMap::COL_GAME_ID => 3, PlayerTableMap::COL_WALLET_ID => 4, PlayerTableMap::COL_COLOR_NAME => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'user_id' => 2, 'game_id' => 3, 'wallet_id' => 4, 'color_name' => 5, ),
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
        $this->setName('player');
        $this->setPhpName('Player');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Player');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 32, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'user', 'id', false, null, null);
        $this->addForeignKey('game_id', 'GameId', 'INTEGER', 'game', 'id', false, null, null);
        $this->addForeignKey('wallet_id', 'WalletId', 'INTEGER', 'wallet', 'id', false, null, null);
        $this->addColumn('color_name', 'ColorName', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('PlayerUser', '\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('CurrentGame', '\\Game', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':game_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('PlayerWallet', '\\Wallet', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':wallet_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('TurnOrder', '\\TurnOrder', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':player_id',
    1 => ':id',
  ),
), null, null, 'TurnOrders', false);
        $this->addRelation('PlayerResource', '\\PlayerResource', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':player_id',
    1 => ':id',
  ),
), null, null, 'PlayerResources', false);
        $this->addRelation('PlayerCity', '\\PlayerCity', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':player_id',
    1 => ':id',
  ),
), null, null, 'PlayerCities', false);
        $this->addRelation('PlayerCard', '\\PlayerCard', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':player_id',
    1 => ':id',
  ),
), null, null, 'PlayerCards', false);
        $this->addRelation('CurrentAuctionPlant', '\\CurrentAuctionPlant', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':highest_bidder_id',
    1 => ':id',
  ),
), null, null, 'CurrentAuctionPlants', false);
        $this->addRelation('PlayerAuctionAction', '\\PlayerAuctionAction', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':player_id',
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
        return $withPrefix ? PlayerTableMap::CLASS_DEFAULT : PlayerTableMap::OM_CLASS;
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
     * @return array           (Player object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PlayerTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PlayerTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PlayerTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PlayerTableMap::OM_CLASS;
            /** @var Player $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PlayerTableMap::addInstanceToPool($obj, $key);
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
            $key = PlayerTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PlayerTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Player $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PlayerTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PlayerTableMap::COL_ID);
            $criteria->addSelectColumn(PlayerTableMap::COL_NAME);
            $criteria->addSelectColumn(PlayerTableMap::COL_USER_ID);
            $criteria->addSelectColumn(PlayerTableMap::COL_GAME_ID);
            $criteria->addSelectColumn(PlayerTableMap::COL_WALLET_ID);
            $criteria->addSelectColumn(PlayerTableMap::COL_COLOR_NAME);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.game_id');
            $criteria->addSelectColumn($alias . '.wallet_id');
            $criteria->addSelectColumn($alias . '.color_name');
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
        return Propel::getServiceContainer()->getDatabaseMap(PlayerTableMap::DATABASE_NAME)->getTable(PlayerTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PlayerTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PlayerTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PlayerTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Player or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Player object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Player) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PlayerTableMap::DATABASE_NAME);
            $criteria->add(PlayerTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PlayerQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PlayerTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PlayerTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the player table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PlayerQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Player or Criteria object.
     *
     * @param mixed               $criteria Criteria or Player object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Player object
        }

        if ($criteria->containsKey(PlayerTableMap::COL_ID) && $criteria->keyContainsValue(PlayerTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PlayerTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PlayerQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PlayerTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PlayerTableMap::buildTableMap();
