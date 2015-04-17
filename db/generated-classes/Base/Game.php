<?php

namespace Base;

use \Bank as ChildBank;
use \BankQuery as ChildBankQuery;
use \Game as ChildGame;
use \GameCard as ChildGameCard;
use \GameCardQuery as ChildGameCardQuery;
use \GameCity as ChildGameCity;
use \GameCityQuery as ChildGameCityQuery;
use \GameQuery as ChildGameQuery;
use \Map as ChildMap;
use \MapQuery as ChildMapQuery;
use \Player as ChildPlayer;
use \PlayerQuery as ChildPlayerQuery;
use \ResourceStore as ChildResourceStore;
use \ResourceStoreQuery as ChildResourceStoreQuery;
use \TurnOrder as ChildTurnOrder;
use \TurnOrderQuery as ChildTurnOrderQuery;
use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \Exception;
use \PDO;
use Map\GameTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'game' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Game implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\GameTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the turn_number field.
     * @var        int
     */
    protected $turn_number;

    /**
     * The value for the step_number field.
     * @var        int
     */
    protected $step_number;

    /**
     * The value for the next_player_id field.
     * @var        int
     */
    protected $next_player_id;

    /**
     * The value for the owner_id field.
     * @var        int
     */
    protected $owner_id;

    /**
     * The value for the bank_id field.
     * @var        int
     */
    protected $bank_id;

    /**
     * The value for the map_id field.
     * @var        int
     */
    protected $map_id;

    /**
     * @var        ChildPlayer
     */
    protected $aNextPlayer;

    /**
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ChildBank
     */
    protected $aBank;

    /**
     * @var        ChildMap
     */
    protected $aMap;

    /**
     * @var        ObjectCollection|ChildPlayer[] Collection to store aggregation of ChildPlayer objects.
     */
    protected $collPlayers;
    protected $collPlayersPartial;

    /**
     * @var        ObjectCollection|ChildResourceStore[] Collection to store aggregation of ChildResourceStore objects.
     */
    protected $collResourceStores;
    protected $collResourceStoresPartial;

    /**
     * @var        ObjectCollection|ChildTurnOrder[] Collection to store aggregation of ChildTurnOrder objects.
     */
    protected $collTurnOrders;
    protected $collTurnOrdersPartial;

    /**
     * @var        ObjectCollection|ChildGameCard[] Collection to store aggregation of ChildGameCard objects.
     */
    protected $collGameCards;
    protected $collGameCardsPartial;

    /**
     * @var        ObjectCollection|ChildGameCity[] Collection to store aggregation of ChildGameCity objects.
     */
    protected $collGameCities;
    protected $collGameCitiesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlayer[]
     */
    protected $playersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildResourceStore[]
     */
    protected $resourceStoresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTurnOrder[]
     */
    protected $turnOrdersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGameCard[]
     */
    protected $gameCardsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGameCity[]
     */
    protected $gameCitiesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Game object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Game</code> instance.  If
     * <code>obj</code> is an instance of <code>Game</code>, delegates to
     * <code>equals(Game)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Game The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [turn_number] column value.
     *
     * @return int
     */
    public function getTurnNumber()
    {
        return $this->turn_number;
    }

    /**
     * Get the [step_number] column value.
     *
     * @return int
     */
    public function getStepNumber()
    {
        return $this->step_number;
    }

    /**
     * Get the [next_player_id] column value.
     *
     * @return int
     */
    public function getNextPlayerId()
    {
        return $this->next_player_id;
    }

    /**
     * Get the [owner_id] column value.
     *
     * @return int
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * Get the [bank_id] column value.
     *
     * @return int
     */
    public function getBankId()
    {
        return $this->bank_id;
    }

    /**
     * Get the [map_id] column value.
     *
     * @return int
     */
    public function getMapId()
    {
        return $this->map_id;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[GameTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [turn_number] column.
     *
     * @param int $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setTurnNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->turn_number !== $v) {
            $this->turn_number = $v;
            $this->modifiedColumns[GameTableMap::COL_TURN_NUMBER] = true;
        }

        return $this;
    } // setTurnNumber()

    /**
     * Set the value of [step_number] column.
     *
     * @param int $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setStepNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->step_number !== $v) {
            $this->step_number = $v;
            $this->modifiedColumns[GameTableMap::COL_STEP_NUMBER] = true;
        }

        return $this;
    } // setStepNumber()

    /**
     * Set the value of [next_player_id] column.
     *
     * @param int $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setNextPlayerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->next_player_id !== $v) {
            $this->next_player_id = $v;
            $this->modifiedColumns[GameTableMap::COL_NEXT_PLAYER_ID] = true;
        }

        if ($this->aNextPlayer !== null && $this->aNextPlayer->getId() !== $v) {
            $this->aNextPlayer = null;
        }

        return $this;
    } // setNextPlayerId()

    /**
     * Set the value of [owner_id] column.
     *
     * @param int $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setOwnerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->owner_id !== $v) {
            $this->owner_id = $v;
            $this->modifiedColumns[GameTableMap::COL_OWNER_ID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setOwnerId()

    /**
     * Set the value of [bank_id] column.
     *
     * @param int $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setBankId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->bank_id !== $v) {
            $this->bank_id = $v;
            $this->modifiedColumns[GameTableMap::COL_BANK_ID] = true;
        }

        if ($this->aBank !== null && $this->aBank->getId() !== $v) {
            $this->aBank = null;
        }

        return $this;
    } // setBankId()

    /**
     * Set the value of [map_id] column.
     *
     * @param int $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setMapId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->map_id !== $v) {
            $this->map_id = $v;
            $this->modifiedColumns[GameTableMap::COL_MAP_ID] = true;
        }

        if ($this->aMap !== null && $this->aMap->getId() !== $v) {
            $this->aMap = null;
        }

        return $this;
    } // setMapId()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : GameTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : GameTableMap::translateFieldName('TurnNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->turn_number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : GameTableMap::translateFieldName('StepNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->step_number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : GameTableMap::translateFieldName('NextPlayerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->next_player_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : GameTableMap::translateFieldName('OwnerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->owner_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : GameTableMap::translateFieldName('BankId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bank_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : GameTableMap::translateFieldName('MapId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = GameTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Game'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aNextPlayer !== null && $this->next_player_id !== $this->aNextPlayer->getId()) {
            $this->aNextPlayer = null;
        }
        if ($this->aUser !== null && $this->owner_id !== $this->aUser->getId()) {
            $this->aUser = null;
        }
        if ($this->aBank !== null && $this->bank_id !== $this->aBank->getId()) {
            $this->aBank = null;
        }
        if ($this->aMap !== null && $this->map_id !== $this->aMap->getId()) {
            $this->aMap = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GameTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildGameQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aNextPlayer = null;
            $this->aUser = null;
            $this->aBank = null;
            $this->aMap = null;
            $this->collPlayers = null;

            $this->collResourceStores = null;

            $this->collTurnOrders = null;

            $this->collGameCards = null;

            $this->collGameCities = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Game::setDeleted()
     * @see Game::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildGameQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                GameTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aNextPlayer !== null) {
                if ($this->aNextPlayer->isModified() || $this->aNextPlayer->isNew()) {
                    $affectedRows += $this->aNextPlayer->save($con);
                }
                $this->setNextPlayer($this->aNextPlayer);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aBank !== null) {
                if ($this->aBank->isModified() || $this->aBank->isNew()) {
                    $affectedRows += $this->aBank->save($con);
                }
                $this->setBank($this->aBank);
            }

            if ($this->aMap !== null) {
                if ($this->aMap->isModified() || $this->aMap->isNew()) {
                    $affectedRows += $this->aMap->save($con);
                }
                $this->setMap($this->aMap);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->playersScheduledForDeletion !== null) {
                if (!$this->playersScheduledForDeletion->isEmpty()) {
                    \PlayerQuery::create()
                        ->filterByPrimaryKeys($this->playersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->playersScheduledForDeletion = null;
                }
            }

            if ($this->collPlayers !== null) {
                foreach ($this->collPlayers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->resourceStoresScheduledForDeletion !== null) {
                if (!$this->resourceStoresScheduledForDeletion->isEmpty()) {
                    \ResourceStoreQuery::create()
                        ->filterByPrimaryKeys($this->resourceStoresScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->resourceStoresScheduledForDeletion = null;
                }
            }

            if ($this->collResourceStores !== null) {
                foreach ($this->collResourceStores as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->turnOrdersScheduledForDeletion !== null) {
                if (!$this->turnOrdersScheduledForDeletion->isEmpty()) {
                    \TurnOrderQuery::create()
                        ->filterByPrimaryKeys($this->turnOrdersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->turnOrdersScheduledForDeletion = null;
                }
            }

            if ($this->collTurnOrders !== null) {
                foreach ($this->collTurnOrders as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->gameCardsScheduledForDeletion !== null) {
                if (!$this->gameCardsScheduledForDeletion->isEmpty()) {
                    \GameCardQuery::create()
                        ->filterByPrimaryKeys($this->gameCardsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->gameCardsScheduledForDeletion = null;
                }
            }

            if ($this->collGameCards !== null) {
                foreach ($this->collGameCards as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->gameCitiesScheduledForDeletion !== null) {
                if (!$this->gameCitiesScheduledForDeletion->isEmpty()) {
                    \GameCityQuery::create()
                        ->filterByPrimaryKeys($this->gameCitiesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->gameCitiesScheduledForDeletion = null;
                }
            }

            if ($this->collGameCities !== null) {
                foreach ($this->collGameCities as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[GameTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GameTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GameTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(GameTableMap::COL_TURN_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'turn_number';
        }
        if ($this->isColumnModified(GameTableMap::COL_STEP_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'step_number';
        }
        if ($this->isColumnModified(GameTableMap::COL_NEXT_PLAYER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'next_player_id';
        }
        if ($this->isColumnModified(GameTableMap::COL_OWNER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'owner_id';
        }
        if ($this->isColumnModified(GameTableMap::COL_BANK_ID)) {
            $modifiedColumns[':p' . $index++]  = 'bank_id';
        }
        if ($this->isColumnModified(GameTableMap::COL_MAP_ID)) {
            $modifiedColumns[':p' . $index++]  = 'map_id';
        }

        $sql = sprintf(
            'INSERT INTO game (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'turn_number':
                        $stmt->bindValue($identifier, $this->turn_number, PDO::PARAM_INT);
                        break;
                    case 'step_number':
                        $stmt->bindValue($identifier, $this->step_number, PDO::PARAM_INT);
                        break;
                    case 'next_player_id':
                        $stmt->bindValue($identifier, $this->next_player_id, PDO::PARAM_INT);
                        break;
                    case 'owner_id':
                        $stmt->bindValue($identifier, $this->owner_id, PDO::PARAM_INT);
                        break;
                    case 'bank_id':
                        $stmt->bindValue($identifier, $this->bank_id, PDO::PARAM_INT);
                        break;
                    case 'map_id':
                        $stmt->bindValue($identifier, $this->map_id, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GameTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getTurnNumber();
                break;
            case 2:
                return $this->getStepNumber();
                break;
            case 3:
                return $this->getNextPlayerId();
                break;
            case 4:
                return $this->getOwnerId();
                break;
            case 5:
                return $this->getBankId();
                break;
            case 6:
                return $this->getMapId();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Game'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Game'][$this->hashCode()] = true;
        $keys = GameTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTurnNumber(),
            $keys[2] => $this->getStepNumber(),
            $keys[3] => $this->getNextPlayerId(),
            $keys[4] => $this->getOwnerId(),
            $keys[5] => $this->getBankId(),
            $keys[6] => $this->getMapId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aNextPlayer) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'player';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'player';
                        break;
                    default:
                        $key = 'Player';
                }

                $result[$key] = $this->aNextPlayer->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aBank) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bank';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'bank';
                        break;
                    default:
                        $key = 'Bank';
                }

                $result[$key] = $this->aBank->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aMap) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'map';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'map';
                        break;
                    default:
                        $key = 'Map';
                }

                $result[$key] = $this->aMap->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPlayers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'players';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'players';
                        break;
                    default:
                        $key = 'Players';
                }

                $result[$key] = $this->collPlayers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collResourceStores) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'resourceStores';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'resource_stores';
                        break;
                    default:
                        $key = 'ResourceStores';
                }

                $result[$key] = $this->collResourceStores->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTurnOrders) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'turnOrders';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'turn_orders';
                        break;
                    default:
                        $key = 'TurnOrders';
                }

                $result[$key] = $this->collTurnOrders->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGameCards) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gameCards';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'game_cards';
                        break;
                    default:
                        $key = 'GameCards';
                }

                $result[$key] = $this->collGameCards->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGameCities) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gameCities';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'game_cities';
                        break;
                    default:
                        $key = 'GameCities';
                }

                $result[$key] = $this->collGameCities->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Game
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GameTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Game
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTurnNumber($value);
                break;
            case 2:
                $this->setStepNumber($value);
                break;
            case 3:
                $this->setNextPlayerId($value);
                break;
            case 4:
                $this->setOwnerId($value);
                break;
            case 5:
                $this->setBankId($value);
                break;
            case 6:
                $this->setMapId($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = GameTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTurnNumber($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setStepNumber($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setNextPlayerId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setOwnerId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setBankId($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setMapId($arr[$keys[6]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Game The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(GameTableMap::DATABASE_NAME);

        if ($this->isColumnModified(GameTableMap::COL_ID)) {
            $criteria->add(GameTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(GameTableMap::COL_TURN_NUMBER)) {
            $criteria->add(GameTableMap::COL_TURN_NUMBER, $this->turn_number);
        }
        if ($this->isColumnModified(GameTableMap::COL_STEP_NUMBER)) {
            $criteria->add(GameTableMap::COL_STEP_NUMBER, $this->step_number);
        }
        if ($this->isColumnModified(GameTableMap::COL_NEXT_PLAYER_ID)) {
            $criteria->add(GameTableMap::COL_NEXT_PLAYER_ID, $this->next_player_id);
        }
        if ($this->isColumnModified(GameTableMap::COL_OWNER_ID)) {
            $criteria->add(GameTableMap::COL_OWNER_ID, $this->owner_id);
        }
        if ($this->isColumnModified(GameTableMap::COL_BANK_ID)) {
            $criteria->add(GameTableMap::COL_BANK_ID, $this->bank_id);
        }
        if ($this->isColumnModified(GameTableMap::COL_MAP_ID)) {
            $criteria->add(GameTableMap::COL_MAP_ID, $this->map_id);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildGameQuery::create();
        $criteria->add(GameTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Game (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTurnNumber($this->getTurnNumber());
        $copyObj->setStepNumber($this->getStepNumber());
        $copyObj->setNextPlayerId($this->getNextPlayerId());
        $copyObj->setOwnerId($this->getOwnerId());
        $copyObj->setBankId($this->getBankId());
        $copyObj->setMapId($this->getMapId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPlayers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlayer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getResourceStores() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addResourceStore($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTurnOrders() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTurnOrder($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGameCards() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGameCard($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGameCities() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGameCity($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Game Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildPlayer object.
     *
     * @param  ChildPlayer $v
     * @return $this|\Game The current object (for fluent API support)
     * @throws PropelException
     */
    public function setNextPlayer(ChildPlayer $v = null)
    {
        if ($v === null) {
            $this->setNextPlayerId(NULL);
        } else {
            $this->setNextPlayerId($v->getId());
        }

        $this->aNextPlayer = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPlayer object, it will not be re-added.
        if ($v !== null) {
            $v->addGame($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPlayer object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPlayer The associated ChildPlayer object.
     * @throws PropelException
     */
    public function getNextPlayer(ConnectionInterface $con = null)
    {
        if ($this->aNextPlayer === null && ($this->next_player_id !== null)) {
            $this->aNextPlayer = ChildPlayerQuery::create()->findPk($this->next_player_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aNextPlayer->addGames($this);
             */
        }

        return $this->aNextPlayer;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Game The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setOwnerId(NULL);
        } else {
            $this->setOwnerId($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addGame($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->owner_id !== null)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->owner_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addGames($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a ChildBank object.
     *
     * @param  ChildBank $v
     * @return $this|\Game The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBank(ChildBank $v = null)
    {
        if ($v === null) {
            $this->setBankId(NULL);
        } else {
            $this->setBankId($v->getId());
        }

        $this->aBank = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBank object, it will not be re-added.
        if ($v !== null) {
            $v->addGame($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildBank object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildBank The associated ChildBank object.
     * @throws PropelException
     */
    public function getBank(ConnectionInterface $con = null)
    {
        if ($this->aBank === null && ($this->bank_id !== null)) {
            $this->aBank = ChildBankQuery::create()->findPk($this->bank_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBank->addGames($this);
             */
        }

        return $this->aBank;
    }

    /**
     * Declares an association between this object and a ChildMap object.
     *
     * @param  ChildMap $v
     * @return $this|\Game The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMap(ChildMap $v = null)
    {
        if ($v === null) {
            $this->setMapId(NULL);
        } else {
            $this->setMapId($v->getId());
        }

        $this->aMap = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMap object, it will not be re-added.
        if ($v !== null) {
            $v->addGame($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildMap object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildMap The associated ChildMap object.
     * @throws PropelException
     */
    public function getMap(ConnectionInterface $con = null)
    {
        if ($this->aMap === null && ($this->map_id !== null)) {
            $this->aMap = ChildMapQuery::create()->findPk($this->map_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMap->addGames($this);
             */
        }

        return $this->aMap;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Player' == $relationName) {
            return $this->initPlayers();
        }
        if ('ResourceStore' == $relationName) {
            return $this->initResourceStores();
        }
        if ('TurnOrder' == $relationName) {
            return $this->initTurnOrders();
        }
        if ('GameCard' == $relationName) {
            return $this->initGameCards();
        }
        if ('GameCity' == $relationName) {
            return $this->initGameCities();
        }
    }

    /**
     * Clears out the collPlayers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPlayers()
     */
    public function clearPlayers()
    {
        $this->collPlayers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPlayers collection loaded partially.
     */
    public function resetPartialPlayers($v = true)
    {
        $this->collPlayersPartial = $v;
    }

    /**
     * Initializes the collPlayers collection.
     *
     * By default this just sets the collPlayers collection to an empty array (like clearcollPlayers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPlayers($overrideExisting = true)
    {
        if (null !== $this->collPlayers && !$overrideExisting) {
            return;
        }
        $this->collPlayers = new ObjectCollection();
        $this->collPlayers->setModel('\Player');
    }

    /**
     * Gets an array of ChildPlayer objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPlayer[] List of ChildPlayer objects
     * @throws PropelException
     */
    public function getPlayers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayersPartial && !$this->isNew();
        if (null === $this->collPlayers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPlayers) {
                // return empty collection
                $this->initPlayers();
            } else {
                $collPlayers = ChildPlayerQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPlayersPartial && count($collPlayers)) {
                        $this->initPlayers(false);

                        foreach ($collPlayers as $obj) {
                            if (false == $this->collPlayers->contains($obj)) {
                                $this->collPlayers->append($obj);
                            }
                        }

                        $this->collPlayersPartial = true;
                    }

                    return $collPlayers;
                }

                if ($partial && $this->collPlayers) {
                    foreach ($this->collPlayers as $obj) {
                        if ($obj->isNew()) {
                            $collPlayers[] = $obj;
                        }
                    }
                }

                $this->collPlayers = $collPlayers;
                $this->collPlayersPartial = false;
            }
        }

        return $this->collPlayers;
    }

    /**
     * Sets a collection of ChildPlayer objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $players A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setPlayers(Collection $players, ConnectionInterface $con = null)
    {
        /** @var ChildPlayer[] $playersToDelete */
        $playersToDelete = $this->getPlayers(new Criteria(), $con)->diff($players);


        $this->playersScheduledForDeletion = $playersToDelete;

        foreach ($playersToDelete as $playerRemoved) {
            $playerRemoved->setGame(null);
        }

        $this->collPlayers = null;
        foreach ($players as $player) {
            $this->addPlayer($player);
        }

        $this->collPlayers = $players;
        $this->collPlayersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Player objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Player objects.
     * @throws PropelException
     */
    public function countPlayers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayersPartial && !$this->isNew();
        if (null === $this->collPlayers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPlayers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPlayers());
            }

            $query = ChildPlayerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collPlayers);
    }

    /**
     * Method called to associate a ChildPlayer object to this object
     * through the ChildPlayer foreign key attribute.
     *
     * @param  ChildPlayer $l ChildPlayer
     * @return $this|\Game The current object (for fluent API support)
     */
    public function addPlayer(ChildPlayer $l)
    {
        if ($this->collPlayers === null) {
            $this->initPlayers();
            $this->collPlayersPartial = true;
        }

        if (!$this->collPlayers->contains($l)) {
            $this->doAddPlayer($l);
        }

        return $this;
    }

    /**
     * @param ChildPlayer $player The ChildPlayer object to add.
     */
    protected function doAddPlayer(ChildPlayer $player)
    {
        $this->collPlayers[]= $player;
        $player->setGame($this);
    }

    /**
     * @param  ChildPlayer $player The ChildPlayer object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removePlayer(ChildPlayer $player)
    {
        if ($this->getPlayers()->contains($player)) {
            $pos = $this->collPlayers->search($player);
            $this->collPlayers->remove($pos);
            if (null === $this->playersScheduledForDeletion) {
                $this->playersScheduledForDeletion = clone $this->collPlayers;
                $this->playersScheduledForDeletion->clear();
            }
            $this->playersScheduledForDeletion[]= clone $player;
            $player->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related Players from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlayer[] List of ChildPlayer objects
     */
    public function getPlayersJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getPlayers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related Players from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlayer[] List of ChildPlayer objects
     */
    public function getPlayersJoinWallet(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerQuery::create(null, $criteria);
        $query->joinWith('Wallet', $joinBehavior);

        return $this->getPlayers($query, $con);
    }

    /**
     * Clears out the collResourceStores collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addResourceStores()
     */
    public function clearResourceStores()
    {
        $this->collResourceStores = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collResourceStores collection loaded partially.
     */
    public function resetPartialResourceStores($v = true)
    {
        $this->collResourceStoresPartial = $v;
    }

    /**
     * Initializes the collResourceStores collection.
     *
     * By default this just sets the collResourceStores collection to an empty array (like clearcollResourceStores());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initResourceStores($overrideExisting = true)
    {
        if (null !== $this->collResourceStores && !$overrideExisting) {
            return;
        }
        $this->collResourceStores = new ObjectCollection();
        $this->collResourceStores->setModel('\ResourceStore');
    }

    /**
     * Gets an array of ChildResourceStore objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildResourceStore[] List of ChildResourceStore objects
     * @throws PropelException
     */
    public function getResourceStores(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collResourceStoresPartial && !$this->isNew();
        if (null === $this->collResourceStores || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collResourceStores) {
                // return empty collection
                $this->initResourceStores();
            } else {
                $collResourceStores = ChildResourceStoreQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collResourceStoresPartial && count($collResourceStores)) {
                        $this->initResourceStores(false);

                        foreach ($collResourceStores as $obj) {
                            if (false == $this->collResourceStores->contains($obj)) {
                                $this->collResourceStores->append($obj);
                            }
                        }

                        $this->collResourceStoresPartial = true;
                    }

                    return $collResourceStores;
                }

                if ($partial && $this->collResourceStores) {
                    foreach ($this->collResourceStores as $obj) {
                        if ($obj->isNew()) {
                            $collResourceStores[] = $obj;
                        }
                    }
                }

                $this->collResourceStores = $collResourceStores;
                $this->collResourceStoresPartial = false;
            }
        }

        return $this->collResourceStores;
    }

    /**
     * Sets a collection of ChildResourceStore objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $resourceStores A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setResourceStores(Collection $resourceStores, ConnectionInterface $con = null)
    {
        /** @var ChildResourceStore[] $resourceStoresToDelete */
        $resourceStoresToDelete = $this->getResourceStores(new Criteria(), $con)->diff($resourceStores);


        $this->resourceStoresScheduledForDeletion = $resourceStoresToDelete;

        foreach ($resourceStoresToDelete as $resourceStoreRemoved) {
            $resourceStoreRemoved->setGame(null);
        }

        $this->collResourceStores = null;
        foreach ($resourceStores as $resourceStore) {
            $this->addResourceStore($resourceStore);
        }

        $this->collResourceStores = $resourceStores;
        $this->collResourceStoresPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ResourceStore objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ResourceStore objects.
     * @throws PropelException
     */
    public function countResourceStores(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collResourceStoresPartial && !$this->isNew();
        if (null === $this->collResourceStores || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collResourceStores) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getResourceStores());
            }

            $query = ChildResourceStoreQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collResourceStores);
    }

    /**
     * Method called to associate a ChildResourceStore object to this object
     * through the ChildResourceStore foreign key attribute.
     *
     * @param  ChildResourceStore $l ChildResourceStore
     * @return $this|\Game The current object (for fluent API support)
     */
    public function addResourceStore(ChildResourceStore $l)
    {
        if ($this->collResourceStores === null) {
            $this->initResourceStores();
            $this->collResourceStoresPartial = true;
        }

        if (!$this->collResourceStores->contains($l)) {
            $this->doAddResourceStore($l);
        }

        return $this;
    }

    /**
     * @param ChildResourceStore $resourceStore The ChildResourceStore object to add.
     */
    protected function doAddResourceStore(ChildResourceStore $resourceStore)
    {
        $this->collResourceStores[]= $resourceStore;
        $resourceStore->setGame($this);
    }

    /**
     * @param  ChildResourceStore $resourceStore The ChildResourceStore object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removeResourceStore(ChildResourceStore $resourceStore)
    {
        if ($this->getResourceStores()->contains($resourceStore)) {
            $pos = $this->collResourceStores->search($resourceStore);
            $this->collResourceStores->remove($pos);
            if (null === $this->resourceStoresScheduledForDeletion) {
                $this->resourceStoresScheduledForDeletion = clone $this->collResourceStores;
                $this->resourceStoresScheduledForDeletion->clear();
            }
            $this->resourceStoresScheduledForDeletion[]= clone $resourceStore;
            $resourceStore->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related ResourceStores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildResourceStore[] List of ChildResourceStore objects
     */
    public function getResourceStoresJoinResourceType(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildResourceStoreQuery::create(null, $criteria);
        $query->joinWith('ResourceType', $joinBehavior);

        return $this->getResourceStores($query, $con);
    }

    /**
     * Clears out the collTurnOrders collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTurnOrders()
     */
    public function clearTurnOrders()
    {
        $this->collTurnOrders = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTurnOrders collection loaded partially.
     */
    public function resetPartialTurnOrders($v = true)
    {
        $this->collTurnOrdersPartial = $v;
    }

    /**
     * Initializes the collTurnOrders collection.
     *
     * By default this just sets the collTurnOrders collection to an empty array (like clearcollTurnOrders());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTurnOrders($overrideExisting = true)
    {
        if (null !== $this->collTurnOrders && !$overrideExisting) {
            return;
        }
        $this->collTurnOrders = new ObjectCollection();
        $this->collTurnOrders->setModel('\TurnOrder');
    }

    /**
     * Gets an array of ChildTurnOrder objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTurnOrder[] List of ChildTurnOrder objects
     * @throws PropelException
     */
    public function getTurnOrders(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTurnOrdersPartial && !$this->isNew();
        if (null === $this->collTurnOrders || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTurnOrders) {
                // return empty collection
                $this->initTurnOrders();
            } else {
                $collTurnOrders = ChildTurnOrderQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTurnOrdersPartial && count($collTurnOrders)) {
                        $this->initTurnOrders(false);

                        foreach ($collTurnOrders as $obj) {
                            if (false == $this->collTurnOrders->contains($obj)) {
                                $this->collTurnOrders->append($obj);
                            }
                        }

                        $this->collTurnOrdersPartial = true;
                    }

                    return $collTurnOrders;
                }

                if ($partial && $this->collTurnOrders) {
                    foreach ($this->collTurnOrders as $obj) {
                        if ($obj->isNew()) {
                            $collTurnOrders[] = $obj;
                        }
                    }
                }

                $this->collTurnOrders = $collTurnOrders;
                $this->collTurnOrdersPartial = false;
            }
        }

        return $this->collTurnOrders;
    }

    /**
     * Sets a collection of ChildTurnOrder objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $turnOrders A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setTurnOrders(Collection $turnOrders, ConnectionInterface $con = null)
    {
        /** @var ChildTurnOrder[] $turnOrdersToDelete */
        $turnOrdersToDelete = $this->getTurnOrders(new Criteria(), $con)->diff($turnOrders);


        $this->turnOrdersScheduledForDeletion = $turnOrdersToDelete;

        foreach ($turnOrdersToDelete as $turnOrderRemoved) {
            $turnOrderRemoved->setGame(null);
        }

        $this->collTurnOrders = null;
        foreach ($turnOrders as $turnOrder) {
            $this->addTurnOrder($turnOrder);
        }

        $this->collTurnOrders = $turnOrders;
        $this->collTurnOrdersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TurnOrder objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TurnOrder objects.
     * @throws PropelException
     */
    public function countTurnOrders(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTurnOrdersPartial && !$this->isNew();
        if (null === $this->collTurnOrders || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTurnOrders) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTurnOrders());
            }

            $query = ChildTurnOrderQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collTurnOrders);
    }

    /**
     * Method called to associate a ChildTurnOrder object to this object
     * through the ChildTurnOrder foreign key attribute.
     *
     * @param  ChildTurnOrder $l ChildTurnOrder
     * @return $this|\Game The current object (for fluent API support)
     */
    public function addTurnOrder(ChildTurnOrder $l)
    {
        if ($this->collTurnOrders === null) {
            $this->initTurnOrders();
            $this->collTurnOrdersPartial = true;
        }

        if (!$this->collTurnOrders->contains($l)) {
            $this->doAddTurnOrder($l);
        }

        return $this;
    }

    /**
     * @param ChildTurnOrder $turnOrder The ChildTurnOrder object to add.
     */
    protected function doAddTurnOrder(ChildTurnOrder $turnOrder)
    {
        $this->collTurnOrders[]= $turnOrder;
        $turnOrder->setGame($this);
    }

    /**
     * @param  ChildTurnOrder $turnOrder The ChildTurnOrder object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removeTurnOrder(ChildTurnOrder $turnOrder)
    {
        if ($this->getTurnOrders()->contains($turnOrder)) {
            $pos = $this->collTurnOrders->search($turnOrder);
            $this->collTurnOrders->remove($pos);
            if (null === $this->turnOrdersScheduledForDeletion) {
                $this->turnOrdersScheduledForDeletion = clone $this->collTurnOrders;
                $this->turnOrdersScheduledForDeletion->clear();
            }
            $this->turnOrdersScheduledForDeletion[]= clone $turnOrder;
            $turnOrder->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related TurnOrders from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTurnOrder[] List of ChildTurnOrder objects
     */
    public function getTurnOrdersJoinPlayer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTurnOrderQuery::create(null, $criteria);
        $query->joinWith('Player', $joinBehavior);

        return $this->getTurnOrders($query, $con);
    }

    /**
     * Clears out the collGameCards collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGameCards()
     */
    public function clearGameCards()
    {
        $this->collGameCards = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGameCards collection loaded partially.
     */
    public function resetPartialGameCards($v = true)
    {
        $this->collGameCardsPartial = $v;
    }

    /**
     * Initializes the collGameCards collection.
     *
     * By default this just sets the collGameCards collection to an empty array (like clearcollGameCards());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGameCards($overrideExisting = true)
    {
        if (null !== $this->collGameCards && !$overrideExisting) {
            return;
        }
        $this->collGameCards = new ObjectCollection();
        $this->collGameCards->setModel('\GameCard');
    }

    /**
     * Gets an array of ChildGameCard objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGameCard[] List of ChildGameCard objects
     * @throws PropelException
     */
    public function getGameCards(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGameCardsPartial && !$this->isNew();
        if (null === $this->collGameCards || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGameCards) {
                // return empty collection
                $this->initGameCards();
            } else {
                $collGameCards = ChildGameCardQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGameCardsPartial && count($collGameCards)) {
                        $this->initGameCards(false);

                        foreach ($collGameCards as $obj) {
                            if (false == $this->collGameCards->contains($obj)) {
                                $this->collGameCards->append($obj);
                            }
                        }

                        $this->collGameCardsPartial = true;
                    }

                    return $collGameCards;
                }

                if ($partial && $this->collGameCards) {
                    foreach ($this->collGameCards as $obj) {
                        if ($obj->isNew()) {
                            $collGameCards[] = $obj;
                        }
                    }
                }

                $this->collGameCards = $collGameCards;
                $this->collGameCardsPartial = false;
            }
        }

        return $this->collGameCards;
    }

    /**
     * Sets a collection of ChildGameCard objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gameCards A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setGameCards(Collection $gameCards, ConnectionInterface $con = null)
    {
        /** @var ChildGameCard[] $gameCardsToDelete */
        $gameCardsToDelete = $this->getGameCards(new Criteria(), $con)->diff($gameCards);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->gameCardsScheduledForDeletion = clone $gameCardsToDelete;

        foreach ($gameCardsToDelete as $gameCardRemoved) {
            $gameCardRemoved->setGame(null);
        }

        $this->collGameCards = null;
        foreach ($gameCards as $gameCard) {
            $this->addGameCard($gameCard);
        }

        $this->collGameCards = $gameCards;
        $this->collGameCardsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GameCard objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GameCard objects.
     * @throws PropelException
     */
    public function countGameCards(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGameCardsPartial && !$this->isNew();
        if (null === $this->collGameCards || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGameCards) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGameCards());
            }

            $query = ChildGameCardQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collGameCards);
    }

    /**
     * Method called to associate a ChildGameCard object to this object
     * through the ChildGameCard foreign key attribute.
     *
     * @param  ChildGameCard $l ChildGameCard
     * @return $this|\Game The current object (for fluent API support)
     */
    public function addGameCard(ChildGameCard $l)
    {
        if ($this->collGameCards === null) {
            $this->initGameCards();
            $this->collGameCardsPartial = true;
        }

        if (!$this->collGameCards->contains($l)) {
            $this->doAddGameCard($l);
        }

        return $this;
    }

    /**
     * @param ChildGameCard $gameCard The ChildGameCard object to add.
     */
    protected function doAddGameCard(ChildGameCard $gameCard)
    {
        $this->collGameCards[]= $gameCard;
        $gameCard->setGame($this);
    }

    /**
     * @param  ChildGameCard $gameCard The ChildGameCard object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removeGameCard(ChildGameCard $gameCard)
    {
        if ($this->getGameCards()->contains($gameCard)) {
            $pos = $this->collGameCards->search($gameCard);
            $this->collGameCards->remove($pos);
            if (null === $this->gameCardsScheduledForDeletion) {
                $this->gameCardsScheduledForDeletion = clone $this->collGameCards;
                $this->gameCardsScheduledForDeletion->clear();
            }
            $this->gameCardsScheduledForDeletion[]= clone $gameCard;
            $gameCard->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related GameCards from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGameCard[] List of ChildGameCard objects
     */
    public function getGameCardsJoinCard(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameCardQuery::create(null, $criteria);
        $query->joinWith('Card', $joinBehavior);

        return $this->getGameCards($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related GameCards from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGameCard[] List of ChildGameCard objects
     */
    public function getGameCardsJoinCardStatus(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameCardQuery::create(null, $criteria);
        $query->joinWith('CardStatus', $joinBehavior);

        return $this->getGameCards($query, $con);
    }

    /**
     * Clears out the collGameCities collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGameCities()
     */
    public function clearGameCities()
    {
        $this->collGameCities = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGameCities collection loaded partially.
     */
    public function resetPartialGameCities($v = true)
    {
        $this->collGameCitiesPartial = $v;
    }

    /**
     * Initializes the collGameCities collection.
     *
     * By default this just sets the collGameCities collection to an empty array (like clearcollGameCities());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGameCities($overrideExisting = true)
    {
        if (null !== $this->collGameCities && !$overrideExisting) {
            return;
        }
        $this->collGameCities = new ObjectCollection();
        $this->collGameCities->setModel('\GameCity');
    }

    /**
     * Gets an array of ChildGameCity objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGameCity[] List of ChildGameCity objects
     * @throws PropelException
     */
    public function getGameCities(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGameCitiesPartial && !$this->isNew();
        if (null === $this->collGameCities || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGameCities) {
                // return empty collection
                $this->initGameCities();
            } else {
                $collGameCities = ChildGameCityQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGameCitiesPartial && count($collGameCities)) {
                        $this->initGameCities(false);

                        foreach ($collGameCities as $obj) {
                            if (false == $this->collGameCities->contains($obj)) {
                                $this->collGameCities->append($obj);
                            }
                        }

                        $this->collGameCitiesPartial = true;
                    }

                    return $collGameCities;
                }

                if ($partial && $this->collGameCities) {
                    foreach ($this->collGameCities as $obj) {
                        if ($obj->isNew()) {
                            $collGameCities[] = $obj;
                        }
                    }
                }

                $this->collGameCities = $collGameCities;
                $this->collGameCitiesPartial = false;
            }
        }

        return $this->collGameCities;
    }

    /**
     * Sets a collection of ChildGameCity objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gameCities A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setGameCities(Collection $gameCities, ConnectionInterface $con = null)
    {
        /** @var ChildGameCity[] $gameCitiesToDelete */
        $gameCitiesToDelete = $this->getGameCities(new Criteria(), $con)->diff($gameCities);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->gameCitiesScheduledForDeletion = clone $gameCitiesToDelete;

        foreach ($gameCitiesToDelete as $gameCityRemoved) {
            $gameCityRemoved->setGame(null);
        }

        $this->collGameCities = null;
        foreach ($gameCities as $gameCity) {
            $this->addGameCity($gameCity);
        }

        $this->collGameCities = $gameCities;
        $this->collGameCitiesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GameCity objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GameCity objects.
     * @throws PropelException
     */
    public function countGameCities(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGameCitiesPartial && !$this->isNew();
        if (null === $this->collGameCities || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGameCities) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGameCities());
            }

            $query = ChildGameCityQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collGameCities);
    }

    /**
     * Method called to associate a ChildGameCity object to this object
     * through the ChildGameCity foreign key attribute.
     *
     * @param  ChildGameCity $l ChildGameCity
     * @return $this|\Game The current object (for fluent API support)
     */
    public function addGameCity(ChildGameCity $l)
    {
        if ($this->collGameCities === null) {
            $this->initGameCities();
            $this->collGameCitiesPartial = true;
        }

        if (!$this->collGameCities->contains($l)) {
            $this->doAddGameCity($l);
        }

        return $this;
    }

    /**
     * @param ChildGameCity $gameCity The ChildGameCity object to add.
     */
    protected function doAddGameCity(ChildGameCity $gameCity)
    {
        $this->collGameCities[]= $gameCity;
        $gameCity->setGame($this);
    }

    /**
     * @param  ChildGameCity $gameCity The ChildGameCity object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removeGameCity(ChildGameCity $gameCity)
    {
        if ($this->getGameCities()->contains($gameCity)) {
            $pos = $this->collGameCities->search($gameCity);
            $this->collGameCities->remove($pos);
            if (null === $this->gameCitiesScheduledForDeletion) {
                $this->gameCitiesScheduledForDeletion = clone $this->collGameCities;
                $this->gameCitiesScheduledForDeletion->clear();
            }
            $this->gameCitiesScheduledForDeletion[]= clone $gameCity;
            $gameCity->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related GameCities from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGameCity[] List of ChildGameCity objects
     */
    public function getGameCitiesJoinCity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameCityQuery::create(null, $criteria);
        $query->joinWith('City', $joinBehavior);

        return $this->getGameCities($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aNextPlayer) {
            $this->aNextPlayer->removeGame($this);
        }
        if (null !== $this->aUser) {
            $this->aUser->removeGame($this);
        }
        if (null !== $this->aBank) {
            $this->aBank->removeGame($this);
        }
        if (null !== $this->aMap) {
            $this->aMap->removeGame($this);
        }
        $this->id = null;
        $this->turn_number = null;
        $this->step_number = null;
        $this->next_player_id = null;
        $this->owner_id = null;
        $this->bank_id = null;
        $this->map_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collPlayers) {
                foreach ($this->collPlayers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collResourceStores) {
                foreach ($this->collResourceStores as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTurnOrders) {
                foreach ($this->collTurnOrders as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGameCards) {
                foreach ($this->collGameCards as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGameCities) {
                foreach ($this->collGameCities as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPlayers = null;
        $this->collResourceStores = null;
        $this->collTurnOrders = null;
        $this->collGameCards = null;
        $this->collGameCities = null;
        $this->aNextPlayer = null;
        $this->aUser = null;
        $this->aBank = null;
        $this->aMap = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GameTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
