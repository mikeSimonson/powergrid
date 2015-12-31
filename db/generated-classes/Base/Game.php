<?php

namespace Base;

use \Bank as ChildBank;
use \BankQuery as ChildBankQuery;
use \CardSet as ChildCardSet;
use \CardSetQuery as ChildCardSetQuery;
use \CurrentAuctionPlant as ChildCurrentAuctionPlant;
use \CurrentAuctionPlantQuery as ChildCurrentAuctionPlantQuery;
use \Game as ChildGame;
use \GameAuctionCard as ChildGameAuctionCard;
use \GameAuctionCardQuery as ChildGameAuctionCardQuery;
use \GameCard as ChildGameCard;
use \GameCardQuery as ChildGameCardQuery;
use \GameDeckCard as ChildGameDeckCard;
use \GameDeckCardQuery as ChildGameDeckCardQuery;
use \GameQuery as ChildGameQuery;
use \Map as ChildMap;
use \MapQuery as ChildMapQuery;
use \Player as ChildPlayer;
use \PlayerAuctionAction as ChildPlayerAuctionAction;
use \PlayerAuctionActionQuery as ChildPlayerAuctionActionQuery;
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
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the has_started field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $has_started;

    /**
     * The value for the card_limit field.
     * @var        int
     */
    protected $card_limit;

    /**
     * The value for the turn_number field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $turn_number;

    /**
     * The value for the phase_number field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $phase_number;

    /**
     * The value for the round_number field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $round_number;

    /**
     * The value for the step_number field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $step_number;

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
     * The value for the card_set_id field.
     * @var        int
     */
    protected $card_set_id;

    /**
     * @var        ChildUser
     */
    protected $aOwnerUser;

    /**
     * @var        ChildBank
     */
    protected $aBank;

    /**
     * @var        ChildMap
     */
    protected $aMap;

    /**
     * @var        ChildCardSet
     */
    protected $aCardSet;

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
     * @var        ObjectCollection|ChildGameDeckCard[] Collection to store aggregation of ChildGameDeckCard objects.
     */
    protected $collDeckCards;
    protected $collDeckCardsPartial;

    /**
     * @var        ObjectCollection|ChildGameAuctionCard[] Collection to store aggregation of ChildGameAuctionCard objects.
     */
    protected $collAuctionCards;
    protected $collAuctionCardsPartial;

    /**
     * @var        ChildCurrentAuctionPlant one-to-one related ChildCurrentAuctionPlant object
     */
    protected $singleCurrentAuctionPlant;

    /**
     * @var        ObjectCollection|ChildPlayerAuctionAction[] Collection to store aggregation of ChildPlayerAuctionAction objects.
     */
    protected $collPlayerAuctionActions;
    protected $collPlayerAuctionActionsPartial;

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
     * @var ObjectCollection|ChildGameDeckCard[]
     */
    protected $deckCardsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGameAuctionCard[]
     */
    protected $auctionCardsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlayerAuctionAction[]
     */
    protected $playerAuctionActionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->has_started = false;
        $this->turn_number = 1;
        $this->phase_number = 1;
        $this->round_number = 1;
        $this->step_number = 1;
    }

    /**
     * Initializes internal state of Base\Game object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [has_started] column value.
     *
     * @return boolean
     */
    public function getHasStarted()
    {
        return $this->has_started;
    }

    /**
     * Get the [has_started] column value.
     *
     * @return boolean
     */
    public function hasStarted()
    {
        return $this->getHasStarted();
    }

    /**
     * Get the [card_limit] column value.
     *
     * @return int
     */
    public function getCardLimit()
    {
        return $this->card_limit;
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
     * Get the [phase_number] column value.
     *
     * @return int
     */
    public function getPhaseNumber()
    {
        return $this->phase_number;
    }

    /**
     * Get the [round_number] column value.
     *
     * @return int
     */
    public function getRoundNumber()
    {
        return $this->round_number;
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
     * Get the [card_set_id] column value.
     *
     * @return int
     */
    public function getCardSetId()
    {
        return $this->card_set_id;
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
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[GameTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Sets the value of the [has_started] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setHasStarted($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->has_started !== $v) {
            $this->has_started = $v;
            $this->modifiedColumns[GameTableMap::COL_HAS_STARTED] = true;
        }

        return $this;
    } // setHasStarted()

    /**
     * Set the value of [card_limit] column.
     *
     * @param int $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setCardLimit($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->card_limit !== $v) {
            $this->card_limit = $v;
            $this->modifiedColumns[GameTableMap::COL_CARD_LIMIT] = true;
        }

        return $this;
    } // setCardLimit()

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
     * Set the value of [phase_number] column.
     *
     * @param int $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setPhaseNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->phase_number !== $v) {
            $this->phase_number = $v;
            $this->modifiedColumns[GameTableMap::COL_PHASE_NUMBER] = true;
        }

        return $this;
    } // setPhaseNumber()

    /**
     * Set the value of [round_number] column.
     *
     * @param int $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setRoundNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->round_number !== $v) {
            $this->round_number = $v;
            $this->modifiedColumns[GameTableMap::COL_ROUND_NUMBER] = true;
        }

        return $this;
    } // setRoundNumber()

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

        if ($this->aOwnerUser !== null && $this->aOwnerUser->getId() !== $v) {
            $this->aOwnerUser = null;
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
     * Set the value of [card_set_id] column.
     *
     * @param int $v new value
     * @return $this|\Game The current object (for fluent API support)
     */
    public function setCardSetId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->card_set_id !== $v) {
            $this->card_set_id = $v;
            $this->modifiedColumns[GameTableMap::COL_CARD_SET_ID] = true;
        }

        if ($this->aCardSet !== null && $this->aCardSet->getId() !== $v) {
            $this->aCardSet = null;
        }

        return $this;
    } // setCardSetId()

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
            if ($this->has_started !== false) {
                return false;
            }

            if ($this->turn_number !== 1) {
                return false;
            }

            if ($this->phase_number !== 1) {
                return false;
            }

            if ($this->round_number !== 1) {
                return false;
            }

            if ($this->step_number !== 1) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : GameTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : GameTableMap::translateFieldName('HasStarted', TableMap::TYPE_PHPNAME, $indexType)];
            $this->has_started = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : GameTableMap::translateFieldName('CardLimit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->card_limit = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : GameTableMap::translateFieldName('TurnNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->turn_number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : GameTableMap::translateFieldName('PhaseNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phase_number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : GameTableMap::translateFieldName('RoundNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->round_number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : GameTableMap::translateFieldName('StepNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->step_number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : GameTableMap::translateFieldName('OwnerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->owner_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : GameTableMap::translateFieldName('BankId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bank_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : GameTableMap::translateFieldName('MapId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->map_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : GameTableMap::translateFieldName('CardSetId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->card_set_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = GameTableMap::NUM_HYDRATE_COLUMNS.

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
        if ($this->aOwnerUser !== null && $this->owner_id !== $this->aOwnerUser->getId()) {
            $this->aOwnerUser = null;
        }
        if ($this->aBank !== null && $this->bank_id !== $this->aBank->getId()) {
            $this->aBank = null;
        }
        if ($this->aMap !== null && $this->map_id !== $this->aMap->getId()) {
            $this->aMap = null;
        }
        if ($this->aCardSet !== null && $this->card_set_id !== $this->aCardSet->getId()) {
            $this->aCardSet = null;
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

            $this->aOwnerUser = null;
            $this->aBank = null;
            $this->aMap = null;
            $this->aCardSet = null;
            $this->collPlayers = null;

            $this->collResourceStores = null;

            $this->collTurnOrders = null;

            $this->collGameCards = null;

            $this->collDeckCards = null;

            $this->collAuctionCards = null;

            $this->singleCurrentAuctionPlant = null;

            $this->collPlayerAuctionActions = null;

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

            if ($this->aOwnerUser !== null) {
                if ($this->aOwnerUser->isModified() || $this->aOwnerUser->isNew()) {
                    $affectedRows += $this->aOwnerUser->save($con);
                }
                $this->setOwnerUser($this->aOwnerUser);
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

            if ($this->aCardSet !== null) {
                if ($this->aCardSet->isModified() || $this->aCardSet->isNew()) {
                    $affectedRows += $this->aCardSet->save($con);
                }
                $this->setCardSet($this->aCardSet);
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
                    foreach ($this->playersScheduledForDeletion as $player) {
                        // need to save related object because we set the relation to null
                        $player->save($con);
                    }
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

            if ($this->gameCardsScheduledForDeletion !== null) {
                if (!$this->gameCardsScheduledForDeletion->isEmpty()) {
                    foreach ($this->gameCardsScheduledForDeletion as $gameCard) {
                        // need to save related object because we set the relation to null
                        $gameCard->save($con);
                    }
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

            if ($this->deckCardsScheduledForDeletion !== null) {
                if (!$this->deckCardsScheduledForDeletion->isEmpty()) {
                    foreach ($this->deckCardsScheduledForDeletion as $deckCard) {
                        // need to save related object because we set the relation to null
                        $deckCard->save($con);
                    }
                    $this->deckCardsScheduledForDeletion = null;
                }
            }

            if ($this->collDeckCards !== null) {
                foreach ($this->collDeckCards as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->auctionCardsScheduledForDeletion !== null) {
                if (!$this->auctionCardsScheduledForDeletion->isEmpty()) {
                    foreach ($this->auctionCardsScheduledForDeletion as $auctionCard) {
                        // need to save related object because we set the relation to null
                        $auctionCard->save($con);
                    }
                    $this->auctionCardsScheduledForDeletion = null;
                }
            }

            if ($this->collAuctionCards !== null) {
                foreach ($this->collAuctionCards as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->singleCurrentAuctionPlant !== null) {
                if (!$this->singleCurrentAuctionPlant->isDeleted() && ($this->singleCurrentAuctionPlant->isNew() || $this->singleCurrentAuctionPlant->isModified())) {
                    $affectedRows += $this->singleCurrentAuctionPlant->save($con);
                }
            }

            if ($this->playerAuctionActionsScheduledForDeletion !== null) {
                if (!$this->playerAuctionActionsScheduledForDeletion->isEmpty()) {
                    foreach ($this->playerAuctionActionsScheduledForDeletion as $playerAuctionAction) {
                        // need to save related object because we set the relation to null
                        $playerAuctionAction->save($con);
                    }
                    $this->playerAuctionActionsScheduledForDeletion = null;
                }
            }

            if ($this->collPlayerAuctionActions !== null) {
                foreach ($this->collPlayerAuctionActions as $referrerFK) {
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
        if ($this->isColumnModified(GameTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(GameTableMap::COL_HAS_STARTED)) {
            $modifiedColumns[':p' . $index++]  = 'has_started';
        }
        if ($this->isColumnModified(GameTableMap::COL_CARD_LIMIT)) {
            $modifiedColumns[':p' . $index++]  = 'card_limit';
        }
        if ($this->isColumnModified(GameTableMap::COL_TURN_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'turn_number';
        }
        if ($this->isColumnModified(GameTableMap::COL_PHASE_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'phase_number';
        }
        if ($this->isColumnModified(GameTableMap::COL_ROUND_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'round_number';
        }
        if ($this->isColumnModified(GameTableMap::COL_STEP_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'step_number';
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
        if ($this->isColumnModified(GameTableMap::COL_CARD_SET_ID)) {
            $modifiedColumns[':p' . $index++]  = 'card_set_id';
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
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'has_started':
                        $stmt->bindValue($identifier, $this->has_started, PDO::PARAM_BOOL);
                        break;
                    case 'card_limit':
                        $stmt->bindValue($identifier, $this->card_limit, PDO::PARAM_INT);
                        break;
                    case 'turn_number':
                        $stmt->bindValue($identifier, $this->turn_number, PDO::PARAM_INT);
                        break;
                    case 'phase_number':
                        $stmt->bindValue($identifier, $this->phase_number, PDO::PARAM_INT);
                        break;
                    case 'round_number':
                        $stmt->bindValue($identifier, $this->round_number, PDO::PARAM_INT);
                        break;
                    case 'step_number':
                        $stmt->bindValue($identifier, $this->step_number, PDO::PARAM_INT);
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
                    case 'card_set_id':
                        $stmt->bindValue($identifier, $this->card_set_id, PDO::PARAM_INT);
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
                return $this->getName();
                break;
            case 2:
                return $this->getHasStarted();
                break;
            case 3:
                return $this->getCardLimit();
                break;
            case 4:
                return $this->getTurnNumber();
                break;
            case 5:
                return $this->getPhaseNumber();
                break;
            case 6:
                return $this->getRoundNumber();
                break;
            case 7:
                return $this->getStepNumber();
                break;
            case 8:
                return $this->getOwnerId();
                break;
            case 9:
                return $this->getBankId();
                break;
            case 10:
                return $this->getMapId();
                break;
            case 11:
                return $this->getCardSetId();
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
            $keys[1] => $this->getName(),
            $keys[2] => $this->getHasStarted(),
            $keys[3] => $this->getCardLimit(),
            $keys[4] => $this->getTurnNumber(),
            $keys[5] => $this->getPhaseNumber(),
            $keys[6] => $this->getRoundNumber(),
            $keys[7] => $this->getStepNumber(),
            $keys[8] => $this->getOwnerId(),
            $keys[9] => $this->getBankId(),
            $keys[10] => $this->getMapId(),
            $keys[11] => $this->getCardSetId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aOwnerUser) {

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

                $result[$key] = $this->aOwnerUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->aCardSet) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cardSet';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'card_set';
                        break;
                    default:
                        $key = 'CardSet';
                }

                $result[$key] = $this->aCardSet->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collDeckCards) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gameDeckCards';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'game_deck_cards';
                        break;
                    default:
                        $key = 'GameDeckCards';
                }

                $result[$key] = $this->collDeckCards->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAuctionCards) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gameAuctionCards';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'game_auction_cards';
                        break;
                    default:
                        $key = 'GameAuctionCards';
                }

                $result[$key] = $this->collAuctionCards->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->singleCurrentAuctionPlant) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'currentAuctionPlant';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'current_auction_plant';
                        break;
                    default:
                        $key = 'CurrentAuctionPlant';
                }

                $result[$key] = $this->singleCurrentAuctionPlant->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPlayerAuctionActions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'playerAuctionActions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'player_auction_actions';
                        break;
                    default:
                        $key = 'PlayerAuctionActions';
                }

                $result[$key] = $this->collPlayerAuctionActions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
                $this->setName($value);
                break;
            case 2:
                $this->setHasStarted($value);
                break;
            case 3:
                $this->setCardLimit($value);
                break;
            case 4:
                $this->setTurnNumber($value);
                break;
            case 5:
                $this->setPhaseNumber($value);
                break;
            case 6:
                $this->setRoundNumber($value);
                break;
            case 7:
                $this->setStepNumber($value);
                break;
            case 8:
                $this->setOwnerId($value);
                break;
            case 9:
                $this->setBankId($value);
                break;
            case 10:
                $this->setMapId($value);
                break;
            case 11:
                $this->setCardSetId($value);
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
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setHasStarted($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCardLimit($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTurnNumber($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPhaseNumber($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setRoundNumber($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setStepNumber($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setOwnerId($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setBankId($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setMapId($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setCardSetId($arr[$keys[11]]);
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
        if ($this->isColumnModified(GameTableMap::COL_NAME)) {
            $criteria->add(GameTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(GameTableMap::COL_HAS_STARTED)) {
            $criteria->add(GameTableMap::COL_HAS_STARTED, $this->has_started);
        }
        if ($this->isColumnModified(GameTableMap::COL_CARD_LIMIT)) {
            $criteria->add(GameTableMap::COL_CARD_LIMIT, $this->card_limit);
        }
        if ($this->isColumnModified(GameTableMap::COL_TURN_NUMBER)) {
            $criteria->add(GameTableMap::COL_TURN_NUMBER, $this->turn_number);
        }
        if ($this->isColumnModified(GameTableMap::COL_PHASE_NUMBER)) {
            $criteria->add(GameTableMap::COL_PHASE_NUMBER, $this->phase_number);
        }
        if ($this->isColumnModified(GameTableMap::COL_ROUND_NUMBER)) {
            $criteria->add(GameTableMap::COL_ROUND_NUMBER, $this->round_number);
        }
        if ($this->isColumnModified(GameTableMap::COL_STEP_NUMBER)) {
            $criteria->add(GameTableMap::COL_STEP_NUMBER, $this->step_number);
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
        if ($this->isColumnModified(GameTableMap::COL_CARD_SET_ID)) {
            $criteria->add(GameTableMap::COL_CARD_SET_ID, $this->card_set_id);
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
        $copyObj->setName($this->getName());
        $copyObj->setHasStarted($this->getHasStarted());
        $copyObj->setCardLimit($this->getCardLimit());
        $copyObj->setTurnNumber($this->getTurnNumber());
        $copyObj->setPhaseNumber($this->getPhaseNumber());
        $copyObj->setRoundNumber($this->getRoundNumber());
        $copyObj->setStepNumber($this->getStepNumber());
        $copyObj->setOwnerId($this->getOwnerId());
        $copyObj->setBankId($this->getBankId());
        $copyObj->setMapId($this->getMapId());
        $copyObj->setCardSetId($this->getCardSetId());

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

            foreach ($this->getDeckCards() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDeckCard($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAuctionCards() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAuctionCard($relObj->copy($deepCopy));
                }
            }

            $relObj = $this->getCurrentAuctionPlant();
            if ($relObj) {
                $copyObj->setCurrentAuctionPlant($relObj->copy($deepCopy));
            }

            foreach ($this->getPlayerAuctionActions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlayerAuctionAction($relObj->copy($deepCopy));
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
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Game The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOwnerUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setOwnerId(NULL);
        } else {
            $this->setOwnerId($v->getId());
        }

        $this->aOwnerUser = $v;

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
    public function getOwnerUser(ConnectionInterface $con = null)
    {
        if ($this->aOwnerUser === null && ($this->owner_id !== null)) {
            $this->aOwnerUser = ChildUserQuery::create()->findPk($this->owner_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOwnerUser->addGames($this);
             */
        }

        return $this->aOwnerUser;
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
     * Declares an association between this object and a ChildCardSet object.
     *
     * @param  ChildCardSet $v
     * @return $this|\Game The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCardSet(ChildCardSet $v = null)
    {
        if ($v === null) {
            $this->setCardSetId(NULL);
        } else {
            $this->setCardSetId($v->getId());
        }

        $this->aCardSet = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCardSet object, it will not be re-added.
        if ($v !== null) {
            $v->addGame($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCardSet object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCardSet The associated ChildCardSet object.
     * @throws PropelException
     */
    public function getCardSet(ConnectionInterface $con = null)
    {
        if ($this->aCardSet === null && ($this->card_set_id !== null)) {
            $this->aCardSet = ChildCardSetQuery::create()->findPk($this->card_set_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCardSet->addGames($this);
             */
        }

        return $this->aCardSet;
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
        if ('DeckCard' == $relationName) {
            return $this->initDeckCards();
        }
        if ('AuctionCard' == $relationName) {
            return $this->initAuctionCards();
        }
        if ('PlayerAuctionAction' == $relationName) {
            return $this->initPlayerAuctionActions();
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
                    ->filterByCurrentGame($this)
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
            $playerRemoved->setCurrentGame(null);
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
                ->filterByCurrentGame($this)
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
        $player->setCurrentGame($this);
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
            $this->playersScheduledForDeletion[]= $player;
            $player->setCurrentGame(null);
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
    public function getPlayersJoinPlayerUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerQuery::create(null, $criteria);
        $query->joinWith('PlayerUser', $joinBehavior);

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
    public function getPlayersJoinPlayerWallet(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerQuery::create(null, $criteria);
        $query->joinWith('PlayerWallet', $joinBehavior);

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
            $this->turnOrdersScheduledForDeletion[]= $turnOrder;
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


        $this->gameCardsScheduledForDeletion = $gameCardsToDelete;

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
            $this->gameCardsScheduledForDeletion[]= $gameCard;
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
     * Clears out the collDeckCards collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDeckCards()
     */
    public function clearDeckCards()
    {
        $this->collDeckCards = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDeckCards collection loaded partially.
     */
    public function resetPartialDeckCards($v = true)
    {
        $this->collDeckCardsPartial = $v;
    }

    /**
     * Initializes the collDeckCards collection.
     *
     * By default this just sets the collDeckCards collection to an empty array (like clearcollDeckCards());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDeckCards($overrideExisting = true)
    {
        if (null !== $this->collDeckCards && !$overrideExisting) {
            return;
        }
        $this->collDeckCards = new ObjectCollection();
        $this->collDeckCards->setModel('\GameDeckCard');
    }

    /**
     * Gets an array of ChildGameDeckCard objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGameDeckCard[] List of ChildGameDeckCard objects
     * @throws PropelException
     */
    public function getDeckCards(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDeckCardsPartial && !$this->isNew();
        if (null === $this->collDeckCards || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDeckCards) {
                // return empty collection
                $this->initDeckCards();
            } else {
                $collDeckCards = ChildGameDeckCardQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDeckCardsPartial && count($collDeckCards)) {
                        $this->initDeckCards(false);

                        foreach ($collDeckCards as $obj) {
                            if (false == $this->collDeckCards->contains($obj)) {
                                $this->collDeckCards->append($obj);
                            }
                        }

                        $this->collDeckCardsPartial = true;
                    }

                    return $collDeckCards;
                }

                if ($partial && $this->collDeckCards) {
                    foreach ($this->collDeckCards as $obj) {
                        if ($obj->isNew()) {
                            $collDeckCards[] = $obj;
                        }
                    }
                }

                $this->collDeckCards = $collDeckCards;
                $this->collDeckCardsPartial = false;
            }
        }

        return $this->collDeckCards;
    }

    /**
     * Sets a collection of ChildGameDeckCard objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $deckCards A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setDeckCards(Collection $deckCards, ConnectionInterface $con = null)
    {
        /** @var ChildGameDeckCard[] $deckCardsToDelete */
        $deckCardsToDelete = $this->getDeckCards(new Criteria(), $con)->diff($deckCards);


        $this->deckCardsScheduledForDeletion = $deckCardsToDelete;

        foreach ($deckCardsToDelete as $deckCardRemoved) {
            $deckCardRemoved->setGame(null);
        }

        $this->collDeckCards = null;
        foreach ($deckCards as $deckCard) {
            $this->addDeckCard($deckCard);
        }

        $this->collDeckCards = $deckCards;
        $this->collDeckCardsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GameDeckCard objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GameDeckCard objects.
     * @throws PropelException
     */
    public function countDeckCards(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDeckCardsPartial && !$this->isNew();
        if (null === $this->collDeckCards || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDeckCards) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDeckCards());
            }

            $query = ChildGameDeckCardQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collDeckCards);
    }

    /**
     * Method called to associate a ChildGameDeckCard object to this object
     * through the ChildGameDeckCard foreign key attribute.
     *
     * @param  ChildGameDeckCard $l ChildGameDeckCard
     * @return $this|\Game The current object (for fluent API support)
     */
    public function addDeckCard(ChildGameDeckCard $l)
    {
        if ($this->collDeckCards === null) {
            $this->initDeckCards();
            $this->collDeckCardsPartial = true;
        }

        if (!$this->collDeckCards->contains($l)) {
            $this->doAddDeckCard($l);
        }

        return $this;
    }

    /**
     * @param ChildGameDeckCard $deckCard The ChildGameDeckCard object to add.
     */
    protected function doAddDeckCard(ChildGameDeckCard $deckCard)
    {
        $this->collDeckCards[]= $deckCard;
        $deckCard->setGame($this);
    }

    /**
     * @param  ChildGameDeckCard $deckCard The ChildGameDeckCard object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removeDeckCard(ChildGameDeckCard $deckCard)
    {
        if ($this->getDeckCards()->contains($deckCard)) {
            $pos = $this->collDeckCards->search($deckCard);
            $this->collDeckCards->remove($pos);
            if (null === $this->deckCardsScheduledForDeletion) {
                $this->deckCardsScheduledForDeletion = clone $this->collDeckCards;
                $this->deckCardsScheduledForDeletion->clear();
            }
            $this->deckCardsScheduledForDeletion[]= $deckCard;
            $deckCard->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related DeckCards from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGameDeckCard[] List of ChildGameDeckCard objects
     */
    public function getDeckCardsJoinGameCard(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameDeckCardQuery::create(null, $criteria);
        $query->joinWith('GameCard', $joinBehavior);

        return $this->getDeckCards($query, $con);
    }

    /**
     * Clears out the collAuctionCards collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAuctionCards()
     */
    public function clearAuctionCards()
    {
        $this->collAuctionCards = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAuctionCards collection loaded partially.
     */
    public function resetPartialAuctionCards($v = true)
    {
        $this->collAuctionCardsPartial = $v;
    }

    /**
     * Initializes the collAuctionCards collection.
     *
     * By default this just sets the collAuctionCards collection to an empty array (like clearcollAuctionCards());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuctionCards($overrideExisting = true)
    {
        if (null !== $this->collAuctionCards && !$overrideExisting) {
            return;
        }
        $this->collAuctionCards = new ObjectCollection();
        $this->collAuctionCards->setModel('\GameAuctionCard');
    }

    /**
     * Gets an array of ChildGameAuctionCard objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGameAuctionCard[] List of ChildGameAuctionCard objects
     * @throws PropelException
     */
    public function getAuctionCards(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAuctionCardsPartial && !$this->isNew();
        if (null === $this->collAuctionCards || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAuctionCards) {
                // return empty collection
                $this->initAuctionCards();
            } else {
                $collAuctionCards = ChildGameAuctionCardQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAuctionCardsPartial && count($collAuctionCards)) {
                        $this->initAuctionCards(false);

                        foreach ($collAuctionCards as $obj) {
                            if (false == $this->collAuctionCards->contains($obj)) {
                                $this->collAuctionCards->append($obj);
                            }
                        }

                        $this->collAuctionCardsPartial = true;
                    }

                    return $collAuctionCards;
                }

                if ($partial && $this->collAuctionCards) {
                    foreach ($this->collAuctionCards as $obj) {
                        if ($obj->isNew()) {
                            $collAuctionCards[] = $obj;
                        }
                    }
                }

                $this->collAuctionCards = $collAuctionCards;
                $this->collAuctionCardsPartial = false;
            }
        }

        return $this->collAuctionCards;
    }

    /**
     * Sets a collection of ChildGameAuctionCard objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $auctionCards A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setAuctionCards(Collection $auctionCards, ConnectionInterface $con = null)
    {
        /** @var ChildGameAuctionCard[] $auctionCardsToDelete */
        $auctionCardsToDelete = $this->getAuctionCards(new Criteria(), $con)->diff($auctionCards);


        $this->auctionCardsScheduledForDeletion = $auctionCardsToDelete;

        foreach ($auctionCardsToDelete as $auctionCardRemoved) {
            $auctionCardRemoved->setGame(null);
        }

        $this->collAuctionCards = null;
        foreach ($auctionCards as $auctionCard) {
            $this->addAuctionCard($auctionCard);
        }

        $this->collAuctionCards = $auctionCards;
        $this->collAuctionCardsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GameAuctionCard objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GameAuctionCard objects.
     * @throws PropelException
     */
    public function countAuctionCards(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAuctionCardsPartial && !$this->isNew();
        if (null === $this->collAuctionCards || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuctionCards) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuctionCards());
            }

            $query = ChildGameAuctionCardQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collAuctionCards);
    }

    /**
     * Method called to associate a ChildGameAuctionCard object to this object
     * through the ChildGameAuctionCard foreign key attribute.
     *
     * @param  ChildGameAuctionCard $l ChildGameAuctionCard
     * @return $this|\Game The current object (for fluent API support)
     */
    public function addAuctionCard(ChildGameAuctionCard $l)
    {
        if ($this->collAuctionCards === null) {
            $this->initAuctionCards();
            $this->collAuctionCardsPartial = true;
        }

        if (!$this->collAuctionCards->contains($l)) {
            $this->doAddAuctionCard($l);
        }

        return $this;
    }

    /**
     * @param ChildGameAuctionCard $auctionCard The ChildGameAuctionCard object to add.
     */
    protected function doAddAuctionCard(ChildGameAuctionCard $auctionCard)
    {
        $this->collAuctionCards[]= $auctionCard;
        $auctionCard->setGame($this);
    }

    /**
     * @param  ChildGameAuctionCard $auctionCard The ChildGameAuctionCard object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removeAuctionCard(ChildGameAuctionCard $auctionCard)
    {
        if ($this->getAuctionCards()->contains($auctionCard)) {
            $pos = $this->collAuctionCards->search($auctionCard);
            $this->collAuctionCards->remove($pos);
            if (null === $this->auctionCardsScheduledForDeletion) {
                $this->auctionCardsScheduledForDeletion = clone $this->collAuctionCards;
                $this->auctionCardsScheduledForDeletion->clear();
            }
            $this->auctionCardsScheduledForDeletion[]= $auctionCard;
            $auctionCard->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related AuctionCards from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGameAuctionCard[] List of ChildGameAuctionCard objects
     */
    public function getAuctionCardsJoinGameCard(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameAuctionCardQuery::create(null, $criteria);
        $query->joinWith('GameCard', $joinBehavior);

        return $this->getAuctionCards($query, $con);
    }

    /**
     * Gets a single ChildCurrentAuctionPlant object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildCurrentAuctionPlant
     * @throws PropelException
     */
    public function getCurrentAuctionPlant(ConnectionInterface $con = null)
    {

        if ($this->singleCurrentAuctionPlant === null && !$this->isNew()) {
            $this->singleCurrentAuctionPlant = ChildCurrentAuctionPlantQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleCurrentAuctionPlant;
    }

    /**
     * Sets a single ChildCurrentAuctionPlant object as related to this object by a one-to-one relationship.
     *
     * @param  ChildCurrentAuctionPlant $v ChildCurrentAuctionPlant
     * @return $this|\Game The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCurrentAuctionPlant(ChildCurrentAuctionPlant $v = null)
    {
        $this->singleCurrentAuctionPlant = $v;

        // Make sure that that the passed-in ChildCurrentAuctionPlant isn't already associated with this object
        if ($v !== null && $v->getGame(null, false) === null) {
            $v->setGame($this);
        }

        return $this;
    }

    /**
     * Clears out the collPlayerAuctionActions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPlayerAuctionActions()
     */
    public function clearPlayerAuctionActions()
    {
        $this->collPlayerAuctionActions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPlayerAuctionActions collection loaded partially.
     */
    public function resetPartialPlayerAuctionActions($v = true)
    {
        $this->collPlayerAuctionActionsPartial = $v;
    }

    /**
     * Initializes the collPlayerAuctionActions collection.
     *
     * By default this just sets the collPlayerAuctionActions collection to an empty array (like clearcollPlayerAuctionActions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPlayerAuctionActions($overrideExisting = true)
    {
        if (null !== $this->collPlayerAuctionActions && !$overrideExisting) {
            return;
        }
        $this->collPlayerAuctionActions = new ObjectCollection();
        $this->collPlayerAuctionActions->setModel('\PlayerAuctionAction');
    }

    /**
     * Gets an array of ChildPlayerAuctionAction objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGame is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPlayerAuctionAction[] List of ChildPlayerAuctionAction objects
     * @throws PropelException
     */
    public function getPlayerAuctionActions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayerAuctionActionsPartial && !$this->isNew();
        if (null === $this->collPlayerAuctionActions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPlayerAuctionActions) {
                // return empty collection
                $this->initPlayerAuctionActions();
            } else {
                $collPlayerAuctionActions = ChildPlayerAuctionActionQuery::create(null, $criteria)
                    ->filterByGame($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPlayerAuctionActionsPartial && count($collPlayerAuctionActions)) {
                        $this->initPlayerAuctionActions(false);

                        foreach ($collPlayerAuctionActions as $obj) {
                            if (false == $this->collPlayerAuctionActions->contains($obj)) {
                                $this->collPlayerAuctionActions->append($obj);
                            }
                        }

                        $this->collPlayerAuctionActionsPartial = true;
                    }

                    return $collPlayerAuctionActions;
                }

                if ($partial && $this->collPlayerAuctionActions) {
                    foreach ($this->collPlayerAuctionActions as $obj) {
                        if ($obj->isNew()) {
                            $collPlayerAuctionActions[] = $obj;
                        }
                    }
                }

                $this->collPlayerAuctionActions = $collPlayerAuctionActions;
                $this->collPlayerAuctionActionsPartial = false;
            }
        }

        return $this->collPlayerAuctionActions;
    }

    /**
     * Sets a collection of ChildPlayerAuctionAction objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $playerAuctionActions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function setPlayerAuctionActions(Collection $playerAuctionActions, ConnectionInterface $con = null)
    {
        /** @var ChildPlayerAuctionAction[] $playerAuctionActionsToDelete */
        $playerAuctionActionsToDelete = $this->getPlayerAuctionActions(new Criteria(), $con)->diff($playerAuctionActions);


        $this->playerAuctionActionsScheduledForDeletion = $playerAuctionActionsToDelete;

        foreach ($playerAuctionActionsToDelete as $playerAuctionActionRemoved) {
            $playerAuctionActionRemoved->setGame(null);
        }

        $this->collPlayerAuctionActions = null;
        foreach ($playerAuctionActions as $playerAuctionAction) {
            $this->addPlayerAuctionAction($playerAuctionAction);
        }

        $this->collPlayerAuctionActions = $playerAuctionActions;
        $this->collPlayerAuctionActionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PlayerAuctionAction objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PlayerAuctionAction objects.
     * @throws PropelException
     */
    public function countPlayerAuctionActions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPlayerAuctionActionsPartial && !$this->isNew();
        if (null === $this->collPlayerAuctionActions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPlayerAuctionActions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPlayerAuctionActions());
            }

            $query = ChildPlayerAuctionActionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGame($this)
                ->count($con);
        }

        return count($this->collPlayerAuctionActions);
    }

    /**
     * Method called to associate a ChildPlayerAuctionAction object to this object
     * through the ChildPlayerAuctionAction foreign key attribute.
     *
     * @param  ChildPlayerAuctionAction $l ChildPlayerAuctionAction
     * @return $this|\Game The current object (for fluent API support)
     */
    public function addPlayerAuctionAction(ChildPlayerAuctionAction $l)
    {
        if ($this->collPlayerAuctionActions === null) {
            $this->initPlayerAuctionActions();
            $this->collPlayerAuctionActionsPartial = true;
        }

        if (!$this->collPlayerAuctionActions->contains($l)) {
            $this->doAddPlayerAuctionAction($l);
        }

        return $this;
    }

    /**
     * @param ChildPlayerAuctionAction $playerAuctionAction The ChildPlayerAuctionAction object to add.
     */
    protected function doAddPlayerAuctionAction(ChildPlayerAuctionAction $playerAuctionAction)
    {
        $this->collPlayerAuctionActions[]= $playerAuctionAction;
        $playerAuctionAction->setGame($this);
    }

    /**
     * @param  ChildPlayerAuctionAction $playerAuctionAction The ChildPlayerAuctionAction object to remove.
     * @return $this|ChildGame The current object (for fluent API support)
     */
    public function removePlayerAuctionAction(ChildPlayerAuctionAction $playerAuctionAction)
    {
        if ($this->getPlayerAuctionActions()->contains($playerAuctionAction)) {
            $pos = $this->collPlayerAuctionActions->search($playerAuctionAction);
            $this->collPlayerAuctionActions->remove($pos);
            if (null === $this->playerAuctionActionsScheduledForDeletion) {
                $this->playerAuctionActionsScheduledForDeletion = clone $this->collPlayerAuctionActions;
                $this->playerAuctionActionsScheduledForDeletion->clear();
            }
            $this->playerAuctionActionsScheduledForDeletion[]= $playerAuctionAction;
            $playerAuctionAction->setGame(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Game is new, it will return
     * an empty collection; or if this Game has previously
     * been saved, it will retrieve related PlayerAuctionActions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Game.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlayerAuctionAction[] List of ChildPlayerAuctionAction objects
     */
    public function getPlayerAuctionActionsJoinPlayer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerAuctionActionQuery::create(null, $criteria);
        $query->joinWith('Player', $joinBehavior);

        return $this->getPlayerAuctionActions($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aOwnerUser) {
            $this->aOwnerUser->removeGame($this);
        }
        if (null !== $this->aBank) {
            $this->aBank->removeGame($this);
        }
        if (null !== $this->aMap) {
            $this->aMap->removeGame($this);
        }
        if (null !== $this->aCardSet) {
            $this->aCardSet->removeGame($this);
        }
        $this->id = null;
        $this->name = null;
        $this->has_started = null;
        $this->card_limit = null;
        $this->turn_number = null;
        $this->phase_number = null;
        $this->round_number = null;
        $this->step_number = null;
        $this->owner_id = null;
        $this->bank_id = null;
        $this->map_id = null;
        $this->card_set_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collDeckCards) {
                foreach ($this->collDeckCards as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAuctionCards) {
                foreach ($this->collAuctionCards as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singleCurrentAuctionPlant) {
                $this->singleCurrentAuctionPlant->clearAllReferences($deep);
            }
            if ($this->collPlayerAuctionActions) {
                foreach ($this->collPlayerAuctionActions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPlayers = null;
        $this->collResourceStores = null;
        $this->collTurnOrders = null;
        $this->collGameCards = null;
        $this->collDeckCards = null;
        $this->collAuctionCards = null;
        $this->singleCurrentAuctionPlant = null;
        $this->collPlayerAuctionActions = null;
        $this->aOwnerUser = null;
        $this->aBank = null;
        $this->aMap = null;
        $this->aCardSet = null;
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
