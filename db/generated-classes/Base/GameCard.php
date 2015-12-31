<?php

namespace Base;

use \Card as ChildCard;
use \CardQuery as ChildCardQuery;
use \Game as ChildGame;
use \GameAuctionCard as ChildGameAuctionCard;
use \GameAuctionCardQuery as ChildGameAuctionCardQuery;
use \GameCard as ChildGameCard;
use \GameCardQuery as ChildGameCardQuery;
use \GameDeckCard as ChildGameDeckCard;
use \GameDeckCardQuery as ChildGameDeckCardQuery;
use \GameQuery as ChildGameQuery;
use \PlayerCard as ChildPlayerCard;
use \PlayerCardQuery as ChildPlayerCardQuery;
use \Exception;
use \PDO;
use Map\GameCardTableMap;
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
 * Base class that represents a row from the 'game_card' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class GameCard implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\GameCardTableMap';


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
     * The value for the card_id field.
     * @var        int
     */
    protected $card_id;

    /**
     * The value for the game_id field.
     * @var        int
     */
    protected $game_id;

    /**
     * @var        ChildGame
     */
    protected $aGame;

    /**
     * @var        ChildCard
     */
    protected $aCard;

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
     * @var        ObjectCollection|ChildPlayerCard[] Collection to store aggregation of ChildPlayerCard objects.
     */
    protected $collPlayerCards;
    protected $collPlayerCardsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

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
     * @var ObjectCollection|ChildPlayerCard[]
     */
    protected $playerCardsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\GameCard object.
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
     * Compares this with another <code>GameCard</code> instance.  If
     * <code>obj</code> is an instance of <code>GameCard</code>, delegates to
     * <code>equals(GameCard)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|GameCard The current object, for fluid interface
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
     * Get the [card_id] column value.
     *
     * @return int
     */
    public function getCardId()
    {
        return $this->card_id;
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\GameCard The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[GameCardTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [card_id] column.
     *
     * @param int $v new value
     * @return $this|\GameCard The current object (for fluent API support)
     */
    public function setCardId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->card_id !== $v) {
            $this->card_id = $v;
            $this->modifiedColumns[GameCardTableMap::COL_CARD_ID] = true;
        }

        if ($this->aCard !== null && $this->aCard->getId() !== $v) {
            $this->aCard = null;
        }

        return $this;
    } // setCardId()

    /**
     * Set the value of [game_id] column.
     *
     * @param int $v new value
     * @return $this|\GameCard The current object (for fluent API support)
     */
    public function setGameId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->game_id !== $v) {
            $this->game_id = $v;
            $this->modifiedColumns[GameCardTableMap::COL_GAME_ID] = true;
        }

        if ($this->aGame !== null && $this->aGame->getId() !== $v) {
            $this->aGame = null;
        }

        return $this;
    } // setGameId()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : GameCardTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : GameCardTableMap::translateFieldName('CardId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->card_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : GameCardTableMap::translateFieldName('GameId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->game_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = GameCardTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\GameCard'), 0, $e);
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
        if ($this->aCard !== null && $this->card_id !== $this->aCard->getId()) {
            $this->aCard = null;
        }
        if ($this->aGame !== null && $this->game_id !== $this->aGame->getId()) {
            $this->aGame = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(GameCardTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildGameCardQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aGame = null;
            $this->aCard = null;
            $this->collDeckCards = null;

            $this->collAuctionCards = null;

            $this->collPlayerCards = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see GameCard::setDeleted()
     * @see GameCard::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GameCardTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildGameCardQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(GameCardTableMap::DATABASE_NAME);
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
                GameCardTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[GameCardTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GameCardTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GameCardTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(GameCardTableMap::COL_CARD_ID)) {
            $modifiedColumns[':p' . $index++]  = 'card_id';
        }
        if ($this->isColumnModified(GameCardTableMap::COL_GAME_ID)) {
            $modifiedColumns[':p' . $index++]  = 'game_id';
        }

        $sql = sprintf(
            'INSERT INTO game_card (%s) VALUES (%s)',
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
                    case 'card_id':
                        $stmt->bindValue($identifier, $this->card_id, PDO::PARAM_INT);
                        break;
                    case 'game_id':
                        $stmt->bindValue($identifier, $this->game_id, PDO::PARAM_INT);
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
        $pos = GameCardTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCardId();
                break;
            case 2:
                return $this->getGameId();
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

        if (isset($alreadyDumpedObjects['GameCard'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['GameCard'][$this->hashCode()] = true;
        $keys = GameCardTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCardId(),
            $keys[2] => $this->getGameId(),
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
                        $key = 'card';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'card';
                        break;
                    default:
                        $key = 'Card';
                }

                $result[$key] = $this->aCard->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\GameCard
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GameCardTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\GameCard
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCardId($value);
                break;
            case 2:
                $this->setGameId($value);
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
        $keys = GameCardTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCardId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setGameId($arr[$keys[2]]);
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
     * @return $this|\GameCard The current object, for fluid interface
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
        $criteria = new Criteria(GameCardTableMap::DATABASE_NAME);

        if ($this->isColumnModified(GameCardTableMap::COL_ID)) {
            $criteria->add(GameCardTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(GameCardTableMap::COL_CARD_ID)) {
            $criteria->add(GameCardTableMap::COL_CARD_ID, $this->card_id);
        }
        if ($this->isColumnModified(GameCardTableMap::COL_GAME_ID)) {
            $criteria->add(GameCardTableMap::COL_GAME_ID, $this->game_id);
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
        $criteria = ChildGameCardQuery::create();
        $criteria->add(GameCardTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \GameCard (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCardId($this->getCardId());
        $copyObj->setGameId($this->getGameId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

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

            foreach ($this->getPlayerCards() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlayerCard($relObj->copy($deepCopy));
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
     * @return \GameCard Clone of current object.
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
     * @return $this|\GameCard The current object (for fluent API support)
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

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildGame object, it will not be re-added.
        if ($v !== null) {
            $v->addGameCard($this);
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
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aGame->addGameCards($this);
             */
        }

        return $this->aGame;
    }

    /**
     * Declares an association between this object and a ChildCard object.
     *
     * @param  ChildCard $v
     * @return $this|\GameCard The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCard(ChildCard $v = null)
    {
        if ($v === null) {
            $this->setCardId(NULL);
        } else {
            $this->setCardId($v->getId());
        }

        $this->aCard = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCard object, it will not be re-added.
        if ($v !== null) {
            $v->addGameCard($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCard object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCard The associated ChildCard object.
     * @throws PropelException
     */
    public function getCard(ConnectionInterface $con = null)
    {
        if ($this->aCard === null && ($this->card_id !== null)) {
            $this->aCard = ChildCardQuery::create()->findPk($this->card_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCard->addGameCards($this);
             */
        }

        return $this->aCard;
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
        if ('DeckCard' == $relationName) {
            return $this->initDeckCards();
        }
        if ('AuctionCard' == $relationName) {
            return $this->initAuctionCards();
        }
        if ('PlayerCard' == $relationName) {
            return $this->initPlayerCards();
        }
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
     * If this ChildGameCard is new, it will return
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
                    ->filterByGameCard($this)
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
     * @return $this|ChildGameCard The current object (for fluent API support)
     */
    public function setDeckCards(Collection $deckCards, ConnectionInterface $con = null)
    {
        /** @var ChildGameDeckCard[] $deckCardsToDelete */
        $deckCardsToDelete = $this->getDeckCards(new Criteria(), $con)->diff($deckCards);


        $this->deckCardsScheduledForDeletion = $deckCardsToDelete;

        foreach ($deckCardsToDelete as $deckCardRemoved) {
            $deckCardRemoved->setGameCard(null);
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
                ->filterByGameCard($this)
                ->count($con);
        }

        return count($this->collDeckCards);
    }

    /**
     * Method called to associate a ChildGameDeckCard object to this object
     * through the ChildGameDeckCard foreign key attribute.
     *
     * @param  ChildGameDeckCard $l ChildGameDeckCard
     * @return $this|\GameCard The current object (for fluent API support)
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
        $deckCard->setGameCard($this);
    }

    /**
     * @param  ChildGameDeckCard $deckCard The ChildGameDeckCard object to remove.
     * @return $this|ChildGameCard The current object (for fluent API support)
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
            $deckCard->setGameCard(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this GameCard is new, it will return
     * an empty collection; or if this GameCard has previously
     * been saved, it will retrieve related DeckCards from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in GameCard.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGameDeckCard[] List of ChildGameDeckCard objects
     */
    public function getDeckCardsJoinGame(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameDeckCardQuery::create(null, $criteria);
        $query->joinWith('Game', $joinBehavior);

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
     * If this ChildGameCard is new, it will return
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
                    ->filterByGameCard($this)
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
     * @return $this|ChildGameCard The current object (for fluent API support)
     */
    public function setAuctionCards(Collection $auctionCards, ConnectionInterface $con = null)
    {
        /** @var ChildGameAuctionCard[] $auctionCardsToDelete */
        $auctionCardsToDelete = $this->getAuctionCards(new Criteria(), $con)->diff($auctionCards);


        $this->auctionCardsScheduledForDeletion = $auctionCardsToDelete;

        foreach ($auctionCardsToDelete as $auctionCardRemoved) {
            $auctionCardRemoved->setGameCard(null);
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
                ->filterByGameCard($this)
                ->count($con);
        }

        return count($this->collAuctionCards);
    }

    /**
     * Method called to associate a ChildGameAuctionCard object to this object
     * through the ChildGameAuctionCard foreign key attribute.
     *
     * @param  ChildGameAuctionCard $l ChildGameAuctionCard
     * @return $this|\GameCard The current object (for fluent API support)
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
        $auctionCard->setGameCard($this);
    }

    /**
     * @param  ChildGameAuctionCard $auctionCard The ChildGameAuctionCard object to remove.
     * @return $this|ChildGameCard The current object (for fluent API support)
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
            $auctionCard->setGameCard(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this GameCard is new, it will return
     * an empty collection; or if this GameCard has previously
     * been saved, it will retrieve related AuctionCards from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in GameCard.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGameAuctionCard[] List of ChildGameAuctionCard objects
     */
    public function getAuctionCardsJoinGame(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameAuctionCardQuery::create(null, $criteria);
        $query->joinWith('Game', $joinBehavior);

        return $this->getAuctionCards($query, $con);
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
     * If this ChildGameCard is new, it will return
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
                    ->filterByCard($this)
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
     * @return $this|ChildGameCard The current object (for fluent API support)
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
            $playerCardRemoved->setCard(null);
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
                ->filterByCard($this)
                ->count($con);
        }

        return count($this->collPlayerCards);
    }

    /**
     * Method called to associate a ChildPlayerCard object to this object
     * through the ChildPlayerCard foreign key attribute.
     *
     * @param  ChildPlayerCard $l ChildPlayerCard
     * @return $this|\GameCard The current object (for fluent API support)
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
        $playerCard->setCard($this);
    }

    /**
     * @param  ChildPlayerCard $playerCard The ChildPlayerCard object to remove.
     * @return $this|ChildGameCard The current object (for fluent API support)
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
            $playerCard->setCard(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this GameCard is new, it will return
     * an empty collection; or if this GameCard has previously
     * been saved, it will retrieve related PlayerCards from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in GameCard.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlayerCard[] List of ChildPlayerCard objects
     */
    public function getPlayerCardsJoinPlayer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerCardQuery::create(null, $criteria);
        $query->joinWith('Player', $joinBehavior);

        return $this->getPlayerCards($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aGame) {
            $this->aGame->removeGameCard($this);
        }
        if (null !== $this->aCard) {
            $this->aCard->removeGameCard($this);
        }
        $this->id = null;
        $this->card_id = null;
        $this->game_id = null;
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
            if ($this->collPlayerCards) {
                foreach ($this->collPlayerCards as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDeckCards = null;
        $this->collAuctionCards = null;
        $this->collPlayerCards = null;
        $this->aGame = null;
        $this->aCard = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GameCardTableMap::DEFAULT_STRING_FORMAT);
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
