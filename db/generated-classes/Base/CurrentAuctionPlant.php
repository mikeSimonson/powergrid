<?php

namespace Base;

use \CurrentAuctionPlantQuery as ChildCurrentAuctionPlantQuery;
use \Game as ChildGame;
use \GameAuctionCard as ChildGameAuctionCard;
use \GameAuctionCardQuery as ChildGameAuctionCardQuery;
use \GameQuery as ChildGameQuery;
use \Player as ChildPlayer;
use \PlayerQuery as ChildPlayerQuery;
use \Exception;
use \PDO;
use Map\CurrentAuctionPlantTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'current_auction_plant' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class CurrentAuctionPlant implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\CurrentAuctionPlantTableMap';


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
     * The value for the game_id field.
     * @var        int
     */
    protected $game_id;

    /**
     * The value for the card_id field.
     * @var        int
     */
    protected $card_id;

    /**
     * The value for the highest_bid field.
     * @var        int
     */
    protected $highest_bid;

    /**
     * The value for the highest_bidder_id field.
     * @var        int
     */
    protected $highest_bidder_id;

    /**
     * The value for the round_number field.
     * @var        int
     */
    protected $round_number;

    /**
     * @var        ChildGame
     */
    protected $aGame;

    /**
     * @var        ChildGameAuctionCard
     */
    protected $aCard;

    /**
     * @var        ChildPlayer
     */
    protected $aHighestBidder;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\CurrentAuctionPlant object.
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
     * Compares this with another <code>CurrentAuctionPlant</code> instance.  If
     * <code>obj</code> is an instance of <code>CurrentAuctionPlant</code>, delegates to
     * <code>equals(CurrentAuctionPlant)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|CurrentAuctionPlant The current object, for fluid interface
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
     * Get the [game_id] column value.
     *
     * @return int
     */
    public function getGameId()
    {
        return $this->game_id;
    }

    /**
     * Get the [card_id] column value.
     *
     * @return int
     */
    public function getCardId()
    {
        return $this->card_id;
    }

    /**
     * Get the [highest_bid] column value.
     *
     * @return int
     */
    public function getHighestBid()
    {
        return $this->highest_bid;
    }

    /**
     * Get the [highest_bidder_id] column value.
     *
     * @return int
     */
    public function getHighestBidderId()
    {
        return $this->highest_bidder_id;
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
     * Set the value of [game_id] column.
     *
     * @param int $v new value
     * @return $this|\CurrentAuctionPlant The current object (for fluent API support)
     */
    public function setGameId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->game_id !== $v) {
            $this->game_id = $v;
            $this->modifiedColumns[CurrentAuctionPlantTableMap::COL_GAME_ID] = true;
        }

        if ($this->aGame !== null && $this->aGame->getId() !== $v) {
            $this->aGame = null;
        }

        return $this;
    } // setGameId()

    /**
     * Set the value of [card_id] column.
     *
     * @param int $v new value
     * @return $this|\CurrentAuctionPlant The current object (for fluent API support)
     */
    public function setCardId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->card_id !== $v) {
            $this->card_id = $v;
            $this->modifiedColumns[CurrentAuctionPlantTableMap::COL_CARD_ID] = true;
        }

        if ($this->aCard !== null && $this->aCard->getId() !== $v) {
            $this->aCard = null;
        }

        return $this;
    } // setCardId()

    /**
     * Set the value of [highest_bid] column.
     *
     * @param int $v new value
     * @return $this|\CurrentAuctionPlant The current object (for fluent API support)
     */
    public function setHighestBid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->highest_bid !== $v) {
            $this->highest_bid = $v;
            $this->modifiedColumns[CurrentAuctionPlantTableMap::COL_HIGHEST_BID] = true;
        }

        return $this;
    } // setHighestBid()

    /**
     * Set the value of [highest_bidder_id] column.
     *
     * @param int $v new value
     * @return $this|\CurrentAuctionPlant The current object (for fluent API support)
     */
    public function setHighestBidderId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->highest_bidder_id !== $v) {
            $this->highest_bidder_id = $v;
            $this->modifiedColumns[CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID] = true;
        }

        if ($this->aHighestBidder !== null && $this->aHighestBidder->getId() !== $v) {
            $this->aHighestBidder = null;
        }

        return $this;
    } // setHighestBidderId()

    /**
     * Set the value of [round_number] column.
     *
     * @param int $v new value
     * @return $this|\CurrentAuctionPlant The current object (for fluent API support)
     */
    public function setRoundNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->round_number !== $v) {
            $this->round_number = $v;
            $this->modifiedColumns[CurrentAuctionPlantTableMap::COL_ROUND_NUMBER] = true;
        }

        return $this;
    } // setRoundNumber()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CurrentAuctionPlantTableMap::translateFieldName('GameId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->game_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CurrentAuctionPlantTableMap::translateFieldName('CardId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->card_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CurrentAuctionPlantTableMap::translateFieldName('HighestBid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->highest_bid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CurrentAuctionPlantTableMap::translateFieldName('HighestBidderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->highest_bidder_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CurrentAuctionPlantTableMap::translateFieldName('RoundNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->round_number = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = CurrentAuctionPlantTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\CurrentAuctionPlant'), 0, $e);
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
        if ($this->aGame !== null && $this->game_id !== $this->aGame->getId()) {
            $this->aGame = null;
        }
        if ($this->aCard !== null && $this->card_id !== $this->aCard->getId()) {
            $this->aCard = null;
        }
        if ($this->aHighestBidder !== null && $this->highest_bidder_id !== $this->aHighestBidder->getId()) {
            $this->aHighestBidder = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(CurrentAuctionPlantTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCurrentAuctionPlantQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aGame = null;
            $this->aCard = null;
            $this->aHighestBidder = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see CurrentAuctionPlant::setDeleted()
     * @see CurrentAuctionPlant::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CurrentAuctionPlantTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCurrentAuctionPlantQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CurrentAuctionPlantTableMap::DATABASE_NAME);
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
                CurrentAuctionPlantTableMap::addInstanceToPool($this);
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

            if ($this->aGame !== null) {
                if ($this->aGame->isModified() || $this->aGame->isNew()) {
                    $affectedRows += $this->aGame->save($con);
                }
                $this->setGame($this->aGame);
            }

            if ($this->aCard !== null) {
                if ($this->aCard->isModified() || $this->aCard->isNew()) {
                    $affectedRows += $this->aCard->save($con);
                }
                $this->setCard($this->aCard);
            }

            if ($this->aHighestBidder !== null) {
                if ($this->aHighestBidder->isModified() || $this->aHighestBidder->isNew()) {
                    $affectedRows += $this->aHighestBidder->save($con);
                }
                $this->setHighestBidder($this->aHighestBidder);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CurrentAuctionPlantTableMap::COL_GAME_ID)) {
            $modifiedColumns[':p' . $index++]  = 'game_id';
        }
        if ($this->isColumnModified(CurrentAuctionPlantTableMap::COL_CARD_ID)) {
            $modifiedColumns[':p' . $index++]  = 'card_id';
        }
        if ($this->isColumnModified(CurrentAuctionPlantTableMap::COL_HIGHEST_BID)) {
            $modifiedColumns[':p' . $index++]  = 'highest_bid';
        }
        if ($this->isColumnModified(CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'highest_bidder_id';
        }
        if ($this->isColumnModified(CurrentAuctionPlantTableMap::COL_ROUND_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'round_number';
        }

        $sql = sprintf(
            'INSERT INTO current_auction_plant (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'game_id':
                        $stmt->bindValue($identifier, $this->game_id, PDO::PARAM_INT);
                        break;
                    case 'card_id':
                        $stmt->bindValue($identifier, $this->card_id, PDO::PARAM_INT);
                        break;
                    case 'highest_bid':
                        $stmt->bindValue($identifier, $this->highest_bid, PDO::PARAM_INT);
                        break;
                    case 'highest_bidder_id':
                        $stmt->bindValue($identifier, $this->highest_bidder_id, PDO::PARAM_INT);
                        break;
                    case 'round_number':
                        $stmt->bindValue($identifier, $this->round_number, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = CurrentAuctionPlantTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getGameId();
                break;
            case 1:
                return $this->getCardId();
                break;
            case 2:
                return $this->getHighestBid();
                break;
            case 3:
                return $this->getHighestBidderId();
                break;
            case 4:
                return $this->getRoundNumber();
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

        if (isset($alreadyDumpedObjects['CurrentAuctionPlant'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CurrentAuctionPlant'][$this->hashCode()] = true;
        $keys = CurrentAuctionPlantTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getGameId(),
            $keys[1] => $this->getCardId(),
            $keys[2] => $this->getHighestBid(),
            $keys[3] => $this->getHighestBidderId(),
            $keys[4] => $this->getRoundNumber(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aGame) {

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

                $result[$key] = $this->aGame->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCard) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gameAuctionCard';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'game_auction_card';
                        break;
                    default:
                        $key = 'GameAuctionCard';
                }

                $result[$key] = $this->aCard->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aHighestBidder) {

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

                $result[$key] = $this->aHighestBidder->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\CurrentAuctionPlant
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CurrentAuctionPlantTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\CurrentAuctionPlant
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setGameId($value);
                break;
            case 1:
                $this->setCardId($value);
                break;
            case 2:
                $this->setHighestBid($value);
                break;
            case 3:
                $this->setHighestBidderId($value);
                break;
            case 4:
                $this->setRoundNumber($value);
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
        $keys = CurrentAuctionPlantTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setGameId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCardId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setHighestBid($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setHighestBidderId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setRoundNumber($arr[$keys[4]]);
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
     * @return $this|\CurrentAuctionPlant The current object, for fluid interface
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
        $criteria = new Criteria(CurrentAuctionPlantTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CurrentAuctionPlantTableMap::COL_GAME_ID)) {
            $criteria->add(CurrentAuctionPlantTableMap::COL_GAME_ID, $this->game_id);
        }
        if ($this->isColumnModified(CurrentAuctionPlantTableMap::COL_CARD_ID)) {
            $criteria->add(CurrentAuctionPlantTableMap::COL_CARD_ID, $this->card_id);
        }
        if ($this->isColumnModified(CurrentAuctionPlantTableMap::COL_HIGHEST_BID)) {
            $criteria->add(CurrentAuctionPlantTableMap::COL_HIGHEST_BID, $this->highest_bid);
        }
        if ($this->isColumnModified(CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID)) {
            $criteria->add(CurrentAuctionPlantTableMap::COL_HIGHEST_BIDDER_ID, $this->highest_bidder_id);
        }
        if ($this->isColumnModified(CurrentAuctionPlantTableMap::COL_ROUND_NUMBER)) {
            $criteria->add(CurrentAuctionPlantTableMap::COL_ROUND_NUMBER, $this->round_number);
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
        $criteria = ChildCurrentAuctionPlantQuery::create();
        $criteria->add(CurrentAuctionPlantTableMap::COL_GAME_ID, $this->game_id);

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
        $validPk = null !== $this->getGameId();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation current_auction_plant_fk_3cbcd5 to table game
        if ($this->aGame && $hash = spl_object_hash($this->aGame)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

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
        return $this->getGameId();
    }

    /**
     * Generic method to set the primary key (game_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setGameId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getGameId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \CurrentAuctionPlant (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setGameId($this->getGameId());
        $copyObj->setCardId($this->getCardId());
        $copyObj->setHighestBid($this->getHighestBid());
        $copyObj->setHighestBidderId($this->getHighestBidderId());
        $copyObj->setRoundNumber($this->getRoundNumber());
        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \CurrentAuctionPlant Clone of current object.
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
     * Declares an association between this object and a ChildGame object.
     *
     * @param  ChildGame $v
     * @return $this|\CurrentAuctionPlant The current object (for fluent API support)
     * @throws PropelException
     */
    public function setGame(ChildGame $v = null)
    {
        if ($v === null) {
            $this->setGameId(NULL);
        } else {
            $this->setGameId($v->getId());
        }

        $this->aGame = $v;

        // Add binding for other direction of this 1:1 relationship.
        if ($v !== null) {
            $v->setCurrentAuctionPlant($this);
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
    public function getGame(ConnectionInterface $con = null)
    {
        if ($this->aGame === null && ($this->game_id !== null)) {
            $this->aGame = ChildGameQuery::create()->findPk($this->game_id, $con);
            // Because this foreign key represents a one-to-one relationship, we will create a bi-directional association.
            $this->aGame->setCurrentAuctionPlant($this);
        }

        return $this->aGame;
    }

    /**
     * Declares an association between this object and a ChildGameAuctionCard object.
     *
     * @param  ChildGameAuctionCard $v
     * @return $this|\CurrentAuctionPlant The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCard(ChildGameAuctionCard $v = null)
    {
        if ($v === null) {
            $this->setCardId(NULL);
        } else {
            $this->setCardId($v->getId());
        }

        $this->aCard = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildGameAuctionCard object, it will not be re-added.
        if ($v !== null) {
            $v->addCurrentAuctionPlant($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildGameAuctionCard object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildGameAuctionCard The associated ChildGameAuctionCard object.
     * @throws PropelException
     */
    public function getCard(ConnectionInterface $con = null)
    {
        if ($this->aCard === null && ($this->card_id !== null)) {
            $this->aCard = ChildGameAuctionCardQuery::create()->findPk($this->card_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCard->addCurrentAuctionPlants($this);
             */
        }

        return $this->aCard;
    }

    /**
     * Declares an association between this object and a ChildPlayer object.
     *
     * @param  ChildPlayer $v
     * @return $this|\CurrentAuctionPlant The current object (for fluent API support)
     * @throws PropelException
     */
    public function setHighestBidder(ChildPlayer $v = null)
    {
        if ($v === null) {
            $this->setHighestBidderId(NULL);
        } else {
            $this->setHighestBidderId($v->getId());
        }

        $this->aHighestBidder = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPlayer object, it will not be re-added.
        if ($v !== null) {
            $v->addCurrentAuctionPlant($this);
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
    public function getHighestBidder(ConnectionInterface $con = null)
    {
        if ($this->aHighestBidder === null && ($this->highest_bidder_id !== null)) {
            $this->aHighestBidder = ChildPlayerQuery::create()->findPk($this->highest_bidder_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aHighestBidder->addCurrentAuctionPlants($this);
             */
        }

        return $this->aHighestBidder;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aGame) {
            $this->aGame->removeCurrentAuctionPlant($this);
        }
        if (null !== $this->aCard) {
            $this->aCard->removeCurrentAuctionPlant($this);
        }
        if (null !== $this->aHighestBidder) {
            $this->aHighestBidder->removeCurrentAuctionPlant($this);
        }
        $this->game_id = null;
        $this->card_id = null;
        $this->highest_bid = null;
        $this->highest_bidder_id = null;
        $this->round_number = null;
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
        } // if ($deep)

        $this->aGame = null;
        $this->aCard = null;
        $this->aHighestBidder = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CurrentAuctionPlantTableMap::DEFAULT_STRING_FORMAT);
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
