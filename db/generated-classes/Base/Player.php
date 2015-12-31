<?php

namespace Base;

use \CurrentAuctionPlant as ChildCurrentAuctionPlant;
use \CurrentAuctionPlantQuery as ChildCurrentAuctionPlantQuery;
use \Game as ChildGame;
use \GameQuery as ChildGameQuery;
use \Player as ChildPlayer;
use \PlayerAuctionAction as ChildPlayerAuctionAction;
use \PlayerAuctionActionQuery as ChildPlayerAuctionActionQuery;
use \PlayerCard as ChildPlayerCard;
use \PlayerCardQuery as ChildPlayerCardQuery;
use \PlayerCity as ChildPlayerCity;
use \PlayerCityQuery as ChildPlayerCityQuery;
use \PlayerQuery as ChildPlayerQuery;
use \PlayerResource as ChildPlayerResource;
use \PlayerResourceQuery as ChildPlayerResourceQuery;
use \TurnOrder as ChildTurnOrder;
use \TurnOrderQuery as ChildTurnOrderQuery;
use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \Wallet as ChildWallet;
use \WalletQuery as ChildWalletQuery;
use \Exception;
use \PDO;
use Map\PlayerTableMap;
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
 * Base class that represents a row from the 'player' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Player implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PlayerTableMap';


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
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the game_id field.
     * @var        int
     */
    protected $game_id;

    /**
     * The value for the wallet_id field.
     * @var        int
     */
    protected $wallet_id;

    /**
     * The value for the color_name field.
     * @var        string
     */
    protected $color_name;

    /**
     * @var        ChildUser
     */
    protected $aPlayerUser;

    /**
     * @var        ChildGame
     */
    protected $aCurrentGame;

    /**
     * @var        ChildWallet
     */
    protected $aPlayerWallet;

    /**
     * @var        ObjectCollection|ChildTurnOrder[] Collection to store aggregation of ChildTurnOrder objects.
     */
    protected $collTurnOrders;
    protected $collTurnOrdersPartial;

    /**
     * @var        ObjectCollection|ChildPlayerResource[] Collection to store aggregation of ChildPlayerResource objects.
     */
    protected $collPlayerResources;
    protected $collPlayerResourcesPartial;

    /**
     * @var        ObjectCollection|ChildPlayerCity[] Collection to store aggregation of ChildPlayerCity objects.
     */
    protected $collPlayerCities;
    protected $collPlayerCitiesPartial;

    /**
     * @var        ObjectCollection|ChildPlayerCard[] Collection to store aggregation of ChildPlayerCard objects.
     */
    protected $collPlayerCards;
    protected $collPlayerCardsPartial;

    /**
     * @var        ObjectCollection|ChildCurrentAuctionPlant[] Collection to store aggregation of ChildCurrentAuctionPlant objects.
     */
    protected $collCurrentAuctionPlants;
    protected $collCurrentAuctionPlantsPartial;

    /**
     * @var        ChildPlayerAuctionAction one-to-one related ChildPlayerAuctionAction object
     */
    protected $singlePlayerAuctionAction;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTurnOrder[]
     */
    protected $turnOrdersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlayerResource[]
     */
    protected $playerResourcesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlayerCity[]
     */
    protected $playerCitiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlayerCard[]
     */
    protected $playerCardsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCurrentAuctionPlant[]
     */
    protected $currentAuctionPlantsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Player object.
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
     * Compares this with another <code>Player</code> instance.  If
     * <code>obj</code> is an instance of <code>Player</code>, delegates to
     * <code>equals(Player)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Player The current object, for fluid interface
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the [game_id] column value.
     *
     * @return int
     */
    public function getGameId()
    {
        return $this->game_id;
    }

    /**
     * Get the [wallet_id] column value.
     *
     * @return int
     */
    public function getWalletId()
    {
        return $this->wallet_id;
    }

    /**
     * Get the [color_name] column value.
     *
     * @return string
     */
    public function getColorName()
    {
        return $this->color_name;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Player The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PlayerTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Player The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[PlayerTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\Player The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[PlayerTableMap::COL_USER_ID] = true;
        }

        if ($this->aPlayerUser !== null && $this->aPlayerUser->getId() !== $v) {
            $this->aPlayerUser = null;
        }

        return $this;
    } // setUserId()

    /**
     * Set the value of [game_id] column.
     *
     * @param int $v new value
     * @return $this|\Player The current object (for fluent API support)
     */
    public function setGameId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->game_id !== $v) {
            $this->game_id = $v;
            $this->modifiedColumns[PlayerTableMap::COL_GAME_ID] = true;
        }

        if ($this->aCurrentGame !== null && $this->aCurrentGame->getId() !== $v) {
            $this->aCurrentGame = null;
        }

        return $this;
    } // setGameId()

    /**
     * Set the value of [wallet_id] column.
     *
     * @param int $v new value
     * @return $this|\Player The current object (for fluent API support)
     */
    public function setWalletId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->wallet_id !== $v) {
            $this->wallet_id = $v;
            $this->modifiedColumns[PlayerTableMap::COL_WALLET_ID] = true;
        }

        if ($this->aPlayerWallet !== null && $this->aPlayerWallet->getId() !== $v) {
            $this->aPlayerWallet = null;
        }

        return $this;
    } // setWalletId()

    /**
     * Set the value of [color_name] column.
     *
     * @param string $v new value
     * @return $this|\Player The current object (for fluent API support)
     */
    public function setColorName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->color_name !== $v) {
            $this->color_name = $v;
            $this->modifiedColumns[PlayerTableMap::COL_COLOR_NAME] = true;
        }

        return $this;
    } // setColorName()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PlayerTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PlayerTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PlayerTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PlayerTableMap::translateFieldName('GameId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->game_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PlayerTableMap::translateFieldName('WalletId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->wallet_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PlayerTableMap::translateFieldName('ColorName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->color_name = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = PlayerTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Player'), 0, $e);
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
        if ($this->aPlayerUser !== null && $this->user_id !== $this->aPlayerUser->getId()) {
            $this->aPlayerUser = null;
        }
        if ($this->aCurrentGame !== null && $this->game_id !== $this->aCurrentGame->getId()) {
            $this->aCurrentGame = null;
        }
        if ($this->aPlayerWallet !== null && $this->wallet_id !== $this->aPlayerWallet->getId()) {
            $this->aPlayerWallet = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(PlayerTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPlayerQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPlayerUser = null;
            $this->aCurrentGame = null;
            $this->aPlayerWallet = null;
            $this->collTurnOrders = null;

            $this->collPlayerResources = null;

            $this->collPlayerCities = null;

            $this->collPlayerCards = null;

            $this->collCurrentAuctionPlants = null;

            $this->singlePlayerAuctionAction = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Player::setDeleted()
     * @see Player::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPlayerQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PlayerTableMap::DATABASE_NAME);
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
                PlayerTableMap::addInstanceToPool($this);
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

            if ($this->aPlayerUser !== null) {
                if ($this->aPlayerUser->isModified() || $this->aPlayerUser->isNew()) {
                    $affectedRows += $this->aPlayerUser->save($con);
                }
                $this->setPlayerUser($this->aPlayerUser);
            }

            if ($this->aCurrentGame !== null) {
                if ($this->aCurrentGame->isModified() || $this->aCurrentGame->isNew()) {
                    $affectedRows += $this->aCurrentGame->save($con);
                }
                $this->setCurrentGame($this->aCurrentGame);
            }

            if ($this->aPlayerWallet !== null) {
                if ($this->aPlayerWallet->isModified() || $this->aPlayerWallet->isNew()) {
                    $affectedRows += $this->aPlayerWallet->save($con);
                }
                $this->setPlayerWallet($this->aPlayerWallet);
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

            if ($this->turnOrdersScheduledForDeletion !== null) {
                if (!$this->turnOrdersScheduledForDeletion->isEmpty()) {
                    foreach ($this->turnOrdersScheduledForDeletion as $turnOrder) {
                        // need to save related object because we set the relation to null
                        $turnOrder->save($con);
                    }
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

            if ($this->playerResourcesScheduledForDeletion !== null) {
                if (!$this->playerResourcesScheduledForDeletion->isEmpty()) {
                    \PlayerResourceQuery::create()
                        ->filterByPrimaryKeys($this->playerResourcesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->playerResourcesScheduledForDeletion = null;
                }
            }

            if ($this->collPlayerResources !== null) {
                foreach ($this->collPlayerResources as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->playerCitiesScheduledForDeletion !== null) {
                if (!$this->playerCitiesScheduledForDeletion->isEmpty()) {
                    \PlayerCityQuery::create()
                        ->filterByPrimaryKeys($this->playerCitiesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->playerCitiesScheduledForDeletion = null;
                }
            }

            if ($this->collPlayerCities !== null) {
                foreach ($this->collPlayerCities as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->playerCardsScheduledForDeletion !== null) {
                if (!$this->playerCardsScheduledForDeletion->isEmpty()) {
                    \PlayerCardQuery::create()
                        ->filterByPrimaryKeys($this->playerCardsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->playerCardsScheduledForDeletion = null;
                }
            }

            if ($this->collPlayerCards !== null) {
                foreach ($this->collPlayerCards as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->currentAuctionPlantsScheduledForDeletion !== null) {
                if (!$this->currentAuctionPlantsScheduledForDeletion->isEmpty()) {
                    foreach ($this->currentAuctionPlantsScheduledForDeletion as $currentAuctionPlant) {
                        // need to save related object because we set the relation to null
                        $currentAuctionPlant->save($con);
                    }
                    $this->currentAuctionPlantsScheduledForDeletion = null;
                }
            }

            if ($this->collCurrentAuctionPlants !== null) {
                foreach ($this->collCurrentAuctionPlants as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->singlePlayerAuctionAction !== null) {
                if (!$this->singlePlayerAuctionAction->isDeleted() && ($this->singlePlayerAuctionAction->isNew() || $this->singlePlayerAuctionAction->isModified())) {
                    $affectedRows += $this->singlePlayerAuctionAction->save($con);
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

        $this->modifiedColumns[PlayerTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PlayerTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PlayerTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PlayerTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(PlayerTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(PlayerTableMap::COL_GAME_ID)) {
            $modifiedColumns[':p' . $index++]  = 'game_id';
        }
        if ($this->isColumnModified(PlayerTableMap::COL_WALLET_ID)) {
            $modifiedColumns[':p' . $index++]  = 'wallet_id';
        }
        if ($this->isColumnModified(PlayerTableMap::COL_COLOR_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'color_name';
        }

        $sql = sprintf(
            'INSERT INTO player (%s) VALUES (%s)',
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
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'user_id':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'game_id':
                        $stmt->bindValue($identifier, $this->game_id, PDO::PARAM_INT);
                        break;
                    case 'wallet_id':
                        $stmt->bindValue($identifier, $this->wallet_id, PDO::PARAM_INT);
                        break;
                    case 'color_name':
                        $stmt->bindValue($identifier, $this->color_name, PDO::PARAM_STR);
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
        $pos = PlayerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getUserId();
                break;
            case 3:
                return $this->getGameId();
                break;
            case 4:
                return $this->getWalletId();
                break;
            case 5:
                return $this->getColorName();
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

        if (isset($alreadyDumpedObjects['Player'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Player'][$this->hashCode()] = true;
        $keys = PlayerTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getUserId(),
            $keys[3] => $this->getGameId(),
            $keys[4] => $this->getWalletId(),
            $keys[5] => $this->getColorName(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPlayerUser) {

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

                $result[$key] = $this->aPlayerUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCurrentGame) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'game';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'game';
                        break;
                    default:
                        $key = 'Game';
                }

                $result[$key] = $this->aCurrentGame->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPlayerWallet) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'wallet';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'wallet';
                        break;
                    default:
                        $key = 'Wallet';
                }

                $result[$key] = $this->aPlayerWallet->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collPlayerResources) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'playerResources';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'player_resources';
                        break;
                    default:
                        $key = 'PlayerResources';
                }

                $result[$key] = $this->collPlayerResources->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPlayerCities) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'playerCities';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'player_cities';
                        break;
                    default:
                        $key = 'PlayerCities';
                }

                $result[$key] = $this->collPlayerCities->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPlayerCards) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'playerCards';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'player_cards';
                        break;
                    default:
                        $key = 'PlayerCards';
                }

                $result[$key] = $this->collPlayerCards->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCurrentAuctionPlants) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'currentAuctionPlants';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'current_auction_plants';
                        break;
                    default:
                        $key = 'CurrentAuctionPlants';
                }

                $result[$key] = $this->collCurrentAuctionPlants->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->singlePlayerAuctionAction) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'playerAuctionAction';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'player_auction_action';
                        break;
                    default:
                        $key = 'PlayerAuctionAction';
                }

                $result[$key] = $this->singlePlayerAuctionAction->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
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
     * @return $this|\Player
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PlayerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Player
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setUserId($value);
                break;
            case 3:
                $this->setGameId($value);
                break;
            case 4:
                $this->setWalletId($value);
                break;
            case 5:
                $this->setColorName($value);
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
        $keys = PlayerTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUserId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setGameId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setWalletId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setColorName($arr[$keys[5]]);
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
     * @return $this|\Player The current object, for fluid interface
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
        $criteria = new Criteria(PlayerTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PlayerTableMap::COL_ID)) {
            $criteria->add(PlayerTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PlayerTableMap::COL_NAME)) {
            $criteria->add(PlayerTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(PlayerTableMap::COL_USER_ID)) {
            $criteria->add(PlayerTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(PlayerTableMap::COL_GAME_ID)) {
            $criteria->add(PlayerTableMap::COL_GAME_ID, $this->game_id);
        }
        if ($this->isColumnModified(PlayerTableMap::COL_WALLET_ID)) {
            $criteria->add(PlayerTableMap::COL_WALLET_ID, $this->wallet_id);
        }
        if ($this->isColumnModified(PlayerTableMap::COL_COLOR_NAME)) {
            $criteria->add(PlayerTableMap::COL_COLOR_NAME, $this->color_name);
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
        $criteria = ChildPlayerQuery::create();
        $criteria->add(PlayerTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Player (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setUserId($this->getUserId());
        $copyObj->setGameId($this->getGameId());
        $copyObj->setWalletId($this->getWalletId());
        $copyObj->setColorName($this->getColorName());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTurnOrders() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTurnOrder($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPlayerResources() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlayerResource($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPlayerCities() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlayerCity($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPlayerCards() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlayerCard($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCurrentAuctionPlants() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCurrentAuctionPlant($relObj->copy($deepCopy));
                }
            }

            $relObj = $this->getPlayerAuctionAction();
            if ($relObj) {
                $copyObj->setPlayerAuctionAction($relObj->copy($deepCopy));
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
     * @return \Player Clone of current object.
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
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Player The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPlayerUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setUserId(NULL);
        } else {
            $this->setUserId($v->getId());
        }

        $this->aPlayerUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addPlayer($this);
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
    public function getPlayerUser(ConnectionInterface $con = null)
    {
        if ($this->aPlayerUser === null && ($this->user_id !== null)) {
            $this->aPlayerUser = ChildUserQuery::create()->findPk($this->user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPlayerUser->addPlayers($this);
             */
        }

        return $this->aPlayerUser;
    }

    /**
     * Declares an association between this object and a ChildGame object.
     *
     * @param  ChildGame $v
     * @return $this|\Player The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCurrentGame(ChildGame $v = null)
    {
        if ($v === null) {
            $this->setGameId(NULL);
        } else {
            $this->setGameId($v->getId());
        }

        $this->aCurrentGame = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildGame object, it will not be re-added.
        if ($v !== null) {
            $v->addPlayer($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildGame object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildGame The associated ChildGame object.
     * @throws PropelException
     */
    public function getCurrentGame(ConnectionInterface $con = null)
    {
        if ($this->aCurrentGame === null && ($this->game_id !== null)) {
            $this->aCurrentGame = ChildGameQuery::create()->findPk($this->game_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCurrentGame->addPlayers($this);
             */
        }

        return $this->aCurrentGame;
    }

    /**
     * Declares an association between this object and a ChildWallet object.
     *
     * @param  ChildWallet $v
     * @return $this|\Player The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPlayerWallet(ChildWallet $v = null)
    {
        if ($v === null) {
            $this->setWalletId(NULL);
        } else {
            $this->setWalletId($v->getId());
        }

        $this->aPlayerWallet = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildWallet object, it will not be re-added.
        if ($v !== null) {
            $v->addPlayer($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildWallet object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildWallet The associated ChildWallet object.
     * @throws PropelException
     */
    public function getPlayerWallet(ConnectionInterface $con = null)
    {
        if ($this->aPlayerWallet === null && ($this->wallet_id !== null)) {
            $this->aPlayerWallet = ChildWalletQuery::create()->findPk($this->wallet_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPlayerWallet->addPlayers($this);
             */
        }

        return $this->aPlayerWallet;
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
        if ('TurnOrder' == $relationName) {
            return $this->initTurnOrders();
        }
        if ('PlayerResource' == $relationName) {
            return $this->initPlayerResources();
        }
        if ('PlayerCity' == $relationName) {
            return $this->initPlayerCities();
        }
        if ('PlayerCard' == $relationName) {
            return $this->initPlayerCards();
        }
        if ('CurrentAuctionPlant' == $relationName) {
            return $this->initCurrentAuctionPlants();
        }
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
     * If this ChildPlayer is new, it will return
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
                    ->filterByPlayer($this)
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
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function setTurnOrders(Collection $turnOrders, ConnectionInterface $con = null)
    {
        /** @var ChildTurnOrder[] $turnOrdersToDelete */
        $turnOrdersToDelete = $this->getTurnOrders(new Criteria(), $con)->diff($turnOrders);


        $this->turnOrdersScheduledForDeletion = $turnOrdersToDelete;

        foreach ($turnOrdersToDelete as $turnOrderRemoved) {
            $turnOrderRemoved->setPlayer(null);
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
                ->filterByPlayer($this)
                ->count($con);
        }

        return count($this->collTurnOrders);
    }

    /**
     * Method called to associate a ChildTurnOrder object to this object
     * through the ChildTurnOrder foreign key attribute.
     *
     * @param  ChildTurnOrder $l ChildTurnOrder
     * @return $this|\Player The current object (for fluent API support)
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
        $turnOrder->setPlayer($this);
    }

    /**
     * @param  ChildTurnOrder $turnOrder The ChildTurnOrder object to remove.
     * @return $this|ChildPlayer The current object (for fluent API support)
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
            $this->turnOrdersScheduledForDeletion[]= $turnOrder;
            $turnOrder->setPlayer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related TurnOrders from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTurnOrder[] List of ChildTurnOrder objects
     */
    public function getTurnOrdersJoinGame(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTurnOrderQuery::create(null, $criteria);
        $query->joinWith('Game', $joinBehavior);

        return $this->getTurnOrders($query, $con);
    }

    /**
     * Clears out the collPlayerResources collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPlayerResources()
     */
    public function clearPlayerResources()
    {
        $this->collPlayerResources = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPlayerResources collection loaded partially.
     */
    public function resetPartialPlayerResources($v = true)
    {
        $this->collPlayerResourcesPartial = $v;
    }

    /**
     * Initializes the collPlayerResources collection.
     *
     * By default this just sets the collPlayerResources collection to an empty array (like clearcollPlayerResources());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPlayerResources($overrideExisting = true)
    {
        if (null !== $this->collPlayerResources && !$overrideExisting) {
            return;
        }
        $this->collPlayerResources = new ObjectCollection();
        $this->collPlayerResources->setModel('\PlayerResource');
    }

    /**
     * Gets an array of ChildPlayerResource objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPlayerResource[] List of ChildPlayerResource objects
     * @throws PropelException
     */
    public function getPlayerResources(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayerResourcesPartial && !$this->isNew();
        if (null === $this->collPlayerResources || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPlayerResources) {
                // return empty collection
                $this->initPlayerResources();
            } else {
                $collPlayerResources = ChildPlayerResourceQuery::create(null, $criteria)
                    ->filterByPlayer($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPlayerResourcesPartial && count($collPlayerResources)) {
                        $this->initPlayerResources(false);

                        foreach ($collPlayerResources as $obj) {
                            if (false == $this->collPlayerResources->contains($obj)) {
                                $this->collPlayerResources->append($obj);
                            }
                        }

                        $this->collPlayerResourcesPartial = true;
                    }

                    return $collPlayerResources;
                }

                if ($partial && $this->collPlayerResources) {
                    foreach ($this->collPlayerResources as $obj) {
                        if ($obj->isNew()) {
                            $collPlayerResources[] = $obj;
                        }
                    }
                }

                $this->collPlayerResources = $collPlayerResources;
                $this->collPlayerResourcesPartial = false;
            }
        }

        return $this->collPlayerResources;
    }

    /**
     * Sets a collection of ChildPlayerResource objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $playerResources A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function setPlayerResources(Collection $playerResources, ConnectionInterface $con = null)
    {
        /** @var ChildPlayerResource[] $playerResourcesToDelete */
        $playerResourcesToDelete = $this->getPlayerResources(new Criteria(), $con)->diff($playerResources);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->playerResourcesScheduledForDeletion = clone $playerResourcesToDelete;

        foreach ($playerResourcesToDelete as $playerResourceRemoved) {
            $playerResourceRemoved->setPlayer(null);
        }

        $this->collPlayerResources = null;
        foreach ($playerResources as $playerResource) {
            $this->addPlayerResource($playerResource);
        }

        $this->collPlayerResources = $playerResources;
        $this->collPlayerResourcesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PlayerResource objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PlayerResource objects.
     * @throws PropelException
     */
    public function countPlayerResources(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayerResourcesPartial && !$this->isNew();
        if (null === $this->collPlayerResources || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPlayerResources) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPlayerResources());
            }

            $query = ChildPlayerResourceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlayer($this)
                ->count($con);
        }

        return count($this->collPlayerResources);
    }

    /**
     * Method called to associate a ChildPlayerResource object to this object
     * through the ChildPlayerResource foreign key attribute.
     *
     * @param  ChildPlayerResource $l ChildPlayerResource
     * @return $this|\Player The current object (for fluent API support)
     */
    public function addPlayerResource(ChildPlayerResource $l)
    {
        if ($this->collPlayerResources === null) {
            $this->initPlayerResources();
            $this->collPlayerResourcesPartial = true;
        }

        if (!$this->collPlayerResources->contains($l)) {
            $this->doAddPlayerResource($l);
        }

        return $this;
    }

    /**
     * @param ChildPlayerResource $playerResource The ChildPlayerResource object to add.
     */
    protected function doAddPlayerResource(ChildPlayerResource $playerResource)
    {
        $this->collPlayerResources[]= $playerResource;
        $playerResource->setPlayer($this);
    }

    /**
     * @param  ChildPlayerResource $playerResource The ChildPlayerResource object to remove.
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function removePlayerResource(ChildPlayerResource $playerResource)
    {
        if ($this->getPlayerResources()->contains($playerResource)) {
            $pos = $this->collPlayerResources->search($playerResource);
            $this->collPlayerResources->remove($pos);
            if (null === $this->playerResourcesScheduledForDeletion) {
                $this->playerResourcesScheduledForDeletion = clone $this->collPlayerResources;
                $this->playerResourcesScheduledForDeletion->clear();
            }
            $this->playerResourcesScheduledForDeletion[]= clone $playerResource;
            $playerResource->setPlayer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related PlayerResources from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlayerResource[] List of ChildPlayerResource objects
     */
    public function getPlayerResourcesJoinResourceType(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerResourceQuery::create(null, $criteria);
        $query->joinWith('ResourceType', $joinBehavior);

        return $this->getPlayerResources($query, $con);
    }

    /**
     * Clears out the collPlayerCities collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPlayerCities()
     */
    public function clearPlayerCities()
    {
        $this->collPlayerCities = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPlayerCities collection loaded partially.
     */
    public function resetPartialPlayerCities($v = true)
    {
        $this->collPlayerCitiesPartial = $v;
    }

    /**
     * Initializes the collPlayerCities collection.
     *
     * By default this just sets the collPlayerCities collection to an empty array (like clearcollPlayerCities());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPlayerCities($overrideExisting = true)
    {
        if (null !== $this->collPlayerCities && !$overrideExisting) {
            return;
        }
        $this->collPlayerCities = new ObjectCollection();
        $this->collPlayerCities->setModel('\PlayerCity');
    }

    /**
     * Gets an array of ChildPlayerCity objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPlayerCity[] List of ChildPlayerCity objects
     * @throws PropelException
     */
    public function getPlayerCities(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayerCitiesPartial && !$this->isNew();
        if (null === $this->collPlayerCities || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPlayerCities) {
                // return empty collection
                $this->initPlayerCities();
            } else {
                $collPlayerCities = ChildPlayerCityQuery::create(null, $criteria)
                    ->filterByPlayer($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPlayerCitiesPartial && count($collPlayerCities)) {
                        $this->initPlayerCities(false);

                        foreach ($collPlayerCities as $obj) {
                            if (false == $this->collPlayerCities->contains($obj)) {
                                $this->collPlayerCities->append($obj);
                            }
                        }

                        $this->collPlayerCitiesPartial = true;
                    }

                    return $collPlayerCities;
                }

                if ($partial && $this->collPlayerCities) {
                    foreach ($this->collPlayerCities as $obj) {
                        if ($obj->isNew()) {
                            $collPlayerCities[] = $obj;
                        }
                    }
                }

                $this->collPlayerCities = $collPlayerCities;
                $this->collPlayerCitiesPartial = false;
            }
        }

        return $this->collPlayerCities;
    }

    /**
     * Sets a collection of ChildPlayerCity objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $playerCities A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function setPlayerCities(Collection $playerCities, ConnectionInterface $con = null)
    {
        /** @var ChildPlayerCity[] $playerCitiesToDelete */
        $playerCitiesToDelete = $this->getPlayerCities(new Criteria(), $con)->diff($playerCities);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->playerCitiesScheduledForDeletion = clone $playerCitiesToDelete;

        foreach ($playerCitiesToDelete as $playerCityRemoved) {
            $playerCityRemoved->setPlayer(null);
        }

        $this->collPlayerCities = null;
        foreach ($playerCities as $playerCity) {
            $this->addPlayerCity($playerCity);
        }

        $this->collPlayerCities = $playerCities;
        $this->collPlayerCitiesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PlayerCity objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PlayerCity objects.
     * @throws PropelException
     */
    public function countPlayerCities(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayerCitiesPartial && !$this->isNew();
        if (null === $this->collPlayerCities || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPlayerCities) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPlayerCities());
            }

            $query = ChildPlayerCityQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlayer($this)
                ->count($con);
        }

        return count($this->collPlayerCities);
    }

    /**
     * Method called to associate a ChildPlayerCity object to this object
     * through the ChildPlayerCity foreign key attribute.
     *
     * @param  ChildPlayerCity $l ChildPlayerCity
     * @return $this|\Player The current object (for fluent API support)
     */
    public function addPlayerCity(ChildPlayerCity $l)
    {
        if ($this->collPlayerCities === null) {
            $this->initPlayerCities();
            $this->collPlayerCitiesPartial = true;
        }

        if (!$this->collPlayerCities->contains($l)) {
            $this->doAddPlayerCity($l);
        }

        return $this;
    }

    /**
     * @param ChildPlayerCity $playerCity The ChildPlayerCity object to add.
     */
    protected function doAddPlayerCity(ChildPlayerCity $playerCity)
    {
        $this->collPlayerCities[]= $playerCity;
        $playerCity->setPlayer($this);
    }

    /**
     * @param  ChildPlayerCity $playerCity The ChildPlayerCity object to remove.
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function removePlayerCity(ChildPlayerCity $playerCity)
    {
        if ($this->getPlayerCities()->contains($playerCity)) {
            $pos = $this->collPlayerCities->search($playerCity);
            $this->collPlayerCities->remove($pos);
            if (null === $this->playerCitiesScheduledForDeletion) {
                $this->playerCitiesScheduledForDeletion = clone $this->collPlayerCities;
                $this->playerCitiesScheduledForDeletion->clear();
            }
            $this->playerCitiesScheduledForDeletion[]= clone $playerCity;
            $playerCity->setPlayer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related PlayerCities from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlayerCity[] List of ChildPlayerCity objects
     */
    public function getPlayerCitiesJoinCity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerCityQuery::create(null, $criteria);
        $query->joinWith('City', $joinBehavior);

        return $this->getPlayerCities($query, $con);
    }

    /**
     * Clears out the collPlayerCards collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPlayerCards()
     */
    public function clearPlayerCards()
    {
        $this->collPlayerCards = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPlayerCards collection loaded partially.
     */
    public function resetPartialPlayerCards($v = true)
    {
        $this->collPlayerCardsPartial = $v;
    }

    /**
     * Initializes the collPlayerCards collection.
     *
     * By default this just sets the collPlayerCards collection to an empty array (like clearcollPlayerCards());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPlayerCards($overrideExisting = true)
    {
        if (null !== $this->collPlayerCards && !$overrideExisting) {
            return;
        }
        $this->collPlayerCards = new ObjectCollection();
        $this->collPlayerCards->setModel('\PlayerCard');
    }

    /**
     * Gets an array of ChildPlayerCard objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPlayerCard[] List of ChildPlayerCard objects
     * @throws PropelException
     */
    public function getPlayerCards(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayerCardsPartial && !$this->isNew();
        if (null === $this->collPlayerCards || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPlayerCards) {
                // return empty collection
                $this->initPlayerCards();
            } else {
                $collPlayerCards = ChildPlayerCardQuery::create(null, $criteria)
                    ->filterByPlayer($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPlayerCardsPartial && count($collPlayerCards)) {
                        $this->initPlayerCards(false);

                        foreach ($collPlayerCards as $obj) {
                            if (false == $this->collPlayerCards->contains($obj)) {
                                $this->collPlayerCards->append($obj);
                            }
                        }

                        $this->collPlayerCardsPartial = true;
                    }

                    return $collPlayerCards;
                }

                if ($partial && $this->collPlayerCards) {
                    foreach ($this->collPlayerCards as $obj) {
                        if ($obj->isNew()) {
                            $collPlayerCards[] = $obj;
                        }
                    }
                }

                $this->collPlayerCards = $collPlayerCards;
                $this->collPlayerCardsPartial = false;
            }
        }

        return $this->collPlayerCards;
    }

    /**
     * Sets a collection of ChildPlayerCard objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $playerCards A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function setPlayerCards(Collection $playerCards, ConnectionInterface $con = null)
    {
        /** @var ChildPlayerCard[] $playerCardsToDelete */
        $playerCardsToDelete = $this->getPlayerCards(new Criteria(), $con)->diff($playerCards);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->playerCardsScheduledForDeletion = clone $playerCardsToDelete;

        foreach ($playerCardsToDelete as $playerCardRemoved) {
            $playerCardRemoved->setPlayer(null);
        }

        $this->collPlayerCards = null;
        foreach ($playerCards as $playerCard) {
            $this->addPlayerCard($playerCard);
        }

        $this->collPlayerCards = $playerCards;
        $this->collPlayerCardsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PlayerCard objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PlayerCard objects.
     * @throws PropelException
     */
    public function countPlayerCards(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayerCardsPartial && !$this->isNew();
        if (null === $this->collPlayerCards || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPlayerCards) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPlayerCards());
            }

            $query = ChildPlayerCardQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlayer($this)
                ->count($con);
        }

        return count($this->collPlayerCards);
    }

    /**
     * Method called to associate a ChildPlayerCard object to this object
     * through the ChildPlayerCard foreign key attribute.
     *
     * @param  ChildPlayerCard $l ChildPlayerCard
     * @return $this|\Player The current object (for fluent API support)
     */
    public function addPlayerCard(ChildPlayerCard $l)
    {
        if ($this->collPlayerCards === null) {
            $this->initPlayerCards();
            $this->collPlayerCardsPartial = true;
        }

        if (!$this->collPlayerCards->contains($l)) {
            $this->doAddPlayerCard($l);
        }

        return $this;
    }

    /**
     * @param ChildPlayerCard $playerCard The ChildPlayerCard object to add.
     */
    protected function doAddPlayerCard(ChildPlayerCard $playerCard)
    {
        $this->collPlayerCards[]= $playerCard;
        $playerCard->setPlayer($this);
    }

    /**
     * @param  ChildPlayerCard $playerCard The ChildPlayerCard object to remove.
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function removePlayerCard(ChildPlayerCard $playerCard)
    {
        if ($this->getPlayerCards()->contains($playerCard)) {
            $pos = $this->collPlayerCards->search($playerCard);
            $this->collPlayerCards->remove($pos);
            if (null === $this->playerCardsScheduledForDeletion) {
                $this->playerCardsScheduledForDeletion = clone $this->collPlayerCards;
                $this->playerCardsScheduledForDeletion->clear();
            }
            $this->playerCardsScheduledForDeletion[]= clone $playerCard;
            $playerCard->setPlayer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related PlayerCards from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlayerCard[] List of ChildPlayerCard objects
     */
    public function getPlayerCardsJoinCard(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerCardQuery::create(null, $criteria);
        $query->joinWith('Card', $joinBehavior);

        return $this->getPlayerCards($query, $con);
    }

    /**
     * Clears out the collCurrentAuctionPlants collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCurrentAuctionPlants()
     */
    public function clearCurrentAuctionPlants()
    {
        $this->collCurrentAuctionPlants = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCurrentAuctionPlants collection loaded partially.
     */
    public function resetPartialCurrentAuctionPlants($v = true)
    {
        $this->collCurrentAuctionPlantsPartial = $v;
    }

    /**
     * Initializes the collCurrentAuctionPlants collection.
     *
     * By default this just sets the collCurrentAuctionPlants collection to an empty array (like clearcollCurrentAuctionPlants());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCurrentAuctionPlants($overrideExisting = true)
    {
        if (null !== $this->collCurrentAuctionPlants && !$overrideExisting) {
            return;
        }
        $this->collCurrentAuctionPlants = new ObjectCollection();
        $this->collCurrentAuctionPlants->setModel('\CurrentAuctionPlant');
    }

    /**
     * Gets an array of ChildCurrentAuctionPlant objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlayer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCurrentAuctionPlant[] List of ChildCurrentAuctionPlant objects
     * @throws PropelException
     */
    public function getCurrentAuctionPlants(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCurrentAuctionPlantsPartial && !$this->isNew();
        if (null === $this->collCurrentAuctionPlants || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCurrentAuctionPlants) {
                // return empty collection
                $this->initCurrentAuctionPlants();
            } else {
                $collCurrentAuctionPlants = ChildCurrentAuctionPlantQuery::create(null, $criteria)
                    ->filterByHighestBidder($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCurrentAuctionPlantsPartial && count($collCurrentAuctionPlants)) {
                        $this->initCurrentAuctionPlants(false);

                        foreach ($collCurrentAuctionPlants as $obj) {
                            if (false == $this->collCurrentAuctionPlants->contains($obj)) {
                                $this->collCurrentAuctionPlants->append($obj);
                            }
                        }

                        $this->collCurrentAuctionPlantsPartial = true;
                    }

                    return $collCurrentAuctionPlants;
                }

                if ($partial && $this->collCurrentAuctionPlants) {
                    foreach ($this->collCurrentAuctionPlants as $obj) {
                        if ($obj->isNew()) {
                            $collCurrentAuctionPlants[] = $obj;
                        }
                    }
                }

                $this->collCurrentAuctionPlants = $collCurrentAuctionPlants;
                $this->collCurrentAuctionPlantsPartial = false;
            }
        }

        return $this->collCurrentAuctionPlants;
    }

    /**
     * Sets a collection of ChildCurrentAuctionPlant objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $currentAuctionPlants A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function setCurrentAuctionPlants(Collection $currentAuctionPlants, ConnectionInterface $con = null)
    {
        /** @var ChildCurrentAuctionPlant[] $currentAuctionPlantsToDelete */
        $currentAuctionPlantsToDelete = $this->getCurrentAuctionPlants(new Criteria(), $con)->diff($currentAuctionPlants);


        $this->currentAuctionPlantsScheduledForDeletion = $currentAuctionPlantsToDelete;

        foreach ($currentAuctionPlantsToDelete as $currentAuctionPlantRemoved) {
            $currentAuctionPlantRemoved->setHighestBidder(null);
        }

        $this->collCurrentAuctionPlants = null;
        foreach ($currentAuctionPlants as $currentAuctionPlant) {
            $this->addCurrentAuctionPlant($currentAuctionPlant);
        }

        $this->collCurrentAuctionPlants = $currentAuctionPlants;
        $this->collCurrentAuctionPlantsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CurrentAuctionPlant objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CurrentAuctionPlant objects.
     * @throws PropelException
     */
    public function countCurrentAuctionPlants(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCurrentAuctionPlantsPartial && !$this->isNew();
        if (null === $this->collCurrentAuctionPlants || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCurrentAuctionPlants) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCurrentAuctionPlants());
            }

            $query = ChildCurrentAuctionPlantQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByHighestBidder($this)
                ->count($con);
        }

        return count($this->collCurrentAuctionPlants);
    }

    /**
     * Method called to associate a ChildCurrentAuctionPlant object to this object
     * through the ChildCurrentAuctionPlant foreign key attribute.
     *
     * @param  ChildCurrentAuctionPlant $l ChildCurrentAuctionPlant
     * @return $this|\Player The current object (for fluent API support)
     */
    public function addCurrentAuctionPlant(ChildCurrentAuctionPlant $l)
    {
        if ($this->collCurrentAuctionPlants === null) {
            $this->initCurrentAuctionPlants();
            $this->collCurrentAuctionPlantsPartial = true;
        }

        if (!$this->collCurrentAuctionPlants->contains($l)) {
            $this->doAddCurrentAuctionPlant($l);
        }

        return $this;
    }

    /**
     * @param ChildCurrentAuctionPlant $currentAuctionPlant The ChildCurrentAuctionPlant object to add.
     */
    protected function doAddCurrentAuctionPlant(ChildCurrentAuctionPlant $currentAuctionPlant)
    {
        $this->collCurrentAuctionPlants[]= $currentAuctionPlant;
        $currentAuctionPlant->setHighestBidder($this);
    }

    /**
     * @param  ChildCurrentAuctionPlant $currentAuctionPlant The ChildCurrentAuctionPlant object to remove.
     * @return $this|ChildPlayer The current object (for fluent API support)
     */
    public function removeCurrentAuctionPlant(ChildCurrentAuctionPlant $currentAuctionPlant)
    {
        if ($this->getCurrentAuctionPlants()->contains($currentAuctionPlant)) {
            $pos = $this->collCurrentAuctionPlants->search($currentAuctionPlant);
            $this->collCurrentAuctionPlants->remove($pos);
            if (null === $this->currentAuctionPlantsScheduledForDeletion) {
                $this->currentAuctionPlantsScheduledForDeletion = clone $this->collCurrentAuctionPlants;
                $this->currentAuctionPlantsScheduledForDeletion->clear();
            }
            $this->currentAuctionPlantsScheduledForDeletion[]= $currentAuctionPlant;
            $currentAuctionPlant->setHighestBidder(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related CurrentAuctionPlants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCurrentAuctionPlant[] List of ChildCurrentAuctionPlant objects
     */
    public function getCurrentAuctionPlantsJoinGame(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCurrentAuctionPlantQuery::create(null, $criteria);
        $query->joinWith('Game', $joinBehavior);

        return $this->getCurrentAuctionPlants($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Player is new, it will return
     * an empty collection; or if this Player has previously
     * been saved, it will retrieve related CurrentAuctionPlants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Player.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCurrentAuctionPlant[] List of ChildCurrentAuctionPlant objects
     */
    public function getCurrentAuctionPlantsJoinCard(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCurrentAuctionPlantQuery::create(null, $criteria);
        $query->joinWith('Card', $joinBehavior);

        return $this->getCurrentAuctionPlants($query, $con);
    }

    /**
     * Gets a single ChildPlayerAuctionAction object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildPlayerAuctionAction
     * @throws PropelException
     */
    public function getPlayerAuctionAction(ConnectionInterface $con = null)
    {

        if ($this->singlePlayerAuctionAction === null && !$this->isNew()) {
            $this->singlePlayerAuctionAction = ChildPlayerAuctionActionQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singlePlayerAuctionAction;
    }

    /**
     * Sets a single ChildPlayerAuctionAction object as related to this object by a one-to-one relationship.
     *
     * @param  ChildPlayerAuctionAction $v ChildPlayerAuctionAction
     * @return $this|\Player The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPlayerAuctionAction(ChildPlayerAuctionAction $v = null)
    {
        $this->singlePlayerAuctionAction = $v;

        // Make sure that that the passed-in ChildPlayerAuctionAction isn't already associated with this object
        if ($v !== null && $v->getPlayer(null, false) === null) {
            $v->setPlayer($this);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPlayerUser) {
            $this->aPlayerUser->removePlayer($this);
        }
        if (null !== $this->aCurrentGame) {
            $this->aCurrentGame->removePlayer($this);
        }
        if (null !== $this->aPlayerWallet) {
            $this->aPlayerWallet->removePlayer($this);
        }
        $this->id = null;
        $this->name = null;
        $this->user_id = null;
        $this->game_id = null;
        $this->wallet_id = null;
        $this->color_name = null;
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
            if ($this->collTurnOrders) {
                foreach ($this->collTurnOrders as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPlayerResources) {
                foreach ($this->collPlayerResources as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPlayerCities) {
                foreach ($this->collPlayerCities as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPlayerCards) {
                foreach ($this->collPlayerCards as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCurrentAuctionPlants) {
                foreach ($this->collCurrentAuctionPlants as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singlePlayerAuctionAction) {
                $this->singlePlayerAuctionAction->clearAllReferences($deep);
            }
        } // if ($deep)

        $this->collTurnOrders = null;
        $this->collPlayerResources = null;
        $this->collPlayerCities = null;
        $this->collPlayerCards = null;
        $this->collCurrentAuctionPlants = null;
        $this->singlePlayerAuctionAction = null;
        $this->aPlayerUser = null;
        $this->aCurrentGame = null;
        $this->aPlayerWallet = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PlayerTableMap::DEFAULT_STRING_FORMAT);
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
