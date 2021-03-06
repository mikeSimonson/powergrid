<?php

namespace Base;

use \City as ChildCity;
use \CityConnection as ChildCityConnection;
use \CityConnectionQuery as ChildCityConnectionQuery;
use \CityQuery as ChildCityQuery;
use \Game as ChildGame;
use \GameQuery as ChildGameQuery;
use \Map as ChildMap;
use \MapQuery as ChildMapQuery;
use \Exception;
use \PDO;
use Map\MapTableMap;
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
 * Base class that represents a row from the 'map' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Map implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\MapTableMap';


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
     * @var        ObjectCollection|ChildGame[] Collection to store aggregation of ChildGame objects.
     */
    protected $collGames;
    protected $collGamesPartial;

    /**
     * @var        ObjectCollection|ChildCity[] Collection to store aggregation of ChildCity objects.
     */
    protected $collCities;
    protected $collCitiesPartial;

    /**
     * @var        ObjectCollection|ChildCityConnection[] Collection to store aggregation of ChildCityConnection objects.
     */
    protected $collCityConnections;
    protected $collCityConnectionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGame[]
     */
    protected $gamesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCity[]
     */
    protected $citiesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCityConnection[]
     */
    protected $cityConnectionsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Map object.
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
     * Compares this with another <code>Map</code> instance.  If
     * <code>obj</code> is an instance of <code>Map</code>, delegates to
     * <code>equals(Map)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Map The current object, for fluid interface
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Map The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[MapTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Map The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[MapTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MapTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MapTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = MapTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Map'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(MapTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMapQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collGames = null;

            $this->collCities = null;

            $this->collCityConnections = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Map::setDeleted()
     * @see Map::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MapTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildMapQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(MapTableMap::DATABASE_NAME);
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
                MapTableMap::addInstanceToPool($this);
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

            if ($this->gamesScheduledForDeletion !== null) {
                if (!$this->gamesScheduledForDeletion->isEmpty()) {
                    foreach ($this->gamesScheduledForDeletion as $game) {
                        // need to save related object because we set the relation to null
                        $game->save($con);
                    }
                    $this->gamesScheduledForDeletion = null;
                }
            }

            if ($this->collGames !== null) {
                foreach ($this->collGames as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->citiesScheduledForDeletion !== null) {
                if (!$this->citiesScheduledForDeletion->isEmpty()) {
                    foreach ($this->citiesScheduledForDeletion as $city) {
                        // need to save related object because we set the relation to null
                        $city->save($con);
                    }
                    $this->citiesScheduledForDeletion = null;
                }
            }

            if ($this->collCities !== null) {
                foreach ($this->collCities as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cityConnectionsScheduledForDeletion !== null) {
                if (!$this->cityConnectionsScheduledForDeletion->isEmpty()) {
                    foreach ($this->cityConnectionsScheduledForDeletion as $cityConnection) {
                        // need to save related object because we set the relation to null
                        $cityConnection->save($con);
                    }
                    $this->cityConnectionsScheduledForDeletion = null;
                }
            }

            if ($this->collCityConnections !== null) {
                foreach ($this->collCityConnections as $referrerFK) {
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

        $this->modifiedColumns[MapTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MapTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MapTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(MapTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }

        $sql = sprintf(
            'INSERT INTO map (%s) VALUES (%s)',
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
        $pos = MapTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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

        if (isset($alreadyDumpedObjects['Map'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Map'][$this->hashCode()] = true;
        $keys = MapTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collGames) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'games';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'games';
                        break;
                    default:
                        $key = 'Games';
                }

                $result[$key] = $this->collGames->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCities) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cities';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'cities';
                        break;
                    default:
                        $key = 'Cities';
                }

                $result[$key] = $this->collCities->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCityConnections) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cityConnections';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'city_connections';
                        break;
                    default:
                        $key = 'CityConnections';
                }

                $result[$key] = $this->collCityConnections->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Map
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MapTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Map
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
        $keys = MapTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
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
     * @return $this|\Map The current object, for fluid interface
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
        $criteria = new Criteria(MapTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MapTableMap::COL_ID)) {
            $criteria->add(MapTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(MapTableMap::COL_NAME)) {
            $criteria->add(MapTableMap::COL_NAME, $this->name);
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
        $criteria = ChildMapQuery::create();
        $criteria->add(MapTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Map (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getGames() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGame($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCities() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCity($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCityConnections() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCityConnection($relObj->copy($deepCopy));
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
     * @return \Map Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Game' == $relationName) {
            return $this->initGames();
        }
        if ('City' == $relationName) {
            return $this->initCities();
        }
        if ('CityConnection' == $relationName) {
            return $this->initCityConnections();
        }
    }

    /**
     * Clears out the collGames collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGames()
     */
    public function clearGames()
    {
        $this->collGames = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGames collection loaded partially.
     */
    public function resetPartialGames($v = true)
    {
        $this->collGamesPartial = $v;
    }

    /**
     * Initializes the collGames collection.
     *
     * By default this just sets the collGames collection to an empty array (like clearcollGames());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGames($overrideExisting = true)
    {
        if (null !== $this->collGames && !$overrideExisting) {
            return;
        }
        $this->collGames = new ObjectCollection();
        $this->collGames->setModel('\Game');
    }

    /**
     * Gets an array of ChildGame objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMap is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGame[] List of ChildGame objects
     * @throws PropelException
     */
    public function getGames(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGamesPartial && !$this->isNew();
        if (null === $this->collGames || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGames) {
                // return empty collection
                $this->initGames();
            } else {
                $collGames = ChildGameQuery::create(null, $criteria)
                    ->filterByMap($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGamesPartial && count($collGames)) {
                        $this->initGames(false);

                        foreach ($collGames as $obj) {
                            if (false == $this->collGames->contains($obj)) {
                                $this->collGames->append($obj);
                            }
                        }

                        $this->collGamesPartial = true;
                    }

                    return $collGames;
                }

                if ($partial && $this->collGames) {
                    foreach ($this->collGames as $obj) {
                        if ($obj->isNew()) {
                            $collGames[] = $obj;
                        }
                    }
                }

                $this->collGames = $collGames;
                $this->collGamesPartial = false;
            }
        }

        return $this->collGames;
    }

    /**
     * Sets a collection of ChildGame objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $games A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMap The current object (for fluent API support)
     */
    public function setGames(Collection $games, ConnectionInterface $con = null)
    {
        /** @var ChildGame[] $gamesToDelete */
        $gamesToDelete = $this->getGames(new Criteria(), $con)->diff($games);


        $this->gamesScheduledForDeletion = $gamesToDelete;

        foreach ($gamesToDelete as $gameRemoved) {
            $gameRemoved->setMap(null);
        }

        $this->collGames = null;
        foreach ($games as $game) {
            $this->addGame($game);
        }

        $this->collGames = $games;
        $this->collGamesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Game objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Game objects.
     * @throws PropelException
     */
    public function countGames(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGamesPartial && !$this->isNew();
        if (null === $this->collGames || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGames) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGames());
            }

            $query = ChildGameQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMap($this)
                ->count($con);
        }

        return count($this->collGames);
    }

    /**
     * Method called to associate a ChildGame object to this object
     * through the ChildGame foreign key attribute.
     *
     * @param  ChildGame $l ChildGame
     * @return $this|\Map The current object (for fluent API support)
     */
    public function addGame(ChildGame $l)
    {
        if ($this->collGames === null) {
            $this->initGames();
            $this->collGamesPartial = true;
        }

        if (!$this->collGames->contains($l)) {
            $this->doAddGame($l);
        }

        return $this;
    }

    /**
     * @param ChildGame $game The ChildGame object to add.
     */
    protected function doAddGame(ChildGame $game)
    {
        $this->collGames[]= $game;
        $game->setMap($this);
    }

    /**
     * @param  ChildGame $game The ChildGame object to remove.
     * @return $this|ChildMap The current object (for fluent API support)
     */
    public function removeGame(ChildGame $game)
    {
        if ($this->getGames()->contains($game)) {
            $pos = $this->collGames->search($game);
            $this->collGames->remove($pos);
            if (null === $this->gamesScheduledForDeletion) {
                $this->gamesScheduledForDeletion = clone $this->collGames;
                $this->gamesScheduledForDeletion->clear();
            }
            $this->gamesScheduledForDeletion[]= $game;
            $game->setMap(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Map is new, it will return
     * an empty collection; or if this Map has previously
     * been saved, it will retrieve related Games from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Map.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGame[] List of ChildGame objects
     */
    public function getGamesJoinOwnerUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameQuery::create(null, $criteria);
        $query->joinWith('OwnerUser', $joinBehavior);

        return $this->getGames($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Map is new, it will return
     * an empty collection; or if this Map has previously
     * been saved, it will retrieve related Games from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Map.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGame[] List of ChildGame objects
     */
    public function getGamesJoinBank(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameQuery::create(null, $criteria);
        $query->joinWith('Bank', $joinBehavior);

        return $this->getGames($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Map is new, it will return
     * an empty collection; or if this Map has previously
     * been saved, it will retrieve related Games from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Map.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGame[] List of ChildGame objects
     */
    public function getGamesJoinCardSet(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameQuery::create(null, $criteria);
        $query->joinWith('CardSet', $joinBehavior);

        return $this->getGames($query, $con);
    }

    /**
     * Clears out the collCities collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCities()
     */
    public function clearCities()
    {
        $this->collCities = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCities collection loaded partially.
     */
    public function resetPartialCities($v = true)
    {
        $this->collCitiesPartial = $v;
    }

    /**
     * Initializes the collCities collection.
     *
     * By default this just sets the collCities collection to an empty array (like clearcollCities());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCities($overrideExisting = true)
    {
        if (null !== $this->collCities && !$overrideExisting) {
            return;
        }
        $this->collCities = new ObjectCollection();
        $this->collCities->setModel('\City');
    }

    /**
     * Gets an array of ChildCity objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMap is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCity[] List of ChildCity objects
     * @throws PropelException
     */
    public function getCities(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCitiesPartial && !$this->isNew();
        if (null === $this->collCities || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCities) {
                // return empty collection
                $this->initCities();
            } else {
                $collCities = ChildCityQuery::create(null, $criteria)
                    ->filterByMap($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCitiesPartial && count($collCities)) {
                        $this->initCities(false);

                        foreach ($collCities as $obj) {
                            if (false == $this->collCities->contains($obj)) {
                                $this->collCities->append($obj);
                            }
                        }

                        $this->collCitiesPartial = true;
                    }

                    return $collCities;
                }

                if ($partial && $this->collCities) {
                    foreach ($this->collCities as $obj) {
                        if ($obj->isNew()) {
                            $collCities[] = $obj;
                        }
                    }
                }

                $this->collCities = $collCities;
                $this->collCitiesPartial = false;
            }
        }

        return $this->collCities;
    }

    /**
     * Sets a collection of ChildCity objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $cities A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMap The current object (for fluent API support)
     */
    public function setCities(Collection $cities, ConnectionInterface $con = null)
    {
        /** @var ChildCity[] $citiesToDelete */
        $citiesToDelete = $this->getCities(new Criteria(), $con)->diff($cities);


        $this->citiesScheduledForDeletion = $citiesToDelete;

        foreach ($citiesToDelete as $cityRemoved) {
            $cityRemoved->setMap(null);
        }

        $this->collCities = null;
        foreach ($cities as $city) {
            $this->addCity($city);
        }

        $this->collCities = $cities;
        $this->collCitiesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related City objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related City objects.
     * @throws PropelException
     */
    public function countCities(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCitiesPartial && !$this->isNew();
        if (null === $this->collCities || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCities) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCities());
            }

            $query = ChildCityQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMap($this)
                ->count($con);
        }

        return count($this->collCities);
    }

    /**
     * Method called to associate a ChildCity object to this object
     * through the ChildCity foreign key attribute.
     *
     * @param  ChildCity $l ChildCity
     * @return $this|\Map The current object (for fluent API support)
     */
    public function addCity(ChildCity $l)
    {
        if ($this->collCities === null) {
            $this->initCities();
            $this->collCitiesPartial = true;
        }

        if (!$this->collCities->contains($l)) {
            $this->doAddCity($l);
        }

        return $this;
    }

    /**
     * @param ChildCity $city The ChildCity object to add.
     */
    protected function doAddCity(ChildCity $city)
    {
        $this->collCities[]= $city;
        $city->setMap($this);
    }

    /**
     * @param  ChildCity $city The ChildCity object to remove.
     * @return $this|ChildMap The current object (for fluent API support)
     */
    public function removeCity(ChildCity $city)
    {
        if ($this->getCities()->contains($city)) {
            $pos = $this->collCities->search($city);
            $this->collCities->remove($pos);
            if (null === $this->citiesScheduledForDeletion) {
                $this->citiesScheduledForDeletion = clone $this->collCities;
                $this->citiesScheduledForDeletion->clear();
            }
            $this->citiesScheduledForDeletion[]= $city;
            $city->setMap(null);
        }

        return $this;
    }

    /**
     * Clears out the collCityConnections collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCityConnections()
     */
    public function clearCityConnections()
    {
        $this->collCityConnections = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCityConnections collection loaded partially.
     */
    public function resetPartialCityConnections($v = true)
    {
        $this->collCityConnectionsPartial = $v;
    }

    /**
     * Initializes the collCityConnections collection.
     *
     * By default this just sets the collCityConnections collection to an empty array (like clearcollCityConnections());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCityConnections($overrideExisting = true)
    {
        if (null !== $this->collCityConnections && !$overrideExisting) {
            return;
        }
        $this->collCityConnections = new ObjectCollection();
        $this->collCityConnections->setModel('\CityConnection');
    }

    /**
     * Gets an array of ChildCityConnection objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMap is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCityConnection[] List of ChildCityConnection objects
     * @throws PropelException
     */
    public function getCityConnections(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCityConnectionsPartial && !$this->isNew();
        if (null === $this->collCityConnections || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCityConnections) {
                // return empty collection
                $this->initCityConnections();
            } else {
                $collCityConnections = ChildCityConnectionQuery::create(null, $criteria)
                    ->filterByMap($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCityConnectionsPartial && count($collCityConnections)) {
                        $this->initCityConnections(false);

                        foreach ($collCityConnections as $obj) {
                            if (false == $this->collCityConnections->contains($obj)) {
                                $this->collCityConnections->append($obj);
                            }
                        }

                        $this->collCityConnectionsPartial = true;
                    }

                    return $collCityConnections;
                }

                if ($partial && $this->collCityConnections) {
                    foreach ($this->collCityConnections as $obj) {
                        if ($obj->isNew()) {
                            $collCityConnections[] = $obj;
                        }
                    }
                }

                $this->collCityConnections = $collCityConnections;
                $this->collCityConnectionsPartial = false;
            }
        }

        return $this->collCityConnections;
    }

    /**
     * Sets a collection of ChildCityConnection objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $cityConnections A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMap The current object (for fluent API support)
     */
    public function setCityConnections(Collection $cityConnections, ConnectionInterface $con = null)
    {
        /** @var ChildCityConnection[] $cityConnectionsToDelete */
        $cityConnectionsToDelete = $this->getCityConnections(new Criteria(), $con)->diff($cityConnections);


        $this->cityConnectionsScheduledForDeletion = $cityConnectionsToDelete;

        foreach ($cityConnectionsToDelete as $cityConnectionRemoved) {
            $cityConnectionRemoved->setMap(null);
        }

        $this->collCityConnections = null;
        foreach ($cityConnections as $cityConnection) {
            $this->addCityConnection($cityConnection);
        }

        $this->collCityConnections = $cityConnections;
        $this->collCityConnectionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CityConnection objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CityConnection objects.
     * @throws PropelException
     */
    public function countCityConnections(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCityConnectionsPartial && !$this->isNew();
        if (null === $this->collCityConnections || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCityConnections) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCityConnections());
            }

            $query = ChildCityConnectionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMap($this)
                ->count($con);
        }

        return count($this->collCityConnections);
    }

    /**
     * Method called to associate a ChildCityConnection object to this object
     * through the ChildCityConnection foreign key attribute.
     *
     * @param  ChildCityConnection $l ChildCityConnection
     * @return $this|\Map The current object (for fluent API support)
     */
    public function addCityConnection(ChildCityConnection $l)
    {
        if ($this->collCityConnections === null) {
            $this->initCityConnections();
            $this->collCityConnectionsPartial = true;
        }

        if (!$this->collCityConnections->contains($l)) {
            $this->doAddCityConnection($l);
        }

        return $this;
    }

    /**
     * @param ChildCityConnection $cityConnection The ChildCityConnection object to add.
     */
    protected function doAddCityConnection(ChildCityConnection $cityConnection)
    {
        $this->collCityConnections[]= $cityConnection;
        $cityConnection->setMap($this);
    }

    /**
     * @param  ChildCityConnection $cityConnection The ChildCityConnection object to remove.
     * @return $this|ChildMap The current object (for fluent API support)
     */
    public function removeCityConnection(ChildCityConnection $cityConnection)
    {
        if ($this->getCityConnections()->contains($cityConnection)) {
            $pos = $this->collCityConnections->search($cityConnection);
            $this->collCityConnections->remove($pos);
            if (null === $this->cityConnectionsScheduledForDeletion) {
                $this->cityConnectionsScheduledForDeletion = clone $this->collCityConnections;
                $this->cityConnectionsScheduledForDeletion->clear();
            }
            $this->cityConnectionsScheduledForDeletion[]= $cityConnection;
            $cityConnection->setMap(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Map is new, it will return
     * an empty collection; or if this Map has previously
     * been saved, it will retrieve related CityConnections from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Map.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCityConnection[] List of ChildCityConnection objects
     */
    public function getCityConnectionsJoinFromCity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCityConnectionQuery::create(null, $criteria);
        $query->joinWith('FromCity', $joinBehavior);

        return $this->getCityConnections($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Map is new, it will return
     * an empty collection; or if this Map has previously
     * been saved, it will retrieve related CityConnections from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Map.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCityConnection[] List of ChildCityConnection objects
     */
    public function getCityConnectionsJoinToCity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCityConnectionQuery::create(null, $criteria);
        $query->joinWith('ToCity', $joinBehavior);

        return $this->getCityConnections($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
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
            if ($this->collGames) {
                foreach ($this->collGames as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCities) {
                foreach ($this->collCities as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCityConnections) {
                foreach ($this->collCityConnections as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collGames = null;
        $this->collCities = null;
        $this->collCityConnections = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MapTableMap::DEFAULT_STRING_FORMAT);
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
