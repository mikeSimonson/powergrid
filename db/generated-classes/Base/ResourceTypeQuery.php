<?php

namespace Base;

use \ResourceType as ChildResourceType;
use \ResourceTypeQuery as ChildResourceTypeQuery;
use \Exception;
use \PDO;
use Map\ResourceTypeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'resource_type' table.
 *
 *
 *
 * @method     ChildResourceTypeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildResourceTypeQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildResourceTypeQuery groupById() Group by the id column
 * @method     ChildResourceTypeQuery groupByName() Group by the name column
 *
 * @method     ChildResourceTypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildResourceTypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildResourceTypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildResourceTypeQuery leftJoinCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the Card relation
 * @method     ChildResourceTypeQuery rightJoinCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Card relation
 * @method     ChildResourceTypeQuery innerJoinCard($relationAlias = null) Adds a INNER JOIN clause to the query using the Card relation
 *
 * @method     ChildResourceTypeQuery leftJoinResourceStore($relationAlias = null) Adds a LEFT JOIN clause to the query using the ResourceStore relation
 * @method     ChildResourceTypeQuery rightJoinResourceStore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ResourceStore relation
 * @method     ChildResourceTypeQuery innerJoinResourceStore($relationAlias = null) Adds a INNER JOIN clause to the query using the ResourceStore relation
 *
 * @method     ChildResourceTypeQuery leftJoinPlayerResource($relationAlias = null) Adds a LEFT JOIN clause to the query using the PlayerResource relation
 * @method     ChildResourceTypeQuery rightJoinPlayerResource($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PlayerResource relation
 * @method     ChildResourceTypeQuery innerJoinPlayerResource($relationAlias = null) Adds a INNER JOIN clause to the query using the PlayerResource relation
 *
 * @method     \CardQuery|\ResourceStoreQuery|\PlayerResourceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildResourceType findOne(ConnectionInterface $con = null) Return the first ChildResourceType matching the query
 * @method     ChildResourceType findOneOrCreate(ConnectionInterface $con = null) Return the first ChildResourceType matching the query, or a new ChildResourceType object populated from the query conditions when no match is found
 *
 * @method     ChildResourceType findOneById(int $id) Return the first ChildResourceType filtered by the id column
 * @method     ChildResourceType findOneByName(string $name) Return the first ChildResourceType filtered by the name column *

 * @method     ChildResourceType requirePk($key, ConnectionInterface $con = null) Return the ChildResourceType by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResourceType requireOne(ConnectionInterface $con = null) Return the first ChildResourceType matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildResourceType requireOneById(int $id) Return the first ChildResourceType filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResourceType requireOneByName(string $name) Return the first ChildResourceType filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildResourceType[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildResourceType objects based on current ModelCriteria
 * @method     ChildResourceType[]|ObjectCollection findById(int $id) Return ChildResourceType objects filtered by the id column
 * @method     ChildResourceType[]|ObjectCollection findByName(string $name) Return ChildResourceType objects filtered by the name column
 * @method     ChildResourceType[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ResourceTypeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ResourceTypeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'powergrid', $modelName = '\\ResourceType', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildResourceTypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildResourceTypeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildResourceTypeQuery) {
            return $criteria;
        }
        $query = new ChildResourceTypeQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildResourceType|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ResourceTypeTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ResourceTypeTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildResourceType A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name FROM resource_type WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildResourceType $obj */
            $obj = new ChildResourceType();
            $obj->hydrate($row);
            ResourceTypeTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildResourceType|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildResourceTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ResourceTypeTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildResourceTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ResourceTypeTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildResourceTypeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ResourceTypeTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ResourceTypeTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResourceTypeTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildResourceTypeQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ResourceTypeTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \Card object
     *
     * @param \Card|ObjectCollection $card the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildResourceTypeQuery The current query, for fluid interface
     */
    public function filterByCard($card, $comparison = null)
    {
        if ($card instanceof \Card) {
            return $this
                ->addUsingAlias(ResourceTypeTableMap::COL_ID, $card->getResourceTypeId(), $comparison);
        } elseif ($card instanceof ObjectCollection) {
            return $this
                ->useCardQuery()
                ->filterByPrimaryKeys($card->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCard() only accepts arguments of type \Card or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Card relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildResourceTypeQuery The current query, for fluid interface
     */
    public function joinCard($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Card');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Card');
        }

        return $this;
    }

    /**
     * Use the Card relation Card object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CardQuery A secondary query class using the current class as primary query
     */
    public function useCardQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Card', '\CardQuery');
    }

    /**
     * Filter the query by a related \ResourceStore object
     *
     * @param \ResourceStore|ObjectCollection $resourceStore the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildResourceTypeQuery The current query, for fluid interface
     */
    public function filterByResourceStore($resourceStore, $comparison = null)
    {
        if ($resourceStore instanceof \ResourceStore) {
            return $this
                ->addUsingAlias(ResourceTypeTableMap::COL_ID, $resourceStore->getResourceTypeId(), $comparison);
        } elseif ($resourceStore instanceof ObjectCollection) {
            return $this
                ->useResourceStoreQuery()
                ->filterByPrimaryKeys($resourceStore->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByResourceStore() only accepts arguments of type \ResourceStore or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ResourceStore relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildResourceTypeQuery The current query, for fluid interface
     */
    public function joinResourceStore($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ResourceStore');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ResourceStore');
        }

        return $this;
    }

    /**
     * Use the ResourceStore relation ResourceStore object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ResourceStoreQuery A secondary query class using the current class as primary query
     */
    public function useResourceStoreQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinResourceStore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ResourceStore', '\ResourceStoreQuery');
    }

    /**
     * Filter the query by a related \PlayerResource object
     *
     * @param \PlayerResource|ObjectCollection $playerResource the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildResourceTypeQuery The current query, for fluid interface
     */
    public function filterByPlayerResource($playerResource, $comparison = null)
    {
        if ($playerResource instanceof \PlayerResource) {
            return $this
                ->addUsingAlias(ResourceTypeTableMap::COL_ID, $playerResource->getResourceTypeId(), $comparison);
        } elseif ($playerResource instanceof ObjectCollection) {
            return $this
                ->usePlayerResourceQuery()
                ->filterByPrimaryKeys($playerResource->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPlayerResource() only accepts arguments of type \PlayerResource or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PlayerResource relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildResourceTypeQuery The current query, for fluid interface
     */
    public function joinPlayerResource($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PlayerResource');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PlayerResource');
        }

        return $this;
    }

    /**
     * Use the PlayerResource relation PlayerResource object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PlayerResourceQuery A secondary query class using the current class as primary query
     */
    public function usePlayerResourceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPlayerResource($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PlayerResource', '\PlayerResourceQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildResourceType $resourceType Object to remove from the list of results
     *
     * @return $this|ChildResourceTypeQuery The current query, for fluid interface
     */
    public function prune($resourceType = null)
    {
        if ($resourceType) {
            $this->addUsingAlias(ResourceTypeTableMap::COL_ID, $resourceType->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the resource_type table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ResourceTypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ResourceTypeTableMap::clearInstancePool();
            ResourceTypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ResourceTypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ResourceTypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ResourceTypeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ResourceTypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ResourceTypeQuery
