<?php

namespace Base;

use \Game as ChildGame;
use \GameQuery as ChildGameQuery;
use \Player as ChildPlayer;
use \PlayerQuery as ChildPlayerQuery;
use \User as ChildUser;
use \UserGroupAuthorization as ChildUserGroupAuthorization;
use \UserGroupAuthorizationQuery as ChildUserGroupAuthorizationQuery;
use \UserQuery as ChildUserQuery;
use \UserToken as ChildUserToken;
use \UserTokenQuery as ChildUserTokenQuery;
use \Exception;
use \PDO;
use Map\UserTableMap;
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
 * Base class that represents a row from the 'user' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class User implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UserTableMap';


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
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the username field.
     * @var        string
     */
    protected $username;

    /**
     * The value for the password field.
     * @var        string
     */
    protected $password;

    /**
     * @var        ObjectCollection|ChildUserGroupAuthorization[] Collection to store aggregation of ChildUserGroupAuthorization objects.
     */
    protected $collAuthorizationGroups;
    protected $collAuthorizationGroupsPartial;

    /**
     * @var        ObjectCollection|ChildUserToken[] Collection to store aggregation of ChildUserToken objects.
     */
    protected $collUserTokens;
    protected $collUserTokensPartial;

    /**
     * @var        ObjectCollection|ChildPlayer[] Collection to store aggregation of ChildPlayer objects.
     */
    protected $collPlayers;
    protected $collPlayersPartial;

    /**
     * @var        ObjectCollection|ChildGame[] Collection to store aggregation of ChildGame objects.
     */
    protected $collGames;
    protected $collGamesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserGroupAuthorization[]
     */
    protected $authorizationGroupsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserToken[]
     */
    protected $userTokensScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlayer[]
     */
    protected $playersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGame[]
     */
    protected $gamesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\User object.
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
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|User The current object, for fluid interface
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
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UserTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[UserTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UserTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[UserTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [password] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UserTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\User'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAuthorizationGroups = null;

            $this->collUserTokens = null;

            $this->collPlayers = null;

            $this->collGames = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
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
                UserTableMap::addInstanceToPool($this);
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

            if ($this->authorizationGroupsScheduledForDeletion !== null) {
                if (!$this->authorizationGroupsScheduledForDeletion->isEmpty()) {
                    foreach ($this->authorizationGroupsScheduledForDeletion as $authorizationGroup) {
                        // need to save related object because we set the relation to null
                        $authorizationGroup->save($con);
                    }
                    $this->authorizationGroupsScheduledForDeletion = null;
                }
            }

            if ($this->collAuthorizationGroups !== null) {
                foreach ($this->collAuthorizationGroups as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userTokensScheduledForDeletion !== null) {
                if (!$this->userTokensScheduledForDeletion->isEmpty()) {
                    \UserTokenQuery::create()
                        ->filterByPrimaryKeys($this->userTokensScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userTokensScheduledForDeletion = null;
                }
            }

            if ($this->collUserTokens !== null) {
                foreach ($this->collUserTokens as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[UserTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UserTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }

        $sql = sprintf(
            'INSERT INTO user (%s) VALUES (%s)',
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
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'username':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'password':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
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
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getEmail();
                break;
            case 3:
                return $this->getUsername();
                break;
            case 4:
                return $this->getPassword();
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

        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getEmail(),
            $keys[3] => $this->getUsername(),
            $keys[4] => $this->getPassword(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAuthorizationGroups) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userGroupAuthorizations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_group_authorizations';
                        break;
                    default:
                        $key = 'UserGroupAuthorizations';
                }

                $result[$key] = $this->collAuthorizationGroups->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserTokens) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userTokens';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_tokens';
                        break;
                    default:
                        $key = 'UserTokens';
                }

                $result[$key] = $this->collUserTokens->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\User
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\User
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
                $this->setEmail($value);
                break;
            case 3:
                $this->setUsername($value);
                break;
            case 4:
                $this->setPassword($value);
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
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEmail($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setUsername($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPassword($arr[$keys[4]]);
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
     * @return $this|\User The current object, for fluid interface
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
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $criteria->add(UserTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UserTableMap::COL_NAME)) {
            $criteria->add(UserTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $criteria->add(UserTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $criteria->add(UserTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $criteria->add(UserTableMap::COL_PASSWORD, $this->password);
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
        $criteria = ChildUserQuery::create();
        $criteria->add(UserTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPassword($this->getPassword());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAuthorizationGroups() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAuthorizationGroup($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserTokens() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserToken($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPlayers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlayer($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGames() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGame($relObj->copy($deepCopy));
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
     * @return \User Clone of current object.
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
        if ('AuthorizationGroup' == $relationName) {
            return $this->initAuthorizationGroups();
        }
        if ('UserToken' == $relationName) {
            return $this->initUserTokens();
        }
        if ('Player' == $relationName) {
            return $this->initPlayers();
        }
        if ('Game' == $relationName) {
            return $this->initGames();
        }
    }

    /**
     * Clears out the collAuthorizationGroups collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAuthorizationGroups()
     */
    public function clearAuthorizationGroups()
    {
        $this->collAuthorizationGroups = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAuthorizationGroups collection loaded partially.
     */
    public function resetPartialAuthorizationGroups($v = true)
    {
        $this->collAuthorizationGroupsPartial = $v;
    }

    /**
     * Initializes the collAuthorizationGroups collection.
     *
     * By default this just sets the collAuthorizationGroups collection to an empty array (like clearcollAuthorizationGroups());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAuthorizationGroups($overrideExisting = true)
    {
        if (null !== $this->collAuthorizationGroups && !$overrideExisting) {
            return;
        }
        $this->collAuthorizationGroups = new ObjectCollection();
        $this->collAuthorizationGroups->setModel('\UserGroupAuthorization');
    }

    /**
     * Gets an array of ChildUserGroupAuthorization objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserGroupAuthorization[] List of ChildUserGroupAuthorization objects
     * @throws PropelException
     */
    public function getAuthorizationGroups(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAuthorizationGroupsPartial && !$this->isNew();
        if (null === $this->collAuthorizationGroups || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAuthorizationGroups) {
                // return empty collection
                $this->initAuthorizationGroups();
            } else {
                $collAuthorizationGroups = ChildUserGroupAuthorizationQuery::create(null, $criteria)
                    ->filterByGroupUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAuthorizationGroupsPartial && count($collAuthorizationGroups)) {
                        $this->initAuthorizationGroups(false);

                        foreach ($collAuthorizationGroups as $obj) {
                            if (false == $this->collAuthorizationGroups->contains($obj)) {
                                $this->collAuthorizationGroups->append($obj);
                            }
                        }

                        $this->collAuthorizationGroupsPartial = true;
                    }

                    return $collAuthorizationGroups;
                }

                if ($partial && $this->collAuthorizationGroups) {
                    foreach ($this->collAuthorizationGroups as $obj) {
                        if ($obj->isNew()) {
                            $collAuthorizationGroups[] = $obj;
                        }
                    }
                }

                $this->collAuthorizationGroups = $collAuthorizationGroups;
                $this->collAuthorizationGroupsPartial = false;
            }
        }

        return $this->collAuthorizationGroups;
    }

    /**
     * Sets a collection of ChildUserGroupAuthorization objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $authorizationGroups A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setAuthorizationGroups(Collection $authorizationGroups, ConnectionInterface $con = null)
    {
        /** @var ChildUserGroupAuthorization[] $authorizationGroupsToDelete */
        $authorizationGroupsToDelete = $this->getAuthorizationGroups(new Criteria(), $con)->diff($authorizationGroups);


        $this->authorizationGroupsScheduledForDeletion = $authorizationGroupsToDelete;

        foreach ($authorizationGroupsToDelete as $authorizationGroupRemoved) {
            $authorizationGroupRemoved->setGroupUser(null);
        }

        $this->collAuthorizationGroups = null;
        foreach ($authorizationGroups as $authorizationGroup) {
            $this->addAuthorizationGroup($authorizationGroup);
        }

        $this->collAuthorizationGroups = $authorizationGroups;
        $this->collAuthorizationGroupsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserGroupAuthorization objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserGroupAuthorization objects.
     * @throws PropelException
     */
    public function countAuthorizationGroups(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAuthorizationGroupsPartial && !$this->isNew();
        if (null === $this->collAuthorizationGroups || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAuthorizationGroups) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAuthorizationGroups());
            }

            $query = ChildUserGroupAuthorizationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGroupUser($this)
                ->count($con);
        }

        return count($this->collAuthorizationGroups);
    }

    /**
     * Method called to associate a ChildUserGroupAuthorization object to this object
     * through the ChildUserGroupAuthorization foreign key attribute.
     *
     * @param  ChildUserGroupAuthorization $l ChildUserGroupAuthorization
     * @return $this|\User The current object (for fluent API support)
     */
    public function addAuthorizationGroup(ChildUserGroupAuthorization $l)
    {
        if ($this->collAuthorizationGroups === null) {
            $this->initAuthorizationGroups();
            $this->collAuthorizationGroupsPartial = true;
        }

        if (!$this->collAuthorizationGroups->contains($l)) {
            $this->doAddAuthorizationGroup($l);
        }

        return $this;
    }

    /**
     * @param ChildUserGroupAuthorization $authorizationGroup The ChildUserGroupAuthorization object to add.
     */
    protected function doAddAuthorizationGroup(ChildUserGroupAuthorization $authorizationGroup)
    {
        $this->collAuthorizationGroups[]= $authorizationGroup;
        $authorizationGroup->setGroupUser($this);
    }

    /**
     * @param  ChildUserGroupAuthorization $authorizationGroup The ChildUserGroupAuthorization object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeAuthorizationGroup(ChildUserGroupAuthorization $authorizationGroup)
    {
        if ($this->getAuthorizationGroups()->contains($authorizationGroup)) {
            $pos = $this->collAuthorizationGroups->search($authorizationGroup);
            $this->collAuthorizationGroups->remove($pos);
            if (null === $this->authorizationGroupsScheduledForDeletion) {
                $this->authorizationGroupsScheduledForDeletion = clone $this->collAuthorizationGroups;
                $this->authorizationGroupsScheduledForDeletion->clear();
            }
            $this->authorizationGroupsScheduledForDeletion[]= $authorizationGroup;
            $authorizationGroup->setGroupUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collUserTokens collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserTokens()
     */
    public function clearUserTokens()
    {
        $this->collUserTokens = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserTokens collection loaded partially.
     */
    public function resetPartialUserTokens($v = true)
    {
        $this->collUserTokensPartial = $v;
    }

    /**
     * Initializes the collUserTokens collection.
     *
     * By default this just sets the collUserTokens collection to an empty array (like clearcollUserTokens());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserTokens($overrideExisting = true)
    {
        if (null !== $this->collUserTokens && !$overrideExisting) {
            return;
        }
        $this->collUserTokens = new ObjectCollection();
        $this->collUserTokens->setModel('\UserToken');
    }

    /**
     * Gets an array of ChildUserToken objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserToken[] List of ChildUserToken objects
     * @throws PropelException
     */
    public function getUserTokens(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserTokensPartial && !$this->isNew();
        if (null === $this->collUserTokens || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserTokens) {
                // return empty collection
                $this->initUserTokens();
            } else {
                $collUserTokens = ChildUserTokenQuery::create(null, $criteria)
                    ->filterByTokenUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserTokensPartial && count($collUserTokens)) {
                        $this->initUserTokens(false);

                        foreach ($collUserTokens as $obj) {
                            if (false == $this->collUserTokens->contains($obj)) {
                                $this->collUserTokens->append($obj);
                            }
                        }

                        $this->collUserTokensPartial = true;
                    }

                    return $collUserTokens;
                }

                if ($partial && $this->collUserTokens) {
                    foreach ($this->collUserTokens as $obj) {
                        if ($obj->isNew()) {
                            $collUserTokens[] = $obj;
                        }
                    }
                }

                $this->collUserTokens = $collUserTokens;
                $this->collUserTokensPartial = false;
            }
        }

        return $this->collUserTokens;
    }

    /**
     * Sets a collection of ChildUserToken objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userTokens A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setUserTokens(Collection $userTokens, ConnectionInterface $con = null)
    {
        /** @var ChildUserToken[] $userTokensToDelete */
        $userTokensToDelete = $this->getUserTokens(new Criteria(), $con)->diff($userTokens);


        $this->userTokensScheduledForDeletion = $userTokensToDelete;

        foreach ($userTokensToDelete as $userTokenRemoved) {
            $userTokenRemoved->setTokenUser(null);
        }

        $this->collUserTokens = null;
        foreach ($userTokens as $userToken) {
            $this->addUserToken($userToken);
        }

        $this->collUserTokens = $userTokens;
        $this->collUserTokensPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserToken objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserToken objects.
     * @throws PropelException
     */
    public function countUserTokens(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserTokensPartial && !$this->isNew();
        if (null === $this->collUserTokens || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserTokens) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserTokens());
            }

            $query = ChildUserTokenQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTokenUser($this)
                ->count($con);
        }

        return count($this->collUserTokens);
    }

    /**
     * Method called to associate a ChildUserToken object to this object
     * through the ChildUserToken foreign key attribute.
     *
     * @param  ChildUserToken $l ChildUserToken
     * @return $this|\User The current object (for fluent API support)
     */
    public function addUserToken(ChildUserToken $l)
    {
        if ($this->collUserTokens === null) {
            $this->initUserTokens();
            $this->collUserTokensPartial = true;
        }

        if (!$this->collUserTokens->contains($l)) {
            $this->doAddUserToken($l);
        }

        return $this;
    }

    /**
     * @param ChildUserToken $userToken The ChildUserToken object to add.
     */
    protected function doAddUserToken(ChildUserToken $userToken)
    {
        $this->collUserTokens[]= $userToken;
        $userToken->setTokenUser($this);
    }

    /**
     * @param  ChildUserToken $userToken The ChildUserToken object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeUserToken(ChildUserToken $userToken)
    {
        if ($this->getUserTokens()->contains($userToken)) {
            $pos = $this->collUserTokens->search($userToken);
            $this->collUserTokens->remove($pos);
            if (null === $this->userTokensScheduledForDeletion) {
                $this->userTokensScheduledForDeletion = clone $this->collUserTokens;
                $this->userTokensScheduledForDeletion->clear();
            }
            $this->userTokensScheduledForDeletion[]= clone $userToken;
            $userToken->setTokenUser(null);
        }

        return $this;
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
     * If this ChildUser is new, it will return
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
                    ->filterByPlayerUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setPlayers(Collection $players, ConnectionInterface $con = null)
    {
        /** @var ChildPlayer[] $playersToDelete */
        $playersToDelete = $this->getPlayers(new Criteria(), $con)->diff($players);


        $this->playersScheduledForDeletion = $playersToDelete;

        foreach ($playersToDelete as $playerRemoved) {
            $playerRemoved->setPlayerUser(null);
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
                ->filterByPlayerUser($this)
                ->count($con);
        }

        return count($this->collPlayers);
    }

    /**
     * Method called to associate a ChildPlayer object to this object
     * through the ChildPlayer foreign key attribute.
     *
     * @param  ChildPlayer $l ChildPlayer
     * @return $this|\User The current object (for fluent API support)
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
        $player->setPlayerUser($this);
    }

    /**
     * @param  ChildPlayer $player The ChildPlayer object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $player->setPlayerUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Players from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPlayer[] List of ChildPlayer objects
     */
    public function getPlayersJoinCurrentGame(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPlayerQuery::create(null, $criteria);
        $query->joinWith('CurrentGame', $joinBehavior);

        return $this->getPlayers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Players from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
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
     * If this ChildUser is new, it will return
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
                    ->filterByOwnerUser($this)
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
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setGames(Collection $games, ConnectionInterface $con = null)
    {
        /** @var ChildGame[] $gamesToDelete */
        $gamesToDelete = $this->getGames(new Criteria(), $con)->diff($games);


        $this->gamesScheduledForDeletion = $gamesToDelete;

        foreach ($gamesToDelete as $gameRemoved) {
            $gameRemoved->setOwnerUser(null);
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
                ->filterByOwnerUser($this)
                ->count($con);
        }

        return count($this->collGames);
    }

    /**
     * Method called to associate a ChildGame object to this object
     * through the ChildGame foreign key attribute.
     *
     * @param  ChildGame $l ChildGame
     * @return $this|\User The current object (for fluent API support)
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
        $game->setOwnerUser($this);
    }

    /**
     * @param  ChildGame $game The ChildGame object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
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
            $game->setOwnerUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Games from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
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
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Games from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGame[] List of ChildGame objects
     */
    public function getGamesJoinMap(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGameQuery::create(null, $criteria);
        $query->joinWith('Map', $joinBehavior);

        return $this->getGames($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Games from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->email = null;
        $this->username = null;
        $this->password = null;
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
            if ($this->collAuthorizationGroups) {
                foreach ($this->collAuthorizationGroups as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserTokens) {
                foreach ($this->collUserTokens as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPlayers) {
                foreach ($this->collPlayers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGames) {
                foreach ($this->collGames as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAuthorizationGroups = null;
        $this->collUserTokens = null;
        $this->collPlayers = null;
        $this->collGames = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
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
