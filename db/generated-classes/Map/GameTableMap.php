<?php

namespace Map;

use \Game;
use \GameQuery;
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
 * This class defines the structure of the 'game' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class GameTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.GameTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'powergrid';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'game';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Game';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Game';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the id field
     */
    const COL_ID = 'game.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'game.name';

    /**
     * the column name for the has_started field
     */
    const COL_HAS_STARTED = 'game.has_started';

    /**
     * the column name for the player_turn_order field
     */
    const COL_PLAYER_TURN_ORDER = 'game.player_turn_order';

    /**
     * the column name for the phase_number field
     */
    const COL_PHASE_NUMBER = 'game.phase_number';

    /**
     * the column name for the turn_number field
     */
    const COL_TURN_NUMBER = 'game.turn_number';

    /**
     * the column name for the step_number field
     */
    const COL_STEP_NUMBER = 'game.step_number';

    /**
     * the column name for the next_player_id field
     */
    const COL_NEXT_PLAYER_ID = 'game.next_player_id';

    /**
     * the column name for the owner_id field
     */
    const COL_OWNER_ID = 'game.owner_id';

    /**
     * the column name for the bank_id field
     */
    const COL_BANK_ID = 'game.bank_id';

    /**
     * the column name for the map_id field
     */
    const COL_MAP_ID = 'game.map_id';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'HasStarted', 'PlayerTurnOrder', 'PhaseNumber', 'TurnNumber', 'StepNumber', 'NextPlayerId', 'OwnerId', 'BankId', 'MapId', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'hasStarted', 'playerTurnOrder', 'phaseNumber', 'turnNumber', 'stepNumber', 'nextPlayerId', 'ownerId', 'bankId', 'mapId', ),
        self::TYPE_COLNAME       => array(GameTableMap::COL_ID, GameTableMap::COL_NAME, GameTableMap::COL_HAS_STARTED, GameTableMap::COL_PLAYER_TURN_ORDER, GameTableMap::COL_PHASE_NUMBER, GameTableMap::COL_TURN_NUMBER, GameTableMap::COL_STEP_NUMBER, GameTableMap::COL_NEXT_PLAYER_ID, GameTableMap::COL_OWNER_ID, GameTableMap::COL_BANK_ID, GameTableMap::COL_MAP_ID, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'has_started', 'player_turn_order', 'phase_number', 'turn_number', 'step_number', 'next_player_id', 'owner_id', 'bank_id', 'map_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'HasStarted' => 2, 'PlayerTurnOrder' => 3, 'PhaseNumber' => 4, 'TurnNumber' => 5, 'StepNumber' => 6, 'NextPlayerId' => 7, 'OwnerId' => 8, 'BankId' => 9, 'MapId' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'hasStarted' => 2, 'playerTurnOrder' => 3, 'phaseNumber' => 4, 'turnNumber' => 5, 'stepNumber' => 6, 'nextPlayerId' => 7, 'ownerId' => 8, 'bankId' => 9, 'mapId' => 10, ),
        self::TYPE_COLNAME       => array(GameTableMap::COL_ID => 0, GameTableMap::COL_NAME => 1, GameTableMap::COL_HAS_STARTED => 2, GameTableMap::COL_PLAYER_TURN_ORDER => 3, GameTableMap::COL_PHASE_NUMBER => 4, GameTableMap::COL_TURN_NUMBER => 5, GameTableMap::COL_STEP_NUMBER => 6, GameTableMap::COL_NEXT_PLAYER_ID => 7, GameTableMap::COL_OWNER_ID => 8, GameTableMap::COL_BANK_ID => 9, GameTableMap::COL_MAP_ID => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'has_started' => 2, 'player_turn_order' => 3, 'phase_number' => 4, 'turn_number' => 5, 'step_number' => 6, 'next_player_id' => 7, 'owner_id' => 8, 'bank_id' => 9, 'map_id' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('game');
        $this->setPhpName('Game');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Game');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('has_started', 'HasStarted', 'BOOLEAN', true, 1, false);
        $this->addColumn('player_turn_order', 'PlayerTurnOrder', 'ARRAY', false, null, null);
        $this->addColumn('phase_number', 'PhaseNumber', 'INTEGER', false, null, 1);
        $this->addColumn('turn_number', 'TurnNumber', 'INTEGER', false, null, 1);
        $this->addColumn('step_number', 'StepNumber', 'INTEGER', false, null, 1);
        $this->addForeignKey('next_player_id', 'NextPlayerId', 'INTEGER', 'player', 'id', false, null, null);
        $this->addForeignKey('owner_id', 'OwnerId', 'INTEGER', 'user', 'id', false, null, null);
        $this->addForeignKey('bank_id', 'BankId', 'INTEGER', 'bank', 'id', false, null, null);
        $this->addForeignKey('map_id', 'MapId', 'INTEGER', 'map', 'id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('NextPlayer', '\\Player', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':next_player_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('OwnerUser', '\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':owner_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('GameBank', '\\Bank', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':bank_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('GameMap', '\\Map', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':map_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Player', '\\Player', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':game_id',
    1 => ':id',
  ),
), null, null, 'Players', false);
        $this->addRelation('ResourceStore', '\\ResourceStore', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':game_id',
    1 => ':id',
  ),
), null, null, 'ResourceStores', false);
        $this->addRelation('TurnOrder', '\\TurnOrder', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':game_id',
    1 => ':id',
  ),
), null, null, 'TurnOrders', false);
        $this->addRelation('GameCard', '\\GameCard', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':game_id',
    1 => ':id',
  ),
), null, null, 'GameCards', false);
        $this->addRelation('GameCity', '\\GameCity', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':game_id',
    1 => ':id',
  ),
), null, null, 'GameCities', false);
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
        return $withPrefix ? GameTableMap::CLASS_DEFAULT : GameTableMap::OM_CLASS;
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
     * @return array           (Game object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GameTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GameTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GameTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GameTableMap::OM_CLASS;
            /** @var Game $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GameTableMap::addInstanceToPool($obj, $key);
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
            $key = GameTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GameTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Game $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GameTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(GameTableMap::COL_ID);
            $criteria->addSelectColumn(GameTableMap::COL_NAME);
            $criteria->addSelectColumn(GameTableMap::COL_HAS_STARTED);
            $criteria->addSelectColumn(GameTableMap::COL_PLAYER_TURN_ORDER);
            $criteria->addSelectColumn(GameTableMap::COL_PHASE_NUMBER);
            $criteria->addSelectColumn(GameTableMap::COL_TURN_NUMBER);
            $criteria->addSelectColumn(GameTableMap::COL_STEP_NUMBER);
            $criteria->addSelectColumn(GameTableMap::COL_NEXT_PLAYER_ID);
            $criteria->addSelectColumn(GameTableMap::COL_OWNER_ID);
            $criteria->addSelectColumn(GameTableMap::COL_BANK_ID);
            $criteria->addSelectColumn(GameTableMap::COL_MAP_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.has_started');
            $criteria->addSelectColumn($alias . '.player_turn_order');
            $criteria->addSelectColumn($alias . '.phase_number');
            $criteria->addSelectColumn($alias . '.turn_number');
            $criteria->addSelectColumn($alias . '.step_number');
            $criteria->addSelectColumn($alias . '.next_player_id');
            $criteria->addSelectColumn($alias . '.owner_id');
            $criteria->addSelectColumn($alias . '.bank_id');
            $criteria->addSelectColumn($alias . '.map_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(GameTableMap::DATABASE_NAME)->getTable(GameTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(GameTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(GameTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new GameTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Game or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Game object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Game) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GameTableMap::DATABASE_NAME);
            $criteria->add(GameTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = GameQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            GameTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                GameTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the game table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GameQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Game or Criteria object.
     *
     * @param mixed               $criteria Criteria or Game object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Game object
        }

        if ($criteria->containsKey(GameTableMap::COL_ID) && $criteria->keyContainsValue(GameTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GameTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = GameQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // GameTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
GameTableMap::buildTableMap();
